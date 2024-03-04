@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'category',
])
@section('content')
    @include('web.user.entete')


    <!-- Offres hebdomadaires -->
    <section class="container">
        <div class="row mx-n2">
            @foreach ($categorie->categories as $category)
                @foreach ($category->produits as $produit  )
                    @include('web.produit.item', [
                        'class' => 'col-md-4 col-6 col-sm-6 px-2 mb-4'
                    ])
                @endforeach
            @endforeach
        </div>
    </section>
@endsection
