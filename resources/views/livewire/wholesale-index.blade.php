<div>
    <div class="bg-center bg-no-repeat bg-cover md:h-[80vh] h-full w-full bg-cover bg-no-repeat"
        style="background-image: url({{ asset('assets/b2b/wholesale/banner.jpg') }})">
        <div class="bg-black/40 w-full h-full bg-opacity-10 py-10 flex justify-center items-center">
            <flux:container class="md:mt-4 mt-12 max-w-6xl">
                <div class="text-center md:text-4xl text-white font-medium">Freshly Baked, Exclusively for Your Business
                </div>
                <div class="mt-4 md:text-xl text-center text-white ">Partner with our bakery to bring premium, oven-fresh
                    products to your shelves or café. Wholesale pricing, consistent supply, and personalized service.
                </div>
            </flux:container>
        </div>
    </div>
    <flux:container class="bg-white px-8 py-8 md:px-12 md:py-12 my-10 rounded-lg shadow-md">
        <div class="flex flex-col md:flex-row gap-6 md:gap-20 justify-between items-center">
            <div class="w-[40%]">
                <img src="/assets/b2b/wholesale/register-image2.jpg" alt="" class="object-cover rounded-lg shadow-md">
            </div>
            <div class="w-[60%]">
                <h3 class="text-4xl">Register Your Account</h3>
                <ol class="list-decimal list-outside pl-4 mt-4 space-y-2 text-gray-700">
                    <li>Register</li>
                    <li>Fill in your business details</li>
                    <li>Upload required documents</li>
                    <li>Wait for admin approval</li>
                    <li>Access your dashboard</li>
                </ol>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row justify-between mt-32 gap-8">
            <!-- Left Content -->
            <div class="flex flex-col justify-between w-full lg:w-2/3 space-y-8 max-h-[500px]">
                <!-- Section 1 -->
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <div
                        class="bg-[#D4A373] text-white rounded-lg p-6 flex flex-col items-start space-y-3 w-full md:w-[240px] shadow-md">
                        <flux:icon.badge-check class="size-10!"></flux:icon.badge-check>
                        <h3 class="font-semibold text-xl">Freshness Guaranteed</h3>
                        <p class="text-sm leading-relaxed">
                            We ensure that all our products are baked fresh daily.
                        </p>
                    </div>
                    <div class="flex-1 text-left">
                        <span class="text-neutral-400 mb-12">7AM Bakery</span>
                        <h3 class="text-4xl font-semibold mb-4 text-gray-800">
                            Perfect Bakery Wholesale Solutions
                        </h3>
                        <p class="text-gray-700 leading-relaxed">
                            Explore our extensive range of freshly baked goods — from artisanal breads to
                            delectable pastries.
                        </p>
                    </div>
                </div>

                <!-- Section 2 -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-[#D4A373] text-white rounded-lg p-6 flex flex-col items-start space-y-3 shadow-md">
                        <flux:icon.badge-check class="size-10!"></flux:icon.badge-check>
                        <h3 class="font-semibold text-xl">Wide Variety</h3>
                        <p class="text-sm leading-relaxed">
                            Choose from breads, pastries, cakes, and more — perfect for any business type.
                        </p>
                    </div>
                    <div class="bg-[#D4A373] text-white rounded-lg p-6 flex flex-col items-start space-y-3 shadow-md">
                        <flux:icon.badge-check class="size-10!"></flux:icon.badge-check>
                        <h3 class="font-semibold text-xl">Reliable Supply</h3>
                        <p class="text-sm leading-relaxed">
                            Count on consistent quality and timely deliveries to keep your stock full.
                        </p>
                    </div>
                    <div class="bg-[#D4A373] text-white rounded-lg p-6 flex flex-col items-start space-y-3 shadow-md">
                        <flux:icon.badge-check class="size-10!"></flux:icon.badge-check>
                        <h3 class="font-semibold text-xl">Partner Benefits</h3>
                        <p class="text-sm leading-relaxed">
                            Enjoy exclusive B2B discounts and priority order handling for registered partners.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Image -->
            <div class="w-full lg:w-1/3 max-h-[500px]">
                <img src="/assets/b2b/wholesale/register-image.jpg" alt="Wholesale Bakery"
                    class="h-full w-full object-cover rounded-lg shadow-md">
            </div>
        </div>
    </flux:container>

</div>
