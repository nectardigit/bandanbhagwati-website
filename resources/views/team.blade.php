@extends('layouts.app')

@section('title', 'Meet the Team — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', 'Meet the engineers and professionals behind Bandan Bhagwati Nirman Sewa.')

@section('content')
@php($social = '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M14 9h3l.5-3H14V4.5c0-.9.3-1.5 1.6-1.5H18V.2A21 21 0 0 0 15.5 0C12.9 0 11 1.6 11 4.4V6H8v3h3v9h3z"/></svg>')

<!-- ===== TEAM ===== -->
<section class="section">
  <div class="wrap">
    <span class="eyebrow">Our Team</span>
    <h2 class="h-sec">{{ $home?->team_page_title ?: 'Meet the Team' }}</h2>
    <p class="sub" style="margin-bottom:44px">{{ $home?->team_page_desc ?: 'The experienced board, engineers, and professionals behind Bandan Bhagwati Nirman Sewa.' }}</p>

    @php($grouped = $members->groupBy(fn ($m) => $m->department ?: 'Our Team'))
    @foreach ($grouped as $department => $group)
    @if ($grouped->count() > 1)
    <h3 class="team-dept">{{ $department }}</h3>
    @endif
    <div class="team-grid">
      @foreach ($group as $m)
      <a class="team-card" href="{{ route('team.show', $m) }}">
        @if ($m->photo)
          <img loading="lazy" decoding="async" src="{{ media($m->photo) }}" alt="{{ $m->name }}">
        @else
          @php($pn = preg_replace('/^(Er\.|Mr\.|Mrs\.|Ms\.|Dr\.)\s*/i', '', $m->name))
          @php($pw = preg_split('/\s+/', trim($pn ?? '')))
          @php($ini = strtoupper(mb_substr($pw[0] ?? '', 0, 1).(count($pw) > 1 ? mb_substr(end($pw), 0, 1) : '')))
          @php($vr = (ord($ini !== '' ? $ini[0] : 'A') % 4) + 1)
          <div class="team-avatar v{{ $vr }}">{{ $ini }}</div>
        @endif
        <div class="info {{ $m->photo ? '' : 'always' }}">
          <b>{{ $m->name }}</b><span>{{ $m->role }}</span>
          <span class="view-profile">View profile &rarr;</span>
        </div>
      </a>
      @endforeach
    </div>
    @endforeach
  </div>
</section>
@endsection
