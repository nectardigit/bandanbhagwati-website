@extends('layouts.app')

@section('title', $post->title.' — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', Str::limit(strip_tags($post->excerpt ?: $post->body), 150))
@section('og_image', og_url($post->cover_image))
@section('content')

<!-- ===== PAGE BANNER ===== -->
<section class="page-banner">
  <div class="bg" style="background-image:url('{{ $post->cover_image ? media($post->cover_image) : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1600&q=80' }}')"></div>
  <div class="wrap">
    <h1>{{ $post->title }}</h1>
    <p class="crumb"><a href="{{ url('/') }}">Home</a> – <a href="{{ url('/blog') }}">Blog</a> – <span class="cur">{{ Str::limit($post->title, 40) }}</span></p>
  </div>
</section>

<!-- ===== BLOG DETAIL ===== -->
<section class="section">
  <div class="wrap bd-grid">
    <!-- MAIN -->
    <article class="bd-main">
      <img loading="lazy" decoding="async" src="{{ media($post->cover_image) }}" alt="{{ $post->title }}">
      <div class="bd-meta"><span>BY: {{ $post->author }}</span><span>{{ optional($post->published_at)->format('M d, Y') }}</span></div>
      <h2>{{ $post->title }}</h2>
      @if ($post->excerpt)<p>{{ $post->excerpt }}</p>@endif
      @if ($post->body)
        {!! $post->body !!}
      @endif
    </article>

    <!-- SIDEBAR -->
    <aside class="related">
      <h3>Related blog post</h3>
      <div id="relList">
        @foreach ($related as $r)
        <a class="rel-card" href="{{ route('blog.show', $r) }}">
          <img loading="lazy" decoding="async" src="{{ media($r->cover_image) }}" alt="{{ $r->title }}">
          <div>
            <div class="rmeta"><span>BY: {{ $r->author }}</span><span>{{ optional($r->published_at)->format('M d, Y') }}</span></div>
            <h4>{{ $r->title }}</h4>
          </div>
        </a>
        @endforeach
      </div>
    </aside>
  </div>
</section>
@endsection
