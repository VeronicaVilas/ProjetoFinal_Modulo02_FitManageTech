<?php

namespace App\Http\Middleware;

use App\Models\Plan;
use App\Models\Student;
use App\Traits\HttpResponses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckStudentPlanLimitToUser
{
    use HttpResponses;

    public function handle(Request $request, Closure $next): Response
    {
        $userId = Auth::id();
        $planId = Auth::user()->plan_id;

        $plan = Plan::find($planId);

        if ($plan->description === 'OURO') {
            return $next($request);
        }

        $limit = $plan->limit;
        $count = Student::where('user_id', $userId)->count();

        if ($count >= $limit) {
            return $this->error('O limite máximo de alunos cadastrados permitido no plano foi ultrapassado. Caso deseje continuar cadastrando, realize o upgrade de plano e, se tiver alguma dúvida, entre em contato conosco.', Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
