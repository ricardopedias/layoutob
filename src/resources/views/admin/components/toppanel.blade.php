<div id="js-toppanel" class="toppanel">

    <nav id="js-toppanel-breadcrumb" aria-label="breadcrumb" class="top-breadcrumb d-inline-block">

        @foreach( Admin::getPageHeader()->getBreadcrumb()->getItems() as $item)

            <a href="{!! $item->getUrl() !!}" data-url="{!! $item->getUrlData() !!}"
               class="{{ $item->getCssClass() }}" target="{{ $item->getUrlTarget() }}"
               onclick="{{ $item->getClickEvent() }}">
                {!! $item->getIconHtml() !!}
                {!! $item->getLabel() !!}
            </a>

        @endforeach

    </nav>

    @php
        $help_class = (Admin::getPageHeader()->getHelpUrl() != null) ? '' : 'd-none';
    @endphp

    <a id="js-toppanel-help" class="toppanel-help float-right {{ $help_class }}"
       aria-label="help" href="javascript:void(0);"
       title="Ajuda"
       data-url="{{ Admin::getPageHeader()->getHelpUrl() }}">
        <i class="fa fa-question-circle"></i>
    </a>

    @php
        $rightinfo_class = (Admin::getPageHeader()->getRightInfo() != null) ? '' : 'd-none';
    @endphp

    <span id="js-toppanel-info" class="toppanel-info float-right {{ $rightinfo_class }}">
        {!! Admin::getPageHeader()->getRightInfo() !!}
    </span>

</div>
