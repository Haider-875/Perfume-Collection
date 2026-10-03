<?php
// Script to generate luxury SVG assets for all 24+ Maison d'Orient Parfums and Slides

$perfumes = [
    // Exclusive
    'oud_royale' => ['title' => 'OUD ROYALE 1947', 'subtitle' => 'EXTRAIT DE PARFUM', 'color1' => '#1A1412', 'color2' => '#3D2817', 'gold' => '#D4AF37', 'accent' => '#C5A059', 'type' => 'bottle'],
    'oud_royale_box' => ['title' => 'OUD ROYALE 1947', 'subtitle' => 'VELVET COFFRET', 'color1' => '#0F0D0C', 'color2' => '#1F1714', 'gold' => '#E5C158', 'accent' => '#C5A059', 'type' => 'box'],
    'dehn_oud_attar' => ['title' => 'DEHN AL OUD', 'subtitle' => 'CAMBODI 100% PURE', 'color1' => '#21170E', 'color2' => '#452B11', 'gold' => '#D4AF37', 'accent' => '#AA7C11', 'type' => 'attar'],
    'dehn_oud_attar_box' => ['title' => 'DEHN AL OUD', 'subtitle' => 'CRYSTAL ATTAR FLACON', 'color1' => '#140D07', 'color2' => '#261608', 'gold' => '#E5C158', 'accent' => '#C5A059', 'type' => 'box'],
    'ambergris_niche' => ['title' => 'AMBERGRIS IMPERIALE', 'subtitle' => 'PRIVATE RESERVE', 'color1' => '#1A1812', 'color2' => '#3A331E', 'gold' => '#E5C158', 'accent' => '#D4AF37', 'type' => 'bottle'],
    'kashmir_saffron' => ['title' => 'KASHMIR SAFFRON', 'subtitle' => 'CRIMSON EXTRAIT', 'color1' => '#2A1110', 'color2' => '#4D1B18', 'gold' => '#F39C12', 'accent' => '#E74C3C', 'type' => 'bottle'],
    'taif_rose_1888' => ['title' => 'TAIF ROSE 1888', 'subtitle' => 'VINTAGE ABSOLUTE', 'color1' => '#2D101A', 'color2' => '#541528', 'gold' => '#E8B4B8', 'accent' => '#D4AF37', 'type' => 'bottle'],
    'sandalwood_supreme' => ['title' => 'MYSORE SUPREME', 'subtitle' => 'SACRED SANDALWOOD', 'color1' => '#261C14', 'color2' => '#483522', 'gold' => '#E5C158', 'accent' => '#C5A059', 'type' => 'bottle'],

    // Men
    'sultan_cuir' => ['title' => "SULTAN'S CUIR", 'subtitle' => 'TUSCAN TOBACCO', 'color1' => '#1C1510', 'color2' => '#362315', 'gold' => '#D4AF37', 'accent' => '#A0522D', 'type' => 'bottle'],
    'sultan_cuir_box' => ['title' => "SULTAN'S CUIR", 'subtitle' => 'ROYAL LEATHER EDITION', 'color1' => '#120D0A', 'color2' => '#24160E', 'gold' => '#E5C158', 'accent' => '#8C6D53', 'type' => 'box'],
    'lahore_nights' => ['title' => 'LAHORE NIGHTS', 'subtitle' => 'SMOKED AMBER', 'color1' => '#14121A', 'color2' => '#2D1B28', 'gold' => '#F39C12', 'accent' => '#D35400', 'type' => 'bottle'],
    'lahore_nights_box' => ['title' => 'LAHORE NIGHTS', 'subtitle' => 'EXTRAIT NOCTURNE', 'color1' => '#0E0C12', 'color2' => '#1F121C', 'gold' => '#F39C12', 'accent' => '#E67E22', 'type' => 'box'],
    'vetiver_imperiale' => ['title' => 'VETIVER IMPERIALE', 'subtitle' => 'SMOKED ROOTS', 'color1' => '#121A14', 'color2' => '#1E3624', 'gold' => '#82B74B', 'accent' => '#527F2D', 'type' => 'bottle'],
    'cardamom_noir' => ['title' => 'CARDAMOM NOIR', 'subtitle' => 'CEYLON SPICE EXTRAIT', 'color1' => '#151515', 'color2' => '#2A2A2A', 'gold' => '#D4AF37', 'accent' => '#7F8C8D', 'type' => 'bottle'],
    'atlas_cedarwood' => ['title' => 'ATLAS CEDARWOOD', 'subtitle' => 'MOROCCAN PEAKS', 'color1' => '#1F1712', 'color2' => '#3B2B1F', 'gold' => '#E5C158', 'accent' => '#A0522D', 'type' => 'bottle'],
    'smoked_birch' => ['title' => 'SMOKED BIRCH ELITE', 'subtitle' => 'CUIR & SMOKE', 'color1' => '#121214', 'color2' => '#24242A', 'gold' => '#D4AF37', 'accent' => '#34495E', 'type' => 'bottle'],

    // Women
    'noor_gulab' => ['title' => 'NOOR-E-GULAB', 'subtitle' => 'ROSE ABSOLUTE', 'color1' => '#2A1118', 'color2' => '#4A1525', 'gold' => '#E8B4B8', 'accent' => '#D4AF37', 'type' => 'bottle'],
    'noor_gulab_box' => ['title' => 'NOOR-E-GULAB', 'subtitle' => 'IMPERIAL TAIF ROSE', 'color1' => '#1F0B12', 'color2' => '#38101E', 'gold' => '#E8B4B8', 'accent' => '#D4AF37', 'type' => 'box'],
    'imperial_motia' => ['title' => 'IMPERIAL MOTIA', 'subtitle' => 'JASMINE SAMBAC', 'color1' => '#181A16', 'color2' => '#2B3324', 'gold' => '#E8E4C9', 'accent' => '#D4AF37', 'type' => 'bottle'],
    'imperial_motia_box' => ['title' => 'IMPERIAL MOTIA', 'subtitle' => 'MIDNIGHT HARVEST', 'color1' => '#0E120D', 'color2' => '#1A2116', 'gold' => '#E8E4C9', 'accent' => '#C5A059', 'type' => 'box'],
    'velvet_orchid' => ['title' => 'VELVET ORCHID', 'subtitle' => 'BLACK SAFFRON', 'color1' => '#201026', 'color2' => '#3D154A', 'gold' => '#D4AF37', 'accent' => '#9B59B6', 'type' => 'bottle'],
    'jasmine_royale' => ['title' => 'JASMINE ROYALE', 'subtitle' => 'GOLDEN NECTAR', 'color1' => '#1F1B12', 'color2' => '#3D341D', 'gold' => '#F3E5AB', 'accent' => '#D4AF37', 'type' => 'bottle'],
    'midnight_peony' => ['title' => 'MIDNIGHT PEONY', 'subtitle' => 'ROYAL FLORA', 'color1' => '#2B1220', 'color2' => '#4D1935', 'gold' => '#FAD02C', 'accent' => '#E8B4B8', 'type' => 'bottle'],
    'silk_bourbon' => ['title' => 'SILK & BOURBON', 'subtitle' => 'VANILLE ABSOLUE', 'color1' => '#241712', 'color2' => '#42271C', 'gold' => '#F39C12', 'accent' => '#D35400', 'type' => 'bottle'],

    // Unisex
    'murree_mist' => ['title' => 'MURREE MIST', 'subtitle' => 'SILVER BERGAMOT', 'color1' => '#0E1A1A', 'color2' => '#173636', 'gold' => '#A2D5C6', 'accent' => '#5C9EAD', 'type' => 'bottle'],
    'murree_mist_box' => ['title' => 'MURREE MIST', 'subtitle' => 'HIMALAYAN PINE & MIST', 'color1' => '#081212', 'color2' => '#112222', 'gold' => '#A2D5C6', 'accent' => '#5C9EAD', 'type' => 'box'],
    'marine_amber' => ['title' => 'AQUA AMBERGRIS', 'subtitle' => 'OCEANIC EXTRAIT', 'color1' => '#0E1624', 'color2' => '#162C4D', 'gold' => '#5DADE2', 'accent' => '#2980B9', 'type' => 'bottle'],
    'gourmand_tonka' => ['title' => 'GOURMAND TONKA', 'subtitle' => 'DARK COCOA & OUD', 'color1' => '#1F120E', 'color2' => '#3E2015', 'gold' => '#F39C12', 'accent' => '#A0522D', 'type' => 'bottle'],
    'bakhoor_cashmere' => ['title' => 'BAKHOOR CASHMERE', 'subtitle' => 'WARM SMOKE', 'color1' => '#1E1812', 'color2' => '#382A1C', 'gold' => '#D4AF37', 'accent' => '#C5A059', 'type' => 'bottle'],
    'spiced_tea' => ['title' => 'SPICED CARDAMOM TEA', 'subtitle' => 'MOUNTAIN CHAI', 'color1' => '#211510', 'color2' => '#3D2418', 'gold' => '#E67E22', 'accent' => '#D35400', 'type' => 'bottle'],
    'white_royal_musk' => ['title' => 'WHITE ROYAL MUSK', 'subtitle' => 'TRANSCENDENT SKIN', 'color1' => '#18181C', 'color2' => '#2C2C34', 'gold' => '#FFFFFF', 'accent' => '#D4AF37', 'type' => 'bottle'],

    // Bundles & Collaborations
    'discovery_set' => ['title' => 'DISCOVERY COFFRET', 'subtitle' => '5X 10ML EXTRAITS', 'color1' => '#121214', 'color2' => '#222228', 'gold' => '#D4AF37', 'accent' => '#C5A059', 'type' => 'set'],
    'discovery_set_open' => ['title' => 'DISCOVERY COFFRET', 'subtitle' => 'THE BESPOKE COLLECTION', 'color1' => '#0C0C0E', 'color2' => '#181820', 'gold' => '#E5C158', 'accent' => '#C5A059', 'type' => 'set'],
    'mughal_duo_bundle' => ['title' => 'ROYAL MUGHAL DUO', 'subtitle' => 'OUD ROYALE & GULAB', 'color1' => '#180E12', 'color2' => '#2E151E', 'gold' => '#E5C158', 'accent' => '#C5A059', 'type' => 'set'],
    'executive_bundle' => ['title' => 'EXECUTIVE SILLAGE DUO', 'subtitle' => 'SULTAN & LAHORE NIGHTS', 'color1' => '#141118', 'color2' => '#281F30', 'gold' => '#D4AF37', 'accent' => '#A0522D', 'type' => 'set'],
    'attar_trio_bundle' => ['title' => 'PURE ATTAR TRIO', 'subtitle' => '3X CRYSTAL FLACONS', 'color1' => '#1F170E', 'color2' => '#3B2912', 'gold' => '#E5C158', 'accent' => '#AA7C11', 'type' => 'set'],
    'grasse_collab' => ['title' => 'PARIS x LAHORE 2026', 'subtitle' => 'ATELIER SPECIAL EDITION', 'color1' => '#10141C', 'color2' => '#18253B', 'gold' => '#D4AF37', 'accent' => '#3498DB', 'type' => 'bottle'],
    'lahore_gala_collab' => ['title' => 'LAHORE GALA 1888', 'subtitle' => 'LIMITED GOLD FOIL', 'color1' => '#24180A', 'color2' => '#452B0F', 'gold' => '#FFEAA7', 'accent' => '#D4AF37', 'type' => 'bottle'],
];

