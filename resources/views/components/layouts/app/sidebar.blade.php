<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-mine-100 dark:bg-gray-800">
    <div class="flex min-h-screen w-full">
        <!-- 🧭 SIDEBAR -->
        <aside
            class="sidebar w-2/12 stick top-0 bg-[#DFD5BA]  dark:bg-gray-900 flex flex-col justify-between border-r border-gray-200 dark:border-zinc-700">
            <div>
                <!-- Logo -->
                <div class="py-8 flex items-center justify-center border-b border-gray-300 dark:border-zinc-700">
                    <a href="{{ route('b2b-home') }}" class="flex items-center space-x-2 rtl:space-x-reverse">
                        <x-app-logo />
                    </a>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex flex-col px-4 py-6 space-y-2 text-zinc-800 dark:text-zinc-200">
                    <a href="{{ route('dashboard') }}" current="{{ request()->routeIs('dashboard') }}"
                        class="px-3 py-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                        Dashboard
                    </a>
                    <a href="{{ route('reservation.index') }}" current="{{ request()->routeIs('reservation.index') }}"
                        class="px-3 py-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                        Reservation
                    </a>
                    <a href="{{ route('type.index') }}" current="{{ request()->routeIs('type.index') }}"
                        class="px-3 py-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                        Membership Type
                    </a>
                    <a href="{{ route('card.index') }}" current="{{ request()->routeIs('card.index') }}"
                        class="px-3 py-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                        Cards
                    </a>
                    <a href="{{ route('member.index') }}" current="{{ request()->routeIs('member.index') }}"
                        class="px-3 py-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                        Member
                    </a>
                    <a href="{{ route('redeem.index') }}" current="{{ request()->routeIs('redeem.index') }}"
                        class="px-3 py-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                        Redeem Reward
                    </a>
                    <a href="{{ route('outlet.index') }}" current="{{ request()->routeIs('outlet.index') }}"
                        class="px-3 py-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                        Outlets
                    </a>
                    <a href="{{ route('business.index') }}" current="{{ request()->routeIs('business.index') }}"
                        class="px-3 py-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                        Businesses
                    </a>
                    <a href="{{ route('set-category.index') }}"
                        current="{{ request()->routeIs('set-category.index') }}"
                        class="px-3 py-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                        Set Categories
                    </a>
                    <a href="{{ route('category.index') }}" current="{{ request()->routeIs('category.index') }}"
                        class="px-3 py-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                        Categories
                    </a>
                    <a href="{{ route('product.index') }}" current="{{ request()->routeIs('product.index') }}"
                        class="px-3 py-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                        Products
                    </a>
                    <a href="{{ route('coupon.index') }}" current="{{ request()->routeIs('coupon.index') }}"
                        class="px-3 py-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                        Coupon
                    </a>
                    <a href="{{ route('transaction.index') }}" current="{{ request()->routeIs('transaction.*') }}"
                        class="px-3 py-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                        Transaction
                    </a>
                    <a href="{{ route('minimum-order.index') }}" current="{{ request()->routeIs('minimum-order.*') }}"
                        class="px-3 py-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                        Minimum Orders
                    </a>
                    <a href="{{ route('newsletter.index') }}" current="{{ request()->routeIs('newsletter.index') }}"
                        class="px-3 py-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                        Newsletters
                    </a>
                    <a href="{{ route('admin.index') }}" current="{{ request()->routeIs('admin.index') }}"
                        class="px-3 py-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                        Admin
                    </a>
                    <a href="{{ route('setting.index') }}" current="{{ request()->routeIs('setting.index') }}"
                        class="px-3 py-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                        Settings
                    </a>
                </nav>
            </div>


            <!-- Logout or Footer Section -->
            <div class="p-4 border-t border-gray-300 dark:border-zinc-700">
                <button class="w-full py-2 rounded-md bg-red-500 hover:bg-red-600 text-white transition">
                    Logout
                </button>
            </div>
        </aside>

        <!-- 📦 MAIN CONTENT SLOT -->
        <div class="flex-1 overflow-y-auto">
            {{ $slot }}
        </div>

    </div>

    @fluxScripts
</body>

</html>
