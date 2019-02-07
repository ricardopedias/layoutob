@component('layout-ui::auth.body-auth')

    <div class="d-flex h-100 align-items-center">

        <div class="container">

            <!-- Logo -->
            <div class="row justify-content-center auth-header reset-header">
                <div class="col-md-8 text-center auth-header-box reset-header-box">
                    <img src="{{ Authentication::getLogin()->getBrandingImg() }}">
                </div>
            </div>

            <!-- Formulário -->
            <div class="row justify-content-center auth-body reset-body">
                <div class="col-md-8 auth-body-box reset-body-box">
                    <div class="card">
                        <div class="card-header">
                            {{ __('layout-ui::auth.password-reset-title') }}
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('password.update') }}">

                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">
                                        {{ __('layout-ui::auth.password-reset-email-address') }}
                                    </label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>
                                                    @if(preg_match('/passwords\.|validation\./', $errors->first('email')))

                                                        {{--
                                                        se contiver uma string de indice, por ex: 'passwords.user',
                                                        deve buscar a tradução no pacote
                                                        --}}

                                                        @lang('layout-ui::' . $errors->first('email'), [
                                                            'attribute' => '"' . __('layout-ui::auth.password-reset-email-address') . '"'
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
                                    <label for="password" class="col-md-4 col-form-label text-md-right">
                                        {{ __('layout-ui::auth.password-reset-password') }}
                                    </label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>
                                                    @if(preg_match('/passwords\.|validation\./', $errors->first('password')))

                                                        {{--
                                                        se contiver uma string de indice, por ex: 'passwords.user',
                                                        deve buscar a tradução no pacote
                                                        --}}

                                                        @lang('layout-ui::' . $errors->first('password'), [
                                                            'attribute' => '"' . __('layout-ui::auth.password-reset-password') . '"',
                                                            'min' => $password_min
                                                        ])

                                                    @else
                                                        {{ $errors->first('password') }}
                                                    @endif
                                                </strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">
                                        {{ __('layout-ui::auth.password-reset-confirm') }}
                                    </label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('layout-ui::auth.password-reset-reset') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rodapé -->
            <div class="row justify-content-center auth-footer reset-footer">
                <div class="col-md-8 text-center auth-footer-box reset-footer-box">
                    {!! config('layout-ui.copyright') !!}
                </div>
            </div>

        </div>

    </div>

@endcomponent
