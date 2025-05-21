<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Penyewaan extends Model
{
    protected $guarded = [];
    protected $table = 'penyewaan';
    public function pelanggan() : BelongsTo {
        return $this->belongsTo(Pelanggan::class);
    }
    public function motor() : BelongsTo {
        return $this->belongsTo(Motor::class);
    }
    public function transaksi() : HasOne {
        return $this->hasOne(Transaksi::class);
    }
}
