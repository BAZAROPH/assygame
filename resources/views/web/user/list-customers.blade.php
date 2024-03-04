@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'profil',
])
@section('content')

@include('web.user.entete', [
    'breadcrumb' => '<li class="breadcrumb-item text-nowrap active" aria-current="page">Votre compte</li>',
])
<!-- Page Content-->
<div class="container pb-5 mb-2 mb-md-3">
	<div class="row">
		@include('web.user.compte-user')
		<!-- Content  -->
		<section class="col-lg-8 mt-5 pt-5">
            @include('flash::message')
            <div class="row">
                <div class="col-md-12">

                </div>
            </div>
		</section>
	</div>
</div>
@endsection
