@extends('web.layouts.app', [
    'title' => 'Modification de mot de passe',
    'page' => 'profil',
])
@section('content')
<style>
    .page-title-overlap {
        padding-bottom: 2.5rem;
    }
</style>
@include('web.user.entete')
<div class="container pb-5 mb-2 mb-md-3">
	<div class="row">
        <section class="col-lg-8 mt-5 pt-5">
            <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data" class="form-box">
                @csrf
                <div class="form-group">
                    <input required type="password" id="current-pass" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Entrer votre mot de passe actuel">
                    @error('current_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{!! $message !!}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input required type="password" id="new-password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Entrez un nouveau mot de passe">
                    @error('new_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{!! $message !!}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input required type="password" id="re-enter" name="new_confirm_password" class="form-control @error('new_confirm_password') is-invalid @enderror" placeholder="Ré-entrez le nouveau mot de passe">
                    @error('new_confirm_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{!! $message !!}</strong>
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
