<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
   use HasFactory;
   protected $guarded = [];


   public function unit()
   {
      return $this->belongsTo(Unit::class);
   }

   public function sub_depts()
   {
      return $this->hasMany(SubDept::class);
   }


   public function employees()
   {
      return $this->hasMany(Employee::class);
   }

   public function contracts()
   {
      return $this->hasMany(Contract::class);
   }

   public function kpi()
   {
      return $this->hasMany(PeKpi::class);
   }

   
   public function positions()
   {
      return $this->hasMany(Position::class);
   }

   public function getManagers(){
      $managers = Employee::where('designation_id', 4)->orWhere('designation_id', 5)->orWhere('designation_id', 6)->orWhere('designation_id', 7)->get();
      // dd($managers);
      return $managers;
   }

   
   public function sps()
   {
      return $this->hasMany(Sp::class);
   }

   
   public function pes()
   {
      return $this->hasMany(Pe::class);
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
      // $employees = $this->employees->where('status', 1);
      $employees = Employee::where('department_id', $this->id)->whereNotIn('designation_id', [5,6,7,8,9])->whereNotIn('nik', ['EN-4-113','kj-5-167', 'kj-5-176','kj-5-175', 'kj-6-174','kj-6-014','kj-5-111','kj-6-136', 'kj-5-101','kj-5-110','kj-5-177'])->where('status', 1)->where('join', '<=', $end)->get();

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
      if ($semester == 1) {
         $start = Carbon::create('01-01-' . $year);
         $end = Carbon::create('30-06-' . $year);
         // dd($end);
      } else {
         $start = Carbon::create('01-07-' . $year);
         $end = Carbon::create('30-12-' . $year);
      }
      $employees = $this->employees->where('status', 1);
      $employees = Employee::where('department_id', $this->id)->whereNotIn('designation_id', [5,6,7,8,9])->where('status', 1)->where('join', '<=', $end)->get();
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

   public function getPendingQpe($semester, $year)
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
      $employees = Employee::where('department_id', $this->id)->whereNotIn('designation_id', [5,6,7,8,9])->whereNotIn('nik', ['EN-4-113','kj-5-167', 'kj-5-176','kj-5-175', 'kj-6-174','kj-6-014','kj-5-111','kj-6-136', 'kj-5-101','kj-5-110','kj-5-177'])->where('status', 1)->where('join', '<=', $end)->get();
      $qpes = Pe::where('semester', $semester)->where('tahun', $year)->get();
      $pendings = [];
      // $employeeQpe = 0;
      foreach ($employees as $employee) {
         if ($employee->getQpe($semester, $year) == null) {
            $pendings[] = $employee;
         }
      }

      // dd($pendings);


      return $pendings;
   }

   public function getCompleteQpe($semester, $year)
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
      $employees = Employee::where('department_id', $this->id)->whereNotIn('designation_id', [5,6,7,8,9])->where('status', 1)->where('join', '<=', $end)->get();
      $qpes = Pe::where('semester', $semester)->where('tahun', $year)->get();
      $completes = [];
      // $employeeQpe = 0;
      foreach ($employees as $employee) {
         if ($employee->getQpe($semester, $year) != null) {
            $completes[] = $employee;
         }
      }

      // dd($completes);


      return $completes;
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
      $employees = Employee::where('department_id', $this->id)->whereNotIn('designation_id', [5,6,7,8,9])->where('status', 1)->where('join', '<=', $end)->get();
      // $qpes = Pe::where('semester', $semester)->where('tahun', $year)->get();

      

      // $employeeEmptyQpe = count($employees) - $employeeQpe;

      return $employees;
   }
}
