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
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="sticky top-0 h-screen border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Dashboard')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                </flux:navlist.group> 
                
                @if(auth()->user()->role === 'admin')
                {{-- Masters - Only Admin --}}
                <flux:navlist.group :heading="__('Masters')" class="grid">
                    <flux:navlist.item icon="clipboard-document-list" :href="route('kriteria.index')" :current="request()->routeIs('kriteria.*')" wire:navigate>{{ __('Kriterias') }}</flux:navlist.item>
                    <flux:navlist.item icon="circle-stack" :href="route('supplier.index')" :current="request()->routeIs('supplier.*')" wire:navigate>{{ __('Suppliers') }}</flux:navlist.item>
                    <flux:navlist.item icon="square-3-stack-3d" :href="route('material.index')" :current="request()->routeIs('material.*')" wire:navigate>{{ __('Materials') }}</flux:navlist.item>
                    <flux:navlist.item icon="users" :href="route('users.index')" :current="request()->routeIs('users.*')" wire:navigate>{{ __('Users') }}</flux:navlist.item>
                </flux:navlist.group>
                @endif
                
                {{-- Evaluation - Both Roles --}}
                <flux:navlist.group :heading="__('Evaluation')" class="grid">
                    <flux:navlist.item icon="clipboard-document-check" :href="route('assessments.index')" :current="request()->routeIs('assessments.*')" wire:navigate>{{ __('Assessments') }}</flux:navlist.item>
                </flux:navlist.group>
                
                {{-- Reports - Both Roles --}}
                <flux:navlist.group :heading="__('Reports')" class="grid">
                    <flux:navlist.item icon="document-chart-bar" :href="route('reports.suppliers')" :current="request()->routeIs('reports.suppliers')" wire:navigate>{{ __('Supplier Reports') }}</flux:navlist.item>
                    <flux:navlist.item icon="clipboard-document-list" :href="route('reports.assessments')" :current="request()->routeIs('reports.assessments')" wire:navigate>{{ __('Assessment Reports') }}</flux:navlist.item>
                    <flux:navlist.item icon="circle-stack" :href="route('reports.kriteria')" :current="request()->routeIs('reports.kriteria')" wire:navigate>{{ __('Kriteria Reports') }}</flux:navlist.item>
                    <flux:navlist.item icon="square-3-stack-3d" :href="route('reports.material')" :current="request()->routeIs('reports.material')" wire:navigate>{{ __('Material Reports') }}</flux:navlist.item>
                    <flux:navlist.item icon="presentation-chart-line" :href="route('reports.executive-summary')" :current="request()->routeIs('reports.executive-summary')" wire:navigate>{{ __('Executive Summaries') }}</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            {{-- Theme Toggle Button --}}
                {{-- <div class="px-2 pb-2">
                    <button 
                        type="button"
                        data-theme-toggle
                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors hover:bg-zinc-200 dark:hover:bg-zinc-800"
                        title="Toggle Theme"
                    >
                        <i class="fa-solid fa-sun w-5 text-center"></i>
                        <span>Toggle Theme</span>
                    </button>
                </div> --}}

            <flux:navlist variant="outline">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:navlist>

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                    data-test="sidebar-menu-button"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            {{-- Theme Toggle for Mobile --}}
            <button 
                type="button"
                data-theme-toggle
                class="flex items-center justify-center rounded-lg p-2 transition-colors hover:bg-zinc-200 dark:hover:bg-zinc-800"
                title="Toggle Theme"
            >
                <i class="fa-solid fa-sun text-lg"></i>
            </button>

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
        @yield('scripts')
    </body>
</html>
