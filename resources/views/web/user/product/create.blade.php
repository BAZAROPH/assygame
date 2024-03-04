@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'profil',
])
@section('content')

@include('web.user.entete')
<!-- Page Content-->
<div class="container pb-5 mb-2 mb-md-3">
	<div class="row">
        <div class="col-12 px-2 mb-4">
            <!-- Steps-->
            <div class="steps steps-light pt-2 mb-5">
                <a class="step-item active current" href="#">
                    <div class="step-progress">
                        <span class="step-count">1</span>
                    </div>
                    <div class="step-label">
                        <i class="icofont-google-map"></i>Infos produit
                    </div>
                </a>

                <span class="step-item" href="#">
                    <div class="step-progress">
                        <span class="step-count">2</span>
                    </div>
                    <div class="step-label">
                        <i class="icofont-ui-calendar"></i>Tarif
                    </div>
                </span>

                {{-- <span class="step-item">
                    <div class="step-progress">
                        <span class="step-count">3</span>
                    </div>
                    <div class="step-label">
                        <i class="czi-card"></i>Options
                    </div>
                </span> --}}
            </div>
            <form method="POST" action="{{ route('product.store') }}">
                @csrf
                <div class="form-group row">
                    <label for="categorie" class="col-md-4 col-form-label text-md-right">
                        Catégorie <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6">
                        <div class="input-group-overlay d-lg-none">
                            <div class="input-group-prepend-overlay">
                                <span class="input-group-text">
                                    <i class="czi-view-grid"></i>
                                </span>
                            </div>
                            <select name="categorie" class="custom-select" id="categorie" required>
                                <option value="">-------Catégories-------</option>
                                @foreach ($categories as $item)
                                    <option {{ (old('categorie') == $item->id) ? 'selected' : '' }} value="{{ $item->id }}">
                                        {{ $item->titre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categorie')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row" id="laSous_categorie" style="display: none;">
                    <label style="width: 180px;" for="sous_categorie" class="col-md-4 col-form-label text-md-right">
                        Sous catégories <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6">
                        <div class="input-group-overlay d-lg-none">
                            <div class="input-group-prepend-overlay">
                                <span class="input-group-text">
                                    <i class="czi-view-list"></i>
                                </span>
                            </div>
                            <select name="sous_categorie" class="custom-select" id="sous_categorie" required></select>
                            @error('sous_categorie')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="titre" class="col-md-4 col-form-label text-md-right">
                        Titre <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6">
                        <div class="input-group-overlay d-lg-none">
                            <div class="input-group-prepend-overlay">
                                <span class="input-group-text">
                                    <i class="czi-bag"></i>
                                </span>
                            </div>
                            <input id="titre" type="text" class="form-control form-control-lg @error('titre') is-invalid @enderror" name="titre" value="{{ old('titre') }}" required autocomplete="titre" autofocus>
                            @error('titre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-right">
                        Description <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6">
                        <div class="input-group-overlay d-lg-none">
                            <div class="input-group-prepend-overlay">
                                <span class="input-group-text">
                                    <i class="czi-document"></i>
                                </span>
                            </div>
                            <textarea required name="description" class="form-control @error('description') is-invalid @enderror" rows="6" id="unp-product-description">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="cz-file-drop-area form-group">
                    {{-- <div class="cz-file-drop-icon czi-cloud-upload"></div>
                    <span class="cz-file-drop-message">Drag and drop here to upload product screenshot</span>
                    <input class="cz-file-drop-input" type="file" multiple>
                    <button class="cz-file-drop-btn btn btn-primary btn-sm mb-2" type="button">Or select file</button><small class="form-text text-muted">1000 x 800px ideal size for hi-res displays</small> --}}
                    @include('web.user.product.dropImage')
                </div>
                <div class="form-group" id="taille" style="display: none;">
                    <div>Cochez les tailles disponibles (facultatif)</div>
                    @foreach ($sizes as $size)
                        <div class="custom-control custom-option custom-control-inline mb-2">
                            <input  value="{{ $size->id }}"type="checkbox" class="custom-control-input" id="{{ $size->id }}" name="size[]">
                            <label for="{{ $size->id }}" class="custom-option-label">{{ $size->titre }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group" id="couleur" style="display: none;">
                    <div>Cochez les couleurs disponibles (facultatif)</div>
                    @foreach ($colors as $color)
                        <div class="custom-control custom-option custom-control-inline mb-2">
                            <input value="{{ $color->id }}" type="checkbox" class="custom-control-input" id="{{ $color->id }}" name="color[]">
                            <label for="{{ $color->id }}" class="custom-option-label rounded-circle">
                                <span class="custom-option-color rounded-circle" style="background-color: {{ $color->description }}"></span>
                            </label>
                        </div>
                    @endforeach
                </div>
                <button class="btn btn-info btn-block" type="submit">
                    <i class="czi-navigation
                    font-size-lg mr-2"></i>Continuer
                </button>
            </form>
        </div>
	</div>
</div>
@endsection

@push("script")
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script>
    $(document).ready(function() {
        $('#categorie').on('change', function() {
            var stateID = $(this).val();

            if(stateID ) {
                $.ajax({
                    url: '/findCategory/'+stateID,
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data) {
                        //console.log(data);
                        if(data){
                            incrementation = 0;

                            $('#laSous_categorie').show()
                            $('#sous_categorie').empty();
                            $('#sous_categorie').focus;
                            $('#sous_categorie').append('<option value="">-- Choisir sous catégorie --</option>');
                            $.each(data, function(key, value){
                                incrementation++;
                                $('select[name="sous_categorie"]').append('<option value="'+ value.id +'">' + value.titre+ '</option>');
                            });
                            if(incrementation == 0){
                                $('#laSous_categorie').hide();
                            }
                        }else{
                            $('#sous_categorie').empty();
                            $('#laSous_categorie').hide();
                        }
                    }
                });
                if (stateID == 1 || stateID == 2 || stateID == 3 || stateID == 4) {
                    $('#taille, #couleur').show();
                }
                else{
                    $('#taille, #couleur').hide();
                }
            }else{
                $('#sous_categorie').empty();
                $('#laSous_categorie').hide();
            }
        });
    });
</script>
@endpush
