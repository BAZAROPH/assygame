@extends('layouts.app')

@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    @include('categorie.header')

                    <div class="page-body">
                        <div class="card p-3">
                            <div class="card-block table-border-style">
                                <div class="badge badge-success" style="font-size: 120%;">
                                    Commandes effectuées : {{ number_format(cout_commandes($valeurs, 'effectue'), 0, '.', ' ') }} Fcfa
                                </div>
                                <div class="badge badge-warning" style="font-size: 120%;">
                                    Commandes en attente : {{ number_format(cout_commandes($valeurs, 'attente'), 0, '.', ' ') }} Fcfa
                                </div>
                                <div class="badge badge-danger" style="font-size: 120%;">
                                    Commandes annulées : {{ number_format(cout_commandes($valeurs, 'annule'), 0, '.', ' ') }} Fcfa
                                </div>
                                <div class="float-right">
                                    <a href="{{ url('commande/rapport') }}">
                                        <i class="icofont-chart-arrows-axis"></i>
                                        Statistiques
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-body">
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
                                <div class="table-responsive">
                                    <table class="table" id="table_id">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Code</th>
                                                <th>Etat</th>
                                                <th>Cout</th>
                                                <th>Client</th>
                                                <th>Action</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php ($i = 0)
                                            @foreach ($valeurs as $valeur)
                                                @php ($i++)
                                                <tr>
                                                    <th scope="row">{{ $i }}</th>
                                                    <td>
                                                        <a href="{{ url()->current().'/'.$valeur->id }}">
                                                            {{ $valeur->code }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url()->current().'/'.$valeur->id }}">
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
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{ number_format($valeur->montant,0,'.',' ') }} Fcfa
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('user/'.$valeur->client->id) }}">
                                                            {{ $valeur->client->nom }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="#" class="btn btn-danger waves-effect" data-toggle="modal" data-target="#exampleModal{{ $i }}" data-placement="top" title="" data-original-title="">
                                                            <i class="icofont icofont-trash"></i>
                                                        </a>
                                                        <div class="modal fade" id="exampleModal{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Mettre à la corbeille "{{ $valeur->titre }}"
                                                                        </h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="alert alert-warning">
                                                                            <i class="icofont icofont-exclamation-tringle"></i>
                                                                            Voulez-vous vraiment mettre à la corbeille ce produit ?
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form action="{{ url()->current().'/'.$valeur->id }}" method="post">
                                                                            @method('DELETE')
                                                                            @csrf
                                                                            <button class="btn btn-danger waves-effect" data-toggle="tooltip" data-placement="top" title="Supprimer" data-original-title="Supprimer">
                                                                                <i class="icofont icofont-trash"></i> OUI
                                                                            </button>
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($valeur->created_at)
                                                            <div style="color:#fff; font-size:1px;">
                                                                {{ $valeur->created_at->format('Y/m/d H:i') }}
                                                            </div>
                                                            {{ $valeur->created_at->diffForHumans() }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
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
