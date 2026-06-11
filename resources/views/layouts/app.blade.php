 <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
{{-- Favicon — uses the "favicon" setting, else the logo, else the static file --}}
@php($faviconUrl = !empty($settings['favicon']) ? media($settings['favicon']) : (!empty($settings['logo_image']) ? media($settings['logo_image']) : asset('favicon.ico')))
<link rel="icon" href="{{ $faviconUrl }}">
<link rel="shortcut icon" href="{{ $faviconUrl }}">
<link rel="apple-touch-icon" href="{{ $faviconUrl }}">
{{-- Google Search Console verification — paste your code in Admin → Site Settings → google_verification --}}
@if (!empty($settings['google_verification']))
<meta name="google-site-verification" content="{{ $settings['google_verification'] }}">
@endif
<title>@yield('title', ($settings['company_name'] ?? 'Bandan Bhagwati').' '.($settings['company_sub'] ?? 'Nirman Sewa Pvt. Ltd.'))</title>
<meta name="description" content="@yield('meta_description', 'Bandan Bhagwati Nirman Sewa — your trusted construction partner across Nepal.')">
<meta property="og:title" content="@yield('title', $settings['company_name'] ?? 'Bandan Bhagwati')">
<meta property="og:description" content="@yield('meta_description', 'Your trusted construction partner across Nepal.')">
<meta property="og:type" content="website">
@php($canonical = rtrim(config('app.site_url'), '/').'/'.ltrim(request()->path(), '/'))
<link rel="canonical" href="{{ $canonical }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="@yield('og_image', og_url(null))">
<meta property="og:site_name" content="{{ $settings['company_name'] ?? 'Bandan Bhagwati' }}">
<meta property="og:locale" content="en_US">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('title', $settings['company_name'] ?? 'Bandan Bhagwati')">
<meta name="twitter:description" content="@yield('meta_description', 'Your trusted construction partner across Nepal.')">
<meta name="twitter:image" content="@yield('og_image', og_url(null))">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/styles.css') }}">
@stack('head')
</head>
<body>

@php($s = $settings ?? [])

<!-- ===== TOP BAR ===== -->
<div class="topbar">
  <div class="wrap">
    <div class="left">
      <span class="item"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s-7-6.3-7-11a7 7 0 0 1 14 0c0 4.7-7 11-7 11z"/><circle cx="12" cy="10" r="2.6"/></svg> {{ $s['address'] ?? 'Sundhara kathmandu, nepal' }}</span>
      <a class="item" href="mailto:{{ $s['email'] ?? 'bandanbhagwati@gmail.com' }}"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg> {{ $s['email'] ?? 'bandanbhagwati@gmail.com' }}</a>
      <a class="item" href="tel:{{ preg_replace('/[^0-9+]/', '', $s['phone'] ?? '+9779825252525') }}"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3.1-8.7A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg> {{ $s['phone'] ?? '+977-9825252525' }}</a>
    </div>
    <div class="right">
      <a class="item" href="{{ $s['support_url'] ?? '#' }}"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18.4 11A6.4 6.4 0 0 0 5.6 11"/><path d="M12 2a10 10 0 0 0-10 10v4a3 3 0 0 0 3 3h1v-7H4"/><path d="M22 16v-4A10 10 0 0 0 12 2"/><path d="M20 17v1a3 3 0 0 1-3 3h-4"/><path d="M22 13v3a3 3 0 0 1-3 0v-3a1 1 0 0 1 3 0z"/></svg> {{ $s['support_label'] ?? 'Support' }}</a>
      <div class="socials">
        <a href="{{ $s['social_facebook'] ?? '#' }}" aria-label="Facebook"><svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M14 9h3l.5-3H14V4.5c0-.9.3-1.5 1.6-1.5H18V.2A21 21 0 0 0 15.5 0C12.9 0 11 1.6 11 4.4V6H8v3h3v9h3z"/></svg></a>
        <a href="{{ $s['social_instagram'] ?? '#' }}" aria-label="Instagram"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg></a>
        <a href="{{ $s['social_twitter'] ?? '#' }}" aria-label="X"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h3l-7 8 8 12h-6l-5-6.5L6 22H3l7.5-9L3 2h6l4.5 6z"/></svg></a>
        <a href="{{ $s['social_linkedin'] ?? '#' }}" aria-label="LinkedIn"><svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5A2.5 2.5 0 1 1 0 3.5a2.5 2.5 0 0 1 4.98 0zM0 8h5v16H0zM8 8h4.8v2.2h.06A5.3 5.3 0 0 1 17.6 8c5 0 5.9 3.3 5.9 7.6V24h-5v-7.5c0-1.8 0-4-2.5-4s-2.9 2-2.9 4V24H8z"/></svg></a>
        <a href="{{ $s['social_youtube'] ?? '#' }}" aria-label="YouTube"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23 7.5a3 3 0 0 0-2.1-2.1C19 5 12 5 12 5s-7 0-8.9.4A3 3 0 0 0 1 7.5 31 31 0 0 0 .6 12 31 31 0 0 0 1 16.5a3 3 0 0 0 2.1 2.1C5 19 12 19 12 19s7 0 8.9-.4a3 3 0 0 0 2.1-2.1A31 31 0 0 0 23.4 12 31 31 0 0 0 23 7.5zM9.7 15.5v-7l6 3.5z"/></svg></a>
      </div>
    </div>
  </div>
