<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\AbsenceEmployee;
use App\Models\AbsenceEmployeeDetail;
use App\Models\Cuti;
use App\Models\Employee;
use App\Models\EmployeeLeader;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsenceEmployeeController extends Controller
{
   public function index(){

      $employee = Employee::where('nik', auth()->user()->username)->first();
      $absences = Absence::where('employee_id', $employee->id)->orderBy('date', 'desc')->get();
      $activeTab = 'index';
      return view('pages.absence-request.index', [
         'activeTab' => $activeTab,
         'employee' => $employee,
         'absences' => $absences,
         'from' => null,
         'to' => null
      ]);
   }

   public function requestEmployee($id){
      $absence = Absence::find(dekripRambo($id));
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $employeeLeaders = EmployeeLeader::where('employee_id', $employee->id)->get();
      $activeTab = 'form';
      $employees = Employee::where('department_id', $employee->department_id)->get();
      return view('pages.absence-request.request', [
         'activeTab' => $activeTab,
         'absence' => $absence,
         'employeeLeaders' => $employeeLeaders,
         'employees' => $employees,
         'from' => null,
         'to' => null
      ]);
   }

   public function pending(){

      $employee = Employee::where('nik', auth()->user()->username)->first();
      $absences = AbsenceEmployee::where('employee_id', $employee->id)->whereIn('status', [1,2])->get();
      // dd($absences);
      $activeTab = 'pending';
      return view('pages.absence-request.pending', [
         'activeTab' => $activeTab,
         'employee' => $employee,
         'absences' => $absences,
         'from' => null,
         'to' => null
      ]);
   }

   public function draft(){

      $employee = Employee::where('nik', auth()->user()->username)->first();
      $absences = AbsenceEmployee::where('employee_id', $employee->id)->where('status', 0)->get();
      $activeTab = 'draft';
      return view('pages.absence-request.draft', [
         'activeTab' => $activeTab,
         'employee' => $employee,
         'absences' => $absences,
         'from' => null,
         'to' => null
      ]);
   }

   public function create(){
      $activeTab = 'form';
      $date = 0;
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $employees = Employee::where('department_id', $employee->department_id)->get();
      // dd($employees);
      $employeeLeaders = EmployeeLeader::where('employee_id', $employee->id)->get();
      $now = Carbon::now();
      // $cutis = Absence::where()
      $cutis = Absence::join('employees', 'absences.employee_id', '=', 'employees.id')
      ->where('absences.type', 5)->where('employees.department_id', $employee->department_id)->whereDate('absences.date', '>=', $now)->select('absences.*')->get();
      // dd($employeeLeaders);
      // dd($cutis);
      return view('pages.absence-request.create', [
         'activeTab' => $activeTab,
         'employeeLeaders' => $employeeLeaders,
         'employees' => $employees,
         'absence' => null,
         'from' => null,
         'to' => null,
         'date' => $date,
         'cutis' => $cutis
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

      if ($absenceEmployee->type == 4){
         $type = 'izin';
      } elseif($absenceEmployee->type == 5){
         $type = 'Cuti';
      } elseif($absenceEmployee->type == 6){
         $type = 'SPT';
      } elseif($absenceEmployee->type == 7){
         $type = 'Sakit';
      }

      $leader = Employee::where('nik', auth()->user()->username)->first();
      $employee = Employee::find($absenceEmployee->employee_id);

      $cuti = Cuti::where('employee_id', $employee->id)->first();
      $employees = Employee::where('department_id', $employee->department_id)->get();
      $employeeLeaders = EmployeeLeader::where('employee_id', $leader->id)->get();
      

      if ($absenceEmployee->type == 5) {
         $absenceEmployeeDetails = AbsenceEmployeeDetail::where('absence_employee_id', $absenceEmployee->id)->get();
         $start = AbsenceEmployeeDetail::where('absence_employee_id', $absenceEmployee->id)->orderBy('date', 'asc')->first();
         $end = AbsenceEmployeeDetail::where('absence_employee_id', $absenceEmployee->id)->orderBy('date', 'desc')->first();
         $total = count($absenceEmployeeDetails);

         if (count($absenceEmployeeDetails) > 0) {
            $absenceEmployee->update([
               'cuti_qty' => $total,
               'cuti_start' => $start->date,
               'cuti_end' => $end->date
            ]);
         }
         
         // dd($total);
      } else {
         $absenceEmployeeDetails = null;
      }
      // dd($employee->nik);
      // dd($absenceEmployee->employee->biodata->fullName());
      return view('pages.absence-request.detail', [
         'activeTab' => $activeTab,
         'type' => $type,
         'employee' => $employee,
         'absenceEmp' => $absenceEmployee,
         'employeeLeaders' => $employeeLeaders,
         'absenceEmployeeDetails' => $absenceEmployeeDetails,
         'employees' => $employees,
         'cuti' => $cuti,
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

      if ($req->type == 5) {
         $desc = $req->keperluan;
         $leader = $req->persetujuan;
      } elseif($req->type == 6){
         $desc = $req->desc;
         $leader = $req->leader;
      } else {
         $desc = $req->desc;
         $leader = null;
      }

      // if (request('doc')) {
      //    $doc = request()->file('doc')->store('docs/formulir');
      // } else {
      //    $doc = null;
      // }

      $absence = AbsenceEmployee::create([
         'status' => 0,
         'employee_id' => $employee->id,
         'absence_id' => $absenceCurrentId,
         'leader_id' => $leader,
         'type' => $req->type,
         'type_desc' => $req->type_desc,
         'date' => $req->date,
         'transport' => $req->transport,
         'destination' => $req->destination,
         'from' => $req->from,
         'transit' => $req->transit,
         'duration' => $req->duration,
         'departure' => $req->departure,
         'return' => $req->return,

         'cuti_taken' => $req->cuti_taken,
         'cuti_qty' => $req->cuti_qty,
         'cuti_start' => $req->cuti_start,
         'cuti_end' => $req->cuti_end,
         'cuti_backup_id' => $req->cuti_backup,


         'desc' => $desc,
         'remark' => $req->remark,
         'doc' => $doc
      ]);

      return redirect()->route('employee.absence.detail', enkripRambo($absence->id))->with('success', 'Pengajuan berhasil dibuat');
   }


   public function update(Request $req){
      $absenceEmp = AbsenceEmployee::find($req->absenceEmp);
      if (request('doc')) {
         $doc = request()->file('doc')->store('doc/absence');
      } elseif ($absenceEmp->doc) {
         $doc = $absenceEmp->doc;
      } else {
         $doc = null;
      }

      

      // dd($req->keperluan);
      if ($absenceEmp->type == 5) {
         $desc = $req->keperluan;
         $leader = $req->persetujuan;
      } elseif($absenceEmp->type == 6){
         $desc = $req->desc;
         $leader = $req->leader;
      } else {
         $desc = $req->desc;
         $leader = null;
      }
      // dd($desc);
      $absenceEmp->update([
         'leader_id' => $leader,
         // 'type' => $req->type,
         'type_desc' => $req->type_desc,
         // 'date' => $req->date,
         'transport' => $req->transport,
         'destination' => $req->destination,
         'from' => $req->from,
         'transit' => $req->transit,
         'duration' => $req->duration,
         'departure' => $req->departure,
         'return' => $req->return,

         'cuti_taken' => $req->cuti_taken,
         'cuti_qty' => $req->cuti_qty,
         'cuti_start' => $req->cuti_start,
         'cuti_end' => $req->cuti_end,
         'cuti_backup_id' => $req->cuti_backup,

         'desc' => $desc,
         'remark' => $req->remark,
         'doc' => $doc
      ]);

      // dd($absenceEmp->desc);

      return redirect()->back()->with('success', 'Request Absensi updated');
   }


   public function delete($id){
      $absenceEmployee = AbsenceEmployee::find(dekripRambo($id));
      $absenceEmployee->delete();

      return redirect()->back()->with('success', 'Data berhasil dihapus');
   }


   public function exportSpt($id){
      $absenceEmp = AbsenceEmployee::find(dekripRambo($id));

      return view('pages.pdf.spt', [
         'absenceEmp' => $absenceEmp
      ]);
   }

   public function exportCuti($id){
      $absenceEmp = AbsenceEmployee::find(dekripRambo($id));
      $employee = Employee::find($absenceEmp->employee_id);
      $cuti = Cuti::where('employee_id', $employee->id)->first();
      return view('pages.pdf.cuti', [
         'employee' => $employee,
         'absenceEmp' => $absenceEmp,
         'cuti' => $cuti
      ]);
   }









   // APPROVAL
   public function release($id){
      $reqForm = AbsenceEmployee::find(dekripRambo($id));

      if ($reqForm->type == 5) {
         if ($reqForm->cuti_qty == 0) {
            return redirect()->back()->with('danger', 'Gagal, Tanggal Cuti belum di pilih');
         }
         $status = 1;
      } elseif($reqForm->type == 6){
         $status = 2;
      }
      // dd('ok');
      $now = Carbon::now();
      $reqForm->update([
         'status' => $status,
         'release_date' => $now
      ]);

      return redirect()->back()->with('success', 'Pengajuan Absensi berhasil dikirim');
   }

   public function approve($id){
      $reqForm = AbsenceEmployee::find(dekripRambo($id));
      $employee = Employee::where('nik', auth()->user()->username)->first();
      if ($reqForm->type == 5) {
         if ($reqForm->leader_id == $employee->id) {
            $status = 5;
         } else {
            $status = 2;
         }
        
        $form = 'Cuti';
      } elseif($reqForm->type == 6){
         $status = 5;
         $form = 'SPT';
      }
      $now = Carbon::now();
      if ($reqForm->app_backup_date != null) {
         $backupDate = $reqForm->app_backup_date;
      } else {
         $backupDate = $now;
      }
      $reqForm->update([
         'status' => $status,
         'app_backup_date' => $backupDate,
         'app_leader_date' => $now
      ]);

      $date = Carbon::create($reqForm->date);
      if ($reqForm->absence_id != null) {
         $absence = Absence::find($reqForm->absence_id);
         
         if ($absence->type == 1){
            $type = 'Alpha';
         } elseif($absence->type == 2){
            $type = 'Terlambat';
         } elseif($absence->type == 3) {
            $type = 'ATL';
         } elseif($absence->type == 4){
            $type = 'Izin';
         } elseif($absence->type == 5){
            $type = 'Cuti';
         } elseif($absence->type == 6){
            $type = 'SPT';
         } elseif($absence->type == 7){
            $type = 'Sakit';
         } elseif($absence->type == 8){
            $type = 'Dinas Luar';
         } elseif($absence->type == 9){
            $type = 'Off Contract';
         }
         
         $revisi = $type;
         $absence->update([
            'type' => $reqForm->type,
            'type_izin' => $reqForm->type_desc,
            'type_spt' => $reqForm->type_desc,
            'desc' => $reqForm->desc,
            'revisi' => $revisi
         ]);
      } else {
         Absence::create([
            'employee_id' => $reqForm->employee_id,
            'type' => $reqForm->type,
            'type_izin' => $reqForm->type_desc,
            'type_spt' => $reqForm->type_desc,
            'desc' => $reqForm->desc,
            'month' => $date->format('F'),
            'year' => $date->format('Y'),
            'date' => $reqForm->date,
            // 'revisi' => $revisi
         ]);
      }

      return redirect()->back()->with('success', 'Formulir ' . $form . ' ' . 'berhasil di setujui');

   }

   public function approveBackup($id){
      $reqForm = AbsenceEmployee::find(dekripRambo($id));
      $employee = Employee::where('nik', auth()->user()->username)->first();
      if ($reqForm->type == 5) {
         
        
        $form = 'Cuti';
      } elseif($reqForm->type == 6){
        
         $form = 'SPT';
      }
      $now = Carbon::now();
      $reqForm->update([
         'status' => 2,
         'app_backup_date' => $now
      ]);

      return redirect()->back()->with('success', 'Formulir ' . $form . ' ' . 'berhasil di setujui');

   }


   public function approveHrd($id){
      $reqForm = AbsenceEmployee::find(dekripRambo($id));
      $employee = Employee::where('nik', auth()->user()->username)->first();
      
      if ($reqForm->type == 5) {
        $form = 'Cuti';
        
      } elseif($reqForm->type == 6){
         $form = 'SPT';
      }

      $reqForm->update([
         'status' => 5
      ]);

      if ($reqForm->absence_id != null) {
         $absence = Absence::find($reqForm->absence_id);
         
         if ($absence->type == 1){
            $type = 'Alpha';
         } elseif($absence->type == 2){
            $type = 'Terlambat';
         } elseif($absence->type == 3) {
            $type = 'ATL';
         } elseif($absence->type == 4){
            $type = 'Izin';
         } elseif($absence->type == 5){
            $type = 'Cuti';
         } elseif($absence->type == 6){
            $type = 'SPT';
         } elseif($absence->type == 7){
            $type = 'Sakit';
         } elseif($absence->type == 8){
            $type = 'Dinas Luar';
         } elseif($absence->type == 9){
            $type = 'Off Contract';
         }
         
         $revisi = $type;
         $absence->update([
            'type' => $reqForm->type,
            'type_izin' => $reqForm->type_desc,
            'type_spt' => $reqForm->type_desc,
            'desc' => $reqForm->desc,
            'revisi' => $revisi
         ]);
      } else {
         Absence::create([
            'type' => $reqForm->type,
            'type_izin' => $reqForm->type_desc,
            'type_spt' => $reqForm->type_desc,
            'desc' => $reqForm->desc,
            // 'revisi' => $revisi
         ]);
      }


      return redirect()->back()->with('success', 'Formulir ' . $form . ' ' . 'berhasil di setujui');

   }
}
