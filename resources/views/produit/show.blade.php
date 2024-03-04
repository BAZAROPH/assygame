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
                                <div>
                                    <a href="{{ route('produit.edit', $valeur) }}" class="btn btn-success waves-effect" data-toggle="tooltip" data-placement="top" title="Modifier" data-original-title="Modifier">
                                        <i class="icofont icofont-edit"></i>
                                    </a>
                                </div>
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
                                                <td>Code</td>
                                                <td>{{ $valeur->code }}</td>
                                            </tr>
                                            <tr>
                                                <td>Titre</td>
                                                <td>{{ $valeur->titre }}</td>
                                            </tr>
                                            <tr>
                                                <td>Categorie</td>
                                                <td>

                                                    @if ($valeur->categorie->categorie->titre)
                                                        {{ $valeur->categorie->categorie->titre }} /
                                                    @endif
                                                    {{ $valeur->categorie->titre }}
                                                    {{-- @if ($valeur->categorie->categorie->categorie->titre)
                                                        / {{ $valeur->categorie->categorie->categorie->titre }}
                                                    @endif --}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Image</td>
                                                <td>
                                                    <div class="row">
                                                        @foreach ($valeur->getMedia('image') as $item)
                                                            <div class="col-md-3">
                                                                <img src="{{ url($item->getUrl('thumb')) }}" class="imf-fluid img-thumbnail">
                                                            </div>
                                                        @endforeach
                                                </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Commandé</td>
                                                <td>{{ count($valeur->commandes) }}x</td>
                                            </tr>
                                            <tr>
                                                <td>Description</td>
                                                <td>{{ $valeur->description }}</td>
                                            </tr>
                                            <tr>
                                                <td>Fournisseur</td>
                                                <td>
                                                    <a href="{{ route('user.show', $valeur->fournisseur) }}">
                                                        {{ $valeur->fournisseur->nom }}
                                                        {{ $valeur->fournisseur->prenom }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Prix</td>
                                                <td>
                                                    @foreach ($valeur->tarifs as $item)
                                                        <div>
                                                            {{ $item->quantite }} =>
                                                            {{ devise($item->montant) }}
                                                        </div>
                                                    @endforeach
                                                </td>
                                            </tr>
                                            @if (count($valeur->couleurs))
                                                <tr>
                                                    <td>Couleurs</td>
                                                    <td>
                                                        @foreach ($valeur->couleurs as $item)
                                                            <div>
                                                                {{ $item->titre }}
                                                                <span style="width: 30px; height:30px; background: {{ $item->description }}">...</span>
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endif
                                            @if (count($valeur->tailles))
                                                <tr>
                                                    <td>Tailles</td>
                                                    <td>
                                                        @foreach ($valeur->tailles as $item)
                                                            <div>
                                                                {{ $item->titre }}
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>Status</td>
                                                <td>
                                                    @if ($valeur->status == 1)
                                                        <span class="text-success">Validé</span>
                                                        <a class="btn btn-danger" href="{{ url('produit/'.$valeur->id.'/validation/0') }}">
                                                            <i class="icofont-reply"></i> Annuler la validation
                                                        </a>
                                                    @else
                                                        <span class="text-danger">Pas validé</span>
                                                        <a class="btn btn-success" href="{{ url('produit/'.$valeur->id.'/validation/1') }}">
                                                            <i class="icofont-check-circled"></i> Valider le produit
                                                        </a>
                                                    @endif

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
