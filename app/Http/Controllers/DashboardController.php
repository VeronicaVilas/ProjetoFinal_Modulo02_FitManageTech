<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Exercise;
use App\Models\User;
use App\Models\Plan;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        try {

            $userId = Auth::id();

            $registeredStudents = Student::where('user_id', $userId)->count();
            $registeredExercises = Exercise::where('user_id', $userId)->count();

            $user = User::with('plan')->find($userId);

            if (!$user) {
                return $this->error('Usuário não encontrado!', Response::HTTP_NOT_FOUND);
            }

            $currentUserPlan = $user->plan->description;
            $remainingStudents = $currentUserPlan === 'OURO' ? 'ilimitado' : max(0, $user->plan->limit - $registeredStudents);

            $response = [
                'registered_students' => $registeredStudents,
                'registered_exercises' => $registeredExercises,
                'current_user_plan' => $currentUserPlan,
                'remaining_students' => $remainingStudents,
            ];

            return $response;

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
