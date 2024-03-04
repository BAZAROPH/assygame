<div class="page-header" style="background: transparent;">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="{{ $infosPage['icon'] }} bg-c-blue"></i>
                <div class="d-inline">
                    <h2>{{ $infosPage['title'] }}</h2>
                </div>
            </div>

        </div>
        <div class="col-lg-4">
            @if ($infosPage['add'] == 1)
                <div class="text-right">
                    <a href="{{ url()->current().'/create' }}" class="btn btn-primary">
                        <i class="icofont-ui-add"></i>
                        Ajouter
                    </a>
                </div>
            @endif
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ url('home') }}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#!">{{ $infosPage['title'] }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
