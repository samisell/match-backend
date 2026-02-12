<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Templates</title>
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
                    <h2 class="text-2xl font-semibold text-gray-800">Email Templates</h2>
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
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('admin.email_templates.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create New Template</a>
                    </div>
                    <div class="bg-white shadow-md rounded my-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($templates as $template)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $template->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $template->subject }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ ucfirst($template->type) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.email_templates.edit', $template->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-4">Edit</a>
                                            <form action="{{ route('admin.email_templates.destroy', $template->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this template?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No email templates found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>