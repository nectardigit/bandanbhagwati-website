@extends('layouts.app')

@section('title', $project->title.' — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', Str::limit(strip_tags($project->body), 150) ?: 'Construction project by Bandan Bhagwati Nirman Sewa.')
@section('og_image', og_url($project->cover_image))
@section('content')
@php($gallery = $project->gallery ?? [])

<!-- ===== WORK IN ACTION (intro) ===== -->
<section class="section" style="padding-bottom:40px">
  <div class="wrap">
    <span class="eyebrow">Our Ongoing Project</span>
    <h2 class="h-sec">{{ $project->title }}</h2>
    <p class="sub">Delivering quality through every step of the process.</p>
    <div class="pd-intro">
      <img loading="lazy" decoding="async" src="{{ media($project->cover_image) }}" alt="{{ $project->title }}">
      <img loading="lazy" decoding="async" src="{{ media($gallery[0] ?? $project->cover_image) }}" alt="{{ $project->title }}">
    </div>
    <div class="pd-text">
      @if ($project->body)
        {!! $project->body !!}
      @endif
    </div>
  </div>
</section>

@if (count($gallery))
<!-- ===== GALLERY ===== -->
<section class="section" style="padding-top:30px">
  <div class="wrap">
    <div class="head-row" style="align-items:flex-end">
      <div>
        <span class="eyebrow">Gallery</span>
        <h2 class="h-sec" style="margin-bottom:8px">Work in Pictures</h2>
        <p class="sub">A visual journey through our projects and achievements.</p>
      </div>
      <button class="btn btn-orange">View more <span class="ico"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M9 7h8v8"/></svg></span></button>
    </div>
    <div class="gallery-grid" id="galleryGrid">
      @foreach ($gallery as $g)
        <img loading="lazy" decoding="async" src="{{ media($g) }}" alt="gallery">
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- ===== PROJECT SPECIFICATION ===== -->
<section class="section" style="padding-top:20px">
  <div class="wrap">
    <span class="eyebrow">Project</span>
    <h2 class="h-sec" style="margin-bottom:8px">Project Specification</h2>
    <p class="sub">Detailed information about the technical specification, features, and current progress of our construction project.</p>
    <div class="spec-wrap">
      <div class="spec-card">
        <h3>Key Specifications</h3>
        @foreach (($project->specs ?? []) as $row)
        <div class="spec-row"><span class="k">{{ $row['label'] ?? '' }}</span><span class="v">{{ $row['value'] ?? '' }}</span></div>
        @endforeach
        @if (!is_null($project->progress))
        <div class="progress">
          <div class="top"><b>Overall Progress</b><b>{{ $project->progress }}%</b></div>
          <div class="bar"><i style="width:{{ $project->progress }}%"></i></div>
        </div>
        @endif
      </div>
      <div class="spec-card">
        <h3>Key Features</h3>
        <div id="featList">
          @foreach (($project->features ?? []) as $f)
          <div class="feat-card">
            <span class="fi" style="background:#fce9c9">{{ $f['icon'] ?? '🏗️' }}</span>
            <div><h4>{{ $f['title'] ?? '' }}</h4><p>{{ $f['text'] ?? '' }}</p></div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>

@if ($team->count())
<!-- ===== TEAM / WORK IN ACTION ===== -->
<section class="section" style="padding-top:20px">
  <div class="wrap">
    <span class="eyebrow">Our Ongoing Project</span>
    <h2 class="h-sec" style="margin-bottom:8px">Work in Action</h2>
    <p class="sub" style="margin-bottom:40px">Delivering quality through every step of the process.</p>
    <div class="team-row" id="teamRow">
      @foreach ($team as $m)
        <img loading="lazy" decoding="async" src="{{ media($m->photo) }}" alt="{{ $m->name }}">
      @endforeach
    </div>
  </div>
</section>
@endif
@endsection
