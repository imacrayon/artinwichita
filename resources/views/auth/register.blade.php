@extends('auth.layout')

@section('content')

@include('auth.partials.logo', ['width' => '200', 'height' => '39'])

<form
    class="bg-white shadow rounded-lg p-8 max-w-login mx-auto"
    method="POST"
    action="{{ route('register') }}"
    aria-label="{{ __('Register') }}"
>
    @csrf

    @component('auth.partials.heading')
        {{ __('Register') }}
    @endcomponent

    @include('auth.partials.errors')

    <div class="mb-6 {{ $errors->has('name') ? ' has-error' : '' }}">
        <label class="block font-bold mb-2" for="name">{{ __('First Name') }}</label>
        <input class="form-control form-input form-input-bordered w-full" id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    </div>

    <div class="mb-6 {{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="block font-bold mb-2" for="email">{{ __('Email Address') }}</label>
        <input class="form-control form-input form-input-bordered w-full" id="email" type="email" name="email" value="{{ old('email') }}" required>
    </div>

    <div class="mb-6 {{ $errors->has('password') ? ' has-error' : '' }}">
        <label class="block font-bold mb-2" for="password">{{ __('Password') }}</label>
        <input class="form-control form-input form-input-bordered w-full" id="password" type="password" name="password" required>
    </div>

    <div class="mb-6 {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label class="block font-bold mb-2" for="password_confirmation">{{ __('Confirm Password') }}</label>
        <input class="form-control form-input form-input-bordered w-full" id="password_confirmation" type="password" name="password_confirmation" required>
    </div>

    <button class="w-full btn btn-default btn-primary hover:bg-primary-dark" type="submit">
        {{ __('Register') }}
    </button>
</form>
@endsection
