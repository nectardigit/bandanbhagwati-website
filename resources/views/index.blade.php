@extends('layouts.app')

@section('title', ($settings['company_name'] ?? 'Bandan Bhagwati').' Nirman Sewa Pvt. Ltd.')
@section('meta_description', $settings['hero_subtitle'] ?? 'Your trusted construction partner across Nepal.')

@section('content')
@php($arrow = '<span class="ico"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M9 7h8v8"/></svg></span>')

<!-- ===== HERO ===== -->
@php($heroImage = ($settings['hero_image'] ?? null) ? media($settings['hero_image']) : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1600&q=80')
@php($heroVideo = ($settings['hero_video'] ?? null) ? media($settings['hero_video']) : null)
<section class="hero">
  @if ($heroVideo)
    <video class="hero-bg" autoplay muted loop playsinline preload="auto" poster="{{ $heroImage }}"
           onended="this.currentTime=0; this.play();"
           onloadeddata="this.play().catch(()=>{});">
      <source src="{{ $heroVideo }}" type="video/mp4">
    </video>
    <div class="hero-overlay"></div>
  @else
    <div class="bg" style="background-image:url('{{ $heroImage }}')"></div>
  @endif
  <div class="wrap">
    <p class="kicker">{{ $settings['hero_kicker'] ?? 'We Developed Landmark Real Estate Projects.' }}</p>
    @if ($home?->hero_title)
      <h1>{{ $home->hero_title }}</h1>
    @else
      <h1>We Your <span class="o">Trusted</span><br><span class="o">Construction</span> Partner</h1>
    @endif
    <p>{{ $settings['hero_subtitle'] ?? 'We turn complex challenges into simple, effective solutions. Delivering every project on time, across Nepal.' }}</p>
    <div class="cta">
      <button class="btn btn-orange" onclick="location.href='{{ url('/service') }}'">Get Started {!! $arrow !!}</button>
      <button class="btn btn-white" onclick="location.href='{{ url('/contact') }}'">Contact us {!! $arrow !!}</button>
    </div>
  </div>
</section>

<!-- ===== ABOUT ===== -->
<section class="section about" id="about">
  <div class="wrap">
    <div class="about-imgs">
      @include('partials.about-imgs')
    </div>
    <div class="about-body">
      <span class="eyebrow">{{ $about?->eyebrow ?: 'About' }}</span>
      <h2>{{ $about?->heading ?: 'Turning Your Vision into Reality, Starting with the Basics' }}</h2>
      @php($aboutFeatures = $about?->features ?: [
        ['title' => "Validate your manufacturer's warranty", 'text' => 'Magna reprehenderit tempor do elit mollit officia fugiat ullamco duis ex aute quis. Est excepteur velit incididunt laborum nulla minim.'],
        ['title' => "Validate your manufacturer's warranty", 'text' => 'Magna reprehenderit tempor do elit mollit officia fugiat ullamco duis ex aute quis. Est excepteur velit incididunt laborum nulla minim.'],
      ])
      <div class="about-feats {{ count($aboutFeatures) <= 2 ? 'open' : '' }}" id="aboutFeats">
        @foreach ($aboutFeatures as $f)
        <div class="feat">
          <span class="ck"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="m8.5 12 2.5 2.5 4.5-5"/></svg></span>
          <div><h4>{{ $f['title'] ?? '' }}</h4><p>{{ $f['text'] ?? '' }}</p></div>
        </div>
        @endforeach
      </div>
      @if (count($aboutFeatures) > 2)
      <button type="button" class="see-more-btn" data-target="aboutFeats"><span class="lbl">See more</span> <span class="caret">▾</span></button>
      @endif
      <div class="about-cards">
        <div class="about-card"><span class="ic"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="8" r="6"/><path d="M8.2 13.6 7 22l5-3 5 3-1.2-8.4"/><path d="m12 5 1 2 2.1.3-1.5 1.5.4 2.1L12 11.9 9.5 12.9l.4-2.1L8.4 9.3 10.5 9z"/></svg></span>{{ $about?->card_one ?: 'Building quality standards' }}</div>
        <div class="about-card"><span class="ic"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="9" cy="8" r="3.2"/><path d="M3 20a6 6 0 0 1 12 0"/><path d="M15.5 5a3 3 0 0 1 0 6M21 20a6 6 0 0 0-4.5-5.8"/></svg></span>{{ $about?->card_two ?: "Certified engineer's team" }}</div>
      </div>
      <button class="btn btn-orange" onclick="location.href='{{ url('/about') }}'">Explore now {!! $arrow !!}</button>
    </div>
  </div>
</section>

<!-- ===== EQUIPMENT SHOWCASE ===== -->
<section class="section" style="padding-top:20px">
  <div class="wrap">
    <div class="head-row">
      <div><h2 class="h-sec">{{ $home?->equip_title ?: 'Equipment Showcase' }}</h2><p class="sub">{{ $home?->equip_sub ?: "Our clients' feedback speaks volumes about our commitment and quality." }}</p></div>
      <div class="head-actions">
        <a class="btn btn-orange" href="{{ url('/equipment') }}">View all {!! $arrow !!}</a>
        <div class="arrows"><button aria-label="prev"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></button><button aria-label="next"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></button></div>
      </div>
    </div>
    <div class="grid4 h-scroll" id="equipGrid">
      @foreach ($equipment as $e)
      <article class="eq-card">
        <img loading="lazy" decoding="async" src="{{ media($e->image) }}" alt="{{ $e->name }}">
        <div class="body">
          <h3>{{ $e->title ?: $e->name }}</h3>
          <p>{{ $e->description }}</p>
          <a class="btn btn-orange" href="{{ route('equipment.show', $e) }}">Rent Now {!! $arrow !!}</a>
        </div>
      </article>
      @endforeach
    </div>
  </div>
</section>

<!-- ===== CATEGORIES ===== -->
<section class="section cats">
  <div class="wrap">
    <span class="eyebrow">{{ $home?->cat_eyebrow ?: 'Category' }}</span>
    <h2 class="h-sec">{{ $home?->cat_title ?: 'Equipment Categories' }}</h2>
    <p class="sub" style="margin-bottom:50px">{{ $home?->cat_sub ?: 'Browse our extensive collection of construction equipment' }}</p>
    <div class="cat-grid" id="catGrid">
      @foreach ($categories as $c)
      <a class="cat" href="{{ route('equipment', ['category' => $c->slug]) }}">
        <div class="circle">{{ $c->icon }}</div>
        <h4>{{ $c->name }}</h4>
        <p>{{ $c->description }}</p>
      </a>
      @endforeach
    </div>
  </div>
</section>

<!-- ===== SERVICES ===== -->
<section class="section services" id="services">
  <div class="wrap">
    <div class="serv-left">
      <h2>{{ $home?->services_title ?: 'Trusted Construction Services for Every Client' }}</h2>
      <p class="sub">{{ $home?->services_sub ?: "Delivering reliable, innovative, and high-quality construction solutions tailored to every client's needs. Committed to excellence with services designed to build trust and lasting value." }}</p>
      <div class="serv-list" id="servList">
        @foreach ($services as $service)
        <div class="serv-item {{ $loop->first ? 'active' : '' }}"
             data-title="{{ $service->title }}"
             data-desc="{{ $service->short_description }}"
             data-image="{{ $service->image ? media($service->image) : '' }}"
             data-url="{{ route('services.show', $service) }}">
          <span>{{ $service->title }}</span>
          <span class="dot"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M9 7h8v8"/></svg></span>
        </div>
        @endforeach
      </div>
    </div>
    @php($firstSvc = $services->first())
    <div class="serv-right">
      <div style="text-align:right;margin-bottom:20px"><a href="{{ url('/service') }}" class="btn btn-orange">View all <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M9 7h8v8"/></svg></a></div>
      <div class="serv-card">
        <div class="serv-media">
          <img loading="lazy" decoding="async" src="{{ $firstSvc && $firstSvc->image ? media($firstSvc->image) : 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?auto=format&fit=crop&w=900&q=80' }}" alt="service">
          <button class="btn btn-orange" onclick="location.href='{{ $firstSvc ? route('services.show', $firstSvc) : url('/service') }}'">Explore now {!! $arrow !!}</button>
        </div>
        <div class="body">
          <h3>{{ $firstSvc->title ?? 'Trusted Construction Services' }}</h3>
          <p>{{ $firstSvc->short_description ?? 'Delivering reliable, innovative, and high-quality construction solutions tailored to every client\'s needs.' }}</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== OUR PROJECT ===== -->
<section class="section" id="projects">
  <div class="wrap">
    <span class="eyebrow">{{ $home?->projects_eyebrow ?: 'Our Project' }}</span>
    <div class="head-row">
      <div><h2 class="h-sec">{{ $home?->projects_title ?: 'Showcasing Our Work' }}</h2><p class="sub">{{ $home?->projects_sub ?: "Our clients' feedback speaks volumes about our commitment and quality." }}</p></div>
      <div class="head-actions">
        <a class="btn btn-orange" href="{{ url('/project') }}">View all {!! $arrow !!}</a>
        <div class="arrows"><button aria-label="prev"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></button><button aria-label="next"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></button></div>
      </div>
    </div>
    <div class="proj-grid h-scroll" id="projGrid">
      @foreach ($projects as $p)
      <a class="proj-card" href="{{ route('projects.show', $p) }}">
        <img loading="lazy" decoding="async" src="{{ media($p->cover_image) }}" alt="{{ $p->title }}">
        <div class="cap"><small>{{ $p->caption }}</small><b>{{ $p->client }}</b></div>
      </a>
      @endforeach
    </div>
  </div>
</section>

<!-- ===== ONGOING PROJECT ===== -->
<section class="section ongoing">
  <div class="wrap">
    <span class="eyebrow">{{ $home?->ongoing_eyebrow ?: 'Our Ongoing Project' }}</span>
    <div class="head-row">
      <div><h2 class="h-sec">{{ $home?->ongoing_title ?: 'Work in Action' }}</h2><p class="sub">{{ $home?->ongoing_sub ?: 'Delivering quality through every step of the process.' }}</p></div>
      <div class="head-actions">
        <a class="btn btn-orange" href="{{ url('/project') }}">View all {!! $arrow !!}</a>
        <div class="arrows"><button aria-label="prev"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></button><button aria-label="next"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></button></div>
      </div>
    </div>
    <div class="proj-grid h-scroll" id="ongoingGrid">
      @foreach ($ongoing as $p)
      <a class="proj-card" href="{{ route('projects.show', $p) }}">
        <img loading="lazy" decoding="async" src="{{ media($p->cover_image) }}" alt="{{ $p->title }}">
        <div class="cap"><small>{{ $p->caption }}</small><b>{{ $p->client }}</b></div>
      </a>
      @endforeach
    </div>
  </div>
</section>

<!-- ===== STATS ===== -->
<section class="stats">
  <div class="wrap">
    <div class="stat"><span class="si">🏆</span><div><b>{{ $settings['stat_awards'] ?? '40+' }}</b><span>World awards</span></div></div>
    <div class="stat"><span class="si">📋</span><div><b>{{ $settings['stat_projects'] ?? '80+' }}</b><span>Project Success</span></div></div>
    <div class="stat"><span class="si">👥</span><div><b>{{ $settings['stat_team'] ?? '60+' }}</b><span>Team members</span></div></div>
    <div class="stat"><span class="si">🎗️</span><div><b>{{ $settings['stat_clients'] ?? '99+' }}</b><span>Client Satisfaction</span></div></div>
  </div>
</section>

<!-- ===== CONTACT CTA ===== -->
<section class="contact" id="contact">
  <div class="img" style="background-image:url('https://images.unsplash.com/photo-1565008447742-97f6f38c985c?auto=format&fit=crop&w=1000&q=80')"></div>
  <div class="panel">
    <span class="eyebrow">{{ $home?->cta_eyebrow ?: 'Contact Us Anytime' }}</span>
    <h2>{{ $home?->cta_title ?: "Have a Project in Mind? Let's Talk." }}</h2>
    <p>{{ $home?->cta_text ?: 'Bandan Bhagwati is a sacred expression of devotion and cultural unity. It represents the deep bond between faith, tradition, and community, bringing people together in reverence and shared belief.' }}</p>
    <button class="btn btn-orange" style="align-self:flex-start" onclick="location.href='{{ url('/contact') }}'">Explore now {!! $arrow !!}</button>
  </div>
</section>

<!-- ===== FAQ ===== -->
<section class="section faq">
  <div class="wrap">
    <div>
      <span class="eyebrow">{{ $home?->faq_eyebrow ?: "FAQ's" }}</span>
      <h2 class="h-sec">{{ $home?->faq_title ?: 'frequently asked questions' }}</h2>
      <p class="sub">{{ $home?->faq_sub ?: 'Delivering quality through every step of the process.' }}</p>
      <div class="faq-list" id="faqList">
        @foreach ($faqs as $faq)
        <div class="faq-item {{ $loop->first ? 'open' : '' }}">
          <div class="faq-q"><span>{{ $faq->question }}</span><span class="faq-plus">+</span></div>
          <div class="faq-a"><p>{{ $faq->answer }}</p></div>
        </div>
        @endforeach
      </div>
      <a class="btn btn-orange" href="{{ url('/faq') }}" style="margin-top:24px;display:inline-flex">View all {!! $arrow !!}</a>
    </div>
    <div class="faq-img">
      <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1521791136064-7986c2920216?auto=format&fit=crop&w=800&q=80" alt="engineer">
    </div>
  </div>
</section>

<!-- ===== TESTIMONIAL ===== -->
@php($t = $testimonials->first())
@if ($t)
<section class="section testi">
  <div class="bg" style="background-image:url('https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=1600&q=80')"></div>
  <div class="wrap">
    <div class="testi-left">
      <span class="eyebrow">{{ $home?->testi_eyebrow ?: 'Testimonials' }}</span>
      <h2>{{ $home?->testi_title ?: 'What our clients say' }}</h2>
      <p>{{ $home?->testi_text ?: 'Our clients trust us to deliver quality construction on time. Here is what they have to say about working with Bandan Bhagwati Nirman Sewa.' }}</p>
      <div class="arrows"><button aria-label="prev"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></button><button aria-label="next"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></button></div>
    </div>
    <div class="testi-card">
      <div class="person">
        <img loading="lazy" decoding="async" src="{{ media($t->photo) }}" alt="{{ $t->name }}">
        <b>{{ $t->name }}</b><span>{{ $t->role }}</span>
      </div>
      <div class="quote">
        <div class="q">&#8220;</div>
        <p>{{ $t->quote }}</p>
        <div class="foot">
          <span class="brand2"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M5 20 9 6l3 8 3-8 4 14" stroke="#f5a000" stroke-width="2.4" stroke-linejoin="round"/></svg>{{ $t->brand }}</span>
          <span class="stars">{{ str_repeat('★', $t->rating) }}</span>
        </div>
      </div>
    </div>
  </div>
</section>
@endif

@if (!empty($clients) && $clients->count())
<!-- ===== CLIENTS / PARTNERS ===== -->
<section class="section clients-sec">
  <div class="wrap">
    <div style="text-align:center;max-width:620px;margin:0 auto 40px">
      <span class="eyebrow" style="justify-content:center">Our Clients</span>
      <h2 class="h-sec">Trusted by Leading Organizations</h2>
    </div>
    @php($logoClients = $clients->filter(fn ($c) => ! empty($c->logo)))
    @php($textClients = $clients->filter(fn ($c) => empty($c->logo)))
    @if ($logoClients->count())
    <div class="client-grid">
      @foreach ($logoClients as $cl)
        <div class="client-logo" title="{{ $cl->name }}">
          @if ($cl->url)<a href="{{ $cl->url }}" target="_blank" rel="noopener">@endif
            <img loading="lazy" decoding="async" src="{{ media($cl->logo) }}" alt="{{ $cl->name }}">
          @if ($cl->url)</a>@endif
        </div>
      @endforeach
    </div>
    @endif
    @if ($textClients->count())
    <p class="sub" style="text-align:center;margin:40px auto 18px;max-width:560px">Our work is trusted by government bodies and leading organizations across Nepal:</p>
    <div class="client-names">
      @foreach ($textClients as $cl)
        <span class="client-name">{{ $cl->name }}</span>
      @endforeach
    </div>
    @endif
  </div>
</section>
@endif

<!-- ===== BLOG ===== -->
<section class="section" id="blog">
  <div class="wrap">
    <span class="eyebrow">{{ $home?->blog_eyebrow ?: 'Our Blog' }}</span>
    <div class="head-row">
      <div><h2 class="h-sec">{{ $home?->blog_title ?: 'Insights & Updates' }}</h2><p class="sub">{{ $home?->blog_sub ?: 'Explore expert insights, industry updates, and project stories from our team.' }}</p></div>
      <div class="head-actions">
        <a class="btn btn-orange" href="{{ url('/blog') }}">View all {!! $arrow !!}</a>
        <div class="arrows"><button aria-label="prev"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></button><button aria-label="next"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></button></div>
      </div>
    </div>
    <div class="grid4 h-scroll" id="blogGrid">
      @foreach ($posts as $post)
      <a class="blog-card" href="{{ route('blog.show', $post) }}">
        <div class="thumb"><img loading="lazy" decoding="async" src="{{ media($post->cover_image) }}" alt="{{ $post->title }}"></div>
        <div class="blog-meta"><span>BY: {{ $post->author }}</span><span>{{ optional($post->published_at)->format('M d, Y') }}</span></div>
        <h3>{{ $post->title }}</h3>
      </a>
      @endforeach
    </div>
  </div>
</section>
@endsection
