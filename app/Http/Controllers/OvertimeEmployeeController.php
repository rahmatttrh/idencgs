<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeLeader;
use App\Models\Location;
use App\Models\Log;
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

   public function indexAdmin(){
      // dd('ok');
      // $employee = Employee::where('nik', auth()->user()->username)->first();
      $spkls = OvertimeEmployee::orderBy('updated_at', 'desc')->get();
      // dd($spkls);
      return view('pages.absence-request.admin.spkl', [
         'spkls' => $spkls
      ])->with('i');
   }

   public function indexLeader(){
      // dd('ok');
      $employee = Employee::where('nik', auth()->user()->username)->first();


      $teamAllSpkls = [];
      $teamId = [];
      $spklApprovalManager = [];
      $spklGroupApprovalManagers = [];
      if (auth()->user()->hasRole('Leader|Supervisor')) {
         // $teamSpkls = OvertimeEmployee::where('status', 1)->orderBy('updated_at', 'desc')->get();
         $myEmployees = Employee::where('status', 1)->where('department_id', $employee->department->id)->get();
            foreach($myEmployees as $emp){
               $teamId[] = $emp->id;
            }

            // dd('ok');
         $teamSpkls = OvertimeEmployee::where('status', 1)->where('leader_id', $employee->id)->orderBy('date', 'desc')->get();
         $spklGroupApprovalLeaders = OvertimeParent::where('status', 1)->where('leader_id', $employee->id)->get();
         // dd($teamSpkls);
      } elseif (auth()->user()->hasRole('Asst. Manager')) {
         // $empSpkls = OvertimeEmployee::where('status', 2)->orderBy('updated_at', 'desc')->get();
         if(count($employee->positions) > 0){
            foreach($employee->positions as $pos){
               foreach($pos->department->employees->where('status', 1) as $emp){
                  $teamId[] = $emp->id;
               }
            }

            // dd($teamId);

            
         } else {
            $myEmployees = Employee::where('status', 1)->where('department_id', $employee->department->id)->get();
            foreach($myEmployees as $emp){
               $teamId[] = $emp->id;
            }

            // dd($myEmployees);
            
         }

         $teamSpkls = OvertimeEmployee::where('status', 1)->where('leader_id', $employee->id)->whereIn('employee_id', $teamId)->orderBy('date', 'desc')->get();
         $spklApprovalManager =OvertimeEmployee::where('status', 2)->whereIn('employee_id', $teamId)->orderBy('date', 'desc')->get();
         $teamAllSpkls = OvertimeEmployee::where('status','>', 0)->where('status','<', 3)->where('leader_id','!=',  $employee->id)->whereIn('employee_id', $teamId)->orderBy('date', 'desc')->get();
         $spklGroupApprovalLeaders = OvertimeParent::where('status', 1)->where('leader_id', $employee->id)->get();
         $spklGroupApprovalManagers = OvertimeParent::where('status', 2)->whereIn('by_id', $teamId)->get();
         // dd($spklGroupApprovalManagers);
      } elseif (auth()->user()->hasRole('Manager')) {
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

         $teamSpkls = OvertimeEmployee::where('status', 2)->whereIn('employee_id', $teamId)->orderBy('date', 'desc')->get();
         $spklGroupApprovalLeaders = OvertimeParent::where('status', 2)->whereIn('by_id', $teamId)->get();
         // dd($spklGroupApprovalLeaders);
      }
     


      $myteams = EmployeeLeader::join('employees', 'employee_leaders.employee_id', '=', 'employees.id')
         ->join('biodatas', 'employees.biodata_id', '=', 'biodatas.id')
         ->where('leader_id', $employee->id)
         ->select('employees.*')
         ->orderBy('biodatas.first_name', 'asc')
         ->get();

      
      return view('pages.spkl.leader.index', [
         'myteams' => $myteams,
         'teamSpkls' => $teamSpkls,
         'teamAllSpkls' => $teamAllSpkls,
         'spklGroupApprovalLeaders' => $spklGroupApprovalLeaders,
         'spklGroupApprovalManagers' => $spklGroupApprovalManagers,

         'spklApprovalManager' => $spklApprovalManager
      ]);
   }




   public function historyLeader(){
      // dd('ok');
      $employee = Employee::where('nik', auth()->user()->username)->first();

      $teamId = [];
      if (auth()->user()->hasRole('Leader|Supervisor')) {
         // $teamSpkls = OvertimeEmployee::where('status', 1)->orderBy('updated_at', 'desc')->get();
         // $myEmployees = Employee::where('status', 1)->where('department_id', $employee->department->id)->get();
         //    foreach($myEmployees as $emp){
         //       $teamId[] = $emp->id;
         //    }

         $myteams = EmployeeLeader::join('employees', 'employee_leaders.employee_id', '=', 'employees.id')
            ->join('biodatas', 'employees.biodata_id', '=', 'biodatas.id')
            ->where('leader_id', $employee->id)
            ->select('employees.*')
            ->orderBy('biodatas.first_name', 'asc')
            ->get();

            foreach($myteams as $emp){
               $teamId[] = $emp->id;
            }

         $teamSpkls = OvertimeEmployee::where('status','>', 1)->whereIn('employee_id', $teamId)->orderBy('date', 'desc')->get();
      } elseif (auth()->user()->hasRole('Asst. Manager')) {
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

         $teamSpkls = OvertimeEmployee::where('status','>', 1)->where('leader_id', $employee->id)->orderBy('date', 'desc')->get();
         // dd($teamSpkls);
      } elseif (auth()->user()->hasRole('Manager')) {
         // dd('ok');
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

         $teamSpkls = OvertimeEmployee::where('status','>', 2)->whereIn('employee_id', $teamId)->orderBy('date', 'desc')->get();
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
      $spklApprovals = OvertimeEmployee::where('status', 3)->orderBy('date', 'desc')->get();
      return view('pages.spkl.hrd.index', [
         'spklApprovals' => $spklApprovals
      ]);
   }

   public function historyHrd(){
      $spklHistories = OvertimeEmployee::where('status', '>', 3)->whereNotIn('status', [201,301])->orderBy('date', 'desc')->get();
      return view('pages.spkl.hrd.history', [
         'spklHistories' => $spklHistories
      ]);
   }

   public function progress(){
      // dd('ok');
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $spkls = OvertimeEmployee::where('employee_id', $employee->id)->where('status', '>', 0)->where('status', '!=', 4)->orderBy('updated_at', 'desc')->get();
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
      // $employeeLeaders = EmployeeLeader::where('employee_id', $employee->id)->get();
      $employeeLeaders = EmployeeLeader::where('employee_id', $employee->id)->get();
      // dd($employeeLeaders);
      $leader = null;
      foreach($employeeLeaders as $lead){
         
         if ($lead->leader->role == 7) {
            $empLead = Employee::find($lead->leader_id);
            $leader = $empLead;
         }
      }
      // dd($employeeLeaders);
      $locations = Location::get();
      // dd($spkls);
      return view('pages.spkl.form', [
         'locations' => $locations,
         'employeeLeaders'=> $employeeLeaders,
         'leader' => $leader
      ]);
   }

   public function createMultiple(){
      // dd('ok');
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $employees = Employee::where('status', 1)->get();
      $locations = Location::get();
      $teams = EmployeeLeader::where('leader_id', $employee->id)->get();
      // dd($spkls);

      $employeeLeaders = EmployeeLeader::where('employee_id', $employee->id)->get();
      // dd($employeeLeaders);
      $leader = null;
      foreach($employeeLeaders as $lead){
         
         if ($lead->leader->role == 7) {
            $empLead = Employee::find($lead->leader_id);
            $leader = $empLead;
         }
      }
      return view('pages.spkl.form-multiple', [
         'locations' => $locations,
         'employees' => $employees,
         'teams' => $teams,
         'employeeLeaders'=> $employeeLeaders,
         'leader' => $leader
      ]);
   }

   public function createTeam(){
      // dd('ok');
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $employees = Employee::where('status', 1)->get();
      $locations = Location::get();
      $teams = EmployeeLeader::where('leader_id', $employee->id)->get();
      // dd($teams);
      $employeeLeaders = EmployeeLeader::where('employee_id', $employee->id)->get();
      // dd($employeeLeaders);
      $leader = null;
      foreach($employeeLeaders as $lead){
         
         if ($lead->leader->role == 7) {
            $empLead = Employee::find($lead->leader_id);
            $leader = $empLead;
         }
      }
      return view('pages.spkl.team.form', [
         'locations' => $locations,
         'employees' => $employees,
         'teams' => $teams,
         'employeeLeaders'=> $employeeLeaders,
         'leader' => $leader
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
      $start = Carbon::Create( $req->hours_start);
      $end = Carbon::Create( $req->hours_end);
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
         
         
         'description' => $req->desc,
         'location' => $req->location,
         'location_id' => $locId,
         'doc' => $doc,
         'by_id' => $employee->id,
         'leader_id' => $req->leader
      ]);

      

      return redirect()->route('employee.spkl.detail', [enkripRambo($spkl->id), enkripRambo('draft')])->with('success', 'Pengajuan Lembur/Piket berhasil dibuat');

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

      $locations = Location::get();
      $locId = null;
      foreach ($locations as $loc) {
         if ($loc->name == $req->location) {
            $locId = $loc->id;
         }
      }


      $start = Carbon::CreateFromFormat('H:i', $req->hours_start);
      $end = Carbon::CreateFromFormat('H:i', $req->hours_end);
      $diffTime = $end->diffInMinutes($start);
      $h = $diffTime / 60 ;
      $hm = floor($h) * 60;
      $msisa = $diffTime - $hm;

      $intH = floatval(floor($h) . '.' .  $msisa);
      
      
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
         'hours' => $intH,
         'description' => $req->desc,
         'location' => $req->location,
         'location_id' => $locId,
         'doc' => $doc,
         'by_id' => $user->id,
         'leader_id' => $req->leader
      ]);

      foreach($req->employees as $emp){
         // $employee
         $employee = Employee::find($emp);
         $spkl_type = $employee->unit->spkl_type;
         $hour_type = $employee->unit->hour_type;
         $payroll = Payroll::find($employee->payroll_id);

        

         $locations = Location::get();
         $locId = null;
         foreach ($locations as $loc) {
            if ($loc->code == $employee->contract->loc) {
               $locId = $loc->id;
            }
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
            
            'description' => $req->desc,
            'location' => $req->location,
            'doc' => $doc, 
            'by_id' => $user->id,
            'leader_id' => $req->leader
         ]);


      }

      return redirect()->route('employee.spkl.detail.multiple', [enkripRambo($parent->id), enkripRambo('draft')])->with('success', 'Pengajuan SPKL Multiple berhasil dibuat');
   }

   public function edit($id){
      $empSpkl = OvertimeEmployee::find(dekripRambo($id));

      $employee = Employee::where('nik', auth()->user()->username)->first();
      // $employeeLeaders = EmployeeLeader::where('employee_id', $employee->id)->get();
      $employeeLeaders = EmployeeLeader::where('employee_id', $employee->id)->get();
      // dd($employeeLeaders);
      $leader = null;
      foreach($employeeLeaders as $lead){
         
         if ($lead->leader->role == 7) {
            $empLead = Employee::find($lead->leader_id);
            $leader = $empLead;
         }
      }
      // dd($employeeLeaders);
      $locations = Location::get();


      return view('pages.spkl.form-edit', [
         'empSpkl' => $empSpkl,
         'locations' => $locations,
         'employeeLeaders'=> $employeeLeaders,
         'leader' => $leader

      ]);
   }

   public function update(Request $req){
      $empSpkl = OvertimeEmployee::find($req->empSpkl);
      $employee = Employee::where('nik', auth()->user()->username)->first();

      $start = Carbon::Create( $req->hours_start);
      $end = Carbon::Create( $req->hours_end);
      $diffTime = $end->diffInMinutes($start);
      $h = $diffTime / 60 ;
      $hm = floor($h) * 60;
      $msisa = $diffTime - $hm;
      $intH = floatval(floor($h) . '.' .  $msisa);

      $hour_type = $employee->unit->hour_type;


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

      if (request('doc')) {
         $doc = request()->file('doc')->store('doc/overtime');
      } else {
         $doc = null;
      }

      $empSpkl->update([
         'location_id' => $req->location,
        
         'month' => $date->format('F'),
         'year' => $date->format('Y'),
         'date' => $req->date,
         'type' => $req->type,
         'hour_type' => $hour_type,
         // 'holiday_type' => $req->holiday_type,
         'hours_start' => $req->hours_start,
         'hours_end' => $req->hours_end,
         'hours' => $intH,
         
         
         'description' => $req->desc,
         'location' => $req->location,
         // 'location_id' => $locId,
         'doc' => $doc,
         'by_id' => $employee->id,
         'leader_id' => $req->leader
      ]);

      return redirect()->route('employee.spkl.detail', [enkripRambo($empSpkl->id), enkripRambo('draft')])->with('success', 'Pengajuan SPKL berhasil diubah');

   }

   public function detail($id, $type){
      // dd('ok');
      
      $empSpkl = OvertimeEmployee::find(dekripRambo($id));
      // if (auth()->user()->hasRole('Administrator')) {
      
      //   $start = Carbon::CreateFromFormat('H:i', $empSpkl->hours_start);
      //    $end = Carbon::CreateFromFormat('H:i', $empSpkl->hours_end);
      //    $diffTime = $end->diffInMinutes($start);
      //    $h = $diffTime / 60 ;
      //    $hm = floor($h) * 60;
      //    $msisa = $diffTime - $hm;

      //    $intH = floatval(floor($h) . '.' .  $msisa);
      //    $empSpkl->update([
      //       'hours' => $intH
      //    ]);
      // }
      $currentSpkl = Overtime::where('overtime_employee_id', $empSpkl->id)->first();

      // $start = Carbon::CreateFromFormat('H:i', $empSpkl->hours_start);
      // $end = Carbon::CreateFromFormat('H:i', $empSpkl->hours_end);
      // $diffTime = $end->diffInMinutes($start);
      // $h = $diffTime / 60 ;
      // $hm = floor($h) * 60;
      // $msisa = $diffTime - $hm;

      // $intH = floatval(floor($h) . '.' .  $msisa);

      // dd($start);

      return view('pages.spkl.detail', [
         'empSpkl' => $empSpkl,
         'currentSpkl' => $currentSpkl,
         'type' => dekripRambo($type)
      ]);
   }

   public function detailMultiple($id, $type){
      $empSpkl = OvertimeParent::find(dekripRambo($id));

      return view('pages.spkl.detail-multiple', [
         'empSpkl' => $empSpkl,
         'type' => dekripRambo($type)
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

   public function deleteMultiple($id){
      $empSpkl = OvertimeParent::find(dekripRambo($id));
      foreach($empSpkl->overtimes as $over){
         $over->delete();
      }

      $empSpkl->delete();

      return redirect()->route('spkl.team')->with('success', 'Form Pengajuan berhasil dihapus');
   }

   // OvertimeParent


   public function approve($id){
      $spklEmp = OvertimeEmployee::find(dekripRambo($id));
      $empLogin = Employee::where('nik', auth()->user()->username)->first();

      if ($spklEmp->leader_id == $empLogin->id) {
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
            'reject_manager_date' => Carbon::now(),
            'reject_manager_desc' => $req->desc,
         ]);
      }

      return redirect()->route('leader.spkl.history')->with('success', "SPKL Rejected");
   }


   public function rejectMultiple(Request $req){

      // dd('ok');
      $spklGroup = OvertimeParent::find($req->spklEmp);
      // $spklEmp = OvertimeEmployee::find($req->spklEmp);
      $empLogin = Employee::where('nik', auth()->user()->username)->first();

      if (auth()->user()->hasRole('Leader|Supervisor')) {
         $status = 201;
        
      } elseif(auth()->user()->hasRole('Manager|Asst. Manager')) {
         $status = 301;
      }

      $spklGroup->update([
         'status' => $status,
         'reject_by' => $empLogin->id,
         'reject_date' => Carbon::now(),
         'reject_desc' => $req->desc,
      ]);

      $spklEmps = OvertimeEmployee::where('parent_id', $spklGroup->id)->get();
      foreach($spklEmps as $spklEmp){
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
               'reject_manager_date' => Carbon::now(),
               'reject_manager_desc' => $req->desc,
            ]);
         }
      }

      return redirect()->back()->with('success', "SPKL Rejected");
   }

   public function approveHrd(Request $req){
      // dd('approve hrd');
      $empSpkl = OvertimeEmployee::find($req->empSpkl);

      $employee = Employee::find($empSpkl->employee->id);
      // $transaction = Transaction::find($req->transaction);
      $spkl_type = $employee->unit->spkl_type;
      $hour_type = $employee->unit->hour_type;
      $payroll = Payroll::find($employee->payroll_id);

      // Cek jika karyawan tsb blm di set payroll
      if (!$payroll) {
         return redirect()->route('payroll.overtime')->with('danger', $employee->nik . ' ' . $employee->biodata->fullName() . ' belum ada data Gaji Karyawan');
      }

      // dd($hour_type);

      $locations = Location::get();
      $locId = null;
      foreach ($locations as $loc) {
         if ($loc->code == $employee->contract->loc) {
            $locId = $loc->id;
         }
      }

      $overtime = new OvertimeController;
      $rate = $overtime->calculateRate($payroll, $req->type, $spkl_type, $hour_type, $req->hours, $req->holiday_type);

      if (request('doc')) {
         $doc = request()->file('doc')->store('doc/overtime');
      } else {
         $doc = null;
      }

      // $hoursFinal = 0;
      if ($req->holiday_type == 1) {
         $finalHour = $req->hours;
         if ($hour_type == 2) {
            // dd('test');
            $multiHours = $req->hours - 1;
            $finalHour = $multiHours * 2 + 1.5;
            // dd($finalHour);
         }
      } elseif ($req->holiday_type == 2) {
         $finalHour = $req->hours * 2;
      } elseif ($req->holiday_type == 3) {
         $finalHour = $req->hours * 2;
         // $employee = Employee::where('payroll_id', $payroll->id)->first();
         if ($employee->unit_id ==  7 || $employee->unit_id ==  8 || $employee->unit_id ==  9) {
            // dd('ok');
            if ($req->hours <= 7) {
               $finalHour = $req->hours * 2;
            } else {
               // dd('ok');
               $hours7 = 14;
               $sisa1 = $req->hours - 7;
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
            if ($req->hours <= 8) {
               $finalHour = $req->hours * 2;
            } else {
               $hours8 = 16;
               $sisa1 = $req->hours - 8;
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
         $finalHour = $req->hours * 3;
      }

      if ($req->type == 1) {
         $hours = $req->hours;
         $finalHour = $finalHour;
      } else {
         if ($req->holiday_type == 1) {
            $finalHour = 1;
         } elseif ($req->holiday_type == 2) {
            // $rate = 1 * $rateOvertime;
            $finalHour = 1;
            // dd($rate);
         } elseif ($req->holiday_type == 3) {
            $finalHour = 2;
         } elseif ($req->holiday_type == 4) {
            $finalHour = 3;
         }

         $hours = $finalHour;
      }

      // dd($finalHour);


      $current = Overtime::where('overtime_employee_id', $empSpkl->id)->first();

      if ($current) {
         $current->delete();
         // return redirect()->back()->with('danger', 'Data SPKL sudah ada.');
      }


      


      $date = Carbon::create($empSpkl->date);

      $overtime = Overtime::create([
         'status' => 1,
         'location_id' => $locId,
         'employee_id' => $employee->id,
         'month' => $empSpkl->month,
         'year' => $empSpkl->year,
         'date' => $empSpkl->date,
         'type' => $req->type,
         'hour_type' => $hour_type,
         'holiday_type' => $req->holiday_type,
         'hours' => $hours,
         'hours_final' => $finalHour,
         'rate' => round($rate),
         'description' => $empSpkl->description,
         'doc' => $doc,
         'overtime_employee_id' => $empSpkl->id
      ]);

      // $overtimes = Overtime::where('month', $transaction->month)->get();
      // $totalOvertime = $overtimes->sum('rate');
      // $transactionCon = new TransactionController;
      // $transactions = Transaction::where('status', '!=', 3)->where('employee_id', $employee->id)->get();

      // foreach ($transactions as $tran) {
      //    $transactionCon->calculateTotalTransaction($tran, $tran->cut_from, $tran->cut_to);
      // }

      // dd($overtime->id);

      $empSpkl->update([
         'status' => 4
      ]);

      if($empSpkl->parent_id != null){
         $status = 4;
         $spklGroup = OvertimeParent::find($empSpkl->parent_id);
         foreach($spklGroup->overtimes as $spkl){
            if($spkl->status == 3){
               $status = 3;
            }
         }

         $spklGroup->update([
            'status' => $status
         ]);

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
         'action' => 'Verifikasi',
         'desc' => 'SPKL ' . $overtime->id . ' ' . $employee->nik . ' ' . $employee->biodata->fullName()
      ]);



      return redirect()->route('hrd.spkl')->with('success', 'Overtime Data successfully verified');
   }
}
