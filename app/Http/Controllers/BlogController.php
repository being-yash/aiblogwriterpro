<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Shop; // Make sure to use the new Shop model
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    /**
     * Generate a blog post using the Gemini API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateBlog(Request $request)
    {
        // 1. Validate the incoming request data
        $request->validate([
            'topic' => 'required|string',
            'keywords' => 'nullable|string',
            'length' => 'required|string',
            'tone' => 'required|string',
        ]);

        $prompt = "Write a " . $request->input('length') . ", " . $request->input('tone') . " blog post about \"" . $request->input('topic') . "\". " .
                  "Make sure to include the following keywords: " . $request->input('keywords') . ". Format the response as a title followed by the content, separated by a newline.";

        // 2. Call the Gemini API
        try {
            $geminiApiKey = env('GEMINI_API_KEY'); // Store your API key in the .env file
            $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-05-20:generateContent?key={$geminiApiKey}", [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ]
            ]);

            $responseData = $response->json();
            $fullText = $responseData['candidates'][0]['content']['parts'][0]['text'];

            // Simple logic to split title and content
            $lines = explode("\n", $fullText, 2);
            $title = trim($lines[0], "# \t\n\r\0\x0B"); // Clean up markdown hashes from the title
            $content = isset($lines[1]) ? trim($lines[1]) : '';

            return response()->json([
                'success' => true,
                'title' => $title,
                'content' => $content
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to generate blog content: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Publish a blog post to Shopify.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function publishBlog(Request $request)
    {
        // 1. Validate the request
        $request->validate([
            'title' => 'required|string',
            'body_html' => 'required|string',
            'published' => 'required|boolean',
        ]);

        // 2. Get the authenticated shop from the session
        $shopDomain = session('shopify_domain');
        $accessToken = session('shopify_token');

        if (!$shopDomain || !$accessToken) {
            return response()->json([
                'success' => false,
                'error' => 'Shopify session not found. Please re-authenticate.'
            ], 401);
        }

        // 3. Set the Shopify API context manually
        \Shopify\Context::initialize(
            env('SHOPIFY_API_KEY'),
            env('SHOPIFY_API_SECRET'),
            env('SHOPIFY_API_SCOPES'),
            $shopDomain, // The host of the shop
            $accessToken // The access token for the shop
        );

        try {
            // Get the ID of the blog you want to post to.
            // You can fetch this dynamically or hardcode it if the app is for a single blog.
            $blogs = \Shopify\Rest\Admin2024_04\Blog::all($accessToken);
            if (empty($blogs)) {
                return response()->json([
                    'success' => false,
                    'error' => 'No blogs found on this Shopify store.'
                ], 404);
            }
            $blogId = $blogs[0]->id; // Use the first blog found

            // 4. Create the article using the Shopify API
            $article = new \Shopify\Rest\Admin2024_04\Article($accessToken);
            $article->blog_id = $blogId;
            $article->title = $request->input('title');
            $article->body_html = $request->input('body_html');
            $article->published = $request->input('published');
            // Assuming we have user info from auth, though this is a simplified custom flow
            $article->author = 'AI Blog Generator'; 

            if ($article->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Blog post published successfully!',
                    'article_id' => $article->id,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Shopify API error: Failed to save article.'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to publish blog post: ' . $e->getMessage()
            ], 500);
        }
    }
}