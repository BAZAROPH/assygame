@extends('layouts.app')

@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    @include('categorie.header')
                    <!-- Page-body start -->
                    <div class="page-body">
                        <!-- Basic table card start -->
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
                                @if ($valeur->created_at)
                                    <div class="text-right">
                                        <span data-toggle="tooltip" data-placement="top" title="{{ $valeur->created_at->format('Y/m/d H:i:s') }}" data-original-title="{{ $valeur->created_at->format('Y/m/d H:i:s') }}">
                                            {{ $valeur->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table" id="table_id">
                                        <tbody>
                                            <tr>
                                                <td>Nom & prénoms</td>
                                                <td>
                                                    {{ $valeur->nom.' '.$valeur->prenom }}
                                                    <div class="text-danger">
                                                        {{ $valeur->type }}
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Image</td>
                                                <td>
                                                    @if(!empty($valeur->getMedia('image')->first()))
                                                        <img height="200" src="{{ url($valeur->getMedia('image')->first()->getUrl()) }}">
                                                    @else
                                                        <img height="100" src="{{ asset('image/user.png') }}">
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>{{ $valeur->email }}</td>
                                            </tr>
                                            <tr>
                                                <td>Contact</td>
                                                <td>{{ $valeur->contact }}</td>
                                            </tr>
                                            <tr>
                                                <td>Commandes ({{ count($valeur->commandes) }})</td>
                                                <td>
                                                    <table width="100%" class="border">
                                                        <tr>
                                                            <td>Code</td>
                                                            <td>Titre</td>
                                                            <td>Cout</td>
                                                            <td>Date</td>
                                                        </tr>
                                                        @foreach ($valeur->commandes as $item)
                                                            <tr>
                                                                <td>
                                                                    <a href="{{ url('commande/'.$item->id) }}">
                                                                        {{ $item->code }}
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    {{ $item->titre }}
                                                                    <div class="text-danger">
                                                                        {{ $item->statut }}
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    {{ number_format($item->montant,0,'.',' ') }} Fcfa
                                                                </td>
                                                                <td>
                                                                    <span data-toggle="tooltip" data-placement="top" title="{{ $item->created_at->format('Y/m/d H:i:s') }}" data-original-title="{{ $item->created_at->format('Y/m/d H:i:s') }}">
                                                                        {{ $item->created_at->diffForHumans() }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td>Produits ({{ count($valeur->produits) }})</td>
                                                <td>
                                                    <table width="100%" class="border">
                                                        <tr>
                                                            <td>Code</td>
                                                            <td>Titre</td>
                                                            <td>Prix</td>
                                                            <td>Date</td>
                                                        </tr>
                                                        @foreach ($valeur->produits as $item)
                                                            <tr>
                                                                <td>
                                                                    <a href="{{ url('produit/'.$item->id) }}">
                                                                        {{ $item->code }}
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    @if(!empty($item->getMedia('image')->first()))
                                                                        <img width="80" src="{{ url($item->getMedia('image')->first()->getUrl()) }}">
                                                                    @else
                                                                        <img height="40" src="{{ asset('image/no-image.png') }}">
                                                                    @endif
                                                                    {{ $item->titre }}
                                                                    <div class="text-danger">
                                                                        {{ $item->categorie->titre }}
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    @foreach ($item->tarifs as $item)
                                                                        <div>
                                                                            {{ $item->quantite }} =>
                                                                            {{ number_format($item->montant,0,'.',' ') }} Fcfa
                                                                        </div>
                                                                    @endforeach
                                                                </td>
                                                                <td>
                                                                    <span data-toggle="tooltip" data-placement="top" title="{{ $item->created_at->format('Y/m/d H:i:s') }}" data-original-title="{{ $item->created_at->format('Y/m/d H:i:s') }}">
                                                                        {{ $item->created_at->diffForHumans() }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
