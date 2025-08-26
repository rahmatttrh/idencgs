<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\OvertimeParent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OvertimeParentController extends Controller
{
   public function approveLeader($id){
      $spklGroup = OvertimeParent::find(dekripRambo($id));
      $userLogin = Employee::where('nik', auth()->user()->username)->first();

      $spklGroup->update([
         'status' => 2,
         'approve_leader_date' => Carbon::now()
      ]);

      foreach($spklGroup->overtimes as $spkl){
         $spkl->update([
            'status' => 2,
            'approve_leader_date' => Carbon::now()
         ]);
      }

      return redirect()->back()->with('success', 'SPKL Group berhasil disetujui');
   }

   public function approveManager($id){
      $spklGroup = OvertimeParent::find(dekripRambo($id));
      $userLogin = Employee::where('nik', auth()->user()->username)->first();

      

            if (auth()->user()->hasRole('Manager')) {
               $spklGroup->update([
                  'status' => 3,
                  'manager_id' => $userLogin->id,
                  'approve_manager_date' => Carbon::now()
               ]);

               foreach($spklGroup->overtimes as $spkl){
                  $spkl->update([
                     'status' => 3,
                     'manager_id' => $userLogin->id,
                     'approve_manager_date' => Carbon::now()
                  ]);
               }
            } elseif(auth()->user()->hasRole('Asst. Manager')){
               $spklGroup->update([
                  'status' => 3,
                  'asmen_id' => $userLogin->id,
                  'approve_asmen_date' => Carbon::now()
               ]);

               foreach($spklGroup->overtimes as $spkl){
                  $spkl->update([
                     'status' => 3,
                     'asmen_id' => $userLogin->id,
                     'approve_asmen_date' => Carbon::now()
                  ]);
               }
            }
      

      

      return redirect()->back()->with('success', 'SPKL Group berhasil disetujui');
   }
}
