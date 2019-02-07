
    <div id="js-sidemenu-minimize" class="sidemenu-minimize"></div>

    <div id="js-sidemenu-touch" class="sidemenu-touch"></div>

    <nav id="js-sidemenu" class="sidemenu">

        {{--
        <div class="sidemenu-profile">
            <img src="https://avatars3.githubusercontent.com/u/27714431?s=460&v=4">
            <a href="#">Ricardo Pereira Dias</a>
        </div>
        --}}

        @foreach( Admin::getSidebar()->getMenu()->getItems() as $item )

            <a href="{!! $item->getUrl() !!}" data-url="{!! $item->getUrlData() !!}"
               class="{{ $item->getCssClass() }}" target="{{ $item->getUrlTarget() }}"
               onclick="{{ $item->getClickEvent() }}">
                @if( empty($item->getIcon()) )
                    <span class="no-icon"><i class="fas fa-ellipsis-h"></i></span>
                @else
                    {!! $item->getIconHtml() !!}
                @endif
                {!! $item->getLabelHtml() !!}
            </a>

            @if( $item->hasSubmenu() )

                <div class="sidemenu-sub">
                    @foreach($item->getSubmenu()->getItems() as $subitem)

                        <a href="{!! $subitem->getUrl() !!}" data-url="{!! $subitem->getUrlData() !!}"
                           class="{{ $subitem->getCssClass() }}" target="{{ $subitem->getUrlTarget() }}"
                           onclick="{{ $subitem->getClickEvent() }}">
                            {!! $subitem->getIconHtml() !!}
                            {!! $subitem->getLabelHtml() !!}
                        </a>

                    @endforeach
                </div>

            @endif

        @endforeach

        {{--
        <div class="sidemenu-status">

            <a href="#">Termos de Uso</a>
            <a href="#">Política de Privacidade</a>
            <a href="#" class="copy">rpdesignerfly © 2018</a>

        </div>
        --}}

    </nav>
