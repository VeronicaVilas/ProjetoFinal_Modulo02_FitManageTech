<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponses;
use App\Mail\SendWelcomeEmailToUser;
use App\Models\Plan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function store(Request $request)
    {

        try {
            $data = $request->all();

            $request->validate([
                'name' => 'string|required|max:255',
                'email' => 'string|required|email|max:255|unique:users',
                'date_birth' => 'date_format:Y-m-d|required',
                'cpf' => 'string|required|max:14|unique:users',
                'password' => 'string|required|min:8|max:32',
                'plan_id' => 'exists:plans,id',
            ]);

            $user = User::create($data);
            $plan = Plan::find($user->plan_id);
            $email = $user->email;

            Mail::to($email)
            ->send(new SendWelcomeEmailToUser($user, $plan));

            return $user;

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
