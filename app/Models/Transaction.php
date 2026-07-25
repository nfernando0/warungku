<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'transaction_code', 'total', 'payment_method', 'paid_amount', 'change_amount', 'transaction_date',])]
class Transaction extends Model
{


    protected function casts(): array
    {
        return [
            'transaction_date' => 'datetime',
        ];
    }
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
