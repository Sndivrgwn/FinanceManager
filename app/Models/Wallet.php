<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'type', 'balance'])]

class Wallet extends Model
{
    public function User(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function Transaction(): HasMany {
        return $this->hasMany(Transaction::class);
    }

    public function sentTransfers()
    {
        return $this->hasMany(Transfer::class, 'from_wallet_id');
    }

    public function receivedTransfers()
    {
        return $this->hasMany(Transfer::class, 'to_wallet_id');
    }
}
