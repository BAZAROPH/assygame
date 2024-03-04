@extends('web.layouts.app', [
    'title' => 'Modification profil',
    'page' => 'profil',
])
@section('content')

@include('web.user.entete')

<div class="container pb-5 mb-2 mb-md-3">
    <div class="row">
        <section class="col-lg-8">
			<!-- Toolbar-->
			<div class="d-flex justify-content-between align-items-center pt-lg-2 pb-4 pb-lg-5 mb-lg-3">
				<div class="{{-- form-inline--}} mb-4">
					<label class="text-light opacity-75 text-nowrap mr-2 d-none d-lg-block" for="order-sort"></label>
					{{-- <select class="form-control custom-select" id="order-sort">
						<option>Tout</option>
						<option>Livrer</option>
						<option>En attente</option>
						<option>Annuler</option>
					</select> --}}
                </div>
			</div>
            <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data" class="form-box">
                @csrf
                <div class="form-group">
                    <input placeholder="{{ __('Nom *') }}" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ auth()->user()->nom }}" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input placeholder="{{ __('Prénoms *') }}" id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ auth()->user()->prenom }}" required autocomplete="prenom">
                    @error('prenom')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input placeholder="{{ __('Date de naissance') }}" id="date_naissance" type="date" class="form-control @error('date_naissance') is-invalid @enderror" name="date_naissance" value="@if(auth()->user()->date_naissance) {{ date('Y-m-d', strtotime(auth()->user()->date_naissance)) }} @endif" autocomplete="date_naissance">
                    @error('date_naissance')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- <div class="form-group">
                    <input placeholder="{{ __('Lieu d\'adhésion *') }}" id="adresse" type="text" class="form-control @error('adresse') is-invalid @enderror" name="adresse" value="{{ auth()->user()->adresse }}" required autocomplete="adresse" autofocus>
                    @error('adresse')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> --}}

                <div class="form-group">
                    <select name="sexe" class="form-control form-control-md" id="sexe">
                        <option value="">-- Votre sexe --</option>
                        <option value="Masculin" {{ (auth()->user()->sexe == 'Masculin') ? 'selected' : '' }}>Masculin</option>
                        <option value="Feminin" {{ (auth()->user()->sexe == 'Feminin') ? 'selected' : '' }}>Feminin</option>
                    </select>
                    @error('sexe')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input placeholder="{{ __('Email') }}" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ auth()->user()->email }}" autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input placeholder="{{ __('Téléphone *') }}" id="contact" type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ auth()->user()->contact }}" required autocomplete="contact" autofocus>
                    @error('contact')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input id="boutique" type="text" class="form-control form-control-lg @error('boutique') is-invalid @enderror" name="boutique" value="{{ auth()->user()->boutique }}" required autocomplete="boutique" autofocus>
                </div>
                @error('boutique')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <div class="form-group">
                    <textarea rows="5" placeholder="{{ __('Commentaire') }}" id="biographie" type="text" class="form-control @error('biographie') is-invalid @enderror" name="biographie">{{ auth()->user()->biographie }}</textarea>
                    @error('biographie')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-info btn-block text-uppercase btn-lg">
                        {{ __('Valider') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/19.1.1/classic/ckeditor.js"></script>
@endsection
