<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Reviews - Toilet Finder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); min-height: 100vh; }
        .glass-card { background: rgba(255,255,255,0.85); backdrop-filter: blur(16px); border-radius: 1rem; box-shadow: 0 8px 32px rgba(31,38,135,0.1);}
        .btn-primary { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: #fff; transition: all 0.3s; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 12px rgba(99,102,241,0.25);}
        .nav-underline { position: relative; }
        .nav-underline:after { content: ''; position: absolute; width: 0; height: 2px; bottom: -2px; left: 0; background-color: #3b82f6; transition: width 0.3s;}
        .nav-underline:hover:after { width: 100%; }
        .input-glass { background: rgba(255,255,255,0.7); border: 1px solid rgba(209,213,219,0.3); }
        .input-glass:focus { border-color: #6366f1; outline: none; box-shadow: 0 0 0 3px rgba(99,102,241,0.2); }
    </style>
</head>
<body class="antialiased text-slate-800">
    <!-- Navbar -->
    <nav class="bg-white/90 backdrop-filter backdrop-blur-md fixed w-full z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo wcari.png') }}" alt="Toilet Finder Logo" class="h-8">
                </div>
                <div class="hidden md:flex items-center space-x-6">
                    <a href="/" class="nav-underline text-slate-600 hover:text-indigo-600 text-sm font-medium">Home</a>
                    <a href="{{ route('findtoilet')}}" class="nav-underline text-slate-600 hover:text-indigo-600 text-sm font-medium">Find Toilets</a>
                    <a href="{{ route('submit') }}" class="nav-underline text-slate-600 hover:text-indigo-600 text-sm font-medium">Submit Toilet</a>
                    <a href="{{ route('user.reviews') }}" class="nav-underline text-indigo-600 font-medium text-sm">Reports</a>
                    <a href="{{ route('about') }}" class="nav-underline text-slate-600 hover:text-indigo-600 text-sm font-medium">About</a>
                </div>
                <div class="flex items-center space-x-3">
                    @if(Auth::check())
                        <div class="relative group" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                <span class="text-sm font-medium text-slate-700">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs ml-1 text-slate-500"></i>
                            </button>
                            <!-- Dropdown Logout -->
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-32 glass-card rounded-md shadow-lg py-1 z-50 border border-slate-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50/50">
                                        <i class="fas fa-sign-out-alt mr-2 text-red-500"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm smooth-transition">
                            Sign In
                        </a>
                    @endif
                    <button class="md:hidden text-slate-500 hover:text-slate-700 focus:outline-none" id="mobile-menu-button">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="md:hidden glass-card fixed inset-x-0 top-16 z-40 shadow-lg hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-4 space-y-2">
            <a href="/" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50">Home</a>
            <a href="{{ route('findtoilet')}}" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50">Find Toilets</a>
            <a href="{{ route('submit') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-indigo-600 bg-indigo-50/50 hover:bg-indigo-100/50">Submit Toilet</a>
            <a href="{{ route('user.reviews') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50">Reviews</a>
            <a href="{{ route('about') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50">Reports</a>
            <a href="{{ route('signin') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-blue-600 hover:bg-blue-50/50 border border-blue-100 mt-2">
                Sign Up
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-12 relative z-10">
        <div class="glass-card p-6 sm:p-8 max-w-2xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl font-semibold text-slate-800 mb-2">Share Your Experience</h2>
                <p class="text-slate-500 text-sm">Tell us what you think about using WCari!</p>
            </div>

            <!-- Review Form -->
            <form method="POST" action="{{ route('laporan.store') }}" class="space-y-5 mb-8">
                @csrf
                
                @auth
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    
                @endauth
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Your Report</label>
                    <textarea name="deskripsi_laporan" rows="4" required 
                        class="input-glass w-full px-3 py-2.5 rounded-lg focus:outline-none text-sm" 
                        placeholder="Share your report..."></textarea>
                    @error('deskripsi_laporan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full btn-primary py-3 rounded-lg font-medium">Submit Reports</button>
            </form>
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-600 rounded-lg">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-slate-800/80 text-white py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <img src="{{ asset('images/logo wcari.png') }}" alt="Toilet Finder Logo" class="h-8 mb-4">
                    <p class="text-slate-300 text-sm mb-4">Helping you find clean, accessible restrooms wherever you are.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-slate-300 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-slate-300 hover:text-white"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-slate-300 hover:text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider mb-4">Navigation</h4>
                    <ul class="space-y-2">
                        <li><a href="/" class="text-slate-300 hover:text-white text-sm">Home</a></li>
                        <li><a href="{{ route('findtoilet') }}" class="text-slate-300 hover:text-white text-sm">Find Toilets</a></li>
                        <li><a href="{{ route('submit') }}" class="text-slate-300 hover:text-white text-sm">Submit Toilet</a></li>
                        <li><a href="{{ route('user.reviews') }}" class="text-slate-300 hover:text-white text-sm">Reviews</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider mb-4">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-slate-300 hover:text-white text-sm">Privacy Policy</a></li>
                        <li><a href="#" class="text-slate-300 hover:text-white text-sm">Terms of Service</a></li>
                        <li><a href="#" class="text-slate-300 hover:text-white text-sm">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-700 mt-10 pt-6 text-sm text-slate-400">
                <p>&copy; 2025 Toilet Finder. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>