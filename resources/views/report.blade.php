<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Reports - Toilet Finder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
            color: #334155;
        }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid rgba(255, 255, 255, 0.4);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        }
        
        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Table styling */
        table {
            border-collapse: separate;
            border-spacing: 0;
        }
        
        th {
            background: rgba(248, 250, 252, 0.7);
        }
        
        td, th {
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        /* Status badges */
        .status-badge {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
        }
        
        /* Mobile menu animation */
        .mobile-menu-enter {
            opacity: 0;
            transform: translateY(-10px);
        }
        
        .mobile-menu-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.3s ease;
        }
        
        .mobile-menu-exit {
            opacity: 1;
        }
        
        .mobile-menu-exit-active {
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
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
                    <a href="{{ route('report') }}" class="text-indigo-600 font-medium text-sm smooth-transition">Reports</a>
                    <a href="{{ route('about') }}" class="text-slate-600 hover:text-indigo-600 font-medium text-sm smooth-transition">About</a>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm smooth-transition">
                        Sign In
                    </a>
                    <button class="md:hidden text-slate-500 hover:text-slate-700 focus:outline-none" id="mobile-menu-button">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="md:hidden glass-card fixed inset-x-0 top-16 z-40 shadow-lg hidden smooth-transition transform transition-all duration-300" id="mobile-menu">
        <div class="px-2 pt-2 pb-4 space-y-1">
            <a href="#" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50 smooth-transition">Home</a>
            <a href="{{ route('findtoilet')}}" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50 smooth-transition">Find Toilets</a>
            <a href="{{ route('submit') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50 smooth-transition">Submit Toilet</a>
            <a href="{{ route('report') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-indigo-600 bg-indigo-50/50 smooth-transition">Reports</a>
            <a href="{{ route('about') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50/50 smooth-transition">About</a>
            <a href="{{ route('signin') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-indigo-600 hover:bg-indigo-100/50 smooth-transition mt-2">
                Sign Up
            </a>
        </div>
    </div>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-24">
        <div class="mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-slate-800 flex items-center gap-3">
                <i class="fas fa-flag text-indigo-600"></i> User Reports
            </h2>
            <p class="text-slate-500 mt-2">Review and manage user-submitted reports</p>
        </div>

        <!-- Reports Table -->
        <div class="glass-card rounded-xl overflow-hidden shadow-sm mb-8">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Toilet</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Report</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100 text-sm">
                        @forelse($reports as $i => $report)
                        <tr class="hover:bg-slate-50/50 smooth-transition">
                            <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $i+1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-800">{{ $report->user->name ?? 'Anonymous' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ $report->toilet->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600 max-w-xs truncate">{{ Str::limit($report->content, 40) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($report->status === 'pending')
                                    <span class="status-badge bg-amber-100 text-amber-800">
                                        <i class="fas fa-clock mr-1"></i> Pending
                                    </span>
                                @elseif($report->status === 'resolved')
                                    <span class="status-badge bg-emerald-100 text-emerald-800">
                                        <i class="fas fa-check-circle mr-1"></i> Resolved
                                    </span>
                                @else
                                    <span class="status-badge bg-slate-100 text-slate-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $report->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('report.show', $report->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium smooth-transition inline-flex items-center">
                                    View <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-400">
                                <i class="fas fa-inbox text-2xl mb-2"></i>
                                <p>No reports found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-800/90 text-white py-12 mt-16 backdrop-blur-sm">
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
                    <h4 class="text-sm font-semibold uppercase tracking-wider mb-4 text-slate-200">Navigation</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-slate-300 hover:text-white text-sm smooth-transition">Home</a></li>
                        <li><a href="{{ route('findtoilet') }}" class="text-slate-300 hover:text-white text-sm smooth-transition">Find Toilets</a></li>
                        <li><a href="{{ route('submit') }}" class="text-slate-300 hover:text-white text-sm smooth-transition">Submit Toilet</a></li>
                        <li><a href="{{ route('user.reviews') }}" class="text-slate-300 hover:text-white text-sm smooth-transition">Reports</a></li>
                        <li><a href="{{ route('report') }}" class="text-slate-300 hover:text-white text-sm smooth-transition">Reports</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider mb-4 text-slate-200">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-slate-300 hover:text-white text-sm smooth-transition">Privacy Policy</a></li>
                        <li><a href="#" class="text-slate-300 hover:text-white text-sm smooth-transition">Terms of Service</a></li>
                        <li><a href="#" class="text-slate-300 hover:text-white text-sm smooth-transition">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-700/50 mt-10 pt-6 text-sm text-slate-400">
                <p>&copy; 2025 Toilet Finder. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>