@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'profil',
])
@section('content')

@include('web.user.entete')
<!-- Page Content-->
<div class="container pb-5 mb-2 mb-md-3">
	<div class="row">
		@include('web.user.compte-user')
		<!-- Content  -->
		<section class="col-lg-8">
            <div class="row">
                <div class="col-md-6">
                    <div class="card border-info">
                        <div class="card-header">
                            Informations pardonnelles
                            <span class="float-right">
                                <a href="{{ url('profil/edit') }}"><i class="icofont-pen-alt-1"></i></a>
                            </span>
                        </div>
                        <div class="card-body">
                            <p class="card-text font-size-sm">
                                <i class="icofont-check-circled"></i>
                                {!! auth()->user()->prenom.' '.auth()->user()->nom !!}
                            </p>
                            <p class="card-text font-size-sm">
                                <i class="icofont-check-circled"></i>
                                {!! auth()->user()->email !!}
                            </p>
                            <p class="card-text font-size-sm">
                                <a href="{{ url('profil/password') }}">
                                    <i class="icofont-ui-lock"></i>
                                    Modifier mot de passe
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
		</section>
	</div>
</div>
@endsection
