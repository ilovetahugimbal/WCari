<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Toilets - Toilet Finder</title>
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
    </style>
</head>
<body>
    <main class="p-4">
        <!-- Nearby Toilets Section -->
        <div>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-slate-800">Nearby Toilets</h3>
            </div>
            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                @foreach($toilets as $toilet)
                <div class="glass-card rounded-xl p-5 hover-scale smooth-transition">
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
                        ]), ENT_QUOTES, 'UTF-8') !!})"
                        class="w-full bg-indigo-50 hover:bg-indigo-100 text-indigo-600 px-4 py-2 rounded-lg text-sm font-medium smooth-transition">
                        View Details
                    </button>
                </div>
                @endforeach
            </div>
        </div>
    </main>

    <!-- Modal Detail Toilet (copy dari app.blade.php) -->
    <div id="toilet-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden smooth-transition">
        <div class="glass-card rounded-xl p-8 w-full max-w-md mx-4 relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 text-xl smooth-transition">
                <i class="fas fa-times"></i>
            </button>
            <div class="flex items-start justify-between mb-4">
                <h3 id="modal-name" class="text-xl font-bold text-indigo-700"></h3>
                <div id="modal-rating" class="flex items-center bg-indigo-50 text-indigo-600 px-2.5 py-1 rounded-full text-xs">
                    <i class="fas fa-star mr-1 text-yellow-400"></i>
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
</body>
</html>