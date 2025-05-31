<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Toilet - Toilet Finder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .glass-nav {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        .slider-btn {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            transition: all 0.3s ease;
        }
        .slider-btn:hover {
            background: rgba(255, 255, 255, 1);
        }
        .blob {
            filter: blur(60px);
            opacity: 0.15;
            position: fixed;
            z-index: 0;
            border-radius: 50%;
        }
        .blob-1 {
            width: 400px; height: 400px;
            background: #6366f1; /* indigo-500 */
            top: -100px; left: -100px;
        }
        .blob-2 {
            width: 300px; height: 300px;
            background: #a5b4fc; /* indigo-300 */
            bottom: -80px; right: -80px;
        }
        .tag {
            transition: all 0.2s ease;
        }
        .tag:hover {
            transform: scale(1.05);
        }
        .review-form textarea {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(209, 213, 219, 0.5);
        }
        .review-form textarea:focus {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
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
            background-color: #6366f1;
            transition: width 0.3s ease;
        }
        .nav-underline:hover:after {
            width: 100%;
        }
        .review-form input[type="radio"]:checked + label i {
            color: #facc15; /* yellow-400 */
            text-shadow: 0 0 4px #fde68a;
        }
        .review-form label i {
            color: #e5e7eb; /* slate-200/300, bintang kosong */
            transition: color 0.2s, transform 0.2s;
        }
        .review-form input[type="radio"]:checked ~ label i,
        .review-form input[type="radio"]:checked + label i {
            color: #facc15; /* yellow-400, bintang aktif */
        }
        .review-form input[type="radio"] {
            display: none;
        }
        .favorite-icon {
            cursor: pointer;
            transition: color 0.2s, transform 0.2s;
        }
        .favorite-icon.favorited {
            color: #ef4444; /* red-500 */
        }
        .favorite-icon:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="antialiased text-slate-800">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <nav class="bg-white/90 backdrop-filter backdrop-blur-md fixed w-full z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo wcari.png') }}" alt="Toilet Finder Logo" class="h-8">
                </div>
                <div class="hidden md:flex items-center space-x-6">
                    <a href="/" class="nav-underline text-slate-600 hover:text-indigo-600 text-sm font-medium">Home</a>
                    <a href="{{ route('findtoilet')}}" class="nav-underline text-indigo-600 font-medium text-sm">Find Toilets</a>
                    <a href="{{ route('submit') }}" class="nav-underline text-slate-600 hover:text-indigo-600 text-sm font-medium">Submit Toilet</a>
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

    <main class="max-w-2xl mx-auto py-6 px-4 sm:px-6 relative z-10 pt-20">
        @if($toilet)
        <div class="glass-card rounded-xl p-6 mb-6 hover:shadow-md transition-all">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-xl sm:text-2xl font-semibold text-slate-800">{{ $toilet->name }}</h2>
                <button type="button" class="favorite-icon text-slate-400 text-2xl" data-toilet-id="{{ $toilet->id }}">
                    <i class="far fa-heart"></i>
                </button>
            </div>
            <div class="text-slate-500 text-sm mb-3">{{ $toilet->address }}</div>
            <div class="text-slate-600 text-sm mb-4">{{ $toilet->description }}</div>
            
            {{-- Rata-rata rating bintang --}}
            @if($reviews->count())
                <div class="flex items-center mb-4">
                    @php
                        $avg = $reviews->avg('rating');
                        $fullStars = floor($avg);
                        $halfStar = ($avg - $fullStars) >= 0.5;
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $fullStars)
                            <i class="fas fa-star text-yellow-400 text-xl"></i>
                        @elseif ($halfStar && $i == $fullStars + 1)
                            <i class="fas fa-star-half-alt text-yellow-400 text-xl"></i>
                        @else
                            <i class="far fa-star text-slate-300 text-xl"></i>
                        @endif
                    @endfor
                    <span class="ml-2 text-slate-600 text-sm font-semibold">{{ number_format($avg, 1) }}</span>
                    <span class="ml-2 text-slate-400 text-xs">({{ $reviews->count() }} reviews)</span>
                </div>
            @endif
            
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($toilet->facilities ?? [] as $f)
                    <span class="tag inline-flex items-center px-2.5 py-0.5 bg-blue-50 text-blue-600 rounded-full text-xs font-medium">
                        <i class="fas fa-check-circle mr-1 text-xs"></i> {{ $f }}
                    </span>
                @endforeach
            </div>
            
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($toilet->access ?? [] as $a)
                    <span class="tag inline-flex items-center px-2.5 py-0.5 bg-green-50 text-green-600 rounded-full text-xs font-medium">
                        <i class="fas fa-check-circle mr-1 text-xs"></i> {{ $a }}
                    </span>
                @endforeach
            </div>
            
            <div class="flex flex-wrap gap-x-4 gap-y-2 text-xs text-slate-500">
                <div class="flex items-center">
                    <i class="fas fa-clock mr-1.5 text-xs"></i>
                    {{ $toilet->open }} - {{ $toilet->close }}
                </div>
                <div class="flex items-center">
                    <i class="fas fa-money-bill-wave mr-1.5 text-xs"></i>
                    {{ $toilet->fee }}
                </div>
                @if($toilet->contact)
                <div class="flex items-center">
                    <i class="fas fa-phone-alt mr-1.5 text-xs"></i>
                    {{ $toilet->contact }}
                </div>
                @endif
            </div>
        </div>
        @else
            <div class="text-red-500 bg-red-50/80 px-4 py-3 rounded-lg border border-red-200 text-sm">
                <i class="fas fa-exclamation-circle mr-2"></i> Toilet not found
            </div>
        @endif

        @if(!empty($images))
        <div class="relative mb-6 rounded-xl overflow-hidden">
            <div class="h-64 bg-slate-100 relative" id="slider">
                @foreach($images as $i => $img)
                    <img src="{{ asset($img) }}"
                         class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500 {{ $i === 0 ? 'opacity-100' : 'opacity-0' }}"
                         alt="Toilet photo {{ $i+1 }}">
                @endforeach
            </div>
            <button type="button" onclick="prevSlide()" 
                    class="slider-btn absolute left-4 top-1/2 -translate-y-1/2 rounded-full p-2 shadow">
                <i class="fas fa-chevron-left text-slate-700"></i>
            </button>
            <button type="button" onclick="nextSlide()" 
                    class="slider-btn absolute right-4 top-1/2 -translate-y-1/2 rounded-full p-2 shadow">
                <i class="fas fa-chevron-right text-slate-700"></i>
            </button>
        </div>
        @endif

        <div class="glass-card rounded-xl p-6 mb-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-slate-800">Reviews</h3>
                <div class="text-sm text-slate-500">{{ $reviews->count() }} reviews</div>
            </div>
            
            @if($reviews->count())
                <div class="space-y-5">
                    @foreach($reviews as $review)
                        <div class="border-b border-slate-100 pb-5 last:border-0 last:pb-0">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 text-sm">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="ml-3 text-sm text-slate-500">{{ $review->created_at->diffForHumans() }}</div>
                                <div class="ml-4 flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $review->rating >= $i ? 'text-yellow-400' : 'text-slate-300' }}"></i>
                                    @endfor
                                    <span class="ml-2 text-xs text-slate-600">{{ number_format($review->rating, 1) }}</span>
                                </div>
                            </div>
                            <div class="text-slate-600 text-sm pl-11">{{ $review->komentar }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <i class="fas fa-comment-slash text-3xl text-slate-300 mb-3"></i>
                    <p class="text-slate-400 text-sm">No reviews yet</p>
                </div>
            @endif

            <form method="POST" action="{{ route('toilet.review.store', $toilet->id) }}" class="review-form mt-8">
                @csrf
                <label class="block text-sm font-medium text-slate-700 mb-2">Add your review</label>
    
                @error('rating')
                    <p class="text-red-500 text-xs mb-2">{{ $message }}</p>
                @enderror
        
            <div class="flex items-center mb-3">
                <span class="mr-3 text-sm text-slate-600">Your Rating:</span>
                    @for ($i = 5; $i >= 1; $i--)
                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" 
                        class="hidden" required {{ old('rating') == $i ? 'checked' : '' }}>
                        <label for="star{{ $i }}" class="cursor-pointer text-2xl text-yellow-400 hover:scale-110 transition-transform">
                        <i class="fas fa-star"></i>
                        </label>
                    @endfor
            </div>

            @error('content')
                <p class="text-red-500 text-xs mb-2">{{ $message }}</p>
            @enderror

                <textarea name="content" rows="3" 
                class="w-full rounded-lg p-3 text-sm focus:outline-none {{ $errors->has('content') ? 'border-red-500' : '' }}"
                placeholder="Share your experience with this toilet...">{{ old('content') }}</textarea>

                <button type="submit" 
                class="btn-primary text-white px-4 py-2.5 rounded-lg font-medium mt-3">
                Submit Review
                </button>
            </form>

        @if(session('success'))
            <div class="mt-4 p-4 bg-green-50 text-green-600 rounded-lg">
                {{ session('success') }}
            </div>
            @endif
            </div>
    </main>
    
    <footer class="text-center text-slate-400 py-6 text-xs mt-6">
        &copy; {{ date('Y') }} Toilet Finder. All rights reserved.
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Image slider functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('#slider img');
        
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('opacity-100', i === index);
                slide.classList.toggle('opacity-0', i !== index);
            });
            currentSlide = index;
        }
        
        function nextSlide() {
            const nextIndex = (currentSlide + 1) % slides.length;
            showSlide(nextIndex);
        }
        
        function prevSlide() {
            const prevIndex = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(prevIndex);
        }
        
        // Auto-rotate slides if more than one
        if (slides.length > 1) {
            setInterval(nextSlide, 5000);
        }

        // Favorite button functionality
        document.addEventListener('DOMContentLoaded', () => {
            const favoriteIcon = document.querySelector('.favorite-icon');
            if (favoriteIcon) {
                const toiletId = favoriteIcon.dataset.toiletId;
                
                // Check local storage for favorited status
                const isFavorited = localStorage.getItem(`toilet_${toiletId}_favorited`) === 'true';
                if (isFavorited) {
                    favoriteIcon.classList.add('favorited');
                    favoriteIcon.querySelector('i').classList.replace('far', 'fas');
                }

                favoriteIcon.addEventListener('click', () => {
                    favoriteIcon.classList.toggle('favorited');
                    const icon = favoriteIcon.querySelector('i');
                    if (favoriteIcon.classList.contains('favorited')) {
                        icon.classList.replace('far', 'fas'); // Change to solid heart
                        localStorage.setItem(`toilet_${toiletId}_favorited`, 'true');
                        // In a real application, you would send an AJAX request to your backend to save this
                        console.log(`Toilet ${toiletId} added to favorites.`);
                    } else {
                        icon.classList.replace('fas', 'far'); // Change to regular heart
                        localStorage.removeItem(`toilet_${toiletId}_favorited`);
                        // In a real application, you would send an AJAX request to your backend to remove this
                        console.log(`Toilet ${toiletId} removed from favorites.`);
                    }
                });
            }
        });
    </script>
</body>
</html>