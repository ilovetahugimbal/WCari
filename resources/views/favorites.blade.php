<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Favorites - Toilet Finder</title>
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
        .favorite-btn {
            transition: all 0.3s ease;
            cursor: pointer;
            color: #ef4444; /* Always red for favorited toilets on this page */
        }
        .favorite-btn:hover {
            transform: scale(1.1);
        }
        .toast {
            animation: fadeInOut 3s ease-in-out forwards;
        }
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(20px); }
            10% { opacity: 1; transform: translateY(0); }
            90% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(20px); }
        }
    </style>
</head>
<body class="antialiased">
    <nav class="glass-nav fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo wcari.png') }}" alt="Toilet Finder Logo" class="h-8 w-auto">
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-slate-600 hover:text-indigo-600 font-medium text-sm smooth-transition">Home</a>
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
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-36 glass-card rounded-md shadow-lg py-1 z-50 border border-slate-100">
                                <a href="{{ route('favorites') }}" class="block px-4 py-2 text-sm text-indigo-700 bg-indigo-50/50 hover:bg-indigo-100/50">
                                    <i class="fas fa-heart mr-2 text-red-500"></i> Favorites
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50/50">
                                        <i class="fas fa-sign-out-alt mr-2 text-slate-500"></i> Logout
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

    <div class="md:hidden glass-card fixed inset-x-0 top-16 z-40 shadow-lg hidden smooth-transition" id="mobile-menu">
        <div class="px-2 pt-2 pb-4 space-y-2">
            <a href="#" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50 smooth-transition">Home</a>
            <a href="{{ route('findtoilet') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50 smooth-transition">Find Toilets</a>
            <a href="{{ route('submit') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50 smooth-transition">Submit Toilet</a>
            <a href="{{ route('user.reviews') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50 smooth-transition">Reviews</a>
            <a href="{{ route('about') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50 smooth-transition">About</a>
            @auth
                <a href="{{ route('favorites') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-indigo-600 bg-indigo-50/50 hover:bg-indigo-100/50">
                    <i class="fas fa-heart mr-2"></i> Favorites
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-3 rounded-lg text-base font-medium text-red-600 hover:bg-red-50/50">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-indigo-600 bg-indigo-50/50 hover:bg-indigo-100/50 smooth-transition mt-2">
                    Sign In
                </a>
            @endauth
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-24">
        <h1 class="text-3xl font-bold text-slate-800 mb-8">My Favorite Toilets</h1>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($favoriteToilets as $toilet)
            <div class="glass-card rounded-xl p-5 hover-scale smooth-transition relative">
                <button onclick="toggleFavorite({{ $toilet->id }}, this)" 
                        class="favorite-btn text-2xl absolute top-4 right-4">
                    <i class="fas fa-heart"></i>
                </button>
                
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div>
                        <h4 class="font-semibold text-indigo-700 text-lg">{{ $toilet->name }}</h4>
                        <div class="text-sm text-slate-500 mt-1">{{ $toilet->distance ?? 'N/A' }} away</div>
                    </div>
                    <div class="flex items-center bg-indigo-50 text-indigo-600 px-2 py-1 rounded-full text-xs">
                        @php
                            $rating = $toilet->rating ?? 0;
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $rating >= $i ? 'text-yellow-400' : 'text-slate-300' }}"></i>
                        @endfor
                        <span class="ml-2 text-slate-700 font-semibold">{{ number_format($rating, 1) }}</span>
                    </div>
                </div>
                <div class="text-sm text-slate-600 mb-4 line-clamp-2">{{ $toilet->address }}</div>
                <div class="flex flex-wrap gap-2 mb-4">
                    {{-- Assuming facilities are stored as a JSON array or similar --}}
                    @if(isset($toilet->facilities) && is_array($toilet->facilities))
                        @foreach($toilet->facilities as $f)
                            <span class="tag inline-flex items-center px-2.5 py-0.5 bg-blue-50 text-blue-600 rounded-full text-xs">
                                {{-- You might want specific icons based on facility names --}}
                                @if(Str::contains(strtolower($f), 'water')) <i class="fas fa-tint mr-1"></i> @endif
                                @if(Str::contains(strtolower($f), 'accessible')) <i class="fas fa-wheelchair mr-1"></i> @endif
                                @if(Str::contains(strtolower($f), 'paper')) <i class="fas fa-toilet-paper mr-1"></i> @endif
                                {{ $f }}
                            </span>
                        @endforeach
                    @endif
                </div>
                <button onclick="showToiletDetail({!! htmlspecialchars(json_encode([
                        'id' => $toilet->id,
                        'name' => $toilet->name,
                        'address' => $toilet->address,
                        'description' => $toilet->description,
                        'facilities' => $toilet->facilities,
                        'open' => $toilet->open,
                        'close' => $toilet->close,
                        'fee' => $toilet->fee,
                        'contact' => $toilet->contact,
                        'access' => $toilet->access,
                        'rating' => $toilet->rating,
                        'is_favorite' => true // On favorites page, it's always true
                    ]), ENT_QUOTES, 'UTF-8') !!})"
                    class="w-full bg-indigo-50 hover:bg-indigo-100 text-indigo-600 px-4 py-2 rounded-lg text-sm font-medium smooth-transition">
                    View Details
                </button>
            </div>
            @empty
            <div class="col-span-full text-center py-10 glass-card rounded-xl">
                <i class="fas fa-heart-crack text-5xl text-slate-300 mb-4"></i>
                <p class="text-slate-500 text-lg">You haven't added any toilets to your favorites yet.</p>
                <p class="text-slate-400 text-sm mt-2">Go to <a href="{{ route('findtoilet') }}" class="text-indigo-600 hover:underline">Find Toilets</a> to start adding them!</p>
            </div>
            @endforelse
        </div>
    </main>

    <div id="toilet-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden smooth-transition">
        <div class="glass-card rounded-xl p-8 w-full max-w-md mx-4 relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 text-xl smooth-transition">
                <i class="fas fa-times"></i>
            </button>
            <div class="flex items-start justify-between mb-4">
                <h3 id="modal-name" class="text-xl font-bold text-indigo-700"></h3>
                <div class="flex items-center">
                    @auth
                    <button id="modal-favorite-btn" class="favorite-btn text-2xl mr-3">
                        <i class="fas fa-heart"></i>
                    </button>
                    @endauth
                    <div id="modal-rating" class="flex items-center bg-indigo-50 text-indigo-600 px-2.5 py-1 rounded-full text-xs">
                        <i class="fas fa-star mr-1 text-yellow-400"></i>
                    </div>
                </div>
            </div>
            <div id="modal-address" class="text-slate-600 mb-4 text-sm"></div>
            <div id="modal-description" class="text-slate-700 mb-4 text-sm"></div>
            <div class="mb-4">
                <h4 class="text-sm font-semibold text-slate-800 mb-2">Facilities</h4>
                <div id="modal-facilities" class="flex flex-wrap gap-2"></div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <h4 class="text-sm font-semibold text-slate-800 mb-1">Opening Hours</h4>
                    <div class="text-sm text-slate-600">
                        <span id="modal-open"></span> - <span id="modal-close"></span>
                    </div>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-slate-800 mb-1">Fee</h4>
                    <div id="modal-fee" class="text-sm text-slate-600"></div>
                </div>
            </div>
            <div class="mb-4">
                <h4 class="text-sm font-semibold text-slate-800 mb-2">Accessibility</h4>
                <div id="modal-access" class="flex flex-wrap gap-2"></div>
            </div>
            <div class="mb-6">
                <h4 class="text-sm font-semibold text-slate-800 mb-1">Contact</h4>
                <div id="modal-contact" class="text-sm text-slate-600"></div>
            </div>
            <button id="review-btn" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-lg font-medium smooth-transition mb-3">
                View Reviews
            </button>
            <button class="w-full border border-indigo-200 bg-white hover:bg-slate-50 text-indigo-600 py-2.5 rounded-lg font-medium smooth-transition">
                Get Directions
            </button>
        </div>
    </div>

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
                        <li><a href="{{ route('user.reviews') }}" class="text-slate-300 hover:text-white text-sm smooth-transition">Reviews</a></li>
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
                <p>© 2025 Toilet Finder. All rights reserved.</p>
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

        // Current modal toilet data
        let currentModalToiletId = null;

        function showToiletDetail(data) {
            currentModalToiletId = data.id;
            
            document.getElementById('modal-name').textContent = data.name || '';
            document.getElementById('modal-address').textContent = data.address || '';
            document.getElementById('modal-description').textContent = data.description || 'No description available.';
            document.getElementById('modal-open').textContent = data.open || 'Not specified';
            document.getElementById('modal-close').textContent = data.close || 'Not specified';
            document.getElementById('modal-fee').textContent = data.fee || 'Free';
            document.getElementById('modal-contact').textContent = data.contact || 'Not available';

            // Render rating stars
            let stars = '';
            let rating = typeof data.rating === 'number' ? data.rating : parseFloat(data.rating) || 0;
            for (let i = 1; i <= 5; i++) {
                stars += `<i class="fas fa-star ${rating >= i ? 'text-yellow-400' : 'text-slate-300'}"></i>`;
            }
            stars += `<span class="ml-2 text-slate-700 font-semibold">${rating.toFixed(1)}</span>`;
            document.getElementById('modal-rating').innerHTML = stars;

            // Set favorite button state for modal
            const favoriteBtn = document.getElementById('modal-favorite-btn');
            if (favoriteBtn) {
                // On the favorites page, the toilet is by definition favorited
                favoriteBtn.classList.add('active'); 
                favoriteBtn.onclick = function() {
                    // When clicked in the modal on the favorites page, it means "remove from favorites"
                    toggleFavorite(data.id, favoriteBtn);
                };
            }

            // Facilities
            let facilities = '';
            if (Array.isArray(data.facilities)) {
                facilities = data.facilities.map(f => {
                    let icon = '';
                    if (f.toLowerCase().includes('water')) icon = '<i class="fas fa-tint mr-1"></i>';
                    if (f.toLowerCase().includes('accessible')) icon = '<i class="fas fa-wheelchair mr-1"></i>';
                    if (f.toLowerCase().includes('paper')) icon = '<i class="fas fa-toilet-paper mr-1"></i>';
                    return `
                        <span class="tag inline-flex items-center px-2.5 py-0.5 bg-blue-50 text-blue-600 rounded-full text-xs">
                            ${icon} ${f}
                        </span>
                    `;
                }).join(' ');
            }
            document.getElementById('modal-facilities').innerHTML = facilities || '<span class="text-slate-400 text-sm">No facilities listed</span>';

            // Accessibility
            let access = '';
            if (Array.isArray(data.access)) {
                access = data.access.map(a => `
                    <span class="tag inline-flex items-center px-2.5 py-0.5 bg-emerald-50 text-emerald-600 rounded-full text-xs">
                        <i class="fas fa-check-circle mr-1"></i> ${a}
                    </span>
                `).join(' ');
            }
            document.getElementById('modal-access').innerHTML = access || '<span class="text-slate-400 text-sm">No accessibility information</span>';

            // Set link review
            document.getElementById('review-btn').onclick = function() {
                window.location.href = '/toilets/' + data.id + '/reviews'; // Ensure this route exists
            };

            document.getElementById('toilet-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('toilet-modal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Toggle favorite function (for cards and modal button)
        function toggleFavorite(toiletId, buttonElement) {
            fetch(`/favorites/${toiletId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Laravel CSRF token
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    showToast(data.message);
                    // If successfully removed, reload the page to reflect changes
                    // or remove the card from the DOM
                    if (data.message.includes('removed')) {
                         // Find and remove the card associated with the toiletId
                        const card = buttonElement.closest('.glass-card');
                        if (card) {
                            card.remove();
                        }
                        // Close modal if the removed toilet's modal is open
                        if (currentModalToiletId === toiletId) {
                            closeModal();
                        }
                        // If no more favorites, show the empty state message
                        const favoriteToiletsContainer = document.querySelector('.grid.gap-6');
                        if (favoriteToiletsContainer && favoriteToiletsContainer.children.length === 0) {
                            favoriteToiletsContainer.innerHTML = `
                                <div class="col-span-full text-center py-10 glass-card rounded-xl">
                                    <i class="fas fa-heart-crack text-5xl text-slate-300 mb-4"></i>
                                    <p class="text-slate-500 text-lg">You haven't added any toilets to your favorites yet.</p>
                                    <p class="text-slate-400 text-sm mt-2">Go to <a href="{{ route('findtoilet') }}" class="text-indigo-600 hover:underline">Find Toilets</a> to start adding them!</p>
                                </div>
                            `;
                        }
                    }
                    // For favorites page, the button should always be "active" (red heart)
                    // It only becomes inactive (empty heart) if the item is removed.
                    // So we don't toggle active class here, but rather remove the card.
                } else {
                    showToast('Failed to update favorites: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred. Please try again.');
            });
        }

        // Show toast notification
        function showToast(message) {
            const existingToast = document.querySelector('.toast');
            if (existingToast) {
                existingToast.remove();
            }

            const toast = document.createElement('div');
            toast.className = 'toast fixed bottom-4 right-4 bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-lg flex items-center space-x-2';
            toast.innerHTML = `<i class="fas fa-info-circle"></i> <span>${message}</span>`;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    </script>
</body>
</html>