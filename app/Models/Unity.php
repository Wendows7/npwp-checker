<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unity extends Model
{
    protected $fillable = ['name'];

    use HasFactory;

    public function Cases()
    {
        return $this->hasMany(Cases::class);
    }
}