function generateBottleSvg($data) {
    return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 800" width="100%" height="100%">
  <defs>
    <radialGradient id="bgGlow_{$data['title']}" cx="50%" cy="50%" r="50%">
      <stop offset="0%" stop-color="{$data['accent']}" stop-opacity="0.25"/>
      <stop offset="100%" stop-color="#080304" stop-opacity="0"/>
    </radialGradient>
    <linearGradient id="goldGrad_{$data['title']}" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#FFF6DD"/>
      <stop offset="25%" stop-color="{$data['gold']}"/>
      <stop offset="50%" stop-color="#9A7B38"/>
      <stop offset="75%" stop-color="{$data['gold']}"/>
      <stop offset="100%" stop-color="#FFEAA7"/>
    </linearGradient>
    <linearGradient id="bottleBody_{$data['title']}" x1="0%" y1="0%" x2="100%" y2="0%">
      <stop offset="0%" stop-color="{$data['color1']}"/>
      <stop offset="35%" stop-color="{$data['color2']}"/>
      <stop offset="50%" stop-color="{$data['color1']}"/>
      <stop offset="70%" stop-color="{$data['color2']}"/>
      <stop offset="100%" stop-color="{$data['color1']}"/>
    </linearGradient>
    <linearGradient id="glassShine" x1="0%" y1="0%" x2="100%" y2="0%">
      <stop offset="0%" stop-color="#FFFFFF" stop-opacity="0.35"/>
      <stop offset="15%" stop-color="#FFFFFF" stop-opacity="0.05"/>
      <stop offset="85%" stop-color="#FFFFFF" stop-opacity="0"/>
      <stop offset="100%" stop-color="#FFFFFF" stop-opacity="0.2"/>
    </linearGradient>
    <filter id="dropShadow" x="-20%" y="-20%" width="140%" height="140%">
      <feDropShadow dx="0" dy="25" stdDeviation="30" flood-color="#000000" flood-opacity="0.85"/>
    </filter>
  </defs>

  <rect width="600" height="800" fill="#080304"/>
  <circle cx="300" cy="450" r="280" fill="url(#bgGlow_{$data['title']})"/>
  <ellipse cx="300" cy="720" rx="190" ry="24" fill="#020101" opacity="0.95" filter="url(#dropShadow)"/>

  <g filter="url(#dropShadow)">
    <rect x="230" y="110" width="140" height="110" rx="6" fill="url(#goldGrad_{$data['title']})" stroke="#664D1B" stroke-width="1.5"/>
    <rect x="245" y="120" width="110" height="90" rx="3" fill="none" stroke="#FFFFFF" stroke-opacity="0.3" stroke-width="1"/>
    <circle cx="300" cy="165" r="22" fill="none" stroke="#5A4315" stroke-width="2"/>
    <path d="M290 170 L300 155 L310 170 Z" fill="#5A4315"/>
    <circle cx="300" cy="154" r="3" fill="#FFEAA7"/>

    <rect x="260" y="220" width="80" height="25" fill="url(#goldGrad_{$data['title']})"/>
    <rect x="270" y="245" width="60" height="15" fill="#140E0A"/>

    <path d="M165 290 Q165 260 200 260 L400 260 Q435 260 435 290 L435 670 Q435 690 410 690 L190 690 Q165 690 165 670 Z" fill="url(#bottleBody_{$data['title']})" stroke="url(#goldGrad_{$data['title']})" stroke-width="2.5"/>
    <path d="M175 640 L425 640 L420 680 L180 680 Z" fill="#050203" opacity="0.7"/>

    <path d="M175 275 L205 275 L205 675 L175 675 Z" fill="url(#glassShine)"/>
    <path d="M395 275 L425 275 L425 675 L395 675 Z" fill="url(#glassShine)"/>

    <rect x="200" y="360" width="200" height="230" rx="4" fill="#080304" stroke="url(#goldGrad_{$data['title']})" stroke-width="2"/>
    <rect x="208" y="368" width="184" height="214" rx="2" fill="none" stroke="url(#goldGrad_{$data['title']})" stroke-opacity="0.4" stroke-width="1"/>
    
    <circle cx="300" cy="405" r="16" fill="none" stroke="url(#goldGrad_{$data['title']})" stroke-width="1.5"/>
    <text x="300" y="410" font-family="'Cinzel', 'Playfair Display', serif" font-size="11" font-weight="bold" fill="url(#goldGrad_{$data['title']})" text-anchor="middle" letter-spacing="2">PC</text>
    
    <text x="300" y="445" font-family="'Cinzel', serif" font-size="9" fill="#E5C158" text-anchor="middle" letter-spacing="3">PERFUMES COLLECTION</text>
    <line x1="240" y1="455" x2="360" y2="455" stroke="url(#goldGrad_{$data['title']})" stroke-width="1"/>

    <text x="300" y="485" font-family="'Cinzel', serif" font-size="14" font-weight="bold" fill="#F5EFE6" text-anchor="middle" letter-spacing="2">{$data['title']}</text>
    <text x="300" y="508" font-family="'Montserrat', sans-serif" font-size="8.5" fill="{$data['gold']}" text-anchor="middle" letter-spacing="3">{$data['subtitle']}</text>
    
    <line x1="260" y1="525" x2="340" y2="525" stroke="url(#goldGrad_{$data['title']})" stroke-width="0.8" stroke-dasharray="3,3"/>
    
    <text x="300" y="550" font-family="'Cinzel', serif" font-size="8" fill="#B3B3B3" text-anchor="middle" letter-spacing="2">100 ML • 3.4 FL.OZ</text>
    <text x="300" y="565" font-family="'Montserrat', sans-serif" font-size="7" fill="#888888" text-anchor="middle" letter-spacing="1.5">HAUTE PARFUMERIE • PAKISTAN</text>
  </g>
</svg>
SVG;
}

