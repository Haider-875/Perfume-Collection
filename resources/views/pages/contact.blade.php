@extends('layouts.app')

@section('title', 'VIP Fragrance Concierge & Consultations | Perfumes Collection Pakistan')

@section('content')

<!-- Header -->
<section class="py-5 text-center" style="background-color: #FAF7F2; border-bottom: 1px solid #E8E0DA;">
    <div class="container px-3 px-lg-4" style="max-width: 800px;">
        <span class="fw-semibold d-block mb-3" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase; color: #541B29;">PRIVILEGE SERVICE</span>
        <h1 class="font-serif mb-3 fw-normal display-5" style="color: #211D1E;">Private Fragrance Concierge</h1>
        <div class="mx-auto mb-4" style="width: 96px; height: 2px; background-color: #9E7D3B;"></div>
        <p class="font-serif mx-auto lh-base mb-0" style="font-size: 1.15rem; max-width: 672px; color: #6B605B;">
            Book a private fragrance consultation with our Master Parfumeur in Lahore, Karachi, or Islamabad, or connect directly on WhatsApp.
        </p>
    </div>
</section>

<!-- Contact Form & Atelier Locations -->
<section class="py-5" style="background-color: #F7F3EE;">
    <div class="container px-3 px-lg-4">
        <div class="row g-4 g-lg-5 align-items-start">
            
            <!-- VIP Consultation Request Form (lg:col-7) -->
            <div class="col-12 col-lg-7">
                <div class="rounded-4 p-4 p-md-5 shadow-sm d-flex flex-column gap-4" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <div>
                        <span class="fw-semibold d-block mb-1" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase; color: #541B29;">BESPOKE INQUIRY</span>
                        <h2 class="font-serif fs-3 fw-normal mb-1" style="color: #211D1E;">Reserve a Private Consultation</h2>
                        <p class="font-serif mb-0" style="font-size: 0.95rem; color: #6B605B;">
                            Whether seeking a custom bridal olfactory pairing, corporate gifting in custom velvet coffrets, or personal signature advice.
                        </p>
                    </div>

                    <form action="{{ route('inquiry.store') }}" method="POST" class="d-flex flex-column gap-3">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label class="d-block mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #541B29;">Full Name *</label>
                                <input type="text" name="name" required placeholder="e.g. Daniyal Khan" class="form-control text-xs py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="d-block mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #541B29;">Phone / WhatsApp *</label>
                                <input type="text" name="phone" required placeholder="03XX-XXXXXXX" class="form-control text-xs py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label class="d-block mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #541B29;">Email Address</label>
                                <input type="email" name="email" placeholder="patron@domain.com" class="form-control text-xs py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="d-block mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #541B29;">City in Pakistan *</label>
                                <input type="text" name="city" required placeholder="Lahore, Karachi, Islamabad..." class="form-control text-xs py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                            </div>
                        </div>

                        <div>
                            <label class="d-block mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #541B29;">Nature of Consultation *</label>
                            <select name="inquiry_type" class="form-select text-xs py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                                <option value="Fragrance Consultation">Private Scent Profiling (Virtual / In-Store)</option>
                                <option value="Bridal & Wedding Wardrobe">Bridal & Groom Signature Scent Curation</option>
                                <option value="Corporate & VIP Gifting">Corporate Luxury Coffrets & Custom Engraving</option>
                                <option value="Pure Dehn al Oud Sourcing">Rare Vintage Agarwood Oil Acquisition</option>
                            </select>
                        </div>

                        <div>
                            <label class="d-block mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #541B29;">Your Preferences / Message *</label>
                            <textarea name="message" required rows="4" placeholder="Detail your preferred scent notes, wear occasions, or gifting requirements..." class="form-control text-xs py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;"></textarea>
                        </div>

                        <button type="submit" class="w-100 btn-gold py-3 text-xs text-uppercase tracking-widest fw-bold" style="border-radius: 8px;">
                            REQUEST ROYAL CONSULTATION
                        </button>
                    </form>
                </div>
            </div>

            <!-- Atelier Boutiques & Direct Channels (lg:col-5) -->
            <div class="col-12 col-lg-5 d-flex flex-column gap-4">
                <!-- WhatsApp Card -->
                <div class="rounded-4 p-4 p-md-5 shadow-sm d-flex flex-column gap-3" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <h3 class="font-serif fs-5 d-flex align-items-center gap-2 fw-semibold mb-0" style="color: #211D1E;">
                        <i class="fab fa-whatsapp text-success"></i> Instant WhatsApp Concierge
                    </h3>
                    <p class="text-xs lh-base mb-0" style="color: #6B605B;">
                        Need instant advice on sillage, longevity, or choosing a wedding gift? Our master perfumer is available directly:
                    </p>
                    <a href="https://wa.me/923363685732?text={{ urlencode('Salam! I would like a luxury perfume consultation with Perfumes Collection.') }}" target="_blank" class="w-100 btn-whatsapp py-3 px-4 text-xs text-uppercase tracking-wider text-center d-block text-decoration-none rounded-3">
                        <i class="fab fa-whatsapp me-1"></i> MESSAGE ON WHATSAPP (+92 336 3685732)
                    </a>
                </div>

                <!-- Boutiques -->
                <div class="rounded-4 p-4 p-md-5 shadow-sm d-flex flex-column gap-4" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <h3 class="font-serif fs-5 fw-semibold pb-3 mb-0" style="color: #211D1E; border-bottom: 1px solid #E8E0DA;">
                        Atelier Boutiques in Pakistan
                    </h3>

                    <!-- Lahore -->
                    <div class="pb-3" style="border-bottom: 1px solid #E8E0DA;">
                        <h4 class="font-serif fs-6 fw-semibold d-flex align-items-center gap-2 mb-1" style="color: #541B29;">
                            <i class="fas fa-landmark" style="color: #9E7D3B;"></i> Lahore Atelier (MM Alam)
                        </h4>
                        <p class="text-xs lh-base mb-0" style="color: #6B605B;">
                            MM Alam Road, Gulberg III, Lahore<br>
                            Hours: Mon - Sun (12:00 PM - 11:00 PM)<br>
                            WhatsApp: +92 336 3685732
                        </p>
                    </div>

                    <!-- Karachi -->
                    <div class="pb-3" style="border-bottom: 1px solid #E8E0DA;">
                        <h4 class="font-serif fs-6 fw-semibold d-flex align-items-center gap-2 mb-1" style="color: #541B29;">
                            <i class="fas fa-landmark" style="color: #9E7D3B;"></i> Karachi Gallery (Clifton)
                        </h4>
                        <p class="text-xs lh-base mb-0" style="color: #6B605B;">
                            Clifton Block 4 Gallery, Karachi<br>
                            Hours: Mon - Sun (1:00 PM - 11:30 PM)<br>
                            WhatsApp: +92 336 3685732
                        </p>
                    </div>

                    <!-- Islamabad -->
                    <div>
                        <h4 class="font-serif fs-6 fw-semibold d-flex align-items-center gap-2 mb-1" style="color: #541B29;">
                            <i class="fas fa-landmark" style="color: #9E7D3B;"></i> Islamabad VIP Salon (F-7)
                        </h4>
                        <p class="text-xs lh-base mb-0" style="color: #6B605B;">
                            F-7 Markaz, Jinnah Super, Islamabad<br>
                            Hours: Mon - Sun (12:00 PM - 11:00 PM)<br>
                            WhatsApp: +92 336 3685732
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
