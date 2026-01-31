<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
    <title>Europath</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Europath.com was created to fill a long-standing gap in the advertising industry, the need for authentic, high-quality images that truly reflect Sri Lankan life, culture, people, and landscapes. ">
    <meta name="keywords" content="Pictorial, stock, pictures, office, wild, sri lanka">
    <meta name="author" content="MGee - The Creative Factory">

    <!-- Open Graph (Facebook, LinkedIn, etc.) -->
    <meta property="og:title" content="Europath">
    <meta property="og:description" content="Europath.com was created to fill a long-standing gap in the advertising industry, the need for authentic, high-quality images that truly reflect Sri Lankan life, culture, people, and landscapes. ">
    <meta property="og:image" content="{{ asset('public/frontend/assets/images/og_image.jpg') }}">
    <meta property="og:url" content="https://Europath.com">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Europath">
    <meta name="twitter:description" content="Europath.com was created to fill a long-standing gap in the advertising industry, the need for authentic, high-quality images that truly reflect Sri Lankan life, culture, people, and landscapes.">
    <meta name="twitter:image" content="{{ asset('public/frontend/assets/images/og_image.jpg') }}">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('public/assets/img/favicon/favicon.png') }}">

	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/assets/css/bootstrap.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('public/frontend/assets/css/icons.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/assets/css/style.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/assets/css/responsive.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/assets/css/color.css') }}" />

	<!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/assets/css/extralayers.css') }}" media="screen" />
	<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/assets/css/settings.css') }}" media="screen" />
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FQEX4C83GD"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-FQEX4C83GD');
    </script>

    <style>
        .pages a.disabled {
            pointer-events: none;
            opacity: 0.4;
        }
    </style>

</head>
<body>
<div class="theme-layout">
	<header>
		<div class="container">
			<div class="header-container">
				<nav>
					<ul>
						<li><a href="{{ route('home') }}" title="">Home</a></li>
						<li><a href="{{ route('images.index') }}" title="">Images</a></li>
						<li><a href="{{ route('contact-us') }}" title="">Contact Us</a></li>
					</ul>
				</nav><!-- Navigation -->
				<div class="header-links">
					<ul>
                    @if(Auth::guard('site')->check())
                        <li><a title="">{{ Auth::guard('site')->user()->name }}</a></li>
                        <li>
                            <form id="logout-form" action="{{ route('site.logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-link" style="padding:0; border:none;">Logout</button>
                            </form>
                        </li>
                    @else
                        <li><a class="call-reg login-popup" href="#" title="">Log in</a></li>
                        <li><a class="call-reg signup-popup" href="#" title="">Sign up</a></li>
                    @endif
                    </ul>
				</div><!-- Header Links -->
			</div>
		</div>
	</header><!-- Header -->

	<div class="responsive-header">
		<div class="responsive-bar">
			<span class="open-menu"><i data-target="menu" class="fa fa-align-center"></i></span>
			<div class="logo"><a href="{{ route('home') }}" title=""><img src="{{ asset('public/frontend/assets/images/logo.png')}}" alt="" /></a></div><!-- Logo -->
			<span class="open-links"><i data-target="links" class="fa fa-arrow-right"></i></span>
		</div>
		<div class="responsive-links menu">
			<ul>
				<li><a href="{{ route('home') }}" title="">Home</a></li>
				<li><a href="{{ route('images.index') }}" title="">Images</a></li>
			</ul>
		</div>

		<div class="responsive-links other">
			<ul>
				@if(Auth::guard('site')->check())
                    <li><a title="">{{ Auth::guard('site')->user()->name }}</a></li>
                    <li>
                        <form id="logout-form" action="{{ route('site.logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-link" style="padding:0; border:none;">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a class="call-reg login-popup" href="#" title="">Log in</a></li>
                    <li><a class="call-reg signup-popup" href="#" title="">Sign up</a></li>
                @endif
			</ul>
		</div>
	</div><!-- Responsive Header -->




    @yield('content')

    @include('layouts.userFooter')

    @yield('footerScript')

</body>
</html>
