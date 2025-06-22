<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeLeader;
use App\Models\Location;
use App\Models\Overtime;
use App\Models\OvertimeEmployee;
use App\Models\OvertimeParent;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OvertimeEmployeeController extends Controller
{
   public function index(){
      // dd('ok');
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $spkls = Overtime::where('employee_id', $employee->id)->orderBy('updated_at', 'desc')->get();
      // dd($spkls);
      return view('pages.spkl.index', [
         'spkls' => $spkls
      ]);
   }

   public function indexLeader(){
      // dd('ok');
      $employee = Employee::where('nik', auth()->user()->username)->first();


      $teamId = [];
      if (auth()->user()->hasRole('Leader|Supervisor')) {
         // $teamSpkls = OvertimeEmployee::where('status', 1)->orderBy('updated_at', 'desc')->get();
         $myEmployees = Employee::where('status', 1)->where('department_id', $employee->department->id)->get();
            foreach($myEmployees as $emp){
               $teamId[] = $emp->id;
            }

         $teamSpkls = OvertimeEmployee::where('status', 1)->whereIn('employee_id', $teamId)->get();
      } elseif (auth()->user()->hasRole('Manager|Asst. Manager')) {
         // $empSpkls = OvertimeEmployee::where('status', 2)->orderBy('updated_at', 'desc')->get();
         if(count($employee->positions) > 0){
            foreach($employee->positions as $pos){
               foreach($pos->department->employees->where('status', 1) as $emp){
                  $teamId[] = $emp->id;
               }
            }

            
         } else {
            $myEmployees = Employee::where('status', 1)->where('department_id', $employee->department->id)->get();
            foreach($myEmployees as $emp){
               $teamId[] = $emp->id;
            }
            
         }

         $teamSpkls = OvertimeEmployee::where('status', 2)->whereIn('employee_id', $teamId)->get();
      }
     


      $myteams = EmployeeLeader::join('employees', 'employee_leaders.employee_id', '=', 'employees.id')
         ->join('biodatas', 'employees.biodata_id', '=', 'biodatas.id')
         ->where('leader_id', $employee->id)
         ->select('employees.*')
         ->orderBy('biodatas.first_name', 'asc')
         ->get();

      
      return view('pages.spkl.leader.index', [
         'myteams' => $myteams,
         'teamSpkls' => $teamSpkls
      ]);
   }




   public function historyLeader(){
      // dd('ok');
      $employee = Employee::where('nik', auth()->user()->username)->first();

      $teamId = [];
      if (auth()->user()->hasRole('Leader|Supervisor')) {
         // $teamSpkls = OvertimeEmployee::where('status', 1)->orderBy('updated_at', 'desc')->get();
         $myEmployees = Employee::where('status', 1)->where('department_id', $employee->department->id)->get();
            foreach($myEmployees as $emp){
               $teamId[] = $emp->id;
            }

         $teamSpkls = OvertimeEmployee::where('status','>', 1)->whereIn('employee_id', $teamId)->get();
      } elseif (auth()->user()->hasRole('Manager|Asst. Manager')) {
         // $empSpkls = OvertimeEmployee::where('status', 2)->orderBy('updated_at', 'desc')->get();
         if(count($employee->positions) > 0){
            foreach($employee->positions as $pos){
               foreach($pos->department->employees->where('status', 1) as $emp){
                  $teamId[] = $emp->id;
               }
            }

            
         } else {
            $myEmployees = Employee::where('status', 1)->where('department_id', $employee->department->id)->get();
            foreach($myEmployees as $emp){
               $teamId[] = $emp->id;
            }
            
         }

         $teamSpkls = OvertimeEmployee::where('status','>', 2)->whereIn('employee_id', $teamId)->get();
      }
      
      $myteams = EmployeeLeader::join('employees', 'employee_leaders.employee_id', '=', 'employees.id')
         ->join('biodatas', 'employees.biodata_id', '=', 'biodatas.id')
         ->where('leader_id', $employee->id)
         ->select('employees.*')
         ->orderBy('biodatas.first_name', 'asc')
         ->get();

      
      return view('pages.spkl.leader.history', [
         'myteams' => $myteams,
         'teamSpkls' => $teamSpkls
      ]);
   }


   public function indexHrd(){
      $spklApprovals = OvertimeEmployee::where('status', 3)->get();
      return view('pages.spkl.hrd.index', [
         'spklApprovals' => $spklApprovals
      ]);
   }

   public function historyHrd(){
      $spklHistories = OvertimeEmployee::where('status', '>', 3)->get();
      return view('pages.spkl.hrd.history', [
         'spklHistories' => $spklHistories
      ]);
   }

   public function progress(){
      // dd('ok');
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $spkls = OvertimeEmployee::where('employee_id', $employee->id)->where('status', '>', 0)->orderBy('updated_at', 'desc')->get();
      // dd($spkls);
      return view('pages.spkl.progress', [
         'spkls' => $spkls
      ]);
   }

   public function draft(){
      // dd('ok');
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $empSpkls = OvertimeEmployee::where('parent_id', null )->where('employee_id', $employee->id)->where('status', 0)->orderBy('updated_at', 'desc')->get();
      // dd($spkls);
      return view('pages.spkl.draft', [
         'spkls' => $empSpkls
      ]);
   }

   public function create(){
      // dd('ok');
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $locations = Location::get();
      // dd($spkls);
      return view('pages.spkl.form', [
         'locations' => $locations
      ]);
   }

   public function createMultiple(){
      // dd('ok');
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $employees = Employee::where('status', 1)->get();
      $locations = Location::get();
      $teams = EmployeeLeader::where('leader_id', $employee->id)->get();
      // dd($spkls);
      return view('pages.spkl.form-multiple', [
         'locations' => $locations,
         'employees' => $employees,
         'teams' => $teams
      ]);
   }

   public function createTeam(){
      // dd('ok');
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $employees = Employee::where('status', 1)->get();
      $locations = Location::get();
      $teams = EmployeeLeader::where('leader_id', $employee->id)->get();
      // dd($spkls);
      return view('pages.spkl.team.form', [
         'locations' => $locations,
         'employees' => $employees,
         'teams' => $teams
      ]);
   }

   public function store(Request $req){
      $req->validate([

      ]);

      

      $employee = Employee::where('nik', auth()->user()->username)->first();
      $spkl_type = $employee->unit->spkl_type;
      $hour_type = $employee->unit->hour_type;
      $payroll = Payroll::find($employee->payroll_id);

      // dd($intH_end);
      $start = Carbon::CreateFromFormat('H:i', $req->hours_start);
      $end = Carbon::CreateFromFormat('H:i', $req->hours_end);
      $diffTime = $end->diffInMinutes($start);
      $h = $diffTime / 60 ;
      $hm = floor($h) * 60;
      $msisa = $diffTime - $hm;

      $intH = floatval(floor($h) . '.' .  $msisa);

      // dd($intH);
    

      $locations = Location::get();
      $locId = null;
      foreach ($locations as $loc) {
         if ($loc->code == $employee->contract->loc) {
            $locId = $loc->id;
         }
      }
      $date = Carbon::create($req->date);

      if (request('doc')) {
         $doc = request()->file('doc')->store('doc/overtime');
      } else {
         $doc = null;
      }

      $overtimeController = new OvertimeController;
      $rate = $overtimeController->calculateRate($payroll, $req->type, $spkl_type, $hour_type, $req->hours, $req->holiday_type);


      if ($req->holiday_type == 1) {
         $finalHour = $intH;
         if ($hour_type == 2) {
            // dd('test');
            $multiHours = $intH - 1;
            $finalHour = $multiHours * 2 + 1.5;
            // dd($finalHour);
         }
      } elseif ($req->holiday_type == 2) {
         $finalHour = $intH * 2;
      } elseif ($req->holiday_type == 3) {
         $finalHour = $intH * 2;
         // $employee = Employee::where('payroll_id', $payroll->id)->first();
            if ($employee->unit_id ==  7 || $employee->unit_id ==  8 || $employee->unit_id ==  9) {
               // dd('ok');
               if ($intH <= 7) {
                  $finalHour = $intH * 2;
               } else{
                  // dd('ok');
                  $hours7 = 14;
                  $sisa1 = $intH - 7;
                  $hours8 = 3;
                  if ($sisa1 > 1) {
                     $sisa2 = $sisa1 - 1;
                     $hours9 = $sisa2 * 4;
                  } else {
                     $hours9 = 0;
                  }
   
                  $finalHour = $hours7 + $hours8 + $hours9;
                  // dd($finalHour);

               }
            } else {
               if ($intH <= 8) {
                  $finalHour = $intH * 2;
               } else{
                  $hours8 = 16;
                  $sisa1 = $intH - 8;
                  $hours9 = 3;
                  if ($sisa1 > 1) {
                     $sisa2 = $sisa1 - 1;
                     $hours10 = $sisa2 * 4;
                  } else {
                     $hours10 = 0;
                  }
   
                  $finalHour = $hours8 + $hours9 + $hours10;
               }
            }
      } elseif ($req->holiday_type == 4) {
         $finalHour = $intH * 3;
      }

      if ($req->type == 1) {
         $hours = $intH;
         $finalHour = $finalHour;
      } else {
         if ($req->holiday_type == 1) {
            $finalHour = 1 ;
            
         } elseif ($req->holiday_type == 2) {
            // $rate = 1 * $rateOvertime;
            $finalHour = 1 ;
            // dd($rate);
         } elseif ($req->holiday_type == 3) {
            $finalHour = 2 ;
         } elseif ($req->holiday_type == 4) {
            $finalHour = 3 ;
         }

         $hours = $finalHour;
      }

      // dd($finalHour);

      //   Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur, dolores! Esse ipsum molestiae porro quod, voluptate praesentium. Nemo ullam velit unde quia recusandae.

      $lastOver = OvertimeEmployee::orderBy('updated_at', 'desc')->get();

      if ($lastOver != null) {
         $id = count($lastOver) + 1;
      } else {
         $id = 1;
      }

      $date = Carbon::make($req->date);

      
      if($req->type == 1 ){
         $code =  'FHRD/FL/' . $date->format('m') . '/' . $date->format('y') . '/' . $id ;
      } elseif($req->type == 2 ){
         $code = 'FHRD/FP/' . $date->format('m') . '/' . $date->format('y') . '/' .$id ;
      } 

      // dd($req->type);


      $spkl = OvertimeEmployee::create([
         'status' => 0,
         'code' => $code,
         'location_id' => $locId,
         'employee_id' => $employee->id,
         'month' => $date->format('F'),
         'year' => $date->format('Y'),
         'date' => $req->date,
         'type' => $req->type,
         'hour_type' => $hour_type,
         'holiday_type' => $req->holiday_type,
         'hours_start' => $req->hours_start,
         'hours_end' => $req->hours_end,
         'hours' => $intH,
         'hours_final' => $finalHour,
         'rate' => round($rate),
         'description' => $req->desc,
         'location' => $req->location,
         'doc' => $doc,
         'by_id' => $employee->id
      ]);

      

      return redirect()->route('employee.spkl.detail', enkripRambo($spkl->id))->with('success', 'Pengajuan Lembur/Piket berhasil dibuat');

   }

   public function storeMultiple(Request $req){

      if (request('doc')) {
         $doc = request()->file('doc')->store('doc/overtime');
      } else {
         $doc = null;
      }
      $date = Carbon::create($req->date);
      $user = Employee::where('nik', auth()->user()->username)->first();

      $lastParent = OvertimeParent::orderBy('updated_at', 'desc')->get();

      if ($lastParent != null) {
         $id = count($lastParent) + 1;
      } else {
         $id = 1;
      }

      $date = Carbon::make($req->date);

      if($req->type == 1 ){
         $code =  'FHRD/FL/' . $date->format('m')  . $date->format('y') . '/' . $id ;
      } elseif($req->type == 2 ){
         $code = 'FHRD/FP/' . $date->format('m')  . $date->format('y')  . '/' . $id ;
      } 
      
      
      $parent = OvertimeParent::create([
         // 'location_id' => $req->location,
         'code' => $code,
         'status' => 0,
         'month' => $date->format('F'),
         'year' => $date->format('Y'),
         'date' => $req->date,
         'type' => $req->type,
         'holiday_type' => $req->holiday_type,
         'hours_start' => $req->hours_start,
         'hours_end' => $req->hours_end,
         'description' => $req->desc,
         'location' => $req->location,
         'doc' => $doc,
         'by_id' => $user->id
      ]);

      foreach($req->employees as $emp){
         // $employee
         $employee = Employee::find($emp);
         $spkl_type = $employee->unit->spkl_type;
         $hour_type = $employee->unit->hour_type;
         $payroll = Payroll::find($employee->payroll_id);

         $start = Carbon::CreateFromFormat('H:i', $req->hours_start);
         $end = Carbon::CreateFromFormat('H:i', $req->hours_end);
         $diffTime = $end->diffInMinutes($start);
         $h = $diffTime / 60 ;
         $hm = floor($h) * 60;
         $msisa = $diffTime - $hm;
   
         $intH = floatval(floor($h) . '.' .  $msisa);

         $locations = Location::get();
         $locId = null;
         foreach ($locations as $loc) {
            if ($loc->code == $employee->contract->loc) {
               $locId = $loc->id;
            }
         }
        

         $overtimeController = new OvertimeController;
         $rate = $overtimeController->calculateRate($payroll, $req->type, $spkl_type, $hour_type, $req->hours, $req->holiday_type);

         if ($req->holiday_type == 1) {
            $finalHour = $intH;
            if ($hour_type == 2) {
               // dd('test');
               $multiHours = $intH - 1;
               $finalHour = $multiHours * 2 + 1.5;
               // dd($finalHour);
            }
         } elseif ($req->holiday_type == 2) {
            $finalHour = $intH * 2;
         } elseif ($req->holiday_type == 3) {
            $finalHour = $intH * 2;
            // $employee = Employee::where('payroll_id', $payroll->id)->first();
               if ($employee->unit_id ==  7 || $employee->unit_id ==  8 || $employee->unit_id ==  9) {
                  // dd('ok');
                  if ($intH <= 7) {
                     $finalHour = $intH * 2;
                  } else{
                     // dd('ok');
                     $hours7 = 14;
                     $sisa1 = $intH - 7;
                     $hours8 = 3;
                     if ($sisa1 > 1) {
                        $sisa2 = $sisa1 - 1;
                        $hours9 = $sisa2 * 4;
                     } else {
                        $hours9 = 0;
                     }
      
                     $finalHour = $hours7 + $hours8 + $hours9;
                     // dd($finalHour);
   
                  }
               } else {
                  if ($intH <= 8) {
                     $finalHour = $intH * 2;
                  } else{
                     $hours8 = 16;
                     $sisa1 = $intH - 8;
                     $hours9 = 3;
                     if ($sisa1 > 1) {
                        $sisa2 = $sisa1 - 1;
                        $hours10 = $sisa2 * 4;
                     } else {
                        $hours10 = 0;
                     }
      
                     $finalHour = $hours8 + $hours9 + $hours10;
                  }
               }
         } elseif ($req->holiday_type == 4) {
            $finalHour = $intH * 3;
         }
   
         if ($req->type == 1) {
            $hours = $intH;
            $finalHour = $finalHour;
         } else {
            if ($req->holiday_type == 1) {
               $finalHour = 1 ;
               
            } elseif ($req->holiday_type == 2) {
               // $rate = 1 * $rateOvertime;
               $finalHour = 1 ;
               // dd($rate);
            } elseif ($req->holiday_type == 3) {
               $finalHour = 2 ;
            } elseif ($req->holiday_type == 4) {
               $finalHour = 3 ;
            }
   
            $hours = $finalHour;
         }


         $lastOver = OvertimeEmployee::orderBy('updated_at', 'desc')->get();

         if ($lastOver != null) {
            $id = count($lastOver) + 1;
         } else {
            $id = 1;
         }

         $date = Carbon::make($req->date);

         
         if($req->type == 1 ){
            $code =  'FHRD/FL/' . $date->format('m') . '/' . $date->format('Y') . $id ;
         } elseif($req->type == 2 ){
            $code = 'FHRD/FP/' . $date->format('m') . '/' . $date->format('Y') .$id ;
         } 
         


         // Inser
         $spkl = OvertimeEmployee::create([
            'code' => $code,
            'parent_id' => $parent->id,
            'status' => 0,
            'location_id' => $locId,
            'employee_id' => $employee->id,
            'month' => $date->format('F'),
            'year' => $date->format('Y'),
            'date' => $req->date,
            'type' => $req->type,
            'hour_type' => $hour_type,
            'holiday_type' => $req->holiday_type,
            'hours_start' => $req->hours_start,
            'hours_end' => $req->hours_end,
            'hours' => $intH,
            'hours_final' => $finalHour,
            'rate' => round($rate),
            'description' => $req->desc,
            'location' => $req->location,
            'doc' => $doc, 
            'by_id' => $user->id
         ]);


      }

      return redirect()->route('employee.spkl.detail.multiple', enkripRambo($parent->id))->with('success', 'Pengajuan SPKL Multiple berhasil dibuat');
   }

   public function detail($id){
      $empSpkl = OvertimeEmployee::find(dekripRambo($id));

      return view('pages.spkl.detail', [
         'empSpkl' => $empSpkl
      ]);
   }

   public function detailMultiple($id){
      $empSpkl = OvertimeParent::find(dekripRambo($id));

      return view('pages.spkl.detail-multiple', [
         'empSpkl' => $empSpkl
      ]);

   }
   public function detailLeader($id){
      $empSpkl = OvertimeEmployee::find(dekripRambo($id));
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $myteams = EmployeeLeader::join('employees', 'employee_leaders.employee_id', '=', 'employees.id')
         ->join('biodatas', 'employees.biodata_id', '=', 'biodatas.id')
         ->where('leader_id', $employee->id)
         ->select('employees.*')
         ->orderBy('biodatas.first_name', 'asc')
         ->get();

      $approval = 0;
      foreach($myteams as $team){
         if ($team->id == $empSpkl->employee->id) {
            $approval = 1;
         }
      }

      return view('pages.spkl.leader.detail', [
         'empSpkl' => $empSpkl,
         'approval' => $approval
      ]);

   }


   public function release($id){
      $empSpkl = OvertimeEmployee::find(dekripRambo($id));
      $now = Carbon::now();
      $empSpkl->update([
         'status' => 1,
         'release_employee_date' => $now
      ]);

      return redirect()->back()->with('success', 'Form Pengajuan berhasil di Release');
   }

   public function releaseMultiple($id){
      $parent = OvertimeParent::find(dekripRambo($id));

      $empSpkls = OvertimeEmployee::where('parent_id', $parent->id)->get();
      $now = Carbon::now();

      foreach($empSpkls as $empSpkl){
         $empSpkl->update([
            'status' => 1,
            'release_employee_date' => $now
         ]);
      }

      $parent->update([
         'status' => 1,
         'release_employee_date' => $now
      ]);
     

      return redirect()->back()->with('success', 'Form Pengajuan berhasil di Release');
   }

   public function delete($id){
      $empSpkl = OvertimeEmployee::find(dekripRambo($id));

      $empSpkl->delete();

      return redirect()->route('employee.spkl')->with('success', 'Form Pengajuan berhasil dihapus');
   }


   public function approve($id){
      $spklEmp = OvertimeEmployee::find(dekripRambo($id));
      $empLogin = Employee::where('nik', auth()->user()->username)->first();

      if (auth()->user()->hasRole('Leader|Supervisor')) {
         $spklEmp->update([
            'status' => 2,
            'leader_id' => $empLogin->id,
            'approve_leader_date' => Carbon::now()
         ]);
      } elseif(auth()->user()->hasRole('Manager|Asst. Manager')) {
         $spklEmp->update([
            'status' => 3,
            'manager_id' => $empLogin->id,
            'approve_manager_date' => Carbon::now()
         ]);
      }

      return redirect()->route('leader.spkl')->with('success', "SPKL Approved");
   }

   public function reject(Request $req){

      $spklEmp = OvertimeEmployee::find($req->spklEmp);
      $empLogin = Employee::where('nik', auth()->user()->username)->first();

      if (auth()->user()->hasRole('Leader|Supervisor')) {
         $spklEmp->update([
            'status' => 201,
            'leader_id' => $empLogin->id,
            'reject_leader_date' => Carbon::now(),
            'reject_leader_desc' => $req->desc,

         ]);
      } elseif(auth()->user()->hasRole('Manager|Asst. Manager')) {
         $spklEmp->update([
            'status' => 301,
            'manager_id' => $empLogin->id,
            'reject_manager_desc' => $req->desc,
         ]);
      }

      return redirect()->route('leader.spkl.history')->with('success', "SPKL Approved");
   }
}