function generateAttarSvg($data) {
    return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 800" width="100%" height="100%">
  <defs>
    <radialGradient id="attarGlow" cx="50%" cy="50%" r="50%">
      <stop offset="0%" stop-color="#C9A24B" stop-opacity="0.3"/>
      <stop offset="100%" stop-color="#080304" stop-opacity="0"/>
    </radialGradient>
    <linearGradient id="goldGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#FFF5DB"/>
      <stop offset="30%" stop-color="#C9A24B"/>
      <stop offset="70%" stop-color="#8C6D2C"/>
      <stop offset="100%" stop-color="#E6C77A"/>
    </linearGradient>
    <linearGradient id="pureOudOil" x1="0%" y1="0%" x2="100%" y2="0%">
      <stop offset="0%" stop-color="#2D1B0D"/>
      <stop offset="50%" stop-color="#6E3D12"/>
      <stop offset="100%" stop-color="#2D1B0D"/>
    </linearGradient>
  </defs>

  <rect width="600" height="800" fill="#080304"/>
  <circle cx="300" cy="450" r="280" fill="url(#attarGlow)"/>

  <g>
    <polygon points="300,70 330,120 300,160 270,120" fill="url(#goldGrad2)" stroke="#AA7C11" stroke-width="2"/>
    <circle cx="300" cy="115" r="10" fill="#FFFFFF" opacity="0.6"/>
    <rect x="285" y="160" width="30" height="40" fill="url(#goldGrad2)"/>
    
    <polygon points="200,240 400,240 450,330 450,650 400,710 200,710 150,650 150,330" fill="url(#pureOudOil)" stroke="url(#goldGrad2)" stroke-width="4"/>
    <polygon points="220,270 380,270 420,350 420,630 380,680 220,680 180,630 180,350" fill="#522D0D" stroke="#C9A24B" stroke-width="1.5" opacity="0.85"/>
    
    <circle cx="300" cy="420" r="35" fill="#120B05" stroke="url(#goldGrad2)" stroke-width="2"/>
    <text x="300" y="428" font-family="'Cinzel', serif" font-size="18" fill="url(#goldGrad2)" font-weight="bold" text-anchor="middle">عطر</text>
    
    <text x="300" y="490" font-family="'Cinzel', serif" font-size="16" font-weight="bold" fill="#F5EFE6" text-anchor="middle" letter-spacing="3">DEHN AL OUD</text>
    <text x="300" y="515" font-family="'Montserrat', sans-serif" font-size="10" fill="#C9A24B" text-anchor="middle" letter-spacing="2">CAMBODI 15-YEAR</text>
    <text x="300" y="540" font-family="'Cinzel', serif" font-size="9" fill="#B3B3B3" text-anchor="middle" letter-spacing="2">12 ML / 1 TOLA • PURE OIL</text>
  </g>
</svg>
SVG;
}

