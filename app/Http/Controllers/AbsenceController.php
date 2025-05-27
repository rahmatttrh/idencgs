<?php

namespace App\Http\Controllers;

use App\Exports\AbsenceDataExport;
use App\Exports\AbsenceExport;
use App\Imports\AbsencesImport;
use App\Models\Absence;
use App\Models\AbsenceEmployee;
use App\Models\Cuti;
use App\Models\Employee;
use App\Models\EmployeeLeader;
use App\Models\Location;
use App\Models\Log;
use App\Models\Payroll;
use App\Models\Transaction;
use App\Models\Unit;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Adapter\Local;
use Maatwebsite\Excel\Facades\Excel;

class AbsenceController extends Controller
{
   public function index()
   {

      $now = Carbon::now();
      $employees = Employee::get();

      $export = false;
      $loc = 'All';
      $locations = Location::get();
      // dd('ok');

      if (auth()->user()->hasRole('HRD-KJ12')) {
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj1-2')
            ->orWhere('contracts.loc', 'kj1-2-medco')
            ->orWhere('contracts.loc', 'kj1-2-premier-oil')
            ->orWhere('contracts.loc', 'kj1-2-petrogas')
            ->orWhere('contracts.loc', 'kj1-2-star-energy')
            ->orWhere('contracts.loc', 'kj1-2-housekeeping')
            ->select('employees.*')
            ->get();

            // $employees = Employee::where('status', 1)->where('location_id', 3)->get();

         $absences = Absence::whereIn('location_id', [3,11,12,13,14,20])->orderBy('updated_at', 'desc')->paginate(800);
      } elseif (auth()->user()->hasRole('HRD-KJ45')) {

         // dd('ok');
         // $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
         //    ->where('contracts.loc', 'kj4')->orWhere('contracts.loc', 'kj5')
         //    ->select('employees.*')
         //    ->get();
         // $employees = Employee::where('status', 1)->where('location_id', 4)->orWhere('location_id', 5)->get();
         $employees = Employee::whereIn('location_id',[4,5,21,22])->where('status', 1)->get();
         $absences = Absence::whereIn('location_id', [4,5,21,22])->orderBy('date', 'asc')->paginate(800);
      } elseif (auth()->user()->hasRole('HRD-JGC')) {

         // dd('ok');
         // $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
         //    ->where('contracts.loc', 'jgc')
         //    ->select('employees.*')
         //    ->get();
         $employees = Employee::where('status', 1)->whereIn('unit_id', [10,13,14])->get();
         // $absences = Absence::orWhere('location_id', 2)->orderBy('date', 'asc')->paginate(800);

         $absences = Absence::join('employees', 'absences.employee_id', '=', 'employees.id')
         ->whereIn('employees.unit_id', [10,13,14])->orderBy('absences.updated_at', 'desc')->select('absences.*')
         ->get();
      } else {
         // dd('ok');
         $employees = Employee::where('status', 1)->get();
         $absences = Absence::orderBy('updated_at', 'desc')->paginate(800);
      }


      $units = Unit::get();
      $locations = Location::get();

      if (auth()->user()->hasRole('HRD-KJ12') || auth()->user()->hasRole('HRD-KJ45') || auth()->user()->hasRole('HRD-JGC'))  {
         return view('pages.payroll.absence.employee', [
            'unitAll' => 1,
            'locAll' => 1,
            'allUnits' => $units,
            'allLocations' => $locations,
            'units' => $units,
            'locations' => $locations,
           
            'export' => $export,
            'loc' => $loc,
            'locations' => $locations,
            'employees' => $employees,
            'absences' => $absences,
            'month' => $now->format('F'),
            'year' => $now->format('Y'),
            'from' => $now->format('d-m-Y'),
            'to' => $now->format('d-m-Y')
         ])->with('i');
      } else {
         return view('pages.payroll.absence.summary', [
            'unitAll' => 1,
            'locAll' => 1,
            'allUnits' => $units,
            'allLocations' => $locations,
            'units' => $units,
            'locations' => $locations,
           
            'export' => $export,
            'loc' => $loc,
            'locations' => $locations,
            'employees' => $employees,
            'absences' => $absences,
            'month' => $now->format('F'),
            'year' => $now->format('Y'),
            'from' => $now->format('d-m-Y'),
            'to' => $now->format('d-m-Y')
         ])->with('i');
      }

      
   }

