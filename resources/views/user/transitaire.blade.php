<!doctype html>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="author" content="Qenium">
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('image/icon.png') }}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Dosis|Montserrat|Nunito|Open+Sans|Oxygen|PT+Sans|Poppins|Raleway|Ubuntu&display=swap" rel="stylesheet">
    <!-- iconfont -->
    <link rel="stylesheet" href="https://allyoucan.cloud/cdn/icofont/1.0.1/icofont.css">
    <!-- Font Awesone -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/design.css') }}">

    <style>
        body{
            font-family: "Open Sans", sans-serif;
        }

        .toggle1 {
            background: #DDD;
            width: 100px;
            height: 50px;
            border-radius: 100px;
            display: block;
            appearance: none;
            -webkit-appearance: none;
            position: relative;
            cursor: pointer;
            float: left;
        }
        .toggle1:after {
            content: "";
            background: #999;
            display: block;
            height: 50px;
            width: 50px;
            border-radius: 100%;
            position: absolute;
            left: 0px;
            transform: scale(0.9);
            cursor: pointer;
            transition: all 0.4s ease;
        }
        .toggle1:checked {
            background: #EEE;
        }
        .toggle1:checked:after {
            background: #0B66CE;
            left: 50px;
        }

        /* DEFAULTS */
/* =============================================== */
body {
    display: grid;
    place-content: center;

    min-height: 100vh;
    margin: 0;
    padding: 40px;
    box-sizing: border-box;

    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Open Sans', sans-serif;
  }


  /* MAIN */
  /* =============================================== */
  .rad-label {
    display: flex;
    align-items: center;

    border-radius: 100px;
    padding: 14px 16px;
    margin: 10px 0;

    cursor: pointer;
    transition: .3s;
  }

  .rad-label:hover,
  .rad-label:focus-within {
    background: hsla(0, 0%, 80%, .14);
  }

  .rad-input {
    position: absolute;
    left: 0;
    top: 0;
    width: 1px;
    height: 1px;
    opacity: 0;
    z-index: -1;
  }

  .rad-design {
    width: 22px;
    height: 22px;
    border-radius: 100px;

    background: linear-gradient(to right bottom, hsl(154, 97%, 62%), hsl(225, 97%, 62%));
    position: relative;
  }

  .rad-design::before {
    content: '';

    display: inline-block;
    width: inherit;
    height: inherit;
    border-radius: inherit;

    background: hsl(0, 0%, 90%);
    transform: scale(1.1);
    transition: .3s;
  }

  .rad-input:checked+.rad-design::before {
    transform: scale(0);
  }

  .rad-text {
    color: hsl(0, 0%, 60%);
    margin-left: 14px;
    letter-spacing: 3px;
    text-transform: uppercase;
    font-size: 18px;
    font-weight: 900;

    transition: .3s;
  }

  .rad-input:checked~.rad-text {
    color: hsl(0, 0%, 40%);
  }


  /* ABS */
  /* ====================================================== */
  .abs-site-link {
    position: fixed;
    bottom: 40px;
    left: 20px;
    color: hsla(0, 0%, 0%, .5);
    font-size: 16px;
  }

    </style>

    <title>Transitaire</title>
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    @include('flash::message')
                </div>
                {{-- @if ($transitaire)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Votre transitaire :
                                <strong>
                                    {{ $transitaire->nom.'['.$transitaire->telephone.']' }}
                                </strong>
                            </h5>
                            <div class="alert alert-info">Modifier votre transitaire</div>
                            <form action="{{ url()->current().'/edit' }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input required name="nom" type="text" class="form-control form-control-lg" placeholder="Nom du transitaire" value="{{ $transitaire->nom }}">
                                    @error('nom')
                                        <div class="text-danger text-center">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input required name="telephone" type="text" class="form-control form-control-lg" placeholder="Numéro téléphone" value="{{ $transitaire->telephone }}">
                                    @error('nom')
                                        <div class="text-danger text-center">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <button type="submit" name="continuer"class="btn btn-primary btn-block btn-lg">Modifier</button>
                            </form>
                        </div>
                    </div>
                @else --}}
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Avez vous un transitaire ?</h5>
                        <span style="font-size: 13px; color:#999">Si vous n'en avez pas cliquez sur continuer</span>
                        <script type="text/javascript">
                            function Change()
                            {
                                if ((document.getElementById('oui').checked))
                                    document.getElementById('rai').style.display="block";
                                else
                                    document.getElementById('rai').style.display="none";
                            }
                        </script>
                        <form method="POST" action="{{ url()->current() }}">
                            @csrf
                            <div class="mt-4">
                                {{-- <div>
                                    <label class="rad-label">
                                        <input type="radio" class="rad-input" name="rad">
                                        <div class="rad-design"></div>
                                        <div class="rad-text">Air</div>
                                    </label>

                                    <label class="rad-label">
                                        <input type="radio" class="rad-input" name="rad">
                                        <div class="rad-design"></div>
                                        <div class="rad-text">Clouds</div>
                                    </label>

                                    <label class="rad-label">
                                        <input type="radio" class="rad-input" name="rad">
                                        <div class="rad-design"></div>
                                        <div class="rad-text">Earth</div>
                                    </label>

                                    <label class="rad-label">
                                        <input type="radio" class="rad-input" name="rad">
                                        <div class="rad-design"></div>
                                        <div class="rad-text">Water</div>
                                    </label>
                                </div> --}}
                                <div>
                                    {{-- <input type="checkbox" name="selection" class="toggle1" value="oui" onClick="Change()" id="oui">
                                    <span style="font-size: 28px;">Oui</span> --}}
                                    <label class="rad-label">
                                        <input name="selection" id="oui" value="oui" onClick="Change()" type="radio" class="rad-input" name="rad">
                                        <div class="rad-design"></div>
                                        <div class="rad-text">Oui</div>
                                    </label>
                                    <label class="rad-label">
                                        <input name="selection" id="oui" value="non" onClick="Change()" type="radio" class="rad-input" name="rad">
                                        <div class="rad-design"></div>
                                        <div class="rad-text">Non</div>
                                    </label>
                                    {{-- <input type="radio" name="selection" id="oui" value="oui" onClick="Change()" id="oui">
                                    <input type="radio" name="selection" id="oui" value="non" checked onClick="Change()" id="oui"> Non --}}
                                    <div id="rai" style="display:none;">
                                        <div class="form-group">
                                            <input name="nom" type="text" class="form-control form-control-lg" placeholder="Nom du transitaire">
                                            @error('nom')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input name="telephone" type="text" class="form-control form-control-lg" placeholder="Numéro téléphone">
                                            @error('telephone')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="continuer" class="btn btn-primary btn-block btn-lg">Continuer</button>
                            {{--  <a href="whatsapp://send?phone=+2250779851243&text=Par quel moyen de paiement souhaitez-vous recevoir l'argent de ma commande">lien</a>  --}}
                        </form>
                    </div>
                </div>
                {{-- @endif --}}
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script>
        var win;
        function openW() {
          win = window.open();
        }
        function closeW() {
          win.close();
        }
      </script>
</body>
</html>
