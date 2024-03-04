<!-- Sidebar-->
<aside class="col-lg-4 pt-4 pt-lg-0">
    <div class="cz-sidebar-static rounded-lg box-shadow-lg px-0 pb-0 mb-5 mb-lg-0">
        <div class="px-4 mb-4">
            <div class="media align-items-center">
                <div class="img-thumbnail rounded-circle position-relative" style="width: 6.375rem;">
                    {{--  <span class="badge badge-warning" data-toggle="tooltip" title="Reward points">
                        384
                    </span>  --}}
                    <a href="{{ url('/profil/picture') }}">
                        @if(!empty(auth()->user()->getMedia('image')->first()))
                            <img class="rounded-circle" width="80" src="{{ url(auth()->user()->getMedia('image')->first()->getUrl('thumb')) }}">
                        @else
                            <img class="rounded-circle" width="80" src="{{ asset('image/user.png') }}">
                        @endif
                    </a>
                </div>
                <div class="media-body pl-3">
                    <h3 class="font-size-base mb-0">
                        {!! auth()->user()->prenom.' '.auth()->user()->nom !!}
                    </h3>
                    <span class="text-accent font-size-sm">
                        {!! auth()->user()->email !!}
                    </span>
                </div>
            </div>
        </div>
        <ul class="list-unstyled mb-0">
            <li class="border-bottom mb-0">
                <a class="nav-link-style d-flex align-items-center px-4 py-3 @if(url()->current() == url('profil/edit')) active @endif" href="{{ url('profil/edit') }}">
                    <i class="czi-user opacity-60 mr-2 text-info"></i>Mon compte
                </a>
            </li>
            <li class="border-bottom mb-0">
                <a class="nav-link-style d-flex align-items-center px-4 py-3 @if(url()->current() == url('profil/commande')) active @endif" href="{{ url('profil/commande') }}">
                    <i class="czi-bag opacity-60 mr-2 text-info"></i>Mes commandes
                    <span class="font-size-sm text-muted ml-auto">
                        @isset ($user->commandes)
                            {{ count($user->commandes) }}
                        @endisset
                    </span>
                </a>
            </li>
            <li class="border-bottom mb-0">
                <a class="nav-link-style d-flex align-items-center px-4 py-3 @if(url()->current() == url('wishlist')) active @endif" href="{{ url('wishlist') }}">
                    <i class="czi-heart opacity-60 mr-2 text-info"></i>Ma liste d'envies
                    <span class="font-size-sm text-muted ml-auto">
                        {{ Cart::instance('wishlist')->count() }}
                    </span>
                </a>
            </li>
            @if (auth()->user()->type == 'fournisseur')
                <li class="border-bottom mb-0">
                    <a class="nav-link-style d-flex align-items-center px-4 py-3 @if(url()->current() == route('product.index')) active @endif" href="{{ route('product.index') }}">
                        <i class="czi-store opacity-60 mr-2 text-info"></i>Mes produits
                        <span class="font-size-sm text-muted ml-auto">
                            {{ count($user->produits) }}
                        </span>
                    </a>
                </li>
            @endif
            <li class="d-lg-none border-top mb-0">
                <a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="czi-sign-out opacity-60 mr-2 text-info"></i>Déconnexion
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</aside>
