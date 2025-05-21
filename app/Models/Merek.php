<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Merek extends Model
{
    protected $table = 'merek';
    protected $guarded = [];
    public function motor() : HasMany {
        return $this->HasMany(Motor::class, 'merek_id', 'id');
    }
}
