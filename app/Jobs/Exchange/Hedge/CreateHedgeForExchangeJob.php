<?php

namespace App\Jobs\Exchange\Hedge;

use App\Models\Exchange;
use App\Services\Hedge\HedgeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateHedgeForExchangeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Exchange $exchange;

    /**
     * Create a new job instance.
     *
     * @param Exchange $exchange
     */
    public function __construct(Exchange $exchange)
    {
        $this->exchange = $exchange;
    }

    /**
     * Execute the job.
     *
     * @param HedgeService $hedgeService
     * @return void
     */
    public function handle(HedgeService $hedgeService)
    {
//        try {
//            $hedgeService->createHedge($this->exchange);
//        }
    }
}
