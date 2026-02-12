<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - {{ $user->name }}</title>
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
            </nav>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navbar -->
            <header class="flex justify-between items-center py-4 px-6 bg-white border-b-4 border-wine-dark">
                <div class="flex items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">Edit User: {{ $user->name }}</h2>
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
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                @error('name')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                @error('email')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Admin Status:</label>
                                <input type="checkbox" name="is_admin" id="is_admin" {{ $user->is_admin ? 'checked' : '' }} class="mr-2 leading-tight">
                                <label for="is_admin" class="text-sm text-gray-700">Is Admin</label>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Matched Status:</label>
                                <input type="checkbox" name="matched" id="matched" {{ $user->matched ? 'checked' : '' }} class="mr-2 leading-tight">
                                <label for="matched" class="text-sm text-gray-700">Is Matched</label>
                            </div>

                            <div class="mb-4">
                                <label for="tags" class="block text-gray-700 text-sm font-bold mb-2">Tags (comma-separated):</label>
                                <input type="text" name="tags" id="tags" value="{{ old('tags', $user->tags->pluck('name')->implode(', ')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('tags')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between mt-6">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Update User
                                </button>
                                <a href="{{ route('admin.users.show', $user->id) }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
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