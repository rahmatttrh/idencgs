<?php

namespace App\Http\Controllers;

use App\Models\Aggreement;
use App\Models\Contract;
use App\Models\Employee;
use App\Models\Log;
use App\Models\Location;
use App\Models\Mutation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MutationController extends Controller
{
   public function store(Request $req)
   {
      $employee = Employee::find($req->employee);
      $contract = Contract::find($req->contract);

      if (request('sk')) {
         
         $sk = request()->file('sk')->store('doc/employee/mutation');
      }  else {
         $sk = null;
      }

      $oldAggreement = Aggreement::create([
         'shift_id' => $contract->shift_id,
         'unit_id' => $contract->unit_id,
         'department_id' => $contract->department_id,
         'sub_dept_id' => $contract->sub_dept_id,
         'designation_id' => $contract->designation_id,
         'position_id' => $contract->position_id,
         'salary' => $contract->salary,
         'hourly_rate' => $contract->hourly_rate,
         'payslip' => $contract->payslip,
         'desc' => $contract->desc,
         'cuti' => $contract->cuti,
         'loc' => $contract->loc,
         'manager_id' => $employee->manager_id,
         'direct_leader_id' => $employee->direct_leader_id,
      ]);

      $newAggreement = Aggreement::create([
         'unit_id' => $req->unit_mutation,
         'department_id' => $req->department_mutation,
         'sub_dept_id' => $req->subdept_mutation,
         'designation_id' => $req->designation,
         'position_id' => $req->position_mutation,
         'salary' => $req->salary,
         'hourly_rate' => $req->hourly_rate,
         'payslip' => $req->payslip,
         'shift_id' => $req->shift,
         'desc' => $req->desc,
         'cuti' => $req->cuti,
         'loc' => $req->loc,
         'manager_id' => $req->manager_mutation,
         'direct_leader_id' => $req->leader_mutation,
      ]);

      Mutation::create([
         'type' => $req->type,
         'date' => $req->date,
         'employee_id' => $employee->id,
         'before_id' => $oldAggreement->id,
         'become_id' => $newAggreement->id,
         'desc' => $req->reason,
         'doc' => $sk ,
         
      ]);

      $contract->update([
         'shift_id' => $req->shift,
         'unit_id' => $req->unit_mutation,
         'department_id' => $req->department_mutation,
         'sub_dept_id' => $req->subdept_mutation,
         'designation_id' => $req->designation,
         'position_id' => $req->position_mutation,
         'salary' => $req->salary,
         'hourly_rate' => $req->hourly_rate,
         'payslip' => $req->payslip,
         
         'desc' => $req->desc,
         'cuti' => $req->cuti,
         
         'loc' => $req->loc
      ]);
      $locations = Location::get();

      foreach ($locations as $loc) {
         if ($loc->code == $employee->contract->loc) {
            $location = $loc->id;
         } else {
            $location = null;
         }
      }

      $employee->update([
         'unit_id' => $req->unit_mutation,
         'contract_id' => $contract->id,
         'department_id' => $req->department_mutation,
         'designation_id' => $req->designation,
         'position_id' => $req->position_mutation,
         'manager_id' => $req->manager_mutation,
         'direct_leader_id' => $req->leader_mutation,
         'location_id' => $location
      ]);

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

      if (auth()->user()->hasRole('Administrator')) {
         $deptId = 0;
      } else {
         $user = Employee::find(auth()->user()->getEmployeeId());
         $deptId = $user->department->id;
      }
      
      Log::create([
         'department_id' => $deptId,
         'user_id' => auth()->user()->id,
         'action' => 'Add',
         'desc' => 'Mutation ' . $employee->nik . ' ' . $employee->biodata->fullname()
      ]);

      return redirect()->route('employee.detail', [enkripRambo($req->employee), enkripRambo('contract')])->with('success', 'Mutation successfully added');
   }

   public function update(Request $req){
      $mutation = Mutation::find($req->mutation);

      if (request('sk')) {
         Storage::delete($mutation->doc);
         $sk = request()->file('sk')->store('doc/employee/mutation');
      } elseif ($mutation->doc) {
         $sk = $mutation->doc;
      } else {
         $sk = null;
      }

      $mutation->update([
         'type' => $req->type,
         'date' => $req->date,
         'doc' => $sk,
         'desc' => $req->reason
      ]);

      return redirect()->route('employee.detail', [enkripRambo($mutation->employee_id), enkripRambo('contract')])->with('success', 'Mutation successfully updated');
   }
}
