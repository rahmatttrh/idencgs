<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
   // use HasFactory;
   // protected $guarded = [];
   use HasFactory;
   protected $guarded = [];


   // public function departments()
   // {
   //    return $this->hasMany(Department::class);
   // }
   public function departments()
   {
      return $this->hasMany(Department::class);
   }


   public function employees()
   {
      return $this->hasMany(Employee::class);
   }

   public function reductions()
   {
      return $this->hasMany(Reduction::class);
   }


   // public function totalSubDept($unitId = 2)
   // {
   //    // Memanggil ModelA dan salah satu metodenya
   //    $ModelDepartments = new Department();
   //    $departments = $ModelDepartments->where('unit_id', $unitId)->get();
   //    $totalSubDept = 0;
   public function totalSubDept($unitId = 2)
   {
      // Memanggil ModelA dan salah satu metodenya
      $ModelDepartments = new Department();
      $departments = $ModelDepartments->where('unit_id', $unitId)->get();
      $totalSubDept = 0;

      foreach ($departments as $key => $dept) {
         $totalSubDept += $dept->sub_depts->count();
      }
      return $totalSubDept;
   }

   public function unitTransactions()
   {
      return $this->hasMany(UnitTransaction::class);
   }


   public function getEmptyQpe($semester, $year)
   {

      if ($semester == 1) {
         $start = Carbon::create('01-01-' . $year);
         $end = Carbon::create('30-06-' . $year);
         // dd($end);
      } else {
         $start = Carbon::create('01-07-' . $year);
         $end = Carbon::create('30-12-' . $year);
      }
      $employees = $this->employees->where('status', 1);
      $employees = Employee::where('unit_id', $this->id)->whereNotIn('designation_id', [5,6,7,8,9])->where('status', 1)->where('join', '<=', $end)->get();
      $qpes = Pe::where('semester', $semester)->where('tahun', $year)->get();

      $employeeQpe = 0;
      foreach ($employees as $employee) {
         foreach ($qpes as $qpe) {
            if ($qpe->employe_id == $employee->id) {
               $employeeQpe = $employeeQpe + 1;
            }
         }
      }

      $employeeEmptyQpe = count($employees) - $employeeQpe;

      return $employeeEmptyQpe;
   }



   public function getQpe($semester, $year, $status)
   {
      $employees = $this->employees->where('status', 1);
      if ($semester == 1) {
         $start = Carbon::create('01-01-' . $year);
         $end = Carbon::create('30-06-' . $year);
         // dd($end);
      } else {
         $start = Carbon::create('01-07-' . $year);
         $end = Carbon::create('30-12-' . $year);
      }
      $employees = Employee::where('unit_id', $this->id)->whereNotIn('designation_id', [5,6,7,8,9])->where('status', 1)->where('join', '<=', $end)->get();

      $qpes = Pe::where('semester', $semester)->where('tahun', $year)->where('status', $status)->get();

      $employeeQpe = 0;
      foreach ($employees as $employee) {
         foreach ($qpes as $qpe) {
            if ($qpe->employe_id == $employee->id) {
               $employeeQpe = $employeeQpe + 1;
            }
         }
      }

      return $employeeQpe;
   }

   public function getAllQpe( $status)
   {
      $employees = $this->employees->where('status', 1);
      
      $employees = Employee::where('unit_id', $this->id)->whereNotIn('designation_id', [5,6,7,8,9])->get();

      $qpes = Pe::where('status', $status)->get();

      $employeeQpe = 0;
      foreach ($employees as $employee) {
         foreach ($qpes as $qpe) {
            if ($qpe->employe_id == $employee->id) {
               $employeeQpe = $employeeQpe + 1;
            }
         }
      }

      return $employeeQpe;
   }

   public function getEmployeeQpe($semester, $year)
   {

      if ($semester == 1) {
         $start = Carbon::create('01-01-' . $year);
         $end = Carbon::create('30-06-' . $year);
         // dd($end);
      } else {
         $start = Carbon::create('01-07-' . $year);
         $end = Carbon::create('30-12-' . $year);
      }
      $employees = $this->employees->where('status', 1);
      $employees = Employee::where('unit_id', $this->id)->whereNotIn('designation_id', [5,6,7,8,9])->where('status', 1)->where('join', '<=', $end)->get();
      $qpes = Pe::where('semester', $semester)->where('tahun', $year)->get();

      

      // $employeeEmptyQpe = count($employees) - $employeeQpe;

      return $employees;
   }

   public function getUnitTransaction($unitTrans)
   {
      $transactions = Transaction::where('unit_id', $this->id)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
      return $transactions;
   }
}
