<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="bg-[#E8E1D7] dark:bg-gray-800 min-h-screen static font-poppins">
    <nav
        class="fixed top-4 left-1/2 max-w-7xl -translate-x-1/2 w-[98%] z-50 bg-white dark:bg-gray-700 shadow-md rounded-xl px-6 py-6 flex items-center justify-between">
        <a href="{{ route('b2b-home') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0"
            wire:navigate>
            <x-app-logo />
        </a>

        <ul class="flex items-center space-x-4 mr-8 h-[40px]">
            <li><a href="{{ route('b2b-home') }}" current="{{ request()->routeIs('home') }}">Home</a></li>
            <li><a href="{{ route('shop.index') }}" current="{{ request()->routeIs('shop.*') }}">Shop</a></li>
            <li><a href="{{ route('contact') }}" current="{{ request()->routeIs('contact') }}">Contact</a></li>
            <li><a href="{{ route('wholesale.index') }}" current="{{ request()->routeIs('wholesale.*') }}">Wholesale</a>
            </li>
            @auth
                <li><a href="{{ route('history') }}" current="{{ request()->routeIs('history') }}">History</a></li>
                {{-- <li><a href="{{ route('checkout') }}" current="{{ request()->routeIs('checkout') }}">Checkout</a></li> --}}
            @endauth
        </ul>

        @guest
            <ul class="flex space-x-4">
                <li><a class="bg-[#D4A373] hover:bg-[#b8875c] dark:bg-gray-500 dark:hover:bg-gray-800 text-white px-8 py-2 rounded-2xl transition"
                        href="{{ route('login') }}" current="{{ request()->routeIs('login') }}">Login</a></li>
            </ul>
        @endguest

        @auth
            {{-- <flux:navbar variant="outline">
                <flux:navlist.item icon="shopping-bag" square="true" :href="route('cart')"
                    :active="request()->routeIs('cart')">
                </flux:navlist.item>

                <!-- Desktop User Menu -->
                <flux:dropdown position="top" align="end">
                    <flux:profile class="cursor-pointer" :initials="auth()->user()->initials()" />

                    <flux:menu>
                        <flux:menu.radio.group>
                            <div class="p-0 text-sm font-normal">
                                <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                        <span
                                            class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>

                                    <div class="grid flex-1 text-start text-sm leading-tight">
                                        <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                        <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                        <span class="truncate text-xs">{{ auth()->user()->role }}</span>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                                {{ __('Settings') }}
                            </flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                class="w-full">
                                {{ __('Log Out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </flux:navbar> --}}
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <a href="{{ route('cart') }}" active="{{ request()->routeIs('cart') }}">
                    <flux:icon icon="shopping-bag" variant="outline" class="" />
                </a>

                <flux:dropdown position="top" align="end">
                    <flux:profile class="cursor-pointer" :initials="auth()->user()->initials()" />

                    <flux:menu>
                        <flux:menu.radio.group>
                            <div class="p-0 text-sm font-normal">
                                <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                        <span
                                            class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>

                                    <div class="grid flex-1 text-start text-sm leading-tight">
                                        <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                        <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                        <span class="truncate text-xs">{{ auth()->user()->role }}</span>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                                {{ __('Settings') }}
                            </flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('settings.bussiness-info')" icon="home-modern" wire:navigate>
                                {{ __('Business Info') }}
                            </flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                class="w-full">
                                {{ __('Log Out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </div>
        @endauth
    </nav>

    <div class="min-h-[55vh]">
        {{ $slot }}
    </div>

    @livewire('footer')
    @livewire('copyright')

    <script class="script"></script>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {

            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByClassName("script")[0] || document.body.lastChild;
                s1.async = true;
                s1.src = 'https://embed.tawk.to/6906c8f74a15fd1950a7e444/1j919lnua';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        });
    </script>
    <!--End of Tawk.to Script-->

    @fluxScripts

</body>

</html>
