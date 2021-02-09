<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Branch extends Model
{
    use HasFactory;

    public function customers() {
        return $this->hasMany(User::class);
    }
}
