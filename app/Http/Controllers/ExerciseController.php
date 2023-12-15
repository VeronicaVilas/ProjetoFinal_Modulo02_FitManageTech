<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ExerciseController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'description' => 'string|required|max:255'
            ]);

            $data = $request->all();

            $data['user_id'] = Auth::id();

            $checkExerciseExists = Exercise::query()
                ->where('description', $data['description'])
                ->where('user_id', $data['user_id'])
                ->first();

            if ($checkExerciseExists) {
                return $this->error('Este exercício já foi cadastrado!', Response::HTTP_CONFLICT);
            }

            $exercise = Exercise::create($data);

            return $exercise;

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function index() {
        $user_id = Auth::id();

        $exercises = Exercise::query()->where('user_id', $user_id)->get();

        return $exercises;
    }
}
