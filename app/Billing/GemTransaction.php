<?php


namespace App\Billing;


use App\Models\User;
use Illuminate\Support\Facades\DB;

class GemTransaction implements TransactionInterface
{

    public function add(int $user, int $count, string $source)
    {
        $user = User::lockForUpdate()->find($user);
        $transId = DB::transaction(function () use (&$user, &$count, &$source) {
            if($user->gem()->count()) {
                $previousCount = $user->gem->count;
                $user->gem->update([
                    'count' => $user->gem->count + $count,
                ]);
            }
            else {
                $previousCount = 0;
                $user->gem()->create([
                    'user_id' => $user->id,
                    'count' => $count,
                ]);
            }
            return DB::table('transactions')->insertGetId([
                'user_id' => $user->id,
                'count' => $count,
                'last_count' => $previousCount,
                'source' => $source,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, 3);
        return [
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'gems' => $user->gem->count ,
                ],
                'transactionId' => $transId,
            ],
        ];
    }
}
