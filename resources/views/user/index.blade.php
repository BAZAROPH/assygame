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
                                <div class="table-responsive">
                                    <table class="table" id="table_id">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nom & prénom</th>
                                                <th>Email</th>
                                                <th>Contact</th>
                                                <th>Nbr. Cmd</th>
                                                @if (request('type') == 'fournisseur')
                                                    <th>Nbr. prod</th>
                                                @endif
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
                                                        @if(!empty($valeur->getMedia()->first()))
                                                            <img height="40" src="{{ url($valeur->getMedia()->first()->getUrl()) }}">
                                                        @else
                                                            <img height="40" src="{{ asset('image/user.png') }}">
                                                        @endif
                                                        <a href="{{ url()->current().'/'.$valeur->id }}">
                                                            {{ $valeur->nom.' '.$valeur->prenom }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{ $valeur->email }}
                                                    </td>
                                                    <td>
                                                        {{ $valeur->contact }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ url()->current().'/'.$valeur->id }}">
                                                            {{ count($valeur->commandes) }}
                                                        </a>
                                                    </td>
                                                    @if (request('type') == 'fournisseur')
                                                        <td>
                                                            <a href="{{ url()->current().'/'.$valeur->id }}">
                                                                {{ count($valeur->produits) }}
                                                            </a>
                                                        </td>
                                                    @endif
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
                                                                            Mettre à la corbeille "{{ $valeur->nom.' '.$valeur->prenom }}"
                                                                        </h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="alert alert-warning">
                                                                            <i class="icofont icofont-exclamation-tringle"></i>
                                                                            Voulez-vous vraiment mettre à la corbeille ?
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