   public function indexUnit(Request $req){
      // dd('ok');
      $unit = Unit::find($req->unit);
      // dd($req->from);
      $employees = Employee::where('unit_id', $unit->id)->whereIn('location_id', $req->locations)->get();

      $locations = Location::whereIn('id', $req->locations)->get();
      // dd($req->from);
      if ($req->from == null) {
         $from = 0;
      } else {
         $from = $req->from;
      }

      if ($req->to == null) {
         $to = 0;
      } else {
         $to = $req->to;
      }
      $allUnits = Unit::get();
      $allLocations = Location::get();
      return view('pages.payroll.absence.summary-unit', [
         'allUnits' => $allUnits,
         'allLocations' => $allLocations,
         'locations' => $locations,
         'unit' => $unit,
         'employees' => $employees,
         'from' => $from,
         'to' => $to,
         'locAll' => $req->locAll
      ])->with('i');

   }

   public function indexLoc($unit, $loc, $from, $to, $locAll){
      $employees = Employee::where('unit_id', dekripRambo($unit))->where('location_id', dekripRambo($loc))->get();
      $unit = Unit::find(dekripRambo($unit));
      $location = Location::find(dekripRambo($loc));
      if ($from == null) {
         $ffrom = 0;
      } else {
         $ffrom = $from;
      }
      if ($to == null) {
         $fto = 0;
      } else {
         $fto = $to;
      }
      $allUnits = Unit::get();
      $allLocations = Location::get();
      return view('pages.payroll.absence.summary-loc', [
         'allUnits' => $allUnits,
         'allLocations' => $allLocations,
         'location' => $location,
         'unit' => $unit,
         'employees' => $employees,
         'from' => $ffrom,
         'to' => $fto,
         'locAll' => $locAll
      ])->with('i');
   }

   public function indexUnitB($unit, $from, $to){
      // dd('ok');
      $unit = Unit::find(dekripRambo($unit));
      $employees = Employee::where('unit_id', $unit->id)->get();

      return view('pages.payroll.absence.summary-unit', [
         'unit' => $unit,
         'employees' => $employees,
         'from' => dekripRambo($from),
         'to' => dekripRambo($to)
      ])->with('i');

   }

   public function detail($id){
      $absence = Absence::find(dekripRambo($id));
      $employee = Employee::find($absence->employee_id);
      $absenceEmp = AbsenceEmployee::where('absence_id', $absence->id)->first(); 
      $cuti = Cuti::where('employee_id', $employee->id)->first();
      return view('pages.payroll.absence.detail', [
         'absence' => $absence,
         'employee' => $employee,
         'absenceEmp' => $absenceEmp,
         'cuti' => $cuti
      ]);
   }


   public function refresh(){
      dd('ok');
      $absences = Absence::get();
      $employees = Employee::where('status', 1)->get();
      foreach($employees as $emp){
         $duplicated = DB::table('absences')->where('type', 2)->where('employee_id', $emp->id)
                    ->select('date', DB::raw('count(`date`) as occurences'))
                    ->groupBy('date')
                    ->having('occurences', '>', 1)
                    ->get();

         foreach($duplicated as $dup){
            // dd($dup->date);
            $overtime = Overtime::where('type', 2)->where('employee_id', $emp->id)->where('date', $dup->date)->first();
            $overtime->delete();
         }
      }
   }

