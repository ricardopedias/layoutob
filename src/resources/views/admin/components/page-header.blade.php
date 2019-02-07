
<div class="d-none">

    @foreach( Admin::getPageHeader()->getBreadcrumb()->getItems() as $item)

        <span class="js-meta-breadcrumb"
              data-href="{!! $item->getUrl() !!}"
              data-url="{!! $item->getUrlData() !!}"
              data-target="{{ $item->getUrlTarget() }}"
              data-class="{{ $item->getCssClass() }}"
              onclick="{{ $item->getClickEvent() }}">
              {!! $item->getIconHtml() !!}
              {!! $item->getLabel() !!}
        </span>

    @endforeach

    @if (Admin::getPageHeader()->getHelpUrl() != null)
        <span id="js-meta-help-url" data-url="{{ Admin::getPageHeader()->getHelpUrl() }}"></span>
    @endif

    @if (Admin::getPageHeader()->getRightInfo() != null)
        <span id="js-meta-right-info" data-content="{{ Admin::getPageHeader()->getRightInfo() }}"></span>
    @endif
</div>


<header class="page-header d-flex">

    <div class="mr-auto px-2 pt-2">
        <h1 class="mb-0 d-none d-md-block">{!! Admin::getPageHeader()->getTitle() !!}</h1>
        <h3 class="mb-0 d-block d-md-none">{!! Admin::getPageHeader()->getMobileTitle() !!}</h3>
    </div>

    <div class="px-2 pt-2">

        <div class="btn-group page-actions page-actions-large d-none d-md-flex" role="group" aria-label="Button group with nested dropdown">

            @foreach( Admin::getPageHeader()->getPageActions()->getItems() as $item )

                @if( $item->hasSubmenu() == false )

                    <a href="{!! $item->getUrl() !!}" data-url="{!! $item->getUrlData() !!}"
                       class="btn btn-secondary {{ $item->getCssClass() }}" target="{{ $item->getUrlTarget() }}"
                       onclick="{{ $item->getClickEvent() }}">
                            {!! $item->getIconHtml() !!}
                            {!! $item->getLabelHtml() !!}
                    </a>

                @else

                    <div class="btn-group" role="group">

                        <a href="javascript:void(0)" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {!! $item->getIconHtml() !!}
                            {!! $item->getLabelHtml() !!}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right">

                            @foreach($item->getSubmenu()->getItems() as $subitem)

                                <a href="{!! $subitem->getUrl() !!}" data-url="{!! $subitem->getUrlData() !!}"
                                   class="dropdown-item {{ $subitem->getCssClass() }}" target="{{ $subitem->getUrlTarget() }}"
                                   onclick="{{ $subitem->getClickEvent() }}">
                                    {!! $subitem->getIconHtml() !!}
                                    {!! $subitem->getLabelHtml() !!}
                                </a>

                            @endforeach

                        </div>
                    </div>

                @endif

            @endforeach

        </div>

        @if( Admin::getPageHeader()->getPageActions()->hasItems() == true )

            <div class="btn-group page-actions page-actions-mobile d-md-none" role="group">

                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">

                    @php $prev = 'item'; @endphp

                    @foreach( Admin::getPageHeader()->getPageActions()->getItems() as $item )

                        @if( $item->hasSubmenu() == false )

                            @if($prev == 'menu')
                                <div class="dropdown-divider"></div>
                            @endif

                            <a href="{!! $item->getUrl() !!}" data-url="{!! $item->getUrlData() !!}"
                               class="dropdown-item {{ $item->getCssClass() }}" target="{{ $item->getUrlTarget() }}"
                               onclick="{{ $item->getClickEvent() }}">
                                    {!! $item->getIconHtml() !!}
                                    {!! $item->getLabelHtml() !!}
                            </a>

                            @php $prev = 'item'; @endphp

                        @else

                            <div class="dropdown-divider"></div>

                            @foreach($item->getSubmenu()->getItems() as $subitem)

                                <a href="{!! $subitem->getUrl() !!}" data-url="{!! $subitem->getUrlData() !!}"
                                   class="dropdown-item {{ $subitem->getCssClass() }}" target="{{ $subitem->getUrlTarget() }}"
                                   onclick="{{ $subitem->getClickEvent() }}">
                                    {!! $subitem->getIconHtml() !!}
                                    {!! $subitem->getLabelHtml() !!}
                                </a>

                            @endforeach

                            @php $prev = 'menu'; @endphp

                        @endif

                    @endforeach

                    <!-- <a class="dropdown-item" href="#">Criar</a>
                    <a class="dropdown-item" href="#">Listar</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item active" href="#">Outras</a>
                    <a class="dropdown-item" href="#">Opcao 1</a>
                    <a class="dropdown-item" href="#">Opçao 2</a> -->

                </div>
            </div>
        @endif
    </div>

</header>

<!-- Mobile adiciona uma margem para ajustar -->
<div class="d-block d-md-none mt-3"></div>
