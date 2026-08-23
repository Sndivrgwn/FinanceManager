<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['type', 'amount', 'description'])]

class Transaction extends Model
{
    public function User(): BelongsTo {
        return $this->BelongsTo(User::class);
    }

    public function Wallet(): BelongsTo {
        return $this->BelongsTo(Wallet::class);
    }

    public function Category(): BelongsTo {
        return $this->BelongsTo(Category::class);
    }
}
