<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    


    private function validateContact(Request $request)
    {
        return $request->validate([
            'nome' => ['required', 'string', 'min:1'],
            'email' => ['required', 'email', 'min:1'],
            'oggetto' => ['required', 'string', 'min:1'],
            'messaggio' => ['required', 'string', 'min:1'],
        ], [
            'nome.required' => 'Il nome è obbligatorio.',
            'nome.string' => 'Il nome deve essere un testo valido.',
            'nome.min' => 'Il nome deve contenere almeno un carattere.',

            'email.required' => 'L\'email è obbligatoria.',
            'email.email' => 'Inserisci un indirizzo email valido.',
            'email.min' => 'L\'email deve contenere almeno un carattere.',

            'oggetto.required' => 'L\'oggetto è obbligatorio.',
            'oggetto.string' => 'L\'oggetto deve essere un testo valido.',
            'oggetto.min' => 'L\'oggetto deve contenere almeno un carattere.',

            'messaggio.required' => 'Il messaggio è obbligatorio.',
            'messaggio.string' => 'Il messaggio deve essere un testo valido.',
            'messaggio.min' => 'Il messaggio deve contenere almeno un carattere.',
        ]);
    }

    public function send(Request $request)
    {
        $data = $this->validateContact($request);

        Mail::to('ferrariluca2002@gmail.com')->send(new ContactMail($data));

        return back()->with('success', 'Messaggio inviato con successo!');
    }

}

