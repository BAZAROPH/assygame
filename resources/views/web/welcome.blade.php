@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'accueil',
])
@section('content')

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
                            Sports Hooded Sweatshirt
                        </a>
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Product gallery-->
                        <div class="col-lg-7 pr-lg-0">
                            <div class="cz-product-gallery">
                                <div class="cz-preview order-sm-2">
                                    <div class="cz-preview-item active" id="first">
                                        <img class="cz-image-zoom" src="web/img/shop/single/gallery/01.jpg" data-zoom="web/img/shop/single/gallery/01.jpg" alt="Product image">
                                        <div class="cz-image-zoom-pane"></div>
                                    </div>
                                    <div class="cz-preview-item" id="second">
                                        <img class="cz-image-zoom" src="web/img/shop/single/gallery/02.jpg" data-zoom="web/img/shop/single/gallery/02.jpg" alt="Product image">
                                        <div class="cz-image-zoom-pane"></div>
                                    </div>
                                    <div class="cz-preview-item" id="third">
                                        <img class="cz-image-zoom" src="web/img/shop/single/gallery/03.jpg" data-zoom="web/img/shop/single/gallery/03.jpg" alt="Product image">
                                        <div class="cz-image-zoom-pane"></div>
                                    </div>
                                    <div class="cz-preview-item" id="fourth">
                                        <img class="cz-image-zoom" src="web/img/shop/single/gallery/04.jpg" data-zoom="web/img/shop/single/gallery/04.jpg" alt="Product image">
                                        <div class="cz-image-zoom-pane"></div>
                                    </div>
                                </div>
                                <div class="cz-thumblist order-sm-1">
                                    <a class="cz-thumblist-item active" href="#first">
                                        <img src="web/img/shop/single/gallery/th01.jpg" alt="Product thumb">
                                    </a>
                                    <a class="cz-thumblist-item" href="#second">
                                        <img src="web/img/shop/single/gallery/th02.jpg" alt="Product thumb">
                                    </a>
                                    <a class="cz-thumblist-item" href="#third">
                                        <img src="web/img/shop/single/gallery/th03.jpg" alt="Product thumb">
                                    </a>
                                    <a class="cz-thumblist-item" href="#fourth">
                                        <img src="web/img/shop/single/gallery/th04.jpg" alt="Product thumb">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Product details-->
                        <div class="col-lg-5 pt-4 pt-lg-0 cz-image-zoom-pane">
                            <div class="product-details ml-auto pb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    {{-- <a href="shop-single-v1.html#reviews">
                                        <div class="star-rating">
                                            <i class="sr-star czi-star-filled active"></i>
                                            <i class="sr-star czi-star-filled active"></i>
                                            <i class="sr-star czi-star-filled active"></i>
                                            <i class="sr-star czi-star-filled active"></i>
                                            <i class="sr-star czi-star"></i>
                                        </div>
                                        <span class="d-inline-block font-size-sm text-body align-middle mt-1 ml-1">
                                            74 Reviews
                                        </span>
                                    </a> --}}
                                    <button class="btn-wishlist" type="button" data-toggle="tooltip" title="Add to wishlist">
                                        <i class="czi-heart"></i>
                                    </button>
                                </div>
                                <div class="mb-3">
                                    <span class="h3 font-weight-normal text-accent mr-1">$18.<small>99</small></span>
                                    <del class="text-muted font-size-lg mr-3">$25.<small>00</small></del>
                                    <span class="badge badge-danger badge-shadow align-middle mt-n2">Sale</span>
                                </div>
                                <div class="font-size-sm mb-4">
                                    <span class="text-heading font-weight-medium mr-1">Color:</span>
                                    <span class="text-muted">Red/Dark blue/White</span>
                                </div>
                                <div class="position-relative mr-n4 mb-3">
                                    <div class="custom-control custom-option custom-control-inline mb-2">
                                        <input class="custom-control-input" type="radio" name="color" id="color1" checked>
                                        <label class="custom-option-label rounded-circle" for="color1"><span class="custom-option-color rounded-circle" style="background-image: url(web/img/shop/single/color-opt-1.png)"></span></label>
                                    </div>
                                    <div class="custom-control custom-option custom-control-inline mb-2">
                                        <input class="custom-control-input" type="radio" name="color" id="color2">
                                        <label class="custom-option-label rounded-circle" for="color2"><span class="custom-option-color rounded-circle" style="background-image: url(web/img/shop/single/color-opt-2.png)"></span></label>
                                    </div>
                                    <div class="custom-control custom-option custom-control-inline mb-2">
                                        <input class="custom-control-input" type="radio" name="color" id="color3">
                                        <label class="custom-option-label rounded-circle" for="color3"><span class="custom-option-color rounded-circle" style="background-image: url(web/img/shop/single/color-opt-3.png)"></span></label>
                                    </div>
                                    <div class="product-badge product-available mt-n1">
                                        <i class="czi-security-check"></i>Product available
                                    </div>
                                </div>
                                <form class="mb-grid-gutter">
                                    <div class="form-group">
                                        <label class="font-weight-medium pb-1" for="product-size">Size:</label>
                                        <select class="custom-select" required id="product-size">
                                        <option value="">Select size</option>
                                        <option value="xs">XS</option>
                                        <option value="s">S</option>
                                        <option value="m">M</option>
                                        <option value="l">L</option>
                                        <option value="xl">XL</option>
                                        </select>
                                    </div>
                                    <div class="form-group d-flex align-items-center">
                                        <select class="custom-select mr-3" style="width: 5rem;">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        </select>
                                        <button class="btn btn-primary btn-shadow btn-block" type="submit"><i class="czi-cart font-size-lg mr-2"></i>Add to Cart</button>
                                    </div>
                                </form>
                                <h5 class="h6 mb-3 pb-2 border-bottom">
                                    <i class="czi-announcement text-muted font-size-lg align-middle mt-n1 mr-2"></i>
                                    Product info
                                </h5>
                                <h6 class="font-size-sm mb-2">Style</h6>
                                <ul class="font-size-sm pl-4">
                                    <li>Hooded top</li>
                                </ul>
                                <h6 class="font-size-sm mb-2">Composition</h6>
                                <ul class="font-size-sm pl-4">
                                    <li>Elastic rib: Cotton 95%, Elastane 5%</li>
                                    <li>Lining: Cotton 100%</li>
                                    <li>Cotton 80%, Polyester 20%</li>
                                </ul>
                                <h6 class="font-size-sm mb-2">Art. No.</h6>
                                <ul class="font-size-sm pl-4 mb-0">
                                    <li>183260098</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('web.carousel')
    {{-- Catégorie --}}
    <div class="cz-carousel cz-controls-static cz-controls-outside mt-2 text-center">
        <div style="font-size: 11px;" class="cz-carousel-inner" data-carousel-options='{
            "items": 3,
            "controls": true,
            "nav": false,
            "autoplay": true,
            "autoplayTimeout": 10000,
            "responsive": {
                "0":{"items":4},
                "500":{
                    "items":2,
                    "gutter": 18
                },
                "768":{
                    "items":3,
                    "gutter": 20
                },
                "1100":{
                    "gutter": 24
                }
            }
        }'>
            @foreach ($categories as $item)
                <div>
                    <a href="{{ route('category.show', $item) }}">
                        @if(!empty($item->getMedia('image')->first()))
                            <img class="img-thumbnail" src="{{ url($item->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $item->titre }}" title="{{ $item->titre }}">
                        @endif
                        <div>{{ $item->titre }}</div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    @if (count($hebdo))
        <section class="pt-4">
            <!-- Heading-->
            <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-2 mb-4 pl-2 pr-2">
                <div class="mb-0 pt-3 mr-3">Offres hebdomadaire</div>
                <div class="pt-3">
                    <a class="btn btn-outline-accent btn-sm" href="#">
                        Voir plus
                        <i class="czi-arrow-right ml-1 mr-n1"></i>
                    </a>
                </div>
            </div>
            <div class="cz-carousel cz-controls-static cz-controls-outside cz-dots-enabled pt-2">
                <div class="cz-carousel-inner" data-carousel-options='{
                "items": 2,
                "gutter": 16,
                "controls": true,
                "autoHeight": true,
                "autoplayTimeout": 15000,
                "responsive": {
                    "0":{"items":2},
                    "480":{"items":2},
                    "720":{"items":3},
                    "991":{"items":2},
                    "1140":{"items":3},
                    "1300":{"items":4},
                    "1500":{"items":5}
                    }
                }'>
                    @foreach ($hebdo as $produit)
                        @include('web.produit.item', [
                            'class' => null
                        ])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Offres hebdomadaires -->
    <section class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-3 mb-4">
            <div class="mb-0 pt-3 mr-2">Nouveautés</div>
            <div class="pt-3">
                <a class="btn btn-outline-info btn-sm" href="#">
                    Voir plus<i class="czi-arrow-right ml-1 mr-n1"></i>
                </a>
            </div>
        </div>
        <div class="row mx-n2">
            @foreach ($produits as $produit)
                @include('web.produit.item', [
                    'class' => 'col-md-4 col-6 col-sm-6 px-2 mb-4'
                ])
            @endforeach
        </div>
        <div class="row">
            <div class="col-12">
                <a class="btn btn-info btn-block" href="{{ route('product.all') }}">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Voir plus
                </a>
            </div>
        </div>
    </section>
@endsection
