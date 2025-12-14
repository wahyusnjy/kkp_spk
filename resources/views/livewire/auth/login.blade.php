<x-layouts.auth>
    <div class="w-full max-w-md">
        {{-- Logo & Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-600 to-blue-700 mb-4 shadow-2xl">
                <i class="fas fa-chart-line text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">SPK Supplier</h1>
            <p class="text-gray-400">Sistem Pendukung Keputusan Pemilihan Supplier</p>
        </div>

        {{-- Login Card --}}
        <div class="bg-gray-800 rounded-2xl shadow-2xl border border-gray-700 p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-white mb-2">Welcome Back!</h2>
                <p class="text-gray-400 text-sm">Silakan login untuk mengakses sistem</p>
            </div>

            {{-- Session Status --}}
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login.store') }}" class="space-y-6">
                @csrf

                {{-- Email Address --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-envelope mr-2 text-blue-400"></i>Email Address
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="nama@email.com"
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    />
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-medium text-gray-300">
                            <i class="fas fa-lock mr-2 text-blue-400"></i>Password
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-blue-400 hover:text-blue-300 transition">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        />
                        <button
                            type="button"
                            onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-300 transition"
                        >
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center">
                    <input
                        id="remember"
                        type="checkbox"
                        name="remember"
                        {{ old('remember') ? 'checked' : '' }}
                        class="w-4 h-4 bg-gray-700 border-gray-600 rounded text-blue-600 focus:ring-2 focus:ring-blue-500"
                    />
                    <label for="remember" class="ml-2 text-sm text-gray-300">
                        Ingat saya
                    </label>
                </div>

                {{-- Login Button --}}
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl flex items-center justify-center gap-2"
                    data-test="login-button"
                >
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </button>
            </form>

            {{-- Register Link --}}
            @if (Route::has('register'))
                <div class="mt-6 pt-6 border-t border-gray-700">
                    <p class="text-center text-gray-400 text-sm">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-semibold transition ml-1">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
            @endif
        </div>

        {{-- Footer --}}
        <div class="mt-8 text-center">
            <p class="text-gray-500 text-sm">
                © {{ date('Y') }} SPK Supplier. All rights reserved.
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Add subtle animation on load
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.bg-gray-800');
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</x-layouts.auth>
