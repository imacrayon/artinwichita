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
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.app = {!! json_encode([
            'csrf' => csrf_token(),
            'user' => Auth::user(),
            'services' => [
                'facebook' => env('FACEBOOK_CLIENT_TOKEN')
            ],
        ]) !!}
    </script>
    <script src="{{ asset('js/manifest.js') }}" defer></script>
    <script src="{{ asset('js/vendor.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="font-sans text-black">
    <a id="skip-link" class="sr-only focus:sr-show" href="#main">Skip to Content</a>
    <div id="app">
        <header class="bg-white border-b border-grey-light fixed pin-t pin-x z-100">
            <navigation inline-template>
                <nav>
                    <div class="max-w-2xl mx-auto flex flex-wrap items-center justify-between lg:px-4">
                        <div class="flex items-center justify-between w-full p-4 lg:w-auto lg:p-0 lg:shadow-none">
                            <div class="flex items-center lg:flex-no-shrink mr-6">
                                <a class="text-lg text-primary no-underline" href="{{ url('/') }}">Art</a>
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
                        <div :class="{'hidden': !open }" class="w-full lg:flex lg:w-auto lg:block">
                            <a href="#" class="block text-grey-dark hover:text-primary px-5 py-4">
                                Page
                            </a>
                        </div>
                    </div>
                </nav>
            </navigation>
        </header>
        <div class="w-full max-w-screen-xl mx-auto px-6">
            <div class="lg:flex -mx-6">
                <div id="sidebar" class="hidden absolute z-90 top-16 bg-white w-full border-b -mb-16 lg:-mb-0 lg:static lg:bg-transparent lg:border-b-0 lg:pt-0 lg:w-1/4 lg:block lg:border-0 xl:w-1/5">
                    <div class="lg:block lg:relative lg:sticky lg:top-16">
                        <nav id="nav" class="px-6 pt-6 overflow-y-auto text-base lg:text-sm lg:py-12 lg:pl-6 lg:pr-8 sticky?lg:h-(screen-16)">
                        </nav>
                    </div>
                </div>
                <main id="main" class="min-h-screen w-full lg:static lg:max-h-full lg:overflow-visible lg:w-3/4 xl:w-4/5">
                    <div class="pt-24 pb-8 lg:pt-28 w-full">
                        <div class="flex">
                            <div class="px-6 xl:px-12 w-full max-w-lg mx-auto lg:ml-0 lg:mr-auto xl:mx-0 xl:w-3/4">
                                @yield('content')
                            </div>
                            <div class="hidden xl:text-sm xl:block xl:w-1/4 xl:px-6">
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <notifications></notifications>
    </div>
</body>
</html>
