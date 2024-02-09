<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
    <script src="{{ mix('resources/js/app.js') }}" defer></script>
</head>

<body class="bg-gray-100">
    <nav class="bg-gray-800 py-6">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-white">
                <a href="{{ route('home') }}" class="text-xl font-bold">{{ config('app.name', 'Laravel') }}</a>
            </div>
            <div>
                <!-- Navbar content here -->
                <!-- Add a link to the dashboard -->
                @auth
                <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Profile</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="py-20 bg-gradient-to-r from-blue-500 to-green-500">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold text-white">Welcome to My Blog</h1>
        </div>
    </header>

    <main class="container mx-auto">
        <!-- Main content here -->
        @if (Auth::check())
        <!-- Show extra content for logged-in users -->
        <div class="bg-blue-200 p-4 mb-4">
            Welcome back, {{ Auth::user()->name }}!
        </div>
        <form method="POST" action="{{ route('posts.store') }}" class="mt-4">
            @csrf
            <input type="text" name="title" placeholder="Title" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2">
            <textarea name="body" placeholder="Write your blog post here..." class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"></textarea>
            <x-input-error :messages="$errors->get('body')" class="mb-2" />
            <x-primary-button>Post</x-primary-button>
        </form>
        @else
        <!-- Show different content for non-logged-in users -->
        <div class="bg-gray-200 p-4">
            <p class="text-center">Please <a href="{{ route('login') }}" class="text-blue-600 underline">log in</a> to post or check comments to the blog.</p>
        </div>
        @endif
        <!-- Display blog posts -->
        @foreach ($posts as $post)
        <div class="bg-white shadow-md p-6 my-4">
            <h2 class="text-xl font-semibold mb-2">{{ $post->title }}</h2>
            <p class="text-gray-700">{{ $post->body }}</p>

            <!-- Display user information -->
            <div class="mt-4 text-sm text-gray-500">Posted by {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</div>

            <!-- Reply form -->
            @auth
            <form method="POST" action="{{ route('comments.store', $post->id) }}" class="mt-4">
                @csrf
                <textarea name="content" placeholder="Your reply" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"></textarea>
                <x-primary-button>Reply</x-primary-button>
            </form>
            @else
            <p class="text-center mt-4">Please <a href="{{ route('login') }}" class="text-blue-600 underline">log in</a> to reply to this post.</p>
            @endauth

            <!-- Display replies -->
            <div class="mt-4">
                <h3 class="text-lg font-semibold mb-2">Replies:</h3>
                @foreach ($post->comments as $comment)
                <div class="bg-gray-100 p-4 mb-2">
                    <p>{{ $comment->content }}</p>
                    <div class="mt-4 text-sm text-gray-500">Posted by {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </main>

    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <!-- Footer content here -->
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>