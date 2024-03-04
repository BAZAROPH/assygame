@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'accueil',
])
@section('content')

    <div class="modal fade" id="clean-cart" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Vider panier</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="font-size-sm alert alert-danger text-center">
                        Voulez-vous vraiment vider le panier
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Fermer</button>
                    <a href="{{ url('panier?clean=1') }}" class="btn btn-danger btn-shadow btn-sm">
                        <i class="icofont-trash"></i> Vider
                    </a>
                </div>
            </div>
        </div>
    </div>

    @foreach (Cart::instance('shopping')->content() as $item)
        <div class="modal fade" id="clean-{{ $item->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content h-100">
                    <div class="modal-header">
                        <h4 class="modal-title">Retirer du panier</h4>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="font-size-sm alert alert-danger text-center">
                            Êtes-vous sûr de vouloir supprimer <strong>"{{ $item->name }}"</strong> de votre panier
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Non</button>
                        <a href="{{ url('panier?rowId='.$item->rowId) }}" class="btn btn-danger btn-shadow btn-sm">
                            <i class="icofont-trash"></i> Oui
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="page-title-overlap bg-dark pt-4 pb-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
                <h1 class="h3 text-light mb-0">Votre panier ({{ count(Cart::instance('shopping')->content()) }})</h1>
            </div>
        </div>
    </div>
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 pt-5">
        <div class="row">
            <!-- List of items-->
            <section class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center pt-3 pb-2 pb-sm-5 mt-1">
                    {{--  @if (count(Cart::instance('shopping')->content()))
                        <h2 class="h6 text-light mb-0">
                            <a class="btn btn-danger btn-sm pl-2" href="#clean-cart" data-toggle="modal">
                                <i class="icofont-trash mr-2"></i>Vider le panier
                            </a>
                        </h2>
                    @endif
                    <a class="btn btn-success btn-sm pl-2" href="{{ url('/') }}">
                        <i class="czi-arrow-left mr-2"></i>Poursuivre vos achats
                    </a>  --}}
                </div>

                @if (!count(Cart::instance('shopping')->content()))
                    <div>
                        <div class="text-center text-white bg-danger border m-auto p-2 pt-4" style="border-radius: 100%; border: solid 3px; width: 150px; height:140px;">
                            <i class="icofont-shopping-cart fa-5x"></i>
                        </div>
                        <h3 class="font-weight-bold text-center">Panier vide</h3>
                    </div>
                @endif

                <form name="form1" method="get" action="" class="mt-3">
                    @csrf
                    @foreach (Cart::instance('shopping')->content() as $item)
                        @php($post = detailPanier($item->id))
                        <div class="row">
                            <div class="col-12 box-shadow border-accent mb-2 pt-2">
                                <div class="row mb-1">
                                    <div class="col-3">
                                        @if(!empty($post->getMedia('image')->first()))
                                            <a href="{{ route('product.show', $post) }}">
                                                <img class="img-fluid" width="80" src="{{ url($post->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $item->name }}">
                                            </a>
                                        @endif
                                    </div>
                                    <div class="col-9">
                                        <h3 class="product-title font-size-base mb-2">
                                            <a href="{{ route('product.show', $post) }}">
                                                {{ $item->name }}
                                            </a>
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
                                                {{ $item->options->quantite }} pièces / {{ devise($item->price) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <a class="btn btn-link px-0 text-danger"  href="#clean-{{ $item->id }}" data-toggle="modal">
                                            <i class="icofont-trash"></i>
                                            Retirer
                                        </a>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group">
                                            <div class="text-center">
                                                <div class="">
                                                    <button id="minus-{{ $item->rowId }}" onclick="this.parentNode.querySelector('input[type=number]').stepDown(); return false;" class="btn">
                                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                                    </button>
                                                    <input class="form-control w-25 d-inline-block text-center" min="1" name="{{ $item->rowId }}" id="quantity-{{ $item->rowId }}" value="{{ $item->qty }}" type="number" readonly>
                                                    <input type="hidden" id="rowId-{{ $item->rowId }}" name="rowId-{{ $item->rowId }}" value="{{ $item->rowId }}">
                                                    <button id="plus-{{ $item->rowId }}" onclick="this.parentNode.querySelector('input[type=number]').stepUp(); return false;" class="btn">
                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </form>
            </section>
             @include('web.cart.recapitulatif')
        </div>
    </div>
@endsection
@push("script")
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script>
        @foreach (Cart::instance('shopping')->content() as $item)
            $(document).ready(function() {
                $('#quantity-{{ $item->rowId }}, #plus-{{ $item->rowId }}, #minus-{{ $item->rowId }}').click(function() {
                    var quantite = $('#quantity-{{ $item->rowId }}').val();
                    var rowId = $('#rowId-{{ $item->rowId }}').val();
                    if(quantite) {
                        $.ajax({
                            url: '/fraisExpedition/'+quantite+'/'+rowId,
                            type: "GET",
                            data : {"_token":"{{ csrf_token() }}"},
                            dataType: "json",
                            success:function(data) {
                                if(data){
                                    $('.coutLivraison').html(data['cout']);
                                    $('.sousTotal').html(data['sousTotal']);
                                    $('.totalCommande').html(data['totalCommande']);
                                }
                            }
                        });
                    }
                });
            });
        @endforeach
    </script>
@endpush
