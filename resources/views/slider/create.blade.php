@extends('layouts.app')

@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    @include('categorie.header')
                    <div class="page-body">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card p-3">
                                    <div class="card-header">
                                        <div class="card-header-right">
                                            <ul class="list-unstyled card-option">
                                                <li><i class="icofont icofont-simple-left "></i></li>
                                                <li><i class="icofont icofont-maximize full-card"></i></li>
                                                <li><i class="icofont icofont-minus minimize-card"></i></li>
                                                <li><i class="icofont icofont-refresh reload-card"></i></li>
                                                <li><i class="icofont icofont-error close-card"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-block table-border-style">
                                        @if (request('slider'))
                                            <form action="{{ url('slider/'.$valeur->id) }}" method="post" enctype="multipart/form-data">
                                            @method('PUT')
                                        @else
                                            <form action="{{ url('slider') }}" method="post" enctype="multipart/form-data">
                                        @endif
                                            @csrf
                                            <div class="form-group">
                                                <input required type="text" class="form-control" name="titre" placeholder="Titre *" value="{{ (request('slider')) ? $valeur->titre : old('titre') }}">
                                                @error('titre')
                                                    <div class="text-danger text-center">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control" name="type">
                                                    <option value="">-------------</option>
                                                    @if (request('slider'))
                                                        <option value="splashscreen" {{ ( "splashscreen" == $valeur->type) ? 'selected' : '' }}>
                                                            Splashscreen App
                                                        </option>
                                                        <option value="accueil" {{ ( "accueil" == $valeur->type) ? 'selected' : '' }}>
                                                            Accueil App
                                                        </option>
                                                    @else
                                                        <option value="splashscreen" {{ ("splashscreen" == old('type')) ? 'selected' : '' }}>
                                                            Splashscreen App
                                                        </option>
                                                        <option value="accueil" {{ ("splashscreen" == old('type')) ? 'selected' : '' }}>
                                                            Accueil App
                                                        </option>
                                                    @endif
                                                </select>
                                                @error('type')
                                                    <div class="text-danger text-center">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="sous_titre" placeholder="Sous titre" value="{{ (request('slider')) ? $valeur->sous_titre : old('sous_titre') }}">
                                                @error('sous_titre')
                                                    <div class="text-danger text-center">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <textarea name="description" rows="5" class="form-control" placeholder="Description">{{ (request('slider')) ? $valeur->sous_titre : old('description') }}</textarea>
                                                @error('description')
                                                    <div class="text-danger text-center">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input id="image" name="image" value="{{ old('image') }}" type="file" class="md-form-control">
                                                @error('image')
                                                    <div class="text-danger text-center">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror

                                                @if (request('slider'))
                                                    @if(!empty($valeur->getMedia('image')->first()))
                                                        <div style="position: absolute; right:10px; margin-top:-40px;">
                                                            <img height="80" src="{{ url($valeur->getMedia('image')->first()->getUrl('thumb')) }}">
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-out btn-primary btn-square btn-block" name="valider">
                                                    Valider
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-body end -->
                </div>
            </div>
            <!-- Main-body end -->
            <div id="styleSelector"></div>
        </div>
    </div>
@endsection
