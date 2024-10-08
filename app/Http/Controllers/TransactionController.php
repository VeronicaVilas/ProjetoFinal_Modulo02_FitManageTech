<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Services\Transaction\UpdateOneTransactionService;
use App\Models\Transaction;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Usuário não autenticado'], Response::HTTP_UNAUTHORIZED);
            }

            $data = $request->all();

            $request->validate([
                'transaction_type' => 'required|in:ENTRADA,SAÍDA',
                'description' => 'required|string|max:255',
                'value' => 'required|numeric|min:0',
                'transaction_date' => 'required|date',
            ]);

            $data['user_id'] = Auth::id();

            // Verifique se o user_id foi atribuído
            if (!$data['user_id']) {
                return response()->json(['message' => 'Usuário não autenticado'], Response::HTTP_UNAUTHORIZED);
            }

            $transaction = Transaction::create($data);

            // Crie uma resposta sem o user_id
            $response = [
                'id' => $transaction->id,
                'transaction_type' => $transaction->transaction_type,
                'description' => $transaction->description,
                'value' => $transaction->value,
                'transaction_date' => $transaction->transaction_date,
            ];

            return $response;

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function index(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Usuário não autenticado'], Response::HTTP_UNAUTHORIZED);
        }

        $userId = Auth::id();
        $search = $request->input('search');

        $query = Transaction::where('user_id', $userId);

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where('transaction_type', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhere('transaction_date', 'like', "%$search%");
            });
        }

        $transaction = $query->orderBy('transaction_date')->get();

        if ($transaction->isEmpty()) {
            return $this->error('Nenhuma transação encontrada com essas características!', Response::HTTP_NOT_FOUND);
        }

        return response()->json($transaction, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        try {
            $userId = Auth::id();

            // Busca a transação associada ao usuário autenticado pelo ID
            $transaction = Transaction::where('user_id', $userId)->find($id);

            // Verifica se a transação foi encontrada
            if (!$transaction) {
                return $this->error('Transação não encontrada!', Response::HTTP_NOT_FOUND);
            }

            // Verifica se o usuário tem permissão para deletar a transação
            if ($transaction->user_id !== $userId) {
                return $this->error('Você não tem permissão para excluir esta transação!', Response::HTTP_FORBIDDEN);
            }

            // Deleta a transação
            $transaction->delete();

            return $this->response('Transação deletada com sucesso!', Response::HTTP_NO_CONTENT);

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            // Obtém o ID do usuário autenticado
            $userId = Auth::id();

            // Busca a transação associada ao usuário autenticado pelo ID
            $transaction = Transaction::where('user_id', $userId)->find($id);

            // Verifica se a transação foi encontrada
            if (!$transaction) {
                return $this->error('Transação não encontrada!', Response::HTTP_NOT_FOUND);
            }

            // Validação dos dados recebidos na requisição
            $request->validate([
                'transaction_type' => 'in:ENTRADA,SAÍDA',
                'description' => 'string|max:255',
                'value' => 'numeric|min:0',
                'transaction_date' => 'date',
            ]);

            // Atualiza os campos da transação com os dados da requisição
            $transaction->update($request->all());

            return $this->response('Transação atualizada com sucesso!', Response::HTTP_OK);

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($id)
    {
        try {
            // Obtém o ID do usuário autenticado
            $userId = Auth::id();

            // Busca a transação associada ao usuário autenticado pelo ID
            $transaction = Transaction::where('user_id', $userId)->find($id);

            // Verifica se a transação foi encontrada
            if (!$transaction) {
                return $this->error('Transação não encontrada!', Response::HTTP_NOT_FOUND);
            }

            // Monta a resposta com os dados da transação
            $response = [
                'id' => $transaction->id,
                'transaction_type' => $transaction->transaction_type,
                'description' => $transaction->description,
                'value' => $transaction->value,
                'transaction_date' => $transaction->transaction_date,
            ];

            // Retorna a resposta da transação
            return response()->json($response, Response::HTTP_OK);

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
