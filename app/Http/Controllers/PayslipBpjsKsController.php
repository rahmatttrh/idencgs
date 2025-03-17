<?php

namespace App\Http\Controllers;

use App\Models\BpjsKsReport;
use App\Models\Location;
use App\Models\PayrollApproval;
use App\Models\PayslipBpjsKs;
use App\Models\PayslipReport;
use App\Models\Unit;
use App\Models\UnitTransaction;
use Illuminate\Http\Request;

class PayslipBpjsKsController extends Controller
{

   public function reportBpjsKs($id)
   {
      // dd('ok');
      $unitTransaction = UnitTransaction::find(dekripRambo($id));
      $locations = Location::get();

      $bpjsKsReports = BpjsKsReport::where('unit_transaction_id', $unitTransaction->id)->get();
      // dd($bpjsKsReports);

      $reportBpjsKs = PayslipBpjsKs::where('unit_transaction_id', $unitTransaction->id)->first();
      // $reportBpjsKt = PayslipBpjsKt::where('unit_transaction_id', $unitTransaction->id)->first();
      $hrd = PayrollApproval::where('unit_transaction_id', $unitTransaction->id)->where('level', 'hrd')->first();
      $manHrd = PayrollApproval::where('unit_transaction_id', $unitTransaction->id)->where('level', 'man-hrd')->first();
      $manFin = PayrollApproval::where('unit_transaction_id', $unitTransaction->id)->where('level', 'man-fin')->first();
      $gm = PayrollApproval::where('unit_transaction_id', $unitTransaction->id)->where('level', 'gm')->first();
      $bod = PayrollApproval::where('unit_transaction_id', $unitTransaction->id)->where('level', 'bod')->first();

      // dd($reportBpjsKs); 

      // $unit = Unit::find($reportBpjsKs->unit_transaction->unit->id);
      // dd($unit);

      $unit = Unit::find($unitTransaction->unit_id);


      return view('pages.payroll.report.bpjsks', [
         'unit' => $unit,
         'reportBpjsKs' => $reportBpjsKs,
         'bpjsKsReports' => $bpjsKsReports,
         'unitTransaction' => $unitTransaction,
         'locations' => $locations,
         'hrd' => $hrd,
         'manHrd' => $manHrd,
         'manFin' => $manFin,
         'gm' => $gm,
         'bod' => $bod,
      ]);
   }


   public function refresh($id){
      $unitTransaction = UnitTransaction::find(dekripRambo($id));
      $locations = Location::get();

      foreach ($locations as $loc){
         if ($loc->totalEmployee($unitTransaction->unit->id) > 0){
            $bpjsKsReport = BpjsKsReport::where('unit_transaction_id', $unitTransaction->id)->where('location_id', $loc->id)->first();

            if ($bpjsKsReport == null) {
               BpjsKsReport::create([
                  'unit_transaction_id' => $unitTransaction->id,
                  'location_id' => $loc->id,
                  'location_name' => $loc->name,
                  'program' => 'Jaminan Kesehatan',
                  'tarif' => $unitTransaction->unit->reductions->where('name', 'BPJS KS')->first()->company + $unitTransaction->unit->reductions->where('name', 'BPJS KS')->first()->employee,
                  'qty' => count($loc->getUnitTransaction($unitTransaction->unit_id, $unitTransaction)),
                  'upah' => $loc->getUnitTransactionBpjs($unitTransaction->unit_id, $unitTransaction),
                  'perusahaan' => $loc->getDeductionReal($unitTransaction, 'BPJS KS', 'company'),
                  'karyawan' => $loc->getDeduction($unitTransaction, 'BPJS KS', 'employee'),
                  'total_iuran' => $loc->getDeductionReal($unitTransaction, 'BPJS KS', 'company')+$loc->getDeduction($unitTransaction, 'BPJS KS', 'employee'),
                  'additional_iuran' => $loc->getDeductionAdditional($unitTransaction, 'employee')
               ]);
            }
         }
      }

      return redirect()->back()->with('success', 'Report BPJS Kesehatan berhasil di refresh');
   }


   


   


   
}
