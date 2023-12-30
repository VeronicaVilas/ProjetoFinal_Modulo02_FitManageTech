<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Treinos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }

        .student {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .student-information {
            border: 1px solid;
            padding: 10px;
            margin: 10px;
            width: 300px;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;

            font-size: 14px;
        }

        th, td {
            border: 1px solid;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <header>
        <h1 class="title">Ficha de Treinos</h1>
        <div class="student">
            <p class="student-information"><strong>Nome:</strong> {{ $name }}</p>
            <p class="student-information"><strong>Instrutor:</strong> {{ $user }}</p>
        </div>
    </header>

    <h3>Treinos:</h3>
    <hr>
    @foreach($workouts as $day => $dayWorkouts)
        <table>
            <thead>
                <tr>
                    <th>Dia da semana</th>
                    <th>Exercício</th>
                    <th>Repetições</th>
                    <th>Peso</th>
                    <th>Tempo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dayWorkouts as $workout)
                    <tr>
                        <td>{{ $day }}</td>
                        <td>{{ $workout->exercise->description }}</td>
                        <td>{{ $workout->repetitions }}</td>
                        <td>{{ $workout->weight }}</td>
                        <td>{{ $workout->time }} minutos</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Sem treinos cadastrados para este dia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach

</body>
</html>
