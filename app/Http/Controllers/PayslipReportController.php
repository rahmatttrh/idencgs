<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\PayslipReport;
use App\Models\PayslipReportProject;
use App\Models\Project;
use App\Models\Unit;
use App\Models\UnitTransaction;
use Illuminate\Http\Request;
use League\Flysystem\Adapter\Local;

class PayslipReportController extends Controller
{
   public function refresh($id){
      // dd('ok');
      $unitTransaction = UnitTransaction::find(dekripRambo($id));
      $unit = Unit::find($unitTransaction->unit_id);
      $locations = Location::get();
      $projects = Project::get();


      foreach ($locations as $loc){
         if ($loc->totalEmployee($unit->id) > 0){
            $payslipReport = PayslipReport::where('unit_transaction_id', $unitTransaction->id)->where('location_id', $loc->id)->first();

            if ($payslipReport == null) {
               $payslipReport = PayslipReport::create([
                  'unit_transaction_id' => $unitTransaction->id,
                  'location_id' => $loc->id,
                  'location_name' => $loc->name,
                  'qty' => count($loc->getUnitTransaction($unit->id, $unitTransaction)),
                  'pokok' => $loc->getValue($unit->id, $unitTransaction, 'Gaji Pokok'),
                  'jabatan' => $loc->getValue($unit->id, $unitTransaction,  'Tunj. Jabatan'),
                  'ops' => $loc->getValue($unit->id, $unitTransaction, 'Tunj. OPS'),
                  'kinerja' => $loc->getValue($unit->id, $unitTransaction, 'Tunj. Kinerja'),
                  'fungsional' => $loc->getValue($unit->id, $unitTransaction, 'Tunj. Fungsional'),
                  'total' => $loc->getValueGaji($unit->id, $unitTransaction),
   
                  'lain' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_penambahan'),
                  'lembur' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('overtime'),
   
                  'bruto' => $loc->getValueGaji($unit->id, $unitTransaction) + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('overtime') + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_penambahan'),
   
                  'bpjskt' => $loc->getReduction($unit->id, $unitTransaction, 'JHT'),
                  'bpjsks' => $loc->getReduction($unit->id, $unitTransaction, 'BPJS KS'),
                  'jp' => $loc->getReduction($unit->id, $unitTransaction, 'JP'),
                  'absen' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_absence'),
                  'terlambat' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_late'),
                  'additional_pengurangan' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_pengurangan'),
                  'gaji_bersih' => ($loc->getValueGaji($unit->id, $unitTransaction) + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('overtime') + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_penambahan') - ($loc->getReduction($unit->id, $unitTransaction, 'JHT') + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_pengurangan') + $loc->getReduction($unit->id, $unitTransaction, 'BPJS KS') + $loc->getReductionAdditional($unit->id, $unitTransaction) + $loc->getReduction($unit->id, $unitTransaction, 'JP') + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_absence') + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_late')))
   
               ]);

               if ($payslipReport->location->projectExist() ==  true){
                  foreach ($projects as $pro){
                     if (count($pro->totalEmployee($unit->id, $loc->id)) > 0){
                        PayslipReportProject::create([
                           'unit_transaction_id' => $unitTransaction->id,
                           'payslip_report_id' => $payslipReport->id,
                           'project_id' => $pro->id,
                           'location_id' => $loc->id,
                           'qty' => count($pro->getUnitTransaction($unit->id, $unitTransaction, $loc->id)),
                           'pokok' => $pro->getValue($unit->id, $unitTransaction, 'Gaji Pokok', $loc->id),
                           'jabatan' => $pro->getValue($unit->id, $unitTransaction,  'Tunj. Jabatan', $loc->id),
                           'ops' => $pro->getValue($unit->id, $unitTransaction, 'Tunj. OPS', $loc->id),
                           'kinerja' => $pro->getValue($unit->id, $unitTransaction, 'Tunj. Kinerja', $loc->id),
                           'fungsional' => $pro->getValue($unit->id, $unitTransaction, 'Tunj. Fungsional', $loc->id),
                           'total' => $pro->getValueGaji($unit->id, $unitTransaction, $loc->id),
   
                           'lain' => $pro->getUnitTransaction($unit->id, $unitTransaction, $loc->id)->sum('additional_penambahan'),
                           'lembur' => $pro->getUnitTransaction($unit->id, $unitTransaction, $loc->id)->sum('overtime'),
            
                           'bruto' => $pro->getValueGaji($unit->id, $unitTransaction, $loc->id) + $pro->getUnitTransaction($unit->id, $unitTransaction, $loc->id)->sum('overtime') + $pro->getUnitTransaction($unit->id, $unitTransaction, $loc->id)->sum('additional_penambahan'),
            
                           'bpjskt' => $pro->getReduction($unit->id, $unitTransaction, 'JHT', $loc->id),
                           'bpjsks' => $pro->getReduction($unit->id, $unitTransaction, 'BPJS KS', $loc->id) + $pro->getAddReduction($unit->id, $unitTransaction, $loc->id),
                           'jp' => $pro->getReduction($unit->id, $unitTransaction, 'JP', $loc->id),
                           'absen' => $pro->getUnitTransaction($unit->id, $unitTransaction, $loc->id)->sum('reduction_absence'),
                           'terlambat' => $pro->getUnitTransaction($unit->id, $unitTransaction, $loc->id)->sum('reduction_late'),
                           'additional_pengurangan' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_pengurangan'),
                           // 'gaji_bersih' => ($pro->getValueGaji($unit->id, $unitTransaction) + $pro->getUnitTransaction($unit->id, $unitTransaction)->sum('overtime') + $pro->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_penambahan') - ($pro->getReduction($unit->id, $unitTransaction, 'JHT') + $pro->getReduction($unit->id, $unitTransaction, 'BPJS KS') + $pro->getReductionAdditional($unit->id, $unitTransaction) + $pro->getReduction($unit->id, $unitTransaction, 'JP') + $pro->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_absence') + $pro->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_late')))
                           'gaji_bersih' => $pro->getValueGajiBersih($unit->id, $unitTransaction, $loc->id)
                        ]);
                        
                     }
                  }
               }
            } else {
               // dd($loc->getValue($unit->id, $unitTransaction, 'Gaji Pokok'));
               $payslipReport->update([
                  
                  'qty' => count($loc->getUnitTransaction($unit->id, $unitTransaction)),
                  'pokok' => $loc->getValue($unit->id, $unitTransaction, 'Gaji Pokok'),
                  'jabatan' => $loc->getValue($unit->id, $unitTransaction,  'Tunj. Jabatan'),
                  'ops' => $loc->getValue($unit->id, $unitTransaction, 'Tunj. OPS'),
                  'kinerja' => $loc->getValue($unit->id, $unitTransaction, 'Tunj. Kinerja'),
                  'fungsional' => $loc->getValue($unit->id, $unitTransaction, 'Tunj. Fungsional'),
                  'total' => $loc->getValueGaji($unit->id, $unitTransaction),
   
                  'lain' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_penambahan'),
                  'lembur' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('overtime'),
   
                  'bruto' => $loc->getValueGaji($unit->id, $unitTransaction) + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('overtime') + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_penambahan'),
   
                  'bpjskt' => $loc->getReduction($unit->id, $unitTransaction, 'JHT'),
                  'bpjsks' => $loc->getReduction($unit->id, $unitTransaction, 'BPJS KS'),
                  'jp' => $loc->getReduction($unit->id, $unitTransaction, 'JP'),
                  'absen' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_absence'),
                  'terlambat' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_late'),
                  'additional_pengurangan' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_pengurangan'),
                  'gaji_bersih' => ($loc->getValueGaji($unit->id, $unitTransaction) + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('overtime') + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_penambahan') - ($loc->getReduction($unit->id, $unitTransaction, 'JHT') + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_pengurangan') + $loc->getReduction($unit->id, $unitTransaction, 'BPJS KS') + $loc->getReductionAdditional($unit->id, $unitTransaction) + $loc->getReduction($unit->id, $unitTransaction, 'JP') + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_absence') + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_late')))
   
   
               ]);
            

               if ($loc->projectExist() ==  true){
                  foreach ($projects as $pro){
                     if (count($pro->totalEmployee($unit->id, $payslipReport->location_id)) > 0){
                        $payslipReportProject = PayslipReportProject::where('unit_transaction_id',$unitTransaction->id)->where('payslip_report_id', $payslipReport->id)->where('location_id', $loc->id)->where('project_id', $pro->id)->first();
                        if ($payslipReportProject == null) {
                           PayslipReportProject::create([
                              'unit_transaction_id' => $unitTransaction->id,
                              'payslip_report_id' => $payslipReport->id,
                              'project_id' => $pro->id,
                              'location_id' => $loc->id,
                              'qty' => count($pro->getUnitTransaction($unit->id, $unitTransaction, $loc->id)),
                              'pokok' => $pro->getValue($unit->id, $unitTransaction, 'Gaji Pokok', $loc->id),
                              'jabatan' => $pro->getValue($unit->id, $unitTransaction,  'Tunj. Jabatan', $loc->id),
                              'ops' => $pro->getValue($unit->id, $unitTransaction, 'Tunj. OPS', $loc->id),
                              'kinerja' => $pro->getValue($unit->id, $unitTransaction, 'Tunj. Kinerja', $loc->id),
                              'fungsional' => $pro->getValue($unit->id, $unitTransaction, 'Tunj. Fungsional', $loc->id),
                              'total' => $pro->getValueGaji($unit->id, $unitTransaction, $loc->id),
      
                              'lain' => $pro->getUnitTransaction($unit->id, $unitTransaction, $loc->id)->sum('additional_penambahan'),
                              'lembur' => $pro->getUnitTransaction($unit->id, $unitTransaction, $loc->id)->sum('overtime'),
               
                              'bruto' => $pro->getValueGaji($unit->id, $unitTransaction, $loc->id) + $pro->getUnitTransaction($unit->id, $unitTransaction, $loc->id)->sum('overtime') + $pro->getUnitTransaction($unit->id, $unitTransaction, $loc->id)->sum('additional_penambahan'),
               
                              'bpjskt' => $pro->getReduction($unit->id, $unitTransaction, 'JHT', $loc->id),
                              'bpjsks' => $pro->getReduction($unit->id, $unitTransaction, 'BPJS KS', $loc->id) + $pro->getAddReduction($unit->id, $unitTransaction, $loc->id),
                              'jp' => $pro->getReduction($unit->id, $unitTransaction, 'JP', $loc->id),
                              'absen' => $pro->getUnitTransaction($unit->id, $unitTransaction, $loc->id)->sum('reduction_absence'),
                              'terlambat' => $pro->getUnitTransaction($unit->id, $unitTransaction, $loc->id)->sum('reduction_late'),
                              'additional_pengurangan' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_pengurangan'),
                              // 'gaji_bersih' => ($pro->getValueGaji($unit->id, $unitTransaction) + $pro->getUnitTransaction($unit->id, $unitTransaction)->sum('overtime') + $pro->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_penambahan') - ($pro->getReduction($unit->id, $unitTransaction, 'JHT') + $pro->getReduction($unit->id, $unitTransaction, 'BPJS KS') + $pro->getReductionAdditional($unit->id, $unitTransaction) + $pro->getReduction($unit->id, $unitTransaction, 'JP') + $pro->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_absence') + $pro->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_late')))
                              'gaji_bersih' => $pro->getValueGajiBersih($unit->id, $unitTransaction, $loc->id)
                           ]);
                        }
                        
                     }
                  }
               }
            }

         }
      }

      return redirect()->back()->with('success', 'Data Report BPJS berhasil di kalibrasi ulang');
   }
}
