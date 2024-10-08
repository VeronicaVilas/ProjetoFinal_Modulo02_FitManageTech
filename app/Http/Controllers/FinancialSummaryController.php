<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class FinancialSummaryController extends Controller
{
    public function getSummary()
    {
        try {
            $userId = Auth::id();

            // Calcular o total de entradas e saídas
            $totalInputs = Transaction::where('user_id', $userId)
                ->where('transaction_type', 'ENTRADA')
                ->sum('value');

            $totalOutputs = Transaction::where('user_id', $userId)
                ->where('transaction_type', 'SAÍDA')
                ->sum('value');

            // Calcular o saldo total
            $totalBalance = $totalInputs - $totalOutputs;

            // Criar a resposta
            $response = [
                'Saldo total' => number_format($totalBalance, 2, '.', ''),
                'Saldo total das entradas' => number_format($totalInputs, 2, '.', ''),
                'Saldo total das saídas' => number_format($totalOutputs, 2, '.', ''),
            ];

            return response()->json($response, Response::HTTP_OK);

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
