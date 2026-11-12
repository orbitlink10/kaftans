@extends('layouts.app')
@section('title', 'Lasafi')
@section('content')
@php
    $heroImage = $content['home_hero_image'];
    $heroImageUrl = str_starts_with($heroImage, 'http') ? $heroImage : asset('storage/'.$heroImage);
@endphp
<section class="hero section" style="--hero-image:url('{{ $heroImageUrl }}')">
    <div class="container py-4">
        <div class="row align-items-center g-4">
            <div class="{{ $homeVideoEmbedUrl ? 'col-lg-7' : 'col-lg-8' }}">
                <h1 class="display-4 fw-bold">{{ $content['home_hero_title'] }}</h1>
                <p class="lead mb-4">{{ $content['home_hero_description'] }}</p>
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-brand btn-lg" href="{{ route('bookings.create') }}">{{ $content['home_primary_cta'] }}</a>
                    <a class="btn btn-light btn-lg" href="{{ route('register') }}">{{ $content['home_provider_cta'] }}</a>
                    <a class="btn btn-outline-light btn-lg" href="{{ $content['home_whatsapp_url'] }}">{{ $content['home_whatsapp_cta'] }}</a>
                </div>
            </div>
            @if($homeVideoEmbedUrl)
                <div class="col-lg-5">
                    <div class="hero-video">
                        <div class="ratio ratio-16x9 rounded overflow-hidden">
                            <iframe src="{{ $homeVideoEmbedUrl }}" title="Lasafi video" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<section class="section services-kingdom" id="services">
    <div class="container">
        <h2 class="section-title">{{ $content['home_services_title'] }}</h2>
        @if($content['home_services_subtitle'])
            <p class="text-center text-muted lead mb-5">{{ $content['home_services_subtitle'] }}</p>
        @endif
        <a class="kingdom-arrow left" href="#services" aria-label="Previous services">&lsaquo;</a>
        <a class="kingdom-arrow right" href="#services" aria-label="Next services">&rsaquo;</a>
        <div class="row g-4 justify-content-center">
            @foreach($popularServices as $service)
                <div class="col-md-6 col-lg-4">
                    <article class="kingdom-service-card h-100">
                        <div class="kingdom-check">✓</div>
                        <h5>{{ $service->name }}</h5>
                        <p>{{ $service->description }}</p>
                        <div class="kingdom-price">From KES {{ number_format($service->base_price) }}</div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
<section class="section bg-white" id="how-it-works">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4"><h3>{{ $content['home_how_title_1'] }}</h3><p>{{ $content['home_how_text_1'] }}</p></div>
            <div class="col-md-4"><h3>{{ $content['home_how_title_2'] }}</h3><p>{{ $content['home_how_text_2'] }}</p></div>
            <div class="col-md-4"><h3>{{ $content['home_how_title_3'] }}</h3><p>{{ $content['home_how_text_3'] }}</p></div>
        </div>
    </div>
</section>
<section class="section" id="why-lasafi">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6"><h2 class="fw-bold">{{ $content['home_why_title'] }}</h2><p>{{ $content['home_why_text'] }}</p></div>
            <div class="col-lg-6">
                <div class="row g-2">@foreach($categories as $category)<div class="col-6"><div class="p-3 bg-white rounded shadow-sm">{{ $category->name }}</div></div>@endforeach</div>
            </div>
        </div>
    </div>
</section>
<section class="section bg-white" id="service-areas">
    <div class="container">
        <h2 class="fw-bold">{{ $content['home_areas_title'] }}</h2>
        <p class="lead">{{ $content['home_areas_text'] }}</p>
    </div>
</section>
<section class="section bg-white pt-0" id="testimonials">
    <div class="container">
        <h2 class="fw-bold">{{ $content['home_testimonials_title'] }}</h2>
        <div class="row g-3 mt-2">
            @forelse($testimonials as $review)
                <div class="col-md-4"><div class="card h-100"><div class="card-body"><strong>{{ $review->customer->name }}</strong><p class="mb-1">{{ $review->comment }}</p><span class="text-brand">{{ str_repeat('*', $review->rating) }}</span></div></div></div>
            @empty
                <div class="col"><p class="text-muted">{{ $content['home_empty_testimonials'] }}</p></div>
            @endforelse
        </div>
    </div>
</section>
@endsection
