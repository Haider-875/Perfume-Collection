<?php
// Generate complementary luxury box packaging SVGs for the 26 new catalog perfumes

$boxes = [
    'my_way_box' => [
        'title' => 'MY WAY PARIS',
        'subtitle' => 'IMPERIAL FLORA COFFRET',
        'color1' => '#2B121F',
        'gold' => '#E8B4B8',
        'accent' => '#D4AF37',
    ],
    'afnan_supremacy_box' => [
        'title' => 'AFNAN SUPREMACY',
        'subtitle' => 'SILVER CUIR & BIRCH',
        'color1' => '#181A1D',
        'gold' => '#D1D5DB',
        'accent' => '#9CA3AF',
    ],
    'gucci_bloom_box' => [
        'title' => 'GUCCI BLOOM',
        'subtitle' => 'NATURAL NECTAR COFFRET',
        'color1' => '#2A141A',
        'gold' => '#F2C6CE',
        'accent' => '#D4AF37',
    ],
    '9pm_nightout_box' => [
        'title' => '9PM NIGHT OUT',
        'subtitle' => 'EXTRAIT NOCTURNE EXCLUSIVE',
        'color1' => '#130E20',
        'gold' => '#F59E0B',
        'accent' => '#8B5CF6',
    ],
    'rebel_men_box' => [
        'title' => 'REBEL POUR HOMME',
        'subtitle' => 'FIERY CEDAR & ELEMI',
        'color1' => '#141416',
        'gold' => '#E5C158',
        'accent' => '#E67E22',
    ],
    '9pm_after9_box' => [
        'title' => '9PM (AFTER 9)',
        'subtitle' => 'MIDNIGHT AMBERGRIS EDITION',
        'color1' => '#0F1522',
        'gold' => '#38BDF8',
        'accent' => '#0284C7',
    ],
    'sentinal_box' => [
        'title' => 'SENTINAL RESERVE',
        'subtitle' => 'AGED AGARWOOD & PLUM',
        'color1' => '#170E1A',
        'gold' => '#E5C158',
        'accent' => '#9333EA',
    ],
    'black_opium_box' => [
        'title' => 'BLACK OPIUM',
        'subtitle' => 'DARK COFFEE & BOURBON',
        'color1' => '#120B10',
        'gold' => '#F472B6',
        'accent' => '#E11D48',
    ],
    'crush_unisex_box' => [
        'title' => 'CRUSH VELVET',
        'subtitle' => 'SUMMER NECTAR & AMBER',
        'color1' => '#220D16',
        'gold' => '#FBBF24',
        'accent' => '#FB7185',
    ],
    'republic_swy_box' => [
        'title' => 'REPUBLIC SWY',
        'subtitle' => 'CANDIED CHESTNUT & VANILLA',
        'color1' => '#23150D',
        'gold' => '#F59E0B',
        'accent' => '#D97706',
    ],
    'bombshell_box' => [
        'title' => 'BOMBSHELL FLORA',
        'subtitle' => 'PURPLE PASSIONFRUIT & PEONY',
        'color1' => '#2B0E1D',
        'gold' => '#F472B6',
        'accent' => '#EC4899',
    ],
    'xerjoff_naxos_box' => [
        'title' => 'XERJOFF NAXOS',
        'subtitle' => 'CARIBBEAN HONEY & TOBACCO',
        'color1' => '#1A160F',
        'gold' => '#FCD34D',
        'accent' => '#D97706',
    ],
    'azzaro_wanted_box' => [
        'title' => 'AZZARO WANTED',
        'subtitle' => 'MISSION HIGH OCTANE',
        'color1' => '#161719',
        'gold' => '#E5C158',
        'accent' => '#78716C',
    ],
    'the_white_oud_box' => [
        'title' => 'THE WHITE OUD',
        'subtitle' => 'CRYSTAL AGARWOOD & MUSK',
        'color1' => '#16171A',
        'gold' => '#FFFFFF',
        'accent' => '#D4AF37',
    ],
    'arabian_sea_box' => [
        'title' => 'ARABIAN SEA',
        'subtitle' => 'OCEANIC AMBERGRIS & RESIN',
        'color1' => '#0B1724',
        'gold' => '#38BDF8',
        'accent' => '#0284C7',
    ],
    'erba_pura_box' => [
        'title' => 'ERBA PURA',
        'subtitle' => 'MEDITERRANEAN FRUITS BASKET',
        'color1' => '#0D1E1E',
        'gold' => '#34D399',
        'accent' => '#059669',
    ],
    'hawas_ice_box' => [
        'title' => 'HAWAS ICE',
        'subtitle' => 'SUB-ZERO FROZEN DRIFTWOOD',
        'color1' => '#0B1A24',
        'gold' => '#7DD3FC',
        'accent' => '#0284C7',
    ],
    'silk_musk_box' => [
        'title' => 'SILK MUSK',
        'subtitle' => 'ROYAL CASHMERE & WHITE LILY',
        'color1' => '#1F1A15',
        'gold' => '#FEF08A',
        'accent' => '#D4AF37',
    ],
    '91_sports_box' => [
        'title' => '91 SPORTS',
        'subtitle' => 'FROSTED MINT & SEA SALT',
        'color1' => '#0E171C',
        'gold' => '#67E8F9',
        'accent' => '#06B6D4',
    ],
    '91_degree_box' => [
        'title' => '91° DEGREE',
        'subtitle' => 'VOLCANIC EMBER & SPICED LEATHER',
        'color1' => '#210B07',
        'gold' => '#FB923C',
        'accent' => '#EA580C',
    ],
    '91_gold_edition_box' => [
        'title' => '91 GOLD EDITION',
        'subtitle' => '24K SAFFRON & IMPERIAL OUD',
        'color1' => '#1C150A',
        'gold' => '#FDE047',
        'accent' => '#CA8A04',
    ],
];

