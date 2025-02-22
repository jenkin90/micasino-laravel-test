<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Transactions;
use App\Models\TransactionsLogs;


class DepositController extends Controller
{

    private $transaction;

    public function index()
    {
        $transactions = Transactions::all();
        return view('transactionList', ['transactions' => $transactions]);
    }

    public function store(PaymentRequest $request)
    {
        $validated = $request->validated();

        $this->transaction = Transactions::create([
            'pay_method' => $validated['pay-method'],
            'amount' => $validated['amount'],
            'currency' => $validated['currency'],
        ]);

        switch ($validated['pay-method']) {
            case 'easymoney':
                $result = $this->easyMoneyPayment($validated);
                break;
            case 'superwalletz':
                $result = $this->superWalletzPayment($validated);
                break;
            default:
                $result = ['message' => 'Payment method not supported', 'status' => 400];
        }

        return response()->view('transactionResult', $result, $result['status']);
    }

    private function transmitPayment($payload, $url)
    {
        TransactionsLogs::createLog($this->transaction->id, 'request', json_encode($payload));
        try {
            $result = Http::connectTimeout(10)->post($url, $payload);
        } catch (\Exception $e) {
            $returnValue = ['message' => 'Internal server error', 'status' => 500];
            $this->transaction->changeStatus('error', 'request_result', $e->getMessage());
            return $returnValue;
        }
        if ($result->successful()) {
            $this->transaction->changeStatus('success', 'request_result', $result->body());
            $returnValue = ['message' => 'Transaction succesfull', 'status' => 200];
        }

        if ($result->failed()) {
            $this->transaction->changeStatus('failed', 'request_result', $result->body());
            $returnValue = ['message' => 'Transaction failed', 'status' => 400];
        }

        return $returnValue;
    }

    private function easyMoneyPayment($validated)
    {
        $payload = [
            'amount' => intval($validated['amount']),
            'currency' => $validated['currency'],
        ];

        $url = "http://127.0.0.1:3000/process";

        return $this->transmitPayment($payload, $url);
    }

    private function superWalletzPayment($validated)
    {
        $payload = [
            'amount' => floatval($validated['amount']),
            'currency' => $validated['currency'],
            'description' => 'Deposit id: ' . $this->transaction->id,
            'callback_url' => 'http://localhost:8000/webhook/' . $this->transaction->id,
        ];

        $url = "http://127.0.0.1:3003/pay";

        return $this->transmitPayment($payload, $url);
    }

    public function webhook($myTransactionId, Request $request)
    {
        $this->transaction = Transactions::find($myTransactionId);
        $this->transaction->changeStatus('confirmed', 'webhook', json_encode($request->all()));
        return response()->json(['message' => "Transaction $myTransactionId ended successfully"], 200);
    }
}