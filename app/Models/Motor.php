<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Motor extends Model
{
    protected $table = 'motor';
    protected $guarded = [];
    function Merek() : BelongsTo {
        return $this->BelongsTo(Merek::class);
    }

    public function transaksi() : HasMany {
        return $this->hasMany(Transaksi::class);
    }
}
