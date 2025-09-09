<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Cuti;
use App\Models\Employee;
use App\Models\EmployeeLeader;
use App\Models\Log;
use App\Models\Position;
use App\Models\User;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{

   public function store(Request $req)
   {
      $req->validate([
         'nik' => 'required'
      ]);
      // dd('ok');
      $employee = Employee::find($req->employee);
      $currentContract = Contract::find($employee->contract_id);
      $currentContract->update([
         'status' => 0
      ]);

      if (request('doc')) {
         
         $doc = request()->file('doc')->store('doc/employee/contract');
      }  else {
         $doc = null;
      }

      $position = Position::find($req->position_add);
      $contract = Contract::create([
         'status' => 1,
         'employee_id' => $req->employee,
         'id_no' => $req->nik,
         'type' => $req->type_add,
         'shift_id' => $req->shift,
         'designation_id' => $position->designation_id,
         'unit_id' => $req->unit_add,
         'department_id' => $req->department_add,
         'sub_dept_id' => $req->subdept_add,
         'position_id' => $req->position_add,
         'salary' => $req->salary,
         'hourly_rate' => $req->hourly_rate,
         'payslip' => $req->payslip,
         'start' => $req->start,
         'end' => $req->end,
         'determination' => $req->determination,
         'desc' => $req->desc,
         'cuti' => $req->cuti,
         'loc' => $req->loc,
         'project_id' => $req->project,
         'note' => $req->note,
         'doc' => $doc
      ]);



      $employee->update([
         // 'unit_id' => $contract->unit_id,
         'nik' => $req->nik,
         'contract_id' => $contract->id,
         'unit_id' => $contract->unit_id,
         'department_id' => $contract->department_id,
         'sub_dept_id' => $contract->sub_dept_id,
         'designation_id' => $contract->designation_id,
         'position_id' => $contract->position_id,
         'project_id' => $req->project,
         // 'manager_id' => $contract->manager_id,
         // 'direct_leader_id' => $contract->direct_leader_id,
      ]);

      // $cutiEmp = Cuti::where('employee_id', $employee->id)->first();
      // $cutiEmp->update([
      //    'start' => $req->start,
      //    'end' => $req->end,

      //    'tahunan' => 12,
      //    // 'masa_kerja' => $req->masa_kerja,
      //    // 'extend' => $req->extend,
      //    // 'expired' => $req->expired,
      //    // 'total' => $total,
      //    // 'used' => $req->used,
      //    // 'sisa' => $total - $req->used
      // ]);

      $today = Carbon::now();
      if ($employee->contract->type == 'Tetap' ) {
         $cuti = Cuti::where('employee_id', $employee->id)->first();
         $penetapan = Carbon::create($employee->contract->determination);
         // // dd($join);
         // dd($penetapan);
         $start = Carbon::create($today->format('Y') . '-' . $penetapan->format('m-d')  );
         $startB = Carbon::create($today->format('Y') . '-' . $penetapan->format('m-d')  );
         // dd($start);

         if ($start > $today) {
            // dd($start->subYear());
            $fixStart = $start->subYear();
            $finalStart = $fixStart;
            $finalEnd = $startB;
            
            // dd($start->addYear());
            // $finalEnd = $start
         } else {
            //  dd($cuti->employee->biodata->fullName());
            $finalStart = $startB;
            $finalEnd = $start->addYear();
         }

         $cuti->update([
            'start' => $finalStart,
            'end' => $finalEnd,
            'extend' => 0,
            'extend_left' => 0,
            'expired' => null 
         ]);
      }

      $cutiController = new CutiController();
      $cutiController->calculateCuti($cuti->id);

      

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
         'desc' => 'Contract ' . $employee->nik . ' ' . $employee->biodata->fullname()
      ]);

      return redirect()->route('employee.detail', [enkripRambo($req->employee), enkripRambo('contract')])->with('success', 'Contract successfully added');
   }
   public function update(Request $req)
   {
      // dd('ok');
      // $req->validate([
      //    'nik' => 'required|unique:employees'
      // ]);

      // dd($req->subdept);

      $position = Position::find($req->position);
      // try {
      //    DB::transaction(function () use ($req) {
      $contract = Contract::find($req->contract);
      $employee = Employee::where('nik', $contract->id_no)->first();
      $user = User::where('username', $employee->nik)->first();
      $user = User::where('username', $employee->nik)->first();
      // dd($req->position);

      // dd($req->designation);


      if (request('doc')) {
         
         $doc = request()->file('doc')->store('doc/employee/contract');
      }  else {
         $doc = null;
      }



      $contract->update([
         'status' => 1,
         'id_no' => $req->nik,
         'employee_id' => $employee->id,
         'type' => $req->type,
         'date' => $req->date,
         'shift_id' => $req->shift,
         'designation_id' => $position->designation_id,
         'unit_id' => $req->unit,
         'department_id' => $req->department,
         'sub_dept_id' => $req->subdept,
         'position_id' => $position->id,
         'salary' => $req->salary,
         'hourly_rate' => $req->hourly_rate,
         'payslip' => $req->payslip,


         'start' => $req->start,
         'end' => $req->end,
         'determination' => $req->determination,
         'desc' => $req->desc,
         'cuti' => $req->cuti,
         'loc' => $req->loc,
         'project_id' => $req->project,
         'note' => $req->note,
         'doc' => $doc
      ]);

      $locations = Location::get();
      foreach ($locations as $loc) {
         if ($loc->code == $req->loc) {
            $location = $loc->id;
         } else {
            $location = null;
         }
      }

      $locId = Location::where('code', $req->loc)->first();
      
      $employee->update([
         // 'unit_id' => $req->unit,
         'nik' => $req->nik,
         'manager_id' => $req->manager,
         'direct_leader_id' => $req->leader,
         'designation_id' => $position->designation_id,

         'unit_id' => $contract->unit_id,
         'department_id' => $contract->department_id,
         'sub_dept_id' => $contract->sub_dept_id,
         'position_id' => $position->id,
         'location_id' => $locId->id,
         'project_id' => $req->project,



      ]);

      // dd($req->loc);

      $user->update([
         'username' => $req->nik
      ]);

      $user->update([
         'username' => $req->nik
      ]);
      // });

      // $user = User::where('username', $employee->nik)->first();
      // $user = User::where('username', $employee->nik)->first();
      $user = User::where('username', $employee->nik)->first();
      $user->roles()->detach();
      if ($employee->contract->designation_id == 1) {
         $user->assignRole('Karyawan');
      } elseif ($employee->contract->designation_id == 2) {
         $user->assignRole('Karyawan');
      } elseif ($employee->contract->designation_id == 3 ) {
         $user->assignRole('Leader');
      } elseif ( $employee->contract->designation_id == 4) {
         $user->assignRole('Supervisor');
      } elseif ($employee->contract->designation_id == 5 ) {
         $user->assignRole('Asst. Manager');
      } elseif ( $employee->contract->designation_id == 6) {
         $user->assignRole('Manager');
      } else {
         $user->assignRole('Karyawan');
      }
      
      // $user->roles()->detach();
      // if ($req->designation == 3) {
      //    $user->assignRole('Leader');
      // } elseif ($req->designation == 4) {
      //    $user->assignRole('Supervisor');
      // } elseif ($req->designation == 6) {
      //    $user->assignRole('Manager');
      // } else {
      //    $user->assignRole('Karyawan');
      // }

      if (auth()->user()->hasRole('Administrator')) {
         $departmentId = null;
      } else {
         $user = Employee::find(auth()->user()->getEmployeeId());
         $departmentId = $user->department_id;
      }
      Log::create([
         'department_id' => $departmentId,
         'user_id' => auth()->user()->id,
         'action' => 'Update',
         'desc' => 'Contract ' . $employee->nik . ' ' . $employee->biodata->fullname()
      ]);

      return redirect()->route('employee.detail', [enkripRambo($req->employee), enkripRambo('contract')])->with('success', 'Contract successfully updated');
      // } catch (\Exception $e) {
      //    // Jika ada kesalahan, transaksi akan di-rollback
      //    return redirect()->back()->with('error', 'Failed to update contract. Please try again.');
      // }
   }

   public function delete($id){
      $contract = Contract::find(dekripRambo($id));

      $contract->delete();

      return redirect()->back()->with('success', 'History Contract successfully deleted');
   }


   public function alert(){
      $now = Carbon::now();
      // dd($now);
      $contractEnds = Contract::where('status', 1)->where('employee_id', '!=', null)->whereDate('end', '>', $now)->get();
      
      $nowAddTwo = $now->addMonth(2);
      $notifContracts = $contractEnds->where('end', '<', $nowAddTwo);
      return view('pages.contract.alert', [
         'contractAlerts' => $notifContracts
      ]);

   }

   public function alertLeader(){
      $now = Carbon::now();
      $employee = Employee::where('nik', auth()->user()->username)->first();
      // dd($now);
      $myteams = EmployeeLeader::join('employees', 'employee_leaders.employee_id', '=', 'employees.id')
            ->join('biodatas', 'employees.biodata_id', '=', 'biodatas.id')
            ->where('leader_id', $employee->id)
            ->select('employees.*')
            ->orderBy('biodatas.first_name', 'asc')
            ->get();

      $teamId = [];
      foreach($myteams as $t){
         $teamId[] = $t->id;
      }

      if (count($employee->positions) > 0) {
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
      }

      $contractEnds = Contract::where('status', 1)->whereIn('employee_id', $teamId)->whereDate('end', '>', $now)->get();
      
      $nowAddTwo = $now->addMonth(2);
      $notifContracts = $contractEnds->where('end', '<', $nowAddTwo);
      return view('pages.contract.alert', [
         'contractAlerts' => $notifContracts
      ]);

   }
}
