@if (Cookie::get('homASS'))
    @include('web.layouts.menu-mobile')
    <!-- Back To Top Button-->
    <a class="btn-scroll-top" href="#top" data-scroll>
        <span class="btn-scroll-top-tooltip text-muted font-size-sm mr-2">Top</span>
        <i class="btn-scroll-top-icon czi-arrow-up"></i>
    </a>
@endif
<div id="preloader"></div>
