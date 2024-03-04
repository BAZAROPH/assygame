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
                <img src="{{ asset('assets/images/success.png') }}" alt="" class="img-fluid">
                {{-- <div class="mt-5 mb-2">
                    <button onclick="closeW()" class="btn btn-block btn-lg btn-primary">
                        Retour à l'accueil
                    </button>
                </div> --}}
                <div class="alert alert-info mt-5 text-center">
                    Cliquez sur <i class="icofont-home"></i> Pour aller à l'accueil
                </div>
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
            win = window.open("https://waytolearnx.com", "_blank", "width=900, height=786");
        }
        function closeW() {
            window.top.close();
        }
    </script>
</body>
</html>
