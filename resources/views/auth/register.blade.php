@extends('web.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-3">
            <h3 class="text-center font-weight-bold">Créer un compte</h3>
            {{-- <p class="text-center">Connectez-vous avec notre email et votre mot de passe</p> --}}
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="py-1">
                            <select class="custom-select mr-2" id="unp-category" name="type" required>
                                <option value="">-------Type-------</option>
                                <option value="fournisseur" {{ (old('type') == 'fournisseur') ? 'selected' : '' }} >Fournisseur</option>
                                <option value="client" {{ (old('type') == 'client') ? 'selected' : '' }}>Client</option>
                            </select>
                        </div>
                        @error('type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>
                    <div class="col-md-6">
                        <div class="input-group-overlay d-lg-none">
                            <div class="input-group-prepend-overlay">
                                <span class="input-group-text">
                                    <i class="icofont-user-alt-5"></i>
                                </span>
                            </div>
                            <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        </div>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                    <div class="col-md-6">
                        <div class="input-group-overlay d-lg-none">
                            <div class="input-group-prepend-overlay">
                                <span class="input-group-text">
                                    <i class="icofont-envelope"></i>
                                </span>
                            </div>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
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
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmation') }}</label>
                    <div class="col-md-6">
                        <div class="input-group-overlay d-lg-none">
                            <div class="input-group-prepend-overlay">
                                <span class="input-group-text">
                                    <i class="icofont-ui-lock"></i>
                                </span>
                            </div>
                            <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-info btn-block btn-lg">
                            {{ __('Continuer') }}
                        </button>
                    </div>
                </div>
            </form>

            <div class="form-group row mt-5 text-center">
                <div class="col-md-8 offset-md-4">
                    Déjà un compte ?
                    <a href="{{ route('login') }}">connectez-vous</a>
                </div>
            </div>

            <div class="form-group row mt-1 text-center">
                <div class="col-md-8 offset-md-4 small">
                    En continuant vous accetez nos
                    <a href="#quick-view" data-toggle="modal">
                        conditions générales d'utilisation
                    </a>
                </div>
                <!-- Quick View Modal-->
                <div class="modal-quick-view modal fade" id="quick-view" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close ml-0 pl-0" type="button" data-dismiss="modal" aria-label="Close">
                                    <i class="icofont-simple-left"></i>
                                </button>
                                <h5 class="modal-title product-title ml-2">
                                    <a href="#" data-toggle="tooltip" data-placement="right" title="Go to product page">
                                        Conditions générales d'utilisation
                                    </a>
                                </h5>
                            </div>
                            <div class="modal-body">
                                <h4>Condition de commande :</h4>
                                Toutes course commandée sur notre application est réalisée dans les 24h après le paiement de la marchandise et des frais de course sur notre plateforme.
                                En cas de commande non conforme à la livraison nous vous garantissons le changement des articles ou le remboursement de votre argent par le même moyen de paiement dans un délais de 15 jours.
                                <h4>Condition de publication : </h4>
                                En cas d’achat d’article non conforme détecter par notre client vous vous engagez à remplacer les articles ou à rembourser l’agent de l’article.

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
