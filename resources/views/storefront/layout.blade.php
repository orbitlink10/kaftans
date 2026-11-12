<!doctype html>
<html lang="en-KE"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>{{ $title ?? 'Reyana' }}</title>
<meta name="description" content="{{ $description ?? 'Discover the Reyana women’s clothing edit: dresses, tops and considered separates for your wardrobe in Kenya.' }}">
@php
 $utility = request()->is('cart','checkout','account','wishlist','search','order-confirmation','contact','size-guide','delivery-shipping','returns-exchanges','faqs','privacy','terms') || request()->hasAny(['q','size','color','min','max','sort','available']) || (isset($products) && $products->isEmpty());
 $noindex = config('reyana.preview') || !config('reyana.indexable') || !app()->environment('production') || $utility;
 $canonical = url(request()->path() === '/' ? '/' : request()->path()).(request()->integer('page',1)>1 ? '?page='.request()->integer('page') : '');
@endphp
@php if(!config('reyana.preview')) $canonical = rtrim(config('app.url'),'/').(request()->path()==='/' ? '/' : '/'.request()->path()).(request()->integer('page',1)>1 ? '?page='.request()->integer('page') : ''); @endphp
<meta name="robots" content="{{ $noindex ? 'noindex,follow' : 'index,follow' }}">
<link rel="canonical" href="{{ $canonical }}">
<meta property="og:title" content="{{ $title ?? 'Reyana' }}"><meta property="og:type" content="website"><meta property="og:url" content="{{ $canonical }}"><meta property="og:site_name" content="Reyana"><meta property="og:description" content="{{ $description ?? 'Discover your next look with Reyana.' }}">
@isset($product)<meta property="og:image" content="{{ url($product['image']) }}">@endisset
<meta name="theme-color" content="#f8f5ef"><link rel="stylesheet" href="{{ asset('reyana/store.css') }}">
<meta name="twitter:card" content="summary_large_image"><meta name="twitter:title" content="{{ $title ?? 'Reyana' }}"><meta name="twitter:description" content="{{ $description ?? 'Discover the Reyana wardrobe edit.' }}">
<script src="{{ asset('reyana/store.js') }}" defer></script>
<script type="application/ld+json">{!! json_encode(['@context'=>'https://schema.org','@type'=>'Organization','name'=>'Reyana','url'=>url('/')], JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT) !!}</script>
@stack('head')
</head><body class="reyana">
<a class="skip" href="#main">Skip to content</a>
@if(config('reyana.preview'))<div class="preview">PRIVATE PREVIEW <span>· Reference imagery & sample products · No real purchases</span></div>@endif
@if(config('reyana.announcement'))<div class="announcement">{{ config('reyana.announcement') }}</div>@endif
<header class="header"><div class="header-top"><span class="locale">KENYA / KSh</span><a class="wordmark" href="{{ url('/') }}" aria-label="Reyana home">REYANA<span>THE EVERYDAY, REIMAGINED</span></a><div class="tools"><a href="{{ url('/search') }}" aria-label="Search">@include('storefront.icon',['icon'=>'search'])</a><a href="{{ url('/account') }}" aria-label="Account">@include('storefront.icon',['icon'=>'user'])</a><a href="{{ url('/wishlist') }}" aria-label="Wishlist">@include('storefront.icon',['icon'=>'heart'])</a><a class="bag" href="{{ url('/cart') }}" aria-label="Shopping bag">@include('storefront.icon',['icon'=>'bag'])<span>{{ array_sum(array_column(session('reyana.cart',[]),'quantity')) }}</span></a></div><button class="menu-button" aria-expanded="false" aria-controls="navigation">Menu ☰</button></div>
<nav id="navigation" aria-label="Main navigation">@foreach($collections as $slug=>$label)<a href="{{ url('/collections/'.$slug) }}" @if(request()->is('collections/'.$slug)) aria-current="page" @endif>{{ $label }}</a>@endforeach</nav></header>
@if(session('success'))<div class="notice" role="status">{{ session('success') }}</div>@endif
@if($errors->any())<div class="notice error" role="alert">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
<main id="main">@yield('content')</main>
<section class="newsletter"><div><span class="eyebrow">LET’S STAY IN THE KNOW</span><h2>A little inspiration.<br>A lot of style.</h2><p>Sign up for collection updates from Reyana.</p></div><form action="{{ url('/newsletter') }}" method="post">@csrf<label for="newsletter-email">Email address</label><div class="email-row"><input id="newsletter-email" type="email" name="email" placeholder="Your email address" required autocomplete="email"><button aria-label="Sign up">→</button></div><label class="consent"><input type="checkbox" name="consent" value="1" required> I agree to receive collection news. Read our <a href="{{ url('/privacy') }}">privacy notice</a>.</label>@if(config('reyana.preview'))<small>Preview only: no marketing subscription is created.</small>@endif</form></section>
<footer><div class="footer-grid"><div><a class="wordmark footer-logo" href="{{ url('/') }}">REYANA</a><p>For the way you move.<br>For the woman you are.</p><span class="eyebrow">WOMEN’S CLOTHING · KENYA</span></div><div><h3>Explore</h3><a href="{{ url('/shop') }}">Shop all</a><a href="{{ url('/collections/new-arrivals') }}">New arrivals</a><a href="{{ url('/collections/dresses') }}">Dresses</a><a href="{{ url('/about') }}">Our story</a><a href="{{ url('/blog') }}">Style journal</a></div><div><h3>Here to help</h3>@foreach(['contact'=>'Contact','size-guide'=>'Size guide','delivery-shipping'=>'Delivery & shipping','returns-exchanges'=>'Returns & exchanges','faqs'=>'FAQs'] as $slug=>$label)<a href="{{ url('/'.$slug) }}">{{ $label }}</a>@endforeach</div><div><h3>Your Reyana</h3><a href="{{ url('/account') }}">My account</a><a href="{{ url('/wishlist') }}">My wishlist</a><a href="{{ url('/cart') }}">Shopping bag</a>@if(config('reyana.contact_email'))<a href="mailto:{{ config('reyana.contact_email') }}">{{ config('reyana.contact_email') }}</a>@endif</div></div><div class="footer-bottom"><span>© {{ date('Y') }} Reyana</span><div><a href="{{ url('/privacy') }}">Privacy</a><a href="{{ url('/terms') }}">Terms</a></div><span>Kenya · KSh</span></div></footer>
</body></html>
