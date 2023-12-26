<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Treinos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Calendário de Treinos - {{ $name }}</h1>

    @foreach ($workouts as $day => $dayWorkouts)
        <h2>{{ $day }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Exercício</th>
                    <th>Repetições</th>
                    <th>Peso</th>
                    <th>Tempo de Pausa</th>
                    <th>Observações</th>
                    <th>Horário</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dayWorkouts as $workout)
                    <tr>
                        <td>{{ $workout->exercise->description }}</td>
                        <td>{{ $workout->repetitions }}</td>
                        <td>{{ $workout->weight }}</td>
                        <td>{{ $workout->break_time }}</td>
                        <td>{{ $workout->observations }}</td>
                        <td>{{ $workout->time }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>
