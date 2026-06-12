@extends('layouts.app')

@section('title', 'About Us — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', 'Learn about Bandan Bhagwati Nirman Sewa — turning your vision into reality.')

@section('content')
@php($arrow = '<span class="ico"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M9 7h8v8"/></svg></span>')

<!-- ===== PAGE BANNER ===== -->
<section class="page-banner">
  <div class="bg" style="background-image:url('{{ $about?->banner_image ? media($about->banner_image) : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1600&q=80' }}')"></div>
  <div class="wrap">
    <h1>{{ $about?->banner_title ?: 'About Us' }}</h1>
    <p class="crumb"><a href="{{ url('/') }}">Home</a> – <span class="cur">{{ $about?->banner_title ?: 'About us' }}</span></p>
  </div>
</section>

<!-- ===== ABOUT ===== -->
<section class="section about">
  <div class="wrap">
    <div class="about-imgs">
      @include('partials.about-imgs')
    </div>
    <div class="about-body">
      <span class="eyebrow">{{ $about?->eyebrow ?: 'About' }}</span>
      <h2>{{ $about?->heading ?: 'Turning Your Vision into Reality, Starting with the Basics' }}</h2>
      @php($aboutFeatures = $about?->features ?: [
        ['title' => "Validate your manufacturer's warranty", 'text' => 'Magna reprehenderit tempor do elit mollit officia fugiat ullamco duis ex aute quis. Est excepteur velit incididunt laborum nulla minim.'],
        ['title' => "Validate your manufacturer's warranty", 'text' => 'Magna reprehenderit tempor do elit mollit officia fugiat ullamco duis ex aute quis. Est excepteur velit incididunt laborum nulla minim.'],
      ])
      @foreach ($aboutFeatures as $f)
      <div class="feat">
        <span class="ck"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="m8.5 12 2.5 2.5 4.5-5"/></svg></span>
        <div><h4>{{ $f['title'] ?? '' }}</h4>@include('partials.feat-text', ['text' => $f['text'] ?? ''])</div>
      </div>
      @endforeach
      <div class="about-cards">
        <div class="about-card"><span class="ic"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="8" r="6"/><path d="M8.2 13.6 7 22l5-3 5 3-1.2-8.4"/><path d="m12 5 1 2 2.1.3-1.5 1.5.4 2.1L12 11.9 9.5 12.9l.4-2.1L8.4 9.3 10.5 9z"/></svg></span>{{ $about?->card_one ?: 'Building quality standards' }}</div>
        <div class="about-card"><span class="ic"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="9" cy="8" r="3.2"/><path d="M3 20a6 6 0 0 1 12 0"/><path d="M15.5 5a3 3 0 0 1 0 6M21 20a6 6 0 0 0-4.5-5.8"/></svg></span>{{ $about?->card_two ?: "Certified engineer's team" }}</div>
      </div>
      <button class="btn btn-orange" onclick="location.href='{{ url($about?->explore_url ?: '/service') }}'">Explore now {!! $arrow !!}</button>
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
          <img loading="lazy" decoding="async" src="{{ ($firstSvc && $firstSvc->image) ? media($firstSvc->image) : ($about?->service_image ? media($about->service_image) : 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?auto=format&fit=crop&w=900&q=80') }}" alt="service">
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
    <span class="eyebrow">{{ $about?->cta_eyebrow ?: 'Contactat Us Anytime' }}</span>
    <h2>{{ $about?->cta_heading ?: "Have a Project in Mind? Let's Talk." }}</h2>
    <p>{{ $about?->cta_text ?: 'Bandan Bhagwato is a sacred expression of devotion and cultural unity. It represents the deep bond between faith, tradition, and community, bringing people together in reverence and shared belief. Rooted in spiritual values, Bandan Bhagwato stands as a meaningful symbol of harmony and purpose.' }}</p>
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
      <img loading="lazy" decoding="async" src="{{ $about?->faq_image ? media($about->faq_image) : 'https://images.unsplash.com/photo-1521791136064-7986c2920216?auto=format&fit=crop&w=800&q=80' }}" alt="engineer">
    </div>
  </div>
</section>
@endsection
