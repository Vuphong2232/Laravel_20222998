<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['customer_id', 'date', 'time'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}