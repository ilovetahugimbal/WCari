<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Toilets - Toilet Finder</title>
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
        }
        .favorite-btn.active {
            color: #ef4444;
            transform: scale(1.1);
        }
        .favorite-btn:not(.active) {
            color: #e5e7eb;
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
    <!-- Navbar -->
    <nav class="glass-nav fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo wcari.png') }}" alt="Toilet Finder Logo" class="h-8 w-auto">
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-slate-600 hover:text-indigo-600 font-medium text-sm smooth-transition">Home</a>
                    <a href="{{ route('findtoilet') }}" class="text-indigo-600 font-medium text-sm smooth-transition">Find Toilets</a>
                    <a href="{{ route('submit') }}" class="text-slate-600 hover:text-indigo-600 font-medium text-sm smooth-transition">Submit Toilet</a>
                    <a href="{{ route('user.reviews') }}" class="text-slate-600 hover:text-indigo-600 font-medium text-sm smooth-transition">Reports</a>
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
                                        <a href="{{ route('favorites') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50/50">
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

    <!-- Mobile Menu -->
    <div class="md:hidden glass-card fixed inset-x-0 top-16 z-40 shadow-lg hidden smooth-transition" id="mobile-menu">
        <div class="px-2 pt-2 pb-4 space-y-2">
            <a href="#" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50 smooth-transition">Home</a>
            <a href="{{ route('findtoilet') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-indigo-600 bg-indigo-50/50 hover:bg-indigo-100/50 smooth-transition">Find Toilets</a>
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

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-24">
        <!-- Search and Filter Section -->
        <div class="glass-card rounded-xl p-5 mb-8">
            <form method="GET" action="{{ route('findtoilet') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-grow">
                    <input type="text" name="q" placeholder="Search for toilets..." 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                        value="{{ request('q') }}">
                </div>
                <div class="flex gap-2">
                    <select name="facility" class="px-3 py-2.5 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-200 text-sm">
                        <option value="" {{ request('facility') == '' ? 'selected' : '' }}>All Facilities</option>
                        <option value="water" {{ request('facility') == 'water' ? 'selected' : '' }}>Water Available</option>
                        <option value="paper" {{ request('facility') == 'paper' ? 'selected' : '' }}>Tissue Available</option>
                        <option value="accessible" {{ request('facility') == 'accessible' ? 'selected' : '' }}>Wheelchair Accessible</option>
                    </select>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium">
                        <i class="fas fa-search mr-2"></i> Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Map Section -->
        <div class="glass-card rounded-xl overflow-hidden hover-scale smooth-transition mb-8">
            <div class="p-5 border-b border-slate-100">
                <h3 class="text-lg font-semibold text-slate-800">Toilets Near You</h3>
            </div>
            <div class="w-full">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3428.6011148875127!2d110.38984787431085!3d-7.050630269088504!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708b3a1e3a1529%3A0x4cda1f81771c5e97!2sUniversitas%20Negeri%20Semarang%20(UNNES)!5e1!3m2!1sid!2sid!4v1747714827047!5m2!1sid!2sid"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <!-- Nearby Toilets Section -->
        <div>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-slate-800">Nearby Toilets</h3>
                <a href="{{ route('findtoilet.all') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium flex items-center smooth-transition">
                    View all <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>
            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                @foreach($toilets->take(9) as $toilet)
                <div class="glass-card rounded-xl p-5 hover-scale smooth-transition relative">
                    
                    
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div>
                            <h4 class="font-semibold text-indigo-700 text-lg">{{ $toilet->name }}</h4>
                            <div class="text-sm text-slate-500 mt-1">{{ $toilet->distance }} m away</div>
                        </div>
                        <div class="flex items-center bg-indigo-50 text-indigo-600 px-2 py-1 rounded-full text-xs">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $toilet->rating >= $i ? 'text-yellow-400' : 'text-slate-300' }}"></i>
                            @endfor
                            <span class="ml-2 text-slate-700 font-semibold">{{ number_format($toilet->rating, 1) }}</span>
                        </div>
                    </div>
                    <div class="text-sm text-slate-600 mb-4 line-clamp-2">{{ $toilet->address }}</div>
                    <div class="flex flex-wrap gap-2 mb-4">
                        @if($toilet->has_water)
                            <span class="tag inline-flex items-center px-2.5 py-0.5 bg-blue-50 text-blue-600 rounded-full text-xs">
                                <i class="fas fa-tint mr-1"></i> Water
                            </span>
                        @endif
                        @if($toilet->is_accessible)
                            <span class="tag inline-flex items-center px-2.5 py-0.5 bg-emerald-50 text-emerald-600 rounded-full text-xs">
                                <i class="fas fa-wheelchair mr-1"></i> Accessible
                            </span>
                        @endif
                        @if($toilet->has_paper)
                            <span class="tag inline-flex items-center px-2.5 py-0.5 bg-amber-50 text-amber-600 rounded-full text-xs">
                                <i class="fas fa-toilet-paper mr-1"></i> Tissue
                            </span>
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
                            'latitude' => $toilet->latitude,
                            'longitude' => $toilet->longitude,
                            'is_favorite' => $toilet->favorites->where('user_id', auth()->id())->count() > 0 
                        ]), ENT_QUOTES, 'UTF-8') !!})"
                        class="w-full bg-indigo-50 hover:bg-indigo-100 text-indigo-600 px-4 py-2 rounded-lg text-sm font-medium smooth-transition">
                        View Details
                    </button>
                </div>
                @endforeach
            </div>
        </div>
    </main>

    <!-- Modal Detail Toilet -->
    <div id="toilet-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden smooth-transition">
        <div class="glass-card rounded-xl p-8 w-full max-w-md mx-4 relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 text-xl smooth-transition">
                <i class="fas fa-times"></i>
            </button>
            <div class="flex items-start justify-between mb-4">
                <h3 id="modal-name" class="text-xl font-bold text-indigo-700"></h3>
                <div class="flex items-center">
                    @auth
                    <button id="modal-favorite-btn" 
                            class="favorite-btn text-2xl mr-3" 
                            data-toilet-id="{{ $toilet->id ?? '' }}">
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
            <div class="flex justify-between items-center mt-6">
    <a href="#" 
       onclick="getDirections('{{ $toilet->latitude }}', '{{ $toilet->longitude }}', '{{ $toilet->name }}')" 
       class="flex items-center justify-center w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
        <i class="fas fa-directions mr-2"></i>
        Get Directions
    </a>
