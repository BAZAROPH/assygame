@extends('layouts.app', [
    'title' => $infosPage['title'],
])

@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">

                    <div class="page-body">
                        <div class="row">
                            <!-- card1 start -->
                            <div class="col-md-6 col-xl-3">
                                <a href="{{ url('produit') }}">
                                    <div class="card widget-card-1">
                                        <div class="card-block-small">
                                            <i class="icofont-shopping-cart bg-c-blue card1-icon"></i>
                                            <span class="text-c-blue f-w-600">Produits</span>
                                            <h4>
                                                {{ count($produits) }}
                                                <small class="text-secondary" style="font-size: 14px;">produit(s)</small>
                                            </h4>
                                            <div>
                                                <span class="f-left m-t-10 text-muted">
                                                    <i class="text-c-blue f-16 icofont-eye m-r-10"></i>Plus
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- card1 end -->
                            <!-- card1 start -->
                            <div class="col-md-6 col-xl-3">
                                <a href="{{ url('commande') }}">
                                    <div class="card widget-card-1">
                                        <div class="card-block-small">
                                            <i class="icofont-truck-alt bg-c-pink card1-icon"></i>
                                            <span class="text-c-pink f-w-600">Commandes</span>
                                            <h4>
                                                {{ count($commandes) }}
                                                 <small class="text-secondary" style="font-size: 14px;">commande(s)</small>
                                            </h4>
                                            <div>
                                                <span class="f-left m-t-10 text-muted">
                                                    <i class="text-c-pink f-16 icofont-calendar m-r-10"></i>
                                                    Détails
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- card1 end -->
                            <!-- card1 start -->
                            <div class="col-md-6 col-xl-3">
                                <a href="{{ url('user?type=client') }}">
                                    <div class="card widget-card-1">
                                        <div class="card-block-small">
                                            <i class="icofont-users-social bg-c-green card1-icon"></i>
                                            <span class="text-c-green f-w-600">Clients</span>
                                            <h4>
                                                {{ count($clients) }}
                                                <small class="text-secondary" style="font-size: 14px;">client(s)</small>
                                            </h4>
                                            <div>
                                                <span class="f-left m-t-10 text-muted">
                                                    <i class="text-c-green f-16 icofont icofont-tag m-r-10"></i>Détails
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- card1 end -->
                            <!-- card1 start -->
                            <div class="col-md-6 col-xl-3">
                                <a href="{{ url('user?type=fournisseur') }}">
                                    <div class="card widget-card-1">
                                        <div class="card-block-small">
                                            <i class="icofont-users-alt-1 bg-c-yellow card1-icon"></i>
                                            <span class="text-c-yellow f-w-600">Fournisseurs</span>
                                            <h4>
                                                {{ count($fournisseurs) }}
                                                <small class="text-secondary" style="font-size: 14px;">fournisseur(s)</small>
                                            </h4>
                                            <div>
                                                <span class="f-left m-t-10 text-muted">
                                                    <i class="text-c-yellow f-16 icofont-refresh m-r-10"></i> Détails
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

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
                                        <div class="card-header-left ">
                                        </div>
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
                                    <div class="card-block">
                                        <div id="statistic-chart" style="height:517px;"></div>
                                    </div>
                                </div>
                            </div>

                            {{--  <div class="col-md-12 col-xl-4">
                                <div class="card fb-card">
                                    <div class="card-header">
                                        <i class="icofont icofont-social-facebook"></i>
                                        <div class="d-inline-block">
                                            <h5>facebook</h5>
                                            <span>blog page timeline</span>
                                        </div>
                                    </div>
                                    <div class="card-block text-center">
                                        <div class="row">
                                            <div class="col-6 b-r-default">
                                                <h2>23</h2>
                                                <p class="text-muted">Active</p>
                                            </div>
                                            <div class="col-6">
                                                <h2>23</h2>
                                                <p class="text-muted">Comment</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card dribble-card">
                                    <div class="card-header">
                                        <i class="icofont icofont-social-dribbble"></i>
                                        <div class="d-inline-block">
                                            <h5>dribble</h5>
                                            <span>Product page analysis</span>
                                        </div>
                                    </div>
                                    <div class="card-block text-center">
                                        <div class="row">
                                            <div class="col-6 b-r-default">
                                                <h2>23</h2>
                                                <p class="text-muted">Live</p>
                                            </div>
                                            <div class="col-6">
                                                <h2>23</h2>
                                                <p class="text-muted">Message</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card twitter-card">
                                    <div class="card-header">
                                        <i class="icofont icofont-social-twitter"></i>
                                        <div class="d-inline-block">
                                            <h5>twitter</h5>
                                            <span>current new timeline</span>
                                        </div>
                                    </div>
                                    <div class="card-block text-center">
                                        <div class="row">
                                            <div class="col-6 b-r-default">
                                                <h2>25</h2>
                                                <p class="text-muted">new tweet</p>
                                            </div>
                                            <div class="col-6">
                                                <h2>450+</h2>
                                                <p class="text-muted">Follower</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  --}}
                        </div>
                    </div>
                </div>

                <div id="styleSelector">

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
                    @for ($i = 0; $i < 14; $i++)
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
