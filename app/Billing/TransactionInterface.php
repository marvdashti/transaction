<?php


namespace App\Billing;


use App\Models\User;

interface TransactionInterface
{

    public function add(int $user,int $count,string $source);
}
