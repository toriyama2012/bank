<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Transfer extends Model
{
    use HasFactory;

    public function customer1() {
        return $this->belongsTo(Customer::class, 'customer_from_id', 'id');
    }

    public function customer2() {
        return $this->belongsTo(Customer::class, 'customer_to_id', 'id');
    }
}
