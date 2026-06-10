@extends('layouts.app')

@section('title', $service->title.' — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', Str::limit(strip_tags($service->short_description ?: $service->body), 150))
@section('og_image', og_url($service->image))
@section('content')
@php($arrow = '<span class="ico"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M9 7h8v8"/></svg></span>')

<!-- ===== PAGE BANNER ===== -->
<section class="page-banner">
  <div class="bg" style="background-image:url('{{ $service->image ? media($service->image) : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1600&q=80' }}')"></div>
  <div class="wrap">
    <h1>{{ $service->title }}</h1>
    <p class="crumb"><a href="{{ url('/') }}">Home</a> – <a href="{{ url('/service') }}">Services</a> – <span class="cur">{{ Str::limit($service->title, 40) }}</span></p>
  </div>
</section>

<!-- ===== SERVICE DETAIL ===== -->
<section class="section">
  <div class="wrap sd-grid">
    <!-- LEFT -->
    <div class="sd-col">
      <h2>More Services</h2>
      <div class="more-serv" id="moreList">
        @foreach ($more as $m)
        <a class="serv-item" href="{{ route('services.show', $m) }}">
          <span>{{ $m->title }}</span>
          <span class="dot"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M9 7h8v8"/></svg></span>
        </a>
        @endforeach
      </div>

      <div class="rating-card">
        <div class="score">4.8</div>
        <div class="rev">5k + Review</div>
        <div class="clients">
          <div class="avatars">
            <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=80&q=80" alt="">
            <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=80&q=80" alt="">
            <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=80&q=80" alt="">
            <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=80&q=80" alt="">
          </div>
          <div><b>25,00+</b><span>Our Client</span></div>
        </div>
        <div class="anytime">
          <span class="bi">🏙️</span>
          <div><b>Any Where any time</b><span class="phone">{{ $settings['phone'] ?? '+977-9825252525' }}</span></div>
        </div>
        <button class="btn btn-orange" style="margin:0 auto" onclick="location.href='{{ url('/contact') }}'">Contact now {!! $arrow !!}</button>
      </div>
    </div>

    <!-- RIGHT -->
    <div class="sd-about">
      <h2 style="font-size:38px">About the service</h2>
      <img loading="lazy" decoding="async" src="{{ media($service->image, 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1100&q=80') }}" alt="{{ $service->title }}">
      @if ($service->body)
        {!! $service->body !!}
      @else
        <p>{{ $service->short_description }}</p>
      @endif
      <h3>Why choose us</h3>
      <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia conseuntur magni.</p>
      <div class="exp-grid" id="expGrid">
        @for ($i = 0; $i < 4; $i++)
        <div class="exp">
          <span class="ei"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2l2.2 4.6L19 7.3l-3.5 3.4.8 4.8L12 13.2 7.7 15.5l.8-4.8L5 7.3l4.8-.7z"/></svg></span>
          <div><h4>Expertise</h4><p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet.</p></div>
        </div>
        @endfor
      </div>
    </div>
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
