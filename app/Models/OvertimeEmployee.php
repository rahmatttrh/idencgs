<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OvertimeEmployee extends Model
{
    use HasFactory;

    protected $guarded = [];
   
    public function employee(){
      return $this->belongsTo(Employee::class);
    }

    public function by(){
      return $this->belongsTo(Employee::class, 'by_id');
    }

    public function location(){
      return $this->belongsTo(Location::class);
    }

    public function parent(){
      return $this->belongsTo(OvertimeParent::class, 'parent_id');
    }

    public function getFinalHours(){

      if ($this->holiday_type == 1) {
         $finalHour = $this->hours;
      } elseif ($this->holiday_type == 2) {
         $finalHour = $this->hours * 2;
      } elseif ($this->holiday_type == 3) {
         $finalHour = $this->hours * 2;
      } elseif ($this->holiday_type == 4) {
         $finalHour = $this->hours * 3;
      }

      return $finalHour;
    }
}
