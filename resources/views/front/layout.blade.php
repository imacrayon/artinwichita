<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-grey-lighter antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ isset($title) ? "${title}  | " : '' }}{{ config('app.name') }}</title>
    <meta name="description" content="{{ isset($description) ? $description : '' }}">

    <!-- Open Graph -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ config('app.name') }}">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:description" content="{{ isset($description) ? $description : '' }}">
    <meta property="og:image" content="{{ isset($social_image) ? $social_image : asset('images/social.png') }}">
    <meta property="og:site_name" content="{{ config('app.name') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Khand:300,700|Rubik:400" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.app = {!! json_encode([
            'csrf' => csrf_token(),
            'user' => Auth::user()
        ]) !!}
    </script>
    <script src="{{ asset('js/manifest.js') }}" defer></script>
    <script src="{{ asset('js/vendor.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="font-body text-black">
    <a id="skip-link" class="sr-only focus:sr-show" href="#main">Skip to Content</a>
    <div id="app">
        <site-header inline-template>
            <header
                class="border-grey-light fixed pin-t pin-x z-10 site-header"
                :class="{
                    'site-header-hidden': hidden,
                    'border-b': !elevated && !open,
                    'bg-white': elevated || open,
                    'shadow': elevated || open
                }"
            >
                <nav class="lg:flex flex-wrap items-center justify-between lg:max-w-2xl xl:max-w-3xl lg:flex mx-auto lg:px-8">
                    <div class="lg:border-none" :class="{'border-b': open}">
                        <div class="max-w-md mx-auto px-5 flex items-center justify-between w-full lg:px-0 lg:max-w-2xl xl:max-w-3xl">
                            <div class="flex items-center lg:flex-no-shrink mr-6">
                                <router-link
                                    to="/"
                                    class="block leading-none text-grey-dark hover:text-primary px-5 py-4 border-b-4 border-primary"
                                >
                                    {{ config('app.name') }}
                                </router-link>
                            </div>
                            <div class="lg:hidden">
                                <button
                                    :class="{'text-grey-dark': !open, 'text-primary': open, 'border-primary': open}"
                                    class="flex rounded-sm items-center px-3 py-2 border focus:outline-none focus:text-primary focus:border-primary hover:text-primary hover:border-primary"
                                    @click="toggle"
                                >
                                    <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <title>Menu</title>
                                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="max-w-md mx-auto lg:max-w-2xl xl:max-w-3xl lg:flex lg:w-auto lg:mx-0"
                        :class="{'hidden': !open }"
                    >
                        <router-link
                            to="/places"
                            class="block leading-none text-grey-dark hover:text-primary px-5 py-4 border-b-4 border-transparent"
                            active-class="border-primary"
                        >
                            Places
                        </router-link>
                        @guest
                            <a href="{{ route('login') }}" class="block leading-none text-grey-dark hover:text-primary px-5 py-4 border-b-4 border-transparent">
                                {{ __('Login') }}
                            </a>
                        @else
                            <a class="block leading-none text-grey-dark hover:text-primary px-5 py-4 border-b-4 border-transparent"
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            >
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endguest
                    </div>
                </nav>
            </header>
        </site-header>
        <main id="main" class="pt-20 sm:pt-24 pb-8 lg:pt-28">
            @yield('content')
        </main>
        <notifications></notifications>
    </div>
</body>
</html
