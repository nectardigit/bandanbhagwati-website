@extends('layouts.app')

@section('title', 'FAQ — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', 'Frequently asked questions about Bandan Bhagwati Nirman Sewa construction services.')

@section('content')
@php($arrow = '<span class="ico"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M9 7h8v8"/></svg></span>')
@php($grouped = $faqs->groupBy(fn ($f) => $f->category ?: 'General'))

<!-- ===== PAGE BANNER ===== -->
<section class="page-banner">
  <div class="bg" style="background-image:url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1600&q=80')"></div>
  <div class="wrap">
    <h1>FAQ</h1>
    <p class="crumb"><a href="{{ url('/') }}">Home</a> – <span class="cur">FAQ</span></p>
  </div>
</section>

<!-- ===== FAQ ===== -->
<section class="section">
  <div class="wrap faq-page">
    <!-- LEFT: grouped accordions -->
    <div class="faq-main">
      <span class="eyebrow">FAQ's</span>
      <h2 class="h-sec" style="margin-bottom:8px">Frequently Asked Questions</h2>
      <p class="sub" style="margin-bottom:28px">Everything you need to know about our services, process, and quality.</p>

      @if ($grouped->count() > 1)
      <div class="equip-filter faq-filter">
        <button class="active" data-cat="all">All</button>
        @foreach ($grouped->keys() as $cat)
          <button data-cat="{{ $cat }}">{{ $cat }}</button>
        @endforeach
      </div>
      @endif

      @forelse ($grouped as $group => $items)
        <div class="faq-group-block" data-cat="{{ $group }}">
          @if ($grouped->count() > 1)
            <h3 class="faq-group">{{ $group }}</h3>
          @endif
          <div class="faq-list">
            @foreach ($items as $faq)
            <div class="faq-item {{ $loop->first ? 'open' : '' }}">
              <div class="faq-q"><span>{{ $faq->question }}</span><span class="faq-plus">+</span></div>
              <div class="faq-a"><p>{{ $faq->answer }}</p></div>
            </div>
            @endforeach
          </div>
        </div>
      @empty
        <p class="sub">No FAQs yet.</p>
      @endforelse
    </div>

    <!-- RIGHT: help / contact card -->
    <aside class="faq-help">
      <span class="hi">💬</span>
      <h3>Still have questions?</h3>
      <p>Can't find the answer you're looking for? Our team is happy to help with anything about your project.</p>
      <a class="phone" href="tel:{{ preg_replace('/[^0-9+]/', '', $settings['phone'] ?? '+9779825252525') }}">📞 {{ $settings['phone'] ?? '+977-9825252525' }}</a>
      <a class="email" href="mailto:{{ $settings['email'] ?? 'bandanbhagwati@gmail.com' }}">✉️ {{ $settings['email'] ?? 'bandanbhagwati@gmail.com' }}</a>
      <a class="btn btn-orange" href="{{ url('/contact') }}" style="margin-top:6px">Contact us {!! $arrow !!}</a>
    </aside>
  </div>
</section>
@endsection
