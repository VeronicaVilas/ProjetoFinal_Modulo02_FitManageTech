<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Http\Controllers\Controller;
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
        $userId = Auth::id();

        $exercise = Exercise::query()->where('user_id', $userId)->get();

        return $exercise;
    }

    public function destroy($id)
    {
        try {

            $exercise = Exercise::find($id);

            if (!$exercise) {
                return $this->error('Exercício não encontrado!', Response::HTTP_NOT_FOUND);
            }

            $userId = Auth::id();

            if ($exercise->user_id !== $userId) {
                return $this->error('Você não tem permissão para excluir este exercício.', Response::HTTP_FORBIDDEN);
            }

            if ($exercise->workouts()->exists()) {
                return $this->error('Não é permitido excluir o exercício pois existem treinos vinculados.', Response::HTTP_CONFLICT);
            }

            $exercise->delete();

            return $this->response('',Response::HTTP_NO_CONTENT);

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
