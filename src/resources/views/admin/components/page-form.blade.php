
@php $uid = uniqid('page-form-'); @endphp

<div id="js-{{ $uid }}"
     class="page-form mx-2 mt-2"
     data-front="{{ Admin::getForm()->getDataFront() }}"
     data-action="{{ Admin::getForm()->getDataAction() }}"
     data-key-field="{{ Admin::getForm()->getKeyField()  }}"
     data-key-value="{{ Admin::getForm()->getKeyValue()  }}"
     data-js-status="valid"
     data-db-status="valid"
     data-generic-error-message="{{ __('layout-ui::crud.form-error') }}"
     data-generic-exception-message="{{ __('layout-ui::crud.form-exception') }}"
     data-generic-created-message="{{ __('layout-ui::crud.form-created') }}"
     data-generic-updated-message="{{ __('layout-ui::crud.form-updated') }}"
     >

     <div class="d-none">

         <!-- Mensagens e status das validações -->

         <span id="js-validation-ok" class="js-validation">@lang('layout-ui::validation.accepted')</span>

         @foreach(Admin::getForm()->getAvailableValidations() as $item)
            <span id="js-validation-{{ str_replace('.', '-', $item->validation) }}" class="js-validation">{{ $item->message }}</span>
         @endforeach

         <!-- Informações sobre os campos do formulário -->

         @foreach(Admin::getForm()->getFields() as $field => $item)
            <div id="js-{{ $field }}" class="js-field" data-name="{{ $field }}" data-status="valid" data-label="{{ $item->label }}">
                @foreach($item->constraints as $param => $value)
                    <span class="{{ str_replace('.', '-', $param) }}" data-value="{{ $value }}"></span>
                @endforeach
            </div>
         @endforeach

     </div>

     <form action="javascript:void(0);" onsubmit="return false;">

         @csrf

         <div class="card">
             <div id="js-{{ $uid }}-alert" class="card-header d-none">

                 <div class="form-alert form-danger">
                     <i class="fa fa-times"></i>
                     <span>Esse formulário contém erros</span>
                 </div>

                 <div class="form-alert form-warning">
                     <i class="fa fa-exclamation-triangle"></i>
                     <span>Esse formulário contém erros</span>
                 </div>

                 <div class="form-alert form-info">
                     <i class="fa fa-info"></i>
                     <span>Esse formulário contém erros</span>
                 </div>

                 <div class="form-alert form-success">
                     <i class="fa fa-check"></i>
                     <span>Esse formulário está ok</span>
                 </div>

             </div>

             <div class="card-body">

                 {!! $slot !!}

            </div>
        </div>

    </form>

</div>