   public function team()
   {

      $now = Carbon::now();
      

      $export = false;
      $loc = 'All';
      $locations = Location::get();

      $employee = Employee::where('nik', auth()->user()->username)->first();
      $myTeamAbsences = EmployeeLeader::join('absences', 'employee_leaders.employee_id', '=', 'absences.employee_id')
     
      ->where('leader_id', $employee->id)
      ->select('absences.*')
      ->get();

      $employees = Employee::join('employee_leaders', 'employees.id', '=', 'employee_leaders.employee_id')
            
            ->where('leader_id', $employee->id)
            ->select('employees.*')
            ->get();


      




      return view('pages.payroll.absence.team', [
         'export' => $export,
         'loc' => $loc,
         'locations' => $locations,
         'employee' => $employee,
         'employees' => $employees,
         'absences' => $myTeamAbsences,
         'month' => $now->format('F'),
         'year' => $now->format('Y'),
         'from' => 0,
         'to' => 0
      ])->with('i');
   }

   public function filterTeam(Request $req){
      // dd('ok');
      // $overtimes = Overtime::get();
      $now = Carbon::now();
      $export = false;
      $loc = 'All';
      $locations = Location::get();

      $employee = Employee::where('nik', auth()->user()->username)->first();
      

      $employees = Employee::join('employee_leaders', 'employees.id', '=', 'employee_leaders.employee_id') 
            ->where('leader_id', $employee->id)
            ->select('employees.*')
            ->get();

     

      
      return view('pages.payroll.absence.team', [
         'employee' => $employee,
         'employees' => $employees,
         'export' => $export,
         'loc' => $loc,
         'locations' => $locations,
         // 'overtimes' => $myTeamOvertimes,
         // 'employees' => $employees,
         'month' => $now->format('F'),
         'year' => $now->format('Y'),
         'from' => $req->from,
         'to' => $req->to
         // 'holidays' => $holidays
      ])->with('i');
   }

   public function approval()
   {

      $now = Carbon::now();
      $employees = Employee::get();
      $absences = Absence::where('status', 404)->get();
      return view('pages.payroll.absence.approval', [
         'employees' => $employees,
         'absences' => $absences,
      ])->with('i');
   }



   public function approve(Request $req)
   {
      $absence = Absence::find($req->absence);
      $absence->update([
         'status' => null,
         'type' => $absence->type_req,
         'type_req' => null
      ]);

      return redirect()->back()->with('success', 'Permintaan Perubahan Absensi disetujui');
   }

   public function reject(Request $req)
   {
      $absence = Absence::find($req->absence);
      $absence->update([
         'status' => 505,
         'desc' => $req->desc
      ]);

      return redirect()->back()->with('success', 'Permintaan Perubahan Absensi ditolak');
   }

   public function create()
   {
      $now = Carbon::now();
      $employees = Employee::with('biodata')->get();
      $absences = Absence::orderBy('updated_at', 'desc')->paginate(10);

      if (auth()->user()->hasRole('HRD-KJ12')) {
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj1-2')
            ->orWhere('contracts.loc', 'kj1-2-medco')
            ->orWhere('contracts.loc', 'kj1-2-premier-oil')
            ->orWhere('contracts.loc', 'kj1-2-petrogas')
            ->orWhere('contracts.loc', 'kj1-2-star-energy')
            ->orWhere('contracts.loc', 'kj1-2-housekeeping')
            ->where('employees.status', 1)
            ->select('employees.*')
            ->get();
      } elseif (auth()->user()->hasRole('HRD-KJ45')) {

         // dd('ok');
         // $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
         //    ->where('contracts.loc', 'kj4')->orWhere('contracts.loc', 'kj5')
         //    ->select('employees.*')
         //    ->get();

            $employees = Employee::whereIn('location_id',[4,5,21,22])->where('status', 1)->get();
      } elseif (auth()->user()->hasRole('HRD-JGC')) {

         // dd('ok');
         $employees = Employee::whereIn('unit_id', [10,13,14])
            ->where('employees.status', 1)
            ->get();
         
      } else {
         // dd('ok');
         $employees = Employee::where('status', 1)->get();
      }



      return view('pages.payroll.absence.form', [
         'employees' => $employees,
         'absences' => $absences,
         'month' => $now->format('F'),
         'year' => $now->format('Y'),
         'from' => null,
         'to' => null
      ])->with('i');
   }

