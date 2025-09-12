<?php

namespace App\Http\Controllers;

use App\Models\AbsenceEmployee;
use App\Models\Employee;
use App\Models\EmployeeLeader;
use App\Models\OvertimeEmployee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsenceLeaderController extends Controller
{
   public function index(){
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $user = Employee::where('nik', auth()->user()->username)->first();
      if (auth()->user()->hasRole('Manager|Asst. Manager')) {
         // dd($employee->id);
         $reqForms = AbsenceEmployee::where('manager_id', $employee->id)->whereIn('status', [2])->orderBy('release_date', 'asc')->get();
         $reqFormLeaderApproval = AbsenceEmployee::where('leader_id', $employee->id)->whereIn('status', [1])->orderBy('release_date', 'asc')->get();

         foreach($reqFormLeaderApproval as $lead){
            $reqForms[] = $lead;
         }
      } else {
         $reqForms = AbsenceEmployee::where('leader_id', $employee->id)->whereIn('status', [1])->orderBy('release_date', 'asc')->get();
      }

      // dd($reqForms);
      
      $allReqForms = AbsenceEmployee::whereIn('status', [1])->where('leader_id', $employee->id)->orderBy('release_date', 'desc')->get();
      // dd($allReqForms);
      $reqBackForms = AbsenceEmployee::where('cuti_backup_id', $employee->id)->whereIn('status', [1])->get();
      $activeTab = 'index';

      $myteams = EmployeeLeader::join('employees', 'employee_leaders.employee_id', '=', 'employees.id')
            ->join('biodatas', 'employees.biodata_id', '=', 'biodatas.id')
            ->where('leader_id', $employee->id)
            ->select('employees.*')
            ->orderBy('biodatas.first_name', 'asc')
            ->get();

      // dd($reqBackForms);


      if (auth()->user()->hasRole('Asst. Manager')) {
         
         // $empSpkls = OvertimeEmployee::where('status', 2)->orderBy('updated_at', 'desc')->get();
         if(count($user->positions) > 0){
            
            foreach($user->positions as $pos){
               foreach($pos->department->employees->where('status', 1) as $emp){
                  $teamId[] = $emp->id;
               }
            }
            
         } else {
            $myEmployees = Employee::where('status', 1)->where('department_id', $user->department->id)->whereNotIn('role', [5,6,8] )->get();
            foreach($myEmployees as $emp){
               $teamId[] = $emp->id;
            }
            
         }

         // dd('ok');
         $waitingMans = AbsenceEmployee::whereIn('employee_id', $teamId)->whereIn('status', [2])->get();
         foreach($waitingMans as $man){
            $allReqForms[] = $man;
         }
         // dd(AbsenceEmployee::wherein('employee_id', $teamId)->whereIn('status', [2])->get());

      //   dd($allReqForms);
      } elseif (auth()->user()->hasRole('Manager')) {
         // $empSpkls = OvertimeEmployee::where('status', 2)->orderBy('updated_at', 'desc')->get();
         if(count($user->positions) > 0){
            foreach($user->positions as $pos){
               foreach($pos->department->employees->where('status', 1) as $emp){
                  $teamId[] = $emp->id;
               }
            }

            $myEmployees = Employee::whereIn('id', $teamId)->whereNotIn('role', [5,6,8] )->get();

            
         } else {
            $myEmployees = Employee::where('status', 1)->where('department_id', $user->department->id)->whereNotIn('role', [5,6,8] )->get();
            foreach($myEmployees as $emp){
               $teamId[] = $emp->id;
            }
            
         }

         
      }






      if (auth()->user()->hasRole('Manager')) {
         // dd($employee->id);
         // dd($reqForms);
         return view('pages.absence-request.manager.index', [
            'activeTab' => $activeTab,
            'reqForms' => $reqForms,
            'reqBackForms' => $reqBackForms,
   
            'allReqForms' => $allReqForms,
            'myteams' => $myteams
         ]);
      } else {
         // dd('ok');
         // dd($reqForms);
         return view('pages.absence-request.leader.index', [
            'activeTab' => $activeTab,
            'reqForms' => $reqForms,
            'reqBackForms' => $reqBackForms,
   
            'allReqForms' => $allReqForms,
            'myteams' => $myteams
         ]);
      }

      
   }

   public function cutiBackup(){
      $now = Carbon::now();
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $reqForms = AbsenceEmployee::where('cuti_backup_id', $employee->id)->where('date', '=>', $now)->orderBy('updated_at', 'desc')->get();

      return view('pages.absence-request.backup', [
         // 'activeTab' => $activeTab,
         'reqForms' => $reqForms,
         // 'allReqForms' => $allReqForms,
         // 'reqBackForms' => $reqBackForms,
         // 'myteams' => $myteams
      ]);

   }

   public function history(){
      
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $reqForms = AbsenceEmployee::where('leader_id', $employee->id)->where('status', '>=', 3)->get();
      $allReqForms = AbsenceEmployee::where('status', '>=', 3)->get();
      $reqBackForms = AbsenceEmployee::where('cuti_backup_id', $employee->id)->where('status', '>', 1)->get();
      $activeTab = 'history';

      if (auth()->user()->hasRole('Manager')) {
         // dd($employee->id);
         $reqForms = AbsenceEmployee::where('manager_id', $employee->id)->where('status', '>=', 3)->orderBy('updated_at', 'desc')->get();
         $allReqForms = AbsenceEmployee::where('status', '>=', 3)->orderBy('updated_at', 'desc')->get();
      } else {
         $reqForms = AbsenceEmployee::where('leader_id', $employee->id)->where('status', '>=', 2)->orderBy('updated_at', 'desc')->get();
         $allReqForms = AbsenceEmployee::where('status', '>=', 2)->orderBy('updated_at', 'desc')->orderBy('updated_at', 'desc')->get();
      }
      $myteams = EmployeeLeader::join('employees', 'employee_leaders.employee_id', '=', 'employees.id')
            ->join('biodatas', 'employees.biodata_id', '=', 'biodatas.id')
            ->where('leader_id', $employee->id)
            ->select('employees.*')
            ->orderBy('biodatas.first_name', 'asc')
            ->get();


      if (auth()->user()->hasRole('Manager')) {
         // dd($employee->id);
         // dd($reqForms);
         // dd('ok');
         return view('pages.absence-request.manager.history', [
            'activeTab' => $activeTab,
            'reqForms' => $reqForms,
            'allReqForms' => $allReqForms,
            'reqBackForms' => $reqBackForms,
            'myteams' => $myteams
         ]);
      } else {
         return view('pages.absence-request.leader.history', [
            'activeTab' => $activeTab,
            'reqForms' => $reqForms,
            'allReqForms' => $allReqForms,
            'reqBackForms' => $reqBackForms,
            'myteams' => $myteams
         ]);
      }

     
   }


   public function indexHrd(){
      // $employee = Employee::where('nik', auth()->user()->username)->first();
      $reqForms = AbsenceEmployee::whereNotIn('status', [0,3])->orderBy('release_date', 'desc')->get();
      $activeTab = 'index';

      $totalApproval = AbsenceEmployee::where('status', 3)->orderBy('release_date', 'desc')->get()->count();


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

            $idEmp = [];
            foreach($employees as $emp){
               $idEmp[] = $emp->id;
            }
            $reqForms = AbsenceEmployee::whereNotIn('status', [0,3])->whereIn('employee_id', $idEmp)->orderBy('release_date', 'desc')->get();
            $totalApproval = AbsenceEmployee::whereNotIn('status', [0,3])->whereIn('employee_id', $idEmp)->orderBy('release_date', 'desc')->get()->count();
      } elseif (auth()->user()->hasRole('HRD-KJ45')) {
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj4')->orWhere('contracts.loc', 'kj5')
            ->orWhere('contracts.loc', 'kj4-housekeeping')
            ->orWhere('contracts.loc', 'kj5-housekeeping')
            ->select('employees.*')
            ->get();

            $idEmp = [];
            foreach($employees as $emp){
               $idEmp[] = $emp->id;
            }
            $reqForms = AbsenceEmployee::whereNotIn('status', [0,3])->whereIn('employee_id', $idEmp)->orderBy('release_date', 'desc')->get();
            $totalApproval = AbsenceEmployee::whereNotIn('status', [0,3])->whereIn('employee_id', $idEmp)->orderBy('release_date', 'desc')->get()->count();

         
      } elseif (auth()->user()->hasRole('HRD-JGC')) {
         $employees = Employee::whereIn('unit_id', [10,13,14])
               ->where('status', 1)
               ->get();

            $idEmp = [];
            foreach($employees as $emp){
               $idEmp[] = $emp->id;
            }
            $reqForms = AbsenceEmployee::whereNotIn('status', [0,3])->whereIn('employee_id', $idEmp)->orderBy('release_date', 'desc')->get();
            $totalApproval = AbsenceEmployee::whereNotIn('status', [0,3])->whereIn('employee_id', $idEmp)->orderBy('release_date', 'desc')->get()->count();

         
      }



      return view('pages.absence-request.hrd.index', [
         'activeTab' => $activeTab,
         'reqForms' => $reqForms,
         'totalApproval' => $totalApproval
      ]);
   }

   public function indexHrdApproval(){
      // $employee = Employee::where('nik', auth()->user()->username)->first();
      $reqForms = AbsenceEmployee::where('status', 3)->orderBy('release_date', 'desc')->get();
      $totalApproval = AbsenceEmployee::where('status', 3)->orderBy('release_date', 'desc')->get()->count();
      $activeTab = 'approval';

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

            $idEmp = [];
            foreach($employees as $emp){
               $idEmp[] = $emp->id;
            }
            $reqForms = AbsenceEmployee::where('status', 3)->whereIn('employee_id', $idEmp)->orderBy('release_date', 'desc')->get();
            $totalApproval = AbsenceEmployee::where('status', 3)->whereIn('employee_id', $idEmp)->orderBy('release_date', 'desc')->get()->count();
      } elseif (auth()->user()->hasRole('HRD-KJ45')) {
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj4')->orWhere('contracts.loc', 'kj5')
            ->orWhere('contracts.loc', 'kj4-housekeeping')
            ->orWhere('contracts.loc', 'kj5-housekeeping')
            ->select('employees.*')
            ->get();

            $idEmp = [];
            foreach($employees as $emp){
               $idEmp[] = $emp->id;
            }
            $reqForms = AbsenceEmployee::where('status', 3)->whereIn('employee_id', $idEmp)->orderBy('release_date', 'desc')->get();
            $totalApproval = AbsenceEmployee::where('status', 3)->whereIn('employee_id', $idEmp)->orderBy('release_date', 'desc')->get()->count();

         
      } elseif (auth()->user()->hasRole('HRD-JGC')) {
         $employees = Employee::whereIn('unit_id', [10,13,14])
               ->where('status', 1)
               ->get();

            $idEmp = [];
            foreach($employees as $emp){
               $idEmp[] = $emp->id;
            }
            $reqForms = AbsenceEmployee::where('status', 3)->whereIn('employee_id', $idEmp)->orderBy('release_date', 'desc')->get();
            $totalApproval = AbsenceEmployee::where('status', 3)->whereIn('employee_id', $idEmp)->orderBy('release_date', 'desc')->get()->count();

         
      }


     

           
      

      
      return view('pages.absence-request.hrd.index', [
         'activeTab' => $activeTab,
         'reqForms' => $reqForms,
         'totalApproval' => $totalApproval
      ]);
   }

   public function monitoringSpklHrd(){
      // $employee = Employee::where('nik', auth()->user()->username)->first();
      // $reqForms = AbsenceEmployee::where('status', '!=', 0)->where('status', '!=', 5)->orderBy('release_date', 'desc')->get();
      // $activeTab = 'index';
      $overtimeEmps = OvertimeEmployee::where('status', '>', 0)->orderBy('date', 'desc')->get();
      return view('pages.absence-request.hrd.spkl', [
         // 'activeTab' => $activeTab,
         'spkls' => $overtimeEmps
      ]);
   }

   public function historyHrd(){
      // $employee = Employee::where('nik', auth()->user()->username)->first();
      $reqForms = AbsenceEmployee::where('status', 5)->get();
      $activeTab = 'history';
      return view('pages.absence-request.hrd.history', [
         'activeTab' => $activeTab,
         'reqForms' => $reqForms
      ]);
   }
}
