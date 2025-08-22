<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Log;
use App\Models\ReductionEmployee;
use Illuminate\Http\Request;

class ReductionEmployeeController extends Controller
{
   public function update(Request $req)
   {
      $reductionEmployee = ReductionEmployee::find($req->redEmp);
      // dd($req->status);
      $reductionEmployee->update([
         'employee_value' => preg_replace('/[Rp. ]/', '', $req->value) ,
         'status' => $req->status
      ]);

      if ($req->status == 1) {
         $stat = 'Enable';
      } else {
         $stat = 'Disable';
      }

      // dd($reductionEmployee->status);
      if (auth()->user()->hasRole('Administrator')) {
         $departmentId = null;
      } else {
         $user = Employee::find(auth()->user()->getEmployeeId());
         $departmentId = $user->department_id;
      }
      Log::create([
         'department_id' => $departmentId,
         'user_id' => auth()->user()->id,
         'action' => $stat,
         'desc' => 'Deduction ' . $reductionEmployee->employee->nik . ' ' . $reductionEmployee->employee->biodata->fullName()
      ]);

      return redirect()->back()->with('status', 'Potongan Karyawan berhasil diubah');
   }

   public function delete(Request $req)
   {
      // dd('ok');
      $req->validate([]);

      $redEmp = ReductionEmployee::find($req->redempId);

      $redEmp->delete();
      return redirect()->back()->with('status', 'Potongan Karyawan berhasil dihapus');
   }
}
