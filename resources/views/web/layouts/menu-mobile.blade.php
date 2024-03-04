<!-- Toolbar for handheld devices-->
<div class="cz-handheld-toolbar">
    <div class="d-table table-fixed w-100">
        <a class="d-table-cell cz-handheld-toolbar-item {{ (route('accueil') == url()->current()) ? 'active' : '' }}" href="{{ url('/') }}">
            <span class="cz-handheld-toolbar-icon">
                <i class="icofont-ui-home"></i>
            </span>
            <span class="cz-handheld-toolbar-label">Accueil</span>
        </a>
        <a class="d-table-cell cz-handheld-toolbar-item {{ (route('home') == url()->current()) ? 'active' : '' }}" href="#sideNav" data-toggle="collapse" onclick="window.scrollTo(0, 0)">
            <span class="cz-handheld-toolbar-icon">
                <i class="icofont-list"></i>
            </span>
            <span class="cz-handheld-toolbar-label">Catégories</span>
        </a>
        @guest
            <a class="d-table-cell cz-handheld-toolbar-item {{ (route('wishlist') == url()->current()) ? 'active' : '' }}" href="{{ route('wishlist') }}">
                <span class="cz-handheld-toolbar-icon">
                    <i class="icofont-heart"></i>
                </span>
                <span class="cz-handheld-toolbar-label">
                    Favoris
                </span>
            </a>
        @else
            @if (auth()->user()->type == 'fournisseur')
                <a class="d-table-cell cz-handheld-toolbar-item {{ (route('home') == url()->current()) ? 'active' : '' }}" href="{{ route('product.index') }}">
                    <span class="cz-handheld-toolbar-icon">
                        <i class="czi-bag"></i>
                    </span>
                    <span class="cz-handheld-toolbar-label">
                        Mes produits
                    </span>
                </a>
            @else
                <a class="d-table-cell cz-handheld-toolbar-item {{ (route('wishlist') == url()->current()) ? 'active' : '' }}" href="{{ route('wishlist') }}">
                    <span class="cz-handheld-toolbar-icon">
                        <i class="icofont-heart"></i>
                    </span>
                    <span class="cz-handheld-toolbar-label">
                        Favoris
                    </span>
                </a>
            @endif

        @endguest
        @guest
            <a class="d-table-cell cz-handheld-toolbar-item {{ (route('login') == url()->current() or route('register') == url()->current() or route('password.email') == url()->current() or route('password.request') == url()->current()) ? 'active' : '' }}" href="{{ url('login') }}">
                <span class="cz-handheld-toolbar-icon"><i class="czi-user-circle"></i></span>
                <span class="cz-handheld-toolbar-label">Compte</span>
            </a>
        @else
            <a class="d-table-cell cz-handheld-toolbar-item {{ (route('profil') == url()->current() or route('profil.finish') == url()->current()) ? 'active' : '' }}" href="{{ url('profil') }}">
                <span class="cz-handheld-toolbar-icon"><i class="czi-user-circle"></i></span>
                <span class="cz-handheld-toolbar-label">
                    {{ auth()->user()->nom }}
                </span>
            </a>
        @endguest
    </div>
</div>
