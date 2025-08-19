<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|min:1',
            'cognome' => 'required|string|min:1',
            'email' => 'required|email|min:1',
            'oggetto' => 'required|string|min:1',
            'messaggio' => 'required|string|min:1',
        ]);

        Mail::to(users: 'ferrariluca2002@gmail.com')->send(new ContactMail($data));

        return back()->with('success', 'Messaggio inviato con successo!');
    }
}

