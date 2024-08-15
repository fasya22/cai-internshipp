@extends('front.layouts.app')

@section('content')
<div class="wrapper-page">
    <div class="card">
        <div class="card-body">
            <h3 class="text-center m-0">
                <a href="{{ url('/') }}" class="logo logo-admin"><img src="{{ asset('front/images/logo.png') }}" height="50" alt="logo"></a>
            </h3>

            <div class="p-3">
                <h4 class="text-muted font-18 mb-3 text-center">{{ __('Verify Your Email Address') }}</h4>
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                <p class="text-center">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                <p class="text-center">{{ __('If you did not receive the email') }},</p>

                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-md waves-effect waves-light">{{ __('Click here to request another') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="m-t-40 text-center">
        {{-- <p>{{ __('Remember It ?') }} <a href="{{ route('login') }}" class="text-primary">{{ __('Sign In Here') }}</a></p> --}}
        <div class="copyright">
            {{-- &copy; Copyright <strong><span>Central AI</span></strong>. All Rights Reserved --}}
            &copy; {{ date('Y') }} <strong><span>Central AI</span></strong>. {{ __('All Rights Reserved') }}
        </div>
    </div>
</div>
@endsection
