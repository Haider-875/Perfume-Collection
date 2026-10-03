@props(['bundle'])

<div class="bundle-card" style="background: var(--bg-card); border: 1px solid var(--border-gold); border-radius: var(--radius-lg); padding: 30px; position: relative; display: flex; flex-direction: column; box-shadow: var(--shadow-card); transition: var(--transition-smooth);">
    
    <!-- Top Savings Badge -->
    <div style="position: absolute; top: 18px; left: 18px; z-index: 5;">
        <span class="badge-luxury" style="background: linear-gradient(135deg, #801313, #B03A2E); color: #FFF; font-size: 0.72rem; padding: 5px 12px; border-radius: 3px; font-weight: 700;">
            {{ $bundle->badge_text ?? 'SAVE RS. ' . number_format($bundle->savings_amount, 0) }}
        </span>
    </div>

    <!-- Image Preview -->
    <div style="background: radial-gradient(circle, rgba(201, 162, 75, 0.12) 0%, rgba(8, 3, 4, 0.7) 70%); border-radius: var(--radius-md); padding: 24px; text-align: center; margin-bottom: 20px;">
        <img src="{{ $bundle->image_url }}" alt="{{ $bundle->name }}" style="max-height: 220px; width: auto; filter: drop-shadow(0 15px 25px rgba(0,0,0,0.85)); transition: transform 0.5s ease;">
    </div>

    <!-- Bundle Title & Tagline -->
    <h3 style="font-size: 1.35rem; margin-bottom: 8px; color: var(--text-ivory); font-family: var(--font-heading);">
        {{ $bundle->name }}
    </h3>
    <p style="font-family: var(--font-serif); font-size: 1rem; color: var(--gold-champagne); font-style: italic; margin-bottom: 16px;">
        "{{ $bundle->tagline }}"
    </p>

    <!-- Included Flacons Breakdown -->
    <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-subtle); border-radius: 6px; padding: 14px; margin-bottom: 20px; flex-grow: 1;">
        <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.12em; color: var(--gold-primary); margin-bottom: 8px; font-weight: 700;">
            <i class="fas fa-layer-group text-gold"></i> Included Masterpieces:
        </div>
        <ul style="list-style: none; display: flex; flex-direction: column; gap: 6px;">
            @foreach($bundle->items as $bItem)
                <li style="font-size: 0.85rem; color: var(--text-sub); display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-check text-gold" style="font-size: 0.7rem;"></i>
                    <span><strong>{{ $bItem->product->name ?? 'Luxury Flacon' }}</strong> ({{ $bItem->custom_size_label ?? '100ml Extrait' }})</span>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Pricing and Savings Summary -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 20px; border-top: 1px solid var(--border-subtle); padding-top: 16px;">
        <div>
            <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase;">Bundle Price</div>
            <div style="font-family: var(--font-heading); font-size: 1.6rem; font-weight: 700; color: var(--gold-champagne);">
                {{ $bundle->formatted_bundle_price }}
            </div>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 0.75rem; color: var(--text-muted); text-decoration: line-through;">
                {{ $bundle->formatted_original_price }}
            </div>
            <div style="font-size: 0.78rem; color: #2ecc71; font-weight: 700;">
                You Save {{ $bundle->formatted_savings }}
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div style="display: flex; gap: 10px;">
        <button onclick="addBundleToCart({{ $bundle->id }})" class="btn-gold" style="flex-grow: 1; padding: 12px 18px; font-size: 0.82rem;">
            <i class="fas fa-shopping-bag"></i> ADD BUNDLE TO CART
        </button>
        <a href="https://wa.me/923001234567?text={{ urlencode('Salam! I want to order the ' . $bundle->name . ' for ' . $bundle->formatted_bundle_price) }}" target="_blank" class="btn-whatsapp" style="padding: 12px 14px;" title="Order via WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>

</div>
