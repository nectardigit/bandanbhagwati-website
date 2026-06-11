@extends('layouts.app')

@section('title', 'Our Clients — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', 'Government bodies and leading organizations that trust Bandan Bhagwati Nirman Sewa Pvt. Ltd. across Nepal.')

@section('content')
<section class="section">
  <div class="wrap">
    <span class="eyebrow">Our Clients</span>
    <h2 class="h-sec">Trusted by Leading Organizations</h2>
    <p class="sub" style="margin-bottom:46px">We are proud to have delivered infrastructure projects for government bodies, ministries, and leading organizations across Nepal.</p>

    <div class="clients-page-grid">
      @foreach ($clients as $cl)
        <div class="client-card">
          @if ($cl->url)<a href="{{ $cl->url }}" target="_blank" rel="noopener">@endif
            <div class="logo-wrap">
              @if ($cl->logo)
                <img loading="lazy" decoding="async" src="{{ media($cl->logo) }}" alt="{{ $cl->name }}">
              @else
                @php($w = preg_split('/\s+/', trim($cl->name)))
                <span class="ph">{{ strtoupper(mb_substr($w[0] ?? '', 0, 1).(count($w) > 1 ? mb_substr($w[1], 0, 1) : '')) }}</span>
              @endif
            </div>
            <div class="nm">{{ $cl->name }}</div>
          @if ($cl->url)</a>@endif
        </div>
      @endforeach
    </div>
  </div>
</section>
@endsection
