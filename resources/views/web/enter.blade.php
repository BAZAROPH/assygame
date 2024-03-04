@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'accueil',
])
@section('content')
    <section class="pt-4">
        <!-- Heading-->
        <div class="text-right mr-2">
            <a href="{{ route('accueil') }}?accueil=1">Passer</a>
        </div>
        <div class="text-center mb-3">
            <img src="{{ asset('image/logo.png') }}" alt="Assygamé" class="img-fluid" width="200">
        </div>
        <div class="cz-carousel cz-controls-static cz-controls-outside cz-dots-enabled pt-2">
            <div class="cz-carousel-inner" data-carousel-options='{
              "items": 2,
              "gutter": 16,
              "controls": true,
              "autoHeight": true,
              "autoplayTimeout": 15000,
              "responsive": {
                  "0":{"items":1},
                  "480":{"items":2},
                  "720":{"items":3},
                  "991":{"items":2},
                  "1140":{"items":3},
                  "1300":{"items":4},
                  "1500":{"items":5}
                }
            }'>
                @foreach ($sliders as $item)
                    <div>
                        @if(!empty($item->getMedia('image')->first()))
                            <img class="img-fluid" src="{{ url($item->getMedia('image')->first()->getUrl()) }}" alt="Assygamé">
                        @endif
                        <div class="product-title text-danger mt-2" style="height: 70px;">
                            {{ $item->titre }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('accueil') }}?accueil=1" class="btn btn-info btn-block">
                        Continuer
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
