@extends('layouts.app')

@section('title', $equipment->name.' — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', Str::limit(strip_tags($equipment->description), 150) ?: 'Construction equipment for rent.')
@section('og_image', og_url($equipment->image))
@section('content')
@php($arrow = '<span class="ico"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M9 7h8v8"/></svg></span>')

<!-- ===== PAGE BANNER ===== -->
<section class="page-banner">
  <div class="bg" style="background-image:url('{{ $equipment->image ? media($equipment->image) : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1600&q=80' }}')"></div>
  <div class="wrap">
    <h1>{{ $equipment->title ?: $equipment->name }}</h1>
    <p class="crumb"><a href="{{ url('/') }}">Home</a> – <a href="{{ url('/equipment') }}">Equipment</a> – <span class="cur">{{ Str::limit($equipment->name, 40) }}</span></p>
  </div>
</section>

<!-- ===== EQUIPMENT DETAIL ===== -->
<section class="section">
  <div class="wrap sd-grid">
    <!-- LEFT -->
    <div class="sd-col">
      <h2>More Equipment</h2>
      <div class="more-serv" id="moreList">
        @foreach ($more as $m)
        <a class="serv-item" href="{{ route('equipment.show', $m) }}">
          <span>{{ $m->name }}</span>
          <span class="dot"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M9 7h8v8"/></svg></span>
        </a>
        @endforeach
      </div>

      <div class="rating-card">
        <div class="score">4.8</div>
        <div class="rev">5k + Review</div>
        <div class="clients">
          <div class="avatars">
            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=80&q=80" alt="">
            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=80&q=80" alt="">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=80&q=80" alt="">
            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=80&q=80" alt="">
          </div>
          <div><b>25,00+</b><span>Our Client</span></div>
        </div>
        <div class="anytime">
          <span class="bi">🏗️</span>
          <div><b>Any Where any time</b><span class="phone">{{ $settings['phone'] ?? '+977-9825252525' }}</span></div>
        </div>
        <button class="btn btn-orange" style="margin:0 auto" onclick="document.getElementById('rentForm').scrollIntoView({behavior:'smooth'})">Rent now {!! $arrow !!}</button>
      </div>

      <div class="rent-form" id="rentForm">
        <h3>Rent this equipment</h3>
        @if (session('enquiry_success'))
          <p class="form-ok">{{ session('enquiry_success') }}</p>
        @endif
        @if ($errors->any())
          <div class="form-err"><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        <form method="POST" action="{{ route('equipment.enquiry', $equipment) }}">
          @csrf
          <input type="text" name="name" placeholder="Your name" value="{{ old('name') }}" required maxlength="255" class="@error('name') invalid @enderror">
          <input type="email" name="email" placeholder="Your email" value="{{ old('email') }}" required maxlength="255" class="@error('email') invalid @enderror">
          <input type="tel" name="phone" placeholder="Phone number" value="{{ old('phone') }}" pattern="[0-9+\-\s()]{7,}" maxlength="50" class="@error('phone') invalid @enderror">
          <textarea name="message" rows="3" placeholder="Message (optional)" maxlength="5000" class="@error('message') invalid @enderror">{{ old('message') }}</textarea>
          @include('partials.captcha')
          <button class="btn btn-orange" type="submit" style="width:100%;justify-content:center">Send enquiry {!! $arrow !!}</button>
        </form>
      </div>
    </div>

    <!-- RIGHT -->
    <div class="sd-about">
      <h2 style="font-size:38px">{{ $equipment->title ?: $equipment->name }}</h2>
      @if ($equipment->price)
        <p style="color:var(--orange);font-weight:800;font-size:24px;margin:0 0 14px">{{ $equipment->price }}</p>
      @endif
      <img src="{{ media($equipment->image, 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?auto=format&fit=crop&w=1100&q=80') }}" alt="{{ $equipment->name }}">
      <p>{{ $equipment->description }}</p>
      @if (!empty($equipment->specs))
      <h3>Specifications</h3>
      <div class="spec-card" style="margin-bottom:26px">
        @foreach ($equipment->specs as $row)
        <div class="spec-row"><span class="k">{{ $row['label'] ?? '' }}</span><span class="v">{{ $row['value'] ?? '' }}</span></div>
        @endforeach
      </div>
      @endif
      <h3>Why rent from us</h3>
      <p>Well-maintained, site-ready machinery delivered on time with experienced operators and full support — so your project keeps moving without downtime.</p>
      <div class="exp-grid" id="expGrid">
        @foreach (['Certified & inspected','Operator available','Flexible rental terms','On-site delivery'] as $point)
        <div class="exp">
          <span class="ei"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="m8.5 12 2.5 2.5 4.5-5"/></svg></span>
          <div><h4>{{ $point }}</h4><p>Reliable equipment and support for large construction projects.</p></div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

@if (!empty($equipment->gallery))
<!-- ===== GALLERY ===== -->
<section class="section" style="padding-top:0">
  <div class="wrap">
    <span class="eyebrow">Gallery</span>
    <h2 class="h-sec" style="margin-bottom:30px">{{ $equipment->name }} in Pictures</h2>
    <div class="gallery-grid">
      @foreach ($equipment->gallery as $g)
        <img loading="lazy" decoding="async" src="{{ media($g) }}" alt="{{ $equipment->name }}">
      @endforeach
    </div>
  </div>
</section>
@endif

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
      <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?auto=format&fit=crop&w=800&q=80" alt="engineer">
    </div>
  </div>
</section>
@endsection
