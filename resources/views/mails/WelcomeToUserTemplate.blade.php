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
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-family: 'Arial', sans-serif;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
            color: black
        }

        .user-information {
            font-size: 16px;
            line-height: 1.6;

            text-transform: lowercase;
            color: black
        }

        .additional-information {
            font-size: 16px;
            color: black
        }

        .upgrade {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }
    </style>
</head>
<body>
    <img src="{{ $message->embed(public_path('logo.png'))}}" width="800px"/>
    <h2 class="title">💪 Bem-Vindo à Nossa Academia {{$user->name}}! 💪</h2>

    <p class="additional-information">Seja bem-vindo à família TrainSys - O seu novo destino para uma jornada fitness extraordinária! Estamos empolgados em tê-lo(a) a bordo e ansiosos para ajudá-lo(a) a atingir seus objetivos de saúde e bem-estar.</p>
    <p class="additional-information">Aqui estão alguns detalhes importantes sobre o seu cadastro:</p>

    <ul>
        <li class="user-information"><strong>Email:</strong> {{$user->email}}</li>
        <li class="user-information"><strong>Plano:</strong> {{$plan->description}}</li>
        <li class="user-information"><strong>Limite de cadastro:</strong> {{$plan->limit > 0 ? $plan->limit : 'ILIMITADO'}}</li>
    </ul>

    <p class="additional-information">Fique à vontade para explorar todas as funcionalidades do nosso sistema e, se tiver alguma dúvida, entre em contato conosco.</p>

    <p class="upgrade">🚨Você ainda não é cliente ouro? Venha fazer um upgrade do seu pacote de acesso, e o melhor é que não possui taxas adicionais. Caso queria mais detalhes entre em contato conosco.</p>

    <p class="additional-information">Agradecemos por escolher nosso serviço e desejamos a você muito sucesso em suas atividades como instrutor!</p>

    <p class="additional-information">Atenciosamente,<br>
    TrainSys</p>
</body>
</html>
