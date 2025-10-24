<?php

namespace App\Providers;

use App\Models\AbsenceEmployee;
use App\Models\Announcement;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Pe;
use App\Models\Sp;
use App\Models\St;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      view()->composer(
         'layouts.header',
         function ($view) {

            if (auth()->user()->hasRole('Administrator')){
               $backupDetails = [];
            } else { 
               
               $id = auth()->user()->getEmployeeId();
               $employee = Employee::find($id);
               $reqBackForms = AbsenceEmployee::where('cuti_backup_id', $employee->id)->get();
               $now = Carbon::now();
               $backupDetails = [];
               

               foreach($reqBackForms as $backup){
                  foreach($backup->details as $detail){
                     if ($detail->date >= $now) {
                        $backupDetails[] = $detail;
                     }
                  }
               }
            }

           
            
            

            if (auth()->user()->hasRole('HRD|HRD-Spv')) {
               $spNotifs = Sp::where('status', 1)->orderBy('updated_at', 'desc')->get();
               $peNotifs = [];
               $employee = null;
               $stNotifs = [];
            } elseif(auth()->user()->hasRole('Manager|Asst. Manager')){
               $id = auth()->user()->getEmployeeId();
               $employee = Employee::find($id);
               $spNotifs = Sp::where('status', 3)->where('department_id', $employee->department_id)->orderBy('updated_at', 'desc')->get();
               // $peNotifs = Pe::where('status', 1)->get();
               // $department = Department::find($employee->department_id);
               $peTotal = null;
               $peNotifs = [];
               $stNotifs = [];
               // dd($employee->positions);
               foreach($employee->positions as $pos){
                  foreach($pos->department->pes->where('status', 1) as $pe){
                     $peTotal = ++$peTotal;
                     $peNotifs[] = $pe;
                  }

                  $sps = Sp::where('status', 3)->where('department_id', $pos->department_id)->get();
                  foreach($sps as $sp){
                     $spNotifs[] = $sp;
                  }
               }
               // dd($spNotifs);
               
            } elseif(auth()->user()->hasRole('Supervisor|Leader')){
               // $id = auth()->user()->username;
               $employee = Employee::where('nik', auth()->user()->username)->first();
               $spNotifNd = Sp::where('status', 101)->where('nd_for', 1)->orWhere('nd_for', 3)->where('by_id', $employee->id)->orderBy('updated_at', 'desc')->get();
               $spNotifs = Sp::where('by_id', $employee->id)->where('department_id', $employee->department_id)->where('status', 2)->orWhere('status', 202)->orderBy('updated_at', 'desc')->get();
               // $spNotifs = $spNotif;
               $stNotifs = [];
               // $peNotif = null;
               // $department
               $peNotifs = Pe::where('status', 202)->where('created_by', $employee->id )->get();
               // $peNotifs = $peNotif->concat($peNotifNd);
               // dd($spNotifs);
            } elseif(auth()->user()->hasRole('Karyawan')){
               $id = auth()->user()->getEmployeeId();
               $employee = Employee::find($id);
               // $spNotifNd = Sp::where('status', 101)->where('nd_for', 2)->orWhere('nd_for', 3)->where('employee_id', $employee->id)->orderBy('updated_at', 'desc')->get();
               $spNotifs = Sp::where('status', 4)->where('employee_id', $employee->id)->orderBy('updated_at', 'desc')->get();
               $stNotifs = St::where('status', 4)->where('employee_id', $employee->id)->orderBy('updated_at', 'desc')->get();
               // $spNotifs = $spNotifNd->concat($spNotif);
               $peNotifs = Pe::where('status', 202)->where('employe_id', $id)->get();
                
            }  else {
               $spNotifs = [];
               $stNotifs = [];
               $peNotifs = [];
               $employee = null;
            }
            // dd($notif);
            if (count($spNotifs) + count($stNotifs) > 0) {
               $notif = true;
            } else {
               $notif = false;
            }

            $announcements = [];
            if (auth()->user()->hasRole('Administrator')) {
               $spRecomends = [];
               $tegurans = [];
               $announcePersonals = [];
               $announceUnits = [];
            } else {
               $employeeLogin = Employee::find(auth()->user()->getEmployeeId());
               $spRecomends = Sp::where('note', 'Recomendation')->where('by_id', $employeeLogin->id)->where('status', 2)->orderBy('updated_at', 'desc')->get();
               $tegurans = St::where('status', 4)->where('employee_id', $employeeLogin->id)->get();
               
              
               
               $announcePersonals = Announcement::where('type', 2)->where('status', 1)->where('employee_id', $employeeLogin->id)->get();
               foreach($announcePersonals as $pers){
                  $announcements[] = $pers;
               }
               

               $announceUnits = Announcement::where('type', 3)->where('status', 1)->where('unit_id', $employeeLogin->unit_id)->get();
               foreach($announceUnits as $un){
                  $announcements[] = $un;
               }
               // $tegurans = St::where('status', 1)->where('employee_id', $employeeLogin->id)->get();
               
               
            }

            $broadcasts = Announcement::where('type', 1)->where('status', 1)->orderBy('updated_at', 'desc')->get();
            foreach($broadcasts as $broad){
               $announcements[] = $broad;
            }
            // dd($announcements);


            

            $view->with([
               'employee' => $employee,
               'notifSp' => $spNotifs,
               'stNotifs' => $stNotifs,
               'peNotifs' => $peNotifs,
               'notif' => $notif,

               'spRecomends' => $spRecomends,

               'broadcasts' => $broadcasts,
               'tegurans' => $tegurans,
               'announcePersonals' => $announcePersonals,
               'announceUnits' => $announceUnits,
               'announcements' => $announcements,

               'backupDetails' => $backupDetails

            ]);
         }
      );

      view()->composer(
         'layouts.sidebar',
         function ($view) {

            if (auth()->user()->hasRole('Administrator')){
               $backupDetails = [];
               $employee = null;
            } else { 

               $id = auth()->user()->getEmployeeId();
               $employee = Employee::find($id);
              
            }
            
      

          

            $view->with([
               'employee' => $employee,

            ]);
         }
      );

    }
}
