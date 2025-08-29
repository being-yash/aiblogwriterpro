<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerifyShopifyRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip verification for the install and callback routes
        if ($request->routeIs('shopify.install') || $request->routeIs('shopify.callback')) {
            return $next($request);
        }

        // Validate the HMAC to ensure the request is from Shopify
        if (!$this->verifyHmac($request->query())) {
            Log::error("HMAC verification failed for request", ['query' => $request->query()]);
            return response('HMAC verification failed.', 401);
        }
        
        // Find the shop and log the user in
        $shopDomain = $request->query('shop');
        if ($shopDomain) {
            $shop = \App\Models\Shop::where('shopify_domain', $shopDomain)->first();
            if ($shop) {
                // You can manually create a session or use a simple auth mechanism
                session([
                    'shopify_domain' => $shop->shopify_domain,
                    'shopify_token' => $shop->shopify_token,
                ]);
            }
        }

        return $next($request);
    }

    /**
     * Verifies the HMAC signature.
     *
     * @param array $query
     * @return bool
     */
    private function verifyHmac(array $query): bool
    {
        $hmac = $query['hmac'] ?? '';
        unset($query['hmac']);

        $pairs = [];
        foreach ($query as $key => $value) {
            $pairs[] = str_replace(['&', '%'], ['%26', '%25'], $key) . '=' . str_replace(['&', '%'], ['%26', '%25'], $value);
        }
        sort($pairs);
        $queryNormalized = implode('&', $pairs);

        $calculatedHmac = hash_hmac('sha256', $queryNormalized, env('SHOPIFY_API_SECRET'));

        return hash_equals($calculatedHmac, $hmac);
    }
}