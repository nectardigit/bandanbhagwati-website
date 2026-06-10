@extends('layouts.app')

@section('title', 'Contact us — '.($settings['company_name'] ?? 'Bandan Bhagwati'))
@section('meta_description', 'Get in touch with Bandan Bhagwati Nirman Sewa.')

@section('content')
<!-- ===== PAGE BANNER ===== -->
<section class="page-banner">
  <div class="bg" style="background-image:url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1600&q=80')"></div>
  <div class="wrap">
    <h1>Contact us</h1>
    <p class="crumb"><a href="{{ url('/') }}">Home</a> – <span class="cur">Contact us</span></p>
  </div>
</section>

<!-- ===== CONTACT ===== -->
<section class="section">
  <div class="wrap contact-grid">
    <!-- INFO -->
    <div class="contact-info">
      <div class="ci-row">
        <span class="cic">📞</span>
        <div><h4>Call Us</h4><p>{{ $settings['phone'] ?? '+977-9825252525' }}</p></div>
      </div>
      <div class="ci-row">
        <span class="cic">✉️</span>
        <div><h4>Email</h4><p>{{ $settings['email'] ?? 'bandanbhagwati@gmail.com' }}</p></div>
      </div>
      <div class="ci-row">
        <span class="cic">📍</span>
        <div><h4>Our Location</h4><p>{{ $settings['address'] ?? 'Sundhara, Kathmandu, Nepal' }}</p></div>
      </div>
      <div class="ci-row">
        <span class="cic">🎧</span>
        <div><h4>Live Chat</h4><p>{{ $settings['email'] ?? 'bandanbhagwati@gmail.com' }}</p></div>
      </div>
    </div>

    <!-- FORM -->
    <form class="contact-form" method="POST" action="{{ route('contact.submit') }}">
      @csrf
      <h3>Get in Touch</h3>
      <p class="lead">Have a question or feedback? Fill out the form below and we'll get back to you soon.</p>
      @if (session('contact_success'))
        <p style="color:#0b8a3a;font-weight:600">{{ session('contact_success') }}</p>
      @endif
      @if ($errors->any())
        <p style="color:#c0392b">{{ $errors->first() }}</p>
      @endif
      <div class="row2">
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
      </div>
      <div class="row2">
        <input type="text" name="city" value="{{ old('city') }}" placeholder="Enter your city">
        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone number">
      </div>
      <div class="full"><input type="text" name="subject" value="{{ old('subject') }}" placeholder="Subject"></div>
      <div class="full"><textarea name="message" placeholder="Message" required>{{ old('message') }}</textarea></div>
      <button class="btn btn-orange" type="submit">Send message</button>
    </form>
  </div>
</section>

<!-- ===== MAP ===== -->
<section>
  <iframe class="map-embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
    src="https://www.google.com/maps?q={{ urlencode($settings['address'] ?? 'Sundhara,Kathmandu,Nepal') }}&output=embed"></iframe>
</section>
@endsection
