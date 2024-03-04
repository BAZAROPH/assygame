@extends('web.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-5">
            <h1 class="text-center font-weight-bold">Bienvenue</h1>
            <p class="text-center">Connectez-vous avec notre email et votre mot de passe</p>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                    <div class="col-md-6">
                        <div class="input-group-overlay d-lg-none">
                            <div class="input-group-prepend-overlay">
                                <span class="input-group-text"><i class="icofont-envelope"></i></span>
                            </div>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Mot de passe') }}</label>

                    <div class="col-md-6">
                        <div class="input-group-overlay d-lg-none">
                            <div class="input-group-prepend-overlay">
                                <span class="input-group-text">
                                    <i class="icofont-ui-lock"></i>
                                </span>
                            </div>
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Rester connecter') }}
                            </label>
                        </div>
                    </div>
                </div> --}}

                <div class="form-group row mb-0 text-center">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-info btn-lg btn-block mb-3">
                            {{ __('Valider') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                {{ __('Mot de passe oublié?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            <div class="form-group row mt-5 text-center">
                <div class="col-md-8 offset-md-4">
                    Vous n'avez pas de compte ?
                    <a href="{{ route('register') }}">inscrivez-vous</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
