<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-mine-100 dark:bg-zinc-800">
    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('b2b-home') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse"
            wire:navigate='false'>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    wire:navigate='false'>{{ __('Dashboard') }}</flux:navlist.item>
                <flux:navlist.item icon="home" :href="route('reservation.index')"
                    :current="request()->routeIs('reservation.index')" wire:navigate='false'>{{ __('Reservation') }}
                </flux:navlist.item>
                <flux:navlist.item icon="home" :href="route('type.index')"
                    :current="request()->routeIs('type.index')" wire:navigate='false'>{{ __('Membership Type') }}
                </flux:navlist.item>
                <flux:navlist.item icon="home" :href="route('card.index')"
                    :current="request()->routeIs('card.index')" wire:navigate='false'>{{ __('Cards') }}
                </flux:navlist.item>
                <flux:navlist.item icon="home" :href="route('member.index')"
                    :current="request()->routeIs('member.index')" wire:navigate='false'>{{ __('Member') }}
                </flux:navlist.item>
                <flux:navlist.item icon="home" :href="route('redeem.index')"
                    :current="request()->routeIs('redeem.index')" wire:navigate='false'>{{ __('Redeem Reward') }}
                </flux:navlist.item>
                <flux:navlist.item icon="home" :href="route('category.index')"
                    :current="request()->routeIs('category.*')" wire:navigate='false'>{{ __('Categories') }}
                </flux:navlist.item>
                <flux:navlist.item icon="home" :href="route('product.index')"
                    :current="request()->routeIs('product.*')" wire:navigate='false'>{{ __('Products') }}
                </flux:navlist.item>
                <flux:navlist.item icon="banknotes" :href="route('coupon.index')"
                    :current="request()->routeIs('coupon.*')" wire:navigate='false'>{{ __('Coupon') }}
                </flux:navlist.item>
                <flux:navlist.item icon="home" :href="route('transaction.index')"
                    :current="request()->routeIs('transaction.*')" wire:navigate='false'>{{ __('Transaction') }}
                </flux:navlist.item>
                <flux:navlist.item icon="envelope-open" :href="route('newsletter.index')"
                    :current="request()->routeIs('newsletter.*')" wire:navigate='false'>{{ __('Newsletters') }}
                </flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <!-- Desktop User Menu -->
        <flux:dropdown class="hidden lg:block" position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon:trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
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
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate='false'>
                        {{ __('Settings') }}</flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
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

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

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
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate='false'>
                        {{ __('Settings') }}</flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @fluxScripts
</body>

</html>
