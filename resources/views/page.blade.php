@extends('layouts.app')

@section('title', $page->title.' — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', $page->meta_description ?: Str::limit(strip_tags($page->body), 150))
@section('content')

@if ($page->show_banner)
<!-- ===== PAGE BANNER ===== -->
<section class="page-banner">
  <div class="bg" style="background-image:url('{{ $page->banner_image ? media($page->banner_image) : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1600&q=80' }}')"></div>
  <div class="wrap">
    <h1>{{ $page->title }}</h1>
    <p class="crumb"><a href="{{ url('/') }}">Home</a> – <span class="cur">{{ $page->title }}</span></p>
  </div>
</section>
@endif

<!-- ===== PAGE BODY ===== -->
<section class="section">
  <div class="wrap">
    @unless ($page->show_banner)
      <h1 class="h-sec" style="margin-bottom:24px">{{ $page->title }}</h1>
    @endunless
    <div class="page-body">
      {!! $page->body !!}
    </div>
  </div>
</section>
@endsection
