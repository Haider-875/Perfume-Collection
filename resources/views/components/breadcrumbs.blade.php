@props(['links' => []])

<nav aria-label="Breadcrumb" style="background: #0E080A; border-bottom: 1px solid var(--border-subtle); padding: 12px 0;">
    <div class="container">
        <ol style="list-style: none; display: flex; flex-wrap: wrap; align-items: center; gap: 8px; font-size: 0.8rem; color: var(--text-muted);">
            <li>
                <a href="{{ route('home') }}" style="color: var(--text-muted); text-decoration: none; transition: var(--transition-smooth);">
                    <i class="fas fa-home text-gold" style="font-size: 0.75rem;"></i> Home
                </a>
            </li>

            @foreach($links as $title => $url)
                <li style="color: var(--border-gold);"><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i></li>
                <li>
                    @if($url)
                        <a href="{{ $url }}" style="color: var(--gold-champagne); text-decoration: none; transition: var(--transition-smooth);">{{ $title }}</a>
                    @else
                        <span style="color: var(--text-ivory); font-weight: 600;">{{ $title }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
</nav>
