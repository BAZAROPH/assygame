<div class="cz-carousel cz-dots-disable cz-dots-inside cz-dots-light">
    <div class="cz-carousel-inner" data-carousel-options='{
        "mode": "gallery",
        "speed": 1000,
        "controls": false,
        "autoplay": true,
        "autoplayTimeout": 5000
    }'>
        @foreach ($sliders as $item)
            <div>
                @if(!empty($item->getMedia('image')->first()))
                    <img class="img-fluid" src="{{ url($item->getMedia('image')->first()->getUrl()) }}" alt="Assygamé">
                @endif
            </div>
        @endforeach
    </div>
</div>
