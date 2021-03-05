<?php


namespace App\Services\Topup\Adapters;


use App\Exceptions\Topup\TopupException;
use App\Models\Balance;
use App\Models\User;
use App\Services\Topup\Topup;
use App\Models\Topup as TopupModel;
use Xendit\Invoice;

class Xendit implements TopupAdapter
{
    public function __construct()
    {
        \Xendit\Xendit::setApiKey(config('payments.xendit.api_key'));
    }

    /**
     * @param Balance $balance
     * @param float $amount
     * @return Topup
     * @throws TopupException
     */
    public function create(Balance $balance, float $amount): Topup
    {
        \DB::beginTransaction();
        try {
            $topup = new TopupModel();
            $topup->balance_id = $balance->id;
            $topup->currency_id = $balance->currency_id;
            $topup->user_id = $balance->user_id;
            $topup->topup_method = 'xendit';
            $topup->amount = $amount;
            $topup->status_id = TopupModel::STATUS_CREATED;

            $topup->save();

            $invoiceUrl = $this->createXenditInvoice($topup);

            if (!$invoiceUrl) {
                throw new TopupException('Xendit request failed');
            }

            \DB::commit();

            return new Topup($invoiceUrl);
        } catch (TopupException $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param TopupModel $topup
     * @return string|null
     */
    private function createXenditInvoice(TopupModel $topup): ?string
    {
        $invoice = Invoice::create([
            'external_id' => $topup->id,
            'payer_email' => $topup->user->email,
            'description' => "Narfex topup #{$topup->id}",
            'amount' => $topup->amount
        ]);

        return $invoice['invoice_url'] ?? null;
    }

    public function processTopup()
    {

    }
}
