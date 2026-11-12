<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @hasSection('meta_description')
        <meta name="description" content="@yield('meta_description')">
    @endif
    <title>@yield('title', 'Lasafi')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --slk-green:#0f9f6e; --slk-blue:#0b5ed7; --slk-ink:#123; --slk-soft:#eef8f4; }
        body { background:#f6f9fb; color:var(--slk-ink); font-size:1rem; }
        .navbar { box-shadow:0 8px 30px rgba(16,24,40,.08); }
        .navbar .nav-link { color:#334155; font-size:1rem; font-weight:600; }
        .navbar .nav-link:hover,
        .navbar .nav-link.active { color:var(--slk-green); }
        .brand-mark { width:34px; height:34px; border-radius:8px; background:linear-gradient(135deg,var(--slk-green),var(--slk-blue)); display:inline-grid; place-items:center; color:#fff; font-weight:800; }
        .btn-brand { background:var(--slk-green); color:#fff; border:0; }
        .btn-brand:hover { background:#0a8a5f; color:#fff; }
        .text-brand { color:var(--slk-green); }
        .hero { background:linear-gradient(120deg,rgba(8,91,66,.92),rgba(9,75,151,.88)), var(--hero-image) center/cover; color:#fff; }
        .hero h1 { font-size:clamp(2.35rem, 4vw, 3.75rem); }
        .hero-video { background:rgba(255,255,255,.14); border:1px solid rgba(255,255,255,.28); border-radius:14px; padding:10px; backdrop-filter:blur(4px); }
        .lead { font-size:1.16rem; }
        .section { padding:54px 0; }
        h2 { font-size:1.8rem; }
        h3 { font-size:1.3rem; }
        h5 { font-size:1.12rem; }
        .btn-lg { --bs-btn-font-size:1.08rem; --bs-btn-padding-y:.68rem; --bs-btn-padding-x:1.08rem; }
        .card { border:0; border-radius:8px; box-shadow:0 12px 35px rgba(16,24,40,.08); }
        .services-kingdom { background:#fff; position:relative; overflow:hidden; }
        .services-kingdom .section-title { color:#172342; font-size:clamp(1.7rem,3vw,2.6rem); font-weight:850; letter-spacing:0; text-align:center; margin-bottom:32px; }
        .kingdom-service-card { min-height:285px; border:2px solid #e8ebf0; border-radius:22px; box-shadow:none; background:#fff; padding:26px 26px; display:flex; flex-direction:column; justify-content:flex-start; transition:transform .2s ease, box-shadow .2s ease; }
        .kingdom-service-card:hover { transform:translateY(-4px); box-shadow:0 18px 45px rgba(17,24,39,.08); }
        .kingdom-check { width:56px; height:56px; border-radius:50%; background:#f4b400; color:#fff; display:grid; place-items:center; font-size:1.9rem; font-weight:900; margin-bottom:28px; line-height:1; }
        .kingdom-service-card h5 { color:#172342; font-size:1.32rem; line-height:1.25; font-weight:850; margin-bottom:18px; }
        .kingdom-service-card p { color:#111827; font-size:1rem; line-height:1.42; margin-bottom:20px; }
        .kingdom-price { color:#172342; font-size:1.02rem; font-weight:850; margin-top:auto; }
        .kingdom-arrow { position:absolute; top:50%; transform:translateY(-10%); width:44px; height:44px; border:3px solid #172342; border-radius:50%; display:grid; place-items:center; color:#172342; background:#fff; font-size:2rem; line-height:1; text-decoration:none; }
        .kingdom-arrow.left { left:20px; }
        .kingdom-arrow.right { right:20px; }
        @media (max-width: 1199.98px) { .kingdom-arrow { display:none; } .kingdom-service-card { min-height:275px; } }
        .metric { border-left:4px solid var(--slk-green); }
        .status { text-transform:capitalize; }
        .site-footer { margin-top:56px; color:#fff; font-family:'Trebuchet MS', 'Segoe UI', Arial, sans-serif; font-size:12px; line-height:18px; }
        .footer-main { position:relative; overflow:hidden; background:linear-gradient(rgba(0,0,0,.82), rgba(0,0,0,.82)), url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1800&q=80') center/cover; padding:34px 0 28px; }
        .footer-title { margin:0 0 16px; color:#fff; font-size:16px; line-height:22px; font-weight:700; }
        .footer-brand { display:flex; align-items:center; gap:8px; margin-bottom:16px; color:#fff; text-decoration:none; }
        .footer-brand .brand-mark { width:38px; height:38px; border-radius:10px; font-size:16px; }
        .footer-brand strong { font-size:18px; line-height:24px; }
        .footer-contact { display:grid; gap:8px; margin:0; padding:0; list-style:none; }
        .footer-contact li { display:flex; align-items:flex-start; gap:8px; color:#fff; font-size:12px; line-height:18px; }
        .footer-contact i, .footer-services i, .footer-address i { color:#ff8800; flex:0 0 auto; margin-top:3px; }
        .footer-services { columns:2; column-gap:36px; margin:0 0 18px; padding:0; list-style:none; }
        .footer-services li { break-inside:avoid; display:flex; gap:8px; margin:0 0 8px; color:#fff; font-size:12px; line-height:18px; }
        .footer-services a { color:#fff; text-decoration:none; }
        .footer-services a:hover { color:#ffad3d; }
        .footer-address { display:flex; gap:8px; color:#fff; font-size:12px; line-height:18px; }
        .footer-social { display:flex; flex-wrap:wrap; gap:7px; margin-bottom:32px; }
        .footer-social a { width:30px; height:30px; border-radius:6px; display:grid; place-items:center; background:#ff8800; color:#fff; font-size:16px; text-decoration:none; }
        .footer-newsletter { display:flex; width:100%; max-width:360px; }
        .footer-newsletter input { min-width:0; flex:1; height:34px; border:1px solid #cfd4dc; border-radius:6px 0 0 6px; padding:6px 10px; color:#4b5563; font-size:12px; line-height:18px; }
        .footer-newsletter button { height:34px; border:0; border-radius:0 6px 6px 0; padding:6px 10px; background:#ff8800; color:#fff; font-size:12px; line-height:18px; }
        .footer-copy { padding-top:18px; color:#d7d7d7; font-size:11px; line-height:16px; }
        @media (max-width: 991.98px) {
            .footer-services { columns:1; }
            .footer-social { margin-bottom:24px; }
        }
        @media (max-width: 575.98px) {
            .footer-main { padding:28px 0 24px; }
            .footer-newsletter { flex-direction:column; gap:10px; }
            .footer-newsletter input, .footer-newsletter button { width:100%; border-radius:6px; }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}"><span class="brand-mark">LA</span> Lasafi</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
        <div id="nav" class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('pages.preview', 'services') }}">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('pages.preview', 'how-it-works') }}">How It Works</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('pages.preview', 'why-lasafi') }}">Why Lasafi</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#service-areas">Areas</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#testimonials">Testimonials</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('bookings.create') }}">Book</a></li>
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    @if(auth()->user()->isRole(['admin', 'dispatcher']))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Manage</a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.services.index') }}">Services</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.providers.index') }}">Providers</a></li>
                                <li><a class="dropdown-item" href="{{ route('bookings.index') }}">Bookings</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.reports.index') }}">Reports</a></li>
                            </ul>
                        </li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="{{ route('profile') }}">Profile</a></li>
                    <li class="nav-item">
                        <form method="post" action="{{ route('logout') }}">@csrf<button class="btn btn-sm btn-outline-secondary">Logout</button></form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="btn btn-sm btn-brand" href="{{ route('register') }}">Register</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<main>
    @if(session('success'))<div class="container mt-3"><div class="alert alert-success">{{ session('success') }}</div></div>@endif
    @if($errors->any())<div class="container mt-3"><div class="alert alert-danger">{{ $errors->first() }}</div></div>@endif
    @yield('content')
</main>
<footer class="site-footer">
    <section class="footer-main">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-3">
                    <h2 class="footer-title">CONTACT US</h2>
                    <a class="footer-brand" href="{{ route('home') }}"><span class="brand-mark">LA</span><strong>Lasafi</strong></a>
                    <ul class="footer-contact">
                        <li><i class="bi bi-telephone-fill"></i><span>+254 711 000 000</span></li>
                        <li><i class="bi bi-envelope-fill"></i><span>support@lasafi.co.ke</span></li>
                        <li><i class="bi bi-calendar3"></i><span>Mon-Fri: 8am - 5pm</span></li>
                        <li><i class="bi bi-calendar3"></i><span>Sat: 8am - 12pm</span></li>
                        <li><i class="bi bi-calendar3"></i><span>Sun: Closed</span></li>
                    </ul>
                </div>
                <div class="col-lg-5">
                    <h2 class="footer-title text-lg-center">Our Services</h2>
                    <ul class="footer-services">
                        <li><i class="bi bi-chevron-right"></i><a href="{{ route('pages.preview', 'services') }}">Residential Cleaning</a></li>
                        <li><i class="bi bi-chevron-right"></i><a href="{{ route('pages.preview', 'services') }}">Commercial Cleaning</a></li>
                        <li><i class="bi bi-chevron-right"></i><a href="{{ route('pages.preview', 'services') }}">Move-In and Move-Out Cleaning</a></li>
                        <li><i class="bi bi-chevron-right"></i><a href="{{ route('pages.preview', 'services') }}">Post-Construction Cleaning</a></li>
                        <li><i class="bi bi-chevron-right"></i><a href="{{ route('pages.preview', 'services') }}">Sofa and Carpet Cleaning</a></li>
                        <li><i class="bi bi-chevron-right"></i><a href="{{ route('pages.preview', 'services') }}">Office Maintenance</a></li>
                        <li><i class="bi bi-chevron-right"></i><a href="{{ route('pages.preview', 'services') }}">Laundry Services</a></li>
                        <li><i class="bi bi-chevron-right"></i><a href="{{ route('pages.preview', 'services') }}">CCTV and Networking</a></li>
                    </ul>
                    <h2 class="footer-title mt-4 mb-3">Our Office Address</h2>
                    <div class="footer-address"><i class="bi bi-geo-alt-fill"></i><span>Nairobi, Kenya. Mobile teams available across Nairobi, Kiambu, Machakos, Kajiado, Mombasa, Nakuru, Kisumu, and Eldoret.</span></div>
                </div>
                <div class="col-lg-4">
                    <h2 class="footer-title">Find Us On Social Media</h2>
                    <div class="footer-social">
                        <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                    </div>
                    <h2 class="footer-title">Signup To Our Newsletter</h2>
                    <form class="footer-newsletter" action="{{ route('home') }}" method="get">
                        <input type="email" name="email" placeholder="Email Address..." aria-label="Email Address">
                        <button type="submit">Subscribe!</button>
                    </form>
                </div>
            </div>
            <div class="footer-copy">© {{ date('Y') }} Lasafi. Cleaning, movers, repairs, networking, CCTV and office maintenance.</div>
        </div>
    </section>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
