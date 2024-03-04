@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'category',
])
@section('content')
    <style>
        .page-title-overlap {
            padding-bottom: 2rem;
        }
    </style>
    @include('web.user.entete')

    <div class="container mt-0">
        <div class="row">
            <div class="col-4 pl-0">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    @php($i = 0)
                    @foreach ($categories as $categorie)
                        @php($i++)
                        <a class="nav-link font-size-xs {{ ($i == 1) ? 'active' : '' }}" id="v-pills-{{ $categorie->id }}-tab" data-toggle="pill" href="#v-pills-{{ $categorie->id }}" role="tab" aria-controls="v-pills-{{ $categorie->id }}" aria-selected="true">
                            {{ $categorie->titre }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-8">
                <div class="tab-content" id="v-pills-tabContent">
                    @php($i = 0)
                    @foreach ($categories as $categorie)
                        @php($i++)
                        <div class="tab-pane {{ ($i == 1) ? 'show active' : '' }} fade" id="v-pills-{{ $categorie->id }}" role="tabpanel" aria-labelledby="v-pills-{{ $categorie->id }}-tab">
                            <div>{{ $categorie->titre }}</div>
                            
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
