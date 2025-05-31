<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About - Toilet Finder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
            color: #334155;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        .glass-header {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.9) 0%, rgba(79, 70, 229, 0.9) 100%);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .nav-underline {
            position: relative;
            overflow: hidden;
        }
        .nav-underline::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 100%;
            height: 2px;
            background: #4f46e5;
            transform: scaleX(0);
            transition: transform 0.3s cubic-bezier(.4,0,.2,1);
            transform-origin: left;
        }
        .nav-underline:hover::after,
        .nav-underline:focus::after {
            transform: scaleX(1);
        }
        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-scale {
            transition: all 0.2s ease;
        }
        .hover-scale:hover {
            transform: translateY(-2px);
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
                    <a href="#" class="text-slate-600 hover:text-indigo-600 font-medium text-sm smooth-transition">Home</a>
                    <a href="{{ route('findtoilet') }}" class="text-slate-600 hover:text-indigo-600 font-medium text-sm smooth-transition">Find Toilets</a>
                    <a href="{{ route('submit') }}" class="text-slate-600 hover:text-indigo-600 font-medium text-sm smooth-transition">Submit Toilet</a>
                    <a href="{{ route('user.reviews') }}" class="text-slate-600 hover:text-indigo-600 font-medium text-sm smooth-transition">Reports</a>
                    <a href="{{ route('about') }}" class="text-indigo-600 font-medium text-sm smooth-transition">About</a>
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

    <!-- Hero Section -->
    <section class="glass-header pt-28 pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl font-bold text-white mb-5">About Toilet Finder</h1>
            <p class="text-indigo-100 text-lg leading-relaxed">
                Our mission is to create a community-driven platform that helps people find clean, accessible restrooms wherever they are.
            </p>
        </div>
    </section>

    <!-- Story Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="glass-card rounded-xl p-8 hover-scale smooth-transition">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="w-full md:w-1/3">
                        <img src="https://illustrations.popsy.co/amber/designer.svg" alt="Our Story" class="w-full h-auto">
                    </div>
                    <div class="w-full md:w-2/3">
                        <h2 class="text-2xl font-bold text-slate-800 mb-4">Our Story</h2>
                        <p class="text-slate-600 mb-4 leading-relaxed">
                            Toilet Finder was born from a simple observation - the difficulty people face in finding clean, accessible public restrooms when they need them most. What started as a personal frustration evolved into a mission to create a solution that benefits everyone.
                        </p>
                        <p class="text-slate-600 leading-relaxed">
                            Today, we're proud to serve thousands of users across Indonesia, helping them locate the nearest restroom with detailed information about facilities, cleanliness, and accessibility.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission -->
    <section class="py-12 px-4 sm:px-6 lg:px-8 bg-white/50">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-2xl font-bold text-center text-slate-800 mb-12">Our Vision & Mission</h2>
            
            <div class="grid md:grid-cols-2 gap-8">
                <div class="glass-card rounded-xl p-8 hover-scale smooth-transition">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-eye text-indigo-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-800">Vision</h3>
                    </div>
                    <p class="text-slate-600 leading-relaxed">
                        To become the most trusted platform for finding public restrooms, making clean and accessible sanitation facilities available to everyone, everywhere.
                    </p>
                </div>
                
                <div class="glass-card rounded-xl p-8 hover-scale smooth-transition">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-bullseye text-indigo-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-800">Mission</h3>
                    </div>
                    <ul class="text-slate-600 space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-indigo-500 mt-1 mr-2"></i>
                            <span>Provide accurate, real-time information about public restrooms</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-indigo-500 mt-1 mr-2"></i>
                            <span>Build a community that shares and verifies restroom information</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-indigo-500 mt-1 mr-2"></i>
                            <span>Promote better sanitation standards in public facilities</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-indigo-500 mt-1 mr-2"></i>
                            <span>Make restrooms accessible to people with disabilities</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-2xl font-bold text-center text-slate-800 mb-12">Meet Our Team</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Team Member 1 -->
                <div class="glass-card rounded-xl p-6 text-center hover-scale smooth-transition">
                    <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-crown text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-lg text-slate-800 mb-1">Alif Nuril Adinda</h3>
                    <p class="text-indigo-600 text-sm font-medium mb-3">Leader</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-slate-400 hover:text-indigo-600 smooth-transition"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-slate-400 hover:text-indigo-600 smooth-transition"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                
                <!-- Team Member 2 -->
                <div class="glass-card rounded-xl p-6 text-center hover-scale smooth-transition">
                    <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-server text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-lg text-slate-800 mb-1">Mukhtarul Hadi</h3>
                    <p class="text-indigo-600 text-sm font-medium mb-3">Backend Developer</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-slate-400 hover:text-indigo-600 smooth-transition"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-slate-400 hover:text-indigo-600 smooth-transition"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                
                <!-- Team Member 3 -->
                <div class="glass-card rounded-xl p-6 text-center hover-scale smooth-transition">
                    <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-laptop-code text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-lg text-slate-800 mb-1">Muhammad Bahrul Widad</h3>
                    <p class="text-indigo-600 text-sm font-medium mb-3">Frontend Developer</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-slate-400 hover:text-indigo-600 smooth-transition"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-slate-400 hover:text-indigo-600 smooth-transition"><i class="fab fa-dribbble"></i></a>
                    </div>
                </div>
                
                <!-- Team Member 4 -->
                <div class="glass-card rounded-xl p-6 text-center hover-scale smooth-transition">
                    <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-paint-brush text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-lg text-slate-800 mb-1">Aisyah Qurrota Ayun</h3>
                    <p class="text-indigo-600 text-sm font-medium mb-3">UI/UX Designer</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-slate-400 hover:text-indigo-600 smooth-transition"><i class="fab fa-behance"></i></a>
                        <a href="#" class="text-slate-400 hover:text-indigo-600 smooth-transition"><i class="fab fa-dribbble"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white/50">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-2xl font-bold text-center text-slate-800 mb-12">Our Core Values</h2>
            
            <div class="grid md:grid-cols-3 gap-6">
                <div class="glass-card rounded-xl p-6 hover-scale smooth-transition">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-users text-indigo-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-lg text-slate-800 mb-2">Community</h3>
                    <p class="text-slate-600 text-sm">We believe in the power of community to create better solutions for everyone.</p>
                </div>
                
                <div class="glass-card rounded-xl p-6 hover-scale smooth-transition">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-shield-alt text-indigo-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-lg text-slate-800 mb-2">Trust</h3>
                    <p class="text-slate-600 text-sm">We're committed to providing accurate, reliable information you can depend on.</p>
                </div>
                
                <div class="glass-card rounded-xl p-6 hover-scale smooth-transition">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-heart text-indigo-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-lg text-slate-800 mb-2">Compassion</h3>
                    <p class="text-slate-600 text-sm">We design with empathy, understanding the real needs of our users.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-800/80 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <img src="{{ asset('images/logo wcari.png') }}" alt="Toilet Finder Logo" class="h-8 mb-4">
                    <p class="text-slate-300 text-sm mb-4">Helping you find clean, accessible restrooms wherever you are.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-slate-300 hover:text-white smooth-transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-slate-300 hover:text-white smooth-transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-slate-300 hover:text-white smooth-transition"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider mb-4">Navigation</h4>
                    <ul class="space-y-2">
                        <li><a href="/" class="text-slate-300 hover:text-white text-sm smooth-transition">Home</a></li>
                        <li><a href="#" class="text-slate-300 hover:text-white text-sm smooth-transition">Find Toilets</a></li>
                        <li><a href="{{ route('submit') }}" class="text-slate-300 hover:text-white text-sm smooth-transition">Submit Toilet</a></li>
                        <li><a href="{{ route('about') }}" class="text-slate-300 hover:text-white text-sm smooth-transition">About</a></li>
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
                <p>&copy; {{ date('Y') }} Toilet Finder. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuButton = document.getElementById('mobile-menu-button');
            
            if (!mobileMenu.contains(event.target) && !menuButton.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>