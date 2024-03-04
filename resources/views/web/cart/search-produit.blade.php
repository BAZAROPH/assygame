@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'profil',
])
@section('content')

@include('web.user.entete')
<!-- Page Content-->
<div class="container pb-5 mb-2 mb-md-3">
    <div class="row">
        <div class="col-12">
            Recherche de {{ request('term_search') }}
        </div>
    </div>
	<div class="row">
        @foreach ($produits as $produit)
            @include('web.produit.item', [
                'class' => 'col-md-4 col-6 col-sm-6 px-2 mb-4'
            ])
        @endforeach
	</div>
    <div class="row">
        <div class="col-12">
            <hr class="my-3">
            <nav class="d-flex justify-content-between pt-2 justify-content-center" aria-label="Page navigation">
                {{ $produits->links() }}
            </nav>
        </div>
    </div>
</div>
@endsection
