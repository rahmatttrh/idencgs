<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];


   public function totalEmployee($unit, $loc){
      $employees = Employee::where('project_id', $this->id)->where('status', 1)->where('unit_id', $unit)->where('location_id', $loc)->get();
      // dd(count($employees));
      return $employees;
   }


   public function getValue($id, $unitTrans, $desc, $loc)
   {
      $value = 0;
      $employees = Employee::where('unit_id', $unitTrans->unit_id)->where('location_id', $loc)->where('project_id', $this->id)->where('status', 1)->get();
      $employeeId = [];

      foreach($employees as $emp){
         $employeeId[] = $emp->id;
      }
      $transactions = Transaction::whereIn('employee_id', $employeeId)->where('location_id', $loc)->where('unit_id', $id)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
      // dd($transactions);
      foreach ($transactions as $trans) {
         $transDetail = TransactionDetail::where('transaction_id', $trans->id)->where('desc', $desc)->first();
         $value = $value + $transDetail->value;
      }

      return $value;
   }

   public function getUnitTransaction($id, $unitTrans, $loc)
   {

      $employees = Employee::where('unit_id', $unitTrans->unit_id)->where('location_id', $loc)->where('project_id', $this->id)->get();
      $employeeId = [];

      foreach($employees as $emp){
         $employeeId[] = $emp->id;
      }
      $transactions = Transaction::whereIn('employee_id', $employeeId)->where('location_id', $loc)->where('unit_id', $id)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
      // dd(count($transactions));
      return $transactions;
   }


   public function getValueGaji($id, $unitTrans, $loc)
   {
      $employees = Employee::where('unit_id', $unitTrans->unit_id)->where('location_id', $loc)->where('project_id', $this->id)->get();
      $employeeId = [];

      foreach($employees as $emp){
         $employeeId[] = $emp->id;
      }

      $value = 0;
      $transactions = Transaction::whereIn('employee_id', $employeeId)->where('location_id', $loc)->where('unit_id', $id)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
      foreach ($transactions as $trans) {
         $pokok = TransactionDetail::where('transaction_id', $trans->id)->where('desc', 'Gaji Pokok')->first()->value;
         $jabatan = TransactionDetail::where('transaction_id', $trans->id)->where('desc', 'Tunj. Jabatan')->first()->value;
         $ops = TransactionDetail::where('transaction_id', $trans->id)->where('desc', 'Tunj. OPS')->first()->value;
         $kinerja = TransactionDetail::where('transaction_id', $trans->id)->where('desc', 'Tunj. Kinerja')->first()->value;
         $insentif = TransactionDetail::where('transaction_id', $trans->id)->where('desc', 'Insentif')->first()->value;
         $fungsional = TransactionDetail::where('transaction_id', $trans->id)->where('desc', 'Tunj. Fungsional')->first()->value;
         $total = $pokok + $jabatan + $ops + $kinerja + $insentif + $fungsional;
         $value = $value + $total;
      }

      return $value;
   }


   public function getReduction($unitId, $unitTrans, $name, $loc)
   {
      $employees = Employee::where('unit_id', $unitTrans->unit_id)->where('project_id', $this->id)->where('location_id', $loc)->get();
      $employeeId = [];

      foreach($employees as $emp){
         $employeeId[] = $emp->id;
      }

      $value = 0;
      $transactions = Transaction::whereIn('employee_id', $employeeId)->where('unit_id', $unitId)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
      foreach ($transactions as $trans) {

         // if ($name == 'JP') {
         //    $transReduction = TransactionReduction::where('transaction_id', $trans->id)->where('name', $name)->where('type', 'company')->first();
         // } else {
         //    $transReduction = TransactionReduction::where('transaction_id', $trans->id)->where('name', $name)->where('type', 'employee')->first();
         // }

         $transReduction = TransactionReduction::where('transaction_id', $trans->id)->where('name', $name)->where('type', 'employee')->where('class', 'Default')->first();
         
         if ($transReduction) {
            $value += $transReduction->value;
         }
      }

      return $value;
   }

   public function getAddReduction($unitId, $unitTrans, $loc)
   {

      $employees = Employee::where('unit_id', $unitTrans->unit_id)->where('location_id', $loc)->where('unit_id', $unitId)->where('project_id', $this->id)->get();
      $employeeId = [];

      foreach($employees as $emp){
         $employeeId[] = $emp->id;
      }

      $value = 0;
      $transactions = Transaction::whereIn('employee_id', $employeeId)->where('location_id', $loc)->where('unit_id', $unitId)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
      foreach ($transactions as $trans) {

         // if ($name == 'JP') {
         //    $transReduction = TransactionReduction::where('transaction_id', $trans->id)->where('name', $name)->where('type', 'company')->first();
         // } else {
         //    $transReduction = TransactionReduction::where('transaction_id', $trans->id)->where('name', $name)->where('type', 'employee')->first();
         // }

         $transReduction = TransactionReduction::where('transaction_id', $trans->id)->where('type', 'employee')->where('class', 'Additional')->get();
         foreach($transReduction as $redu)
         // if ($transReduction) {
            $value += $redu->value;
         // }
      }

      return $value;
   }


   public function getValueGajiBersih($id, $unitTrans, $loc)
   {
      $employees = Employee::where('unit_id', $unitTrans->unit_id)->where('project_id', $this->id)->where('location_id', $loc)->get();
      $employeeId = [];

      foreach($employees as $emp){
         $employeeId[] = $emp->id;
      }

      $value = 0;
      $transactions = Transaction::whereIn('employee_id', $employeeId)->where('unit_id', $id)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
      foreach ($transactions as $trans) {
         $pokok = TransactionDetail::where('transaction_id', $trans->id)->where('desc', 'Gaji Pokok')->first()->value;
         $jabatan = TransactionDetail::where('transaction_id', $trans->id)->where('desc', 'Tunj. Jabatan')->first()->value;
         $ops = TransactionDetail::where('transaction_id', $trans->id)->where('desc', 'Tunj. OPS')->first()->value;
         $kinerja = TransactionDetail::where('transaction_id', $trans->id)->where('desc', 'Tunj. Kinerja')->first()->value;
         $insentif = TransactionDetail::where('transaction_id', $trans->id)->where('desc', 'Insentif')->first()->value;
         $fungsional = TransactionDetail::where('transaction_id', $trans->id)->where('desc', 'Tunj. Fungsional')->first()->value;
         $total = $pokok + $jabatan + $ops + $kinerja + $insentif + $fungsional;
         $value = $value + $trans->total;
      }

      return $value;
   }


}
