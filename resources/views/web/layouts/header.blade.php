@if (Cookie::get('homASS'))
    <header class="box-shadow-sm fixed-top">
        <div class="bg-light">
            <div class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                    <!-- Toolbar-->
                    <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center w-100">
                        {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sideNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <a class="navbar-tool navbar-stuck-toggler" href="#">
                            <span class="navbar-tool-tooltip">Menu</span>
                            <div class="navbar-tool-icon-box">
                                <i class="navbar-tool-icon czi-menu"></i>
                            </div>
                        </a> --}}
                        @if (url('/') == url()->current())
                            <!-- Search-->
                            <form action="{{ route('search') }}" method="get" class="w-100">
                                @csrf
                                <div class="input-group-overlay d-lg-none">
                                    <div class="input-group-prepend-overlay">
                                        <span class="input-group-text"><i class="czi-search"></i></span>
                                    </div>
                                    <input value="{{ old('term_search') }}" name="term_search" class="form-control prepended-form-control" type="text" placeholder="Recherchez...">
                                </div>
                            </form>
                        @else
                            <div class="">
                                <a href="{{ url()->previous() }}" class="mr-2">
                                    <i class="icofont-arrow-left text-dark" style="font-size: 20px;"></i>
                                </a>
                            </div>
                            <div class="input-group-overlay">
                                @if (Route::currentRouteName() == 'product.show')
                                    Détails produit
                                @else
                                    {{ $infosPage['title'] }}
                                @endif
                            </div>
                        @endif

                        @if (url()->current() == route('product.index'))
                            <div class="navbar-tool dropdown ml-3 mt-1">
                                <a class="navbar-tool-icon-box bg-secondary dropdown-toggle" href="{{ route('product.create') }}">
                                    <i class="navbar-tool-icon czi-add-circle text-danger"></i>
                                </a>
                            </div>
                        @else
                            <div class="navbar-tool dropdown ml-3 mt-1">
                                <a class="navbar-tool-icon-box bg-secondary dropdown-toggle" href="{{ url('panier') }}">
                                    <span class="navbar-tool-label">{{ count(Cart::instance('shopping')->content()) }}</span>
                                    <i class="navbar-tool-icon czi-cart"></i>
                                </a>
                                <a class="navbar-tool-text" href="{{ url('panier') }}">
                                    <small>Panier</small>
                                    {{ devise(Cart::instance('shopping')->subtotal()) }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="mt-5"></div>
@endif
@include('flash::message')
{{-- @include('web.layouts.aside') --}}
