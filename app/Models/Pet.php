<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;
 
#[Fillable(['customer_id', 'name', 'species', 'age', 'color', 'gender'])]
class Pet extends Model
{
    use SoftDeletes;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
