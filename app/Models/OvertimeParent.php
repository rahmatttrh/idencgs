<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OvertimeParent extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function overtimes(){
      return $this->hasMany(OvertimeEmployee::class, 'parent_id');
    }

    public function by(){
      return $this->belongsTo(Employee::class, 'by_id');
    }

    public function leader(){
      return $this->belongsTo(Employee::class);
    }

    public function manager(){
      return $this->belongsTo(Employee::class);
    }

    public function asmen(){
      return $this->belongsTo(Employee::class);
    }

    public function rejectBy(){
      return $this->belongsTo(Employee::class, 'reject_by');
    }
}
