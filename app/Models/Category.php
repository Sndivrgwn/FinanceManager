<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'type'])]

class Category extends Model
{
    public function User(): BelongsTo {
        return $this->BelongsTo(User::class);
    }

    public function Transaction(): HasMany {
        return $this->hasMany(Transaction::class);
    }
}
