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
                                        @if (request('produit'))
                                            <form action="{{ url('produit/'.$valeur->id) }}" method="post" enctype="multipart/form-data">
                                            @method('PUT')
                                        @else
                                            <form action="{{ url('produit') }}" method="post" enctype="multipart/form-data">
                                        @endif
                                            @csrf
                                            <div class="form-group">
                                                <input required type="text" class="form-control" name="titre" placeholder="Titre *" value="{{ (request('produit')) ? $valeur->titre : old('titre') }}">
                                                @error('titre')
                                                    <div class="text-danger text-center">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control" name="categorie_id">
                                                    <option value="">-------------</option>
                                                    @foreach ($valeurs as $categorie)
                                                        @if (request('produit'))
                                                            <option value="{{ $categorie->id }}" {{ ( $categorie->id == $valeur->categorie_id) ? 'selected' : '' }}>
                                                                {{ $categorie->titre }}
                                                            </option>
                                                            @if(count($categorie->categories))
                                                                @include('categorie.children', [
                                                                    'childrens' => $categorie->categories,
                                                                    'nombreIteration' => 1,
                                                                    'page' => 'edit',
                                                                    'category' => $valeur,
                                                                ])
                                                            @endif
                                                        @else
                                                            <option value="{{ $categorie->id }}" {{ ($categorie->id == old('categorie_id')) ? 'selected' : '' }}>
                                                                {{ $categorie->titre }}
                                                            </option>
                                                            @if(count($categorie->categories))
                                                                @include('categorie.children', [
                                                                    'childrens' => $categorie->categories,
                                                                    'nombreIteration' => 1,
                                                                    'page' => 'add',
                                                                ])
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('titre')
                                                    <div class="text-danger text-center">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            {{-- <div class="form-group">
                                                <input type="text" class="form-control" name="sous_titre" placeholder="Sous titre" value="{{ (request('produit')) ? $valeur->sous_titre : old('sous_titre') }}">
                                                @error('sous_titre')
                                                    <div class="text-danger text-center">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div> --}}
                                            <div class="form-group">
                                                <textarea name="description" rows="5" class="form-control" placeholder="Description">{{ (request('produit')) ? $valeur->description : old('description') }}</textarea>
                                                @error('description')
                                                    <div class="text-danger text-center">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <h4>Images</h4>
                                                <input id="image" name="image" value="{{ old('image') }}" type="file" class="md-form-control">
                                                @error('image')
                                                    <div class="text-danger text-center">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                                @if (request('produit'))
                                                    <div class="row">
                                                        @foreach ($valeur->getMedia('image') as $item)
                                                            <div class="col-2">
                                                                {{-- <div style="position: absolute;">
                                                                    <a href="{{ url()->current().'?del='.$item->id }}">
                                                                        <i class="fa fa-trash text-danger" aria-hidden="true" style="font-size: 20px;"></i>
                                                                    </a>
                                                                </div> --}}
                                                                <img height="100" src="{{ url($item->getUrl('thumb')) }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-out btn-primary btn-square btn-block" name="valider">
                                                    Valider
                                                </button>
                                                <a href="{{ route('produit.index') }}" class="btn btn-default">Retour</a>
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