</div>
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
                        <li><a href="{{ route('user.reviews') }}" class="text-slate-300 hover:text-white text-sm smooth-transition">Reviews</a></li>
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

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuButton = document.getElementById('mobile-menu-button');
            if (!mobileMenu.contains(event.target) && !menuButton.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
        
        function getDirections(lat, lng, name) {
            // Encode toilet name untuk URL
            const encodedName = encodeURIComponent(name);
    
            // Buat URL Google Maps dengan koordinat toilet
            const mapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}&destination_place_id=${encodedName}`;
    
            // Buka di tab baru
            window.open(mapsUrl, '_blank');
        }

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

            // Set favorite button state
            const favoriteBtn = document.getElementById('modal-favorite-btn');
            if (favoriteBtn) {
                favoriteBtn.classList.toggle('active', data.is_favorite);
                favoriteBtn.setAttribute('data-toilet-id', data.id);
                favoriteBtn.onclick = function() {
                    toggleFavorite(data.id, favoriteBtn);
                };
            }

            // Facilities
            let facilities = '';
            if (Array.isArray(data.facilities)) {
                facilities = data.facilities.map(f => `
                    <span class="tag inline-flex items-center px-2.5 py-0.5 bg-indigo-50 text-indigo-600 rounded-full text-xs">
                        ${f}
                    </span>
                `).join(' ');
            }
            document.getElementById('modal-facilities').innerHTML = facilities || '<span class="text-slate-400 text-sm">No facilities listed</span>';

            // Accessibility
            let access = '';
            if (Array.isArray(data.access)) {
                access = data.access.map(a => `
                    <span class="tag inline-flex items-center px-2.5 py-0.5 bg-emerald-50 text-emerald-600 rounded-full text-xs">
                        ${a}
                    </span>
                `).join(' ');
            }
            document.getElementById('modal-access').innerHTML = access || '<span class="text-slate-400 text-sm">No accessibility information</span>';

            // Set link review
            document.getElementById('review-btn').onclick = function() {
                window.location.href = '/toilets/' + data.id + '/reviews';
            };

            document.getElementById('toilet-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Update tombol Get Directions
            const directionsBtn = document.getElementById('get-directions-btn');
            if (directionsBtn) {
                directionsBtn.onclick = () => getDirections(data.latitude, data.longitude, data.name);
            }
        }

        function closeModal() {
            document.getElementById('toilet-modal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Toggle favorite function
        function toggleFavorite(toiletId, buttonElement) {
            fetch(`/favorites/${toiletId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Update all related buttons
            const isFavorited = buttonElement.classList.contains('active');
            const newState = !isFavorited;
            
            // Update clicked button
            buttonElement.classList.toggle('active', newState);
            
            // Update all buttons with same toilet ID
            document.querySelectorAll(`[data-toilet-id="${toiletId}"]`).forEach(btn => {
                btn.classList.toggle('active', newState);
            });
                    
                    // Show toast notification
                    showToast(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred. Please try again.');
            });
        }

        // Show toast notification
        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'toast fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg';
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    </script>
</body>
</html>