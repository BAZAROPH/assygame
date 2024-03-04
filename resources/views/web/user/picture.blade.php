@extends('web.layouts.app', [
    'title' => 'Modification photo de profil',
    'page' => 'profil',
])
@section('content')
<style>
    .page-title-overlap {
        padding-bottom: 2.5rem;
    }
</style>
@include('web.user.entete')
<div class="container pb-5 mt-3">
    <div class="row">
        <div class="col-md-12">
            @include('flash::message')
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data" class="form-box">
                @csrf
                <div class="form-group">
                    <div class="text-center">
                        @if(!empty(auth()->user()->getMedia('image')->first()))
                            <img class="rounded-circle" width="80" src="{{ url(auth()->user()->getMedia('image')->first()->getUrl('thumb')) }}">
                        @else
                            <img class="rounded-circle" width="80" src="{{ asset('image/user.png') }}">
                        @endif
                    </div>
                    <input type="file" name="photo" class="form-control form-control-lg @error('photo') is-invalid @enderror">
                    @error('photo')
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
@endsection
