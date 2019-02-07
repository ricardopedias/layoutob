
<div id="js-mainloader-panel-backdrop" class="mainloader panel-backdrop">

    @php $mainloader = 'circle'; @endphp

    <!-- Cubos -->
    @if($mainloader == 'cube')
        @include('layout-ui::admin.components.loader-cube')
    @elseif($mainloader == 'cube-construct')
        @include('layout-ui::admin.components.loader-cube-construct')

    <!-- Blocos -->
    @elseif($mainloader == 'box')
        @include('layout-ui::admin.components.loader-box')
    @elseif($mainloader == 'box-orbit')
        @include('layout-ui::admin.components.loader-box-orbit')
    @elseif($mainloader == 'box-progress')
        @include('layout-ui::admin.components.loader-box-progress')

    <!-- Círculos -->
    @elseif($mainloader == 'circle')
        @include('layout-ui::admin.components.loader-circle')
    @elseif($mainloader == 'circle-orbit')
        @include('layout-ui::admin.components.loader-circle-orbit')
    @elseif($mainloader == 'circle-pulse')
        @include('layout-ui::admin.components.loader-circle-pulse')
    @elseif($mainloader == 'circle-progress')
        @include('layout-ui::admin.components.loader-circle-progress')
    @endif

</div>
