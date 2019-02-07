<?php
namespace LayoutUI\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use LayoutUI\Notifications\ResetPassword;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getContext()
    {
        // Tenta encontrar o contexto na sessão
        $context_from_session = session('login_context', null);
        if ($context_from_session != null) {
            return $context_from_session;
        }

        // Busca o contexto no cache
        $context_key = 'user_' . $this->id . '_context';
        if (\Cache::has($context_key) == true) {
            $context = \Cache::get($context_key, null);

            // Armazena na sessão para evitar consulta em disco
            session(['login_context' => $context]);

            return $context;
        }

        // O contexto não está presente
        return null;
    }

    /**
     * Método sobrescrito para personalizar o objeto responsável
     * pelo envio da redefinição de senha.
     *
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
