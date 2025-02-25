<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\PayrollApproval;
use App\Models\PayslipBpjsKs;
use App\Models\PayslipBpjsKt;
use App\Models\Transaction;
use App\Models\Unit;
use App\Models\UnitTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UnitTransactionController extends Controller
{

   public function detail($id)
   {
      // dd('ok');
      $unitTransaction = UnitTransaction::find(dekripRambo($id));
      $unit = Unit::find($unitTransaction->unit_id);
      $units = Unit::get();
      $locations = Location::get();
      $firstLoc = Location::orderBy('id', 'asc')->first();
      $locations = Location::get();
      $firstLoc = Location::orderBy('id', 'asc')->first();
      $transactions = Transaction::where('unit_id', $unit->id)->where('month', $unitTransaction->month)->where('year', $unitTransaction->year)->orderBy('name', 'asc')->get();


      $manhrd = PayrollApproval::where('unit_transaction_id', $unitTransaction->id)->where('level', 'man-hrd')->where('type', 'approve')->first();
      $manfin = PayrollApproval::where('unit_transaction_id', $unitTransaction->id)->where('level', 'man-fin')->where('type', 'approve')->first();
      $gm = PayrollApproval::where('unit_transaction_id', $unitTransaction->id)->where('level', 'gm')->where('type', 'approve')->first();
      $bod = PayrollApproval::where('unit_transaction_id', $unitTransaction->id)->where('level', 'bod')->where('type', 'approve')->first();

      $reportBpjsKs = PayslipBpjsKs::where('unit_transaction_id', $unitTransaction->id)->first();
      $reportBpjsKt = PayslipBpjsKt::where('unit_transaction_id', $unitTransaction->id)->first();

      $now = Carbon::create($unitTransaction->month);
      // dd($now->addMonth()->format('F'));
      if (!$reportBpjsKt) {
         PayslipBpjsKt::create([
            'unit_transaction_id' => $unitTransaction->id,
            'month' => $now->addMonth()->format('F'),
            'year' => $unitTransaction->year,
            'status' => 0,
            'payslip_employee' => count($transactions),
            'payslip_total' => $transactions->sum('total')
         ]);
      } else {
         $reportBpjsKt->update([
            'unit_transaction_id' => $unitTransaction->id,
            'month' => $now->addMonth()->format('F'),
            'year' => $unitTransaction->year,
            'status' => 0,
            'payslip_employee' => count($transactions),
            'payslip_total' => $transactions->sum('total')
         ]);
      }


      if (!$reportBpjsKs) {
         PayslipBpjsKs::create([
            'unit_transaction_id' => $unitTransaction->id,
            'month' => $now->addMonth()->format('F'),
            'year' => $unitTransaction->year,
            'status' => 0,
            'payslip_employee' => count($transactions),
            'payslip_total' => $transactions->sum('total')
         ]);
      } else {
         $reportBpjsKs->update([
            'unit_transaction_id' => $unitTransaction->id,
            'month' => $now->addMonth()->format('F'),
            'year' => $unitTransaction->year,
            'status' => 0,
            'payslip_employee' => count($transactions),
            'payslip_total' => $transactions->sum('total')
         ]);
      }

      // test create report bpjs ks
      // PayslipBpjsKs::create([
      //    'unit_transaction_id' => $unitTransaction->id,
      //    'month' => $unitTransaction->month,
      //    'year' => $unitTransaction->year,
      //    'status' => 0,
      // ]);

      
   $totalGrandHead = 0;
   foreach ($locations as $loc){
      if ($loc->totalEmployee($unit->id) > 0){
         $bruto = $loc->getValueGaji($unit->id, $unitTransaction) + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('overtime') + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_penambahan');

                                 // $tk = 2/100 * $loc->getValueGaji($unit->id, $unitTransaction);
         $tk = $loc->getReduction($unit->id, $unitTransaction, 'JHT');
         $ks = $loc->getReduction($unit->id, $unitTransaction, 'BPJS KS') + $loc->getReductionAdditional($unit->id, $unitTransaction);
         $jp = $loc->getReduction($unit->id, $unitTransaction, 'JP');
         $abs = $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_absence');
         $late = $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_late');

         $total = $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('total');
         
         $totalGrandHead += $total;
      }
                           
                              
                                 
                  
   }

   // dd($totalGrandHead);
                           
   $unitTransaction->update([
      'total_salary' => $totalGrandHead
   ]);
                        

      return view('pages.payroll.transaction.monthly-all', [
         'unit' => $unit,
         'units' => $units,
         'locations' => $locations,
         'firstLoc' => $firstLoc,
         'locations' => $locations,
         'firstLoc' => $firstLoc,
         'unitTransaction' => $unitTransaction,
         'transactions' => $transactions,

         'manhrd' => $manhrd,
         'manfin' => $manfin,
         'gm' => $gm,
         'bod' => $bod,
      ])->with('i');
   }

   public function refresh ($id){
      // dd('okeee');
      $unitTransaction = UnitTransaction::find(dekripRambo($id));
      $transactionCon = new TransactionController;
      $transactions = Transaction::where('unit_transaction_id', $unitTransaction->id)->get();
      foreach ($transactions as $tran) {
         $transactionCon->calculateTotalTransaction($tran, $tran->cut_from, $tran->cut_to);
      }

      return redirect()->back()->with('success', "Transaction data refreshed");
   }
}
