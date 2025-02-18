<?php

namespace App\Http\Controllers;

use App\Models\AbsenceEmployee;
use App\Models\Employee;
use Illuminate\Http\Request;

class AbsenceLeaderController extends Controller
{
   public function index(){
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $reqForms = AbsenceEmployee::where('leader_id', $employee->id)->whereIn('status', [1,2])->get();
      $reqBackForms = AbsenceEmployee::where('cuti_backup_id', $employee->id)->whereIn('status', [1])->get();
      $activeTab = 'index';


      return view('pages.absence-request.leader.index', [
         'activeTab' => $activeTab,
         'reqForms' => $reqForms,
         'reqBackForms' => $reqBackForms
      ]);
   }

   public function history(){
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $reqForms = AbsenceEmployee::where('leader_id', $employee->id)->where('status', '>=', 3)->get();
      $activeTab = 'history';
      return view('pages.absence-request.leader.history', [
         'activeTab' => $activeTab,
         'reqForms' => $reqForms
      ]);
   }


   public function indexHrd(){
      // $employee = Employee::where('nik', auth()->user()->username)->first();
      $reqForms = AbsenceEmployee::whereIn('status', [3])->get();
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
