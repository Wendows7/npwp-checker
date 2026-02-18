<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Suspect extends Model
{
    use HasFactory;

        protected $fillable = [
            'nik',
            'name',
            'alias',
            'gender',
            'place_of_birth',
            'date_of_birth',
            'age',
            'religion',
            'education',
            'occupation',
            'address',
            'finger_code',
            'photo'
            ];

    public function Cases()
    {
        return $this->hasMany(Cases::class);
    }
}
