@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'accueil',
])
@section('content')
    @include('web.user.entete')
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-0">
        <div class="row">
            <section class="col-lg-8">
                <!-- Steps-->
                {{-- <div class="steps steps-light pt-2 pb-3 mb-5">
                    <a class="step-item active" href="{{ url('/panier') }}">
                        <div class="step-progress">
                            <span class="step-count">1</span>
                        </div>
                        <div class="step-label">
                            <i class="czi-cart"></i>Panier
                        </div>
                    </a>

                    <a class="step-item active" href="{{ url('adresse-de-livraison') }}">
                        <div class="step-progress">
                            <span class="step-count">2</span>
                        </div>
                        <div class="step-label">
                            <i class="icofont-google-map"></i>Adresse
                        </div>
                    </a>

                    <a class="step-item active" href="{{ url('date-de-livraison') }}">
                        <div class="step-progress">
                            <span class="step-count">3</span>
                        </div>
                        <div class="step-label">
                            <i class="icofont-ui-calendar"></i>Date & heure
                        </div>
                    </a>

                    <span class="step-item active current" href="{{ url('') }}">
                        <div class="step-progress">
                            <span class="step-count">4</span>
                        </div>
                        <div class="step-label">
                            <i class="czi-card"></i>Paiement
                        </div>
                    </span>
                    <span class="step-item" href="{{ url('') }}">
                        <div class="step-progress">
                            <span class="step-count">5</span>
                        </div>
                        <div class="step-label">
                            <i class="czi-check-circle"></i>Résumé
                        </div>
                    </span>
                </div> --}}
                {{-- <form name="form1" method="get" action="" class="mt-3">
                    @csrf
                    @foreach (Cart::instance('shopping')->content() as $item)
                        @php($post = detailPanier($item->id))
                        <div class="row">
                            <div class="col-12 box-shadow border-accent mb-2 pt-2">
                                <div class="row mb-1">
                                    <div class="col-3">
                                        @if(!empty($post->getMedia('image')->first()))
                                            <img class="img-fluid" width="80" src="{{ url($post->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $item->name }}">
                                        @endif
                                    </div>
                                    <div class="col-9">
                                        <h3 class="product-title font-size-base mb-2">
                                            {{ $item->name }}
                                        </h3>
                                        <div class="font-size-sm text-muted">
                                            @if ($item->options->taille)
                                                Taille:
                                                @foreach ($item->options->taille as $value)
                                                    <label style="min-width: 2rem;
                                                    height: 2rem;
                                                    margin-bottom: 0;
                                                    padding-right: 0.375rem;
                                                    padding-left: 0.375rem;
                                                    padding-top: 0;
                                                    border: 1px solid #e3e9ef;" class="custom-option-label">{{ $value }}</label>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="font-size-sm text-muted">
                                            @if ($item->options->couleur)
                                                @foreach ($item->options->couleur as $value)
                                                    <label style="min-width: 2rem;
                                                    height: 2rem;
                                                    margin-bottom: 0;
                                                    padding-right: 0.375rem;
                                                    padding-left: 0.375rem;
                                                    padding-top: 0;
                                                    border: 1px solid #e3e9ef;" class="custom-option-label rounded-circle">
                                                        <span class="custom-option-color rounded-circle" style="width: 1.5rem;
                                                        height: 1.5rem;
                                                        margin-top: -0.75rem;
                                                        margin-left: -0.75rem;
                                                        background-color: {{ $value }};"></span>
                                                    </label>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div>
                                            <span class="mr-1 text-danger font-size-sm">
                                                ({{ $item->options->quantite }} pièces / {{ devise($item->price) }}) x {{ $item->qty }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </form> --}}
            </section>
            @include('web.cart.recapitulatif')
        </div>
    </div>
@endsection
