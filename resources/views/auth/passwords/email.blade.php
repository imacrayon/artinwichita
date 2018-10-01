@extends('auth.layout')

@section('content')

@include('auth.partials.logo', ['width' => '200', 'height' => '39'])

<form
    class="bg-white shadow rounded-lg p-8 max-w-login mx-auto"
    method="POST"
    action="{{ route('password.email') }}"
    aria-label="{{ __('Reset Password') }}"
>
    @csrf

    @component('auth.partials.heading')
        {{ __('Reset Password') }}
    @endcomponent

    @include('auth.partials.errors')

    <div class="mb-6">
        <label class="block font-bold mb-2" for="email">{{ __('Email Address') }}</label>
        <input class="form-control form-input form-input-bordered w-full{{ $errors->has('email') ? ' border-danger' : '' }}" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @if ($errors->has('email'))
            <span class="text-danger text-xs italic" role="alert">
                {{ $errors->first('email') }}
            </span>
        @endif
    </div>

    <button type="submit" class="w-full btn btn-primary hover:bg-primary-dark">
        {{ __('Send Reset Link') }}
    </button>
</form>
@endsection
