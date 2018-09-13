@extends('auth.layout')

@section('content')

@include('auth.partials.logo', ['width' => '200', 'height' => '39'])

<a class="btn btn-default btn-primary mx-auto" href="{{ route('auth.social', 'facebook') }}">Facebook</a>

<form class="bg-white shadow rounded-lg p-8 max-w-login mx-auto"
    method="POST"
    action="{{ route('login') }}"
    aria-label="{{ __('Login') }}">

    @csrf

    @component('auth.partials.heading')
        {{ __('Welcome Back!') }}
    @endcomponent

    @include('auth.partials.errors')

    <div class="mb-6">
        <label class="block font-bold mb-2" for="email">Email Address</label>
        <input class="form-control form-input form-input-bordered w-full" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    </div>

    <div class="mb-6">
        <label class="block font-bold mb-2" for="password">
            Password &ndash;
            <a class="text-primary dim font-bold no-underline" href="{{ route('password.request') }}">
                Remind me
            </a>
        </label>
        <input class="form-control form-input form-input-bordered w-full" id="password" type="password" name="password" required>
    </div>

    <div class="mb-6">
        <label class="flex items-center block text-xl font-bold">
            <input class="" type="checkbox" name="remember">
            <span class="text-base ml-2">Remember Me</span>
        </label>
    </div>

    <button
        class="w-full btn btn-default btn-primary hover:bg-primary-dark"
        type="submit">
        Login
    </button>
</form>
@endsection
