<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
   use HasFactory;
   protected $guarded = [];

   public function totalEmployee($id)
   {
      $employees = Employee::where('location_id', $this->id)->where('unit_id', $id)->where('status', 1)->get();
      // dd($employees);
      // $transactions =
      $total = count($employees);
      // dd('ok');
      return $total;
   }

   public function totalAbsence($id, $from, $to){
      $employees = Employee::where('location_id', $this->id)->where('unit_id', $id)->where('status', 1)->get();
      $total = 0;
      foreach ($employees as $emp) {
        $alphas =  $emp->getAbsences($from, $to)->where('type', 1);
        $totalAlpha = count($alphas);
        $total = $total + $totalAlpha;
      }
      return $total;
   }

   public function totalLate($id, $from, $to){
      $employees = Employee::where('location_id', $this->id)->where('unit_id', $id)->where('status', 1)->get();
      $total = 0;
      foreach ($employees as $emp) {
        $alphas =  $emp->getAbsences($from, $to)->where('type', 2);
        $totalAlpha = count($alphas);
        $total = $total + $totalAlpha;
      }
      return $total;
   }

   public function totalAtl($id, $from, $to){
      $employees = Employee::where('location_id', $this->id)->where('unit_id', $id)->where('status', 1)->get();
      $total = 0;
      foreach ($employees as $emp) {
        $alphas =  $emp->getAbsences($from, $to)->where('type', 3);
        $totalAlpha = count($alphas);
        $total = $total + $totalAlpha;
      }
      return $total;
   }

   public function totalIzin($id, $from, $to){
      $employees = Employee::where('location_id', $this->id)->where('unit_id', $id)->where('status', 1)->get();
      $total = 0;
      foreach ($employees as $emp) {
        $alphas =  $emp->getAbsences($from, $to)->where('type', 4);
        $totalAlpha = count($alphas);
        $total = $total + $totalAlpha;
      }
      return $total;
   }
   public function totalCuti($id, $from, $to){
      $employees = Employee::where('location_id', $this->id)->where('unit_id', $id)->where('status', 1)->get();
      $total = 0;
      foreach ($employees as $emp) {
        $alphas =  $emp->getAbsences($from, $to)->where('type', 5);
        $totalAlpha = count($alphas);
        $total = $total + $totalAlpha;
      }
      return $total;
   }

   public function totalSakit($id, $from, $to){
      $employees = Employee::where('location_id', $this->id)->where('unit_id', $id)->where('status', 1)->get();
      $total = 0;
      foreach ($employees as $emp) {
        $alphas =  $emp->getAbsences($from, $to)->where('type', 7);
        $totalAlpha = count($alphas);
        $total = $total + $totalAlpha;
      }
      return $total;
   }

   

   public function getUnitTransaction($id, $unitTrans)
   {
      $transactions = Transaction::where('location_id', $this->id)->where('unit_id', $id)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
      // dd(count($transactions));
      return $transactions;
   }

   public function getUnitTransactionBpjs($id, $unitTrans)
   {
      $value = 0;
      $transactions = Transaction::where('location_id', $this->id)->where('unit_id', $id)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
      
      // dd(count($transactions));

      foreach($transactions as $tran){
         $employee = Employee::find($tran->employee_id);
         $unitReductionBpjs = Reduction::where('unit_id', $employee->unit_id)->where('name', 'BPJS KS')->first();
         $employeeReductionBpjs = ReductionEmployee::where('employee_id', $employee->id)->where('reduction_id', $unitReductionBpjs->id)->first();

         // if ($employeeReductionBpjs->status == 1) {
         //    $payroll= Payroll::find($tran->payroll_id);
         //    $value += $payroll->total;
         // }

         $payroll= Payroll::find($tran->payroll_id);
         $value += $payroll->total;
      }
      return $value;
   }

   // public function getDeductionAdditional($id, $unitTrans){
   //    $redAdditionals = ReductionAdditional::where('employee_id', $this->employee->id)->get();
      

   //    return $redAdditionals->sum('employee_value');;
   // }

   public function getValue($id, $unitTrans, $desc)
   {
      $value = 0;
      $transactions = Transaction::where('location_id', $this->id)->where('unit_id', $id)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
      foreach ($transactions as $trans) {
         $transDetail = TransactionDetail::where('transaction_id', $trans->id)->where('desc', $desc)->first();
         $value = $value + $transDetail->value;
      }

      return $value;
   }

   public function getValueGaji($id, $unitTrans)
   {
      $value = 0;
      $transactions = Transaction::where('location_id', $this->id)->where('unit_id', $id)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
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

   public function getValueGajiBersih($id, $unitTrans)
   {
      $value = 0;
      $transactions = Transaction::where('location_id', $this->id)->where('unit_id', $id)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
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

   public function getValueBpjsKt($id, $unitTrans)
   {
      $value = 0;
      $transactions = Transaction::where('location_id', $this->id)->where('unit_id', $id)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
      foreach ($transactions as $trans) {
         $pokok = TransactionDetail::where('transaction_id', $trans->id)->where('desc', 'Gaji Pokok')->first()->value;
         $jabatan = TransactionDetail::where('transaction_id', $trans->id)->where('desc', 'Tunj. Jabatan')->first()->value;
         $ops = TransactionDetail::where('transaction_id', $trans->id)->where('desc', 'Tunj. OPS')->first()->value;
         $kinerja = TransactionDetail::where('transaction_id', $trans->id)->where('desc', 'Tunj. Kinerja')->first()->value;
         $total = $pokok + $jabatan + $ops + $kinerja;
         $value = $value + $total;
      }

      return $value;
   }

   public function getReduction($unitId, $unitTrans, $name)
   {
      $value = 0;
      $transactions = Transaction::where('location_id', $this->id)->where('unit_id', $unitId)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
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

   public function getAddReduction($unitId, $unitTrans)
   {
      $value = 0;
      $transactions = Transaction::where('location_id', $this->id)->where('unit_id', $unitId)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
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

   public function getReductionAdditional($unitId, $unitTrans)
   {
      $value = 0;
      $transactions = Transaction::where('location_id', $this->id)->where('unit_id', $unitId)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
      foreach ($transactions as $trans) {

         // if ($name == 'JP') {
         //    $transReduction = TransactionReduction::where('transaction_id', $trans->id)->where('name', $name)->where('type', 'company')->first();
         // } else {
         //    $transReduction = TransactionReduction::where('transaction_id', $trans->id)->where('name', $name)->where('type', 'employee')->first();
         // }
         $redAdditionals = ReductionEmployee::where('employee_id', $trans->employee->id)->where('type', 'Additional')->get();
         // $transReduction = TransactionReduction::where('transaction_id', $trans->id)->where('name', $name)->where('type', 'employee')->first();
         
         if ($redAdditionals) {
            $value += $redAdditionals->sum('employee_value');
         }
      }

      return $value;
   }

   public function getReductionAdditionalB($unitId, $unitTrans)
   {
      $value = 0;
      $transactions = Transaction::where('location_id', $this->id)->where('unit_id', $unitId)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
      foreach ($transactions as $trans) {

         // if ($name == 'JP') {
         //    $transReduction = TransactionReduction::where('transaction_id', $trans->id)->where('name', $name)->where('type', 'company')->first();
         // } else {
         //    $transReduction = TransactionReduction::where('transaction_id', $trans->id)->where('name', $name)->where('type', 'employee')->first();
         // }
         $redAdditionals = ReductionEmployee::where('employee_id', $trans->employee->id)->where('type', 'Additional')->get();

         // $transReduction = TransactionReduction::where('transaction_id', $trans->id)->where('name', $name)->where('type', 'employee')->first();
         
         if ($redAdditionals) {
            $value = $redAdditionals->sum('employee_value');
         }
      }

      return $value;
   }

   public function getDeduction($unitTrans, $name, $user)
   {
      $value = 0;
      $transactions = Transaction::where('location_id', $this->id)->where('unit_id', $unitTrans->unit_id)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
      foreach ($transactions as $trans) {
         $transReduction = TransactionReduction::where('transaction_id', $trans->id)->where('name', $name)->where('type', $user)->first();
         if ($transReduction) {
            $value = $value + $transReduction->value;
         }
      }

      return $value;
   }

   public function getDeductionReal($unitTrans, $name, $user)
   {
      $value = 0;
      $transactions = Transaction::where('location_id', $this->id)->where('unit_id', $unitTrans->unit_id)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
      foreach ($transactions as $trans) {
         $transReduction = TransactionReduction::where('transaction_id', $trans->id)->where('name', $name)->where('type', $user)->first();
         if ($transReduction) {
            $value = $value + $transReduction->value_real;
         }
      }

      return $value;
   }

   public function getDeductionAdditional($unitTrans, $user)
   {
      $value = 0;
      $transactions = Transaction::where('location_id', $this->id)->where('unit_id', $unitTrans->unit_id)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
      foreach ($transactions as $trans) {

         foreach ($trans->reductions->where('class', 'Additional')->where('type', 'employee') as $red) {
            $value = $value + $red->value;
         }
         // $transReduction = TransactionReduction::where('transaction_id', $trans->id)->where('class', 'Additional')->where('type', $user)->first();
      }

      return $value;
   }

   public function getReductionBpjsKt($unitId, $unitTrans)
   {
      $value = 0;
      $transactions = Transaction::where('location_id', $this->id)->where('unit_id', $unitId)->where('month', $unitTrans->month)->where('year', $unitTrans->year)->get();
      // dd($transactions);
      foreach ($transactions as $trans) {
         $jkk = TransactionReduction::where('transaction_id', $trans->id)->where('name', 'JKK')->where('type', 'company')->first()->value;
         $jkm = TransactionReduction::where('transaction_id', $trans->id)->where('name', 'JKM')->where('type', 'company')->first()->value;
         $total = $jkk + $jkm;
         $value = $value + $total;
      }

      return $value;
   }



   public function payrolls()
   {
      return $this->hasMany(Payroll::class);
   }

   public function transactions()
   {
      return $this->hasMany(Transaction::class);
   }

   public function overtimes()
   {
      return $this->hasMany(Overtime::class);
   }

   public function reductions()
   {
      return $this->hasMany(Reduction::class);
   }
}
