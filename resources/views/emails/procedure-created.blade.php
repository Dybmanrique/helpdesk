<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Trámite Registrado</title>
    <style>
        body {
            background-color: #e5e7eb;
            color: #111827;
            font-family: ui-sans-serif, system-ui, sans-serif;
            margin: 0;
            padding: 1.5rem;
        }

        .container {
            max-width: 42rem;
            margin: auto;
            background-color: #ffffff;
            padding: 1.5rem;
            border-radius: 0.5rem;
        }

        h1 {
            font-size: 1.5rem;
            text-align: center;
            color: #0891b2;
        }

        p {
            margin-bottom: 1rem;
        }

        .ticket {
            background-color: #f3f5f6;
            padding: 0.25rem;
            border-radius: 0.25rem;
            display: block;
            word-wrap: break-word;
        }

        .ticket-note {
            font-size: 12px;
            color: #6b7280;
            margin-top: -10px;
        }

        a.link {
            text-decoration: none;
            font-weight: bold;
            color: #0891b2;
        }

        .button-container {
            text-align: center;
            margin-top: 1.5rem;
        }

        .button {
            text-decoration: none;
            color: #ffffff;
            font-size: 1.125rem;
            font-weight: bold;
            background-color: #0891b2;
            border-radius: 0.75rem;
            padding: 0.5rem 1.5rem;
            display: block;
            margin: auto;
            max-width: 300px;
            word-wrap: break-word;
        }

        .footer {
            margin-top: 1.5rem;
            text-align: center;
            color: #6b7280;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>¡Su trámite fue registrado correctamente!</h1>

        <p>Nos complace informarle que su trámite ha sido registrado y está siendo procesado. Puede
            darle seguimiento en cualquier momento para conocer su estado actual.</p>

        <p><strong>Su trámite fue registrado con el siguiente ticket:</strong>
            <code class="ticket">{{ $ticket }}</code>
        </p>
        <p class="ticket-note">(Use este código para referirse a su trámite cuando necesite más información, darle
            seguimiento o al contactar con nosotros).</p>

        <p>Puede ver el estado de su trámite haciendo clic <a
                href="{{ route('procedures.consult', ['code' => $ticket]) }}" class="link">AQUÍ</a> o en el enlace de
            abajo.</p>

        <p>Si necesita más información o tiene alguna pregunta, no dude en contactarnos. Estamos aquí para ayudarle.</p>

        <div class="button-container">
            <a href="{{ route('procedures.consult', ['code' => $ticket]) }}" class="button">Ver estado de mi trámite</a>
        </div>

        <div class="footer">
            <hr>
            <p>Gracias por confiar en nosotros.</p>
            <p>UGEL Asunción</p>
        </div>
    </div>
</body>

</html>