function generateBoxSvg($data) {
    return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 800" width="100%" height="100%">
  <defs>
    <radialGradient id="boxGlow_{$data['title']}" cx="50%" cy="50%" r="50%">
      <stop offset="0%" stop-color="{$data['accent']}" stop-opacity="0.3"/>
      <stop offset="100%" stop-color="#080304" stop-opacity="0"/>
    </radialGradient>
    <linearGradient id="boxGold" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#FFFDF9"/>
      <stop offset="35%" stop-color="{$data['gold']}"/>
      <stop offset="70%" stop-color="#8C6D2C"/>
      <stop offset="100%" stop-color="{$data['gold']}"/>
    </linearGradient>
  </defs>

  <rect width="600" height="800" fill="#080304"/>
  <circle cx="300" cy="420" r="280" fill="url(#boxGlow_{$data['title']})"/>

  <g>
    <rect x="130" y="160" width="340" height="520" rx="8" fill="{$data['color1']}" stroke="url(#boxGold)" stroke-width="3"/>
    <rect x="145" y="175" width="310" height="490" rx="4" fill="none" stroke="url(#boxGold)" stroke-opacity="0.3" stroke-width="1.5"/>

    <path d="M150 200 L150 180 L170 180" fill="none" stroke="url(#boxGold)" stroke-width="2"/>
    <path d="M450 200 L450 180 L430 180" fill="none" stroke="url(#boxGold)" stroke-width="2"/>
    <path d="M150 640 L150 660 L170 660" fill="none" stroke="url(#boxGold)" stroke-width="2"/>
    <path d="M450 640 L450 660 L430 660" fill="none" stroke="url(#boxGold)" stroke-width="2"/>

    <circle cx="300" cy="310" r="42" fill="none" stroke="url(#boxGold)" stroke-width="2"/>
    <circle cx="300" cy="310" r="34" fill="none" stroke="url(#boxGold)" stroke-width="1" stroke-dasharray="4,2"/>
    <text x="300" y="318" font-family="'Cinzel', serif" font-size="20" font-weight="bold" fill="url(#boxGold)" text-anchor="middle" letter-spacing="3">PC</text>

    <text x="300" y="390" font-family="'Cinzel', serif" font-size="11" fill="url(#boxGold)" text-anchor="middle" letter-spacing="4">PERFUMES COLLECTION</text>
    <text x="300" y="410" font-family="'Montserrat', sans-serif" font-size="8" fill="#888888" text-anchor="middle" letter-spacing="3">HAUTE PARFUMERIE • PAKISTAN</text>

    <line x1="220" y1="440" x2="380" y2="440" stroke="url(#boxGold)" stroke-width="1.5"/>

    <text x="300" y="480" font-family="'Cinzel', serif" font-size="16" font-weight="bold" fill="#F5EFE6" text-anchor="middle" letter-spacing="3">{$data['title']}</text>
    <text x="300" y="510" font-family="'Montserrat', sans-serif" font-size="10" fill="{$data['gold']}" text-anchor="middle" letter-spacing="4">{$data['subtitle']}</text>

    <text x="300" y="580" font-family="'Cinzel', serif" font-size="9" fill="#999999" text-anchor="middle" letter-spacing="2">EXTRAIT DE PARFUM • 40% VOL</text>
    <text x="300" y="605" font-family="'Montserrat', sans-serif" font-size="8" fill="#666666" text-anchor="middle" letter-spacing="2">PAKISTAN • HAUTE PARFUMERIE</text>
  </g>
</svg>
SVG;
}

