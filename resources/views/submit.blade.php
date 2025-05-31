<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Toilet - Toilet Finder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
            min-height: 100vh;
            }
            .glass-card {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
                border-radius: 1rem;
            }
            .input-glass {
                background: rgba(255, 255, 255, 0.8);
                border: 1px solid rgba(209, 213, 219, 0.3);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .input-glass:focus {
                background: rgba(255, 255, 255, 0.95);
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
                border-color: rgba(59, 130, 246, 0.3);
            }
            .file-upload-label {
                border: 1px dashed rgba(203, 213, 225, 0.6);
                transition: all 0.3s ease;
                background: rgba(255, 255, 255, 0.6);
            }
            .file-upload-label:hover {
                border-color: #a5b4fc;
                background: rgba(255, 255, 255, 0.8);
            }
            .checkbox-item {
                transition: all 0.2s ease;
            }
            .checkbox-item:hover {
                transform: translateY(-2px);
            }
            .btn-primary {
                background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
                box-shadow: 0 4px 6px rgba(99, 102, 241, 0.2);
                transition: all 0.3s ease;
            }
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 12px rgba(99, 102, 241, 0.25);
            }
            .nav-underline {
                position: relative;
            }
            .nav-underline:after {
                content: '';
                position: absolute;
                width: 0;
                height: 2px;
                bottom: -2px;
                left: 0;
                background-color: #3b82f6;
                transition: width 0.3s ease;
            }
            .nav-underline:hover:after {
                width: 100%;
            }
            .blob {
                filter: blur(60px);
                opacity: 0.1;
                position: fixed;
                z-index: 0;
                border-radius: 50%;
            }
            .blob-1 {
                width: 400px; height: 400px;
                background: #6366f1;
                top: -100px; left: -100px;
            }
            .blob-2 {
                width: 300px; height: 300px;
                background: #a5b4fc;
                bottom: -80px; right: -80px;
            }
    </style>
