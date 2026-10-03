@extends('layouts.app')

@section('title', 'VIP Fragrance Concierge & Consultations | Maison d\'Orient Pakistan')

@section('content')

<!-- Header -->
<section style="padding: 70px 0 50px; background: linear-gradient(180deg, #16131A 0%, #0A0A0C 100%); text-align: center; border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <span class="section-pretitle">PRIVILEGE SERVICE</span>
        <h1 style="font-size: 3rem; margin-bottom: 14px;">Private Fragrance Concierge</h1>
        <div class="section-divider">
            <span class="line"></span>
            <i class="fas fa-crown"></i>
            <span class="line"></span>
        </div>
        <p style="font-family: var(--font-serif); font-size: 1.25rem; color: var(--gold-champagne); max-width: 680px; margin: 0 auto; line-height: 1.6;">
            Book a private fragrance consultation with our Master Parfumeur in Lahore, Karachi, or Islamabad, or connect directly on WhatsApp.
        </p>
    </div>
</section>

<!-- Contact Form & Atelier Locations -->
<section style="padding: 80px 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 60px; align-items: start;">
            
            <!-- VIP Consultation Request Form -->
            <div style="background: var(--bg-card); border: 1px solid var(--border-gold); border-radius: var(--radius-md); padding: 40px;">
                <span class="section-pretitle">BESPOKE INQUIRY</span>
                <h2 style="font-size: 1.8rem; margin-bottom: 10px;">Reserve a Private Consultation</h2>
                <p style="font-family: var(--font-serif); font-size: 1.05rem; color: var(--text-sub); margin-bottom: 28px;">
                    Whether seeking a custom bridal olfactory pairing, corporate gifting in custom velvet coffrets, or personal signature advice.
                </p>

                <form action="{{ route('inquiry.store') }}" method="POST">
                    @csrf
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                        <div>
                            <label style="display: block; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 6px;">Full Name *</label>
                            <input type="text" name="name" required placeholder="e.g. Daniyal Khan" style="width: 100%; background: #0E0E12; border: 1px solid var(--border-subtle); padding: 12px; border-radius: 4px; color: #FFF; font-size: 0.9rem;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 6px;">Phone / WhatsApp *</label>
                            <input type="text" name="phone" required placeholder="03XX-XXXXXXX" style="width: 100%; background: #0E0E12; border: 1px solid var(--border-subtle); padding: 12px; border-radius: 4px; color: #FFF; font-size: 0.9rem;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                        <div>
                            <label style="display: block; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 6px;">Email Address</label>
                            <input type="email" name="email" placeholder="patron@domain.com" style="width: 100%; background: #0E0E12; border: 1px solid var(--border-subtle); padding: 12px; border-radius: 4px; color: #FFF; font-size: 0.9rem;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 6px;">City *</label>
                            <input type="text" name="city" required placeholder="Lahore, Karachi, Islamabad..." style="width: 100%; background: #0E0E12; border: 1px solid var(--border-subtle); padding: 12px; border-radius: 4px; color: #FFF; font-size: 0.9rem;">
                        </div>
                    </div>

                    <div style="margin-bottom: 18px;">
                        <label style="display: block; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 6px;">Nature of Consultation *</label>
                        <select name="inquiry_type" style="width: 100%; background: #0E0E12; border: 1px solid var(--border-subtle); padding: 12px; border-radius: 4px; color: var(--gold-champagne); font-size: 0.9rem; font-weight: 600;">
                            <option value="Fragrance Consultation">Private Scent Profiling (Virtual / In-Store)</option>
                            <option value="Bridal & Wedding Wardrobe">Bridal & Groom Signature Scent Curation</option>
                            <option value="Corporate & VIP Gifting">Corporate Luxury Coffrets & Custom Engraving</option>
                            <option value="Pure Dehn al Oud Sourcing">Rare Vintage Agarwood Oil Acquisition</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 6px;">Your Preferences / Message *</label>
                        <textarea name="message" required rows="4" placeholder="Detail your preferred scent notes, wear occasions, or gifting requirements..." style="width: 100%; background: #0E0E12; border: 1px solid var(--border-subtle); padding: 12px; border-radius: 4px; color: #FFF; font-size: 0.9rem;"></textarea>
                    </div>

                    <button type="submit" class="btn-gold" style="width: 100%;">REQUEST ROYAL CONSULTATION</button>
                </form>
            </div>

            <!-- Atelier Boutiques & Direct Channels -->
            <div>
                <div style="background: var(--bg-card); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 30px; margin-bottom: 24px;">
                    <h3 style="font-size: 1.25rem; color: var(--gold-champagne); margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="fab fa-whatsapp" style="color: #25D366;"></i> Instant WhatsApp Concierge
                    </h3>
                    <p style="font-size: 0.88rem; color: var(--text-sub); line-height: 1.6; margin-bottom: 18px;">
                        Need instant advice on sillage, longevity, or choosing a wedding gift? Our master perfumer is available directly:
                    </p>
                    <a href="https://wa.me/923001234567?text={{ urlencode('Salam! I would like a luxury perfume consultation.') }}" target="_blank" class="btn-whatsapp" style="width: 100%; justify-content: center;">
                        <i class="fab fa-whatsapp"></i> MESSAGE +92 300 1234567
                    </a>
                </div>

                <!-- Boutiques -->
                <div style="background: var(--bg-card); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 30px;">
                    <h3 style="font-size: 1.25rem; color: var(--gold-champagne); margin-bottom: 20px;">
                        Atelier Boutiques in Pakistan
                    </h3>

                    <!-- Lahore -->
                    <div style="margin-bottom: 20px; border-bottom: 1px solid var(--border-subtle); padding-bottom: 16px;">
                        <h4 style="font-size: 1.05rem; color: var(--text-ivory); margin-bottom: 4px;">
                            <i class="fas fa-landmark text-gold"></i> Lahore Atelier (MM Alam)
                        </h4>
                        <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.5;">
                            Suite 402, MM Alam Road, Gulberg III, Lahore<br>
                            Hours: Mon - Sun (12:00 PM - 11:00 PM)<br>
                            Tel: +92 (42) 3578-9000
                        </p>
                    </div>

                    <!-- Karachi -->
                    <div style="margin-bottom: 20px; border-bottom: 1px solid var(--border-subtle); padding-bottom: 16px;">
                        <h4 style="font-size: 1.05rem; color: var(--text-ivory); margin-bottom: 4px;">
                            <i class="fas fa-landmark text-gold"></i> Karachi Gallery (Clifton)
                        </h4>
                        <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.5;">
                            Ocean Mall & Clifton Block 4 Gallery, Karachi<br>
                            Hours: Mon - Sun (12:00 PM - 11:00 PM)<br>
                            Tel: +92 (21) 3583-4000
                        </p>
                    </div>

                    <!-- Islamabad -->
                    <div>
                        <h4 style="font-size: 1.05rem; color: var(--text-ivory); margin-bottom: 4px;">
                            <i class="fas fa-landmark text-gold"></i> Islamabad VIP Salon (F-7)
                        </h4>
                        <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.5;">
                            F-7 Markaz, Jinnah Super, Islamabad<br>
                            Hours: By Prior Private Appointment<br>
                            Tel: +92 (51) 2654-3210
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
