@extends('web.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-3">
            <h3 class="text-center font-weight-bold">Profil</h3>
            <p class="text-center">Completez les informations de votre compte</p>
            <form method="POST" action="{{ route('profil.register') }}">
                @csrf
                @if (auth()->user()->type == 'fournisseur')
                    <div class="form-group row">
                        <label style="width: 180px;" for="boutique" class="col-md-4 col-form-label text-md-right">{{ __('Nom de la boutique *') }}</label>
                        <div class="col-md-6">
                            <div class="input-group-overlay d-lg-none">
                                <div class="input-group-prepend-overlay">
                                    <span class="input-group-text">
                                        <i class="icofont-food-cart"></i>
                                    </span>
                                </div>
                                <input id="boutique" type="text" class="form-control form-control-lg @error('boutique') is-invalid @enderror" name="boutique" value="{{ old('boutique') }}" required autocomplete="boutique" autofocus>
                            </div>
                            @error('boutique')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                @endif

                <div class="form-group row">
                    <label for="prenom" class="col-md-4 col-form-label text-md-right">{{ __('Prénom *') }}</label>
                    <div class="col-md-6">
                        <div class="input-group-overlay d-lg-none">
                            <div class="input-group-prepend-overlay">
                                <span class="input-group-text">
                                    <i class="icofont-user-alt-5"></i>
                                </span>
                            </div>
                            <input id="prenom" type="text" class="form-control form-control-lg @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom') }}" required autocomplete="prenom" autofocus>
                        </div>
                        @error('prenom')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="contact" class="col-md-4 col-form-label text-md-right" style="width: 170px;">{{ __('Contact WhatsApp') }}</label>
                    <div class="col-md-6">
                        <div class="input-group-overlay d-lg-none">
                            <div class="input-group-prepend-overlay">
                                <span class="input-group-text">
                                    <i class="icofont-iphone"></i>
                                </span>
                            </div>
                            <input id="contact" type="text" class="form-control form-control-lg @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" required>
                        </div>
                        @error('contact')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="pays_id" class="col-md-4 col-form-label text-md-right">{{ __('Pays') }}</label>
                    <div class="col-md-6">
                        <div class="input-group-overlay d-lg-none">
                            <div class="input-group-prepend-overlay">
                                <span class="input-group-text">
                                    <i class="icofont-globe-alt"></i>
                                </span>
                            </div>
                            <select class="form-control form-control-lg mr-2" id="unp-category" name="pays_id" required>
                                <option value="">-------Pays-------</option>
                                @foreach ($pays as $country)
                                    <option {{ ($country->id == 110) ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->titre }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('pays_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="ville" class="col-md-4 col-form-label text-md-right">{{ __('Ville') }}</label>
                    <div class="col-md-6">
                        <div class="input-group-overlay d-lg-none">
                            <div class="input-group-prepend-overlay">
                                <span class="input-group-text">
                                    <i class="icofont-building-alt"></i>
                                </span>
                            </div>
                            <input id="ville" type="text" class="form-control form-control-lg @error('ville') is-invalid @enderror" name="ville" value="{{ old('ville') }}" required autocomplete="ville">
                        </div>
                        @error('ville')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="adresse" class="col-md-4 col-form-label text-md-right">{{ __('Adresse/localisation') }}</label>
                    <div class="col-md-6">
                        <div class="input-group-overlay d-lg-none">
                            <div class="input-group-prepend-overlay">
                                <span class="input-group-text">
                                    <i class="icofont-google-map"></i>
                                </span>
                            </div>
                            <input id="adresse" type="text" class="form-control form-control-lg @error('adresse') is-invalid @enderror" name="adresse" value="{{ old('adresse') }}" required autocomplete="adresse">
                        </div>
                        @error('adresse')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-info btn-block btn-lg">
                            {{ __('Finaliser') }}
                        </button>
                    </div>
                </div>
            </form>

            {{-- <div class="form-group row mt-1 text-center">
                <div class="col-md-8 offset-md-4 small">
                    En continuant vous accetez nos
                    <a href="#quick-view" data-toggle="modal">
                        conditions générales d'utilisation
                    </a>
                </div>
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
            </div> --}}
        </div>
    </div>
</div>
@endsection
