<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Email Template</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .wine-dark { background-color: #722F37; }
        .wine-light { background-color: #8B0000; }
        .text-wine { color: #722F37; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen bg-gray-200">
        <!-- Sidebar -->
        <div class="w-64 wine-dark text-white flex flex-col">
            <div class="flex items-center justify-center h-20 border-b border-gray-700">
                <h1 class="text-2xl font-bold">Admin Panel</h1>
            </div>
            <nav class="flex-1 px-4 py-8">
                <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">All Users</a>
                <a href="{{ route('admin.dashboard', ['filter' => 'matched']) }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">Matched Users</a>
                <a href="{{ route('admin.dashboard', ['filter' => 'unmatched']) }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">Unmatched Users</a>

                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-2">Tags</h3>
                    @forelse ($allTags as $tag)
                        <a href="{{ route('admin.dashboard', ['tag' => $tag->name]) }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 text-sm">
                            {{ $tag->name }}
                        </a>
                    @empty
                        <p class="text-gray-400 text-sm px-4">No tags created yet.</p>
                    @endforelse
                </div>
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-2">Email Management</h3>
                    <a href="{{ route('admin.email_templates.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 text-sm">
                        Email Templates
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navbar -->
            <header class="flex justify-between items-center py-4 px-6 bg-white border-b-4 border-wine-dark">
                <div class="flex items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">Create Email Template</h2>
                </div>
                <div class="flex items-center">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main content -->
            <main class="flex-1 overflow-x-auto overflow-y-auto bg-gray-200">
                <div class="container mx-auto px-6 py-8">
                    <div class="bg-white shadow-md rounded my-6 p-6">
                        <form action="{{ route('admin.email_templates.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Template Name:</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                @error('name')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="subject" class="block text-gray-700 text-sm font-bold mb-2">Subject:</label>
                                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                @error('subject')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="body" class="block text-gray-700 text-sm font-bold mb-2">Body (use {{'{ { variable } }'}} for placeholders):</label>
                                <textarea name="body" id="body" rows="10" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('body') }}</textarea>
                                @error('body')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type:</label>
                                <select name="type" id="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="user" {{ old('type') == 'user' ? 'selected' : '' }}>User Notification</option>
                                    <option value="admin" {{ old('type') == 'admin' ? 'selected' : '' }}>Admin Notification</option>
                                </select>
                                @error('type')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between mt-6">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Create Template
                                </button>
                                <a href="{{ route('admin.email_templates.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>