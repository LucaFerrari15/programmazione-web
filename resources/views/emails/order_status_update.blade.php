<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Aggiornamento Ordine #{{ $order->id }}</title>
</head>

<body style="margin:0; padding:20px; background-color:#f8f9fa; font-family:Arial,sans-serif;">

    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
        style="max-width:600px; border-radius:8px; overflow:hidden; border:1px solid #ddd; background-color:#ffffff;">

        <!-- Header -->
        <tr>
            <td align="center"
                style="color:#ffffff; font-size:24px; font-weight:bold; padding:30px;
                @if ($newStatus === 'pending') background-color:#ffc107;
                @elseif($newStatus === 'shipped') background-color:#007bff;
                @elseif($newStatus === 'completed') background-color:#28a745;
                @elseif($newStatus === 'cancelled') background-color:#dc3545;
                @else background-color:#6c757d; @endif
            ">
                @if ($newStatus === 'pending')
                    ⏳ Ordine in Attesa di Conferma Reso
                @elseif($newStatus === 'shipped')
                    🚚 Ordine Spedito!
                @elseif($newStatus === 'completed')
                    ✅ Ordine Completato!
                @elseif($newStatus === 'cancelled')
                    ❌ Ordine Annullato
                @else
                    📋 Aggiornamento Ordine
                @endif
            </td>
        </tr>

        <!-- Intro -->
        <tr>
            <td style="padding:30px; color:#333333; font-size:16px; line-height:1.6;">
                <p style="margin:0 0 20px 0;">Ciao <strong>{{ $order->user->name }}</strong>,</p>

                @if ($newStatus === 'pending')
                    <p style="margin:0 0 20px 0;">Il tuo ordine è in attesa: stiamo aspettando che un amministratore
                        confermi la tua richiesta di reso. Ti aggiorneremo appena ci saranno novità.</p>
                @elseif($newStatus === 'shipped')
                    <p style="margin:0 0 20px 0;">Il tuo ordine è stato spedito! I tuoi articoli sono ora in viaggio
                        verso di te.</p>
                @elseif($newStatus === 'completed')
                    <p style="margin:0 0 20px 0;">Il tuo ordine è stato completato! Speriamo che tu sia soddisfatto del
                        tuo acquisto.</p>
                @elseif($newStatus === 'cancelled')
                    <p style="margin:0 0 20px 0;">Il tuo ordine è stato annullato. Se hai domande, non esitare a
                        contattarci.</p>
                @endif

                <div
                    style="background-color:#e3f2fd; padding:20px; border-radius:8px; border-left:4px solid #2196f3; margin:20px 0;">
                    <h3 style="margin:0 0 10px 0; color:#1976d2;">📋 Dettagli Ordine</h3>
                    <p style="margin:5px 0;"><strong>Numero Ordine:</strong> #{{ $order->id }}</p>
                    <p style="margin:5px 0;"><strong>Data:</strong> {{ $order->dataDiCreazioneOrdineFormattata() }}</p>
                    <p style="margin:5px 0;"><strong>Stato Ordine:</strong>
                        <span
                            style="
                            @if ($newStatus === 'pending') color:#ffc107;
                            @elseif($newStatus === 'shipped') color:#007bff;
                            @elseif($newStatus === 'completed') color:#28a745;
                            @elseif($newStatus === 'cancelled') color:#dc3545;
                            @else color:#6c757d; @endif
                            font-weight:bold;
                        ">{{ ucfirst($newStatus) }}</span>
                    </p>
                    <p style="margin:5px 0;"><strong>Totale:</strong> <span style="font-size:18px; font-weight:bold;">
                            €{{ number_format($order->total, 2) }}</span></p>
                </div>
            </td>
        </tr>

        <!-- Status Info -->
        <tr>
            <td style="padding:0 30px 30px 30px;">
                @if ($newStatus === 'pending')
                    <div
                        style="background-color:#fff3cd; padding:20px; border-radius:8px; border-left:4px solid #ffc107;">
                        <h4 style="margin:0 0 10px 0; color:#856404;">⏳ In Attesa di Conferma</h4>
                        <ul style="margin:0; padding-left:20px; color:#856404;">
                            <li style="margin-bottom:8px;">La tua richiesta di reso è stata registrata</li>
                            <li style="margin-bottom:8px;">Un amministratore verificherà la tua richiesta</li>
                            <li style="margin-bottom:8px;">Riceverai un aggiornamento appena sarà confermata</li>
                        </ul>
                    </div>
                @elseif($newStatus === 'shipped')
                    <div
                        style="background-color:#cce5ff; padding:20px; border-radius:8px; border-left:4px solid #007bff;">
                        <h4 style="margin:0 0 10px 0; color:#004085;">🚚 Il tuo pacco è in arrivo!</h4>
                        <ul style="margin:0; padding-left:20px; color:#004085;">
                            <li style="margin-bottom:8px;">I tuoi articoli sono stati spediti</li>
                            <li style="margin-bottom:8px;">Riceverai il pacco entro 2-5 giorni lavorativi</li>
                            <li style="margin-bottom:8px;">Controlla la tua email per i dettagli di tracciamento</li>
                        </ul>
                    </div>
                @elseif($newStatus === 'completed')
                    <div
                        style="background-color:#d4edda; padding:20px; border-radius:8px; border-left:4px solid #28a745;">
                        <h4 style="margin:0 0 10px 0; color:#155724;">✅ Grazie per il tuo acquisto!</h4>
                        <ul style="margin:0; padding-left:20px; color:#155724;">
                            <li style="margin-bottom:8px;">Il tuo ordine è stato completato con successo</li>
                            <li style="margin-bottom:8px;">Hai 14 giorni per eventuali resi</li>

                        </ul>
                    </div>
                @elseif($newStatus === 'cancelled')
                    <div
                        style="background-color:#f8d7da; padding:20px; border-radius:8px; border-left:4px solid #dc3545;">
                        <h4 style="margin:0 0 10px 0; color:#721c24;">❌ Ordine Annullato</h4>
                        <ul style="margin:0; padding-left:20px; color:#721c24;">
                            <li style="margin-bottom:8px;">Il tuo ordine è stato annullato</li>
                            <li style="margin-bottom:8px;">Se hai effettuato un pagamento, sarà rimborsato</li>
                            <li style="margin-bottom:8px;">Contattaci per ulteriori informazioni</li>
                        </ul>
                    </div>
                @endif
            </td>
        </tr>

        <!-- Prodotti (solo se non annullato) -->
        @if ($newStatus !== 'cancelled')
            <tr>
                <td style="padding:0 30px 30px 30px;">
                    <h3 style="margin:0 0 15px 0; color:#333; border-bottom:2px solid #eee; padding-bottom:10px;">🛍️ I
                        Tuoi Prodotti</h3>

                    @foreach ($order->items as $item)
                        <div
                            style="border:1px solid #eee; border-radius:8px; padding:15px; margin-bottom:10px; background-color:#fafafa;">
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <div>
                                    <h4 style="margin:0 0 5px 0; color:#333;">{{ $item->product->nome }}</h4>
                                    <p style="margin:0; color:#666; font-size:14px;">
                                        Taglia: {{ $item->size->nome }} | Quantità: {{ $item->quantity }}
                                    </p>
                                </div>
                                <span style="font-weight:bold; color:#28a745;">
                                    €{{ number_format($item->price * $item->quantity, 2) }}</span>
                            </div>
                        </div>
                    @endforeach
                </td>
            </tr>
        @endif

        <!-- Footer -->
        <tr>
            <td align="center" style="background-color:#f8f9fa; padding:30px; font-size:14px; color:#666;">
                <p style="margin:0 0 10px 0;">Hai domande sul tuo ordine? Non esitare a contattarci!</p>
                <p style="margin:0;">Grazie per la fiducia! 🏀</p>
            </td>
        </tr>
    </table>

</body>

</html>
