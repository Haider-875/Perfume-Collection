@extends('layouts.app')

@section('title', 'Shipping & Express Delivery Pakistan | Maison d\'Orient')

@section('content')

<section class="py-5" style="background-color: #F7F3EE;">
    <div class="container px-3 px-lg-4" style="max-width: 896px;">
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Shipping & Delivery Policy']
        ]" />

        <div class="rounded-4 p-4 p-md-5 shadow-sm mt-3" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
            <h1 class="font-serif display-5 mb-4 fw-normal" style="color: #211D1E;">
                Shipping & Dispatch Policy (Pakistan)
            </h1>

            <div class="lh-lg d-flex flex-column gap-4" style="font-size: 0.95rem; color: #514744;">
                <h3 class="fs-5 font-serif mb-0 fw-semibold" style="color: #541B29;">1. Express Air Delivery Benchmarks</h3>
                <div class="table-responsive my-2">
                    <table class="table text-xs text-start align-middle mb-0" style="background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #211D1E;">
                        <thead style="background-color: #FAF7F2; color: #541B29;">
                            <tr>
                                <th class="p-3" style="border-bottom: 1px solid #E8E0DA;">Destination City / Zone</th>
                                <th class="p-3" style="border-bottom: 1px solid #E8E0DA;">Courier Partner</th>
                                <th class="p-3" style="border-bottom: 1px solid #E8E0DA;">Transit Time</th>
                            </tr>
                        </thead>
                        <tbody style="color: #514744;">
                            <tr style="border-bottom: 1px solid #E8E0DA;">
                                <td class="p-3 fw-semibold" style="color: #211D1E;">Lahore (Same Day / Next Day)</td>
                                <td class="p-3">Maison Fleet / TCS</td>
                                <td class="p-3 fw-medium" style="color: #541B29;">12 - 24 Hours</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #E8E0DA;">
                                <td class="p-3 fw-semibold" style="color: #211D1E;">Karachi, Islamabad, Rawalpindi, Faisalabad</td>
                                <td class="p-3">TCS Express Air</td>
                                <td class="p-3 fw-medium" style="color: #541B29;">24 - 48 Hours</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #E8E0DA;">
                                <td class="p-3 fw-semibold" style="color: #211D1E;">Peshawar, Quetta, Multan, Sialkot, Gujranwala</td>
                                <td class="p-3">TCS / Leopards</td>
                                <td class="p-3 fw-medium" style="color: #541B29;">48 Hours</td>
                            </tr>
                            <tr>
                                <td class="p-3 fw-semibold" style="color: #211D1E;">All Other 300+ Pakistan Cities & Towns</td>
                                <td class="p-3">TCS Express Overland</td>
                                <td class="p-3 fw-medium" style="color: #541B29;">48 - 72 Hours</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3 class="fs-5 font-serif mb-0 fw-semibold" style="color: #541B29;">2. Free Shipping Privilege</h3>
                <p class="mb-0">All orders with a subtotal of <strong style="color: #211D1E;">Rs. 4,999 and above</strong> receive complimentary Express Shipping anywhere in Pakistan. For orders below Rs. 4,999, a nominal flat courier fee of Rs. 250 is applied.</p>

                <h3 class="fs-5 font-serif mb-0 fw-semibold" style="color: #541B29;">3. Cash on Delivery (COD)</h3>
                <p class="mb-0">Cash on Delivery is available with zero surcharge. Please have the exact payment amount ready upon courier arrival.</p>
            </div>
        </div>
    </div>
</section>

@endsection
