<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Conferma Ordine #{{ $order->id }}</title>
</head>

<body style="margin:0; padding:20px; background-color:#f8f9fa; font-family:Arial,sans-serif;">

    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
        style="max-width:600px; border-radius:8px; overflow:hidden; border:1px solid #ddd; background-color:#ffffff;">

        <!-- Header -->
        <tr>
            <td align="center"
                style="background-color:#28a745; color:#ffffff; font-size:24px; font-weight:bold; padding:30px;">
                🛒 Ordine Confermato!
            </td>
        </tr>

        <!-- Intro -->
        <tr>
            <td style="padding:30px; color:#333333; font-size:16px; line-height:1.6;">
                <p style="margin:0 0 20px 0;">Ciao <strong>{{ $order->user->name }}</strong>,</p>
                <p style="margin:0 0 20px 0;">Grazie per il tuo acquisto! Il tuo ordine è stato ricevuto e sarà
                    processato a breve.</p>

                <div
                    style="background-color:#e3f2fd; padding:20px; border-radius:8px; border-left:4px solid #2196f3; margin:20px 0;">
                    <h3 style="margin:0 0 10px 0; color:#1976d2;">📋 Dettagli Ordine</h3>
                    <p style="margin:5px 0;"><strong>Numero Ordine:</strong> #{{ $order->id }}</p>
                    <p style="margin:5px 0;"><strong>Data:</strong> {{ $order->dataDiCreazioneOrdineFormattata() }}</p>
                    <p style="margin:5px 0;"><strong>Stato:</strong> <span
                            style="color:#28a745; font-weight:bold;">{{ ucfirst($order->status) }}</span></p>
                    <p style="margin:5px 0;"><strong>Totale:</strong> <span
                            style="font-size:18px; font-weight:bold;">€{{ number_format($order->total, 2) }}</span></p>
                </div>
            </td>
        </tr>

        <!-- Prodotti -->
        <tr>
            <td style="padding:0 30px;">
                <h3 style="margin:20px 0 15px 0; color:#333; border-bottom:2px solid #eee; padding-bottom:10px;">🛍️
                    Prodotti Ordinati</h3>

                @foreach ($order->items as $item)
                    <div
                        style="border:1px solid #eee; border-radius:8px; padding:15px; margin-bottom:15px; background-color:#fafafa;">
                        <div style="display:flex; align-items:center; margin-bottom:10px;">
                            <div style="flex:1;">
                                <h4 style="margin:0 0 5px 0; color:#333;">{{ $item->product->nome }}</h4>
                                <p style="margin:0; color:#666; font-size:14px;">
                                    <strong>Team:</strong> {{ $item->product->team->nome }} |
                                    <strong>Taglia:</strong> {{ $item->size->nome }}
                                </p>
                            </div>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="color:#666;">Quantità: {{ $item->quantity }}</span>
                            <span
                                style="font-weight:bold; color:#28a745;">€{{ number_format($item->price * $item->quantity, 2) }}</span>
                        </div>
                    </div>
                @endforeach
            </td>
        </tr>

        <!-- Indirizzo di spedizione -->
        <tr>
            <td style="padding:30px;">
                <h3 style="margin:0 0 15px 0; color:#333; border-bottom:2px solid #eee; padding-bottom:10px;">📦
                    Indirizzo di Spedizione</h3>
                <div style="background-color:#f8f9fa; padding:20px; border-radius:8px; border:1px solid #dee2e6;">
                    <p style="margin:5px 0;"><strong>{{ $order->nome_spedizione }}
                            {{ $order->cognome_spedizione }}</strong></p>
                    <p style="margin:5px 0;">{{ $order->via }}, {{ $order->civico }}</p>
                    <p style="margin:5px 0;">{{ $order->cap }} {{ $order->comune }} ({{ $order->provincia }})</p>
                    <p style="margin:5px 0;">{{ $order->paese }}</p>
                </div>
            </td>
        </tr>



        <!-- Footer -->
        <tr>
            <td align="center" style="background-color:#f8f9fa; padding:30px; font-size:14px; color:#666;">
                <p style="margin:0 0 10px 0;">Hai domande sul tuo ordine? Contattaci!</p>
                <p style="margin:0;">Grazie per aver scelto il nostro store! 🏀</p>
            </td>
        </tr>
    </table>

</body>

</html>