   public function edit($id)
   {
      // dd('ok');
      $absence = Absence::find(dekripRambo($id));
      // $absences = Absence::get();
      $employees = Employee::where('status', 1)->get();

      return view('pages.payroll.absence.edit', [
         // 'absences' => $absences,
         'absence' => $absence,
         'employees' => $employees
      ]);
   }

   public function update(Request $req)
   {
      $absence = Absence::find($req->absenceId);
      if ($req->evidence) {
         $evidence = request()->file('evidence')->store('absence/evidence');
      } else {
         $evidence = null;
      }

      $employee = Employee::find($req->employee);
      $payroll = Payroll::find($employee->payroll_id);
      $date = Carbon::create($req->date);

      $locations = Location::get();

      foreach ($locations as $loc) {
         if ($loc->code == $employee->contract->loc) {
            $location = $loc->id;
         }
      }

      $value =  1 * 1 / 30 * $payroll->total;

      if ($req->minute == 'T1') {
         $min = 30;
      } elseif($req->minute == 'T2'){
         $min = 60;
      } elseif($req->minute == 'T3'){
         $min = 90;
      } elseif($req->minute == 'T4'){
         $min = 120;
      } else {
         $min = null;
      }

      if (auth()->user()->hasRole('Administrator|HRD|HRD-Payroll|HRD-KJ45|HRD-KJ12')) {
         $absence->update([
            'type' => $req->type,
            'employee_id' => $req->employee,
            'month' => $date->format('F'),
            'year' => $date->format('Y'),
            'date' => $req->date,
            'desc' => $req->desc,
            'doc' => $evidence,
            'minute' => $min,
            'location_id' => $location,
            'type_izin' => $req->type_izin,
            'type_spt' => $req->type_spt,
            'value' => $value
         ]);
      } else {
         $absence->update([
            'status' => 404,
            'type_req' => $req->type,
            'doc' => $evidence
         ]);
      }


      return redirect()->back()->with('success', 'Absence successfully updated');
   }

   public function downloadTemplate(Request $req)
   {
      $req->validate([]);

      $data = [
         'date' => $req->date,
         'bu' => $req->bu,
         'location' => $req->location,
      ];

      if ($req->location == 'all') {
         # code...
         $location = 'semua-lokasi';
      } else {
         # code...
         $loc = Location::find($req->location);
         $location = $loc->name;
      }


      return Excel::download(new AbsenceExport($data), 'template-import-ketidakhadiran-' . $location . '.xlsx');
   }

   public function import()
   {
      $now = Carbon::now();
      $employees = Employee::get();
      $absences = Absence::get();
      $units = Unit::orderBy('name')->get();
      $locations = Location::orderBy('name')->get();


      return view('pages.payroll.absence.import', [
         'employees' => $employees,
         'absences' => $absences,
         'units' => $units,
         'locations' => $locations,
         'month' => $now->format('F'),
         'year' => $now->format('Y'),
         'from' => null,
         'to' => null
      ])->with('i');
   }


