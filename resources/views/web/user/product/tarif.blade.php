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
                <a class="step-item active" href="#">
                    <div class="step-progress">
                        <span class="step-count">1</span>
                    </div>
                    <div class="step-label">
                        <i class="icofont-google-map"></i>Infos produit
                    </div>
                </a>

                <span class="step-item active current" href="#">
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
            <form method="POST" action="{{ route('product.tarifStore', $produit) }}">
                @csrf
                <div id="repeater">
                    <!-- Repeater Heading -->
                    <div class="repeater-heading">
                        <button class="btn btn-accent btn-sm pull-right repeater-add-btn" onclick='return false;'>
                            <i class="czi-add"></i> Ajouter une autre ligne pour le tarif
                        </button>
                    </div>
                    <div class="clearfix"></div>
                    <!-- Repeater Items -->
                    <div class="items" data-group="test">
                        <!-- Repeater Content -->
                        <div class="item-content">
                            <div class="row">
                                <div class="col-5 pr-0">
                                    <div class="form-group row">
                                        <label style="width: 110px;" for="quantite" class="col-md-4 col-form-label text-md-right">
                                            Quantité <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-6">
                                            <div class="input-group-overlay d-lg-none">
                                                <div class="input-group-prepend-overlay">
                                                    <span class="input-group-text">
                                                        <i class="czi-wash"></i>
                                                    </span>
                                                </div>
                                                <input id="quantite" type="number" class="form-control form-control-lg @error('titre') is-invalid @enderror" name="quantite[]" value="{{ old('quantite[]') }}" required data-skip-name="true" data-name="quantite[]">
                                                @error('quantite[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5 pl-0">
                                    <div class="form-group row">
                                        <label style="width: 100px;" for="montant" class="col-md-4 col-form-label text-md-right">
                                            Montant <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-6">
                                            <div class="input-group-overlay d-lg-none">
                                                <div class="input-group-prepend-overlay">
                                                    <span class="input-group-text">
                                                        <i class="czi-dollar-circle"></i>
                                                    </span>
                                                </div>
                                                <input id="montant" type="number" class="form-control form-control-lg @error('montant[]') is-invalid @enderror" name="montant[]" value="{{ old('montant[]') }}" required data-skip-name="true" data-name="montant[]">
                                                @error('montant[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 text-center pt-4 pl-0">
                                    <!-- Repeater Remove Btn -->
                                    <div class="repeater-remove-btn">
                                        <button class="btn btn-danger remove-btn p-1">
                                            <i class="czi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <button class="btn btn-info btn-block" type="submit">
                        Continuer
                        <i class="czi-navigation font-size-lg mr-2"></i>
                    </button>
                </div>

            </form>
        </div>
	</div>
</div>
@endsection

@push("script")
<script src="{{ asset('js/repeater.js') }}" type="text/javascript"></script>
<script>
    /* Create Repeater */
    $("#repeater").createRepeater({
        showFirstItemToDefault: true,
    });
</script>
@endpush
