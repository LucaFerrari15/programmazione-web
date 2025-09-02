<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Nuovo Messaggio dal Form Contatti</title>
</head>

<body style="margin:0; padding:20px; background-color:#f8f9fa; font-family:Arial,sans-serif;">

    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
        style="max-width:600px; border-radius:8px; overflow:hidden; border:1px solid #ddd; background-color:#ffffff;">
        <!-- Header -->
        <tr>
            <td align="center"
                style="background-color:#dc3545; color:#ffffff; font-size:20px; font-weight:bold; padding:20px;">
                📩 Nuovo messaggio dal sito
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td style="padding:20px; color:#333333; font-size:16px; line-height:1.5;">
                <p style="margin:0 0 10px 0;"><strong>Nome:</strong> {{ $data['nome'] }}</p>
                <p style="margin:0 0 10px 0;"><strong>Email:</strong> {{ $data['email'] }}</p>
                <p style="margin:0 0 10px 0;"><strong>Oggetto:</strong> {{ $data['oggetto'] }}</p>

                <hr style="border:none; border-top:1px solid #ddd; margin:20px 0;">

                <p style="margin:0 0 10px 0;"><strong>Messaggio:</strong></p>
                <div
                    style="background-color:#f1f1f1; padding:15px; border-radius:6px; border:1px solid #ccc; margin-top:5px;">
                    {{ $data['messaggio'] }}
                </div>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td align="center" style="background-color:#f8f9fa; padding:15px; font-size:12px; color:#888888;">
                Questo messaggio è stato inviato dal form contatti del tuo sito.
            </td>
        </tr>
    </table>

</body>

</html>