// Generate all perfume SVGs
foreach ($perfumes as $key => $meta) {
    if ($meta['type'] === 'attar') {
        $svg = generateAttarSvg($meta);
    } elseif ($meta['type'] === 'box' || $meta['type'] === 'set') {
        $svg = generateBoxSvg($meta);
    } else {
        $svg = generateBottleSvg($meta);
    }
    file_put_contents("public/assets/images/perfumes/{$key}.svg", $svg);
}

// Generate Hero Slide Images
$slides = [
    'hero_slide_1' => ['title' => 'IMPERIAL EXTRAIT DE PARFUM', 'sub' => '40% CONCENTRATION • 18H BEAST MODE', 'bg' => '#120508'],
    'hero_slide_2' => ['title' => 'ROYAL CAMBODIAN DEHN AL OUD', 'sub' => '15-YEAR MACERATION • 100% PURE AGARWOOD', 'bg' => '#1A0E06'],
    'hero_slide_3' => ['title' => 'THE BESPOKE BUNDLES & GIFTING', 'sub' => 'SAVE UP TO RS. 6,000 ON CURATED SETS', 'bg' => '#0A0E18'],
    'hero_slide_4' => ['title' => 'PARIS x LAHORE COLLABORATION', 'sub' => 'FRENCH NICHE REFINEMENT FOR PAKISTAN', 'bg' => '#140D1C'],
];

