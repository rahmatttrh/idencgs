<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
   use HasFactory;
   protected $guarded = [];

   public function employee()
   {
      return $this->belongsTo(Employee::class);
   }


   public function payroll()
   {
      return $this->belongsTo(Payroll::class);
   }

   public function details()
   {
      return $this->hasMany(TransactionDetail::class);
   }


   public function reductions()
   {
      return $this->hasMany(TransactionReduction::class);
   }


   public function overtimes()
   {
      return $this->hasMany(TransactionOvertime::class);
   }

   public function location()
   {
      return $this->belongsTo(Location::class);
   }

   public function unit_transaction()
   {
      return $this->belongsTo(UnitTransaction::class);
   }

   public function getBpjsKt()
   {
      $jkkReductions = TransactionReduction::where('transaction_id', $this->id)->where('name', 'JKK')->get();
      $jkmReductions = TransactionReduction::where('transaction_id', $this->id)->where('name', 'JKM')->get();
      $value = $jkkReductions->sum('value_real') + $jkmReductions->sum('value_real');
      // dd(count($transReductions));
      return $value;
   }

   public function getDeduction($name, $user)
   {
      $value = 0;
      
      $transReductions = TransactionReduction::where('transaction_id', $this->id)->where('name', $name)->where('type', $user)->where('class', 'Default')->get();
      // $transReduction = Reduction::where('class', 'Default')->where('type', 'employee')
      foreach($transReductions as $redu){
         if ($user == 'company') {
            $value += $redu->value_real;
         } else {
            $value += $redu->value;
         }
         // $value += $redu->value;
      }
      // if ($transReduction) {
      //    $value += $transReduction->value;
      // }

      return $value;
   }

   public function getAddDeduction($user)
   {
      $value = 0;
      
      $transReductions = TransactionReduction::where('transaction_id', $this->id)->where('type', $user)->where('class', 'Additional')->get();
      // $transReduction = Reduction::where('class', 'Default')->where('type', 'employee')
      foreach($transReductions as $redu){
         $value += $redu->value;
      }
      // if ($transReduction) {
      //    $value += $transReduction->value;
      // }

      return $value;
   }

   public function getDeductionAdditional()
   {
      $value = 0;
      $redAdditionals = ReductionAdditional::where('employee_id', $this->employee->id)->get();
      

      return $redAdditionals->sum('employee_value');;
   }
}
