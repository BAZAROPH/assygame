@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'commande',
])
{{-- @foreach ($user->commandes as $item)
    <div class="modal fade" id="{{ $item->reference }}">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Commande #{{ $item->reference }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-0">
                    @foreach ($item->produits as $produit)
                        <!-- Item-->
                        <div class="d-sm-flex justify-content-between mb-4 pb-3 pb-sm-2 border-bottom">
                            <div class="media d-block d-sm-flex text-center text-sm-left">
                                <a class="d-inline-block mx-auto mr-sm-4" href="{{ url($produit->slug) }}" style="width: 10rem;">
                                    @if(!empty($produit->getMedia('image')->first()))
                                        <img width="80" src="{{ url($produit->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $produit->libele }}">
                                    @endif
                                </a>
                                <div class="media-body pt-2">
                                    <h3 class="product-title font-size-base mb-2">
                                        <a href="{{ url($produit->slug) }}">
                                            {{ $produit->libele }}</a>
                                    </h3>
                                    <div class="font-size-sm">
                                        <span class="text-muted mr-2">Size:</span>8.5
                                    </div>
                                    <div class="font-size-sm">
                                        <span class="text-muted mr-2">Color:</span>White &amp; Blue
                                    </div>
                                    <div class="font-size-lg text-accent pt-2">
                                        {{ devise($produit->pivot->cout) }}
                                    </div>
                                </div>
                            </div>
                            <div class="pt-2 pl-sm-3 mx-auto mx-sm-0 text-center">
                                <div class="text-muted mb-2">Quantité: </div>
                                {{ $produit->pivot->quantite }}
                            </div>
                            <div class="pt-2 pl-sm-3 mx-auto mx-sm-0 text-center">
                                <div class="text-muted mb-2">Sous total :</div>
                                {{ devise($produit->pivot->cout * $produit->pivot->quantite) }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Footer-->
                <div class="modal-footer flex-wrap justify-content-between bg-secondary font-size-md">
                    <div class="px-2 py-1">
                        <span class="text-muted">Sous total:&nbsp;</span>
                        <span>{{ devise($item->cout_commande) }}</span>
                    </div>
                    <div class="px-2 py-1">
                        <span class="text-muted">Livraison:&nbsp;</span>
                        <span>{{ devise($item->cout_livraison) }}</span>
                    </div>
                    <div class="px-2 py-1">
                        <span class="text-muted">Adresse de livraison:&nbsp;</span>
                        <span>{{ $item->adresse->libelle }}</span>
                    </div>
                    <div class="px-2 py-1">
                        <span class="text-muted">Total:&nbsp;</span>
                        <span class="font-size-lg">{{ devise($item->total_commande) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach --}}

@section('content')
<style>
    .page-title-overlap {
        padding-bottom: 2.5rem;
    }
</style>
@foreach ($user->commandes as $commande)
    <div class="modal fade" id="{{ $commande->code }}">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Commande #{{ $commande->code }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-0">
                    @php($i = 0)
                    @foreach ($commande->produits as $item)
                        @php($i++)
                        <div class="row">
                            <div class="col-12 box-shadow border-accent mb-2 pt-2">
                                <div class="row mb-1">
                                    <div class="col-3">
                                        @if(!empty($item->getMedia('image')->first()))
                                            <a href="{{ route('product.show', $item) }}">
                                                <img class="img-fluid" width="80" src="{{ url($item->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $item->titre }}">
                                            </a>
                                        @endif
                                    </div>
                                    <div class="col-9">
                                        <h3 class="product-title font-size-base mb-2">
                                            <a href="{{ route('product.show', $item) }}">
                                                {{ $item->titre }}
                                            </a>
                                        </h3>
                                        <div class="font-size-sm text-muted">
                                            @if (json_decode($item->pivot->options)->taille)
                                                Taille:
                                                @foreach (json_decode($item->pivot->options)->taille as $value)
                                                    <label style="min-width: 2rem;
                                                    height: 2rem;
                                                    margin-bottom: 0;
                                                    padding-right: 0.375rem;
                                                    padding-left: 0.375rem;
                                                    padding-top: 0;
                                                    border: 1px solid #e3e9ef;" class="custom-option-label">{{ $value }}</label>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="font-size-sm text-muted">
                                            @if (json_decode($item->pivot->options)->couleur)
                                                @foreach (json_decode($item->pivot->options)->couleur as $value)
                                                    <label style="min-width: 2rem;
                                                    height: 2rem;
                                                    margin-bottom: 0;
                                                    padding-right: 0.375rem;
                                                    padding-left: 0.375rem;
                                                    padding-top: 0;
                                                    border: 1px solid #e3e9ef;" class="custom-option-label rounded-circle">
                                                        <span class="custom-option-color rounded-circle" style="width: 1.5rem;
                                                        height: 1.5rem;
                                                        margin-top: -0.75rem;
                                                        margin-left: -0.75rem;
                                                        background-color: {{ $value }};"></span>
                                                    </label>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div>
                                            <span class="mr-1 text-danger font-size-sm">
                                                ({{ $item->pivot->quantite }} pièces / {{ devise($item->pivot->montant) }}) x {{ json_decode($item->pivot->options)->quantite }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Footer-->
                <div class="modal-footer flex-wrap justify-content-between bg-secondary font-size-md">
                    <div class="px-2 py-1">
                        <span class="text-muted">Sous total:&nbsp;</span>
                        <span>{{ devise($commande->montant) }}</span>
                    </div>
                    <div class="px-2 py-1">
                        <span class="text-muted">Livraison:&nbsp;</span>
                        <span>{{ devise($commande->livraison) }}</span>
                    </div>
                    <div class="px-2 py-1">
                        <span class="text-muted">Total:&nbsp;</span>
                        <span class="font-size-lg">{{ devise($commande->total) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

@include('web.user.entete')

<!-- Page Content-->
<div class="container pb-5 mt-3">
    <div class="row">
		<!-- Content  -->
		<section class="col-lg-8">
			<div class="table-responsive font-size-md">
                @include('flash::message')
				<table class="table table-hover mb-0" id="simpletable">
					<thead>
						<tr>
                            <th>Date</th>
							<th>Commande #</th>
							<th>Etat</th>
							<th>Produit</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
                        @foreach ($user->commandes as $item)
                            <tr>
                                <td class="py-3">
                                    <span type="button" data-container="body" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="{{ $item->created_at->format('d-m-Y H:i') }}">
                                        {{ $item->created_at->diffForHumans() }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <a class="nav-link-style font-weight-medium font-size-sm" href="#{{ $item->code }}" data-toggle="modal">
                                        {{ $item->code }}
                                    </a>
                                </td>
                                <td class="py-3">
                                    <span class="m-0">{{ $item->statut }}</span>
                                </td>
                                <td class="py-3">
                                    <span class="badge badge-success m-0">{{ count($item->produits) }}</span>
                                </td>
                                <td class="py-3">{{ devise($item->total) }}</td>
                            </tr>
                        @endforeach
					</tbody>
				</table>
			</div>
			<hr class="pb-4">
			<!-- Pagination-->
			{{-- <nav class="d-flex justify-content-between pt-2" aria-label="Page navigation">
				<ul class="pagination">
					<li class="page-item"><a class="page-link" href="#"><i class="czi-arrow-left mr-2"></i>Prev</a></li>
				</ul>
				<ul class="pagination">
					<li class="page-item d-sm-none"><span class="page-link page-link-static">1 / 5</span></li>
					<li class="page-item active d-none d-sm-block" aria-current="page"><span class="page-link">1<span class="sr-only">(current)</span></span></li>
					<li class="page-item d-none d-sm-block"><a class="page-link" href="#">2</a></li>
					<li class="page-item d-none d-sm-block"><a class="page-link" href="#">3</a></li>
					<li class="page-item d-none d-sm-block"><a class="page-link" href="#">4</a></li>
					<li class="page-item d-none d-sm-block"><a class="page-link" href="#">5</a></li>
				</ul>
				<ul class="pagination">
					<li class="page-item"><a class="page-link" href="#" aria-label="Next">Next<i class="czi-arrow-right ml-2"></i></a></li>
				</ul>
			</nav> --}}
		</section>
	</div>
</div>
@endsection

@push('dataTable')
@if (request('ref'))
    <script type="text/javascript">
        $(window).on('load', function() {
            $('#{{ request('ref') }}').modal('show');
        });
    </script>
@endif
<!-- data-table js -->
<script src="https://cdn.qenium.com/bower/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.qenium.com/bower/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.qenium.com/assets/plugins/data-table/js/jszip.min.js"></script>
<script src="https://cdn.qenium.com/assets/plugins/data-table/js/pdfmake.min.js"></script>
<script src="https://cdn.qenium.com/assets/plugins/data-table/js/vfs_fonts.js"></script>
<script src="https://cdn.qenium.com/bower/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="https://cdn.qenium.com/bower/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="https://cdn.qenium.com/bower/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.qenium.com/bower/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.qenium.com/bower/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('admin/pages/data-table.js') }}"></script>
@endpush