foreach ($slides as $sKey => $sVal) {
    $slideSvg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1920 1080" width="100%" height="100%">
  <defs>
    <radialGradient id="slideAura_{$sKey}" cx="60%" cy="50%" r="60%">
      <stop offset="0%" stop-color="#C9A24B" stop-opacity="0.25"/>
      <stop offset="100%" stop-color="{$sVal['bg']}" stop-opacity="1"/>
    </radialGradient>
    <linearGradient id="goldTxt" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#FFFDF8"/>
      <stop offset="50%" stop-color="#E6C77A"/>
      <stop offset="100%" stop-color="#C9A24B"/>
    </linearGradient>
  </defs>
  <rect width="1920" height="1080" fill="{$sVal['bg']}"/>
  <rect width="1920" height="1080" fill="url(#slideAura_{$sKey})"/>
  
  <!-- Subtle Ornamental Grid Lines -->
  <line x1="100" y1="100" x2="1820" y2="100" stroke="#C9A24B" stroke-opacity="0.15" stroke-width="1"/>
  <line x1="100" y1="980" x2="1820" y2="980" stroke="#C9A24B" stroke-opacity="0.15" stroke-width="1"/>
  <line x1="100" y1="100" x2="100" y2="980" stroke="#C9A24B" stroke-opacity="0.15" stroke-width="1"/>
  <line x1="1820" y1="100" x2="1820" y2="980" stroke="#C9A24B" stroke-opacity="0.15" stroke-width="1"/>
</svg>
SVG;
    file_put_contents("public/assets/images/perfumes/{$sKey}.svg", $slideSvg);
}

echo "All 35+ luxury SVG assets generated successfully!\n";
