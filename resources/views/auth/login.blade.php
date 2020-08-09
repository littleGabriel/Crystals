@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm" style="opacity: 0.8">
                <div class="card-header">{{ __('auth.Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('auth.E-Mail Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('auth.Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('auth.Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('auth.Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('auth.Forgot Your Password?') }}
                                    </a>
                                @endif

                                <a class="btn btn-link float-right" href="/login/github">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1.6em" height="1.6em" viewBox="0 0 30 30" version="1.1">
                                        <g id="surface3666969">
                                            <path style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,0%,0%);fill-opacity:0.6;" d="M 15 3 C 8.371094 3 3 8.371094 3 15 C 3 20.621094 6.871094 25.328125 12.09375 26.628906 C 12.035156 26.46875 12 26.28125 12 26.046875 L 12 23.996094 C 11.511719 23.996094 10.695312 23.996094 10.492188 23.996094 C 9.671875 23.996094 8.941406 23.644531 8.585938 22.988281 C 8.195312 22.257812 8.125 21.144531 7.152344 20.460938 C 6.863281 20.234375 7.082031 19.976562 7.414062 20.011719 C 8.03125 20.183594 8.539062 20.605469 9.019531 21.230469 C 9.5 21.859375 9.722656 22 10.617188 22 C 11.050781 22 11.699219 21.976562 12.308594 21.878906 C 12.636719 21.046875 13.203125 20.28125 13.894531 19.917969 C 9.898438 19.507812 7.992188 17.519531 7.992188 14.820312 C 7.992188 13.65625 8.488281 12.535156 9.328125 11.585938 C 9.054688 10.648438 8.707031 8.730469 9.433594 8 C 11.234375 8 12.320312 9.164062 12.582031 9.480469 C 13.476562 9.175781 14.460938 9 15.496094 9 C 16.53125 9 17.519531 9.175781 18.417969 9.484375 C 18.675781 9.171875 19.761719 8 21.566406 8 C 22.296875 8.730469 21.945312 10.65625 21.667969 11.59375 C 22.503906 12.539062 22.996094 13.660156 22.996094 14.820312 C 22.996094 17.515625 21.089844 19.503906 17.101562 19.917969 C 18.199219 20.488281 19 22.101562 19 23.3125 L 19 26.046875 C 19 26.152344 18.976562 26.226562 18.964844 26.316406 C 23.640625 24.675781 27 20.234375 27 15 C 27 8.371094 21.628906 3 15 3 Z M 15 3 "/>
                                        </g>
                                    </svg>
                                    Github登录
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
