@php
    // Priority for each image: 1) admin-picked (File Manager) → 2) local file in public/assets/about/ → 3) default.
    $aboutPhoto1 = ($about?->photo1 ? media($about->photo1) : null)
        ?? (file_exists(public_path('assets/about/engineers.jpg')) ? asset('assets/about/engineers.jpg') : null)
        ?? 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=600&q=80';
    $aboutPhoto2 = ($about?->photo2 ? media($about->photo2) : null)
        ?? (file_exists(public_path('assets/about/city.jpg')) ? asset('assets/about/city.jpg') : null)
        ?? 'https://images.unsplash.com/photo-1449157291145-7efd050a4d0e?auto=format&fit=crop&w=600&q=80';
    $aboutCone  = ($about?->cone_image ? media($about->cone_image) : null)
        ?? (file_exists(public_path('assets/about/cone.png')) ? asset('assets/about/cone.png') : null);
    $aboutBadge = ($about?->badge_image ? media($about->badge_image) : null)
        ?? (file_exists(public_path('assets/about/badge.png')) ? asset('assets/about/badge.png') : null);
@endphp

<img loading="lazy" decoding="async" class="ph1" src="{{ $aboutPhoto1 }}" alt="engineers">

@if ($aboutCone)
  <img loading="lazy" decoding="async" class="cone" src="{{ $aboutCone }}" alt="under construction">
@else
  <svg class="cone" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
    <ellipse cx="100" cy="184" rx="74" ry="12" fill="#00000016"/>
    <rect x="34" y="164" width="132" height="20" rx="6" fill="#ef8a14"/>
    <rect x="34" y="164" width="132" height="7" rx="3.5" fill="#ffac3a"/>
    <path d="M100 56 L70 164 L130 164 Z" fill="#f7951b"/>
    <path d="M100 56 L86 164 L130 164 Z" fill="#e8820e"/>
    <path d="M89 106 h22 l5 24 h-32 z" fill="#fff"/>
    <g transform="rotate(-14 92 72)">
      <ellipse cx="92" cy="74" rx="44" ry="10" fill="#eaa600"/>
      <path d="M52 74 a40 30 0 0 1 80 0 z" fill="#ffce1f"/>
      <path d="M70 74 a22 16 0 0 1 44 0" fill="#f5bd00"/>
      <rect x="87" y="46" width="10" height="10" rx="3" fill="#ffce1f"/>
    </g>
    <rect x="62" y="150" width="84" height="36" rx="3" fill="#ffd21a" stroke="#161616" stroke-width="2.5"/>
    <text x="104" y="166" font-family="Plus Jakarta Sans,Arial,sans-serif" font-size="12" font-weight="800" text-anchor="middle" fill="#161616">UNDER</text>
    <text x="104" y="180" font-family="Plus Jakarta Sans,Arial,sans-serif" font-size="9.5" font-weight="800" text-anchor="middle" fill="#161616">CONSTRUCTION</text>
  </svg>
@endif

<img loading="lazy" decoding="async" class="ph2" src="{{ $aboutPhoto2 }}" alt="city">

@if ($aboutBadge)
  <img loading="lazy" decoding="async" class="badge-img" src="{{ $aboutBadge }}" alt="10+ years of experience">
@else
  <div class="badge">
    <span class="medal"><svg width="38" height="44" viewBox="0 0 38 44" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M12 23l-4 18 7-4.5 4 6V25z" fill="#e8a317"/>
      <path d="M26 23l4 18-7-4.5-4 6V25z" fill="#cf8f12"/>
      <circle cx="19" cy="16" r="15" fill="#ffce4d"/>
      <circle cx="19" cy="16" r="10.5" fill="#f5a000"/>
      <path d="M19 8.5l2.4 4.9 5.4.8-3.9 3.8.9 5.4-4.8-2.5-4.8 2.5.9-5.4-3.9-3.8 5.4-.8z" fill="#fff"/>
    </svg></span>
    <div><b>{{ $about?->years_label ?: '10+ years' }}</b><span>{{ $about?->years_sub ?: 'of experience' }}</span></div>
  </div>
@endif
