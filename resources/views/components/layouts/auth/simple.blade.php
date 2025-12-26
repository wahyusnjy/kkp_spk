<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<script>
    // Apply theme immediately to prevent flash
    (function() {
        const savedTheme = localStorage.getItem('theme') || 'dark';
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    })();
</script>
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-gradient-to-br dark:from-gray-900 dark:via-blue-900 dark:to-gray-900">
        <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 via-blue-50 to-gray-50 dark:from-gray-900 dark:via-blue-900 dark:to-gray-900 p-4">
            {{-- Theme Toggle Button - Fixed Position --}}
            <div class="fixed top-4 right-4 z-50">
                <button 
                    type="button"
                    data-theme-toggle
                    class="flex items-center justify-center rounded-full p-3 shadow-lg transition-all bg-white dark:bg-zinc-800 hover:scale-110"
                    title="Toggle Theme"
                >
                    <i class="fa-solid fa-sun text-xl text-gray-700 dark:text-gray-200"></i>
                </button>
            </div>

            <div class="flex w-full max-w-sm flex-col gap-2">
                <div class="">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
