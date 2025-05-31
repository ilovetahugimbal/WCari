<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Toilet Finder</title>
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
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
            border-radius: 1.5rem;
        }
        .input-glass {
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(209, 213, 219, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-glass:focus {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            border-color: rgba(59, 130, 246, 0.3);
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
        .social-btn {
            transition: all 0.3s ease;
        }
        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
        }
        .blob {
            filter: blur(60px);
            opacity: 0.15;
        }
        .checkbox:checked {
            background-color: #6366f1;
            border-color: #6366f1;
        }
    </style>
</head>
<body class="flex items-center justify-center p-4 antialiased">
    <!-- Background blobs -->
    <div class="fixed inset-0 overflow-hidden z-0">
        <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-indigo-300 blob"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 rounded-full bg-indigo-200 blob"></div>
    </div>

    <!-- Main card -->
    <div class="glass-card p-8 w-full max-w-md z-10 transform transition-all duration-500 hover:scale-[1.02]">
        <div class="flex flex-col items-center mb-8">
            <img src="{{ asset('images/logo wcari.png') }}" alt="Logo" class="h-12 mb-4">
            <h2 class="text-2xl font-bold text-slate-800">Welcome Back</h2>
            <p class="text-slate-500 text-sm mt-2">Sign in to your account</p>
        </div>

        @if($errors->any())
            <div class="mb-6 text-sm text-red-600 bg-red-50/80 p-3 rounded-lg border border-red-100">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ $errors->first('login') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
            @csrf
            
            <div class="space-y-1">
                <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-envelope text-sm"></i>
                    </div>
                    <input type="email" id="email" name="email" required autofocus
                        class="input-glass w-full pl-10 pr-4 py-3 rounded-lg text-slate-700 focus:outline-none"
                        placeholder="your@email.com">
                </div>
            </div>

            <div class="space-y-1">
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-lock text-sm text-indigo-400"></i>
                    </div>
                    <input type="password" id="password" name="password" required
                        class="input-glass w-full pl-10 pr-4 py-3 rounded-lg text-slate-700 focus:outline-none"
                        placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox"
                        class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 checkbox">
                    <label for="remember-me" class="ml-2 block text-sm text-slate-600">Remember me</label>
                </div>
                <a href="#" class="text-sm text-indigo-600 hover:underline font-medium">Forgot password?</a>
            </div>

            <button type="submit" 
                class="w-full btn-primary text-white py-3 rounded-lg font-medium mt-2">
                Sign In
            </button>

            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-3 bg-white/85 text-slate-500">or continue with</span>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-3">
                <a href="{{ url('/auth/google') }}" 
                    class="social-btn flex items-center justify-center gap-3 input-glass py-2.5 rounded-lg font-medium text-slate-700 hover:bg-white">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5">
                    <span>Google</span>
                </a>
            </div>
        </form>

        <div class="text-center text-sm text-slate-600 mt-6">
            Don't have an account? 
            <a href="{{ route('signup') }}" class="text-indigo-600 font-medium hover:underline ml-1">Sign up</a>
        </div>
    </div>

    <script>
        // Add animation to form elements
        document.querySelectorAll('input').forEach((input, index) => {
            input.style.transitionDelay = `${index * 50}ms`;
            input.classList.add('opacity-0', '-translate-y-2');
            
            setTimeout(() => {
                input.classList.remove('opacity-0', '-translate-y-2');
                input.classList.add('opacity-100', 'translate-y-0');
            }, 100);
        });

        // Add focus effect to inputs
        const inputs = document.querySelectorAll('.input-glass');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.querySelector('svg').classList.add('text-blue-500');
            });
            input.addEventListener('blur', () => {
                input.parentElement.querySelector('svg').classList.remove('text-blue-500');
            });
        });
    </script>
</body>
</html>