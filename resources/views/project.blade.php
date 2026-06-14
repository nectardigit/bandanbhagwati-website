@extends('layouts.app')

@section('title', 'Projects — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', 'Showcasing our ongoing and completed construction projects.')

@section('content')
@php($arrow2 = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h13M13 6l6 6-6 6"/></svg>')

<!-- ===== PAGE BANNER ===== -->
<section class="page-banner">
  <div class="bg" style="background-image:url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1600&q=80')"></div>
  <div class="wrap">
    <h1>Project</h1>
    <p class="crumb"><a href="{{ url('/') }}">Home</a> – <span class="cur" id="projCrumb">Ongoing project</span></p>
  </div>
</section>

<!-- ===== PROJECTS ===== -->
<section class="section">
  <div class="wrap">
    <div class="head-row" style="align-items:center">
      <div>
        <span class="eyebrow" id="projEyebrow">Ongoing Project</span>
        <h2 class="h-sec" style="margin-bottom:6px">{{ $home?->project_page_title ?: 'Showcasing Our Work' }}</h2>
        <p class="sub">{{ $home?->project_page_desc ?: "Our clients' feedback speaks volumes about our commitment and quality." }}</p>
      </div>
      <div class="proj-toggle">
        <button class="active" data-set="ongoing">Ongoing</button>
        <button data-set="completed">Completed</button>
      </div>
    </div>
    @if ($categories->count())
    <div class="proj-cat-filter equip-filter" style="margin:18px 0 4px">
      <button class="active" data-cat="all">All</button>
      @foreach ($categories as $cat)
        <button data-cat="{{ $cat->slug }}">{{ $cat->name }}</button>
      @endforeach
    </div>
    @endif
    <div class="proj-grid" id="projGrid" style="row-gap:48px;margin-top:10px">
      @foreach ($ongoing as $p)
      <a class="proj-card" data-set="ongoing" data-cat="{{ $p->category->slug ?? '' }}" href="{{ route('projects.show', $p) }}">
        <img loading="lazy" decoding="async" src="{{ media($p->cover_image) }}" alt="{{ $p->title }}">
        <div class="cap"><small>{{ $p->category->name ?? $p->caption }}</small><b>{{ $p->client }}</b></div>
        <span class="more">Explore more {!! $arrow2 !!}</span>
      </a>
      @endforeach
      @foreach ($completed as $p)
      <a class="proj-card" data-set="completed" data-cat="{{ $p->category->slug ?? '' }}" href="{{ route('projects.show', $p) }}">
        <img loading="lazy" decoding="async" src="{{ media($p->cover_image) }}" alt="{{ $p->title }}">
        <div class="cap"><small>{{ $p->category->name ?? $p->caption }}</small><b>{{ $p->client }}</b></div>
        <span class="more">Explore more {!! $arrow2 !!}</span>
      </a>
      @endforeach
    </div>
  </div>
</section>
@endsection
