<?php

// app/Http/Controllers/SubscriptionController.php
namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;


class SubscriptionController extends Controller
{
    /**
     * Captura/elabora la suscripción para invitados y logueados.
     * - Garantiza 1 fila por email (upsert).
     * - Si está logueado, vincula user_id.
     * - Maneja confirmación opcional (doble opt-in).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email:rfc,dns'],
        ]);

        $email = mb_strtolower(trim($data['email']));

        // upsert por email
        $sub = NewsletterSubscription::updateOrCreate(
            ['email' => $email],
            [
                // si ya estaba confirmada, no tocamos esa bandera
                'subscribed_at'     => now(),
                'unsubscribed_at'   => null,        // re-activa si se había dado de baja
                'confirm_token'     => Str::random(40),
                'unsubscribe_token' => Str::random(40),
            ]
        );

        // Vincula user_id si está logueado y/o coincide el correo
        if (Auth::check()) {
            $user = Auth::user();

            // Si el email ingresado es el mismo del usuario, vinculamos
            if (strcasecmp($user->email, $email) === 0) {
                if (!$sub->user_id) {
                    $sub->user_id = $user->id;
                }
            }

            // Puedes decidir: auto-confirmar a usuarios logueados
            // (si NO quieres doble opt-in para ellos)
            $sub->confirmed = true;
            $sub->save();

            return back()->with('status', '¡Suscripción activada!');
        }

        // Invitado: aquí decides si haces doble opt-in (enviar email con confirm link)
        // Si quieres omitir doble opt-in, puedes marcar confirmed=true directamente.
        // Por defecto dejémoslo en false y pedimos confirmación.
        // -> Envía correo (mailable) con route('subscribe.confirm', $sub->confirm_token) (no implementado aquí)
        return back()->with('status', 'Revisa tu correo para confirmar la suscripción.');
    }

    /**
     * Confirma suscripción (doble opt-in).
     */
    public function confirm(string $token)
    {
        $sub = NewsletterSubscription::where('confirm_token', $token)->first();

        if (!$sub) {
            return redirect('/')->with('status', 'Token inválido o expirado.');
        }

        $sub->confirmed = true;
        $sub->confirm_token = null; // quemamos el token
        $sub->save();

        return redirect('/')->with('status', '¡Suscripción confirmada!');
    }

    /**
     * Baja con token.
     */
    public function unsubscribe(string $token)
    {
        $sub = NewsletterSubscription::where('unsubscribe_token', $token)->first();

        if (!$sub) {
            return redirect('/')->with('status', 'Token inválido o ya dado de baja.');
        }

        $sub->unsubscribed_at = now();
        $sub->save();

        return redirect('/')->with('status', 'Has sido dado de baja del boletín.');
    }


  public function showSubscribers(Request $request)
    {
        $q = trim((string)$request->get('q', ''));

        $subs = NewsletterSubscription::query()
            ->with('user:id,name,email') // por si está vinculado a un usuario
            ->when($q, function ($query) use ($q) {
                $query->where(function ($s) use ($q) {
                    $s->where('email', 'like', "%{$q}%")
                      ->orWhereHas('user', function ($u) use ($q) {
                          $u->where('name', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%");
                      });
                });
            })
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        return view('dashboard.subscriptions.index', compact('subs', 'q'));
    }

    /**
     * GET /admin/users
     * Lista todos los usuarios con indicador de suscripción.
     */
    public function showAllUsers(Request $request)
    {
        $q = trim((string)$request->get('q', ''));

        $users = User::query()
            ->with(['newsletterSubscription' => function ($s) {
                $s->select('id','user_id','email','confirmed','subscribed_at','unsubscribed_at');
            }])
            ->when($q, function ($query) use ($q) {
                $query->where(function ($u) use ($q) {
                    $u->where('name', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        return view('dashboard.users.index', compact('users', 'q'));
    }

    /**
     * POST /admin/subscription/toggle/{user}
     * Activa/Desactiva la suscripción del usuario.
     */
    public function toggleSubscription(User $user)
    {
        // upsert por email
        $sub = NewsletterSubscription::firstOrNew(['email' => $user->email]);
        if (!$sub->exists) {
            $sub->user_id        = $user->id;
            $sub->confirmed      = true;
            $sub->subscribed_at  = now();
            $sub->unsubscribed_at = null;
            $sub->save();

            return back()->with('status', "Suscripción activada para {$user->email}");
        }

        // Si está dado de baja -> reactivar
        if (!is_null($sub->unsubscribed_at)) {
            $sub->user_id         = $user->id;     // vincula por si no lo estaba
            $sub->confirmed       = true;
            $sub->unsubscribed_at = null;
            if (is_null($sub->subscribed_at)) {
                $sub->subscribed_at = now();
            }
            $sub->save();

            return back()->with('status', "Suscripción reactivada para {$user->email}");
        }

        // Si está activa -> dar de baja
        $sub->unsubscribed_at = now();
        $sub->save();

        return back()->with('status', "Suscripción desactivada para {$user->email}");
    }

    /**
     * DELETE /admin/user/{user}
     * Elimina un usuario y maneja su suscripción asociada.
     */
    public function deleteUser(User $user)
    {
        DB::transaction(function () use ($user) {
            // Opcional: dar de baja su suscripción (si quieres borrarla, usa ->delete())
            NewsletterSubscription::where('email', $user->email)
                ->update(['unsubscribed_at' => now()]);

            // Elimina el usuario (si usas soft deletes, cámbialo a $user->delete();)
            $user->forceDelete();
        });

        return back()->with('status', "Usuario {$user->email} eliminado.");
    }
    
}