   public function importStore(Request $req)
   {
      // dd('ok');
      $req->validate([
         'excel' => 'required'
      ]);

      $file = $req->file('excel');
      $fileName = $file->getClientOriginalName();
      $file->move('AbsenceData', $fileName);


      try {
         // Excel::import(new CargoItemImport($parent->id), $req->file('file-cargo'));
         Excel::import(new AbsencesImport, public_path('/AbsenceData/' . $fileName));
      } catch (Exception $e) {
         return redirect()->back()->with('danger', 'Import Failed ' . $e->getMessage());
      }

      if (auth()->user()->hasRole('Administrator')) {
         $departmentId = null;
      } else {
         $user = Employee::find(auth()->user()->getEmployeeId());
         $departmentId = $user->department_id;
      }
      Log::create([
         'department_id' => $departmentId,
         'user_id' => auth()->user()->id,
         'action' => 'Import',
         'desc' => 'Data Absence '
      ]);



      return redirect()->route('payroll.absence')->with('success', 'Absence Data successfully imported');
   }


   public function filter(Request $req)
   {
      $req->validate([]);



      if (auth()->user()->hasRole('HRD-KJ12')) {
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj1-2')
            ->select('employees.*')
            ->get();

         $absences = Absence::where('location_id', 4)->orWhere('location_id', 5)->whereBetween('date', [$req->from, $req->to])->get();
      } elseif (auth()->user()->hasRole('HRD-KJ45')) {

         // dd('ok');
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj4')->orWhere('contracts.loc', 'kj5')
            ->select('employees.*')
            ->get();
         $absences = Absence::where('location_id', 3)->whereBetween('date', [$req->from, $req->to])->get();
         if ($req->loc == 'KJ45') {
            $absences = Absence::whereBetween('date', [$req->from, $req->to])->where('location_id', 4)->orWhere('location_id', 5)->get();
         } else {
            $absences = Absence::whereBetween('date', [$req->from, $req->to])->get();
         }
      } else {
         // dd('ok');
         $employees = Employee::get();
         $absences = Absence::whereBetween('date', [$req->from, $req->to])->get();
      }

      if ($req->loc == 'KJ45') {
         $absences = Absence::whereBetween('date', [$req->from, $req->to])->where('location_id', 4)->orWhere('location_id', 5)->get();
      } else {
         $absences = Absence::whereBetween('date', [$req->from, $req->to])->get();
      }

      

      $loc = $req->loc;
      $employees = Employee::get();
      $export = true;
      return view('pages.payroll.absence.index', [
         'loc' => $loc,
         'export' => $export,
         'employees' => $employees,
         'absences' => $absences,
         'from' => $req->from,
         'to' => $req->to
      ])->with('i');
   }

   public function filterEmployee(Request $req)
   {
      // dd('ok');
      $req->validate([]);



      if (auth()->user()->hasRole('HRD-KJ12')) {
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj1-2')
            ->select('employees.*')
            ->get();

         $employees = Employee::where('status', 1)->where('location_id', 3)->get();
         // $employees = Employee::where('status', 1)->where('location_id', 4)->orWhere('location_id', 5)->get();

         // $absences = Absence::where('location_id', 4)->orWhere('location_id', 5)->whereBetween('date', [$req->from, $req->to])->get();
      } elseif (auth()->user()->hasRole('HRD-KJ45')) {

         // dd('ok');
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj4')->orWhere('contracts.loc', 'kj5')
            ->select('employees.*')
            ->get();
         $employees = Employee::where('status', 1)->where('location_id', 4)->orWhere('location_id', 5)->get();
         // $absences = Absence::where('location_id', 3)->whereBetween('date', [$req->from, $req->to])->get();
         // if ($req->loc == 'KJ45') {
         //    $absences = Absence::whereBetween('date', [$req->from, $req->to])->where('location_id', 4)->orWhere('location_id', 5)->get();
         // } else {
         //    $absences = Absence::whereBetween('date', [$req->from, $req->to])->get();
         // }
      } elseif(auth()->user()->hasRole('HRD-JGC')){
         // dd('ok');
         $employees = Employee::where('status', 1)->where('unit_id', 10)->orWhere('unit_id', 13)->orWhere('unit_id', 14)->get();
      } else {
         // dd('ok');
         $employees = Employee::where('status', 1)->get();
         // $absences = Absence::whereBetween('date', [$req->from, $req->to])->get();
      }

      if ($req->loc == 'KJ45') {
         // $absences = Absence::whereBetween('date', [$req->from, $req->to])->where('location_id', 4)->orWhere('location_id', 5)->get();
      } 

      

      $loc = $req->loc;
      // $employees = Employee::get();
      $export = true;
      return view('pages.payroll.absence.employee', [
         'loc' => $loc,
         'export' => $export,
         'employees' => $employees,
         // 'absences' => $absences,
         'from' => $req->from,
         'to' => $req->to
      ])->with('i');
   }

