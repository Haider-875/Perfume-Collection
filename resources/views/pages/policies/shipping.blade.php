@extends('layouts.app')

@section('title', 'Shipping & Express Delivery Pakistan | Perfumes Collection Pakistan')

@section('content')

<section class="py-5 py-md-6" style="background-color: #F7F3EE;">
    <div class="container px-3 px-sm-4 px-lg-5" style="max-width: 840px;">
        
        <!-- Header (Strictly Center Aligned with Generous Margins & Spacing) -->
        <div class="text-center mx-auto mb-4 mb-md-5" style="max-width: 660px;">
            <!-- Breadcrumbs Component (Simple clean Home link) -->
            <div class="d-flex justify-content-center mb-3">
                <x-breadcrumbs :items="[
                    ['label' => 'Home', 'url' => route('home')]
                ]" />
            </div>

            <!-- Clean Subtitle Text (No badge container, center aligned) -->
            <span class="d-block mb-2 fw-semibold text-center text-uppercase" style="font-size: 11px; letter-spacing: 0.26em; color: #541B29;">
                EXPRESS DISPATCH &amp; LOGISTICS
            </span>

            <!-- Main Heading (Center aligned, responsive typography) -->
            <h1 class="font-serif fw-bold mb-3 text-center" style="color: #211D1E; font-size: clamp(1.4rem, 4vw, 2.25rem); line-height: 1.25; letter-spacing: -0.01em;">
                Shipping &amp; Dispatch Policy
            </h1>

            <p class="mx-auto lh-base fw-light mb-0 text-center" style="max-width: 580px; font-size: clamp(0.88rem, 1.8vw, 0.96rem); color: #6B605B; line-height: 1.7;">
                Our solemn commitment to prompt, temperature-protected fragrance dispatch. Discover express courier benchmarks and complimentary shipping privileges across Pakistan.
            </p>
        </div>

        <!-- Policy Card (Center-Aligned with Generous Margins & Paddings) -->
        <div class="rounded-4 p-4 p-sm-5 shadow-sm text-center mx-auto" style="background-color: #FFFFFF; border: 1px solid #E8E0DA; max-width: 800px;">
            <div class="d-flex flex-column gap-4 gap-md-5">
                
                <!-- Section 1: Benchmarks Table -->
                <div class="pb-4 pb-md-5 text-center" style="border-bottom: 1px solid #F0EAE1;">
                    <h3 class="font-serif mb-3 fw-semibold text-center" style="color: #541B29; font-size: clamp(1.05rem, 2.5vw, 1.2rem);">
                        1. Express Air Delivery Benchmarks
                    </h3>
                    
                    <div class="table-responsive my-3 mx-auto rounded-3 overflow-hidden shadow-xs" style="border: 1px solid #E8E0DA; max-width: 720px;">
                        <table class="table text-xs text-center align-middle mb-0" style="background-color: #FFFFFF; color: #211D1E;">
                            <thead style="background-color: #FAF7F2; color: #541B29;">
                                <tr>
                                    <th class="p-3 fw-semibold text-center" style="border-bottom: 1px solid #E8E0DA; font-size: 11px; letter-spacing: 0.04em;">Destination City / Zone</th>
                                    <th class="p-3 fw-semibold text-center" style="border-bottom: 1px solid #E8E0DA; font-size: 11px; letter-spacing: 0.04em;">Courier Partner</th>
                                    <th class="p-3 fw-semibold text-center" style="border-bottom: 1px solid #E8E0DA; font-size: 11px; letter-spacing: 0.04em;">Transit Time</th>
                                </tr>
                            </thead>
                            <tbody style="color: #514744; font-size: 12px;">
                                <tr style="border-bottom: 1px solid #F0EAE1;">
                                    <td class="p-3 fw-medium" style="color: #211D1E;">Lahore (Express Atelier Dispatch)</td>
                                    <td class="p-3">Dedicated Courier / TCS</td>
                                    <td class="p-3 fw-semibold" style="color: #541B29;">12 &ndash; 24 Hours</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F0EAE1;">
                                    <td class="p-3 fw-medium" style="color: #211D1E;">Karachi, Islamabad, Rawalpindi, Faisalabad</td>
                                    <td class="p-3">TCS Express Air</td>
                                    <td class="p-3 fw-semibold" style="color: #541B29;">24 &ndash; 48 Hours</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F0EAE1;">
                                    <td class="p-3 fw-medium" style="color: #211D1E;">Peshawar, Quetta, Multan, Sialkot, Gujranwala</td>
                                    <td class="p-3">TCS / Leopards Express</td>
                                    <td class="p-3 fw-semibold" style="color: #541B29;">48 Hours</td>
                                </tr>
                                <tr>
                                    <td class="p-3 fw-medium" style="color: #211D1E;">All Other 300+ Pakistan Cities &amp; Towns</td>
                                    <td class="p-3">TCS Express Overland</td>
                                    <td class="p-3 fw-semibold" style="color: #541B29;">48 &ndash; 72 Hours</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 2: Free Shipping -->
                <div class="pb-4 pb-md-5 text-center" style="border-bottom: 1px solid #F0EAE1;">
                    <h3 class="font-serif mb-2.5 fw-semibold text-center" style="color: #541B29; font-size: clamp(1.05rem, 2.5vw, 1.2rem);">
                        2. Complimentary Shipping Privilege
                    </h3>
                    <p class="mb-0 fw-light text-center mx-auto" style="max-width: 640px; font-size: clamp(0.88rem, 1.8vw, 0.95rem); color: #514744; line-height: 1.85;">
                        All orders with a subtotal of <strong style="color: #211D1E;">Rs. 5,000 and above</strong> receive complimentary Express Air shipping anywhere in Pakistan. For orders below Rs. 5,000, standard delivery charges of Rs. 399 are applied at checkout.
                    </p>
                </div>

                <!-- Section 3: COD & Safe Transit -->
                <div class="text-center">
                    <h3 class="font-serif mb-2.5 fw-semibold text-center" style="color: #541B29; font-size: clamp(1.05rem, 2.5vw, 1.2rem);">
                        3. Cash on Delivery (COD) &amp; Safe Transit
                    </h3>
                    <p class="mb-0 fw-light text-center mx-auto" style="max-width: 640px; font-size: clamp(0.88rem, 1.8vw, 0.95rem); color: #514744; line-height: 1.85;">
                        Insured Cash on Delivery (COD) is available nationwide with zero surcharge. Each perfume flacon is cushioned inside specialized shock-absorbent and heat-protected packaging to guarantee pristine arrival.
                    </p>
                </div>

            </div>
        </div>

        <!-- Trust Note at Bottom (Center Aligned with generous top margin) -->
        <div class="text-center mt-4 mt-md-5">
            <span class="d-block text-xs fw-medium text-center" style="color: #786C67; font-size: 12px; letter-spacing: 0.04em;">
                Insured nationwide dispatch &bull; 100% temperature-protected luxury courier packaging
            </span>
        </div>

    </div>
</section>

@endsection
