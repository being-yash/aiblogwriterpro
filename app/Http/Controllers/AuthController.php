<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Shop;

class AuthController extends Controller
{
    /**
     * Redirects to the Shopify authentication page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function install(Request $request)
    {
        // Get the shop domain from the URL query
        $shop = $request->query('shop');

        if (!$shop) {
            return response('Missing shop parameter', 400);
        }

        // Generate the nonce and store it in the session
        session(['shopify_nonce' => bin2hex(random_bytes(10))]);

        // Build the authorization URL
        $scopes = env('SHOPIFY_API_SCOPES');
        $redirectUri = env('SHOPIFY_APP_URL') . '/auth/callback';
        $authUrl = "https://{$shop}/admin/oauth/authorize?client_id=" . env('SHOPIFY_API_KEY') .
                   "&scope={$scopes}&redirect_uri={$redirectUri}&state=" . session('shopify_nonce') .
                   "&grant_options[]=";

        return redirect()->away($authUrl);
    }

    /**
     * Handles the callback from Shopify after a successful installation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(Request $request)
    {
        // 1. Validate the incoming request and HMAC
        if (!$request->has(['hmac', 'code', 'shop', 'state'])) {
            return response('Invalid callback parameters', 400);
        }

        // Verify the nonce to prevent CSRF attacks
        if ($request->input('state') !== session('shopify_nonce')) {
            Log::error("Shopify callback state mismatch", ['request_state' => $request->input('state'), 'session_state' => session('shopify_nonce')]);
            return response('State mismatch', 403);
        }

        // 2. Exchange the authorization code for an access token
        $shop = $request->query('shop');
        $code = $request->query('code');

        try {
            $response = Http::post("https://{$shop}/admin/oauth/access_token", [
                'client_id' => env('SHOPIFY_API_KEY'),
                'client_secret' => env('SHOPIFY_API_SECRET'),
                'code' => $code,
            ]);

            $tokenData = $response->json();
            $accessToken = $tokenData['access_token'];

            // 3. Store the shop and access token in the database
            $shopModel = Shop::firstOrNew(['shopify_domain' => $shop]);
            $shopModel->shopify_token = $accessToken;
            $shopModel->is_online = true; // Use a dedicated column if needed for offline access
            $shopModel->save();

            // Store the session data in the Laravel session for immediate use
            session([
                'shopify_domain' => $shop,
                'shopify_token' => $accessToken,
            ]);

            // 4. Redirect to the main app page
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            Log::error("Shopify callback error", ['error' => $e->getMessage()]);
            return response('Failed to authenticate with Shopify: ' . $e->getMessage(), 500);
        }
    }
}