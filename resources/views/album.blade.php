@extends('layouts.app')

@section('title', $album->title.' — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($album->description ?: $album->title), 150))
@section('og_image', og_url($album->cover ?: ($album->images[0] ?? null)))

@section('content')
@php($photos = $album->photos())
<section class="section">
  <div class="wrap">
    <a href="{{ route('gallery') }}" class="view-more" style="margin-bottom:18px;display:inline-flex">&larr; All albums</a>
    <span class="eyebrow">Album</span>
    <h2 class="h-sec">{{ $album->title }}</h2>
    @if ($album->description)<p class="sub" style="margin-bottom:40px">{{ $album->description }}</p>@endif

    @if (count($photos))
    <div class="photo-grid" id="albumGrid">
      @foreach ($photos as $i => $img)
        <button type="button" class="photo-thumb" data-full="{{ media($img) }}" data-index="{{ $i }}" aria-label="Open photo {{ $i + 1 }}">
          <img loading="lazy" decoding="async" src="{{ media($img) }}" alt="{{ $album->title }} — photo {{ $i + 1 }}">
        </button>
      @endforeach
    </div>
    @else
      <p class="sub">No photos in this album yet.</p>
    @endif
  </div>
</section>

{{-- Lightbox --}}
<div class="lightbox" id="lightbox" aria-hidden="true">
  <button class="lb-close" id="lbClose" aria-label="Close">&times;</button>
  <button class="lb-nav lb-prev" id="lbPrev" aria-label="Previous">&#8249;</button>
  <img class="lb-img" id="lbImg" src="" alt="">
  <button class="lb-nav lb-next" id="lbNext" aria-label="Next">&#8250;</button>
  <div class="lb-counter" id="lbCounter"></div>
</div>
@endsection
