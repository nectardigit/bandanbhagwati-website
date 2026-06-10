@extends('layouts.app')

@section('title', 'Equipment — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', 'Browse our fleet of construction equipment available for rent.')

@section('content')
@php($arrow = '<span class="ico"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M9 7h8v8"/></svg></span>')

<!-- ===== PAGE BANNER ===== -->
<section class="page-banner">
  <div class="bg" style="background-image:url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1600&q=80')"></div>
  <div class="wrap">
    <h1>Equipment</h1>
    <p class="crumb"><a href="{{ url('/') }}">Home</a> – <span class="cur">Equipment</span></p>
  </div>
</section>

<!-- ===== EQUIPMENT GRID ===== -->
<section class="section">
  <div class="wrap">
    <span class="eyebrow">Our Fleet</span>
    <h2 class="h-sec">Equipment for Rent</h2>
    <p class="sub" style="margin-bottom:30px">Browse our extensive collection of well-maintained construction equipment.</p>
    @if ($categories->count())
    <div class="equip-filter">
      <button class="{{ ($activeCat ?? null) ? '' : 'active' }}" data-cat="all">All</button>
      @foreach ($categories as $c)
      <button class="{{ ($activeCat ?? null) == $c->id ? 'active' : '' }}" data-cat="{{ $c->id }}">{{ $c->name }}</button>
      @endforeach
    </div>
    @endif
    <div class="grid4" id="equipFilterGrid">
      @foreach ($items as $e)
      <article class="eq-card" data-cat="{{ $e->category_id }}">
        <img loading="lazy" decoding="async" src="{{ media($e->image) }}" alt="{{ $e->name }}">
        <div class="body">
          <h3>{{ $e->title ?: $e->name }}</h3>
          @if ($e->price)<p style="color:var(--orange);font-weight:700;margin:0 0 6px">{{ $e->price }}</p>@endif
          <p>{{ $e->description }}</p>
          <a class="btn btn-orange" href="{{ route('equipment.show', $e) }}">Rent Now {!! $arrow !!}</a>
        </div>
      </article>
      @endforeach
    </div>
  </div>
</section>
@endsection
