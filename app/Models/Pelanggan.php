<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $guarded = [];
    public function penyewaan() : HasMany {
        return $this->hasMany(Penyewaan::class);
    }
    public function transaksi() : HasMany {
        return $this->hasMany(Transaksi::class);
    }
}
