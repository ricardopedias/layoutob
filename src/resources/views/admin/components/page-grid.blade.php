
@php $uid = uniqid('page-grid-'); @endphp

<div id="js-{{ $uid }}"
     class="page-grid {{ Admin::getDatagrid()->getGridCssClass() }} mx-2 mt-2"
     data-provider="{{ Admin::getDatagrid()->getDataProvider() }}"
     @if(Admin::getDatagrid()->hasColumnID() == true)
        data-column-id="{{ Admin::getDatagrid()->getColumnID()->masked_column  }}"
        data-column-alias-id="{{ Admin::getDatagrid()->getColumnAliasID()  }}"
     @endif
     @if(Admin::getDatagrid()->showColumnID() == true)
        data-column-id-show="yes"
     @else
        data-column-id-show="no"
     @endif
     >

    <div class="page-grid-control pt-2 pr-2 pl-2">

        <div class="btn-group float-right page-grid-registers">
            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="d-none d-md-inline">Exibindo </span>25 itens
            </button>

            <div class="dropdown-menu dropdown-menu-right" style="width: 80px; min-width: 80px;">
                <button class="dropdown-item" type="button" data-limit="5">5</button>
                <button class="dropdown-item" type="button" data-limit="10">10</button>
                <button class="dropdown-item active" type="button" data-limit="25">25</button>
                <button class="dropdown-item" type="button" data-limit="50">50</button>
                <button class="dropdown-item" type="button" data-limit="100">100</button>
            </div>
        </div>

        <div class="page-grid-search">
            <div class="input-group input-group-sm ">
                <input type="text" class="form-control page-grid-search-input" placeholder="Buscar..." aria-label="Buscar..." aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-secondary page-grid-search-submit" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

    </div>

    <div class="page-grid-wrapper">

        <div class="page-grid-scroller">

            <table>

                <thead>
                    <tr>

                        @if(Admin::getDatagrid()->hasBulkActions() == true)
                            <th class="page-grid-check">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input" id="customCheck-0">
                                  <label class="custom-control-label" for="customCheck-0"></label>
                                </div>
                            </th>
                        @endif

                        @if(Admin::getDatagrid()->showColumnID() == true)
                            <th class="page-grid-col {{ Admin::getDatagrid()->getColumnID()->css_class }}"
                                data-id="{{ Admin::getDatagrid()->getColumnID()->masked_column }}"
                                {{ (Admin::getDatagrid()->getColumnID()->show == false) ? 'style="display: none;"' : '' }}
                                >
                                @if(Admin::getDatagrid()->getColumnID()->orderable == true)
                                <i></i>
                                @endif
                                <span>{{ Admin::getDatagrid()->getColumnID()->label }}</span>
                            </th>
                        @endif

                        @foreach(Admin::getDatagrid()->getColumns() as $id_column => $item)
                            <th class="page-grid-col {{ $item->css_class }}" data-id="{{ $id_column }}">
                                @if($item->orderable == true)
                                <i></i>
                                @endif
                                <span>{{ $item->label }}</span>
                            </th>
                        @endforeach

                        @if(Admin::getDatagrid()->hasActions() == true)
                            <th class="page-grid-actions text-center">Ações</th>
                        @endif

                    </tr>
                </thead>

                <tbody>

                    <tr style="display: none" class="page-grid-row-template">

                        @if(Admin::getDatagrid()->hasBulkActions() == true)
                            <td class="page-grid-check page-grid-sticky">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input" id="customCheck-__ID__">
                                  <label class="custom-control-label" for="customCheck-__ID__"></label>
                                </div>
                            </td>
                        @endif

                        @if(Admin::getDatagrid()->showColumnID() == true)
                            <td class="{{ Admin::getDatagrid()->getColumnID()->css_class }} text-center" data-id="{{ Admin::getDatagrid()->getColumnID()->masked_column }}"><span>0</span></td>
                        @endif

                        @foreach(Admin::getDatagrid()->getColumns() as $id_column => $item)
                            <td class="{{ $item->css_class }}" data-id="{{ $id_column }}"><span></span></td>
                        @endforeach

                        @if(Admin::getDatagrid()->hasActions() == true)

                            <td class="page-grid-actions">

                                @foreach(Admin::getDatagrid()->getActions()->getItems() as $item)

                                    @php $func_name = 'page_grid_action_click_' . uniqid(); @endphp

                                    <div>
                                        <a href="{!! $item->getUrl() !!}"
                                           data-url="{!! $item->getUrlData() !!}"
                                           data-id=""
                                           data-function="{{ $func_name }}"
                                           data-delete-url="{{ $item->getDeleteUrl() }}"
                                           target="{{ $item->getUrlTarget() }}" title="{{ $item->getLabel() }}"
                                           class="{{ ($item->getJavascript() != null ? 'page-grid-action-javascript' : '') }} {{ ($item->getDeleteKey() != null ? 'page-grid-action-delete' : '') }}"
                                           >
                                            @if( empty($item->getIcon()) == false )
                                                {!! $item->getIconHtml() !!}
                                            @else
                                                <i class="fa fa-cog"></i>
                                            @endif
                                        </a>

                                        @if($item->getDeleteKey() !== null)

                                            <script>
                                                function {{ $func_name }}_delete(el){
                                                    var id  = $(el).data('id');
                                                    var url = $(el).data('delete-url');
                                                    Admin.deleteConfirm('{{ $item->getDeleteKey() }}', id, url, '{{ csrf_token() }}', function(){
                                                        PageGrid.callDataProvider();
                                                    });
                                                }
                                            </script>

                                        @endif

                                        @if($item->getJavascript() !== null)

                                            <script>
                                                function {{ $func_name }}(el){
                                                    {!! $item->getJavascript(); !!}
                                                }
                                            </script>

                                        @endif
                                    </div>

                                @endforeach

                                <div class="btn-group dropleft page-grid-actions-mobile" role="group">

                                    <a href="javascript:void(0)" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-cog"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right">

                                        @foreach(Admin::getDatagrid()->getActions()->getItems() as $item)

                                            @php
                                                $js_id = 'js-page-grid-action-' . uniqid();
                                            @endphp

                                            <a href="{!! $item->getUrl() !!}" id="{{ $js_id }}"
                                               data-url="{!! $item->getUrlData() !!}"
                                               target="{{ $item->getUrlTarget() }}" class="dropdown-item">

                                               @if( empty($item->getIcon()) == false )
                                                   {!! $item->getIconHtml() !!}
                                               @endif
                                               {!! $item->getLabel() !!}

                                            </a>

                                            @if($item->getJavascript() !== null)

                                                @php $func_name = 'page_grid_action_click_' . uniqid(); @endphp

                                                <script>

                                                    function {{ $func_name }}(){
                                                        {!! $item->getJavascript(); !!}
                                                    }
                                                    document.getElementById('{{ $js_id }}').addEventListener('click', function(){ {{ $func_name }}(this); });

                                                </script>

                                            @endif

                                        @endforeach

                                    </div>
                                </div>

                            </td>

                        @endif

                    </tr>

                </tbody>

            </table>
        </div>
    </div>
