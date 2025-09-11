<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\AbsenceEmployee;
use App\Models\AbsenceEmployeeDetail;
use App\Models\Cuti;
use App\Models\Employee;
use App\Models\EmployeeLeader;
use App\Models\Log;
use App\Models\Overtime;
use App\Models\OvertimeEmployee;
use App\Models\Permit;
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

   public function indexTeam(){

      $employee = Employee::where('nik', auth()->user()->username)->first();
      $teams = EmployeeLeader::where('leader_id', $employee->id)->get();
      $absences = Absence::where('employee_id', $employee->id)->orderBy('date', 'desc')->get();
      $activeTab = 'index';

      $formAbsences = [];
      foreach($teams as $emp){
         $empAbsences = AbsenceEmployee::where('employee_id', $emp->employee_id)->where('status', '>', 0)->orderBy('updated_at', 'desc')->get();
         foreach($empAbsences as $abs){
            $formAbsences[] = $abs;
         }
      }


      return view('pages.absence-request.leader.monitoring', [
         'activeTab' => $activeTab,
         'employee' => $employee,
         'formAbsences' => $formAbsences,

      ]);
   }

   public function indexAdmin(){

      // $employee = Employee::where('nik', auth()->user()->username)->first();
      $absences = AbsenceEmployee::where('status', '>', 0)->orderBy('created_at', 'desc')->get();
      $activeTab = 'index';
      return view('pages.absence-request.admin.index', [
         'activeTab' => $activeTab,
         // 'employee' => $employee,
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
      $date = Carbon::make($absence->date);

      $allManagers = Employee::where('role', 5)->get();
      $employeeLeaders = EmployeeLeader::where('employee_id', $employee->id)->get();
      // dd($employeeLeaders);
      $leader = null;
      foreach($employeeLeaders as $lead){

         if ($lead->leader->role == 7) {
            $empLead = Employee::find($lead->leader_id);
            $leader = $empLead;
         }
      }

      if ($leader == null) {
         $assmen = Employee::where('department_id', $employee->department_id)->where('role', 8)->first();
         $leader = $assmen;
      }

      if ($leader == null) {
         $assmen = Employee::where('department_id', $employee->department_id)->where('role', 5)->first();
         $leader = $assmen;
      }

      $managers = Employee::where('department_id', $employee->department_id)->where('role', 5)->get();
      // dd($managers);
      if (count($managers) == 0) {
         foreach($allManagers as $man){
            if (count($man->positions) > 0) {
               foreach($man->positions as $pos){
                  if ($pos->department_id == $employee->department_id) {
                     $managers[] = $man;
                  }
               }
            }
         }
      }
      // if ($leader == null) {
      //    $leader = $managers;
      // }
      // dd('ok');
      return view('pages.absence-request.request', [
         'activeTab' => $activeTab,
         'absence' => $absence,
         'employeeLeaders' => $employeeLeaders,
         'employees' => $employees,
         'leader' => $leader,
         'managers' => $managers,
         'date' => $date,
         'from' => null,
         'to' => null
      ]);
   }

   public function pending(){

      // dd('ok');
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $absences = AbsenceEmployee::where('employee_id', $employee->id)->whereIn('status', [1,2,5,101,202])->orderBy('updated_at', 'desc')->get();
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
      $absences = AbsenceEmployee::where('employee_id', $employee->id)->where('status', 0)->orderBy('updated_at', 'desc')->get();
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
      // dd('Under Maintenance')
      $activeTab = 'form';
      $date = 0;
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $employees = Employee::where('department_id', $employee->department_id)->get();
      // dd($employees);
      $allManagers = Employee::where('role', 5)->where('status', 1)->get();
      $employeeLeaders = EmployeeLeader::where('employee_id', $employee->id)->get();
      // dd($employeeLeaders);
      $leader = null;
      // dd($employeeLeaders);

      // dd($employeeLeaders);
      foreach($employeeLeaders as $lead){

         if ($lead->leader->role == 7) {
            $empLead = Employee::find($lead->leader_id);
            $leader = $empLead;
         }
      }

      if ($leader == null) {
         foreach($employeeLeaders as $lead){

            if ($lead->leader->role == 5) {
               $empLead = Employee::find($lead->leader_id);
               $leader = $empLead;
            }
         }
      }

      if ($leader == null) {
         $assmen = Employee::where('department_id', $employee->department_id)->where('role', 8)->first();
         $leader = $assmen;
      }

      if ($leader == null) {
         $assmen = Employee::where('department_id', $employee->department_id)->where('role', 5)->first();
         $leader = $assmen;
      }

      $managers = Employee::where('department_id', $employee->department_id)->where('role', 5)->get();
      // dd($managers);
      if (count($managers) == 0) {
         foreach($allManagers as $man){
            if (count($man->positions) > 0) {
               foreach($man->positions as $pos){
                  if ($pos->department_id == $employee->department_id) {
                     $managers[] = $man;
                  }
               }
            }
         }
      }


      // if ($leader == null) {
      //    // $assmen = Employee::where('department_id', $employee->department_id)->where('role', 5)->first();
      //    $leader = $managers;
      // }
      // @if (count($employee->positions) > 0)
      //                @foreach ($positions as $pos)
      //                 <b>{{$pos->department->unit->name ?? '-'}} {{$pos->department->name ?? '-'}} </b> <br>
      //                <small class="">{{$pos->name}}</small>
      //                <br>
      //                {{-- <div class="row">
      //                   <div class="col-md-4">
      //                      {{$pos->department->name}}
      //                   </div>
      //                   <div class="col">
      //                      {{$pos->name}}
      //                   </div>
      //                </div> --}}
      //                   {{-- <small>- {{$pos->name}}</small> <br> --}}
      //                @endforeach

      //              @else
      //              <b>{{$employee->unit->name ?? '-'}} - {{$employee->department->name}}</b><br>
      //              @if ($employee->position->type == 'subdept')
      //                  {{$employee->sub_dept->name}}
      //                  <hr>
      //              @endif

      //             <small>{{$employee->position->name}}</small>
      //          @endif
      $now = Carbon::now();
      // $cutis = Absence::where()
      $cutis = Absence::join('employees', 'absences.employee_id', '=', 'employees.id')
      ->where('absences.type', 5)->where('employees.department_id', $employee->department_id)->whereDate('absences.date', '>=', $now)->select('absences.*')->get();
      // dd($employeeLeaders);
      // dd($cutis);

      // dd($cutis);

      $permits = Permit::get();

      // dd($backDate);
      return view('pages.absence-request.create', [
         'activeTab' => $activeTab,
         'employee' => $employee,
         'employeeLeaders' => $employeeLeaders,
         'managers' => $managers,
         'employees' => $employees,
         'absence' => null,
         'from' => null,
         'to' => null,
         'date' => $date,
         'cutis' => $cutis,
         'permits' => $permits,
         'leader' => $leader,
      ]);
   }

   public function detail($id, $type){
      $activeTab = 'form';
      $pageType = dekripRambo($type);
      // dd($pageType);
      // dd(dekripRambo($type));
      $emps = collect();
      if (auth()->user()->hasRole('Administrator')) {
        $user = null;
        $emps = [];
      } else {
         
         $user = Employee::where('nik', auth()->user()->username)->first();
      }
      // dd(dekripRambo($id));
      // dd('ok');


      $absenceEmployee = AbsenceEmployee::find(dekripRambo($id));
      // dd(dekripRambo($id));
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
      } elseif($absenceEmployee->type == 10){
         $type = 'Izin Resmi';
      }

      if ($user) {
         $leader = Employee::where('nik', auth()->user()->username)->first();
      }

      $employee = Employee::find($absenceEmployee->employee_id);


      $cuti = Cuti::where('employee_id', $employee->id)->first();
      $employees = Employee::where('department_id', $employee->department_id)->get();
      // dd($employees);


      if ($user) {
         $employeeLeaders = EmployeeLeader::where('employee_id', $leader->id)->get();

      } else{
         $employeeLeaders = [];
      }


      // $myteams = EmployeeLeader::join('employees', 'employee_leaders.employee_id', '=', 'employees.id')
      // ->join('biodatas', 'employees.biodata_id', '=', 'biodatas.id')
      // ->where('leader_id', $user->id)
      // ->select('employees.*')
      // ->orderBy('biodatas.first_name', 'asc')
      // ->get();
      if ($user) {
         // dd($user->designation_id);
         if ($employee->designation_id > 4) {
            if (count($employee->positions) > 1) {
              foreach($employee->positions as $pos){
               $myteams = Employee::where('department_id', $pos->department_id)->whereIn('designation_id', [3,4,5])->where('id', '!=', $absenceEmployee->employee_id)->get();
               // dd(myteams);
               // $myteams = EmployeeLeader::where('leader_id', $user->id)->where('employee_id', '!=', $user->id)->get();
               foreach($myteams as $team){
                  // $emp = Employee::find($team->id);
                  $emps[] = $team;

               }
              }

            //   dd($emps);
            } else {
               $myteams = Employee::where('department_id', $user->department_id)->whereIn('designation_id', [3,4,5])->where('id', '!=', $absenceEmployee->employee_id)->get();
               // dd(myteams);
               // $myteams = EmployeeLeader::where('leader_id', $user->id)->where('employee_id', '!=', $user->id)->get();
               foreach($myteams as $team){
                  // $emp = Employee::find($team->id);
                  $emps[] = $team;

               }
            }
            
            // dd('ok');

            // dd($emps);
         } else {
            $myteams = EmployeeLeader::where('leader_id', $user->id)->get();

            $emps = [];

            foreach($myteams as $team){
               $emp = Employee::find($team->employee_id);
               $emps[] = $emp;
            }
         }

      } else {
         $myteams = null;
      }

      if ($employee->designation_id == 1) {
         $backs = Employee::where('department_id', $employee->department_id)->whereIn('designation_id', [1,2])->where('status', 1)->get();
      } else {
         $backs = Employee::where('department_id', $employee->department_id)->where('designation_id', '<=', $employee->designation_id)->where('status', 1)->get();
      }

      

      // dd($employee->designation_id);

      // dd($absenceEmployee->type);


      if ($absenceEmployee->type == 5 || $absenceEmployee->type == 7) {
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
      } else if ($absenceEmployee->type == 10) {
         $absenceEmployeeDetails = AbsenceEmployeeDetail::where('absence_employee_id', $absenceEmployee->id)->get();

       } else {
         $absenceEmployeeDetails = collect();
      }


      // dd($absenceEmployeeDetails);

      // dd($employee->nik);
      // dd($absenceEmployee->employee->biodata->fullName());
      $user = Employee::where('nik', auth()->user()->username)->first();
      $backDate = Carbon::now()->addDay(-7);

      if ($absenceEmployee->type == 5) {
         $dateArray = [];
         foreach($absenceEmployeeDetails as $detail){
            $dateArray[] = $detail->date;
         }
         $sameDateForms = AbsenceEmployeeDetail::whereIn('date', $dateArray)->get();
      } else {
         $sameDateForms = null;
      }


      // dd($pageType);

      return view('pages.absence-request.detail', [
         'pageType' => $pageType,
         'myteams' => $myteams,
         'activeTab' => $activeTab,
         'type' => $type,
         'employee' => $employee,
         'absenceEmp' => $absenceEmployee,
         'employeeLeaders' => $employeeLeaders,
         'absenceEmployeeDetails' => $absenceEmployeeDetails,
         'employees' => $employees,
         'cuti' => $cuti,
         'from' => null,
         'to' => null,
         'user' => $user,
         'backDate' => $backDate,
         'sameDateForms' => $sameDateForms,
         'emps' => $backs
      ]);
   }

   public function store(Request $req){
      

      if ($req->type == 7) {
         $req->validate([
            'doc' => 'required'
         ]);
      }

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

      $typeDesc = null;

      if ($req->type == 5) {
         $req->validate([
            'keperluan' => 'required',
            'persetujuan' => 'required',
            // 'cuti_backup' => 'required'
         ]);
         $manager = $req->manager;
         $desc = $req->keperluan;
         $leader = $req->persetujuan;
         $date = Carbon::now();
         $permitId = null;
         // dd($date);
      } if ($req->type == 4) {
         $req->validate([
            // 'keperluan' => 'required',
            // 'persetujuan' => 'required',
            // 'cuti_backup' => 'required'
         ]);
         // dd($req->desc);
         $manager = $req->manager;
         $desc = $req->desc_izin;
         // dd($desc);
         $leader = $req->persetujuan;
         $date = $req->date;
         $permitId = null;
         $typeDesc = $req->type_izin;
         

      } elseif($req->type == 6){
         $req->validate([
            'leader' => 'required',
            'desc' => 'required'
         ]);
         $typeDesc = $req->type_desc;
         $desc = $req->desc;
         $leader = $req->leader;
         $manager = $req->manager;
         $date = $req->date;
         $permitId = null;
      } elseif($req->type == 10){

         $desc = $req->desc;
         $leader = $req->persetujuan;
         $manager = $req->manager;
         $date = Carbon::now();
         $permitId = $req->permit;

      }  elseif($req->type == 7){

         $desc = $req->desc;
         $leader = $req->persetujuan;
         $manager = $req->manager;
         $date = $req->date;
         $permitId = null;
         // dd('7');
      }
      // else {
      //    $desc = $req->desc;
      //    $leader = null;
      //    $manager = null;
      //    $date = $req->date;
      //    $permitId = null;
      //    dd('ok');
      //  }


      // dd($desc);

      if ($req->type == 4) {
         $departure = $req->date . ' ' . $req->permit_from;
         $return = $req->date . ' ' . $req->permit_to;
      } else {
         $departure = $req->departure;
         $return = $req->return;
      }

      $absence = AbsenceEmployee::create([
         'status' => 0,
         'employee_id' => $employee->id,
         'absence_id' => $absenceCurrentId,
         'manager_id' => $manager,
         'leader_id' => $leader,
         'type' => $req->type,
         'type_desc' => $typeDesc,
         'date' => $date,
         'transport' => $req->transport,
         'destination' => $req->destination,
         'from' => $req->from,
         'transit' => $req->transit,
         'duration' => $req->duration,
         'departure' => $departure,
         'return' => $return,

         'cuti_taken' => $req->cuti_taken,
         'cuti_qty' => $req->cuti_qty,
         'cuti_start' => $req->cuti_start,
         'cuti_end' => $req->cuti_end,
         'cuti_backup_id' => $req->cuti_backup,


         'desc' => $desc,
         'remark' => $req->remark,
         'doc' => $doc,
         'permit_id' => $permitId
      ]);

      if ($absence->type == 4) {
         $type = 'Izin';
      } else if($absence->type == 5){
         $type = 'Cuti';
      } else if($absence->type == 6){
         $type = 'SPT';
      } else if($absence->type == 10){
         $type = 'Izin Resmi';
      } else if($absence->type == 7){
         $type = 'Sakit';
      }

      $now = Carbon::now();

      $lastAbsence = AbsenceEmployee::orderBy('updated_at', 'desc')->get();

      if ($lastAbsence != null) {
         $id = count($lastAbsence) + 1;
      } else {
         $id = 1;
      }

      $date = Carbon::make($absence->date);


      if($absence->type == 4 ){
         $code =  'FHRD/FA/I/' . $date->format('m')  . $date->format('y') . '/' . $id ;
      } elseif($absence->type == 6 ){
         $code =  'FHRD/FA/S/' . $date->format('m')  . $date->format('y') . '/' . $id ;
      } elseif($absence->type == 7 ){
         $code = 'FHRD/FA/SK/' . $date->format('m')  . $date->format('y') . '/' . $id ;
      }  elseif($absence->type == 5 ){
         $code =  'FHRD/FA/C/' . $date->format('m')  . $date->format('y') . '/' . $id ;
      } elseif($absence->type == 10 ){
         $code = 'FHRD/FA/IR/' . $date->format('m')  . $date->format('y') . '/' . $id ;
      } else {
         $code = '';
      }


      $absence->update([
         'release_date' => $now,
         'code' => $code
      ]);

      $id = $absence->id;

      if ($absence->absence_id != null) {
         // dd('kosong');
         $absenceHrd = Absence::find($absence->absence_id);
         $absenceHrd->update([
            'code' => $code
         ]);
      }

      

      if($absence->type == 7){
         AbsenceEmployeeDetail::create([
            'absence_employee_id' => $absence->id,
            'date' => $absence->date
         ]);
      }


      if($absence->type == 10){
         // Izin Resmi
         $dates = AbsenceEmployeeDetail::where('absence_employee_id', $absence->id)->get();

         foreach($dates as $d){
            $ddate = Carbon::create($d->date);
            Absence::create([
               'employee_id' => $absence->employee_id,
               'type' => $absence->type,
               'type_izin' => $absence->type_desc,
               'type_spt' => $absence->type_desc,
               'desc' => $absence->desc,
               'month' => $ddate->format('F'),
               'year' => $ddate->format('Y'),
               'date' => $d->date,
               'absence_employee_id' => $absence->id
            ]);
         }
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
         'action' => 'Create',
         'desc' => 'Form Request ' . $type . ' '
      ]);

      // dd($absence->id);



      return redirect()->route('employee.absence.detail', [enkripRambo($id), enkripRambo('draft')])->with('success', 'Pengajuan berhasil dibuat');
   }

   public function edit($id){
      $absenceEmployee = AbsenceEmployee::find(dekripRambo($id));
      $leader = Employee::where('nik', auth()->user()->username)->first();

      $employee = Employee::find($absenceEmployee->employee_id);
      $employees = Employee::where('department_id', $employee->department_id)->get();
      $employeeLeaders = EmployeeLeader::where('employee_id', $employee->id)->get();
      $allManagers = Employee::where('role', 5)->get();
      $managers = Employee::where('department_id', $employee->department_id)->where('role', 5)->get();
      if (count($managers) == 0) {
         foreach($allManagers as $man){
            if (count($man->positions) > 0) {
               foreach($man->positions as $pos){
                  if ($pos->department_id == $employee->department_id) {
                     $managers[] = $man;
                  }
               }
            }
         }
      }

      if ($absenceEmployee->type == 4){
         $type = 'Izin';
         $cuti = null;
      } elseif($absenceEmployee->type == 5){
         $type = 'Cuti';
         $cuti = $absenceEmployee;

      } elseif($absenceEmployee->type == 6){
         $type = 'SPT';
         $cuti = null;
      } elseif($absenceEmployee->type == 7){
         $type = 'Sakit';
         $cuti = null;
      } elseif($absenceEmployee->type == 10){
         $type = 'Izin Resmi';
         $cuti = null;
      }

      // $employeeLeaders = EmployeeLeader::where('employee_id', $leader->id)->get();
      return view('pages.absence-request.edit', [
         'type' => $type,
         'absenceEmp' => $absenceEmployee,
         'employeeLeaders' => $employeeLeaders,
         'cuti' => $cuti,
         'employees' => $employees,
         'managers' => $managers
      ]);
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
         $manager = $req->manager;
      } elseif($absenceEmp->type == 6){
         $desc = $req->desc;
         $leader = $req->leader;
         $manager = null;
      } else {
         $desc = $req->desc;
         $leader = null;
         $manager = null;
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

         // 'cuti_taken' => $req->cuti_taken,
         // 'cuti_qty' => $req->cuti_qty,
         // 'cuti_start' => $req->cuti_start,
         // 'cuti_end' => $req->cuti_end,
         // 'cuti_backup_id' => $req->cuti_backup,

         'manager_id' => $manager,


         'desc' => $desc,
         'remark' => $req->remark,
         'doc' => $doc
      ]);

      // dd($absenceEmp->desc);

      return redirect()->route('employee.absence.detail', [enkripRambo($absenceEmp->id), enkripRambo('draft')])->with('success', 'Request Absensi updated');
   }

   public function updateFile(Request $req){
      $req->validate([

      ]);

      if (request('doc')) {
         $doc = request()->file('doc')->store('doc/absence');
      } else {
         $doc = null;
      }

      $absenceEmp = AbsenceEmployee::find($req->id);
      $absenceEmp->update([
         'doc' => $doc
      ]);
      return redirect()->back()->with('success', 'Dokumen berhasil diupdate');
   }

   public function updatePengganti(Request $req){
      $absenceEmp = AbsenceEmployee::find($req->absence_employee);

      // dd($desc);
      $absenceEmp->update([

         'cuti_backup_id' => $req->cuti_backup,

      ]);

      // dd($absenceEmp->desc);

      return redirect()->back()->with('success', 'Karyawan Pengganti berhasil diupdate');
   }


   public function delete($id){
      $absenceEmployee = AbsenceEmployee::find(dekripRambo($id));
      $absEmpDetails = AbsenceEmployeeDetail::where('absence_employee_id', $absenceEmployee->id)->get();
      foreach($absEmpDetails as $detail){
         $detail->delete();
      }
      $absenceEmployee->delete();

      // {{route()}}
      return redirect()->route('employee.absence.draft')->with('success', 'Data berhasil dihapus');
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

   public function exportSpkl($id){
      $empSpkl = OvertimeEmployee::find(dekripRambo($id));
      $currentSpkl = Overtime::where('overtime_employee_id', $empSpkl->id)->first();
      return view('pages.pdf.spkl', [
         'empSpkl' => $empSpkl,
         'currentSpkl' => $currentSpkl
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
      } elseif($reqForm->type == 6 ){
         $status = 1;
      } elseif($reqForm->type == 4 ){
         $status = 1;
      } elseif($reqForm->type == 10 ){
         $status = 1;
      }  elseif($reqForm->type == 7 ){
         $status = 1;
      } elseif(  $reqForm->type == 7 ){
         // dd('ok');
         $status = 5;
         $ddate = Carbon::make($reqForm->date);

         // if ($reqForm->type == 10) {
         //    $dates = AbsenceEmployeeDetail::where('absence_employee_id', $reqForm->id)->get();
         //       // dd($dates);
         //       foreach($dates as $d){
         //          $ddate = Carbon::create($d->date);
         //          Absence::create([
         //             'employee_id' => $reqForm->employee_id,
         //             'type' => $reqForm->type,
         //             'type_izin' => $reqForm->type_desc,
         //             'type_spt' => $reqForm->type_desc,
         //             'desc' => $reqForm->desc,
         //             'month' => $ddate->format('F'),
         //             'year' => $ddate->format('Y'),
         //             'date' => $d->date,
         //             'absence_employee_id' => $reqForm->id
         //          ]);



         //       }
         // } else {
         //    Absence::create([
         //       'employee_id' => $reqForm->employee_id,
         //       'type' => $reqForm->type,
         //       'type_izin' => $reqForm->type_desc,
         //       'type_spt' => $reqForm->type_desc,
         //       'desc' => $reqForm->desc,
         //       'remark' => $reqForm->remark,
         //       'month' => $ddate->format('F'),
         //       'year' => $ddate->format('Y'),
         //       'date' => $ddate,
         //       // 'revisi' => $revisi
         //    ]);
         // }

         // dd($reqForm->absence_id);


      }
      // dd('ok');
      $now = Carbon::now();

      // $lastAbsence = AbsenceEmployee::orderBy('updated_at', 'desc')->get();

      // if ($lastAbsence != null) {
      //    $id = count($lastAbsence) + 1;
      // } else {
      //    $id = 1;
      // }

      // $date = Carbon::make($reqForm->date);


      // if($reqForm->type == 4 ){
      //    $code = $id . '/FHRD/I/' . $date->format('m') . '/' . $date->format('Y');
      // } elseif($reqForm->type == 6 ){
      //    $code = $id . '/FHRD/S/' . $date->format('m') . '/' . $date->format('Y');
      // } elseif($reqForm->type == 7 ){
      //    $code = $id . '/FHRD/SK/' . $date->format('m') . '/' . $date->format('Y');
      // }  elseif($reqForm->type == 5 ){
      //    $code = $id . '/FHRD/C/' . $date->format('m') . '/' . $date->format('Y');
      // } elseif($reqForm->type == 10 ){
      //    $code = $id . '/FHRD/IR/' . $date->format('m') . '/' . $date->format('Y');
      // } else {
      //    $code = '';
      // }


      $reqForm->update([
         'status' => $status,
         'release_date' => $now,
         // 'code' => $code
      ]);

      // if ($reqForm->absence_id != null) {
      //    // dd('kosong');
      //    $absence = Absence::find($reqForm->absence_id);
      //    $absence->update([
      //       'code' => $code
      //    ]);
      // }

      return redirect()->back()->with('success', 'Pengajuan Absensi berhasil dikirim');
   }

   public function approve($id){
      // dd('manager real');
      $reqForm = AbsenceEmployee::find(dekripRambo($id));
      $employee = Employee::where('nik', auth()->user()->username)->first();

      if ($reqForm->type == 5) {
         $cuti = Cuti::where('employee_id',  $reqForm->employee->id)->first();
         // $cuti->update([
         //    'start' => $employee->contract->start,
         //    'end' => $employee->contract->end,
         // ]);
         $dates = AbsenceEmployeeDetail::where('absence_employee_id', $reqForm->id)->get();
            // dd($dates);
            foreach($dates as $d){
               $cuti = Cuti::where('employee_id',  $reqForm->employee->id)->first();
               // dd($cuti->start);
            }
      }


      if ($reqForm->type == 5) {
         // if (auth()->user()->hasRole('BOD')) {
         //    $status = 5;
         // }

         if ($reqForm->manager_id == $employee->id) {
            $status = 3;
         } elseif(auth()->user()->hasRole('BOD')){
            $status = 3;
         } else {
            $status = 2;
         }

        $form = 'Cuti';
      } elseif($reqForm->type == 6){
         if ($reqForm->manager_id == $employee->id) {
            $status = 3;
         } else {
            $status = 3;
         }
         $form = 'SPT';
      } elseif($reqForm->type == 10){
         if ($reqForm->manager_id == $employee->id) {
            $status = 3;
         } else {
            $status = 2;
         }
         $form = 'IZIN RESMI';
      } elseif($reqForm->type == 4){
         if ($reqForm->manager_id == $employee->id) {
            $status = 3;
         } else {
            $status = 2;
         }
         $form = 'IZIN';
      } elseif($reqForm->type == 7){
         if ($reqForm->manager_id == $employee->id) {
            $status = 3;
         } else {
            $status = 2;
         }
         $form = 'SAKIT';
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
      ]);


      if($reqForm->type == 6){
         // if ($reqForm->manager_id == $employee->id) {
         //    $status = 5;
         // } else {
         //    $status = 5;
         // }
         // $form = 'SPT';

         // $reqForm->update([
            
         //    'app_leader_date' => $now
         // ]);

      } else {
         if ($reqForm->status == 3) {
            $reqForm->update([
              
               'app_manager_date' => $now
            ]);
         }
   
         if ($reqForm->status == 2) {
            $reqForm->update([
               
               'app_leader_date' => $now
            ]);
         }
      }

      

      // dd($reqForm->status);

      // $date = Carbon::create($reqForm->date);
      // if($reqForm->status == 5 || $reqForm->type == 10 || $reqForm->type == 7){
      //    if ($reqForm->absence_id != null) {
      //       $absence = Absence::find($reqForm->absence_id);

      //       if ($absence->type == 1){
      //          $type = 'Alpha';
      //       } elseif($absence->type == 2){
      //          $type = 'Terlambat';
      //       } elseif($absence->type == 3) {
      //          $type = 'ATL';
      //       } elseif($absence->type == 4){
      //          $type = 'Izin';
      //       } elseif($absence->type == 5){
      //          $type = 'Cuti';
      //       } elseif($absence->type == 6){
      //          $type = 'SPT';
      //       } elseif($absence->type == 7){
      //          $type = 'Sakit';
      //       } elseif($absence->type == 8){
      //          $type = 'Dinas Luar';
      //       } elseif($absence->type == 9){
      //          $type = 'Off Contract';
      //       } elseif($absence->type == 9){
      //          $type = 'Izin Resmi';
      //       }

      //       $revisi = $type;
      //       $absence->update([
      //          'type' => $reqForm->type,
      //          'type_izin' => $reqForm->type_desc,
      //          'type_spt' => $reqForm->type_desc,
      //          'desc' => $reqForm->desc,
      //          'revisi' => $revisi
      //       ]);
      //    } else {
      //       // dd($reqForm->type);
      //       if ($reqForm->type == 5 || $reqForm->type == 10 || $reqForm->type == 7) {
      //          $cutiCon = new CutiController;
      //          $dates = AbsenceEmployeeDetail::where('absence_employee_id', $reqForm->id)->get();
      //          // dd($dates);
      //          foreach($dates as $d){
      //             $ddate = Carbon::create($d->date);
      //             Absence::create([
      //                'employee_id' => $reqForm->employee_id,
      //                'type' => $reqForm->type,
      //                'type_izin' => $reqForm->type_desc,
      //                'type_spt' => $reqForm->type_desc,
      //                'desc' => $reqForm->desc,
      //                'month' => $ddate->format('F'),
      //                'year' => $ddate->format('Y'),
      //                'date' => $d->date,
      //                'absence_employee_id' => $reqForm->id
      //             ]);

      //             $cuti = Cuti::where('employee_id',  $reqForm->employee->id)->where('start', '>=', $d->date)->where('end', '<=', $d->date)->first();
      //             if ($cuti) {
      //                $cutiCon->calculateCuti($cuti->id);
      //                if ($d->date >= $cuti->start && $d->date <= $cuti->expired) {
      //                   $cuti->update([
      //                      'extend' => $cuti->extend - 1
      //                   ]);
      //                }
      //             }

      //          }

      //       } else {
      //          Absence::create([
      //             'employee_id' => $reqForm->employee_id,
      //             'type' => $reqForm->type,
      //             'type_izin' => $reqForm->type_desc,
      //             'type_spt' => $reqForm->type_desc,
      //             'desc' => $reqForm->desc,
      //             'month' => $date->format('F'),
      //             'year' => $date->format('Y'),
      //             'date' => $reqForm->date,
      //             // 'revisi' => $revisi
      //          ]);
      //       }

      //    }
      // }


      // if($reqForm->status == 5){
      //    if ($reqForm->type == 5){
      //       $cutiCon = new CutiController();
      //       $cuti = Cuti::where('employee_id',  $reqForm->employee_id)->first();
      //       $cutiCon->calculateCuti($cuti->id);

      //       // dd($cuti->sisa);
      //    }
      // }



      return redirect()->back()->with('success', 'Formulir ' . $form . ' ' . 'berhasil di setujui');

   }

   public function approveManager($id){

      // dd('ok');
      $reqForm = AbsenceEmployee::find(dekripRambo($id));
      $employee = Employee::where('nik', auth()->user()->username)->first();
      // dd('manager');
      if ($reqForm->type == 5) {
         $cuti = Cuti::where('employee_id',  $reqForm->employee->id)->first();
         // $cuti->update([
         //    'start' => $employee->contract->start,
         //    'end' => $employee->contract->end,
         // ]);
         $dates = AbsenceEmployeeDetail::where('absence_employee_id', $reqForm->id)->get();
            // dd($dates);
            foreach($dates as $d){
               $cuti = Cuti::where('employee_id',  $reqForm->employee->id)->first();
               // dd($cuti->start);
            }
      }


      // if ($reqForm->type == 5) {
         if ($reqForm->manager_id == $employee->id) {
            $status = 3;
         } elseif (auth()->user()->hasRole('Asst. Manager')) {
            $status = 3;
         } else {
            $status = 2;
         }

         $form = 'Absensi';
      // }


      $now = Carbon::now();
      if ($reqForm->app_backup_date != null) {
         $backupDate = $reqForm->app_backup_date;
      } else {
         $backupDate = $now;
      }
      $reqForm->update([
         'status' => $status,
         // 'app_backup_date' => $backupDate,
         'app_manager_date' => $now,
         'app_asmen_date' => $now,
         'asmen_id' => $employee->id
      ]);

      // dd($reqForm->status);

      // $date = Carbon::create($reqForm->date);
      // if($reqForm->status == 5){
      //    if ($reqForm->absence_id != null) {
      //       $absence = Absence::find($reqForm->absence_id);

      //       if ($absence->type == 1){
      //          $type = 'Alpha';
      //       } elseif($absence->type == 2){
      //          $type = 'Terlambat';
      //       } elseif($absence->type == 3) {
      //          $type = 'ATL';
      //       } elseif($absence->type == 4){
      //          $type = 'Izin';
      //       } elseif($absence->type == 5){
      //          $type = 'Cuti';
      //       } elseif($absence->type == 6){
      //          $type = 'SPT';
      //       } elseif($absence->type == 7){
      //          $type = 'Sakit';
      //       } elseif($absence->type == 8){
      //          $type = 'Dinas Luar';
      //       } elseif($absence->type == 9){
      //          $type = 'Off Contract';
      //       } elseif($absence->type == 9){
      //          $type = 'Izin Resmi';
      //       }

      //       $revisi = $type;
      //       $absence->update([
      //          'type' => $reqForm->type,
      //          'type_izin' => $reqForm->type_desc,
      //          'type_spt' => $reqForm->type_desc,
      //          'desc' => $reqForm->desc,
      //          'revisi' => $revisi
      //       ]);
      //    } else {
      //       // dd($reqForm->type);
      //       if ($reqForm->type == 5 || $reqForm->type == 10) {
      //          $cutiCon = new CutiController;
      //          $dates = AbsenceEmployeeDetail::where('absence_employee_id', $reqForm->id)->get();
      //          // dd($dates);
      //          foreach($dates as $d){
      //             $ddate = Carbon::create($d->date);
      //             Absence::create([
      //                'employee_id' => $reqForm->employee_id,
      //                'type' => $reqForm->type,
      //                'type_izin' => $reqForm->type_desc,
      //                'type_spt' => $reqForm->type_desc,
      //                'desc' => $reqForm->desc,
      //                'month' => $ddate->format('F'),
      //                'year' => $ddate->format('Y'),
      //                'date' => $d->date,
      //                'absence_employee_id' => $reqForm->id
      //             ]);

      //             $cuti = Cuti::where('employee_id',  $reqForm->employee->id)->where('start', '>=', $d->date)->where('end', '<=', $d->date)->first();
      //             if ($cuti) {
      //                $cutiCon->calculateCuti($cuti->id);
      //                if ($d->date >= $cuti->start && $d->date <= $cuti->expired) {
      //                   $cuti->update([
      //                      'extend' => $cuti->extend - 1
      //                   ]);
      //                }
      //             }

      //          }

      //       } else {
      //          Absence::create([
      //             'employee_id' => $reqForm->employee_id,
      //             'type' => $reqForm->type,
      //             'type_izin' => $reqForm->type_desc,
      //             'type_spt' => $reqForm->type_desc,
      //             'desc' => $reqForm->desc,
      //             'month' => $date->format('F'),
      //             'year' => $date->format('Y'),
      //             'date' => $reqForm->date,
      //             // 'revisi' => $revisi
      //          ]);
      //       }

      //    }
      // }



      if($reqForm->type == 5){
         $cutiCon = new CutiController();
         $cuti = Cuti::where('employee_id',  $reqForm->employee_id)->first();
         // $cutiCon->calculateCuti($cuti->id);

         //   dd($cuti->sisa);
      }


      return redirect()->back()->with('success', 'Formulir ' . $form . ' ' . 'berhasil di setujui');

   }

   public function approveOld($id){
      // dd('manager real');
      $reqForm = AbsenceEmployee::find(dekripRambo($id));
      $employee = Employee::where('nik', auth()->user()->username)->first();

      if ($reqForm->type == 5) {
         $cuti = Cuti::where('employee_id',  $reqForm->employee->id)->first();
         // $cuti->update([
         //    'start' => $employee->contract->start,
         //    'end' => $employee->contract->end,
         // ]);
         $dates = AbsenceEmployeeDetail::where('absence_employee_id', $reqForm->id)->get();
            // dd($dates);
            foreach($dates as $d){
               $cuti = Cuti::where('employee_id',  $reqForm->employee->id)->first();
               // dd($cuti->start);
            }
      }


      if ($reqForm->type == 5) {
         // if (auth()->user()->hasRole('BOD')) {
         //    $status = 5;
         // }

         if ($reqForm->manager_id == $employee->id) {
            $status = 5;
         } elseif(auth()->user()->hasRole('BOD')){
            $status = 5;
         } else {
            $status = 2;
         }

        $form = 'Cuti';
      } elseif($reqForm->type == 6){
         if ($reqForm->manager_id == $employee->id) {
            $status = 5;
         } else {
            $status = 5;
         }
         $form = 'SPT';
      } elseif($reqForm->type == 10){
         if ($reqForm->manager_id == $employee->id) {
            $status = 5;
         } else {
            $status = 2;
         }
         $form = 'IZIN RESMI';
      } elseif($reqForm->type == 4){
         if ($reqForm->manager_id == $employee->id) {
            $status = 5;
         } else {
            $status = 2;
         }
         $form = 'IZIN';
      } elseif($reqForm->type == 7){
         if ($reqForm->manager_id == $employee->id) {
            $status = 5;
         } else {
            $status = 2;
         }
         $form = 'SAKIT';
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
      ]);


      if($reqForm->type == 6){
         // if ($reqForm->manager_id == $employee->id) {
         //    $status = 5;
         // } else {
         //    $status = 5;
         // }
         // $form = 'SPT';

         $reqForm->update([
            
            'app_leader_date' => $now
         ]);

      } else {
         if ($reqForm->status == 5) {
            $reqForm->update([
              
               'app_manager_date' => $now
            ]);
         }
   
         if ($reqForm->status == 2) {
            $reqForm->update([
               
               'app_leader_date' => $now
            ]);
         }
      }

      

      // dd($reqForm->status);

      $date = Carbon::create($reqForm->date);
      if($reqForm->status == 5 || $reqForm->type == 10 || $reqForm->type == 7){
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
            } elseif($absence->type == 9){
               $type = 'Izin Resmi';
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
            // dd($reqForm->type);
            if ($reqForm->type == 5 || $reqForm->type == 10 || $reqForm->type == 7) {
               $cutiCon = new CutiController;
               $dates = AbsenceEmployeeDetail::where('absence_employee_id', $reqForm->id)->get();
               // dd($dates);
               foreach($dates as $d){
                  $ddate = Carbon::create($d->date);
                  Absence::create([
                     'employee_id' => $reqForm->employee_id,
                     'type' => $reqForm->type,
                     'type_izin' => $reqForm->type_desc,
                     'type_spt' => $reqForm->type_desc,
                     'desc' => $reqForm->desc,
                     'month' => $ddate->format('F'),
                     'year' => $ddate->format('Y'),
                     'date' => $d->date,
                     'absence_employee_id' => $reqForm->id
                  ]);

                  $cuti = Cuti::where('employee_id',  $reqForm->employee->id)->where('start', '>=', $d->date)->where('end', '<=', $d->date)->first();
                  if ($cuti) {
                     $cutiCon->calculateCuti($cuti->id);
                     if ($d->date >= $cuti->start && $d->date <= $cuti->expired) {
                        $cuti->update([
                           'extend' => $cuti->extend - 1
                        ]);
                     }
                  }

               }

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

         }
      }


      if($reqForm->status == 5){
         if ($reqForm->type == 5){
            $cutiCon = new CutiController();
            $cuti = Cuti::where('employee_id',  $reqForm->employee_id)->first();
            $cutiCon->calculateCuti($cuti->id);

            // dd($cuti->sisa);
         }
      }



      return redirect()->back()->with('success', 'Formulir ' . $form . ' ' . 'berhasil di setujui');

   }

   public function approveManagerOld($id){

      // dd('ok');
      $reqForm = AbsenceEmployee::find(dekripRambo($id));
      $employee = Employee::where('nik', auth()->user()->username)->first();
      // dd('manager');
      if ($reqForm->type == 5) {
         $cuti = Cuti::where('employee_id',  $reqForm->employee->id)->first();
         // $cuti->update([
         //    'start' => $employee->contract->start,
         //    'end' => $employee->contract->end,
         // ]);
         $dates = AbsenceEmployeeDetail::where('absence_employee_id', $reqForm->id)->get();
            // dd($dates);
            foreach($dates as $d){
               $cuti = Cuti::where('employee_id',  $reqForm->employee->id)->first();
               // dd($cuti->start);
            }
      }


      // if ($reqForm->type == 5) {
         if ($reqForm->manager_id == $employee->id) {
            $status = 5;
         } elseif (auth()->user()->hasRole('Asst. Manager')) {
            $status = 5;
         } else {
            $status = 2;
         }

         $form = 'Absensi';
      // }


      $now = Carbon::now();
      if ($reqForm->app_backup_date != null) {
         $backupDate = $reqForm->app_backup_date;
      } else {
         $backupDate = $now;
      }
      $reqForm->update([
         'status' => $status,
         // 'app_backup_date' => $backupDate,
         'app_manager_date' => $now,
         'app_asmen_date' => $now,
         'asmen_id' => $employee->id
      ]);

      // dd($reqForm->status);

      $date = Carbon::create($reqForm->date);
      if($reqForm->status == 5){
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
            } elseif($absence->type == 9){
               $type = 'Izin Resmi';
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
            // dd($reqForm->type);
            if ($reqForm->type == 5 || $reqForm->type == 10) {
               $cutiCon = new CutiController;
               $dates = AbsenceEmployeeDetail::where('absence_employee_id', $reqForm->id)->get();
               // dd($dates);
               foreach($dates as $d){
                  $ddate = Carbon::create($d->date);
                  Absence::create([
                     'employee_id' => $reqForm->employee_id,
                     'type' => $reqForm->type,
                     'type_izin' => $reqForm->type_desc,
                     'type_spt' => $reqForm->type_desc,
                     'desc' => $reqForm->desc,
                     'month' => $ddate->format('F'),
                     'year' => $ddate->format('Y'),
                     'date' => $d->date,
                     'absence_employee_id' => $reqForm->id
                  ]);

                  $cuti = Cuti::where('employee_id',  $reqForm->employee->id)->where('start', '>=', $d->date)->where('end', '<=', $d->date)->first();
                  if ($cuti) {
                     $cutiCon->calculateCuti($cuti->id);
                     if ($d->date >= $cuti->start && $d->date <= $cuti->expired) {
                        $cuti->update([
                           'extend' => $cuti->extend - 1
                        ]);
                     }
                  }

               }

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

         }
      }



      if($reqForm->type == 5){
         $cutiCon = new CutiController();
         $cuti = Cuti::where('employee_id',  $reqForm->employee_id)->first();
         $cutiCon->calculateCuti($cuti->id);

      //   dd($cuti->sisa);
      }


      return redirect()->back()->with('success', 'Formulir ' . $form . ' ' . 'berhasil di setujui');

   }

   public function reject(Request $req){

      $absEmp = AbsenceEmployee::find($req->absEmp);
      $employee = Employee::where('nik', auth()->user()->username)->first();

      if ($absEmp->status == 1) {
         $status = 101;
      } elseif($absEmp->status == 2){
         $status = 202;
      }

      $absEmp->update([
         'status' => $status,
         'reject_by' => $employee->id,
         'reject_date' => Carbon::now(),
         'reject_desc' => $req->remark
      ]);


      return redirect()->back()->with('success', 'Form Absensi berhasil di Reject');

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
      }  elseif($reqForm->type == 7){
         $form = 'Sakit';
      } elseif($reqForm->type == 8){
         $form = 'Dinas Luar';
      } elseif($reqForm->type == 9){
         $form = 'Off Contract';
      } elseif($reqForm->type == 10){
         $form = 'Izin Resmi';
      } else {
         $form = 'Absensi';
      }

      $reqForm->update([
         'status' => 5,
         'app_hrd_date' => Carbon::now()
      ]);

      if ($reqForm->type == 5) {
         $cuti = Cuti::where('employee_id',  $reqForm->employee->id)->first();
         // $cuti->update([
         //    'start' => $employee->contract->start,
         //    'end' => $employee->contract->end,
         // ]);
         $dates = AbsenceEmployeeDetail::where('absence_employee_id', $reqForm->id)->get();
            // dd($dates);
            foreach($dates as $d){
               $cuti = Cuti::where('employee_id',  $reqForm->employee->id)->first();
               // dd($cuti->start);
            }
      }


      $date = Carbon::create($reqForm->date);
      if($reqForm->status == 5 || $reqForm->type == 10 || $reqForm->type == 7){
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
            } elseif($absence->type == 9){
               $type = 'Izin Resmi';
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
            // dd($reqForm->type);
            if ($reqForm->type == 5 || $reqForm->type == 10 || $reqForm->type == 7) {
               $cutiCon = new CutiController;
               $dates = AbsenceEmployeeDetail::where('absence_employee_id', $reqForm->id)->get();
               // dd($dates);
               foreach($dates as $d){
                  $ddate = Carbon::create($d->date);
                  Absence::create([
                     'employee_id' => $reqForm->employee_id,
                     'type' => $reqForm->type,
                     'type_izin' => $reqForm->type_desc,
                     'type_spt' => $reqForm->type_desc,
                     'desc' => $reqForm->desc,
                     'month' => $ddate->format('F'),
                     'year' => $ddate->format('Y'),
                     'date' => $d->date,
                     'absence_employee_id' => $reqForm->id
                  ]);

                  $cuti = Cuti::where('employee_id',  $reqForm->employee->id)->where('start', '>=', $d->date)->where('end', '<=', $d->date)->first();
                  if ($cuti) {
                     $cutiCon->calculateCuti($cuti->id);
                     if ($d->date >= $cuti->start && $d->date <= $cuti->expired) {
                        $cuti->update([
                           'extend' => $cuti->extend - 1
                        ]);
                     }
                  }

               }

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

         }
      }

      if($reqForm->status == 5){
         if ($reqForm->type == 5){
            $cutiCon = new CutiController();
            $cuti = Cuti::where('employee_id',  $reqForm->employee_id)->first();
            $cutiCon->calculateCuti($cuti->id);

            // dd($cuti->sisa);
         }
      }

      // if ($reqForm->absence_id != null) {
      //    $absence = Absence::find($reqForm->absence_id);

      //    if ($absence->type == 1){
      //       $type = 'Alpha';
      //    } elseif($absence->type == 2){
      //       $type = 'Terlambat';
      //    } elseif($absence->type == 3) {
      //       $type = 'ATL';
      //    } elseif($absence->type == 4){
      //       $type = 'Izin';
      //    } elseif($absence->type == 5){
      //       $type = 'Cuti';
      //    } elseif($absence->type == 6){
      //       $type = 'SPT';
      //    } elseif($absence->type == 7){
      //       $type = 'Sakit';
      //    } elseif($absence->type == 8){
      //       $type = 'Dinas Luar';
      //    } elseif($absence->type == 9){
      //       $type = 'Off Contract';
      //    }

      //    $revisi = $type;
      //    $absence->update([
      //       'type' => $reqForm->type,
      //       'type_izin' => $reqForm->type_desc,
      //       'type_spt' => $reqForm->type_desc,
      //       'desc' => $reqForm->desc,
      //       'revisi' => $revisi
      //    ]);
      // } else {
      //    Absence::create([
      //       'type' => $reqForm->type,
      //       'type_izin' => $reqForm->type_desc,
      //       'type_spt' => $reqForm->type_desc,
      //       'desc' => $reqForm->desc,
      //       // 'revisi' => $revisi
      //    ]);
      // }


      return redirect()->back()->with('success', 'Formulir ' . $form . ' ' . 'berhasil di setujui');

   }

   public function approveHrdOld($id){
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
