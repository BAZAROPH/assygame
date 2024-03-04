<!-- Product-->
<div class="{{ $class }}">
    <div class="card product-card card-static pb-3">
        <span class="badge badge-success badge-shadow">{{ $produit->stock }}</span>
        {{-- <button class="btn-wishlist btn-sm" type="button" data-toggle="tooltip" data-placement="left" title="Add to wishlist">
            <i class="czi-heart"></i>
        </button> --}}
        <a class="card-img-top d-block overflow-hidden" href="{{ route('product.show', $produit) }}">
            @if(!empty($produit->getMedia('image')->first()))
                <img class="img-fluid" src="{{ url($produit->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $produit->titre }}">
            @endif
        </a>
        <div class="card-body py-2">
            <a class="product-meta d-block font-size-xs pb-1" href="#">
                {{ $produit->categorie->titre }}
            </a>
            <h3 class="product-title font-size-sm" style="height: 60px;">
                <a href="{{ route('product.show', $produit) }}">
                    {{ $produit->titre }}
                </a>
            </h3>
            <div class="product-price">
                <span class="text-danger">
                    {{ devise($produit->tarifs[0]->montant) }}
                </span>
            </div>
        </div>
        {{-- <div class="product-floating-btn">
            <button class="btn btn-primary btn-shadow btn-sm" type="button" data-toggle="toast" data-target="#cart-toast">
                +<i class="czi-cart font-size-base ml-1"></i>
            </button>
        </div> --}}
    </div>
</div>