</div>

<div class="page-grid-bottom pt-2 pr-2 pl-2 text-center text-md-left">

    <nav id="js-{{ $uid }}-pagination" class="page-grid-pagination mx-2 mt-3 float-md-right d-inline-block" aria-label="Paginação">
        <ul class="pagination">

            <li class="page-item page-item-prev">
                <a class="page-link" href="javascript:void(0);" aria-label="Anterior">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Anterior</span>
                </a>
            </li>

            <li class="page-item page-item-first">
                <a class="page-link" href="javascript:void(0);" data-page="1">1 ...</a>
            </li>

            <li class="page-item page-item-0" style="display: none;">
                <a class="page-link" href="javascript:void(0);">1</a>
            </li>

            <li class="page-item page-item-1" style="display: none;">
                <a class="page-link" href="javascript:void(0);">2</a>
            </li>

            <li class="page-item page-item-2" style="display: none;">
                <a class="page-link" href="javascript:void(0);">3</a>
            </li>

            <li class="page-item page-item-3" style="display: none;">
                <a class="page-link" href="javascript:void(0);">4</a>
            </li>

            <li class="page-item page-item-4" style="display: none;">
                <a class="page-link" href="javascript:void(0);">5</a>
            </li>

            <li class="page-item page-item-last">
                <a class="page-link" href="javascript:void(0);">... 8</a>
            </li>

            <li class="page-item page-item-next">
                <a class="page-link" href="javascript:void(0);" aria-label="Próxima">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Próxima</span>
                </a>
            </li>

        </ul>
    </nav>

    <div class="w-100"></div>

    <div id="js-{{ $uid }}-info" class="page-grid-info mx-2 mt-md-4">
        Não há informações para exibir
    </div>

    <div class="clearfix"></div>

</div>
