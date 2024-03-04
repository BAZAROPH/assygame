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
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Code</td>
                                                <td>{{ $valeur->code }}</td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td>
                                                    @switch($valeur->statut)
                                                        @case('attente')
                                                                <span class="text-warning">En attente</span>
                                                            @break
                                                        @case('effectue')
                                                                <span class="text-success">Effectuée</span>
                                                            @break
                                                        @case('annule')
                                                                <span class="text-danger">Annulée</span>
                                                            @break
                                                        @default
                                                    @endswitch
                                                    <form method="post" action="{{ url()->current() }}" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="input-group mb-3">
                                                            <select required class="form-control-lg" name="statut" id="">
                                                                <option value="">-------</option>
                                                                <option value="attente" @if($valeur->statut == 'attente') selected @endif>En attente</option>
                                                                <option value="effectue" @if($valeur->statut == 'effectue') selected @endif>Effectée</option>
                                                                <option value="annule" @if($valeur->statut == 'annule') selected @endif>Annulée</option>
                                                            </select>
                                                            <div class="input-group-append">
                                                                <button name="valider" class="btn btn-outline-primary">Valider</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                            {{-- <tr>
                                                <td>Titre</td>
                                                <td>{{ $valeur->titre }}</td>
                                            </tr>
                                            <tr>
                                                <td>Description</td>
                                                <td>{{ $valeur->description }}</td>
                                            </tr> --}}
                                            <tr>
                                                <td>Client</td>
                                                <td>
                                                    <a href="{{ url('user/'.$valeur->client->id) }}">
                                                        {{ $valeur->client->nom.' '.$valeur->client->prenom }} --
                                                        {{ $valeur->client->contact }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Sous total</td>
                                                <td>
                                                    {{ devise($valeur->montant) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Frais d'expédition</td>
                                                <td>
                                                    {{ devise($valeur->livraison) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Total</td>
                                                <td>
                                                    {{ devise($valeur->total) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Produits ({{ count($valeur->commande_produits) }})</td>
                                                <td>
                                                    <table width="100%" class="border">
                                                        <tr>
                                                            <td>Code</td>
                                                            <td>Titre</td>
                                                            <td>Prix</td>
                                                            <td>Quantité</td>
                                                            <td>Total</td>
                                                        </tr>
                                                        @foreach ($valeur->produits as $item)
                                                            <tr>
                                                                <td>
                                                                    @if(!empty($item->getMedia('image')->first()))
                                                                        <a href="{{ url('produit/'.$item->id) }}" data-toggle="modal" data-target="#exampleModal{{ $item->id }}">
                                                                            <img width="100" src="{{ url($item->getMedia('image')->first()->getUrl()) }}">
                                                                        </a>
                                                                    @else
                                                                        <img height="40" src="{{ asset('image/no-image.png') }}">
                                                                    @endif
                                                                    <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">{{ $item->titre }}</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <img class="img-fluid" src="{{ url($item->getMedia('image')->first()->getUrl()) }}">
                                                                                <p>{{ $item->description }}</p>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    [{{ $item->code }}]
                                                                    {{ $item->titre }}
                                                                    <div class="text-danger">
                                                                        {{ $item->categorie->titre }}
                                                                    </div>
                                                                </td>
                                                                <td>{{ number_format($item->pivot->montant,0,'.',' ') }} Fcfa</td>
                                                                <td>{{ $item->pivot->quantite }}</td>
                                                                <td>{{ number_format(($item->pivot->montant*$item->pivot->quantite) ,0,'.',' ') }} Fcfa</td>
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
