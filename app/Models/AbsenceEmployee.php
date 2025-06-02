<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenceEmployee extends Model
{
    use HasFactory;

    protected $guarded = [];


   public function absence(){
      return $this->belongsTo(Absence::class);
   }

   public function permit(){
      return $this->belongsTo(Permit::class);
   }

   public function employee()
   {
      return $this->belongsTo(Employee::class);
   }

   public function leader()
   {
      return $this->belongsTo(Employee::class);
   }

   public function manager()
   {
      return $this->belongsTo(Employee::class);
   }

   public function cuti_backup()
   {
      return $this->belongsTo(Employee::class);
   }

   public function details(){
      return $this->hasMany(AbsenceEmployeeDetail::class);
   }

   public function rejectBy(){
      return $this->belongsTo(Employee::class, 'reject_by');
   }
}
