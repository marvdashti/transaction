<?php

namespace App\Http\Controllers;

use App\Billing\TransactionInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function addTransaction(TransactionInterface $transaction, Request $request)
    {
        $request->merge([
            'userId' => $request->route('userId'),
            'count' => $request->route('count'),
            'source' => $request->route('source'),
        ]);
        Validator::make($request->all(), [
            'userId' => 'required|exists:App\Models\User,id',
            'count' => 'required',
        ])->validate();
        return $transaction->add($request->userId, $request->count, $request->source);
    }
}
