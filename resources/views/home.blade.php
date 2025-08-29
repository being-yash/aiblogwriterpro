<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Essential AI Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        .prose img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-4 sm:p-8">

    <!-- Main Container -->
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl mx-auto overflow-hidden">
        
        <!-- Header Section -->
        <div class="p-6 sm:p-8 bg-purple-600 text-white flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <i class="fas fa-magic text-2xl"></i>
                <h1 class="text-3xl font-bold">Essential AI Blog</h1>
            </div>
        </div>

        <!-- App Content -->
        <div class="p-6 sm:p-8">
            <!-- Navigation buttons to switch between views -->
            <div class="flex justify-end space-x-2 mb-6">
                <button id="show-list-btn" class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300">
                    <i class="fas fa-list-ul"></i> All Blog Posts
                </button>
                <button id="show-new-btn" class="bg-purple-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-700 transition duration-300">
                    <i class="fas fa-plus"></i> New Blog Post
                </button>
            </div>

            <!-- Blog Posts List View -->
            <div id="list-view" class="view">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Blog posts</h2>
                    <button id="generate-multiple-btn" class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300">
                        Generate multiple blog posts
                    </button>
                </div>
                <!-- This section would be dynamically populated with generated blog posts -->
                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4 shadow-sm border border-gray-200 flex justify-between items-center">
                        <div>
                            <p class="text-gray-800 font-semibold">Elevate Your Bridal Look with Zevar's Exquisite Kundan Jewelry Collection</p>
                            <span class="text-xs text-gray-500">Last edited: 19 minutes ago</span>
                        </div>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Hidden</span>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 shadow-sm border border-gray-200 flex justify-between items-center">
                        <div>
                            <p class="text-gray-800 font-semibold">Generating</p>
                            <span class="text-xs text-gray-500">Last edited: in a few seconds</span>
                        </div>
                        <i class="fas fa-sync-alt animate-spin text-purple-600"></i>
                    </div>
                </div>
            </div>

            <!-- New/Edit Blog Post View -->
            <div id="new-edit-view" class="view hidden">
                <div class="flex justify-between items-center mb-6">
                    <button id="back-to-list-btn" class="text-gray-600 hover:text-gray-800 transition duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back
                    </button>
                    <h2 class="text-2xl font-bold text-gray-800">Blog post</h2>
                    <button class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300">
                        Preview on Shopify
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Left Sidebar for Settings -->
                    <div class="md:col-span-1 bg-gray-50 rounded-lg p-6 border border-gray-200 space-y-4">
                        <h3 class="font-bold text-lg">Settings</h3>
                        <!-- Visibility -->
                        <div class="space-y-2">
                            <label class="block text-gray-700 font-semibold">Visibility</label>
                            <div class="flex items-center space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio" name="visibility" value="visible" checked>
                                    <span class="ml-2 text-gray-700">Visible</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio" name="visibility" value="hidden">
                                    <span class="ml-2 text-gray-700">Hidden</span>
                                </label>
                            </div>
                        </div>

                        <!-- Language -->
                        <div class="space-y-2">
                            <label for="language" class="block text-gray-700 font-semibold">Language</label>
                            <select id="language" class="w-full p-2 border border-gray-300 rounded-lg">
                                <option>English</option>
                                <option>Spanish</option>
                                <option>French</option>
                            </select>
                        </div>
                        
                        <!-- Post Topic and Keywords (for new post generation) -->
                        <div class="space-y-2">
                            <label for="post-topic" class="block text-gray-700 font-semibold">Post topic</label>
                            <input type="text" id="post-topic" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="What's this blog post about?">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="keywords" class="block text-gray-700 font-semibold">Keywords</label>
                            <input type="text" id="keywords" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="e.g. kundan jewelry, bridal jewelry">
                        </div>
                        
                        <!-- Tone -->
                        <div class="space-y-2">
                            <label for="tone" class="block text-gray-700 font-semibold">Tone</label>
                            <select id="tone" class="w-full p-2 border border-gray-300 rounded-lg">
                                <option>Informal</option>
                                <option>Formal</option>
                                <option>Professional</option>
                            </select>
                        </div>

                        <!-- Post Length -->
                        <div class="space-y-2">
                            <label for="post-length" class="block text-gray-700 font-semibold">Post length</label>
                            <select id="post-length" class="w-full p-2 border border-gray-300 rounded-lg">
                                <option>Short</option>
                                <option>Medium</option>
                                <option>Long</option>
                            </select>
                        </div>

                        <!-- Image Generation Section -->
                        <div class="space-y-2">
                            <label class="block text-gray-700 font-semibold">Image</label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="form-checkbox" id="generate-image-checkbox">
                                <span class="ml-2 text-gray-700">Generate featured image</span>
                            </label>
                            <textarea id="image-description" rows="2" class="w-full p-2 border border-gray-300 rounded-lg mt-2" placeholder="Describe the image you want to generate."></textarea>
                        </div>

                        <button id="generate-blog-btn" class="w-full bg-purple-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-purple-700 transition duration-300 ease-in-out">
                            Generate blog post
                        </button>
                    </div>

                    <!-- Right Main Content Area -->
                    <div class="md:col-span-2 bg-white rounded-lg p-6 space-y-6">
                        <!-- Alert Message -->
                        <div id="alert-message" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 hidden" role="alert">
                            <p>Blog post successfully created!</p>
                        </div>
                        
                        <!-- Main Content Area -->
                        <div id="content-area">
                            <!-- Loading Spinner -->
                            <div id="generating-spinner" class="hidden flex flex-col items-center justify-center p-12">
                                <svg class="animate-spin -ml-1 h-12 w-12 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="mt-4 text-gray-600">Generating content...</span>
                            </div>

                            <!-- Initial Empty State -->
                            <div id="empty-state" class="flex flex-col items-center justify-center text-center p-12 bg-gray-50 rounded-lg border-dashed border-2 border-gray-300">
                                <i class="fas fa-file-alt text-6xl text-gray-300 mb-4"></i>
                                <h3 class="text-xl font-semibold text-gray-600">Your content will appear here</h3>
                                <p class="text-gray-500 mt-2">Please fill out all the necessary information to generate your AI blog post.</p>
                            </div>

                            <!-- Generated/Editable Content Section -->
                            <div id="generated-content-section" class="hidden">
                                <label for="blog-title-input" class="block text-gray-700 font-semibold mb-2">Title</label>
                                <input id="blog-title-input" type="text" class="w-full p-2 border border-gray-300 rounded-lg text-xl font-bold mb-4">
                                
                                <label for="blog-content-editor" class="block text-gray-700 font-semibold mb-2">Content</label>
                                <textarea id="blog-content-editor" rows="20" class="w-full p-2 border border-gray-300 rounded-lg"></textarea>
                                
                                <div id="featured-image-container" class="mt-6 hidden">
                                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Featured Image</h4>
                                    <div id="featured-image-preview" class="w-full bg-gray-200 rounded-lg overflow-hidden">
                                        <!-- Image will be displayed here -->
                                    </div>
                                    <div class="flex space-x-4 mt-4">
                                        <button id="remove-image-btn" class="flex-1 bg-red-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-600 transition duration-300">
                                            Remove
                                        </button>
                                        <button id="regenerate-image-btn" class="flex-1 bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">
                                            Re-generate image
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- New button to publish to Shopify -->
                                <button id="publish-btn" class="w-full bg-purple-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-purple-700 transition duration-300 ease-in-out mt-6">
                                    Publish to Shopify
                                </button>
                                
                                <div id="publishing-spinner" class="hidden flex flex-col items-center justify-center mt-6">
                                    <svg class="animate-spin -ml-1 h-12 w-12 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="mt-4 text-gray-600">Publishing blog post...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Generate Multiple Blog Posts View -->
            <div id="multiple-view" class="view hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Multiple blog posts</h2>
                    <button id="back-from-multiple-btn" class="text-gray-600 hover:text-gray-800 transition duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Global Settings -->
                    <div class="md:col-span-1 bg-gray-50 rounded-lg p-6 border border-gray-200 space-y-4">
                        <h3 class="font-bold text-lg">Global Settings</h3>
                        <div class="space-y-2">
                            <label class="block text-gray-700 font-semibold">Visibility</label>
                            <div class="flex items-center space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio" name="bulk-visibility" value="visible" checked>
                                    <span class="ml-2 text-gray-700">Visible</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio" name="bulk-visibility" value="hidden">
                                    <span class="ml-2 text-gray-700">Hidden</span>
                                </label>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label for="bulk-language" class="block text-gray-700 font-semibold">Language</label>
                            <select id="bulk-language" class="w-full p-2 border border-gray-300 rounded-lg">
                                <option>English</option>
                                <option>Spanish</option>
                                <option>French</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label for="bulk-tone" class="block text-gray-700 font-semibold">Tone</label>
                            <select id="bulk-tone" class="w-full p-2 border border-gray-300 rounded-lg">
                                <option>Informal</option>
                                <option>Formal</option>
                                <option>Professional</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label for="bulk-post-length" class="block text-gray-700 font-semibold">Post length</label>
                            <select id="bulk-post-length" class="w-full p-2 border border-gray-300 rounded-lg">
                                <option>Short</option>
                                <option>Medium</option>
                                <option>Long</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-gray-700 font-semibold">Image</label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="form-checkbox" id="bulk-generate-image">
                                <span class="ml-2 text-gray-700">Generate featured image</span>
                            </label>
                        </div>
                    </div>
                    <!-- Posts to Generate -->
                    <div class="md:col-span-1 bg-white rounded-lg p-6 space-y-4">
                        <h3 class="font-bold text-lg">Posts</h3>
                        <div id="posts-container" class="space-y-4">
                            <!-- Post 1 -->
                            <div class="post-item p-4 border border-gray-300 rounded-lg space-y-2">
                                <h4 class="font-semibold text-gray-700">#1 Post topic</h4>
                                <input type="text" class="w-full p-2 border border-gray-300 rounded-lg post-topic" placeholder="e.g., earrings">
                                <label class="block text-gray-700 font-semibold">Keywords</label>
                                <input type="text" class="w-full p-2 border border-gray-300 rounded-lg post-keywords" placeholder="e.g., nath, nose ring x, nose pin">
                                <div class="flex justify-end">
                                    <button class="remove-post-btn text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Post 2 -->
                            <div class="post-item p-4 border border-gray-300 rounded-lg space-y-2">
                                <h4 class="font-semibold text-gray-700">#2 Post topic</h4>
                                <input type="text" class="w-full p-2 border border-gray-300 rounded-lg post-topic" placeholder="e.g., nose ring nath">
                                <label class="block text-gray-700 font-semibold">Keywords</label>
                                <input type="text" class="w-full p-2 border border-gray-300 rounded-lg post-keywords" placeholder="e.g., nath, nose ring x, nose pin">
                                <div class="flex justify-end">
                                    <button class="remove-post-btn text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button id="add-post-btn" class="w-full text-purple-600 font-bold py-2 px-4 rounded-lg border-2 border-purple-600 hover:bg-purple-100 transition duration-300">
                            <i class="fas fa-plus mr-2"></i> Add new post
                        </button>
                    </div>
                </div>
                <button id="generate-multiple-posts-btn" class="w-full mt-6 bg-purple-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-purple-700 transition duration-300 ease-in-out">
                    Generate multiple posts
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // View-related elements
            const showListBtn = document.getElementById('show-list-btn');
            const showNewBtn = document.getElementById('show-new-btn');
            const generateMultipleBtn = document.getElementById('generate-multiple-btn');
            const backToListBtn = document.getElementById('back-to-list-btn');
            const backFromMultipleBtn = document.getElementById('back-from-multiple-btn');
            const listView = document.getElementById('list-view');
            const newEditView = document.getElementById('new-edit-view');
            const multipleView = document.getElementById('multiple-view');

            // Single Post elements
            const generateBlogBtn = document.getElementById('generate-blog-btn');
            const postTopicInput = document.getElementById('post-topic');
            const keywordsInput = document.getElementById('keywords');
            const contentArea = document.getElementById('content-area');
            const emptyState = document.getElementById('empty-state');
            const generatingSpinner = document.getElementById('generating-spinner');
            const generatedContentSection = document.getElementById('generated-content-section');
            const blogTitleInput = document.getElementById('blog-title-input');
            const blogContentEditor = document.getElementById('blog-content-editor');
            const featuredImageContainer = document.getElementById('featured-image-container');
            const featuredImagePreview = document.getElementById('featured-image-preview');
            const alertMessage = document.getElementById('alert-message');
            
            // Multiple Posts elements
            const addPostBtn = document.getElementById('add-post-btn');
            const postsContainer = document.getElementById('posts-container');
            const generateMultiplePostsBtn = document.getElementById('generate-multiple-posts-btn');
            
            // New Publish elements
            const publishBtn = document.getElementById('publish-btn');
            const publishingSpinner = document.getElementById('publishing-spinner');

            let postCount = 2; // For dynamic post numbering in multiple view

            /**
             * Switches the view to the specified screen.
             * @param {string} viewId - The ID of the view to show ('list', 'new-edit', 'multiple').
             */
            function switchView(viewId) {
                listView.classList.add('hidden');
                newEditView.classList.add('hidden');
                multipleView.classList.add('hidden');
                document.getElementById(viewId + '-view').classList.remove('hidden');
            }

            /**
             * Adds a new post input section to the multiple generation view.
             */
            function addNewPostInput() {
                postCount++;
                const newPostHtml = `
                    <div class="post-item p-4 border border-gray-300 rounded-lg space-y-2">
                        <h4 class="font-semibold text-gray-700">#${postCount} Post topic</h4>
                        <input type="text" class="w-full p-2 border border-gray-300 rounded-lg post-topic">
                        <label class="block text-gray-700 font-semibold">Keywords</label>
                        <input type="text" class="w-full p-2 border border-gray-300 rounded-lg post-keywords">
                        <div class="flex justify-end">
                            <button class="remove-post-btn text-red-500 hover:text-red-700">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                `;
                postsContainer.insertAdjacentHTML('beforeend', newPostHtml);
                attachRemoveListeners();
            }

            /**
             * Attaches event listeners to the "remove post" buttons.
             */
            function attachRemoveListeners() {
                document.querySelectorAll('.remove-post-btn').forEach(button => {
                    button.onclick = (e) => {
                        e.target.closest('.post-item').remove();
                    };
                });
            }

            /**
             * Handles the blog post generation process using a Laravel backend API.
             */
            async function handleGeneration() {
                const postTopic = postTopicInput.value;
                const keywords = keywordsInput.value;
                const postLength = document.getElementById('post-length').value;
                const tone = document.getElementById('tone').value;

                if (!postTopic) {
                    alertMessage.textContent = 'Please enter a post topic.';
                    alertMessage.classList.remove('hidden');
                    alertMessage.classList.add('bg-red-100', 'border-red-500', 'text-red-700');
                    alertMessage.classList.remove('bg-green-100', 'border-green-500', 'text-green-700');
                    return;
                }
                
                // Show loading state
                emptyState.classList.add('hidden');
                generatedContentSection.classList.add('hidden');
                generatingSpinner.classList.remove('hidden');
                alertMessage.classList.add('hidden');

                // Endpoint for your Laravel API
                const laravelApiUrl = '/api/generate-blog';

                const payload = {
                    topic: postTopic,
                    keywords: keywords,
                    length: postLength,
                    tone: tone
                };
                
                try {
                    const response = await fetch(laravelApiUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Assuming CSRF token is in the blade template
                        },
                        body: JSON.stringify(payload)
                    });

                    if (!response.ok) {
                        throw new Error(`API response status: ${response.status}`);
                    }

                    const result = await response.json();
                    
                    if (result.success) {
                        blogTitleInput.value = result.title;
                        blogContentEditor.value = result.content;
                        
                        // Mock image for now
                        const mockImage = "https://placehold.co/600x400/805ad5/ffffff?text=Generated+Image";
                        featuredImagePreview.innerHTML = `<img src="${mockImage}" alt="Generated Featured Image">`;
                        featuredImageContainer.classList.remove('hidden');

                        generatingSpinner.classList.add('hidden');
                        generatedContentSection.classList.remove('hidden');
                        
                        alertMessage.textContent = 'Blog post created successfully!';
                        alertMessage.classList.remove('hidden');
                        alertMessage.classList.remove('bg-red-100', 'border-red-500', 'text-red-700');
                        alertMessage.classList.add('bg-green-100', 'border-green-500', 'text-green-700');
                    } else {
                        throw new Error(result.error || 'Unknown error from backend.');
                    }
                } catch (error) {
                    console.error('Generation error:', error);
                    generatingSpinner.classList.add('hidden');
                    emptyState.classList.remove('hidden');
                    alertMessage.textContent = `An error occurred: ${error.message}`;
                    alertMessage.classList.remove('hidden');
                    alertMessage.classList.remove('bg-green-100', 'border-green-500', 'text-green-700');
                    alertMessage.classList.add('bg-red-100', 'border-red-500', 'text-red-700');
                }
            }

            /**
             * Handles publishing the blog post to Shopify using a Laravel backend API.
             */
            async function publishToShopify() {
                const title = blogTitleInput.value;
                const content = blogContentEditor.value;
                const visibility = document.querySelector('input[name="visibility"]:checked').value;
                
                // Show publishing loading state
                publishBtn.classList.add('hidden');
                publishingSpinner.classList.remove('hidden');
                alertMessage.classList.add('hidden');

                // Endpoint for your Laravel API
                const laravelApiUrl = '/api/publish-blog';

                const payload = {
                    title: title,
                    body_html: content.replace(/\n/g, '<br>'), // Simple newline to HTML break conversion
                    published: visibility === 'visible',
                };

                try {
                    const response = await fetch(laravelApiUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(payload)
                    });

                    if (response.ok) {
                        alertMessage.textContent = 'Blog post successfully published to Shopify!';
                        alertMessage.classList.remove('hidden');
                        alertMessage.classList.add('bg-green-100', 'border-green-500', 'text-green-700');
                        alertMessage.classList.remove('bg-red-100', 'border-red-500', 'text-red-700');
                    } else {
                        throw new Error('Failed to publish blog post. Check your Laravel backend logs.');
                    }
                } catch (error) {
                    console.error('Publishing error:', error);
                    alertMessage.textContent = `Error publishing: ${error.message}`;
                    alertMessage.classList.remove('hidden');
                    alertMessage.classList.add('bg-red-100', 'border-red-500', 'text-red-700');
                    alertMessage.classList.remove('bg-green-100', 'border-green-500', 'text-green-700');
                } finally {
                    publishingSpinner.classList.add('hidden');
                    publishBtn.classList.remove('hidden');
                }
            }
            
            // Event Listeners
            showListBtn.addEventListener('click', () => switchView('list'));
            showNewBtn.addEventListener('click', () => switchView('new-edit'));
            backToListBtn.addEventListener('click', () => switchView('list'));
            generateMultipleBtn.addEventListener('click', () => switchView('multiple'));
            backFromMultipleBtn.addEventListener('click', () => switchView('list'));
            addPostBtn.addEventListener('click', addNewPostInput);
            generateBlogBtn.addEventListener('click', handleGeneration);
            publishBtn.addEventListener('click', publishToShopify);
            generateMultiplePostsBtn.addEventListener('click', () => {
                alert('This button would trigger the bulk generation process via your Laravel backend.');
            });

            // Initial state
            attachRemoveListeners();
        });
    </script>
</body>
</html>
