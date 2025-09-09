<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Models\Employee;
use App\Models\EmployeeLeader;
use App\Models\Pe;
use App\Models\PeBehaviorApprasial;
use App\Models\PeDiscipline;
use App\Models\PeKpa;
use App\Models\PekpaDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
   public function kpaEmployee($id)
   {
      $dekripId = dekripRambo($id);
      $kpa = PeKpa::find($dekripId);

      $datas = PekpaDetail::where('kpa_id', $kpa->id)->where('addtional', '0')->get();
      // Additional 
      $addtional = PekpaDetail::where('kpa_id', $kpa->id)->where('addtional', '1')->first();
      // dd($kpa->employe->biodata->fullName());
      return view('pages.pdf.kpa-employee', [
         'kpa' => $kpa,
         'datas' => $datas,
         'addtional' => $addtional
      ])->with('i');
   }

   public function kpaSummary($employee, $semester, $tahun)
   {
      $dekripEMployee = dekripRambo($employee);
      $dekripSemester = dekripRambo($semester);
      $dekripTahun = dekripRambo($tahun);
      $employee = Employee::find($dekripEMployee);
      // dd($employee->biodata->fullName());

      if ($dekripSemester == 'I') {
         # JIKA SEMESTER I
         $startMonth = 1; // Bulan Mei
         $endMonth = 6; // Bulan Agustus

         // $products = Product::
         //     ->get();

      } else if ($dekripSemester == 'II') {
         # JIKA SEMSESTER II

         $startMonth = 7; // Bulan Mei
         $endMonth = 12; // Bulan Agustus
      }

      $kpas = PeKpa::where('employe_id', $employee->id)
         ->where('status', '>', 0)
         ->whereYear('date', $dekripTahun)
         ->whereMonth('date', '>=', $startMonth)
         ->whereMonth('date', '<=', $endMonth)
         ->orderBy('date', 'desc')
         ->orderBy('employe_id')
         ->get();

      $months = range($startMonth, $endMonth);


      $achievementData = array_fill_keys($months, 0);

      $achievements = PeKpa::selectRaw('MONTH(date) as month, achievement')
         ->whereIn(DB::raw('MONTH(date)'), $months)
         ->where('employe_id', $employee->id)
         ->where('status', '>', 0)
         ->whereYear('date', $dekripTahun)
         ->get();

      $index = 0;
      foreach ($achievements as $achievement) {
         $month = $achievement->month;
         $achievementData[$month] = $achievement->achievement;

         $index++;
      }

      $rating = PeKpa::where('employe_id', $employee->id)
         ->where('status', '>', 0)
         ->whereYear('date', $dekripTahun)
         ->whereMonth('date', '>=', $startMonth)
         ->whereMonth('date', '<=', $endMonth)
         ->avg('achievement');



      $karyawan = Employee::find($employee->id);

      return view('pages.pdf.kpa-summary', [
         'kpas' => $kpas,
         'karyawan' => $karyawan,
         'semester' => $dekripSemester,
         'tahun' => $dekripTahun,

         'rating' => intval($rating),
         'achievementData' => $achievementData
      ])->with('i');
   }



   public function kpiExample()
   {

      // dd($kpa->employe->biodata->fullName());
      return view('pages.pdf.kpi-example', [
         // 'kpa' => $kpa,
         // 'datas' => $datas,
         // 'addtional' => $addtional
      ])->with('i');
   }


   public function qpe($id)
   {

      $pe = Pe::find($id);
      $pd = PeDiscipline::where('pe_id', $pe->id)->first();
      $kpa = PeKpa::where('pe_id', $pe->id)->first();
      $pba = PeBehaviorApprasial::where('pe_id', $pe->id)->first();
      $kds = PekpaDetail::where('kpa_id', $kpa->id)
         ->where('addtional', '0')
         ->get();

      $kda = PekpaDetail::where('kpa_id', $kpa->id)
         ->where('addtional', '1')
         ->first();



      if (auth()->user()->hasRole('Administrator')) {
         // dd($pe->department_id);
         // $pe->update([
         //    'department_id' => $pe->employe->department_id
         // ]);

         $employe = Employee::find($pe->employe_id);

         $allManagers = Employee::where('role', 5)->get();
         $manager = Employee::where('department_id', $employe->department_id)->where('role', 5)->first();
         // dd($managers);
         // dd($pe->asmen_id);
         $asmen = Employee::find($pe->asmen_id);
         $employeeLeaders = EmployeeLeader::where('employee_id', $pe->asmen_id)->first();
         // dd($employeeLeaders->leader->biodata->fullName());

         if ($manager == null) {
            foreach($allManagers as $man){
               if (count($man->positions) > 0) {
                  foreach($man->positions as $pos){
                     if ($pos->department_id == $employe->department_id) {
                        $manager = $man;
                     }
                  }
               }
            }
         }
         // $asmen = $pe->verifikasi_by;
         $pe->update([
            // 'asmen_id' => $asmen,
            'verifikasi_by' => $employeeLeaders->leader_id
         ]);

         // dd($manager);
      }

      // dd($kpa->employe->biodata->fullName());
      return view('pages.pdf.qpe-pdf', [
         'pe' => $pe,
         'pd' => $pd,
         'kpa' => $kpa,
         'pba' => $pba,
         'kds' => $kds,
         'kda' => $kda,
      ])->with('i');
   }

   public function employee($unit, $loc, $gender, $type)
   {

      if ($gender == 'All') {
         // dd('all');
         if ($type == 'All') {
            // dd('ok');
            $employees = Employee::join('biodatas', 'employees.biodata_id', '=', 'biodatas.id')        
            ->join('contracts', 'employees.contract_id', '=', 'contracts.id')->where('contracts.loc', $loc)
            ->select('employees.*')->where('employees.unit_id', $unit)->get();
         } else {
            // dd('okee');
            $employees = Employee::join('biodatas', 'employees.biodata_id', '=', 'biodatas.id')        
            ->join('contracts', 'employees.contract_id', '=', 'contracts.id')->where('contracts.loc', $loc)
            ->where('contracts.type', $type)
            ->select('employees.*')->where('employees.unit_id', $unit)->get();
            // dd($employees);
         }
         
      } else {
         if ($type == 'All') {
            $employees = Employee::join('biodatas', 'employees.biodata_id', '=', 'biodatas.id')->where('biodatas.gender', $gender)        
            ->join('contracts', 'employees.contract_id', '=', 'contracts.id')->where('contracts.loc', $loc)
            ->select('employees.*')->where('employees.unit_id', $unit)->get();
         } else {
            $employees = Employee::join('biodatas', 'employees.biodata_id', '=', 'biodatas.id')->where('biodatas.gender', $gender)  
            ->join('contracts', 'employees.contract_id', '=', 'contracts.id')->where('contracts.loc', $loc)
            ->where('contracts.type', $type)
            ->select('employees.*')->where('employees.unit_id', $unit)->get();
         }
      }

      return view('pages.pdf.employee', [
         'employees' => $employees
      ])->with('i');
   }

   public function employeeExcel($unit, $loc, $gender, $type){
      $now = Carbon::now();
      dd($unit);
      return Excel::download(new EmployeeExport($unit, $loc, $gender, $type), 'employee.xlsx');
   }
}
