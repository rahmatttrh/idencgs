<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayslipReportProject extends Model
{
    use HasFactory;

    protected $guarded = [];

   public function unit_transaction(){
      return $this->belongsTo(UnitTransaction::class);
   }

   public function report(){
      return $this->belongsTo(PayslipReport::class, 'report_payslip_id');
   }

   public function project(){
      return $this->belongsTo(Project::class);
   }



   public function location(){
      return $this->belongsTo(Location::class);
   }
}
