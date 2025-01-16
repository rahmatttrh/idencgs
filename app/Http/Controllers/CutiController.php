<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Contract;
use App\Models\Cuti;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CutiController extends Controller
{
   public function index(){
      // $employees = Employee::where('status', 1)->get();
      // foreach($employees as $emp){
      //    Cuti::create([
      //       'employee_id' => $emp->id,
      //       'tahunan' => 12,
      //       'masa_kerja' => 0,
      //       'extend' => 0,
      //       'total' => 12,
      //       'used' => 0,
      //       'sisa' => 12
      //    ]);
      // }


      $cutis = Cuti::get();
      $today = Carbon::now();
      // dd($cutis);

      foreach($cutis as $cuti){
         $contract = Contract::find($cuti->employee->contract_id);
         // if ($contract->start != null && $contract->end != null) {
         //    // dd($cuti->start);
         //    $absences = Absence::where('employee_id', $cuti->employee->id)->where('date', '>=', $contract->start)->where('date', '<=', $contract->end)->where('type', 5)->get();
         //    if ($cuti->expired != null) {
         //       if ($cuti->expired < $today) {
         //          $extend = $cuti->extend;
         //       } else {
         //          $extend = 0;
         //       }
         //    } else {
         //       $extend = $cuti->extend;
         //    }

         //    $total = $cuti->tahunan + $cuti->masa_kerja + $extend;
         //    $cuti->update([
         //       'used' => count($absences),
         //       'total' => $total,
         //       'sisa' => $total - count($absences)
         //    ]);
         // }

         if ($cuti->employee->contract->type == 'Tetap') {
            $cuti->update([
               'start' => $cuti->employee->contract->start,
               'end' => $cuti->employee->contract->end
            ]);
         } else {
            $cuti->update([
               'start' => null,
               'end' => null
            ]);
         }
        
         
      }

      // dd($cutis);



      return view('pages.cuti.index', [
         'cutis' => $cutis
      ]);
   }

   public function edit($id){
      $cuti = Cuti::find(dekripRambo($id));
      $absences = Absence::where('employee_id', $cuti->employee->id)->where('date', '>=', $cuti->start)->where('date', '<=', $cuti->end)->where('type', 5)->get();

      return view('pages.cuti.edit', [
         'cuti' => $cuti,
         'absences' => $absences
      ]);
   }

   public function update(Request $req){
      $cuti = Cuti::find($req->cutiId);
      $today = Carbon::now();

      $contract = Contract::find($cuti->employee->contract_id);
      $absences = Absence::where('employee_id', $cuti->employee->id)->where('date', '>=', $contract->start)->where('date', '<=', $contract->end)->where('type', 5)->get();

      if ($req->expired != null) {
         if ($cuti->expired < $today) {
            $extend = $cuti->extend;
         } else {
            $extend = 0;
         }

      } else {
         $extend = 0;
      }

      $total = $cuti->tahunan + $cuti->masa_kerja + $extend;
      // $cuti->update([
      //    'used' => count($absences),
      //    'total' => $total,
      //    'sisa' => $total - count($absences)
      // ]);

      

      $cuti->update([
         'tahunan' => $req->tahunan,
         'masa_kerja' => $req->masa_kerja,
         'extend' => $req->extend,
         'expired' => $req->expired,
         'total' => $total,
         'used' => $req->used,
         'sisa' => $total - $req->used
      ]);

      return redirect()->route('cuti')->with('success', 'Data Cuti updated');
   }
}