   public function filterSummary(Request $req){
      $req->validate([]);
      // dd($req->units);
      $unitAll = 0;
      foreach($req->units as $u){
         if ($u == 'all') {
            $unitAll = 1;
         }
      }

      $locAll = 0;
      foreach($req->locations as $l){
         if ($l == 'all') {
            $locAll = 1;
         }
      }
      
      
      if ($unitAll == 1) {
         $units = Unit::get();
      } else {
         $units = Unit::whereIn('id', $req->units)->get();
      }

      if ($locAll == 1) {
         $locations = Location::get();
      } else {
         $locations = Location::whereIn('id', $req->locations)->get();
      }

      
      $allUnits = Unit::get();
      $allLocations = Location::get();
      
      
      return view('pages.payroll.absence.summary', [
         'allUnits' => $allUnits,
         'allLocations' => $allLocations,
         'units' => $units,
         'locations' => $locations,
         'unitAll' => $unitAll,
         'locAll' => $locAll,
         
         'from' => $req->from,
         'to' => $req->to
      ])->with('i');

   }

   public function indexEmployeeDetail($id, $from, $to)
   {
      $employee = Employee::find(dekripRambo($id));
      $now = Carbon::now();
     

      $export = false;
      $loc = 'All';
      $locations = Location::get();

      if ($from == 0) {
         $absences = Absence::where('employee_id', $employee->id)->orderBy('updated_at', 'desc')->get();
      } else {
         $absences = Absence::where('employee_id', $employee->id)->whereBetween('date', [$from, $to])->orderBy('updated_at', 'desc')->get();
      }
      


      return view('pages.payroll.absence.summary-employee', [
         'from' => $from,
         'to' => $to,
         'employee' => $employee,
         'absences' => $absences,
      ])->with('i');
   }

   public function absenceExcel($from, $to, $loc){
      // dd($loc);
      return Excel::download(new AbsenceDataExport($from, $to, $loc), 'absensi-' . $loc .'-' . $from  .'- '. $to .'.xlsx');
   }