</div>

<!-- ===== HEADER ===== -->
<header class="header">
  <div class="header-inner">
    <div class="brand-wrap">
      <a class="logo" href="{{ url('/') }}">
        @if (!empty($s['logo_image']))
          <img class="logo-img" src="{{ media($s['logo_image']) }}" alt="{{ $s['company_name'] ?? 'Bandan Bhagwati' }}">
        @else
          <svg class="mark" viewBox="0 0 70 60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6 30a29 29 0 0 1 58 0H6z" fill="#1f9ad6"/>
            <path d="M14 30a21 21 0 0 1 42 0H14z" fill="#0b4fa8"/>
            <circle cx="35" cy="22" r="6" fill="#cfe9f7"/>
            <rect x="10" y="34" width="50" height="6" rx="1" fill="#0b4fa8"/>
            <path d="M16 40v12M54 40v12M22 52c0-4 4-7 7-7s7 3 7 7M34 52c0-4 4-7 7-7s7 3 7 7" stroke="#f5a000" stroke-width="4" stroke-linecap="round"/>
            <rect x="26" y="44" width="18" height="8" fill="#f5a000"/>
          </svg>
          <span class="txt"><b>{{ $s['company_name'] ?? 'BANDAN BHAGWATI' }}</b><span>{{ $s['company_sub'] ?? 'NIRMAN SEWA PVT. LTD.' }}</span></span>
        @endif
      </a>
    </div>
    @php($navActive = function ($u) {
        if ($u === '/' || $u === url('/')) return request()->is('/');
        if (\Illuminate\Support\Str::startsWith($u, '/')) return request()->is(trim($u, '/').'*');
        return false;
    })
    <nav class="nav-blue">
      <div class="nav">
        @forelse ($menuHeader as $item)
          @if ($item->children->count())
            <div class="has-drop">
              <a href="{{ $item->link }}" class="{{ $navActive($item->link) ? 'active' : '' }}">{{ $item->label }} <span class="caret">▾</span></a>
              <div class="dropdown">
                @foreach ($item->children as $child)
                  <a href="{{ $child->link }}" @if($child->open_new_tab) target="_blank" rel="noopener" @endif>{{ $child->label }}</a>
                @endforeach
              </div>
            </div>
          @else
            <a href="{{ $item->link }}" class="{{ $navActive($item->link) ? 'active' : '' }}" @if($item->open_new_tab) target="_blank" rel="noopener" @endif>{{ $item->label }}</a>
          @endif
        @empty
          <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
          <a href="{{ url('/about') }}">About Us</a>
          <a href="{{ url('/service') }}">Services</a>
          <a href="{{ url('/contact') }}">Connect</a>
        @endforelse
      </div>
      <div class="nav-actions">
        <button class="btn talk-btn" onclick="location.href='{{ $s['talk_url'] ?? url('/contact') }}'">{{ $s['talk_label'] ?? "Let's Talk" }} <span class="ico"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M9 7h8v8"/></svg></span></button>
      </div>
    </nav>
  </div>
</header>

@yield('content')

