<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GemTransactionTest extends TestCase
{
    use DatabaseTransactions;
    public function test_add()
    {
        $userId = 1;
        $count = rand(1,10);
        $source = "gift";
        $response = $this->get("/add/$userId/$count/$source");

        /* test response status */
        $response->assertStatus(200);

        /* test transaction record */
        $this->assertDatabaseHas('transactions',[
            'id' => $response['data']['transactionId'],
            'user_id' => $userId,
            'count' => $count,
            'last_count' => ($response['data']['user']['gems'] - $count),
            'source' => $source,
        ]);

        /* test gems record */
        $this->assertDatabaseHas('gems',[
            'user_id' => $userId,
            'count' => $response['data']['user']['gems'],
        ]);
    }
    public function test_transaction_validation_errors()
    {
        $response = $this->get("/add/''/''/''");
        $response->assertStatus(302);
    }
}
