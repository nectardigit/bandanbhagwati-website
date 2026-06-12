@extends('layouts.app')

@section('title', 'Photo Gallery — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', 'Photo albums of projects, equipment and works by Bandan Bhagwati Nirman Sewa.')

@section('content')
<section class="section">
  <div class="wrap">
    <span class="eyebrow">{{ $home?->gallery_eyebrow ?: 'Gallery' }}</span>
    <h2 class="h-sec">{{ $home?->gallery_title ?: 'Photo Gallery' }}</h2>
    <p class="sub" style="margin-bottom:46px">{{ $home?->gallery_desc ?: 'Browse our project and works photo albums.' }}</p>

    @if ($albums->count())
    <div class="album-grid">
      @foreach ($albums as $album)
        @php($cover = $album->cover ?: ($album->images[0] ?? null))
        <a class="album-card" href="{{ route('gallery.show', $album) }}">
          <div class="album-cover">
            @if ($cover)<img loading="lazy" decoding="async" src="{{ media($cover) }}" alt="{{ $album->title }}">@endif
            <span class="album-count">{{ is_array($album->images) ? count($album->images) : 0 }} photos</span>
          </div>
          <div class="album-meta">
            <h3>{{ $album->title }}</h3>
            @if ($album->description)<p>{{ \Illuminate\Support\Str::limit($album->description, 80) }}</p>@endif
          </div>
        </a>
      @endforeach
    </div>
    @else
      <p class="sub">No albums yet. Please check back soon.</p>
    @endif
  </div>
</section>
@endsection
