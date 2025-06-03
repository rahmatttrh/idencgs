<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitTransaction extends Model
{
   use HasFactory;
   protected $guarded = [];

   public function unit(){
      return $this->belongsTo(Unit::class);
   }

   public function transactions(){
      return $this->hasMany(Transaction::class);
   }

   public function payslipReports(){
      return $this->hasMany(PayslipReport::class);
   }

   public function rejectBy(){
      return $this->belongsTo(Employee::class, 'reject_by');
   }
}
