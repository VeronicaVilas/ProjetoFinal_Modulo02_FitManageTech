<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Student;
use App\Models\Workout;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class WorkoutController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'student_id' => 'exists:students,id',
                'exercise_id' => 'exists:exercises,id',
                'repetitions' => 'integer|required',
                'weight' => 'numeric|required',
                'break_time' => 'integer|required',
                'day' => 'string|required|in:SEGUNDA,TERÇA,QUARTA,QUINTA,SEXTA,SÁBADO,DOMINGO',
                'observations' => 'string',
                'time' => 'integer|required',
            ]);

            $data = $request->all();

            $userId = Auth::id();
            $student = Student::find($data['student_id']);

            if (!$student || $student->user_id !== $userId) {
                return $this->error('Estudante não encontrado ou não pertence ao usuário logado.', Response::HTTP_NOT_FOUND);
            }

            $exercise = Exercise::find($data['exercise_id']);

            if (!$exercise || $exercise->user_id !== $userId) {
                return $this->error('Exercício não encontrado ou não pertence ao usuário logado.', Response::HTTP_NOT_FOUND);
            }

            $checkWorkoutExists = Workout::query()
                ->where('student_id', $data['student_id'])
                ->where('day', $data['day'])
                ->first();

            if ($checkWorkoutExists) {
                return $this->error('O Treino já foi cadastrado para este dia!', Response::HTTP_CONFLICT);
            }

            $data['user_id'] = $userId;

            $workout = Workout::create($data);

            return $workout;

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
