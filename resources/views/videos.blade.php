@extends('layouts.app')

@section('title', 'Video Gallery — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', 'Video albums of projects and works by Bandan Bhagwati Nirman Sewa.')

@section('content')
<section class="section">
  <div class="wrap">
    <span class="eyebrow">Videos</span>
    <h2 class="h-sec">Video Gallery</h2>
    <p class="sub" style="margin-bottom:46px">Watch our project and works video albums.</p>

    @if ($albums->count())
    <div class="album-grid">
      @foreach ($albums as $album)
        @php($first = $album->videos[0] ?? null)
        @php($cover = $album->cover ?: ($first['thumb'] ?? null) ?: (($first && ! empty($first['url'])) ? video_embed($first['url'])['thumb'] : null))
        <a class="album-card" href="{{ route('videos.show', $album) }}">
          <div class="album-cover">
            @if ($cover)<img loading="lazy" decoding="async" src="{{ media($cover) }}" alt="{{ $album->title }}">@endif
            <span class="album-play"><svg width="22" height="22" viewBox="0 0 24 24" fill="#fff"><path d="M8 5v14l11-7z"/></svg></span>
            <span class="album-count">{{ is_array($album->videos) ? count($album->videos) : 0 }} videos</span>
          </div>
          <div class="album-meta">
            <h3>{{ $album->title }}</h3>
            @if ($album->description)<p>{{ \Illuminate\Support\Str::limit($album->description, 80) }}</p>@endif
          </div>
        </a>
      @endforeach
    </div>
    @else
      <p class="sub">No video albums yet. Please check back soon.</p>
    @endif
  </div>
</section>
@endsection