function renderBox($data) {
    return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 800" width="100%" height="100%">
  <defs>
    <radialGradient id="boxGlow_{$data['title']}" cx="50%" cy="50%" r="55%">
      <stop offset="0%" stop-color="{$data['accent']}" stop-opacity="0.32"/>
      <stop offset="100%" stop-color="#080304" stop-opacity="0"/>
    </radialGradient>
    <linearGradient id="boxGold_{$data['title']}" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#FFFFFF"/>
      <stop offset="30%" stop-color="{$data['gold']}"/>
      <stop offset="70%" stop-color="{$data['accent']}"/>
      <stop offset="100%" stop-color="{$data['gold']}"/>
    </linearGradient>
    <filter id="boxShadow_{$data['title']}" x="-20%" y="-20%" width="140%" height="140%">
      <feDropShadow dx="0" dy="25" stdDeviation="30" flood-color="#000000" flood-opacity="0.9"/>
    </filter>
  </defs>

  <rect width="600" height="800" fill="#080304"/>
  <circle cx="300" cy="420" r="280" fill="url(#boxGlow_{$data['title']})"/>

  <g filter="url(#boxShadow_{$data['title']})">
    <!-- Velvet Textured Outer Box Flap -->
    <rect x="130" y="150" width="340" height="530" rx="8" fill="{$data['color1']}" stroke="url(#boxGold_{$data['title']})" stroke-width="2.5"/>
    <rect x="145" y="165" width="310" height="500" rx="4" fill="none" stroke="url(#boxGold_{$data['title']})" stroke-opacity="0.3" stroke-width="1.5"/>

    <!-- Gold Foil Corner Accents -->
    <path d="M150 195 L150 170 L175 170" fill="none" stroke="url(#boxGold_{$data['title']})" stroke-width="2"/>
    <path d="M450 195 L450 170 L425 170" fill="none" stroke="url(#boxGold_{$data['title']})" stroke-width="2"/>
    <path d="M150 635 L150 660 L175 660" fill="none" stroke="url(#boxGold_{$data['title']})" stroke-width="2"/>
    <path d="M450 635 L450 660 L425 660" fill="none" stroke="url(#boxGold_{$data['title']})" stroke-width="2"/>

    <!-- Royal Monogram Seal -->
    <circle cx="300" cy="290" r="42" fill="none" stroke="url(#boxGold_{$data['title']})" stroke-width="2"/>
    <circle cx="300" cy="290" r="35" fill="none" stroke="url(#boxGold_{$data['title']})" stroke-width="1" stroke-dasharray="4,2"/>
    <text x="300" y="298" font-family="'Cinzel', serif" font-size="20" font-weight="bold" fill="url(#boxGold_{$data['title']})" text-anchor="middle" letter-spacing="3">PC</text>

    <!-- Brand Header -->
    <text x="300" y="375" font-family="'Cinzel', serif" font-size="11" font-weight="bold" fill="url(#boxGold_{$data['title']})" text-anchor="middle" letter-spacing="4">PERFUMES COLLECTION</text>
    <text x="300" y="395" font-family="'Montserrat', sans-serif" font-size="8" fill="#A8A29E" text-anchor="middle" letter-spacing="3">HAUTE PARFUMERIE • ATELIER</text>

    <line x1="210" y1="425" x2="390" y2="425" stroke="url(#boxGold_{$data['title']})" stroke-width="1.5"/>

    <!-- Product Title & Reserve Tagline -->
    <text x="300" y="470" font-family="'Cinzel', serif" font-size="16" font-weight="bold" fill="#FFFFFF" text-anchor="middle" letter-spacing="3">{$data['title']}</text>
    <text x="300" y="500" font-family="'Montserrat', sans-serif" font-size="9" font-weight="600" fill="{$data['gold']}" text-anchor="middle" letter-spacing="3">{$data['subtitle']}</text>

    <line x1="250" y1="535" x2="350" y2="535" stroke="url(#boxGold_{$data['title']})" stroke-opacity="0.5" stroke-width="1" stroke-dasharray="3,3"/>

    <!-- Spec Badges -->
    <text x="300" y="580" font-family="'Cinzel', serif" font-size="9" fill="#D6D3D1" text-anchor="middle" letter-spacing="2">EXTRAIT DE PARFUM • 50ML / 100ML</text>
    <text x="300" y="605" font-family="'Montserrat', sans-serif" font-size="8" fill="#78716C" text-anchor="middle" letter-spacing="2">35% OIL CONCENTRATION • LONG LASTING</text>
  </g>
</svg>
SVG;
}

$targetDir = __DIR__ . '/../public/assets/images/perfumes';
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

$generated = 0;
foreach ($boxes as $filename => $boxData) {
    $filepath = $targetDir . '/' . $filename . '.svg';
    file_put_contents($filepath, renderBox($boxData));
    $generated++;
}

echo "Successfully generated {$generated} luxury box packaging SVGs in {$targetDir}\n";
