<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cases extends Model
{
    use HasFactory;

     protected $fillable = [
        'suspect_id',
         'number',
         'name',
         'chapter',
         'place',
         'datetime',
         'decision',
         'division',
         'description'
    ];

    public function suspect()
    {
        return $this->belongsTo(Suspect::class);
    }
}
