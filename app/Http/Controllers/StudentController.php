<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function store(Request $request)
    {

        try {
            $data = $request->all();

            $request->validate([
                'name' => 'string|required|max:255',
                'email' => 'string|required|email|max:255|unique:students',
                'date_birth' => 'date_format:Y-m-d|required',
                'cpf' => 'string|required|max:14|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/|unique:students',
                'contact' => 'string|required|max:20|unique:students',
                'cep' => 'string',
                'street' => 'string',
                'state' => 'string',
                'neighborhood' => 'string',
                'city' => 'string',
                'number' => 'string',
            ]);

            $data['user_id'] = Auth::id();
            $student = Student::create($data);

            return $student;

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function index(Request $request)
    {
        $userId = Auth::id();

        $search = $request->input('search');

        $query = Student::where('user_id', $userId);
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where('name', 'ilike', "%$search%")
                    ->orWhere('cpf', 'ilike', "%$search%")
                    ->orWhere('email', 'ilike', "%$search%");
            });
        }

        $students = $query->orderBy('name')->get();

        return $students;
    }

    public function destroy($id)
    {
        $userId = Auth::id();
        $student = Student::query()->where('user_id', $userId)->find($id);

        if (!$student) {
            return $this->error('Estudante não encontrado!', Response::HTTP_NOT_FOUND);
        }

        if ($student->user_id !== $userId) {
            return $this->error('Você não tem permissão para excluir este estudante!', Response::HTTP_FORBIDDEN);
        }

        $student->delete();

        return $this->response('', Response::HTTP_NO_CONTENT);
    }

    public function update(Request $request, $id)
    {
        try {
            $userId = Auth::id();

            $student = Student::query()->where('user_id', $userId)->find($id);

            if (!$student) {
                return $this->error('Estudante não encontrado!', Response::HTTP_NOT_FOUND);
            }

            $request->validate([
                'name' => 'string|max:255',
                'email' => 'string|email|max:255|unique:students',
                'date_birth' => 'date_format:Y-m-d',
                'cpf' => 'string|max:14|unique:students',
                'contact' => 'string|required|max:20|unique:students',
                'cep' => 'string',
                'street' => 'string',
                'state' => 'string',
                'neighborhood' => 'string',
                'city' => 'string',
                'number' => 'string',
            ]);

            $student->update($request->all());

            return $this->response('Estudante atualizado com sucesso!', Response::HTTP_OK);

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($id)
    {
        try {
            $student = Student::find($id);

            if (!$student) {
                return $this->error('Estudante não encontrado!', Response::HTTP_NOT_FOUND);
            }

            $response = [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
                'date_birth' => $student->date_birth,
                'cpf' => $student->cpf,
                'contact' => $student->contact,
                'address' => [
                    'cep' => $student->cep,
                    'street' => $student->street,
                    'state' => $student->state,
                    'neighborhood' => $student->neighborhood,
                    'city' => $student->city,
                    'number' => $student->number,
                ],
            ];

            return $response;

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}

