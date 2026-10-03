@extends('layouts.app')

@section('title', 'Shipping & Express Delivery Pakistan | Maison d\'Orient')

@section('content')

<section class="py-16 md:py-24 bg-[#080304]">
    <div class="container max-w-4xl mx-auto">
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Shipping & Delivery Policy']
        ]" />

        <h1 class="font-serif text-3xl md:text-5xl text-[#F5EFE6] mb-8 font-normal">
            Shipping & Dispatch Policy (Pakistan)
        </h1>

        <div class="prose prose-invert max-w-none text-[#F5EFE6]/80 text-sm md:text-base leading-relaxed space-y-6">
            <h3 class="text-lg text-[#C9A24B] font-serif">1. Express Air Delivery Benchmarks</h3>
            <div class="overflow-x-auto my-6">
                <table class="w-full border border-[#C9A24B]/30 text-xs md:text-sm text-left">
                    <thead class="bg-[#120709] text-[#C9A24B]">
                        <tr>
                            <th class="p-3 border-b border-[#C9A24B]/30">Destination City / Zone</th>
                            <th class="p-3 border-b border-[#C9A24B]/30">Courier Partner</th>
                            <th class="p-3 border-b border-[#C9A24B]/30">Transit Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#C9A24B]/15">
                        <tr>
                            <td class="p-3 font-semibold text-[#F5EFE6]">Lahore (Same Day / Next Day)</td>
                            <td class="p-3">Maison Fleet / TCS</td>
                            <td class="p-3 text-[#C9A24B]">12 - 24 Hours</td>
                        </tr>
                        <tr>
                            <td class="p-3 font-semibold text-[#F5EFE6]">Karachi, Islamabad, Rawalpindi, Faisalabad</td>
                            <td class="p-3">TCS Express Air</td>
                            <td class="p-3 text-[#C9A24B]">24 - 48 Hours</td>
                        </tr>
                        <tr>
                            <td class="p-3 font-semibold text-[#F5EFE6]">Peshawar, Quetta, Multan, Sialkot, Gujranwala</td>
                            <td class="p-3">TCS / Leopards</td>
                            <td class="p-3 text-[#C9A24B]">48 Hours</td>
                        </tr>
                        <tr>
                            <td class="p-3 font-semibold text-[#F5EFE6]">All Other 300+ Pakistan Cities & Towns</td>
                            <td class="p-3">TCS Express Overland</td>
                            <td class="p-3 text-[#C9A24B]">48 - 72 Hours</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h3 class="text-lg text-[#C9A24B] font-serif">2. Free Shipping Privilege</h3>
            <p>All orders with a subtotal of <strong>Rs. 4,999 and above</strong> receive complimentary Express Shipping anywhere in Pakistan. For orders below Rs. 4,999, a nominal flat courier fee of Rs. 250 is applied.</p>

            <h3 class="text-lg text-[#C9A24B] font-serif">3. Cash on Delivery (COD)</h3>
            <p>Cash on Delivery is available with zero surcharge. Please have the exact payment amount ready upon courier arrival.</p>
        </div>
    </div>
</section>

@endsection
