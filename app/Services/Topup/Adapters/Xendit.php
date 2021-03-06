<?php


namespace App\Services\Topup\Adapters;


use App\Exceptions\Topup\TopupException;
use App\Http\Requests\Webhooks\Xendit\SettleInvoiceRequest;
use App\Models\Balance;
use App\Services\Topup\Topup;
use App\Models\Topup as TopupModel;
use Xendit\Exceptions\ApiException;
use Xendit\Invoice;

class Xendit implements TopupAdapter
{
    const STATUS_PAID = 'PAID';
    const STATUS_EXPIRED = 'EXPIRED';

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

            return new Topup($topup->id, $invoiceUrl);
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
        try {
            $invoice = Invoice::create([
                'external_id' => (string) $topup->id,
                'payer_email' => $topup->user->email,
                'description' => "Narfex topup #{$topup->id}",
                'amount' => $topup->amount
            ]);
        } catch (ApiException $e) {
            \Log::error('Xendit api error', [$e]);
            return null;
        }

        return $invoice['invoice_url'] ?? null;
    }

    public function processInvoice(SettleInvoiceRequest $request): void
    {
        $topup = TopupModel::find($request->get('external_id'));

        if (!$topup) {
            return;
        }

        $status = $request->get('status') === self::STATUS_PAID ? TopupModel::STATUS_DONE : TopupModel::STATUS_EXPIRED;

        $topup->status_id = $status;
        $topup->save();
    }
}
