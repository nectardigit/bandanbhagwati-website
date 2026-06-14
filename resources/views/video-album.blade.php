@extends('layouts.app')

@section('title', $album->title.' — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($album->description ?: $album->title), 150))

@section('content')
@php($videos = $album->videoList())
<section class="section">
  <div class="wrap">
    <a href="{{ route('videos') }}" class="view-more" style="margin-bottom:18px;display:inline-flex">&larr; All video albums</a>
    <span class="eyebrow">Video Album</span>
    <h2 class="h-sec">{{ $album->title }}</h2>
    @if ($album->description)<p class="sub" style="margin-bottom:40px">{{ $album->description }}</p>@endif

    @if (count($videos))
    <div class="video-grid" id="videoGrid">
      @foreach ($videos as $i => $v)
        @php($info = video_embed($v['url'] ?? ''))
        @php($thumb = ($v['thumb'] ?? null) ?: $info['thumb'])
        <button type="button" class="video-thumb" data-type="{{ $info['type'] }}" data-embed="{{ $info['embed'] }}" aria-label="Play {{ $v['title'] ?? 'video' }}">
          <span class="vt-media">
            @if ($thumb)
              <img loading="lazy" decoding="async" src="{{ media($thumb) }}" alt="{{ $v['title'] ?? $album->title }}">
            @endif
            <span class="vt-play"><svg width="26" height="26" viewBox="0 0 24 24" fill="#fff"><path d="M8 5v14l11-7z"/></svg></span>
          </span>
          @if (! empty($v['title']))<span class="vt-title">{{ $v['title'] }}</span>@endif
        </button>
      @endforeach
    </div>
    @else
      <p class="sub">No videos in this album yet.</p>
    @endif
  </div>
</section>

{{-- Video lightbox --}}
<div class="lightbox vlightbox" id="vLightbox" aria-hidden="true">
  <button class="lb-close" id="vLbClose" aria-label="Close">&times;</button>
  <div class="vlb-frame" id="vLbFrame"></div>
</div>
@endsection
