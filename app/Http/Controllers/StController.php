<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\St;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StController extends Controller
{

   public function index(){
      $sts = St::get();
      return view('pages.sp.teguran.index', [
         'sts' => $sts
      ]);
   }
   public function create(){
      $allEmployees = Employee::where('status', 1)->get();

      return view('pages.sp.teguran.create', [
         'allEmployees' => $allEmployees
      ]);
   }

   public function store(Request $req){
      $req->validate([
         'file' => request('file') ? 'mimes:pdf,jpg,jpeg,png|max:5120' : '',
      ]);

      $date = Carbon::now();
      $by = Employee::where('nik', auth()->user()->username)->first();
      $employee = Employee::find($req->employee);
      $st = St::orderBy("created_at", "desc")->first();

      if (isset($st)) {
         $code = "ST/" . $employee->department->id . '/' . $date->format('dmy') . '/' . ($st->id + 1);
      } else {
         $code = "ST/"  . $employee->department->id . '/' . $date->format('dmy') . '/' . 1;
      }

      if (request('file')) {
         
         $file = request()->file('file')->store('st/file');
      }  else {
         $file = null;
      }

      if ($req->type == 1) {
         $status = 4;
         
         $note = 'Existing';
      } else {
         $status = 2;
         $note = 'Recomendation';

        
      }

      // Store to database
      $st = St::create([
         'type' => $req->type,
         'date' => $req->date,
         'code' => $code,
         'employee_id' => $req->employee,
         'by_id' => auth()->user()->getEmployee()->id,
         'leader_id' => $req->to,
         'hrd_id' => auth()->user()->getEmployee()->id,
         'hrd_app_date' => $date,
         'status' => $status,
         'rule' => $req->rule,
         'desc' => $req->desc,
         'file' => $file,
         'note' => $note
      ]);

      return redirect()->route('st.detail', enkripRambo($st->id))->with('success', 'Surat Teguran berhasil dibuat');






   }


   public function detail($id){
      // dd('ok');
      $st = St::find(dekripRambo($id));
      $employee = Employee::find($st->employee_id);



      if ($employee->biodata->gender == 'Male') {
         $gen = 'Saudara';
      } elseif ($employee->biodata->gender == 'Female') {
         $gen = 'Saudari';
      } else {
         $gen = 'Saudara/Saudari';
      }

      if (auth()->user()->hasRole('Administrator')) {
         # code...
      } else {
         $employeeLogin = Employee::where('nik', auth()->user()->username)->first();
         if ($st->employee_id == $employeeLogin->id && $st->status == 1) {
            $st->update([
               'status' => 2
            ]);
         }
      }

      return view('pages.sp.teguran.detail', [
         'st' => $st,
         'gen' => $gen
      ]);
   }

   public function delete($id){
      $st = St::find(dekripRambo($id));
      $st->delete();

      return redirect()->route('st')->with('success', 'Surat Teguran berhasil dihapus');

   }



   public function approve($id){
      $st = St::find(dekripRambo($id));
      $user = Employee::find(auth()->user()->getEmployeeId());
      $now = Carbon::now();

      

      if ($user->id == $st->leader_id) {
         $st->update([
            'status' => 3,
            'leader_app_date' => $now
         ]);
      } elseif(auth()->user()->hasRole('Manager|Asst. Manager')){
         $st->update([
            'status' => 4,
            'manager_app_date' => $now,
            'manager_id' => $user->id
         ]);
      } elseif($user->id == $st->employee_id){
         $st->update([
            'status' => 5,
            'employee_app_date' => $now
         ]);
      }

      return redirect()->back()->with('success', 'Surat Teguran approved');
      
   }

   public function approveHrd($id){
      $st = St::find(dekripRambo($id));
      $user = Employee::find(auth()->user()->getEmployeeId());
      $now = Carbon::now();

      $st->update([
         'status' => 2,
         'hrd_app_date' => $now,
         'hrd_id' => $user->id
      ]);

      return redirect()->back()->with('success', 'Surat Teguran approved');
      
   }



}
