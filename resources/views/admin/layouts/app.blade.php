<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-indigo-800 min-h-screen p-4">
            <div class="text-white font-bold text-xl mb-8">Admin Panel</div>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-white hover:bg-indigo-700 rounded">Dashboard</a>
                <a href="{{ route('admin.toilets') }}" class="block px-4 py-2 text-white hover:bg-indigo-700 rounded">Toilets</a>
                <a href="{{ route('admin.laporans') }}" class="block px-4 py-2 text-white hover:bg-indigo-700 rounded">Reports</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <header class="bg-white shadow">
                <div class="px-4 py-6">
                    <div class="flex justify-between">
                        <h2 class="font-semibold text-xl text-gray-800">Admin Panel</h2>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-red-600">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="container mx-auto py-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>