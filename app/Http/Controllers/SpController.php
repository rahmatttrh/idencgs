<?php

namespace App\Http\Controllers;

use App\Exports\SpExport as ExportsSpExport;
use App\Imports\SpExport;
use App\Models\Employee;
use App\Models\EmployeeLeader;
use App\Models\EmployeePosition;
use App\Models\Log;
use App\Models\Pe;
use App\Models\Position;
use App\Models\Sp;
use App\Models\SpApproval;
use App\Models\Spkl;
use App\Models\St;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SpController extends Controller
{
   public function index()
   {
      $now = Carbon::now();

      // dd(auth()->user()->getEmployee()->id);

      if (auth()->user()->hasRole('Administrator')) {
         $employee = null;
         $employees = Employee::get();
         $sps = Sp::orderBy('created_at', 'desc')->get();
         $allEmployees = [];
         return view('pages.sp.index-hrd', [
            'employee' => $employee,
            'allEmployees' => $allEmployees,
            'employees' => $employees,
            'sps' => $sps
         ])->with('i');
      } elseif (auth()->user()->hasRole('BOD|HRD-Spv|HRD|HRD-Manager|HRD-Recruitment|HRD-Payroll')) {
         $employee = auth()->user()->getEmployee();
         $allEmployees = Employee::get();
         $employees = [];
         $sps = Sp::orderBy('created_at', 'desc')->get();
         return view('pages.sp.index-hrd', [
            'employee' => $employee,
            'allEmployees' => $allEmployees,
            'employees' => $employees,
            'sps' => $sps
         ])->with('i');
      } elseif(auth()->user()->hasRole('HRD-KJ12')) {
         $employee = auth()->user()->getEmployee();
         $allEmployees = Employee::get();
         $allEmployees = Employee::where('status', 1)->whereIn('location_id', [3])->get();
         $sps = Sp::orderBy('created_at', 'desc')->get();
         $employees = [];
         return view('pages.sp.index-hrd', [
            'employee' => $employee,
            'allEmployees' => $allEmployees,
            'employees' => $employees,
            'sps' => $sps
         ])->with('i');
            
      } elseif (auth()->user()->hasRole('HRD-KJ45')) {


         $employee = auth()->user()->getEmployee();
         $allEmployees = Employee::get();
         $allEmployees = Employee::where('status', 1)->whereIn('location_id', [4])->get();
         $sps = Sp::orderBy('created_at', 'desc')->get();
         $employees = [];
         return view('pages.sp.index-hrd', [
            'employee' => $employee,
            'allEmployees' => $allEmployees,
            'employees' => $employees,
            'sps' => $sps
         ])->with('i');
         // dd($overtimes);
      } elseif (auth()->user()->hasRole('Manager|Asst. Manager')) {
         $employee = auth()->user()->getEmployee();
         $employees = Employee::where('department_id', auth()->user()->getEmployee()->department_id)->where('designation_id', '<', 6)->get();
         $allEmployees = [];
         $sps = Sp::where('department_id', auth()->user()->getEmployee()->department_id)->orderBy('created_at', 'desc')->get();
      } elseif (auth()->user()->hasRole('Leader') || auth()->user()->hasRole('Supervisor')) {
         $employee = auth()->user()->getEmployee();
         // dd(auth()->user()->getEmployeeId());
         // $employees = Employee::where('department_id', auth()->user()->getEmployee()->department_id)->where('designation_id', '<', 4)->get();
         // $employees = Employee::where('direct_leader_id', auth()->user()->getEmployeeId())->get();
         $employees = EmployeeLeader::where('leader_id', auth()->user()->getEmployee()->id)->get();
         $sps = Sp::where('by_id', auth()->user()->getEmployee()->id)->orderBy('created_at', 'desc')->get();
         // dd($sps);
         $allEmployees = [];
      } else {
         $employee = auth()->user()->getEmployee();
         $allEmployees = [];
         $employees = [];
         $sps = Sp::where('employee_id', $employee->id)->whereIn('status', [1,2])->get();
         $sts = St::where('employee_id', $employee->id)->whereIn('status', [1,2])->get();
         return view('pages.sp.index-employee', [
            'employee' => $employee,
            'allEmployees' => $allEmployees,
            'employees' => $employees,
            'sps' => $sps,
            'sts' => $sts
         ])->with('i');
      }
      
      // foreach ($sps as $sp) {
      //    if ($sp->date_to < $now) {
      //       // dd($sp->code);
      //       $sp->update([
      //          'status' => 0
      //       ]);
      //    }
      // }

      // dd($employees);

      return view('pages.sp.index', [
         'employee' => $employee,
         'allEmployees' => $allEmployees,
         'employees' => $employees,
         'sps' => $sps
      ])->with('i');
   }

   public function indexEmployee(){
      // dd('ok');
         $employee = auth()->user()->getEmployee();
         $allEmployees = [];
         $employees = [];
         $sps = Sp::where('employee_id', $employee->id)->whereIn('status', [4,5])->get();
         // dd($sps);
         $sts = St::where('employee_id', $employee->id)->whereIn('status', [1,2])->get();
         return view('pages.sp.index-employee', [
            'employee' => $employee,
            'allEmployees' => $allEmployees,
            'employees' => $employees,
            'sps' => $sps,
            'sts' => $sts
         ])->with('i');
   }

   public function create(){
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $teams = [];
      if(count($employee->positions) > 0){
         foreach($employee->positions as $pos){
            foreach($pos->department->employees->where('status', 1) as $emp){
               $teamId[] = $emp;
            }
         }

         
      } else {
         $myEmployees = Employee::where('status', 1)->where('department_id', $employee->department->id)->get();
         foreach($myEmployees as $emp){
            $teamId[] = $emp;
         }
         
      }

      return view('pages.sp.form', [
         'teams' => $teams
      ]);
   }

   public function store(Request $req)
   {

      $date = Carbon::now();
      $employee = Employee::find($req->employee);

      $req->validate([
         'file' => request('file') ? 'mimes:pdf,jpg,jpeg,png|max:5120' : '',
      ]);

      $sp = Sp::orderBy("created_at", "desc")->first();
      if (isset($sp)) {
         $code = "SP/" . $employee->department->id . '/' . $date->format('dmy') . '/' . ($sp->id + 1);
      } else {
         $code = "SP/"  . $employee->department->id . '/' . $date->format('dmy') . '/' . 1;
      }

      $spEmployee = Sp::where('employee_id', $employee->id)->where('status', 1)->latest()->first();
      if ($spEmployee) {
         if ($spEmployee->level == 'I') {
            $level = 'II';
         } elseif ($spEmployee->level == 'II') {
            $level = 'III';
         } else {
            $level = 'I';
         }
      } else {
         $level = 'I';
      }

      if (request('file')) {
         
         $file = request()->file('file')->store('sp/file');
      }  else {
         $file = null;
      }

      // dd($req->date_from);
      // $from = Carbon::make($req->date_from);

      // $bulan = $from->format('m');
      // $tahun = $from->format('Y');

      // if ($bulan >= 1 && $bulan <= 6) {
      //    $semester =  1; // Semester 1: Januari sampai Juni
      // } else {
      //    $semester =  2; // Semester 2: Juli sampai Desember
      // }



      if (auth()->user()->id == 1) {
         return redirect()->back()->with('danger', 'SP Create Fail, Administrator cannot create SP');
      }

      Sp::create([
         'department_id' => $employee->department_id,
         'employee_id' => $req->employee,
         'by_id' => auth()->user()->getEmployee()->id,
         // 'semester' => $semester,
         // 'tahun' => $tahun,
         'status' => '0',
         'code' => $code,
         'level' => $req->level,
         // 'date_from' => $req->date_from,
         // 'date_to' => $from->addMonths(6),
         'reason' => $req->reason,
         'desc' => $req->desc,
         // 'rule' => $req->rule,
         'file' => $file
      ]);

         // $user = Employee::find(auth()->user()->getEmployeeId());
         // Log::create([
         //    'department_id' => $user->department_id,
         //    'user_id' => auth()->user()->id,
         //    'action' => 'Create',
         //    'desc' => 'SP ' . $sp->level . ' ' . $sp->code . ' ' . $employee->nik . ' ' . $employee->biodata->fullName()
         // ]);

      

      return redirect()->back()->with('success', 'SP Created');
   }

   public function hrdCreate()
   {
      $employees = Employee::where('status', 1)->get();

      if (auth()->user()->hasRole('HRD-Spv|HRD|HRD-Manager|HRD-Recruitment|HRD-Payroll')) {
         
         $employees = Employee::get();
         
      } elseif(auth()->user()->hasRole('HRD-KJ12')) {
         
         $employees = Employee::where('status', 1)->whereIn('location_id', [3])->get();
         
            
      } elseif (auth()->user()->hasRole('HRD-KJ45')) {

         $employees = Employee::where('status', 1)->whereIn('location_id', [4])->get();
         
      }
      return view('pages.sp.create', [
         'allEmployees' => $employees
      ]);
   }

   public function hrdStore(Request $req)
   {

      $date = Carbon::now();
      $employee = Employee::find($req->employee);

      $req->validate([
         'file' => request('file') ? 'mimes:pdf,jpg,jpeg,png|max:5120' : '',
      ]);

      $sp = Sp::orderBy("created_at", "desc")->first();

      // $posMan = Position::where('department_id', $sp->department->id)->where('designation_id', 6)->first();
      // $empPos = EmployeePosition::where('position_id', $posMan->id)->first();
      // $manager = Employee::find($empPos->employee_id);
      // dd($manager->biodata->fullName());

      if (isset($sp)) {
         $code = "SP/" . $employee->department->id . '/' . $date->format('dmy') . '/' . ($sp->id + 1);
      } else {
         $code = "SP/"  . $employee->department->id . '/' . $date->format('dmy') . '/' . 1;
      }

      $spEmployee = Sp::where('employee_id', $employee->id)->where('status', 1)->latest()->first();
      if ($spEmployee) {
         if ($spEmployee->level == 'I') {
            $level = 'II';
         } elseif ($spEmployee->level == 'II') {
            $level = 'III';
         } else {
            $level = 'I';
         }
      } else {
         $level = 'I';
      }

      if (request('file')) {
         
         $file = request()->file('file')->store('sp/file');
      }  else {
         $file = null;
      }

      // dd($req->date_from);
      $from = Carbon::make($req->date_from);
     
      // dd($to->addDays(-1));


      $bulan = $from->format('m');
      $tahun = $from->format('Y');

      if ($bulan >= 1 && $bulan <= 6) {
         $semester =  1; // Semester 1: Januari sampai Juni
      } else {
         $semester =  2; // Semester 2: Juli sampai Desember
      }

      if ($req->type == 1) {
         $status = 4;
         $by = auth()->user()->getEmployeeId();
         $note = 'Existing';
      } else {
         $status = 2;
         $by = $req->to;
         $note = 'Recomendation';

         SpApproval::create([
            'status' => 1,
            'sp_id' => $sp->id,
            'type' => 'Approve',
            'level' => 'hrd',
            'employee_id' => auth()->user()->getEmployeeId(),
         ]);
      }

      $to = $from->addMonths(6);
      $sp = Sp::create([
         'department_id' => $employee->department_id,
         'employee_id' => $req->employee,
         'by_id' => $by,
         // 'by' => $by,
         'status' => $status,
         'code' => $code,
         'level' => $req->level,
         'tahun' => $tahun,
         'semester' => $semester,
         'rule' => $req->rule,
         'date_from' => $req->date_from,
         'date_to' => $to->addDays(-1),
         'reason' => $req->reason,
         'desc' => $req->desc,
         'file' => $file,
         'note' => $note
      ]);

      if ($req->type == 1) {
      } else {
         SpApproval::create([
            'status' => 1,
            'sp_id' => $sp->id,
            'type' => 'Approve',
            'level' => 'hrd',
            'employee_id' => auth()->user()->getEmployeeId(),
         ]);
      }

      // SpApproval::create([
      //    'status' => 1,
      //    'sp_id' => $sp->id,
      //    'type' => 'Submit',
      //    'level' => 'user',
      //    'employee_id' => $by,
      // ]);

      // SpApproval::create([
      //    'status' => 1,
      //    'sp_id' => $sp->id,
      //    'type' => 'Approve',
      //    'level' => 'hrd',
      //    'employee_id' => auth()->user()->getEmployeeId(),
      // ]);

      // SpApproval::create([
      //    'status' => 1,
      //    'sp_id' => $sp->id,
      //    'type' => 'Submit',
      //    'level' => 'user',
      //    'employee_id' => auth()->user()->getEmployeeId(),
      // ]);

      // SpApproval::create([
      //    'status' => 1,
      //    'sp_id' => $sp->id,
      //    'type' => 'Approved',
      //    'level' => 'hrd',
      //    'employee_id' => auth()->user()->getEmployeeId(),
      // ]);

      // $posMan = Position::where('department_id', $sp->department->id)->where('designation_id', 6)->first();
      // $empPos = EmployeePosition::where('position_id', $posMan->id)->first();
      // // $manager = Employee::find($empPos->employee_id);
      
      // SpApproval::create([
      //    'status' => 1,
      //    'sp_id' => $sp->id,
      //    'type' => 'Approve',
      //    'level' => 'manager',
      //    'employee_id' => $manager->id,
      // ]);


      if (auth()->user()->id == 1) {
         return redirect()->back()->with('danger', 'SP Create Fail, Administrator cannot create SP');
      }

      

      $user = Employee::find(auth()->user()->getEmployeeId());
      Log::create([
         'department_id' => $user->department_id,
         'user_id' => auth()->user()->id,
         'action' => 'Create',
         'desc' => 'SP ' . $sp->level . ' ' . $sp->code . ' ' . $employee->nik . ' ' . $employee->biodata->fullName()
      ]);

      

      return redirect()->route('sp')->with('success', 'SP Created');
   }

   public function detail($id)
   {
      $spkl = Spkl::get()->first();
      $sp = Sp::find(dekripRambo($id));
      if (auth()->user()->hasRole('Administrator')) {
         // dd($sp->id);
      }
      // $manager = Employee::find(1);
      $employee = Employee::find($sp->employee_id);
      $userCurrent = Employee::where('nik', auth()->user()->username)->first();

      // dd($sp->id);
      // 21

      // $sps = Sp::get();
      // foreach($sps as $sp){
      //    $spApp = SpApproval::where('sp_id', $sp->id)->where('type', 'Submit')->first();
      //    $user = Employee::find($sp->by_id);

      //    if ($spApp) {
      //       # code...
      //    } else {
      //       // SpApproval::create([
      //       //    'status' => 1,
      //       //    'sp_id' => $sp->id,
      //       //    'type' => 'Submit',
      //       //    'level' => 'user',
      //       //    'employee_id' => $sp->by_id,
      //       //    'created_at' => $sp->created_at,
      //       //    'updated_at' => $sp->updated_at
      //       // ]);
      //    }
         
      // }

      $spDebug = Sp::find(24);
      $spApp = SpApproval::where('sp_id', $spDebug->id)->where('type', 'Approve')->where('level', 'manager')->first();
      // dd($spApp);
      $user = Employee::find($sp->by_id);
      // dd($user->biodata->fullName());

      if ($spApp) {
         // $spApp->update([
         //    'level' => 'user',
         //    'employee_id' => $spDebug->by_id,
         // ]);
      } else {
         // SpApproval::create([
         //    'status' => 1,
         //    'sp_id' => $spDebug->id,
         //    'type' => 'Approve',
         //    'level' => 'hrd',
         //    'employee_id' => 173,
         //    'created_at' => $spDebug->created_at,
         //    'updated_at' => $spDebug->updated_at
         // ]);
   }

      // hafiz = 173
      // lia = 165



      

      // $user = Employee::find($sp->by_id);
      // $spApproval = SpApproval::where('sp_id', $sp->id)->where('type', 'Submit')->where('level', 'user')->first();
      // $spApproval->update([
      //    'employee_id' => $user->id
      // ]);
      // dd($user->biodata->fullName());

      // dd($sp);
      $emp = Employee::find($sp->by_id);
      // dd($emp->biodata->fullName());

      if (auth()->user()->hasRole('Administrator')) {
         
      } else {
         if (auth()->user()->getEmployeeId() == $sp->employee_id) {
            if ($sp->status == 4) {
               $sp->update([
                  'status' => '5',
               ]);
         
               SpApproval::create([
                  'status' => 1,
                  'sp_id' => $sp->id,
                  'type' => 'Approve',
                  'level' => 'employee',
                  'employee_id' => auth()->user()->getEmployeeId(),
               ]);
         
               $employee = Employee::find(auth()->user()->getEmployeeId());
         
               Log::create([
                  'department_id' => $employee->department_id,
                  'user_id' => auth()->user()->id,
                  'action' => 'Confirm',
                  'desc' => 'SP ' . $sp->level . ' ' . $sp->code
               ]);
            }
         }
      }
      




      if (auth()->user()->hasRole('Administrator|HRD|HRD-Spv|HRD-Manager')) {
         $employees = Employee::get();
      } elseif (auth()->user()->hasRole('Manager')) {
         $employees = Employee::where('department_id', auth()->user()->getEmployee()->department_id)->where('designation_id', '<', 6)->get();
      } elseif (auth()->user()->hasRole('Leader') || auth()->user()->hasRole('Supervisor')) {
         $employees = Employee::where('department_id', auth()->user()->getEmployee()->department_id)->where('designation_id', '<', 4)->get();
      } else {
         $employees = [];
      }

      if ($sp->note) {
         $user = SpApproval::where('sp_id', $sp->id)->where('status', 1)->where('type', 'Release')->first();
      } else {
         $user = SpApproval::where('sp_id', $sp->id)->where('status', 1)->where('type', 'Submit')->first();
      }
      if (auth()->user()->hasRole('Administrator')) {
         // dd($user);
      } 

      // dd($user->id);
      $hrd = SpApproval::where('sp_id', $sp->id)->where('status', 1)->where('type', 'Approve')->where('level', 'hrd')->first();
      // dd($hrd->id);
      $manager = SpApproval::where('sp_id', $sp->id)->where('status', 1)->where('type', 'Approve')->where('level', 'manager')->first();
      $suspect = SpApproval::where('sp_id', $sp->id)->where('status', 1)->where('type', 'Approve')->where('level', 'employee')->first();
      // dd($sp->created_by->biodata->fullName());
      // dd();

      // dd($manager->employee->id);

      if ($employee->biodata->gender == 'Male') {
         $gen = 'Saudara';
      } elseif ($employee->biodata->gender == 'Female') {
         $gen = 'Saudari';
      } else {
         $gen = 'Saudara/Saudari';
      }

      $approvals = SpApproval::where('sp_id', $sp->id)->get();

      // dd($employees);
      return view('pages.sp.detail', [
         'spkl' => $spkl,
         'sp' => $sp,
         // 'manager' => $manager,
         'gen' => $gen,
         'employees' => $employees,
         'approvals' => $approvals,
         'user' => $user,
         'hrd' => $hrd,
         'manager' => $manager,
         'suspect' => $suspect,

         'userCurrent' => $userCurrent
      ]);
   }

   public function update(Request $req)
   {
      $sp = Sp::find($req->id);
      // dd($sp->code);
      $employee = Employee::find($sp->employee_id);

      $sp->update([
         // 'employee_id' => $req->employee,
         'level' => $req->level,
         'reason' => $req->reason,
         'desc' => $req->desc
      ]);

      $user = Employee::find(auth()->user()->getEmployeeId());
      Log::create([
         'department_id' => $user->department_id,
         'user_id' => auth()->user()->id,
         'action' => 'Update',
         'desc' => 'SP ' . $sp->level . ' ' . $sp->code . ' ' . $employee->nik . ' ' . $employee->biodata->fullName()
      ]);

      return redirect()->back()->with('success', 'SP updated.');
   }

   public function delete($id)
   {
      // dd('delete');
      $sp = Sp::find(dekripRambo($id));
      $employee = Employee::find($sp->employee_id);

      $user = Employee::find(auth()->user()->getEmployeeId());
      Log::create([
         'department_id' => $user->department_id,
         'user_id' => auth()->user()->id,
         'action' => 'Delete',
         'desc' => 'SP ' . $sp->level . ' ' . $sp->code . ' ' . $employee->nik . ' ' . $employee->biodata->fullName()
      ]);

      $sp->delete();

      return redirect()->route('sp')->with('success', 'SP deleted');
   }

   public function close($id)
   {
      // dd('delete');
      $sp = Sp::find(dekripRambo($id));
      $employee = Employee::find($sp->employee_id);

      $sp->update([
         'status' => 4
      ]);

      SpApproval::create([
         'status' => 1,
         'sp_id' => $sp->id,
         'type' => 'Approve',
         'level' => 'employee',
         'employee_id' => $sp->employee_id,
      ]);

      $user = Employee::find(auth()->user()->getEmployeeId());
      Log::create([
         'department_id' => $user->department_id,
         'user_id' => auth()->user()->id,
         'action' => 'Close',
         'desc' => 'SP ' . $sp->level . ' ' . $sp->code . ' ' . $employee->nik . ' ' . $employee->biodata->fullName()
      ]);

      return redirect()->back()->with('success', 'SP complain proccess completed ');
   }

   public function exportForm(){
      
      return view('pages.sp.export', [
         
      ]);

   }


   public function export(Request $req){
      $req->validate([

      ]);

      // dd($req->from);
      return Excel::download(new ExportsSpExport($req->from, $req->to), 'sp-list.xlsx');

      

   }



   public function leaderApproval(){
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $spRecomends = Sp::where('note', 'Recomendation')->where('by_id', $employee->id)->where('status', 2)->orderBy('updated_at', 'desc')->get();
      $stAlerts = St::where('leader_id', $employee->id)->where('status', 2)->orderBy('date', 'desc')->get();
      return view('pages.sp.leader.index', [
         'spApprovals' => $spRecomends,
         'stAlerts' => $stAlerts
      ]);

   }

   public function managerApproval(){
      $employee = Employee::where('nik', auth()->user()->username)->first();
      // $spRecomends = Sp::where('note', 'Recomendation')->where('by_id', $employee->id)->where('status', 2)->orderBy('updated_at', 'desc')->get();

      $teamId = [];
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

      $spApprovals = Sp::where('status', 3)->whereIn('employee_id', $teamId)->get();
      $stApprovals = St::where('status', 3)->whereIn('employee_id', $teamId)->get();
      // dd($spApprovals);
      return view('pages.sp.manager.index', [
         'spApprovals' => $spApprovals,
         'stApprovals' => $stApprovals
      ]);

   }


   
}
