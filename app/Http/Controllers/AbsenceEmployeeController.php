<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\AbsenceEmployee;
use App\Models\Employee;
use Illuminate\Http\Request;

class AbsenceEmployeeController extends Controller
{
   public function index(){

      $employee = Employee::where('nik', auth()->user()->username)->first();
      $absences = Absence::where('employee_id', $employee->id)->orderBy('date', 'desc')->get();
      $activeTab = 'index';
      return view('pages.absence.index', [
         'activeTab' => $activeTab,
         'employee' => $employee,
         'absences' => $absences,
         'from' => null,
         'to' => null
      ]);
   }

   public function requestEmployee($id){
      $absence = Absence::find(dekripRambo($id));

      $activeTab = 'form';
      return view('pages.absence.request', [
         'activeTab' => $activeTab,
         'absence' => $absence,
         'from' => null,
         'to' => null
      ]);
   }

   public function pending(){

      $employee = Employee::where('nik', auth()->user()->username)->first();
      $absences = AbsenceEmployee::where('employee_id', $employee->id)->get();
      $activeTab = 'pending';
      return view('pages.absence.pending', [
         'activeTab' => $activeTab,
         'employee' => $employee,
         'absences' => $absences,
         'from' => null,
         'to' => null
      ]);
   }

   public function create(){
      $activeTab = 'form';
      return view('pages.absence.create', [
         'activeTab' => $activeTab,
         'absence' => null,
         'from' => null,
         'to' => null
      ]);
   }

   public function detail($id){
      $activeTab = 'form';
      $absenceEmployee = AbsenceEmployee::find(dekripRambo($id));
      $absenceCurrent = Absence::where('employee_id', $absenceEmployee->employee->id)->where('date', $absenceEmployee->date)->first();
      if ($absenceCurrent) {
         $absenceCurrentId = $absenceCurrent->id;
      } else {
         $absenceCurrentId = null;
      }

      $absenceEmployee->update([
         'absence_id' => $absenceCurrentId
      ]);

      return view('pages.absence.detail', [
         'activeTab' => $activeTab,
         'absenceEmployee' => $absenceEmployee,
         'from' => null,
         'to' => null
      ]);
   }

   public function store(Request $req){
      $req->validate([

      ]);

      $employee = Employee::where('nik', auth()->user()->username)->first();
      if (request('doc')) {
         $doc = request()->file('doc')->store('doc/absence');
      } else {
         $doc = null;
      }

      $absenceCurrent = Absence::where('employee_id', $employee->id)->where('date', $req->date)->first();
      if ($absenceCurrent) {
         $absenceCurrentId = $absenceCurrent->id;
      } else {
         $absenceCurrentId = null;
      }

      $absence = AbsenceEmployee::create([
         'status' => 0,
         'employee_id' => $employee->id,
         'absence_id' => $absenceCurrentId,
         'type' => $req->type,
         'type_desc' => $req->type_desc,
         'date' => $req->date,
         'desc' => $req->desc,
         'transport' => $req->transport,
         'destination' => $req->destination,
         'from' => $req->from,
         'transit' => $req->transit,
         'duration' => $req->duration,
         'departure' => $req->departure,
         'return' => $req->return,
         'remark' => $req->remark,
         'doc' => $doc
      ]);

      return redirect()->route('employee.absence.detail', enkripRambo($absence->id))->with('success', 'Pengajuan berhasil dibuat');
   }


   public function delete($id){
      $absenceEmployee = AbsenceEmployee::find(dekripRambo($id));
      $absenceEmployee->delete();

      return redirect()->back()->with('success', 'Data berhasil dihapus');
   }









   // APPROVAL
   public function approve($id){
      dd('ok');
   }
}
