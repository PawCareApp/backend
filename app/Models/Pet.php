<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'customer_id',
        'name',
        'species',
        'age',
        'color',
        'gender',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
