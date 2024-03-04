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
                                                <th>Code</th>
                                                <th>Libelle</th>
                                                <th>Status</th>
                                                <th>Hebdo</th>
                                                <th>Fournisseur</th>
                                                <th>Prix</th>
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
                                                    <td width="100">
                                                        <a href="{{ url()->current().'/'.$valeur->id }}">
                                                            @if(!empty($valeur->getMedia('image')->first()))
                                                                <img width="150" src="{{ url($valeur->getMedia('image')->first()->getUrl('thumb')) }}">
                                                            @else
                                                                <img height="40" src="{{ asset('image/no-image.png') }}">
                                                            @endif
                                                            <i class="{{ $valeur->icon }} text-warning-color"></i>
                                                            {{ $valeur->titre }}
                                                        </a>
                                                    </td>

                                                    <td>
                                                        @if ($valeur->status == 1)
                                                            <span class="text-success">
                                                                <i class="icofont-check-circled"></i> Validé
                                                            </span>
                                                            {{-- <a class="btn btn-danger btn-sm" href="{{ url('produit/'.$valeur->id.'/validation/0') }}">
                                                                <i class="icofont-reply"></i> Annuler
                                                            </a> --}}
                                                        @else
                                                            <span class="text-danger">
                                                                <i class="icofont-close-circled"></i> Pas validé
                                                            </span>
                                                            {{-- <a class="btn btn-success btn-sm" href="{{ url('produit/'.$valeur->id.'/validation/1') }}">
                                                                <i class="icofont-check-circled"></i> Valider
                                                            </a> --}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($valeur->hebdo == 1)
                                                            <span class="text-success">
                                                                <i class="icofont-check-circled"></i> Hebdo
                                                            </span>
                                                            <a class="btn btn-danger btn-sm" href="{{ url('produit/'.$valeur->id.'/hebdo/0') }}">
                                                                <i class="icofont-reply"></i> Annuler
                                                            </a>
                                                        @else
                                                            <span class="text-danger">
                                                                <i class="icofont-close-circled"></i> Pas Hebdo
                                                            </span>
                                                            <a class="btn btn-success btn-sm" href="{{ url('produit/'.$valeur->id.'/hebdo/1') }}">
                                                                <i class="icofont-check-circled"></i> Valider
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('user/'.$valeur->fournisseur->id) }}">
                                                            @if(!empty($valeur->fournisseur->getMedia()->first()))
                                                                <img height="40" src="{{ url($valeur->fournisseur->getMedia()->first()->getUrl()) }}">
                                                            @else
                                                                <img height="40" src="{{ asset('image/user.png') }}">
                                                            @endif
                                                            {{ $valeur->fournisseur->nom.' '.$valeur->fournisseur->prenom }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @foreach ($valeur->tarifs as $item)
                                                            <div>
                                                                {{ $item->quantite }} =>
                                                                {{ number_format($item->montant,0,'.',' ') }} Fcfa
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <a href="{{ url()->current().'/'.$valeur->id.'/edit' }}" class="btn btn-success waves-effect" data-toggle="tooltip" data-placement="top" title="Modifier" data-original-title="Modifier">
                                                            <i class="icofont icofont-edit"></i>
                                                        </a>
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
