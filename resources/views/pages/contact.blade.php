@extends('layouts.app')

@section('title', 'VIP Fragrance Concierge & Consultations | Perfumes Collection Pakistan')

@section('content')

<!-- Header -->
<section class="py-16 md:py-24 bg-gradient-to-b from-[#18050b] via-[#0d0305] to-[#050203] text-center border-b border-[#d6aa62]/20">
    <div class="container mx-auto px-4 max-w-4xl">
        <span class="text-[11px] uppercase tracking-[0.28em] text-[#d6aa62] font-semibold block mb-3">PRIVILEGE SERVICE</span>
        <h1 class="font-serif text-3xl md:text-5xl lg:text-6xl text-[#f5efe7] mb-4 font-normal">Private Fragrance Concierge</h1>
        <div class="w-24 h-0.5 bg-gradient-to-r from-transparent via-[#d6aa62] to-transparent mx-auto mb-6"></div>
        <p class="font-serif text-lg md:text-xl text-[#b8a9a2] max-w-2xl mx-auto leading-relaxed">
            Book a private fragrance consultation with our Master Parfumeur in Lahore, Karachi, or Islamabad, or connect directly on WhatsApp.
        </p>
    </div>
</section>

<!-- Contact Form & Atelier Locations -->
<section class="py-16 md:py-24 bg-[#050203]">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            <!-- VIP Consultation Request Form (lg:col-span-7) -->
            <div class="lg:col-span-7 bg-[#140408] border border-[#d6aa62]/25 rounded-2xl p-6 md:p-10 shadow-xl space-y-6">
                <div>
                    <span class="text-[11px] uppercase tracking-[0.28em] text-[#d6aa62] font-semibold block mb-1">BESPOKE INQUIRY</span>
                    <h2 class="font-serif text-2xl md:text-3xl text-[#f5efe7] font-normal">Reserve a Private Consultation</h2>
                    <p class="font-serif text-sm md:text-base text-[#b8a9a2] mt-2">
                        Whether seeking a custom bridal olfactory pairing, corporate gifting in custom velvet coffrets, or personal signature advice.
                    </p>
                </div>

                <form action="{{ route('inquiry.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs uppercase tracking-wider text-[#d6aa62] mb-1 font-semibold">Full Name *</label>
                            <input type="text" name="name" required placeholder="e.g. Daniyal Khan" class="w-full bg-[#080204] border border-[#d6aa62]/30 rounded-lg px-4 py-3 text-xs text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:border-[#d6aa62] focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider text-[#d6aa62] mb-1 font-semibold">Phone / WhatsApp *</label>
                            <input type="text" name="phone" required placeholder="03XX-XXXXXXX" class="w-full bg-[#080204] border border-[#d6aa62]/30 rounded-lg px-4 py-3 text-xs text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:border-[#d6aa62] focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs uppercase tracking-wider text-[#d6aa62] mb-1 font-semibold">Email Address</label>
                            <input type="email" name="email" placeholder="patron@domain.com" class="w-full bg-[#080204] border border-[#d6aa62]/30 rounded-lg px-4 py-3 text-xs text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:border-[#d6aa62] focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider text-[#d6aa62] mb-1 font-semibold">City in Pakistan *</label>
                            <input type="text" name="city" required placeholder="Lahore, Karachi, Islamabad..." class="w-full bg-[#080204] border border-[#d6aa62]/30 rounded-lg px-4 py-3 text-xs text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:border-[#d6aa62] focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-wider text-[#d6aa62] mb-1 font-semibold">Nature of Consultation *</label>
                        <select name="inquiry_type" class="w-full bg-[#080204] border border-[#d6aa62]/30 rounded-lg px-4 py-3 text-xs text-[#f5efe7] focus:border-[#d6aa62] focus:outline-none">
                            <option value="Fragrance Consultation" class="bg-[#140408]">Private Scent Profiling (Virtual / In-Store)</option>
                            <option value="Bridal & Wedding Wardrobe" class="bg-[#140408]">Bridal & Groom Signature Scent Curation</option>
                            <option value="Corporate & VIP Gifting" class="bg-[#140408]">Corporate Luxury Coffrets & Custom Engraving</option>
                            <option value="Pure Dehn al Oud Sourcing" class="bg-[#140408]">Rare Vintage Agarwood Oil Acquisition</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-wider text-[#d6aa62] mb-1 font-semibold">Your Preferences / Message *</label>
                        <textarea name="message" required rows="4" placeholder="Detail your preferred scent notes, wear occasions, or gifting requirements..." class="w-full bg-[#080204] border border-[#d6aa62]/30 rounded-lg px-4 py-3 text-xs text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:border-[#d6aa62] focus:outline-none"></textarea>
                    </div>

                    <button type="submit" class="w-full btn-gold py-4 text-xs uppercase tracking-[0.2em] font-bold">
                        REQUEST ROYAL CONSULTATION
                    </button>
                </form>
            </div>

            <!-- Atelier Boutiques & Direct Channels (lg:col-span-5) -->
            <div class="lg:col-span-5 space-y-6">
                <!-- WhatsApp Card -->
                <div class="bg-[#140408] border border-[#d6aa62]/25 rounded-2xl p-6 md:p-8 shadow-xl space-y-4">
                    <h3 class="font-serif text-xl text-[#f0d59d] flex items-center gap-2 font-semibold">
                        <i class="fab fa-whatsapp text-emerald-400"></i> Instant WhatsApp Concierge
                    </h3>
                    <p class="text-xs text-[#b8a9a2] leading-relaxed">
                        Need instant advice on sillage, longevity, or choosing a wedding gift? Our master perfumer is available directly:
                    </p>
                    <a href="https://wa.me/923008765432?text={{ urlencode('Salam! I would like a luxury perfume consultation with Perfumes Collection.') }}" target="_blank" class="w-full btn-whatsapp py-3 px-6 text-xs uppercase tracking-wider text-center block">
                        <i class="fab fa-whatsapp mr-1"></i> MESSAGE ON WHATSAPP
                    </a>
                </div>

                <!-- Boutiques -->
                <div class="bg-[#140408] border border-[#d6aa62]/25 rounded-2xl p-6 md:p-8 shadow-xl space-y-6">
                    <h3 class="font-serif text-xl text-[#f0d59d] font-semibold border-b border-[#d6aa62]/20 pb-3">
                        Atelier Boutiques in Pakistan
                    </h3>

                    <!-- Lahore -->
                    <div class="space-y-1 border-b border-[#d6aa62]/15 pb-4">
                        <h4 class="font-serif text-base text-[#f5efe7] font-semibold flex items-center gap-2">
                            <i class="fas fa-landmark text-[#d6aa62]"></i> Lahore Atelier (MM Alam)
                        </h4>
                        <p class="text-xs text-[#b8a9a2] leading-relaxed">
                            MM Alam Road, Gulberg III, Lahore<br>
                            Hours: Mon - Sun (12:00 PM - 11:00 PM)<br>
                            Tel: +92 300 8765432
                        </p>
                    </div>

                    <!-- Karachi -->
                    <div class="space-y-1 border-b border-[#d6aa62]/15 pb-4">
                        <h4 class="font-serif text-base text-[#f5efe7] font-semibold flex items-center gap-2">
                            <i class="fas fa-landmark text-[#d6aa62]"></i> Karachi Gallery (Clifton)
                        </h4>
                        <p class="text-xs text-[#b8a9a2] leading-relaxed">
                            Clifton Block 4 Gallery, Karachi<br>
                            Hours: Mon - Sun (12:00 PM - 11:00 PM)
                        </p>
                    </div>

                    <!-- Islamabad -->
                    <div class="space-y-1">
                        <h4 class="font-serif text-base text-[#f5efe7] font-semibold flex items-center gap-2">
                            <i class="fas fa-landmark text-[#d6aa62]"></i> Islamabad VIP Salon (F-7)
                        </h4>
                        <p class="text-xs text-[#b8a9a2] leading-relaxed">
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
