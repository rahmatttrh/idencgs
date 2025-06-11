<?php

namespace App\Http\Controllers;

use App\Models\AbsenceEmployee;
use App\Models\Employee;
use App\Models\EmployeeLeader;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsenceLeaderController extends Controller
{
   public function index(){
      $employee = Employee::where('nik', auth()->user()->username)->first();
      if (auth()->user()->hasRole('Manager')) {
         // dd($employee->id);
         $reqForms = AbsenceEmployee::where('manager_id', $employee->id)->whereIn('status', [1,2])->orderBy('release_date', 'asc')->get();
      } else {
         $reqForms = AbsenceEmployee::where('leader_id', $employee->id)->whereIn('status', [1])->orderBy('release_date', 'asc')->get();
      }

      // dd($reqForms);
      
      $allReqForms = AbsenceEmployee::whereIn('status', [1])->where('leader_id', $employee->id)->orderBy('release_date', 'asc')->get();
      $reqBackForms = AbsenceEmployee::where('cuti_backup_id', $employee->id)->whereIn('status', [1])->get();
      $activeTab = 'index';

      $myteams = EmployeeLeader::join('employees', 'employee_leaders.employee_id', '=', 'employees.id')
            ->join('biodatas', 'employees.biodata_id', '=', 'biodatas.id')
            ->where('leader_id', $employee->id)
            ->select('employees.*')
            ->orderBy('biodatas.first_name', 'asc')
            ->get();

      // dd($reqBackForms);

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
      $reqForms = AbsenceEmployee::where('status', '!=', 5)->orderBy('release_date', 'desc')->get();
      $activeTab = 'index';
      return view('pages.absence-request.hrd.index', [
         'activeTab' => $activeTab,
         'reqForms' => $reqForms
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
