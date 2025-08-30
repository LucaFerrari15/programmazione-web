<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCartNotEmpty
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user || $user->cartItems()->count() === 0) {
            return response()
                ->view('errors.genericError', [
                    'error_name' => "Carrello vuoto",
                    'spiegazione' => "Impossibile effettuare il pagamento se non si hanno item nel carrello!"
                ], 403);

        }

        return $next($request);
    }
}
