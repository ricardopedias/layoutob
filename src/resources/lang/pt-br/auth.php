<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'Essas credenciais não correspondem aos nossos registros.',
    'failed_context' => 'Esse contexto é inválido nestas credenciais.',
    'throttle' => 'Muitas tentativas de login. Tente novamente em :seconds segundos.',

    // Formulário de Login
    'login-title'                  => 'Login',
    'login-context'                => 'ID',
    'login-email-address'          => 'E-mail',
    'login-password'               => 'Senha',
    'login-remember-me'            => 'Manter Conectado',
    'login-submit'                 => 'Entrar',
    'login-forgot-password'        => 'Esqueceu sua senha?',

    // Formulário de recuperaçãio de senha
    'password-reset-title'         => 'Redefinir senha',
    'password-reset-email-address' => 'Endereço de e-mail',
    'password-reset-password'      => 'Senha',
    'password-reset-confirm'       => 'Confirme a Senha',
    'password-reset-submit'        => 'Enviar link para redefinir a senha',
    'password-reset-reset'         => 'Redefinir Senha',

    // Email de recuperação de senha
    'password-reset-email-subject'    => 'Notificação de Redefinição de Senha',
    'password-reset-email-greeting'   => 'Olá',
    'password-reset-email-greeting-error'   => 'Ooooops!',
    'password-reset-email-message'    => 'Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.',
    'password-reset-email-submit'     => 'Redefinir Senha',
    'password-reset-email-alert'      => 'Se você não solicitou uma redefinição de senha, nenhuma ação adicional é necessária.',
    'password-reset-email-salutation' => "Saudações",
    'password-reset-email-problems'   => "Se você está tendo problemas para clicar no botão \":actionText\", copie e cole o URL abaixo\n".
                                         'em seu navegador: [:actionURL](:actionURL)',
    'password-reset-email-copyright'  => 'Todos os direitos reservados'
];
