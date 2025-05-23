<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
   use HasFactory;

   protected $guarded = [];

   public function employee()
   {
      return $this->belongsTo(Employee::class);
   }

   public function absenceEmp()
   {
      return $this->belongsTo(AbsenceEmployee::class, 'absence_employee_id');
   }



   public function getRequest(){
      $absenceEmployee = AbsenceEmployee::where('absence_id', $this->id)->first();

      return $absenceEmployee;
   }
}
