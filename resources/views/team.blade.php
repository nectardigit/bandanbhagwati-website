@extends('layouts.app')

@section('title', 'Meet the Team — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', 'Meet the engineers and professionals behind Bandan Bhagwati Nirman Sewa.')

@section('content')
@php($social = '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M14 9h3l.5-3H14V4.5c0-.9.3-1.5 1.6-1.5H18V.2A21 21 0 0 0 15.5 0C12.9 0 11 1.6 11 4.4V6H8v3h3v9h3z"/></svg>')

<!-- ===== TEAM ===== -->
<section class="section">
  <div class="wrap">
    <span class="eyebrow">Our Team</span>
    <h2 class="h-sec">Meet the Team</h2>
    <p class="sub" style="margin-bottom:44px">The experienced board, engineers, and professionals behind Bandan Bhagwati Nirman Sewa.</p>

    @php($grouped = $members->groupBy(fn ($m) => $m->department ?: 'Our Team'))
    @foreach ($grouped as $department => $group)
    @if ($grouped->count() > 1)
    <h3 class="team-dept">{{ $department }}</h3>
    @endif
    <div class="team-grid">
      @foreach ($group as $m)
      <article class="team-card">
        <img loading="lazy" decoding="async" src="{{ media($m->photo) }}" alt="{{ $m->name }}">
        <div class="info">
          <b>{{ $m->name }}</b><span>{{ $m->role }}</span>
          <div class="ts">
            @if($m->facebook)<a href="{{ $m->facebook }}" aria-label="Facebook"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M14 9h3l.5-3H14V4.5c0-.9.3-1.5 1.6-1.5H18V.2A21 21 0 0 0 15.5 0C12.9 0 11 1.6 11 4.4V6H8v3h3v9h3z"/></svg></a>@endif
            @if($m->instagram)<a href="{{ $m->instagram }}" aria-label="Instagram"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg></a>@endif
            @if($m->twitter)<a href="{{ $m->twitter }}" aria-label="X"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h3l-7 8 8 12h-6l-5-6.5L6 22H3l7.5-9L3 2h6l4.5 6z"/></svg></a>@endif
            @if($m->linkedin)<a href="{{ $m->linkedin }}" aria-label="LinkedIn"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5A2.5 2.5 0 1 1 0 3.5a2.5 2.5 0 0 1 4.98 0zM0 8h5v16H0zM8 8h4.8v2.2h.06A5.3 5.3 0 0 1 17.6 8c5 0 5.9 3.3 5.9 7.6V24h-5v-7.5c0-1.8 0-4-2.5-4s-2.9 2-2.9 4V24H8z"/></svg></a>@endif
            @if($m->youtube)<a href="{{ $m->youtube }}" aria-label="YouTube"><svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M23 7.5a3 3 0 0 0-2.1-2.1C19 5 12 5 12 5s-7 0-8.9.4A3 3 0 0 0 1 7.5 31 31 0 0 0 .6 12 31 31 0 0 0 1 16.5a3 3 0 0 0 2.1 2.1C5 19 12 19 12 19s7 0 8.9-.4a3 3 0 0 0 2.1-2.1A31 31 0 0 0 23.4 12 31 31 0 0 0 23 7.5zM9.7 15.5v-7l6 3.5z"/></svg></a>@endif
          </div>
        </div>
      </article>
      @endforeach
    </div>
    @endforeach
  </div>
</section>
@endsection
