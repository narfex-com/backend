<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Webhooks\Xendit\SettleDisbursementRequest;
use App\Http\Requests\Webhooks\Xendit\SettleInvoiceRequest;
use App\Services\Topup\Adapters\Xendit;
use App\Services\Topup\TopupService;
use App\Services\Withdrawal\Adapters\IdrAdapter;
use App\Services\Withdrawal\WithdrawalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class XenditController extends Controller
{
    private Xendit $xenditTopup;
    private IdrAdapter $xenditWithdrawal;

    /**
     * XenditController constructor.
     * @param Xendit $xenditTopup
     * @param IdrAdapter $xenditWithdrawal
     */
    public function __construct(Xendit $xenditTopup, IdrAdapter $xenditWithdrawal)
    {
        $this->xenditTopup = $xenditTopup;
        $this->xenditWithdrawal = $xenditWithdrawal;

        parent::__construct();
    }


    public function invoice(SettleInvoiceRequest $request): JsonResponse
    {
        $this->xenditTopup->processInvoice($request);

        return $this->response->build();
    }

    public function disbursement(SettleDisbursementRequest $request): JsonResponse
    {
        $this->xenditWithdrawal->processXenditWebhook($request->getWebhookData());

        return $this->response->build();
    }
}
