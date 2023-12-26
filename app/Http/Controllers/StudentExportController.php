<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Workout;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class StudentExportController extends Controller
{
    public function export(Request $request)
    {
        try {
            $studentId = $request->input('id_do_estudante');
            $student = Student::find($studentId);

            if (!$student) {
                return $this->error('Estudante não encontrado!', Response::HTTP_NOT_FOUND);
            }

            $workouts = Workout::query()
                ->where('student_id', $studentId)
                ->with(['exercise' => function ($query) {
                    $query->select('id', 'description');
                }])
                ->orderBy('day')
                ->orderBy('created_at')
                ->get(['*', 'workouts.exercise_id as exercise_id']);

            $groupedWorkouts = $workouts->groupBy('day');

            $name = $student->name;
            $workouts = $groupedWorkouts;

            $pdf = PDF::loadView('pdfs.workoutStudent', [
                'name' => $name,
                'workouts' => $workouts
            ]);

            return $pdf->stream('ficha_de_treinos.pdf');

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
