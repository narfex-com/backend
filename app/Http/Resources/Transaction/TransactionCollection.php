<?php

namespace App\Http\Resources\Transaction;

use App\Http\Resources\BasePaginationCollection;

class TransactionCollection extends BasePaginationCollection
{
    public $collects = TransactionResource::class;
}
