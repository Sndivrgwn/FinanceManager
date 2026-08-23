<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['from_wallet_id', 'to_wallet_id', 'amount', 'description', 'transfer_date'])]

class Transfer extends Model
{
    public function User(): BelongsTo {
        return $this->BelongsTo(User::class);
    }
    public function fromWallet()
    {
        return $this->belongsTo(Wallet::class, 'from_wallet_id');
    }

    public function toWallet()
    {
        return $this->belongsTo(Wallet::class, 'to_wallet_id');
    }
}
