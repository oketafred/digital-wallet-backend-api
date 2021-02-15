<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Webpatser\Uuid\Uuid;

class MobileMoneyDeposit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transaction;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Log::info($this->transaction);
        $response = Http::post('https://www.easypay.co.ug/api/', [
            "username"      => env('EASYPAY_USERNAME'),
            "password"      => env('EASYPAY_PASSWORD'),
            "action"        => "mmdeposit",
            "amount"        => 500,
            "currency"      => "UGX",
            "phone"         => $this->transaction->phone,
            "reference"     => $this->transaction->reference,
            "reason"        => "Wallet Deposit"
        ]);

        $response->throw();
    }
}