</head>
<body class="antialiased text-slate-800">
    <!-- Background blobs -->
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

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
                    <a href="{{ route('submit') }}" class="nav-underline text-indigo-600 font-medium text-sm">Submit Toilet</a>
                    <a href="{{ route('user.reviews') }}" class="nav-underline text-slate-600 hover:text-indigo-600 text-sm font-medium">Reports</a>
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
            <a href="{{ route('user.reviews') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50">Reports</a>
            <a href="{{ route('about') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50">About</a>
            <a href="{{ route('signin') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-blue-600 hover:bg-blue-50/50 border border-blue-100 mt-2">
                Sign Up
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-12 relative z-10">
        <div class="glass-card p-6 sm:p-8 max-w-3xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl font-semibold text-slate-800 mb-2">Submit New Toilet</h2>
                <p class="text-slate-500 text-sm">Help others by sharing toilet information</p>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50/80 text-green-700 rounded-lg border border-green-200 text-sm">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any()))
                <div class="mb-6 p-4 bg-red-50/80 text-red-700 rounded-lg border border-red-200 text-sm">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <h3 class="font-medium">Please fix these issues:</h3>
                    </div>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('toilet.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1" for="name">Toilet Name*</label>
                            <input type="text" id="name" name="name" required 
                                   class="input-glass w-full px-3 py-2.5 rounded-lg focus:outline-none text-sm"
                                   placeholder="e.g. Johar Market Public Toilet" value="{{ old('name') }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1" for="address">Full Address*</label>
                            <textarea id="address" name="address" required rows="3"
                                   class="input-glass w-full px-3 py-2.5 rounded-lg focus:outline-none text-sm"
                                   placeholder="Enter complete address">{{ old('address') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1" for="description">Description</label>
                            <textarea id="description" name="description" rows="3"
                                   class="input-glass w-full px-3 py-2.5 rounded-lg focus:outline-none text-sm"
                                   placeholder="Brief description about this toilet">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-5">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1" for="open">Opening Time</label>
                                <input type="time" id="open" name="open" 
                                       class="input-glass w-full px-3 py-2.5 rounded-lg focus:outline-none text-sm"
                                       value="{{ old('open') }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1" for="close">Closing Time</label>
                                <input type="time" id="close" name="close" 
                                       class="input-glass w-full px-3 py-2.5 rounded-lg focus:outline-none text-sm"
                                       value="{{ old('close') }}">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1" for="fee">Fee</label>
                            <input type="text" id="fee" name="fee" 
                                   class="input-glass w-full px-3 py-2.5 rounded-lg focus:outline-none text-sm"
                                   placeholder="Free or enter amount" value="{{ old('fee') }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1" for="photo">Toilet Photo</label>
                            <label for="photo" class="file-upload-label flex flex-col items-center justify-center w-full p-4 rounded-lg cursor-pointer">
                                <input type="file" id="photo" name="photo[]" class="hidden" accept="image/*" multiple>
                                <i class="fas fa-cloud-upload-alt text-indigo-400 mb-2 text-lg"></i>
                                <p class="text-sm text-slate-600 mb-1">Click to upload photo</p>
                                <p class="text-xs text-slate-400">PNG, JPG up to 5MB</p>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Facilities Section -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-3">Facilities</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        @php
                            $facilityIcons = [
                                'Air Bersih'      => 'fa-tint',
                                'Sabun'           => 'fa-soap',
                                'Kloset Duduk'    => 'fa-toilet',
                                'Kloset Jongkok'  => 'fa-restroom',
                                'Tempat Sampah'   => 'fa-trash-alt',
                                'Mushola'         => 'fa-mosque',
                                'Parkir'          => 'fa-parking',
                            ];
                        @endphp
                        @foreach(['Air Bersih','Sabun','Kloset Duduk','Kloset Jongkok','Tempat Sampah','Mushola','Parkir'] as $facility)
                            <label class="checkbox-item flex items-center space-x-2 text-sm text-slate-700 bg-slate-50/50 hover:bg-slate-100/50 p-2 rounded-lg">
                                <input type="checkbox" name="facilities[]" value="{{ $facility }}" 
                                       class="rounded text-blue-600 focus:ring-blue-500"
                                       {{ (is_array(old('facilities')) && in_array($facility, old('facilities'))) ? 'checked' : '' }}>
                                <i class="fas {{ $facilityIcons[$facility] ?? 'fa-check' }} text-indigo-500"></i>
                                <span>{{ $facility }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Accessibility Section -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-3">Accessibility</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @php
                            $accessIcons = [
                                'Ramah Difabel'                => 'fa-wheelchair',
                                'Toilet Anak'                  => 'fa-child',
                                'Toilet Pria/Wanita Terpisah'  => 'fa-venus-mars',
                            ];
                        @endphp
                        @foreach(['Ramah Difabel','Toilet Anak','Toilet Pria/Wanita Terpisah'] as $access)
                            <label class="checkbox-item flex items-center space-x-2 text-sm text-slate-700 bg-slate-50/50 hover:bg-slate-100/50 p-2 rounded-lg">
                                <input type="checkbox" name="access[]" value="{{ $access }}" 
                                       class="rounded text-blue-600 focus:ring-blue-500"
                                       {{ (is_array(old('access')) && in_array($access, old('access'))) ? 'checked' : '' }}>
                                <i class="fas {{ $accessIcons[$access] ?? 'fa-check' }} text-indigo-500"></i>
                                <span>{{ $access }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-2">
                    @auth
                    <button type="submit" 
                                class="w-full btn-primary text-white py-3 rounded-lg font-medium">
                            Submit Toilet Information
                    </button>
                    @else
                        <button type="button" 
                                onclick="window.location.href='{{ route('login') }}'"
                                class="w-full btn-primary text-white py-3 rounded-lg font-medium opacity-70 cursor-not-allowed">
                            Please log in to submit
                        </button>
                    @endauth
                </div>
            </form>
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
                    <a href="#" class="text-slate-300 hover:text-white smooth-transition"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-slate-300 hover:text-white smooth-transition"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-slate-300 hover:text-white smooth-transition"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider mb-4">Navigation</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-slate-300 hover:text-white text-sm smooth-transition">Home</a></li>
                    <li><a href="{{ route('findtoilet') }}" class="text-slate-300 hover:text-white text-sm smooth-transition">Find Toilets</a></li>
                    <li><a href="{{ route('submit') }}" class="text-slate-300 hover:text-white text-sm smooth-transition">Submit Toilet</a></li>
                    <li><a href="#" class="text-slate-300 hover:text-white text-sm smooth-transition">Reports</a></li>
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

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // File input display
        const fileInput = document.getElementById('photo');
        const fileUploadLabel = fileInput.parentElement;
        
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length) {
                fileUploadLabel.innerHTML = `
                    <i class="fas fa-check-circle text-green-400 mb-2 text-lg"></i>
                    <p class="text-sm text-slate-600 mb-1">${e.target.files[0].name}</p>
                    <p class="text-xs text-slate-400">${(e.target.files[0].size / 1024 / 1024).toFixed(2)}MB</p>
                `;
                fileUploadLabel.classList.add('bg-green-50/80', 'border-green-200', 'border-solid');
            }
        });
        
    </script>
</body>
</html>