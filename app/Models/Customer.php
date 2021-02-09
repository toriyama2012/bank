<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Branch;
use App\Models\Transfer;

class Customer extends Model
{
    use HasFactory;

    public function branch() {
        return $this->belongsTo(Branch::class);
    }

    public function transfers() {
        return $this->hasMany(Transfer::class);
    }
}
