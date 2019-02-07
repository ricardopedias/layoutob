
@include('layout-ui::admin.components.page-header')

@component('layout-ui::admin.components.page-form')

    @inject('user', '\LayoutUI\Models\User')

    @php

        if (\Admin::getForm()->isUpdate() == true) {
            $user_model = \LayoutUI\Models\User::find(request()->id);
        }

    @endphp


    <div class="row">

        <div class="form-group col">
            <label for="{{ field_name('name') }}">Nome da pessoa <i class="fa fa-asterisk text-danger"></i></label>
            <input type="text" id="{{ field_name('name') }}" name="{{ field_name('name') }}" value="{{ field_value('name') }}"
                   class="form-control " placeholder="Digite um nome pessoal"
                   aria-describedby="{{ field_name('name') }}-help"
                   >
            <small id="{{ field_name('name') }}-help" class="form-text text-muted"></small>
        </div>

        <div class="w-100 d-md-none"></div>

        <div class="form-group col">
            <label for="{{ field_name('email') }}">Email</label>
            <input type="text" id="{{ field_name('email') }}" name="{{ field_name('email') }}" value="{{ field_value('email') }}"
                   class="form-control " placeholder="Digite uma palavra"
                   aria-describedby="{{ field_name('email') }}-help"
                   >
            <small id="{{ field_name('email') }}-help" class="form-text text-muted"></small>
        </div>

        <div class="w-100"></div>

        <div class="form-group col">
            <label for="{{ field_name('password') }}">Senha</label>
            <input type="password" id="{{ field_name('password') }}" name="{{ field_name('password') }}"
                   class="form-control "
                   aria-describedby="{{ field_name('password') }}-help"
                   >
            <small id="{{ field_name('password') }}-help" class="form-text text-muted"></small>
        </div>

        <div class="w-100 d-md-none"></div>

        <div class="form-group col">
            <label for="{{ field_name('password_confirmation') }}">Validar Senha</label>
            <input type="password" id="{{ field_name('password_confirmation') }}" name="{{ field_name('password_confirmation') }}"
                   class="form-control "
                   aria-describedby="{{ field_name('password_confirmation') }}-help"
                   >
            <small id="{{ field_name('password_confirmation') }}-help" class="form-text text-muted"></small>
        </div>

    </div>

    <button type="submit" class="btn btn-primary">{{ __('layout-ui::crud.form-save') }}</button>

@endcomponent
