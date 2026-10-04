@extends('layouts.app')

@section('title', 'Shipping & Express Delivery Pakistan | Maison d\'Orient')

@section('content')

<section class="py-5" style="background-color: #080304;">
    <div class="container px-3 px-lg-4" style="max-width: 896px;">
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Shipping & Delivery Policy']
        ]" />

        <h1 class="font-serif display-5 text-light-parchment mb-4 fw-normal">
            Shipping & Dispatch Policy (Pakistan)
        </h1>

        <div class="text-light-parchment lh-lg d-flex flex-column gap-4" style="font-size: 0.95rem;">
            <h3 class="fs-5 text-gold font-serif mb-0">1. Express Air Delivery Benchmarks</h3>
            <div class="table-responsive my-3">
                <table class="table border border-gold-30 text-xs text-start align-middle mb-0" style="background-color: #0c0507; color: #f5efe7;">
                    <thead style="background-color: #120709; color: #d6aa62;">
                        <tr>
                            <th class="p-3 border-bottom border-gold-30">Destination City / Zone</th>
                            <th class="p-3 border-bottom border-gold-30">Courier Partner</th>
                            <th class="p-3 border-bottom border-gold-30">Transit Time</th>
                        </tr>
                    </thead>
                    <tbody class="text-muted-parchment">
                        <tr class="border-bottom border-gold-20">
                            <td class="p-3 fw-semibold text-light-parchment">Lahore (Same Day / Next Day)</td>
                            <td class="p-3">Maison Fleet / TCS</td>
                            <td class="p-3 text-gold">12 - 24 Hours</td>
                        </tr>
                        <tr class="border-bottom border-gold-20">
                            <td class="p-3 fw-semibold text-light-parchment">Karachi, Islamabad, Rawalpindi, Faisalabad</td>
                            <td class="p-3">TCS Express Air</td>
                            <td class="p-3 text-gold">24 - 48 Hours</td>
                        </tr>
                        <tr class="border-bottom border-gold-20">
                            <td class="p-3 fw-semibold text-light-parchment">Peshawar, Quetta, Multan, Sialkot, Gujranwala</td>
                            <td class="p-3">TCS / Leopards</td>
                            <td class="p-3 text-gold">48 Hours</td>
                        </tr>
                        <tr>
                            <td class="p-3 fw-semibold text-light-parchment">All Other 300+ Pakistan Cities & Towns</td>
                            <td class="p-3">TCS Express Overland</td>
                            <td class="p-3 text-gold">48 - 72 Hours</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h3 class="fs-5 text-gold font-serif mb-0">2. Free Shipping Privilege</h3>
            <p class="text-muted-parchment mb-0">All orders with a subtotal of <strong>Rs. 4,999 and above</strong> receive complimentary Express Shipping anywhere in Pakistan. For orders below Rs. 4,999, a nominal flat courier fee of Rs. 250 is applied.</p>

            <h3 class="fs-5 text-gold font-serif mb-0">3. Cash on Delivery (COD)</h3>
            <p class="text-muted-parchment mb-0">Cash on Delivery is available with zero surcharge. Please have the exact payment amount ready upon courier arrival.</p>
        </div>
    </div>
</section>

@endsection
