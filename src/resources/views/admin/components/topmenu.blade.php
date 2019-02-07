    <header class="topmenu">

        <div id="js-mobile-menu" class="mobile icon">
            <i class="fas fa-bars"></i>
        </div>

        <a class="branding" href="#">
            <img src="{{ Admin::getTopbar()->getBrandingImg() }}">
        </a>

        <nav>

            {{-- Ícones --}}

            @foreach(Admin::getTopbar()->getRightIcons()->getItems() as $item)

                <a href="{!! $item->getUrl() !!}" data-url="{!! $item->getUrlData() !!}"
                   class="icon {{ $item->getCssClass() }}" target="{{ $item->getUrlTarget() }}"
                   onclick="{{ $item->getClickEvent() }}">
                    {!! $item->getIconHtml() !!}
                    {!! $item->getLabelHtml() !!}
                </a>

            @endforeach

            <a id="js-profile-button" class="icon profile-icon" href="javascript:void(0)">
                <img src="{{ Admin::getTopbar()->getProfileImg() }}">
            </a>

        </nav>

        <div id="js-profile-menu" class="profile-menu d-none">

            {{-- Menu do Perfil --}}

            @foreach(Admin::getTopbar()->getProfileMenu()->getItems() as $item)

                <a href="{!! $item->getUrl() !!}" data-url="{!! $item->getUrlData() !!}"
                   class="{{ $item->getCssClass() }}" target="{{ $item->getUrlTarget() }}"
                   onclick="{{ $item->getClickEvent() }}">
                    {!! $item->getIconHtml() !!}
                    {!! $item->getLabel() !!}
                </a>

            @endforeach

            <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out-alt"></i>
                Sair do Sistema
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

        </div>

    </header>
