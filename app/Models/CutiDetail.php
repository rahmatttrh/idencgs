<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function cuti(){
      return $this->belongsTo(Cuti::class);
    }
}
