@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'profil',
])
@section('content')

<div class="modal fade" id="clean-cart" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Vider favoris</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="font-size-sm alert alert-danger text-center">
                    Voulez-vous vraiment vider la liste d'envie
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

@foreach (Cart::instance('wishlist')->content() as $item)
    <div class="modal fade" id="clean-{{ $item->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content h-100">
                <div class="modal-header">
                    <h4 class="modal-title">Retirer des favoris</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="font-size-sm alert alert-danger text-center">
                        Êtes-vous sûr de vouloir supprimer <strong>"{{ $item->name }}"</strong> de vos favoris
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Non</button>
                    <a href="{{ url('wishlist?rowId='.$item->rowId) }}" class="btn btn-danger btn-shadow btn-sm">
                        <i class="icofont-trash"></i> Oui
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach

@include('web.user.entete', [
    'breadcrumb' => '<li class="breadcrumb-item text-nowrap active" aria-current="page">'.$infosPage['title'].'</li>',
])
<div class="container pb-5 mb-2 mb-md-3">
	<div class="row">
		<section class="col-lg-8 mt-5 pt-5">
            @if (!count(Cart::instance('shopping')->content()))
                <div>
                    <div class="text-center text-white bg-danger border m-auto p-2 pt-4" style="border-radius: 100%; border: solid 3px; width: 150px; height:140px;">
                        <i class="icofont-shopping-cart fa-5x"></i>
                    </div>
                    <h3 class="font-weight-bold text-center">Pas de liste d'envie</h3>
                </div>
            @endif

            @include('flash::message')
            @foreach (Cart::instance('wishlist')->content() as $item)
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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <a class="btn btn-link px-0 text-danger"  href="#clean-{{ $item->id }}" data-toggle="modal">
                                    <i class="icofont-trash"></i>
                                    Retirer
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{--  <button class="btn btn-outline-accent btn-block" type="button">
                <i class="czi-loading font-size-base mr-2"></i>Update cart
            </button>  --}}
        </section>
	</div>
</div>
@endsection