<!-- ===== NEWSLETTER ===== -->
<section class="news">
  <div class="bg" style="background-image:url('https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&w=1600&q=80')"></div>
  <div class="wrap">
    <h2>Subscribe to our newsletter to receive more updates</h2>
    <p>Get the newest travel offers, expert destination tips, and members-only deals.</p>
    @if (session('newsletter_success'))
      <p style="color:#fff;font-weight:600;margin-bottom:12px">{{ session('newsletter_success') }}</p>
    @endif
    <form method="POST" action="{{ route('newsletter.submit') }}">
      @csrf
      <input type="email" name="email" placeholder="Enter your email address" required>
      <button class="btn btn-orange" type="submit">Subscribe</button>
    </form>
    @error('email')<p style="color:#ffd;margin-top:8px">{{ $message }}</p>@enderror
  </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="footer">
  <div class="wrap">
    <div>
      <div class="logo-box">
        <a class="logo" href="{{ url('/') }}">
          @if (!empty($s['logo_image']))
            <img class="logo-img" src="{{ media($s['logo_image']) }}" alt="{{ $s['company_name'] ?? 'Bandan Bhagwati' }}">
          @else
            <svg class="mark" viewBox="0 0 70 60" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M6 30a29 29 0 0 1 58 0H6z" fill="#1f9ad6"/>
              <path d="M14 30a21 21 0 0 1 42 0H14z" fill="#0b4fa8"/>
              <circle cx="35" cy="22" r="6" fill="#cfe9f7"/>
              <rect x="10" y="34" width="50" height="6" rx="1" fill="#0b4fa8"/>
              <path d="M16 40v12M54 40v12M22 52c0-4 4-7 7-7s7 3 7 7M34 52c0-4 4-7 7-7s7 3 7 7" stroke="#f5a000" stroke-width="4" stroke-linecap="round"/>
              <rect x="26" y="44" width="18" height="8" fill="#f5a000"/>
            </svg>
            <span class="txt"><b>{{ $s['company_name'] ?? 'BANDAN BHAGWATI' }}</b><span>{{ $s['company_sub'] ?? 'NIRMAN SEWA PVT. LTD.' }}</span></span>
          @endif
        </a>
      </div>
      <p class="about-txt">{{ $s['footer_about'] ?? 'Bandan Bhagwati is a sacred celebration symbolizing unity, devotion, and cultural heritage.' }}</p>
      <p class="foll">Follow Us:</p>
      <div class="socials2">
        <a href="{{ $s['social_youtube'] ?? '#' }}" aria-label="YouTube"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M23 7.5a3 3 0 0 0-2.1-2.1C19 5 12 5 12 5s-7 0-8.9.4A3 3 0 0 0 1 7.5 31 31 0 0 0 .6 12 31 31 0 0 0 1 16.5a3 3 0 0 0 2.1 2.1C5 19 12 19 12 19s7 0 8.9-.4a3 3 0 0 0 2.1-2.1A31 31 0 0 0 23.4 12 31 31 0 0 0 23 7.5zM9.7 15.5v-7l6 3.5z"/></svg></a>
        <a href="{{ $s['social_twitter'] ?? '#' }}" aria-label="X"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h3l-7 8 8 12h-6l-5-6.5L6 22H3l7.5-9L3 2h6l4.5 6z"/></svg></a>
        <a href="{{ $s['social_linkedin'] ?? '#' }}" aria-label="LinkedIn"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5A2.5 2.5 0 1 1 0 3.5a2.5 2.5 0 0 1 4.98 0zM0 8h5v16H0zM8 8h4.8v2.2h.06A5.3 5.3 0 0 1 17.6 8c5 0 5.9 3.3 5.9 7.6V24h-5v-7.5c0-1.8 0-4-2.5-4s-2.9 2-2.9 4V24H8z"/></svg></a>
        <a href="{{ $s['social_instagram'] ?? '#' }}" aria-label="Instagram"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg></a>
        <a href="{{ $s['social_facebook'] ?? '#' }}" aria-label="Facebook"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M14 9h3l.5-3H14V4.5c0-.9.3-1.5 1.6-1.5H18V.2A21 21 0 0 0 15.5 0C12.9 0 11 1.6 11 4.4V6H8v3h3v9h3z"/></svg></a>
      </div>
    </div>
    <div>
      <h5>COMPANY</h5>
      <ul>
        @forelse ($menuFooterCompany as $item)
          <li><a href="{{ $item->link }}" @if($item->open_new_tab) target="_blank" rel="noopener" @endif>{{ $item->label }}</a></li>
        @empty
          <li><a href="{{ url('/about') }}">About us</a></li>
          <li><a href="{{ url('/contact') }}">Contact us</a></li>
        @endforelse
      </ul>
    </div>
    <div>
      <h5>QUICK LINKS</h5>
      <ul>
        @forelse ($menuFooterQuick as $item)
          <li><a href="{{ $item->link }}" @if($item->open_new_tab) target="_blank" rel="noopener" @endif>{{ $item->label }}</a></li>
        @empty
          <li><a href="#">Terms &amp; Conditions</a></li>
          <li><a href="#">Privacy Policy</a></li>
        @endforelse
      </ul>
    </div>
    <div>
      <h5>CONTACT INFO</h5>
      <div class="ci"><span class="ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3.1-8.7A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg></span> {{ $s['phone'] ?? '+977-9825252525' }}{{ !empty($s['phone2']) ? ' / '.$s['phone2'] : '' }}</div>
      <div class="ci"><span class="ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg></span> {{ $s['email'] ?? 'bandanbhagwati@gmail.com' }}</div>
      <div class="ci"><span class="ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s-7-6.3-7-11a7 7 0 0 1 14 0c0 4.7-7 11-7 11z"/><circle cx="12" cy="10" r="2.6"/></svg></span> {{ $s['address'] ?? 'Sundhara kathmandu, nepal' }}</div>
    </div>
  </div>
  <div class="footer-bot">
    <div class="wrap">
      <span>Copyright © {{ date('Y') }} {{ $s['company_name'] ?? 'Bandan Bhagwati' }}. All rights reserved.</span>
      <span class="dev">• Developed BY: <b>Nectar Digit</b></span>
    </div>
  </div>
</footer>

<script src="{{ asset('assets/app.js') }}"></script>
<script src="{{ asset('assets/nav.js') }}"></script>
@stack('scripts')
</body>
</html>
