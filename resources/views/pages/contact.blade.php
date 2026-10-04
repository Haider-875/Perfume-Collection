@extends('layouts.app')

@section('title', 'VIP Fragrance Concierge & Consultations | Perfumes Collection Pakistan')

@section('content')

<!-- Header -->
<section class="py-5 text-center border-bottom border-gold-20" style="background: linear-gradient(to bottom, #18050b, #0d0305, #050203);">
    <div class="container px-3 px-lg-4" style="max-width: 800px;">
        <span class="text-gold fw-semibold d-block mb-3" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase;">PRIVILEGE SERVICE</span>
        <h1 class="font-serif text-light-parchment mb-3 fw-normal display-5">Private Fragrance Concierge</h1>
        <div class="mx-auto mb-4" style="width: 96px; height: 2px; background: linear-gradient(to right, transparent, #d6aa62, transparent);"></div>
        <p class="font-serif text-muted-parchment mx-auto lh-base mb-0" style="font-size: 1.15rem; max-width: 672px;">
            Book a private fragrance consultation with our Master Parfumeur in Lahore, Karachi, or Islamabad, or connect directly on WhatsApp.
        </p>
    </div>
</section>

<!-- Contact Form & Atelier Locations -->
<section class="py-5" style="background-color: #050203;">
    <div class="container px-3 px-lg-4">
        <div class="row g-4 g-lg-5 align-items-start">
            
            <!-- VIP Consultation Request Form (lg:col-7) -->
            <div class="col-12 col-lg-7">
                <div class="bg-wine-card border border-gold-25 rounded-4 p-4 p-md-5 shadow-xl d-flex flex-column gap-4">
                    <div>
                        <span class="text-gold fw-semibold d-block mb-1" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase;">BESPOKE INQUIRY</span>
                        <h2 class="font-serif fs-3 text-light-parchment fw-normal mb-1">Reserve a Private Consultation</h2>
                        <p class="font-serif text-muted-parchment mb-0" style="font-size: 0.95rem;">
                            Whether seeking a custom bridal olfactory pairing, corporate gifting in custom velvet coffrets, or personal signature advice.
                        </p>
                    </div>

                    <form action="{{ route('inquiry.store') }}" method="POST" class="d-flex flex-column gap-3">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label class="d-block text-gold mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Full Name *</label>
                                <input type="text" name="name" required placeholder="e.g. Daniyal Khan" class="form-control form-control-luxury text-xs py-2 px-3">
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="d-block text-gold mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Phone / WhatsApp *</label>
                                <input type="text" name="phone" required placeholder="03XX-XXXXXXX" class="form-control form-control-luxury text-xs py-2 px-3">
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label class="d-block text-gold mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Email Address</label>
                                <input type="email" name="email" placeholder="patron@domain.com" class="form-control form-control-luxury text-xs py-2 px-3">
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="d-block text-gold mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">City in Pakistan *</label>
                                <input type="text" name="city" required placeholder="Lahore, Karachi, Islamabad..." class="form-control form-control-luxury text-xs py-2 px-3">
                            </div>
                        </div>

                        <div>
                            <label class="d-block text-gold mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Nature of Consultation *</label>
                            <select name="inquiry_type" class="form-select form-control-luxury text-xs py-2 px-3">
                                <option value="Fragrance Consultation" class="bg-wine-dark text-light-parchment">Private Scent Profiling (Virtual / In-Store)</option>
                                <option value="Bridal & Wedding Wardrobe" class="bg-wine-dark text-light-parchment">Bridal & Groom Signature Scent Curation</option>
                                <option value="Corporate & VIP Gifting" class="bg-wine-dark text-light-parchment">Corporate Luxury Coffrets & Custom Engraving</option>
                                <option value="Pure Dehn al Oud Sourcing" class="bg-wine-dark text-light-parchment">Rare Vintage Agarwood Oil Acquisition</option>
                            </select>
                        </div>

                        <div>
                            <label class="d-block text-gold mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Your Preferences / Message *</label>
                            <textarea name="message" required rows="4" placeholder="Detail your preferred scent notes, wear occasions, or gifting requirements..." class="form-control form-control-luxury text-xs py-2 px-3"></textarea>
                        </div>

                        <button type="submit" class="w-100 btn-gold py-3 text-xs text-uppercase tracking-widest fw-bold">
                            REQUEST ROYAL CONSULTATION
                        </button>
                    </form>
                </div>
            </div>

            <!-- Atelier Boutiques & Direct Channels (lg:col-5) -->
            <div class="col-12 col-lg-5 d-flex flex-column gap-4">
                <!-- WhatsApp Card -->
                <div class="bg-wine-card border border-gold-25 rounded-4 p-4 p-md-5 shadow-xl d-flex flex-column gap-3">
                    <h3 class="font-serif fs-5 text-gold-soft d-flex align-items-center gap-2 fw-semibold mb-0">
                        <i class="fab fa-whatsapp text-success"></i> Instant WhatsApp Concierge
                    </h3>
                    <p class="text-xs text-muted-parchment lh-base mb-0">
                        Need instant advice on sillage, longevity, or choosing a wedding gift? Our master perfumer is available directly:
                    </p>
                    <a href="https://wa.me/923008765432?text={{ urlencode('Salam! I would like a luxury perfume consultation with Perfumes Collection.') }}" target="_blank" class="w-100 btn-whatsapp py-3 px-4 text-xs text-uppercase tracking-wider text-center d-block text-decoration-none rounded-3">
                        <i class="fab fa-whatsapp me-1"></i> MESSAGE ON WHATSAPP
                    </a>
                </div>

                <!-- Boutiques -->
                <div class="bg-wine-card border border-gold-25 rounded-4 p-4 p-md-5 shadow-xl d-flex flex-column gap-4">
                    <h3 class="font-serif fs-5 text-gold-soft fw-semibold border-bottom border-gold-20 pb-3 mb-0">
                        Atelier Boutiques in Pakistan
                    </h3>

                    <!-- Lahore -->
                    <div class="border-bottom border-gold-15 pb-3">
                        <h4 class="font-serif fs-6 text-light-parchment fw-semibold d-flex align-items-center gap-2 mb-1">
                            <i class="fas fa-landmark text-gold"></i> Lahore Atelier (MM Alam)
                        </h4>
                        <p class="text-xs text-muted-parchment lh-base mb-0">
                            MM Alam Road, Gulberg III, Lahore<br>
                            Hours: Mon - Sun (12:00 PM - 11:00 PM)<br>
                            Tel: +92 300 8765432
                        </p>
                    </div>

                    <!-- Karachi -->
                    <div class="border-bottom border-gold-15 pb-3">
                        <h4 class="font-serif fs-6 text-light-parchment fw-semibold d-flex align-items-center gap-2 mb-1">
                            <i class="fas fa-landmark text-gold"></i> Karachi Gallery (Clifton)
                        </h4>
                        <p class="text-xs text-muted-parchment lh-base mb-0">
                            Clifton Block 4 Gallery, Karachi<br>
                            Hours: Mon - Sun (12:00 PM - 11:00 PM)
                        </p>
                    </div>

                    <!-- Islamabad -->
                    <div>
                        <h4 class="font-serif fs-6 text-light-parchment fw-semibold d-flex align-items-center gap-2 mb-1">
                            <i class="fas fa-landmark text-gold"></i> Islamabad VIP Salon (F-7)
                        </h4>
                        <p class="text-xs text-muted-parchment lh-base mb-0">
                            F-7 Markaz, Jinnah Super, Islamabad<br>
                            Hours: By Prior Private Appointment
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
