<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Workout;
use App\Models\Exercise;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentWorkoutController extends Controller
{
    public function index($studentId)
    {
        try {
            $student = Student::find($studentId);

            $workouts = Workout::query()
                ->where('student_id', $studentId)
                ->with(['exercise' => function ($query) {
                    $query->select('id', 'description');
                }])
                ->orderBy('day')
                ->orderBy('created_at')
                ->get(['*', 'workouts.exercise_id as exercise_id']);

            $groupedWorkouts = $workouts->groupBy('day');

            $response = [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'workouts' => $groupedWorkouts,
            ];

            return $response;

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
