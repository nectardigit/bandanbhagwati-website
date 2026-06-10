@extends('layouts.app')

@section('title', 'Services — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', 'Comprehensive construction solutions designed to meet your goals.')

@section('content')
@php($arrow = '<span class="ico"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M9 7h8v8"/></svg></span>')
@php($vmArrow = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M7 17 17 7M9 7h8v8"/></svg>')
@php($icons = [
  'building'  => '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 21h18M5 21V7l7-4 7 4v14"/><path d="M9 9h0M9 13h0M9 17h0M15 9h0M15 13h0M15 17h0"/></svg>',
  'renovate'  => '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 21h18M6 21V10l6-4 6 4v11"/><path d="m14 13 4-4 3 3-4 4z"/></svg>',
  'robot'     => '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3M5 5l2 2M17 17l2 2M19 5l-2 2M7 17l-2 2"/></svg>',
  'home'      => '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="m3 11 9-7 9 7M5 10v10h14V10"/><path d="m9 14 2 2 4-4"/></svg>',
  'blueprint' => '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 8h6M7 12h4M14 16l3-3 1 1-3 3z"/></svg>',
  'crane'     => '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M5 21V5l14-2v4M5 7h14M9 7v3M9 10h4v4H9z"/></svg>',
  'tower'     => '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M9 21V3h6v18M9 7h6M9 11h6M9 15h6"/></svg>',
])

<!-- ===== PAGE BANNER ===== -->
<section class="page-banner">
  <div class="bg" style="background-image:url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1600&q=80')"></div>
  <div class="wrap">
    <h1>Service</h1>
    <p class="crumb"><a href="{{ url('/') }}">Home</a> – <span class="cur">Service</span></p>
  </div>
</section>

<!-- ===== SOLUTIONS WE PROVIDE ===== -->
<section class="section">
  <div class="wrap">
    <span class="eyebrow">Our Services</span>
    <h2 class="h-sec">Solutions We Provide</h2>
    <p class="sub" style="margin-bottom:46px">Comprehensive solutions designed to meet your goals.</p>
    <div class="svc-grid" id="svcGrid">
      @foreach ($solutions as $sol)
      <a class="svc-card" href="{{ route('services.show', $sol) }}">
        <div class="top"><span class="ic">{!! $icons[$sol->icon] ?? $icons['building'] !!}</span><h3>{{ $sol->title }}</h3></div>
        <p>{{ $sol->short_description }}</p>
        <span class="view-more" style="font-size:15px">View more {!! $vmArrow !!}</span>
      </a>
      @endforeach
    </div>
  </div>
</section>

<!-- ===== SERVICES ===== -->
<section class="section services" id="services">
  <div class="wrap">
    <div class="serv-left">
      <span class="eyebrow">Services</span>
      <h2>Trusted Construction Services for Every Client</h2>
      <p class="sub">Delivering reliable, innovative, and high-quality construction solutions tailored to every client's needs. Committed to excellence with services designed to build trust and lasting value.</p>
      <div class="serv-list" id="servList">
        @foreach ($services as $service)
        <div class="serv-item {{ $loop->first ? 'active' : '' }}"
             data-title="{{ $service->title }}"
             data-desc="{{ $service->short_description }}"
             data-image="{{ $service->image ? media($service->image) : '' }}"
             data-url="{{ route('services.show', $service) }}">
          <span>{{ $service->title }}</span>
          <span class="dot"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M9 7h8v8"/></svg></span>
        </div>
        @endforeach
      </div>
    </div>
    @php($firstSvc = $services->first())
    <div class="serv-right">
      <div style="text-align:right;margin-bottom:20px"><a href="{{ url('/service') }}" class="view-more">View more <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M9 7h8v8"/></svg></a></div>
      <div class="serv-card">
        <div class="serv-media">
          <img loading="lazy" decoding="async" src="{{ $firstSvc && $firstSvc->image ? media($firstSvc->image) : 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?auto=format&fit=crop&w=900&q=80' }}" alt="service">
          <button class="btn btn-orange" onclick="location.href='{{ $firstSvc ? route('services.show', $firstSvc) : url('/service') }}'">Explore now {!! $arrow !!}</button>
        </div>
        <div class="body">
          <h3>{{ $firstSvc->title ?? 'Trusted Construction Services' }}</h3>
          <p>{{ $firstSvc->short_description ?? 'Delivering reliable, innovative, and high-quality construction solutions tailored to every client\'s needs.' }}</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== STATS ===== -->
<section class="stats">
  <div class="wrap">
    <div class="stat"><span class="si">🏆</span><div><b>{{ $settings['stat_awards'] ?? '40+' }}</b><span>World awards</span></div></div>
    <div class="stat"><span class="si">📋</span><div><b>{{ $settings['stat_projects'] ?? '80+' }}</b><span>Project Success</span></div></div>
    <div class="stat"><span class="si">👥</span><div><b>{{ $settings['stat_team'] ?? '60+' }}</b><span>Team members</span></div></div>
    <div class="stat"><span class="si">🎗️</span><div><b>{{ $settings['stat_clients'] ?? '99+' }}</b><span>Client Satisfaction</span></div></div>
  </div>
</section>

<!-- ===== CONTACT CTA ===== -->
<section class="contact">
  <div class="img" style="background-image:url('https://images.unsplash.com/photo-1565008447742-97f6f38c985c?auto=format&fit=crop&w=1000&q=80')"></div>
  <div class="panel">
    <span class="eyebrow">Contactat Us Anytime</span>
    <h2>Have a Project in Mind? Let's Talk.</h2>
    <p>Bandan Bhagwato is a sacred expression of devotion and cultural unity. It represents the deep bond between faith, tradition, and community, bringing people together in reverence and shared belief. Rooted in spiritual values, Bandan Bhagwato stands as a meaningful symbol of harmony and purpose.</p>
    <button class="btn btn-orange" style="align-self:flex-start" onclick="location.href='{{ url('/contact') }}'">Explore now {!! $arrow !!}</button>
  </div>
</section>

<!-- ===== FAQ ===== -->
<section class="section faq">
  <div class="wrap">
    <div>
      <span class="eyebrow">FAQ's</span>
      <h2 class="h-sec">frequently asked questions</h2>
      <p class="sub">Delivering quality through every step of the process.</p>
      <div class="faq-list" id="faqList">
        @foreach ($faqs as $faq)
        <div class="faq-item {{ $loop->first ? 'open' : '' }}">
          <div class="faq-q"><span>{{ $faq->question }}</span><span class="faq-plus">+</span></div>
          <div class="faq-a"><p>{{ $faq->answer }}</p></div>
        </div>
        @endforeach
      </div>
    </div>
    <div class="faq-img">
      <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1521791136064-7986c2920216?auto=format&fit=crop&w=800&q=80" alt="engineer">
    </div>
  </div>
</section>
@endsection
