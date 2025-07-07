<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class St extends Model
{
    use HasFactory;

    protected $guarded = [];

   public function employee()
   {
      return $this->belongsTo(Employee::class, 'employee_id');
   }

   public function leader()
   {
      return $this->belongsTo(Employee::class, 'leader_id');
   }

   public function manager()
   {
      return $this->belongsTo(Employee::class, 'manager_id');
   }

   public function hrd()
   {
      return $this->belongsTo(Employee::class, 'hrd_id');
   }

   public function by()
   {
      return $this->belongsTo(Employee::class, 'by_id');
   }

   public function department()
   {
      return $this->belongsTo(Department::class);
   }

   
}
