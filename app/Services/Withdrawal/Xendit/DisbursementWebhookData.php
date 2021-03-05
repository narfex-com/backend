<?php


namespace App\Services\Withdrawal\Xendit;


use App\Exceptions\Withdrawal\WithdrawalException;
use App\Models\Withdrawal;

class DisbursementWebhookData
{
    public const STATUS_COMPLETED = 'COMPLETED';
    public const STATUS_FAILED = 'FAILED';

    private Withdrawal $withdrawal;

    private string $status;

    private ?string $failureCode = null;

    /**
     * DisbursementWebhookData constructor.
     * @param int $withdrawalId
     * @param string $status
     * @param string|null $failureCode
     */
    public function __construct(int $withdrawalId, string $status, ?string $failureCode = null)
    {
        /** @var Withdrawal $withdrawal */
        $withdrawal = Withdrawal::whereId($withdrawalId)
            ->first();

        if (!$withdrawal) {
            throw new WithdrawalException('Withdrawal not found');
        }

        if ($withdrawal->status_id !== Withdrawal::STATUS_PENDING) {
            throw new WithdrawalException('Withdrawal is already executed');
        }

        $this->withdrawal = $withdrawal;
        $this->status = $status;
        $this->failureCode = $failureCode;
    }

    public function isSuccess(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * @return Withdrawal
     */
    public function getWithdrawal(): Withdrawal
    {
        return $this->withdrawal;
    }

    /**
     * @return string|null
     */
    public function getFailureCode(): ?string
    {
        return $this->failureCode;
    }
}
