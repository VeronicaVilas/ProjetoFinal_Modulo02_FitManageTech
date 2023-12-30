<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Boas-vindas ao Nosso Sistema</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .logo {
            padding: 20px;
            text-align: center;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .user-information {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }

        .additional-information {
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
        }

        .upgrade {
            font-size: 14px;
            line-height: 1.6;
            color: #555;
            font-style: italic;
            margin-top: 20px;
        }

        .footer {
            font-size: 16px;
            margin-top: 20px;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="{{ $message->embed(public_path('Logo.png')) }}" width="250px" alt="Logo da Academia" style="display: block; margin: 0 auto;" />
        </div>
        <h2 class="title">💪 Bem-Vindo à Nossa Academia {{$user->name}}! 💪</h2>

        <p class="additional-information">Seja bem-vindo à família TrainSys - O seu novo destino para uma jornada fitness extraordinária! Estamos empolgados em tê-lo(a) a bordo e ansiosos para ajudá-lo(a) a atingir seus objetivos de saúde e bem-estar.</p>

        <p class="additional-information">Aqui estão alguns detalhes importantes sobre o seu cadastro:</p>

        <ul>
            <li class="user-information"><strong>Email:</strong> {{$user->email}}</li>
            <li class="user-information"><strong>Plano:</strong> {{$plan->description}}</li>
            <li class="user-information"><strong>Limite de cadastro:</strong> {{$plan->limit > 0 ? $plan->limit : 'ILIMITADO'}}</li>
        </ul>

        <p class="additional-information">Fique à vontade para explorar todas as funcionalidades do nosso sistema e, se tiver alguma dúvida, entre em contato conosco.</p>

        <p class="upgrade">🚨 Ainda não é cliente ouro? Faça um upgrade do seu pacote de acesso sem taxas adicionais. Entre em contato para mais detalhes.</p>

        <p class="additional-information">Agradecemos por escolher nosso serviço e desejamos a você muito sucesso em suas atividades como instrutor!</p>

        <p class="footer">Atenciosamente,<br> TrainSys</p>
    </div>
</body>

</html>
