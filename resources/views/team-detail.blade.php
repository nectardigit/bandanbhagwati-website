@extends('layouts.app')

@section('title', $member->name.' — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($member->bio ?: ($member->role.' at Bandan Bhagwati Nirman Sewa.')), 150))
@section('og_image', og_url($member->photo))

@section('content')
@php($pn = preg_replace('/^(Er\.|Mr\.|Mrs\.|Ms\.|Dr\.)\s*/i', '', $member->name))
@php($pw = preg_split('/\s+/', trim($pn ?? '')))
@php($ini = strtoupper(mb_substr($pw[0] ?? '', 0, 1).(count($pw) > 1 ? mb_substr(end($pw), 0, 1) : '')))
@php($vr = (ord($ini !== '' ? $ini[0] : 'A') % 4) + 1)

<section class="section">
  <div class="wrap">
    <a href="{{ route('team') }}" class="view-more" style="display:inline-flex;margin-bottom:22px">&larr; Back to team</a>
    <div class="member-detail">
      <div class="member-photo">
        @if ($member->photo)
          <img src="{{ media($member->photo) }}" alt="{{ $member->name }}">
        @else
          <div class="team-avatar v{{ $vr }}" style="aspect-ratio:1/1;border-radius:18px;font-size:96px">{{ $ini }}</div>
        @endif
      </div>
      <div class="member-info">
        @if ($member->department)<span class="eyebrow">{{ $member->department }}</span>@endif
        <h2 class="h-sec" style="margin:6px 0 6px">{{ $member->name }}</h2>
        <p class="member-role">{{ $member->role }}</p>

        @if ($member->facebook || $member->instagram || $member->twitter || $member->linkedin || $member->youtube)
        <div class="member-socials">
          @if($member->facebook)<a href="{{ $member->facebook }}" target="_blank" rel="noopener" aria-label="Facebook"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M14 9h3l.5-3H14V4.5c0-.9.3-1.5 1.6-1.5H18V.2A21 21 0 0 0 15.5 0C12.9 0 11 1.6 11 4.4V6H8v3h3v9h3z"/></svg></a>@endif
          @if($member->instagram)<a href="{{ $member->instagram }}" target="_blank" rel="noopener" aria-label="Instagram"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg></a>@endif
          @if($member->twitter)<a href="{{ $member->twitter }}" target="_blank" rel="noopener" aria-label="X"><svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h3l-7 8 8 12h-6l-5-6.5L6 22H3l7.5-9L3 2h6l4.5 6z"/></svg></a>@endif
          @if($member->linkedin)<a href="{{ $member->linkedin }}" target="_blank" rel="noopener" aria-label="LinkedIn"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5A2.5 2.5 0 1 1 0 3.5a2.5 2.5 0 0 1 4.98 0zM0 8h5v16H0zM8 8h4.8v2.2h.06A5.3 5.3 0 0 1 17.6 8c5 0 5.9 3.3 5.9 7.6V24h-5v-7.5c0-1.8 0-4-2.5-4s-2.9 2-2.9 4V24H8z"/></svg></a>@endif
          @if($member->youtube)<a href="{{ $member->youtube }}" target="_blank" rel="noopener" aria-label="YouTube"><svg width="19" height="19" viewBox="0 0 24 24" fill="currentColor"><path d="M23 7.5a3 3 0 0 0-2.1-2.1C19 5 12 5 12 5s-7 0-8.9.4A3 3 0 0 0 1 7.5 31 31 0 0 0 .6 12 31 31 0 0 0 1 16.5a3 3 0 0 0 2.1 2.1C5 19 12 19 12 19s7 0 8.9-.4a3 3 0 0 0 2.1-2.1A31 31 0 0 0 23.4 12 31 31 0 0 0 23 7.5zM9.7 15.5v-7l6 3.5z"/></svg></a>@endif
        </div>
        @endif

        <div class="member-bio">
          @if (trim(strip_tags($member->bio ?? '')) !== '')
            {!! $member->bio !!}
          @else
            <p>{{ $member->name }} is part of the {{ $member->department ?: 'team' }} at Bandan Bhagwati Nirman Sewa Pvt. Ltd., contributing to the delivery of quality infrastructure projects across Nepal.</p>
          @endif
        </div>
      </div>
    </div>

    @if ($others->count())
    <h3 class="team-dept" style="margin-top:56px">More from {{ $member->department ?: 'the team' }}</h3>
    <div class="team-grid">
      @foreach ($others as $m)
      <a class="team-card" href="{{ route('team.show', $m) }}">
        @if ($m->photo)
          <img loading="lazy" decoding="async" src="{{ media($m->photo) }}" alt="{{ $m->name }}">
        @else
          @php($oin = strtoupper(mb_substr($m->name, 0, 1)))
          <div class="team-avatar v{{ (ord($oin ?: 'A') % 4) + 1 }}">{{ $oin }}</div>
        @endif
        <div class="info always"><b>{{ $m->name }}</b><span>{{ $m->role }}</span></div>
      </a>
      @endforeach
    </div>
    @endif
  </div>
</section>
@endsection
