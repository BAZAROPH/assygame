@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'profil',
])
@section('content')

@include('web.user.entete')
<!-- Page Content-->
<div class="container pb-5 mb-2 mb-md-3">
	<div class="row">
        @foreach ($produits as $produit)
            @include('web.produit.item', [
                'class' => 'col-md-4 col-6 col-sm-6 px-2 mb-4'
            ])
        @endforeach
	</div>

    <div class="row">
        <div class="col-12">
            <a class="btn btn-info btn-block" href="{{ route('product.create') }}">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> Ajouter vos articles
            </a>
        </div>
    </div>
</div>
@endsection
