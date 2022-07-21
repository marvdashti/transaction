<?php

namespace App\Providers;

use App\Billing\gemTransaction;
use App\Billing\TransactionInterface;
use App\Models\Gem;
use Illuminate\Support\ServiceProvider;
use phpDocumentor\Reflection\PseudoTypes\TraitString;

class TransactionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(TransactionInterface::class,function (){
            return new GemTransaction();
        });
    }
}
