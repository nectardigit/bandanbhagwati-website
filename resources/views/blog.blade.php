@extends('layouts.app')

@section('title', 'Blog — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', 'Insights, industry updates, and project stories from Bandan Bhagwati Nirman Sewa.')

@section('content')
<!-- ===== PAGE BANNER ===== -->
<section class="page-banner">
  <div class="bg" style="background-image:url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1600&q=80')"></div>
  <div class="wrap">
    <h1>Blog</h1>
    <p class="crumb"><a href="{{ url('/') }}">Home</a> – <span class="cur">Blog</span></p>
  </div>
</section>

<!-- ===== BLOG GRID ===== -->
<section class="section">
  <div class="wrap">
    <div class="blog-list-grid" id="blogGrid">
      @foreach ($posts as $post)
      <a class="blog-card" href="{{ route('blog.show', $post) }}">
        <div class="thumb"><img loading="lazy" decoding="async" src="{{ media($post->cover_image) }}" alt="{{ $post->title }}"></div>
        <div class="blog-meta"><span>BY: {{ $post->author }}</span><span>{{ optional($post->published_at)->format('M d, Y') }}</span></div>
        <h3>{{ $post->title }}</h3>
      </a>
      @endforeach
    </div>

    @if ($posts->hasPages())
    <div class="pager">
      <a href="{{ $posts->previousPageUrl() ?: '#' }}">‹</a>
      @for ($i = 1; $i <= $posts->lastPage(); $i++)
        <a href="{{ $posts->url($i) }}" class="{{ $posts->currentPage() == $i ? 'active' : '' }}">{{ $i }}</a>
      @endfor
      <a href="{{ $posts->nextPageUrl() ?: '#' }}">›</a>
    </div>
    @endif
  </div>
</section>
@endsection
