@component('layout-ui::auth.body-auth')

    <div class="d-flex h-100 align-items-center">

        <div class="container">

            <!-- Logo -->
            <div class="row justify-content-center auth-header login-header">
                <div class="col-md-8 text-center auth-header-box login-header-box">
                    <img src="{{ Authentication::getLogin()->getBrandingImg() }}">
                </div>
            </div>

            <!-- Formulário -->
            <div class="row justify-content-center auth-body login-body">
                <div class="col-md-8 auth-body-box login-body-box">
                    <div class="card">

                        <div class="card-header">
                            {{ __('layout-ui::auth.login-title') }}
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                @if (Authentication::getLogin()->hasContextField() == true)

                                    <div class="form-group row">
                                        <label for="context" class="col-sm-4 col-form-label text-md-right">
                                            {{ Authentication::getLogin()->getContextLabel() }}
                                        </label>

                                        <div class="col-md-6">
                                            <input id="context" type="text" class="form-control{{ $errors->has('context') ? ' is-invalid' : '' }}" name="context" value="{{ old('context') }}" autofocus>

                                            @if ($errors->has('context'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>
                                                        @if(preg_match('/auth\.|validation\./', $errors->first('context')))

                                                            {{--
                                                            se contiver uma string de indice, por ex: 'passwords.user',
                                                            deve buscar a tradução no pacote
                                                            --}}

                                                            @lang('layout-ui::' . $errors->first('context'), [
                                                                'attribute' => '"' . __('layout-ui::auth.login-context') . '"',
                                                            ])

                                                        @else

                                                            {{ $errors->first('context') }}

                                                        @endif

                                                    </strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                @endif

                                <div class="form-group row">
                                    <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('layout-ui::auth.login-email-address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>
                                                    @if(preg_match('/auth\.|validation\./', $errors->first('email')))

                                                        {{--
                                                        se contiver uma string de indice, por ex: 'passwords.user',
                                                        deve buscar a tradução no pacote
                                                        --}}

                                                        @lang('layout-ui::' . $errors->first('email'), [
                                                            'attribute' => '"' . __('layout-ui::auth.login-email-address') . '"',
                                                            'seconds' => config('layout-ui.login_decay_minutes')*60
                                                        ])

                                                    @else

                                                        {{ $errors->first('email') }}

                                                    @endif

                                                </strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('layout-ui::auth.login-password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="new-password">

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('layout-ui::auth.login-remember-me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('layout-ui::auth.login-submit') }}
                                        </button>

                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('layout-ui::auth.login-forgot-password') }}
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rodapé -->
            <div class="row justify-content-center auth-footer login-footer">
                <div class="col-md-8 text-center auth-footer-box login-footer-box">
                    {!! config('layout-ui.copyright') !!}
                </div>
            </div>

        </div>

    </div>

@endcomponent