   public function store(Request $req)
   {

      if (auth()->user()->hasRole('Administrator')) {
         // dd('ok');
      }
      // dd('ok');
      $employee = Employee::find($req->employee);
      $payroll = Payroll::find($employee->payroll_id);
      // Cek jika karyawan tsb blm di set payroll
      if (!$payroll) {
         return redirect()->back()->with('danger', $employee->nik . ' ' . $employee->biodata->fullName() . ' belum ada data Gaji Karyawan');
      }

      if ($req->type == 2) {
         $req->validate([
            'minute' => 'required'
         ]);
      }

      if ($req->type == 4) {
         $req->validate([
            'type_izin' => 'required'
         ]);
      }

      if ($req->type == 6) {
         $req->validate([
            'type_spt' => 'required'
         ]);
      }



      $date = Carbon::create($req->date);
      if (request('doc')) {
         $doc = request()->file('doc')->store('doc/overtime');
      } else {
         $doc = null;
      }

      $locations = Location::get();

      foreach ($locations as $loc) {
         if ($loc->code == $employee->contract->loc) {
            $location = $loc->id;
         } else {
            $location = $employee->location_id;
         }
      }

      // if (auth()->user()->hasRole('Administrator')) {
      //    dd($location->name);
      // }

      

      $value =  1 * 1 / 30 * $payroll->total;

      // $reductionAlpha = null;
      // foreach ($alphas as $alpha) {
      //    $reductionAlpha =  1 * 1 / 30 * $payroll->total;
      //    $alpha->update([
      //       'value' => $reductionAlpha
      //    ]);
      // }

      if ($req->minute == 'T1') {
         $min = 30;
      } elseif($req->minute == 'T2'){
         $min = 60;
      } elseif($req->minute == 'T3'){
         $min = 90;
      } elseif($req->minute == 'T4'){
         $min = 120;
      } else {
         $min = null;
      }

      $currentAbsence = Absence::where('employee_id', $employee->id)->where('date', $req->date)->first();

      if (!$currentAbsence) {
         Absence::create([
            'type' => $req->type,
            'employee_id' => $req->employee,
            'month' => $date->format('F'),
            'year' => $date->format('Y'),
            'date' => $req->date,
            'desc' => $req->desc,
            'doc' => $doc,
            'minute' => $min,
            'location_id' => $location,
            'type_izin' => $req->type_izin,
            'type_spt' => $req->type_spt,
            'value' => $value
         ]);

         $transactionCon = new TransactionController;
         $transactions = Transaction::where('employee_id', $employee->id)->get();

         foreach ($transactions as $tran) {
            $transactionCon->calculateTotalTransaction($tran, $tran->cut_from, $tran->cut_to);
         }

         if (auth()->user()->hasRole('Administrator')) {
            $departmentId = null;
         } else {
            $user = Employee::find(auth()->user()->getEmployeeId());
            $departmentId = $user->department_id;
         }
         Log::create([
            'department_id' => $departmentId,
            'user_id' => auth()->user()->id,
            'action' => 'Add',
            'desc' => 'Data Absence ' . $employee->nik . ' ' . $employee->biodata->fullname()
         ]);
      } else {
         return redirect()->back()->with('danger', 'Gagal, Karyawan sudah memiliki data absensi di tanggal tersebut');
      }

      // Kalkulasi Cuti
      if ($req->type == 5) {
         $cutiCon = new CutiController;
         $cuti = Cuti::where('employee_id',  $req->employee)->first();
         $cutiCon->calculateCuti($cuti->id);
      }

      

      



      return redirect()->back()->with('success', 'Data Absence successfully added');
   }

   public function delete($id)
   {
      $absence = Absence::find(dekripRambo($id));
      $type = $absence->type;
      $absenceDate = $absence->date;
      $employee = Employee::find($absence->employee_id);
      $transaction = Transaction::where('employee_id', $absence->employee_id)->where('month', $absence->month)->where('year', $absence->year)->first();
      $absence->delete();

      $transactionCon = new TransactionController;
      $transactions = Transaction::where('employee_id', $employee->id)->get();

      foreach ($transactions as $tran) {
         $transactionCon->calculateTotalTransaction($tran, $tran->cut_from, $tran->cut_to);
      }

      // if ($transaction) {
      //    $trans = new TransactionController;
      //    $trans->calculateTotalTransaction($transaction);
      // }

      if ($type == 5) {
         $cutiCon = new CutiController;
         $cuti = Cuti::where('employee_id',  $employee->id)->first();
         $cutiCon->calculateCuti($cuti->id);
      }

      if (auth()->user()->hasRole('Administrator')) {
         $departmentId = null;
      } else {
         $user = Employee::find(auth()->user()->getEmployeeId());
         $departmentId = $user->department_id;
      }
      Log::create([
         'department_id' => $departmentId,
         'user_id' => auth()->user()->id,
         'action' => 'Delete',
         'desc' => 'Data Absence date:' . $absenceDate . ' ' . $employee->nik . ' ' . $employee->biodata->fullname()
      ]);

      return redirect()->back()->with('success', 'Absence Data successfully deleted');
   }
}
