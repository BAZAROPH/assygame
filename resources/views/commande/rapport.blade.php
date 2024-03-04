@extends('layouts.app', [
    'title' => $infosPage['title'],
])

@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    {{--  <div class="text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Les 30 derniers jours
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="#">Les 30 derniers jours</a>
                              <a class="dropdown-item" href="#">Aujoud'hui</a>
                              <a class="dropdown-item" href="#">Hier</a>
                              <a class="dropdown-item" href="#">7 derniers jours</a>
                              <a class="dropdown-item" href="#">Ce mois</a>
                              <a class="dropdown-item" href="#">Mois passé</a>
                              <a class="dropdown-item" href="#">Personnalisé</a>
                            </div>
                          </div>
                    </div>  --}}
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
                            </div>
                        </div>
                    </div>

                    <div class="page-body">
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>
                                            Statistique des commandes effectuées des 14 derniers jours
                                            <a href="{{ url('commande/rapport') }}">
                                                <i class="icofont-plus"></i>
                                                Voir plus
                                            </a>
                                        </h5>
                                        {{--  <div class="text-center mt-3">
                                            <form action="{{ url('commande/rapport') }}" method="get">
                                                <div class="input-group mb-3">
                                                    <input name="search" type="text" class="form-control" placeholder="Recherche..." aria-describedby="button-addon2">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-primary" type="button" id="button-addon2">Rechercher</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>  --}}
                                        <div class="card-header-left">
                                        </div>
                                        <div class="card-header-right">
                                            <ul class="list-unstyled card-option">
                                                <li><i class="icofont icofont-simple-left"></i></li>
                                                <li><i class="icofont icofont-maximize full-card"></i></li>
                                                <li><i class="icofont icofont-minus minimize-card"></i></li>
                                                <li><i class="icofont icofont-refresh reload-card"></i></li>
                                                <li><i class="icofont icofont-error close-card"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div id="statistic-chart" style="height:517px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
    <script>
        'use strict';
        $(document).ready(function() {
            var chart = AmCharts.makeChart("statistic-chart", {
                "type": "serial",
                "marginTop": 0,
                "hideCredits": true,
                "marginRight": 0,
                "dataProvider": [
                    @php($current = Carbon\Carbon::now()->subWeeks(1))
                    @for ($i = 0; $i < 16; $i++)
                        {
                            "year": "{{ $current->addDay()->toDateString() }}",
                            "value": {{ total_date_commandes($current->toDateString()) }}
                        },
                    @endfor
                ],
                "valueAxes": [{
                    "axisAlpha": 0,
                    "dashLength": 6,
                    "gridAlpha": 0.1,
                    "position": "left"
                }
            ],
                "graphs": [{
                    "id": "g1",
                    "bullet": "round",
                    "bulletSize": 9,
                    "lineColor": "#4680ff",
                    "lineThickness": 2,
                    "negativeLineColor": "#4680ff",
                    "type": "smoothedLine",
                    "valueField": "value"
                }],
                "chartCursor": {
                    "cursorAlpha": 0,
                    "valueLineEnabled": false,
                    "valueLineBalloonEnabled": true,
                    "valueLineAlpha": false,
                    "color": '#fff',
                    "cursorColor": '#FC6180',
                    "fullWidth": true
                },
                "categoryField": "year",
                "categoryAxis": {
                    "gridAlpha": 0,
                    "axisAlpha": 0,
                    "fillAlpha": 1,
                    "fillColor": "#FAFAFA",
                    "minorGridAlpha": 0,
                    "minorGridEnabled": true
                },
                "export": {
                    "enabled": true
                }
            });
        });
    </script>
@endsection
