@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'produit',
])
@section('content')

@include('web.user.entete')
<!-- Page Content-->
<div class="container pb-5 mb-2 mb-md-3">
	<!-- Gallery + details-->
    <div class="bg-light box-shadow-lg rounded-lg px-4 py-3 mb-5">
        <div class="px-lg-3">
            <div class="row">
                <!-- Product gallery-->
                <div class="col-lg-7 pr-lg-0 pt-lg-4">
                    <div class="d-flex justify-content-between align-items-center float-right" style="margin-top: -60px; margin-right:-30px;">
                        <a href="{{ route('wishlist.add', $produit) }}" class="btn-wishlist mr-0 mr-lg-n3" data-toggle="tooltip" title="Ajout à la liste d'envie">
                            <i class="czi-heart"></i>
                        </a>
                    </div>
                    <div class="d-flex justify-content-between align-items-center float-left" style="margin-top: -30px; margin-left: -30px;">
                        <div class="badge badge-success mt-n1">
                            {{ $produit->stock }}
                        </div>
                        {{-- @switch($produit->stock)
                            @case('En stock')
                                <div class="badge badge-success mt-n1">
                                    <i class="czi-security-check"></i>Nouveau
                                </div>
                            @case('en-reapprovisionnement')
                                <div class="product-badge product-bientot mt-n1">
                                    <i class="czi-security-check"></i>En réapprovisionnement
                                </div>
                                @break
                            @default
                                <div class="product-badge product-rupture mt-n1">
                                    <i class="czi-security-check"></i>Rupture
                                </div>
                        @endswitch --}}
                    </div>
                    <!-- Gallery-->
                    <div class="cz-gallery row pb-2">
                        <div class="col-8">
                            @if(!empty($produit->getMedia('image')->first()))
                                <a class="gallery-item rounded-lg mb-grid-gutter" href="{{ url($produit->getMedia('image')->first()->getUrl('thumb')) }}" data-sub-html="&lt;h6 class=&quot;font-size-sm text-light&quot;&gt;{{ $infosPage['title'] }}&lt;/h6&gt;">
                                    <img src="{{ url($produit->getMedia('image')->first()->getUrl()) }}" alt="{{ $infosPage['title'] }}">
                                    <span class="gallery-item-caption">{{ $infosPage['title'] }}</span>
                                </a>
                            @endif
                        </div>
                        <div class="col-4">
                            @php($i = 0)
                            @foreach ($produit->getMedia('image') as $item)
                                @if ($i > 0)
                                    <a class="gallery-item rounded-lg mb-grid-gutter" href="{{ url($item->getUrl()) }}" data-sub-html="&lt;h6 class=&quot;font-size-sm text-light&quot;&gt;{{ $infosPage['title'] }}&lt;/h6&gt;">
                                        <img src="{{ url($item->getUrl()) }}" alt="{{ $infosPage['title'] }}">
                                        <span class="gallery-item-caption">{{ $infosPage['title'] }}</span>
                                    </a>
                                @endif
                                @php($i++)
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Product details-->
                <div class="col-lg-5 pt-4 pt-lg-0">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="czi-delivery"></i>
                            Expédition
                        </div>
                        <div class="card-body">
                            <div>
                                <i class="czi-check-circle"></i>
                                Frais d’expédition
                            </div>
                            @if ($produit->categorie_id == 5)
                                <ul>
                                    <li>5000f/article</li>
                                </ul>
                            @else
                                <ul>
                                    <li>1 à 100 articles: 2000f/ article</li>
                                    <li>101 à 200 articles: 1500f/ article</li>
                                    <li>201 à 500 articles: 1000f/article</li>
                                    <li>501 à 1000 articles : 700f/article</li>
                                    <li>+ 1000 articles: 500f/article</li>
                                </ul>
                            @endif
                            <div>
                                <i class="czi-check-circle"></i>
                                Délais de livraison (4-7j)
                            </div>
                        </div>
                    </div>
                    <div class="accordion mb-4" id="productPanels">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="accordion-heading">
                                    <a href="#productInfo" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="productInfo">
                                        <i class="czi-announcement text-muted font-size-lg align-middle mt-n1 mr-2"></i>
                                        Description<span class="accordion-indicator"></span>
                                    </a>
                                </h3>
                            </div>
                            <div class="collapse show" id="productInfo" data-parent="#productPanels">
                                <div class="card-body">
                                   {!! $produit->description !!}
                                </div>
                            </div>
                        </div>
                        {{--  <div class="card">
                            <div class="card-header">
                                <h3 class="accordion-heading">
                                    <a class="collapsed" href="#shippingOptions" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="shippingOptions">
                                        <i class="czi-delivery text-muted lead align-middle mt-n1 mr-2"></i>
                                        Shipping options<span class="accordion-indicator"></span>
                                    </a>
                                </h3>
                            </div>
                            <div class="collapse" id="shippingOptions" data-parent="#productPanels">
                                <div class="card-body font-size-sm">
                                    <div class="d-flex justify-content-between border-bottom pb-2">
                                        <div>
                                            <div class="font-weight-semibold text-dark">Courier</div>
                                            <div class="font-size-sm text-muted">2 - 4 days</div>
                                        </div>
                                        <div>$26.50</div>
                                    </div>
                                    <div class="d-flex justify-content-between border-bottom py-2">
                                        <div>
                                            <div class="font-weight-semibold text-dark">Local shipping</div>
                                            <div class="font-size-sm text-muted">up to one week</div>
                                        </div>
                                        <div>$10.00</div>
                                    </div>
                                    <div class="d-flex justify-content-between border-bottom py-2">
                                        <div>
                                            <div class="font-weight-semibold text-dark">Flat rate</div>
                                            <div class="font-size-sm text-muted">5 - 7 days</div>
                                        </div>
                                        <div>$33.85</div>
                                    </div>
                                    <div class="d-flex justify-content-between border-bottom py-2">
                                        <div>
                                            <div class="font-weight-semibold text-dark">UPS ground shipping</div>
                                            <div class="font-size-sm text-muted">4 - 6 days</div>
                                        </div>
                                        <div>$18.00</div>
                                    </div>
                                    <div class="d-flex justify-content-between pt-2">
                                        <div>
                                            <div class="font-weight-semibold text-dark">Local pickup from store</div>
                                            <div class="font-size-sm text-muted">&mdash;</div>
                                        </div>
                                        <div>$0.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="accordion-heading">
                                    <a class="collapsed" href="#localStore" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="localStore">
                                        <i class="czi-location text-muted font-size-lg align-middle mt-n1 mr-2"></i>
                                        Find in local store<span class="accordion-indicator"></span>
                                    </a>
                                </h3>
                            </div>
                            <div class="collapse" id="localStore" data-parent="#productPanels">
                                <div class="card-body">
                                    <select class="custom-select">
                                        <option value>Select your country</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Belgium">Belgium</option>
                                        <option value="France">France</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Spain">Spain</option>
                                        <option value="UK">United Kingdom</option>
                                        <option value="USA">USA</option>
                                    </select>
                                </div>
                            </div>
                        </div>  --}}
                    </div>
                    <div class="product-details pb-3 w-100">
                        @if ($produit->stock == 'En stock')
                            <div class="card">
                                <div class="card-header">
                                    <i class="czi-bag" aria-hidden="true"></i>
                                    Ajout au Panier
                                </div>
                                <div class="card-body">
                                    <form class="mb-grid-gutter" method="get" action="{{ route('panier.add', $produit) }}">
                                        @csrf
                                        <div class="form-group text-center">
                                            @foreach ($produit->tarifs as $item)
                                                <div class="custom-control custom-option custom-control-inline mb-2">
                                                    <input required value="{{ $item->id }}"type="radio" class="custom-control-input" id="tarif-{{ $item->id }}" name="tarif">
                                                    <label for="tarif-{{ $item->id }}" class="custom-option-label">
                                                        {{ devise($item->montant) }}
                                                        <div style="margin-top: -15px;" class="text-info">
                                                            {{ $item->quantite }} pièces
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if (count($produit->couleurs))
                                            <div class="form-group">
                                                @foreach ($produit->couleurs as $item)
                                                    <div class="custom-control custom-option custom-control-inline mb-2">
                                                        <input value="{{ $item->description }}"type="checkbox" class="custom-control-input" id="couleur-{{ $item->id }}" name="couleur[]">
                                                        <label for="couleur-{{ $item->id }}" class="custom-option-label rounded-circle">
                                                            <span class="custom-option-color rounded-circle" style="background-color: {{ $item->description }}"></span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if ($produit->tailles)
                                            <div class="form-group">
                                                @foreach ($produit->tailles as $item)
                                                    <div class="custom-control custom-option custom-control-inline mb-2">
                                                        <input value="{{ $item->titre }}"type="checkbox" class="custom-control-input" id="taille-{{ $item->id }}" name="taille[]">
                                                        <label for="taille-{{ $item->id }}" class="custom-option-label">{{ $item->titre }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <div class="text-center">
                                                <div class="">
                                                    <button onclick="this.parentNode.querySelector('input[type=number]').stepDown(); return false;" class="btn btn-outline-dark w-25">
                                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                                    </button>
                                                    <input class="form-control w-25 d-inline-block text-center" min="0" name="quantity" value="1" type="number">
                                                    <button onclick="this.parentNode.querySelector('input[type=number]').stepUp(); return false;" class="btn btn-outline-dark w-25">
                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <button class="btn btn-info btn-shadow btn-block">
                                                <i class="czi-cart font-size-lg mr-2"></i>
                                                Ajouter au panier
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
