<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenceEmployeeDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function absence_employee(){
      return $this->belongsTo(AbsenceEmployee::class);
    }
}
