<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details - {{ $user->name }}</title>
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
                    <h2 class="text-2xl font-semibold text-gray-800">User Details: {{ $user->name }}</h2>
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
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    <div class="bg-white shadow-md rounded my-6 p-6">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                            <p class="text-gray-900">{{ $user->name }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                            <p class="text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Joined:</label>
                            <p class="text-gray-900">{{ $user->created_at->format('M d, Y H:i A') }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Admin:</label>
                            <p class="text-gray-900">{{ $user->is_admin ? 'Yes' : 'No' }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Matched:</label>
                            <p class="text-gray-900">{{ $user->matched ? 'Yes' : 'No' }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tags:</label>
                            <div class="flex flex-wrap">
                                @forelse ($user->tags as $tag)
                                    <span class="bg-wine-light text-white text-xs px-2 py-1 rounded-full mr-2 mb-2">{{ $tag->name }}</span>
                                @empty
                                    <p class="text-gray-900">No tags assigned.</p>
                                @endforelse
                            </div>
                        </div>
                        <div class="flex items-center justify-start mt-6">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>