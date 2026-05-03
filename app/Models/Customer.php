<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;
 
#[Fillable(['user_id', 'name', 'address', 'phone_number', 'gender'])]
class Customer extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pet(){
        return $this->hasMany(Pet::class);
    }
}
