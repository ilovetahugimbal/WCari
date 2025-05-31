<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toilet Finder - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
            color: #334155;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        .glass-header {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.85) 0%, rgba(79, 70, 229, 0.85) 100%);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .hover-scale {
            transition: all 0.2s ease;
        }
        .hover-scale:hover {
            transform: translateY(-2px);
        }
        .tag {
            transition: all 0.2s ease;
        }
        .tag:hover {
            transform: scale(1.05);
        }
        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>
<body class="antialiased">
    <!-- Navbar -->
    <nav class="glass-nav fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo wcari.png') }}" alt="Toilet Finder Logo" class="h-8 w-auto">
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-indigo-600 font-medium text-sm smooth-transition">Home</a>
                    <a href="{{ route('findtoilet') }}" class="text-slate-600 hover:text-indigo-600 font-medium text-sm smooth-transition">Find Toilets</a>
                    <a href="{{ route('submit') }}" class="text-slate-600 hover:text-indigo-600 font-medium text-sm smooth-transition">Submit Toilet</a>
                    <a href="{{ route('user.reviews') }}" class="text-slate-600 hover:text-indigo-600 font-medium text-sm smooth-transition">Reviews</a>
                    <a href="{{ route('about') }}" class="text-slate-600 hover:text-indigo-600 font-medium text-sm smooth-transition">About</a>
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
    <div class="md:hidden glass-card fixed inset-x-0 top-16 z-40 shadow-lg hidden smooth-transition" id="mobile-menu">
        <div class="px-2 pt-2 pb-4 space-y-2">
            <a href="#" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50 smooth-transition">Home</a>
            <a href="{{ route('findtoilet')}}" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50 smooth-transition">Find Toilets</a>
            <a href="{{ route('submit') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50 smooth-transition">Submit Toilet</a>
            <a href="{{ route('user.reviews') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50 smooth-transition">Reviews</a>
            <a href="{{ route('about') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50 smooth-transition">About</a>
            <a href="{{ route('signin') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-indigo-600 bg-indigo-50/50 hover:bg-indigo-100/50 smooth-transition mt-2">
                Sign Up
            </a>
        </div>
    </div>

    <!-- Header / Banner -->
    <header class="glass-header pt-28 pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl font-bold text-white mb-5">Find Nearby Toilets with Ease</h1>
            <p class="text-indigo-100 mb-8 text-lg">Locate the nearest restroom or contribute by adding new locations to help others.</p>
            <form method="GET" action="{{ route('findtoilet') }}" class="flex flex-col sm:flex-row gap-3 justify-center max-w-md mx-auto">
                <input type="text" name="q" placeholder="Search for toilets..."
                    class="flex-grow py-3 px-4 rounded-lg bg-white/90 focus:bg-white focus:ring-2 focus:ring-indigo-300 focus:outline-none smooth-transition shadow-sm"
                    value="{{ request('q') }}"
                />
                <button type="submit" class="bg-white text-indigo-600 py-3 px-6 rounded-lg font-semibold hover-scale hover:shadow-md smooth-transition flex items-center justify-center">
                    <i class="fas fa-search mr-2"></i>
                    Search
                </button>
            </form>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 -mt-10">
        <div class="flex flex-col gap-8">

            <!-- Welcome Card -->
            <div class="glass-card rounded-xl p-8 hover-scale smooth-transition">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold mb-4 text-slate-800">Welcome to Toilet Finder</h2>
                        <p class="text-slate-600 mb-4 leading-relaxed">
                            Our platform helps you quickly locate nearby public restrooms with detailed information about facilities, cleanliness, and accessibility. 
                            Join our community to share and discover the best restroom locations around you.
                        </p>
                        <div class="flex gap-3">
                           <a href="{{ route('findtoilet') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-5 rounded-lg font-medium smooth-transition inline-block">
                                Find Toilets
                            </a>
                            <button class="border border-indigo-200 bg-white hover:bg-slate-50 text-indigo-600 py-2 px-5 rounded-lg font-medium smooth-transition">
                                How It Works
                            </button>
                        </div>
                    </div>
                    <div class="w-full md:w-1/3">
                        <img src="https://illustrations.popsy.co/amber/digital-nomad.svg" alt="Illustration" class="w-full h-auto">
                    </div>
                </div>
            </div>
            <!-- How It Works Section -->
            <div class="mt-10">
                <h3 class="text-xl font-semibold text-slate-800 mb-8 text-center">How It Works</h3>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="glass-card rounded-xl p-6 text-center hover-scale smooth-transition">
                        <div class="w-16 h-16 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-search text-indigo-600 text-2xl"></i>
                        </div>
                        <h4 class="font-semibold text-lg mb-2">Search</h4>
                        <p class="text-slate-600 text-sm">Find nearby toilets based on your current location or any address.</p>
                    </div>
                    <div class="glass-card rounded-xl p-6 text-center hover-scale smooth-transition">
                        <div class="w-16 h-16 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-info-circle text-indigo-600 text-2xl"></i>
                        </div>
                        <h4 class="font-semibold text-lg mb-2">View Details</h4>
                        <p class="text-slate-600 text-sm">Check facilities, accessibility, and user reviews before you go.</p>
                    </div>
                    <div class="glass-card rounded-xl p-6 text-center hover-scale smooth-transition">
                        <div class="w-16 h-16 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-plus-circle text-indigo-600 text-2xl"></i>
                        </div>
                        <h4 class="font-semibold text-lg mb-2">Contribute</h4>
                        <p class="text-slate-600 text-sm">Add new locations or update information to help the community.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-800/80 text-white py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <img src="{{ asset('images/logo wcari.png') }}" alt="Toilet Finder Logo" class="h-8 mb-4">
                    <p class="text-slate-300 text-sm mb-4">Helping you find clean, accessible restrooms wherever you are.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-slate-300 hover:text-white smooth-transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-slate-300 hover:text-white smooth-transition"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-slate-300 hover:text-white smooth-transition"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider mb-4">Navigation</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-slate-300 hover:text-white text-sm smooth-transition">Home</a></li>
                        <li><a href="{{route('findtoilet')}}" class="text-slate-300 hover:text-white text-sm smooth-transition">Find Toilets</a></li>
                        <li><a href="{{ route('submit') }}" class="text-slate-300 hover:text-white text-sm smooth-transition">Submit Toilet</a></li>
                        <li><a href="#" class="text-slate-300 hover:text-white text-sm smooth-transition">Reviews</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider mb-4">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-slate-300 hover:text-white text-sm smooth-transition">Privacy Policy</a></li>
                        <li><a href="#" class="text-slate-300 hover:text-white text-sm smooth-transition">Terms of Service</a></li>
                        <li><a href="#" class="text-slate-300 hover:text-white text-sm smooth-transition">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-700 mt-10 pt-6 text-sm text-slate-400">
                <p>&copy; 2025 Toilet Finder. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>