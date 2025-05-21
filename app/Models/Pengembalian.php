<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';
    protected $guarded = [];
    public function penyewaan() : BelongsTo {
        return $this->belongsTo(Penyewaan::class);
    }
}
