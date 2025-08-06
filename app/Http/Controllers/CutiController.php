<?php

namespace App\Http\Controllers;

use App\Imports\CutiImport;
use App\Models\Absence;
use App\Models\Contract;
use App\Models\Cuti;
use App\Models\Employee;
use App\Models\Log;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CutiController extends Controller
{
   public function index(){
      $cutis = Cuti::get();


      // GENERATE PERIODE CUTI KARYAWAN TETEP DARI JOIN DATE
      // $tetapContrats = Contract::where('type', 'Tetap')->get();
      // foreach($tetapContrats as $tcon){
      //    $employee = Employee::find($tcon->employee_id);
      
      //    if ($employee) {
      //       $joinDate = Carbon::create($employee->join);
      //       $nexYearJoin = Carbon::create($employee->join)->addYear();
      //       // $nextYear = $joinDate->addYear();

      //       $cutiEmp = Cuti::where('employee_id', $tcon->employee_id)->first();
      //       if ($cutiEmp ) {
      //          // dd($joinDate->addYear());
      //          $cutiEmp->update([
      //             'start' => $joinDate,
      //             'end' => $nexYearJoin
      //          ]);


      //          $now = Carbon::now();
      //          if ($cutiEmp->start < $now) {
      //             // dd($cutiEmp->employee->nik);
      //             $cutiStart = Carbon::create($cutiEmp->start);
      //             $cutiEnd = Carbon::create($cutiEmp->end);
      //             $nowStart = Carbon::create($now->format('Y') . '-' . $cutiStart->format('m') . '-' . $cutiStart->format('d'));
                  
      //             if ($nowStart > $now) {
      //                // dd($nowStart);
      //                $finalStartDate = $nowStart->addYear(-1);
      //                // dd($finalStartDate);
      //                $cutiEmp->update([
      //                   'start' => $finalStartDate,
      //                   // 'end' => $finalEndDate
      //                ]);
                     
      //                $end = $nowStart->addYear(1);
      //                $finalEndDate = $end;
      //                $cutiEmp->update([
      //                   // 'start' => $finalStartDate,
      //                   'end' => $finalEndDate
      //                ]);

      //                // dd($finalStartDate);
      //                // dd('start:' . $finalStartDate . ' end:'. $finalEndDate);
      //                // dd($nowStart->addYear(-1));

      //             } else {
      //                $finalStartDate = $nowStart;
      //                $cutiEmp->update([
      //                   'start' => $finalStartDate,
      //                   // 'end' => $finalEndDate
      //                ]);
      //                $finalEndDate = $nowStart->addYear(1);
      //                $cutiEmp->update([
      //                   // 'start' => $finalStartDate,
      //                   'end' => $finalEndDate
      //                ]);
      //             }

                  

      //             $this->calculateCuti($cutiEmp->id);
                  

      //          }

      //       }
      //    }
         
         
      // }
      // END GENERATE PERIODE CUTI KARYAWAN TETEP DARI JOIN DATE

      // $contracts = Contract::where('type', 'Kontrak')->get();
      // foreach($contracts as $con){
      //    $cutiEmp = Cuti::where('employee_id', $con->employee_id)->first();
      //    if ($cutiEmp) {
      //       $cutiEmp->update([
      //       'start' => $con->start,
      //       'end' => $con->end,
      //       'tahunan' => 12,
      //    ]);

      //    $this->calculateCuti($cutiEmp->id);
      //    }
         

      // }

      

      // kalkulasi cuti dipakai dari table Absences
      // foreach($cutis as $cuti){
      //    if ($cuti->start != null && $cuti->end != null) {
      //       $absences = Absence::where('employee_id', $cuti->employee->id)->where('date', '>=', $cuti->start)->where('date', '<=', $cuti->end)->where('type', 5)->get();
      foreach($cutis as $cuti){
         $this->calculateCuti($cuti->id);
         // if ($cuti->start != null && $cuti->end != null) {
         //    $absences = Absence::where('employee_id', $cuti->employee->id)->where('date', '>=', $cuti->start)->where('date', '<=', $cuti->end)->where('type', 5)->get();
         //       $used = count($absences);
         //       $cuti->update([
         //          'used' => $used,
         //          'sisa' => $cuti->total - $used
         //       ]);
         //    }
         // }
         //    $used = count($absences);
         //    $cuti->update([
         //       'used' => $used,
         //       'sisa' => $cuti->total - $used
         //    ]);
         // }
      }

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
      // dd('ok');
      $today = Carbon::now();
      // dd($cutis);

      // foreach($cutis as $cuti){
      //    $contract = Contract::find($cuti->employee->contract_id);
      //    // if ($contract->start != null && $contract->end != null) {
      //    //    // dd($cuti->start);
      //    //    $absences = Absence::where('employee_id', $cuti->employee->id)->where('date', '>=', $contract->start)->where('date', '<=', $contract->end)->where('type', 5)->get();
      //    //    if ($cuti->expired != null) {
      //    //       if ($cuti->expired < $today) {
      //    //          $extend = $cuti->extend;
      //    //       } else {
      //    //          $extend = 0;
      //    //       }
      //    //    } else {
      //    //       $extend = $cuti->extend;
      //    //    }

      //    //    $total = $cuti->tahunan + $cuti->masa_kerja + $extend;
      //    //    $cuti->update([
      //    //       'used' => count($absences),
      //    //       'total' => $total,
      //    //       'sisa' => $total - count($absences)
      //    //    ]);
      //    // }


      //    // Generate Data Cuti
         
      //    if ($cuti->employee->contract->type == 'Tetap') {
      //       // // dd($cuti->employee->biodata->fullName());
      //       // $join = Carbon::create($cuti->employee->join);
      //       // // dd($join);
      //       // $start = Carbon::create($today->format('Y') . '-' . $join->format('m-d')  );
      //       // $startB = Carbon::create($today->format('Y') . '-' . $join->format('m-d')  );
      //       // // dd($start);

      //       // if ($start > $today) {
      //       //    // dd($start->subYear());
      //       //    $fixStart = $start->subYear();
      //       //    $finalStart = $fixStart;
      //       //    $finalEnd = $startB;
               
      //       //    // dd($start->addYear());
      //       //    // $finalEnd = $start
      //       // } else {
      //       //    //  dd($cuti->employee->biodata->fullName());
      //       //    $finalStart = $startB;
      //       //    $finalEnd = $start->addYear();
      //       // }

      //       // $cuti->update([
      //       //    'start' => $finalStart,
      //       //    'end' => $finalEnd
      //       // ]);
      //    } elseif($cuti->employee->contract->type == 'Kontrak') {
      //       // $cuti->update([
      //       //    'start' => $contract->start,
      //       //    'end' => $contract->end
      //       // ]);
      //    }
        
         
      // }

      // Generate Cuti Masa Kerja
      // $today = Carbon::now();
      // foreach($cutis as $cuti){
      //    $contract = Contract::find($cuti->employee->contract_id);
         
      //    if ($contract->type == 'Tetap') {
      //       $startDate = Carbon::parse($contract->determination); 
      //       $endDate = Carbon::parse($today); 
      //       $diffYear = $startDate->diffInYears($endDate);
      //       // dd($cuti->employee->biodata->fullName());
      //       if ($diffYear >= 25) {
      //          $cuti->update([
      //             'masa_kerja' => 10
      //          ]);
      //       } elseif($diffYear >= 20){
      //          $cuti->update([
      //             'masa_kerja' => 8
      //          ]);
      //       } elseif($diffYear >= 15){
      //          $cuti->update([
      //             'masa_kerja' => 6
      //          ]);
      //       } elseif($diffYear >= 10){
      //          $cuti->update([
      //             'masa_kerja' => 4
      //          ]);
      //       } elseif($diffYear >= 5){
      //          $cuti->update([
      //             'masa_kerja' => 2
      //          ]);
      //       } 
      //    } 
         
      // }

      // dd($cutis);



      return view('pages.cuti.index', [
         'cutis' => $cutis
      ]);
   }

   public function indexEmployee(){
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $cuti = Cuti::where('employee_id', $employee->id)->first();
      if ($cuti->start){
      $absences = Absence::where('employee_id', $cuti->employee->id)->where('date', '>=', $cuti->start)->where('date', '<=', $cuti->end)->where('type', 5)->get();
      } else {
         $absences = [];
      }

      $this->calculateCuti($cuti->id);
      return view('pages.cuti.employee.index', [
         'cuti' => $cuti,
         'employee' => $employee,
         'absences' => $absences
      ]);
   }

   public function edit($id){
      $cuti = Cuti::find(dekripRambo($id));
      // dd('ok');
      $this->calculateCuti($cuti->id);
      // dd($cut);
      if ($cuti->start) {
         $absences = Absence::where('employee_id', $cuti->employee->id)->where('date', '>=', $cuti->start)->where('date', '<=', $cuti->end)->where('type', 5)->get();
         // dd($cuti->start);
         // $used = count($absences);
         // $cuti->update([
         //    'used' => $used,
         //    'sisa' => $cuti->total - $used
         // ]);
      } else {
         $absences = [];
      }
       
      
// dd('oke');

      // dd($cuti->employee->contract->type);
      return view('pages.cuti.edit', [
         'cuti' => $cuti,
         'absences' => $absences
      ]);
   }

   public function update(Request $req){
      $cuti = Cuti::find($req->cutiId);
      $today = Carbon::now();
      
      // dd($cuti);
      $contract = Contract::find($cuti->employee->contract_id);
      if ($cuti->start != null && $cuti->end != null) {
      $absences = Absence::where('employee_id', $cuti->employee->id)->where('date', '>=', $cuti->start)->where('date', '<=', $cuti->end)->where('type', 5)->get();
      } else {
         $absences = [];
      }
      if ($cuti->start != null && $cuti->end != null) {
         $absences = Absence::where('employee_id', $cuti->employee->id)->where('date', '>=', $cuti->start)->where('date', '<=', $cuti->end)->where('type', 5)->get();
      } else {
         $absence = [];
      }
      

      if ($req->expired != null) {
         if ($req->expired < $today) {
            $extend = $req->extend;
         } else {
            $extend = 0;
         }

      } else {
         $extend = 0;
      }

      $total = $req->tahunan + $req->masa_kerja + $extend;
      // $cuti->update([
      //    'used' => count($absences),
      //    'total' => $total,
      //    'sisa' => $total - count($absences)
      // ]);

      

      $cuti->update([
         'start' => $req->periode_start,
         'end' => $req->periode_end,
         'tahunan' => $req->tahunan,
         'masa_kerja' => $req->masa_kerja,
         'extend' => $req->extend,
         'expired' => $req->expired,
         'total' => $total,
         'used' => $req->used,
         'sisa' => $total - $req->used
      ]);

      return redirect()->back()->with('success', 'Data Cuti updated');
   }

   public function import(){
      return view('pages.cuti.import');
   }

   public function importStore(Request $req)
   {

      $req->validate([
         'excel' => 'required'
      ]);
      $file = $req->file('excel');
      $fileName = $file->getClientOriginalName();
      $file->move('CutiData', $fileName);

      try {
         // Excel::import(new CargoItemImport($parent->id), $req->file('file-cargo'));
         // dd($fileName);
         Excel::import(new CutiImport, public_path('CutiData/' . $fileName));

         
      } catch (Exception $e) {
         return redirect()->back()->with('danger', 'Import Failed ' . $e->getMessage());
      }

      if (auth()->user()->hasRole('Administrator')) {
         $departmentId = null;
         $userId = 1;
      } else {
         $user = Employee::find(auth()->user()->getEmployeeId());
         $userId = $user->id;
         $departmentId = $user->department_id;
      }
      Log::create([
         'department_id' => $departmentId,
         'user_id' => auth()->user()->id,
         'action' => 'Import',
         'desc' => 'Data Cuti '
      ]);


      return redirect()->route('cuti')->with('success', 'Cuti Data successfully imported');
   }

   public function calculateCuti($cuti){
      $today = Carbon::now();
      $cuti = Cuti::find($cuti);
      // dd($cuti->end);
      $contract = Contract::find($cuti->employee->contract_id);
      
      if ($cuti->expired != null) {
         
         $expired = Carbon::create($cuti->expired);
         // if(auth()->user()->hasRole('Administrator')){
            
         //    dd($today->format('Y-m-d'));
         // }
         
         if ($cuti->expired > $today->format('Y-m-d')) {
            $extend = $cuti->extend;
            // if(auth()->user()->hasRole('Administrator')){
            
            //    dd($extend);
            // }
            
         } else {
           
            $extend = 0;
         }
      } else {
         $extend = $cuti->extend;
      }
      // dd('ok');
      if ($cuti->start != null && $cuti->end != null) {
         $absences = Absence::where('employee_id', $cuti->employee->id)->where('date', '>=', $cuti->start)->where('date', '<=', $cuti->end)->where('type', 5)->get();
         // dd(count($absences));
         if ($cuti->expired != null) {
            $absencesExtend = Absence::where('employee_id', $cuti->employee->id)->where('date', '>=', $cuti->start)->where('date', '<=', $cuti->expired)->where('type', 5)->get();
            
            if(count($absencesExtend) > $cuti->extend ){
               $extendSisa = count($absencesExtend) - $cuti->extend;
               $cuti->update([
                  'extend_left' => 0
               ]);
            } else {
               $cuti->update([
                  'extend_left' => $cuti->extend - count($absencesExtend)
               ]);
               $extendSisa = 0;
            }
            
         } else {
            $absencesExtend = [];
            $extendSisa = 0;
         }
         
         
         $countAbsence = count($absences) - count($absencesExtend) + $extendSisa;
         // dd($countAbsence);
        
      } else {
         $countAbsence = 0;
      }
      // dd($countAbsence);

      $total = $cuti->tahunan + $cuti->masa_kerja + $extend;
      // dd($total - $countAbsence);
      $cuti->update([
         'used' => $countAbsence,
         'total' => $total,
         'sisa' => $total - $countAbsence
      ]);

      return $cuti->sisa;

      // dd($cuti->sisa);

   }

}
