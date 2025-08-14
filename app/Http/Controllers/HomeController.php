<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\AbsenceEmployee;
use App\Models\Announcement;
use App\Models\Biodata;
use App\Models\Contract;
use App\Models\Cuti;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\EmployeeLeader;
use App\Models\Holiday;
use App\Models\Log;
use App\Models\Overtime;
use App\Models\OvertimeEmployee;
use App\Models\OvertimeParent;
use App\Models\Pe;
use App\Models\Position;
use App\Models\Presence;
use App\Models\Sp;
use App\Models\Spkl;
use App\Models\St;
use App\Models\SubDept;
use App\Models\Task;
use App\Models\Transaction;
use App\Models\Unit;
use App\Models\UnitTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HomeController extends Controller
{
   /**
    * Create a new controller instance.
    *
    * @return void
    */
   public function __construct()
   {
      $this->middleware(['auth']);
   }

   /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
   public function index()
   {

      $cuties = Cuti::get();
      
      // $allUsers = User::gett();
      // $transactions = Transaction::get();
      // foreach($transactions as $tran){
      //    $tran->update([
      //       'name' => $tran->employee->biodata->first_name
      //    ]);
      // }

      // $userDebug = User::where('username', 'EN-4-095')->first();
      // $userDebug->update([
      //          'password' => Hash::make('dobby123')
      //       ]);
      // foreach ($allUsers as $user) {
      //    $user->update([
      //       'password' => Hash::make('12345678')
      //    ]);
      // }

      if (!auth()->user()->hasRole('BOD|Administrator|HRD-Manager|HRD|HRD-Spv|HRD-Recruitment|Manager|Asst. Manager|Supervisor|Leader|Karyawan')) {
         // $id = auth()->user()->id;
         RoleEmptyUser;
         // dd('tidak ada role');
      }


      // $overtimes = Overtime::where('type', 2)->get();
      // foreach($overtimes as $over){
        
      // }
      // $overtimes = Overtime::get();
      // foreach ($overtimes as $over) {
      //    if ($over->hours == 0) {
      //       $over->delete();
      //    }
      // }

      // }
      // if (auth()->user()->hasRole('Manager')) {
      //    dd('Manager');
      // } else {
      //    dd('ok');
      // }

      // $contracts = Contract::get();
      // foreach($contracts as $con){
      //    $con->update([
      //       'manager_id' => null
      //    ]);
      // }

      // $employees = Employee::get();
      // foreach($employees as $emp){
      //    $emp->update([
      //       'manager_id' => null
      //    ]);
      // }

      // if (auth()->user()->assignRole('Karyawan')) {
      //    dd('karyawan');
      // } else {
      //    dd('bukan karyawan');
      // }

      // AKTIDKAN CODE DIBAWAH INI HANYA SEKALI SETELAH REFRESH DB
      // ASSIGN ROLE USER
      // $users = User::where('id', '!=', 1)->where('id', '!=', 2)->get();
      // $admin = User::where('email', 'admin@gmail.com')->first();
      // $developer = User::where('email', 'developer@gmail.com')->first();

      // $admin->assignRole('Administratorss
      // $developer->assignRole('Administrator');

      // foreach ($users as $user) {
      //    $user->roles()->detach();
      //    $employee = Employee::where('nik', $user->username)->first();
      // $hrds = Employee::where('department_id', 8)->get();
      // $hrds = Employee::where('department_id', 8)->get();
      //    // dd($hrds);
      //    // JIKA EMPLOYEE DARI DIVISI HRD
      //    // ASSIGN 2 ROLE  (ADMINISTRATOR DAN HRD)
      //    if ($employee->department_id == 8) {
      //       // $employee->update(s[
      //       //    'department_id' => 8
      //       // ]);
      //       // $user->assignRole('Administrator');
      //       $user->assignRole('HRD');
      //    } else {
      //       if ($employee->designation_id == 1 || $employee->designation_id == 2) {
      //          $user->assignRole('Karyawan');
      //       } else if ($employee->designation_id == 3) {
      //          $user->assignRole('Leader');
      //       } else if ($employee->designation_id == 4) {
      //          $user->assignRole('Supervisor');
      //       } else if ($employee->designation_id == 5) {
      //          $user->assignRole('Asst. Manager');
      //       } else if ($employee->designation_id == 6) {
      //          $user->assignRole('Manager');
      //       } else if ($employee->designation_id == 7) {
      //          $user->assignRole('BOD');
      //       }
      //    }
      // }s

      // $contracts = Contract::get();
      // foreach ($contracts as $cont) {
      //    $cont->update([
      //       'shift_id' => 1ssss
      //    ]);
      // }
      // END OF ASSIGN ROLE





      // $employee = Employee::where('nik', auth()->user()->username)->first();
      // dd($employee->id);

      // if (auth()->user()->hasRole('Administrator')) {
      //    dd('admin');
      // } else {
      //    dd('staff');
      // }


      // Aktifkan sekali
      // Set Role user
      // $employees = Employee::get();
      // foreach($employees as $emp){
      //    // dd('ok');
      //    $user = User::where('username', $emp->nik)->first();
      //    if ($emp->designation_id == 1) {
      //       $user->assignRole('Manager');
      //    } elseif ($emp->designation_id == 2) {
      //       $user->assignRole('Asst. Manager');
      //    } elseif ($emp->designation_id == 3) {
      //       $user->assignRole('Supervisor');
      //    } else {
      //       $user->assignRole('Karyawan');
      //    }
      // }

      // Aktifkan sekali
      // $employees = Employee::get();
      // foreach($employees as $emp){
      //    $contract = Contract::find($emp->contract_id);
      //    $emp->update([
      //       'unit_id' => $contract->unit_id
      //    ]);
      // }




      // $employeeUsers = User::where('');

      $now = Carbon::now();
      // dd($now->format('Y-m-d'));
      // dd($now->format('F'));
      $yearMonth = $now->format('Y-m');
      // dd($yearMonth);
      $start = Carbon::parse($yearMonth)->startOfMonth();
      $end = Carbon::parse($yearMonth)->endOfMonth();

      $dates = [];
      while ($start->lte($end)) {
         $dates[] = $start->copy();
         $start->addDay();
      }

      // if (auth()->user()->hasRole('HRD') && auth()->user()->hasRole('Manager')) {
      //    dd('okee');
      // } else {
      //    dd('not okee');
      // }

      // dd($dates);
      // dd(auth()->user()->getEmployeeId());

      $broadcasts = Announcement::where('type', 1)->where('status', 1)->get();
      if (auth()->user()->hasRole('Administrator')) {
         $personals = [];

         // $overs = Overtime::where('employee_id', 23)->orderBy('created_at', 'desc')->get();
         // dd($overs);
      } else {
         $employee = Employee::where('nik', auth()->user()->username)->first();
         $personals = Announcement::where('type', 2)->where('status', 1)->where('employee_id', $employee->id)->get();
      }


      if (auth()->user()->hasRole('Administrator')) {
         
         // Reset Password
         // $allUsers = User::where('email', '!=', 'admin@ekanuri.com')->get();
         // foreach($allUsers as $user){
         //    $employee = Employee::where('nik', $user->username)->first();
         //    if ($employee) {
         //       $birth = Carbon::create($employee->biodata->birth_date);
         //       // dd($birth->format('dmy'));

         //       $user->update([
         //          // 'password' => Hash::make('12345678')
         //          'password' => Hash::make('enc#' . $birth->format('dmy'))
         //       ]);
         //    }
         // }
         // End Reset Password




         // $allUsers = User::where('email', '!=', 'admin@ekanuri.com')->get();
         // foreach($allUsers as $user){
         //    $employee = Employee::where('nik', $user->username)->first();

         //    if ($employee) {
         //       if ($employee->contract->position_id != null) {
         //          if ($employee->contract->position->designation_id == 1 || $employee->contract->position->designation_id == 2) {
         //             $user->roles()->detach();
         //             $user->assignRole('Karyawan');
         //          }
         //       }
               

         //       // $user->update([
         //       //    'password' => Hash::make('12345678')
         //       //    // 'password' => Hash::make('enc#' . $birth->format('dmy'))
         //       // ]);
         //    }
         // }

         // $ia = User::where('username', 'bod-002')->first();
         // // dd($ia);
         // $iaEmp = Employee::where('nik', 'bod-002')->first();
         // $birth = Carbon::create($iaEmp->biodata->birth_date);
         // dd($birth->format('dmy'));
         // $ia->update([
         //    // 'password' => Hash::make('12345678')
         //    'password' => Hash::make('enc#' . $birth->format('dmy'))
         // ]);


         


         // Reset Password
         // $allUsers = User::where('email', '!=', 'admin@ekanuri.com')->get();
         // foreach($allUsers as $user){
         //    $employee = Employee::where('nik', $user->username)->first();

         //    if ($employee) {
         //       if ($employee->contract->position_id != null) {
         //          if ($employee->contract->position->designation_id == 1 || $employee->contract->position->designation_id == 2) {
         //             $user->roles()->detach();
         //             $user->assignRole('Karyawan');
         //          }
         //       }
               

         //       // $user->update([
         //       //    'password' => Hash::make('12345678')
         //       //    // 'password' => Hash::make('enc#' . $birth->format('dmy'))
         //       // ]);
         //    }
         // }
         // End Reset Password

         


         // clearAllCookies();
         $employees = Employee::get();



         $tetap = Contract::where('status', 1)->where('type', 'Tetap')->get()->count();
         $kontrak = Contract::where('status', 1)->where('type', 'Kontrak')->get()->count();
         $off = Employee::where('status', 3)->get()->count();
         // dd($tetap);
         $male = Biodata::where('gender', 'Male')->count();
         $female = Biodata::where('gender', 'Female')->count();
         $spkls = Spkl::orderBy('updated_at', 'desc')->paginate(5);
         $sps = Sp::orderBy('updated_at', 'desc')->get();
         $recentSps = Sp::orderBy('updated_at', 'desc')->paginate(5);
         $logins = Log::where('department_id', '!=', null)->orderBy('created_at', 'desc')->paginate(250);
         $qpes = Pe::orderBy('updated_at', 'desc')->get();
         $recentQpes = Pe::orderBy('updated_at', 'desc')->paginate(8);

         $kontrak = Contract::where('status', 1)->where('type', 'Kontrak')->get()->count();
         $tetap = Contract::where('status', 1)->where('type', 'Tetap')->get()->count();
         $empty = Contract::where('type', null)->get()->count();
         // $empty = Contract::where('type', null)->get()->count();


         // Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit culpa tenetur sed
         $contracts = Contract::where('status', 1)->get();
         $now = Carbon::now();
         $alertContracts = [];
         $alertBirtdays = [];

         $now = Carbon::now();
         // dd($now);
         $contractEnds = Contract::where('status', 1)->where('employee_id', '!=', null)->whereDate('end', '>', $now)->get();
         
         $nowAddTwo = $now->addMonth(2);
         $notifContracts = $contractEnds->where('end', '<', $nowAddTwo);

         foreach ($contracts as $con) {

            if ($con->end) {
               $employee = Employee::where('contract_id', $con->id)->first();
               $date1 = Carbon::createFromDate($con->end);
               $date2 = Carbon::createFromDate($now->format('Y-m-d'));
               $time = $now->diff($con->end);

               $diffMonth = $date1->diffInMonths($date2);
               if ($diffMonth < 12) {
                  if ($employee) {
                     $alertContracts[] = $employee;
                  }
               }
               // dd($diffMonth);
            }
         }

         $bios = Biodata::whereMonth('birth_date', $now)->get();

         foreach ($bios as $bio) {
            // dd($bio->employee->nik);
            $employee = Employee::where('biodata_id', $bio->id)->first();
            if ($employee->status == 1) {
               $alertBirtdays[] = $employee;
            }
         }


         return view('pages.dashboard.admin', [
            'employees' => $employees,
            'male' => $male,
            'female' => $female,
            'spkls' => $spkls,
            'sps' => $sps,
            'recentSps' => $recentSps,
            'tetap' => $tetap,
            'kontrak' => $kontrak,
            'off' => $off,
            'logins' => $logins,
            'qpes' => $qpes,
            'recentQpes' => $recentQpes,
            'kontrak' => $kontrak,
            'tetap' => $tetap,
            'empty' => $empty,

            'alertContracts' => $alertContracts,
            'alertBirthdays' => $alertBirtdays,
            'notifContracts' => $notifContracts
         ]);
      } elseif (auth()->user()->hasRole('BOD')) {

         $user = Employee::find(auth()->user()->getEmployeeId());
         $employees = Employee::get();
         $male = Biodata::where('gender', 'Male')->count();
         $female = Biodata::where('gender', 'Female')->count();
         $spkls = Spkl::orderBy('updated_at', 'desc')->paginate(5);
         $sps = Sp::orderBy('updated_at', 'desc')->paginate(5);
         $kontrak = Contract::where('status', 1)->where('type', 'Kontrak')->get()->count();
         $tetap = Contract::where('status', 1)->where('type', 'Tetap')->get()->count();
         $empty = Contract::where('type', null)->get()->count();
         $logs = Log::where('department_id', $user->department_id)->orderBy('created_at', 'desc')->paginate(5);
         $teams = EmployeeLeader::where('leader_id', $user->id)->get();
         // dd($teams);
         $pes = Pe::orderBy('updated_at', 'desc')->get();
         $recentPes = Pe::orderBy('updated_at', 'desc')->paginate(8);

         $payrollApprovals = UnitTransaction::where('status', 4)->get();
         $units = Unit::get();
            $qpes = Pe::get();

            $now = Carbon::now();
            $month = $now->format('m');
            if ($month < 7) {
               $semester = 1;
            } else {
               $semester = 2;
            }

         $reqForms = AbsenceEmployee::where('leader_id', $employee->id)->whereIn('status', [1])->get();
         

         return view('pages.dashboard.bod', [
            'reqForms' => $reqForms,
            'user' => $user,
            'employee' => $user,
            'employees' => $employees,
            'male' => $male,
            'female' => $female,
            'spkls' => $spkls,
            'sps' => $sps,
            'kontrak' => $kontrak,
            'tetap' => $tetap,
            'empty' => $empty,
            'logs' => $logs,
            'teams' => $teams,
            'pes' => $pes,
            'recentPes' => $recentPes,
            'positions' => [],
            'payrollApprovals' => $payrollApprovals,
            'units' => $units,
            'semester' => 1,
            'year' => 2024 
         ]);
      } elseif (auth()->user()->hasRole('HRD-Manager|HRD')) {

         $user = Employee::find(auth()->user()->getEmployeeId());
         $employees = Employee::get();
         $male = Biodata::where('gender', 'Male')->count();
         $female = Biodata::where('gender', 'Female')->count();
         $spkls = Spkl::orderBy('updated_at', 'desc')->paginate(5);
         $sps = Sp::orderBy('updated_at', 'desc')->paginate(5);
         $kontrak = Contract::where('status', 1)->where('type', 'Kontrak')->get()->count();
         $tetap = Contract::where('status', 1)->where('type', 'Tetap')->get()->count();
         $empty = Contract::where('type', null)->get()->count();
         $logs = Log::where('department_id', $user->department_id)->orderBy('created_at', 'desc')->paginate(5);
         $teams = EmployeeLeader::where('leader_id', $user->id)->get();
         // dd($teams);
         $pes = Pe::orderBy('updated_at', 'desc')->get();
         $recentPes = Pe::orderBy('updated_at', 'desc')->paginate(8);

         // if (count($user->positions) > 0) {
         //    $teams = null;
         //    $pes = null;
         //    $recentPes = null;
         // } else {
         //    if ($user->position->sub_dept_id != null) {
         //       // dd('ada sub');
         //       $teams = Employee::where('status', 1)->where('sub_dept_id', $user->position->sub_dept_id)->where('id', '!=', $user->id)->get();
         //    } else {
         //       $teams = Employee::where('status', 1)->where('department_id', $user->position->department_id)->get();
         //    }

         // }

         if ($user->position_id = 57) {
            $unitTransactionApproval = UnitTransaction::where('status', 1)->get();
         } else {
            $unitTransactionApproval = [];
         }

         $absenceApprovals = Absence::where('status', 404)->get();
         $reqForms = AbsenceEmployee::where('leader_id', $user->id)->whereIn('status', [1,2])->get();

         // dd($reqForms);
         if(auth()->user()->username == 'EN-2-001'){
            // $reqForms = AbsenceEmployee::where('leader_id', $user->id)->whereIn('status', [2])->get();
            $reqForms = AbsenceEmployee::where('manager_id', $user->id)->whereIn('status', [2])->get();
            // dd($reqForms);
         } else {
            $reqForms = AbsenceEmployee::where('leader_id', $user->id)->whereIn('status', [1])->get();
         }
         
         $reqBackForms = AbsenceEmployee::where('cuti_backup_id', $user->id)->whereIn('status', [1])->get();
         // dd($reqForms);


         $now = Carbon::now();
         // dd($now);
         $contractEnds = Contract::where('type', 'Kontrak')->where('status', 1)->where('employee_id', '!=', null)->whereDate('end', '>', $now)->get();
         
         $nowAddTwo = $now->addMonth(2);
         $notifContracts = $contractEnds->where('end', '<', $nowAddTwo);

         $spklApprovals = OvertimeEmployee::where('status', 3)->get();
         $spApprovals = Sp::where('status', 1)->get();
         $stApprovals = St::where('status', 1)->get();

         $teamId = [];
         if(count($user->positions) > 0){
            foreach($user->positions as $pos){
               foreach($pos->department->employees->where('status', 1) as $emp){
                  $teamId[] = $emp->id;
               }
            }

            
         } else {
            $myEmployees = Employee::where('status', 1)->where('department_id', $user->department->id)->get();
            foreach($myEmployees as $emp){
               $teamId[] = $emp->id;
            }
            
         }

         $peApprovals = Pe::whereIn('employe_id', $teamId)->where('status', 1)->get();

         if (auth()->user()->hasRole('Asst. Manager')) {
         
            // $empSpkls = OvertimeEmployee::where('status', 2)->orderBy('updated_at', 'desc')->get();
            if(count($user->positions) > 0){
               
               foreach($user->positions as $pos){
                  foreach($pos->department->employees->where('status', 1) as $emp){
                     $teamId[] = $emp->id;
                  }
               }

               $myEmployees = Employee::whereIn('id', $teamId)->whereNotIn('role', [5,6,8] )->get();
               
               
            } else {
               $myEmployees = Employee::where('status', 1)->where('department_id', $user->department->id)->whereNotIn('role', [5,6,8] )->get();
               foreach($myEmployees as $emp){
                  $teamId[] = $emp->id;
               }
               
            }

            // $reqForms[] = AbsenceEmployee::wherein('employee_id', $teamId)->whereIn('status', [2])->get();
   
            $teamSpkls = OvertimeEmployee::where('status', 1)->where('leader_id', $user->id)->whereIn('employee_id', $teamId)->orderBy('date', 'desc')->get();
         } elseif (auth()->user()->hasRole('Manager')) {
            // $empSpkls = OvertimeEmployee::where('status', 2)->orderBy('updated_at', 'desc')->get();
            if(count($user->positions) > 0){
               foreach($user->positions as $pos){
                  foreach($pos->department->employees->where('status', 1) as $emp){
                     $teamId[] = $emp->id;
                  }
               }

               $myEmployees = Employee::whereIn('id', $teamId)->whereNotIn('role', [5,6,8] )->get();
   
               
            } else {
               $myEmployees = Employee::where('status', 1)->where('department_id', $user->department->id)->whereNotIn('role', [5,6,8] )->get();
               foreach($myEmployees as $emp){
                  $teamId[] = $emp->id;
               }
               
            }
   
            $teamSpkls = OvertimeEmployee::where('status', 2)->whereIn('employee_id', $teamId)->orderBy('date', 'desc')->get();
         }


         // dd($myEmployees);

         // dd($reqForms); 




         return view('pages.dashboard.hrd', [
            'reqForms' => $reqForms,
            'user' => $user,
            'employee' => $user,
            'employees' => $employees,
            'male' => $male,
            'female' => $female,
            'spkls' => $spkls,
            'sps' => $sps,
            
            'kontrak' => $kontrak,
            'tetap' => $tetap,
            'empty' => $empty,
            'logs' => $logs,
            'teams' => $teams,
            'pes' => $pes,
            'recentPes' => $recentPes,
            'positions' => [],
            'payrollApprovals' => $unitTransactionApproval,
            'absenceApprovals' => $absenceApprovals,
            'reqForms' => $reqForms,
            'reqBackForms' => $reqBackForms,

            'notifContracts' => $notifContracts,
            'spklApprovals' => $teamSpkls,
            'spApprovals' => $spApprovals,
            'stApprovals' => $stApprovals,
            'peApprovals' => $peApprovals,
            'myEmployees' => $myEmployees->where('id', '!=', $user->id)
         ]);
      } elseif (auth()->user()->hasRole('HRD-Spv')) {
         $user = Employee::find(auth()->user()->getEmployeeId());
         $units = Unit::get()->count();
         $employees = Employee::get();
         $male = Biodata::where('gender', 'Male')->count();
         $female = Biodata::where('gender', 'Female')->count();
         $spkls = Spkl::orderBy('updated_at', 'desc')->paginate(5);
         $sps = Sp::where('status', '>', 1)->orderBy('created_at', 'desc')->paginate('5');
         $sps = Sp::where('status', '>', 1)->orderBy('created_at', 'desc')->paginate('5');
         $kontrak = Contract::where('status', 1)->where('type', 'Kontrak')->get()->count();
         $tetap = Contract::where('status', 1)->where('type', 'Tetap')->get()->count();
         $empty = Contract::where('type', null)->get()->count();

         $logs = Log::where('department_id', $user->department_id)->orderBy('created_at', 'desc')->paginate(5);
         $reqForms = AbsenceEmployee::where('leader_id', $user->id)->whereIn('status', [1,2])->get();
         $reqBackForms = AbsenceEmployee::where('cuti_backup_id', $user->id)->whereIn('status', [1])->get();
         return view('pages.dashboard.hrd-spv', [
            'units' => $units,
            'employees' => $employees,
            'male' => $male,
            'female' => $female,
            'spkls' => $spkls,
            'sps' => $sps,
            'kontrak' => $kontrak,
            'tetap' => $tetap,
            'empty' => $empty,
            'logs' => $logs,
            'reqForms' => $reqForms,
            'reqBackForms' => $reqBackForms
         ]);
      } elseif (auth()->user()->hasRole('HRD-Recruitment')) {
         $user = Employee::find(auth()->user()->getEmployeeId());
         $units = Unit::get()->count();
         $employees = Employee::where('kpi_id', null)->get();
         $male = Biodata::where('gender', 'Male')->count();
         $female = Biodata::where('gender', 'Female')->count();
         $spkls = Spkl::orderBy('updated_at', 'desc')->paginate(5);
         $sps = Sp::where('status', 1)->get();
         $kontrak = Contract::where('status', 1)->where('type', 'Kontrak')->get()->count();
         $allEmployees = Contract::where('status', 1)->get()->count();
         $tetap = Contract::where('status', 1)->where('type', 'Tetap')->get()->count();
         $empty = Contract::where('type', null)->get()->count();

         $reqForms = AbsenceEmployee::where('leader_id', $user->id)->whereIn('status', [1,2])->get();
         $reqBackForms = AbsenceEmployee::where('cuti_backup_id', $user->id)->whereIn('status', [1])->get();

         $teams = EmployeeLeader::where('leader_id', $user->id)->get();

         $now = Carbon::now();
         // dd($now);
         $contractEnds = Contract::where('type', 'Kontrak')->where('status', 1)->where('employee_id', '!=', null)->whereDate('end', '>', $now)->get();
         
         $nowAddTwo = $now->addMonth(2);
         $notifContracts = $contractEnds->where('end', '<', $nowAddTwo);

         $cutis = Absence::join('employees', 'absences.employee_id', '=', 'employees.id')
            ->where('employees.department_id', $user->department_id)
            ->where('absences.type', 5)
            ->where('absences.date', '>=', $now->format('Y-m-d'))
            ->select('absences.*')
            ->get();
         $peHistories = Pe::where('employe_id', $user->id)->where('status', '>', 1)->paginate(3);
         $spHistories = Sp::where('employee_id', auth()->user()->getEmployeeId())->where('status', '>', 3)->get();
         $spklApprovals = OvertimeEmployee::where('status', 3)->get();

         $absenceProgress = AbsenceEmployee::where('status', '!=', 0)->where('status', '!=', 5)->orderBy('release_date', 'desc')->get();
         // dd($now);
         // $contractEnds = Contract::whereBetween('end', [$now, $nowAddTwo])->get();
         
         // dd($contractEnds->where('end', '<', $nowAddTwo));
         // dd($reqForms);

         $spklApprovals = OvertimeEmployee::where('status', 1)->where('leader_id', $user->id)->get();
         return view('pages.dashboard.hrd-recruitment', [
            'units' => $units,
            'employee' => $user,
            'allEmployees' => $allEmployees,
            'employees' => $employees,
            'male' => $male,
            'female' => $female,
            'spkls' => $spkls,
            'sps' => $sps,
            'kontrak' => $kontrak,
            'tetap' => $tetap,
            'empty' => $empty,
            'broadcasts' => $broadcasts,
            'personals' => $personals,
            'reqForms' => $reqForms,
            'reqBackForms' => $reqBackForms,
            'teams' => $teams,
            'notifContracts' => $notifContracts,
            'cutis' => $cutis,
            'peHistories' => $peHistories,
            'spHistories' => $spHistories,
            'spklApprovals' => $spklApprovals,
            'absenceProgress' => $absenceProgress
         ])->with('i');
      } elseif (auth()->user()->hasRole('HRD-Payroll')) {
         $user = Employee::find(auth()->user()->getEmployeeId());
         $units = Unit::get()->count();
         $employees = Employee::where('kpi_id', null)->get();
         $male = Biodata::where('gender', 'Male')->count();
         $female = Biodata::where('gender', 'Female')->count();
         $spkls = Spkl::orderBy('updated_at', 'desc')->paginate(5);
         $sps = Sp::where('status', 1)->get();
         $kontrak = Contract::where('status', 1)->where('type', 'Kontrak')->get()->count();
         $tetap = Contract::where('status', 1)->where('type', 'Tetap')->get()->count();
         $empty = Contract::where('type', null)->get()->count();

         $now = Carbon::now();
         $month = $now->format('m');
         $holidays = Holiday::whereMonth('date', $month)->orderBy('date', 'asc')->get();
         $transactions = Transaction::where('status', 0)->get();
         $unitTransactions = UnitTransaction::orderBy('cut_to', 'desc')->paginate(25);
         $emptyPayroll = Employee::where('status', '!=', 3)->where('payroll_id', null)->get();
         // $reqForms = AbsenceEmployee::where('status', 3)->get();
         $reqForms = AbsenceEmployee::where('leader_id', $user->id)->whereIn('status', [1,2])->get();
         $reqBackForms = AbsenceEmployee::where('cuti_backup_id', $user->id)->get();
         $formAbsences = AbsenceEmployee::where('status', '!=', 5)->orderBy('release_date', 'desc')->paginate(30);

         $cutis = Absence::join('employees', 'absences.employee_id', '=', 'employees.id')
            ->where('employees.department_id', $user->department_id)
            ->where('absences.type', 5)
            ->where('absences.date', '>=', $now->format('Y-m-d'))
            ->select('absences.*')
            ->get();

         $peHistories = Pe::where('employe_id', $user->id)->where('status', '>', 1)->paginate(3);
         $spHistories = Sp::where('employee_id', auth()->user()->getEmployeeId())->where('status', '>', 3)->get();

         $spklApprovals = OvertimeEmployee::where('status', 3)->get();


         $payslipProgress = UnitTransaction::where('status', '>', 0)->where('status', '<', 5)->get()->count();
         $payslipComplete = UnitTransaction::whereIn('status', [5,6])->get()->count();
         $payslipReject = UnitTransaction::whereIn('status', [101,202,303,404])->get()->count();
         $absenceProgress = AbsenceEmployee::where('status', '!=', 0)->where('status', '!=', 5)->orderBy('release_date', 'desc')->get();

         return view('pages.dashboard.hrd-payroll', [
            'units' => $units,
            'employee' => $user,
            'employees' => $employees,
            'male' => $male,
            'female' => $female,
            'spkls' => $spkls,
            'sps' => $sps,
            'kontrak' => $kontrak,
            'tetap' => $tetap,
            'empty' => $empty,
            'broadcasts' => $broadcasts,
            'personals' => $personals,

            'month' => $now->format('F'),
            'holidays' => $holidays,
            'transactions' => $transactions,
            'unitTransactions' => $unitTransactions,
            'emptyPayroll' => $emptyPayroll,

            'broadcasts' => $broadcasts,
            'personals' => $personals,

            'reqForms' => $reqForms,
            'reqBackupForms' => $reqBackForms,
            'formAbsences' => $formAbsences,
            'cutis' => $cutis, 
            'peHistories' => $peHistories,
            'spHistories' => $spHistories,
            'spklApprovals' => $spklApprovals,

            'payslipProgress' => $payslipProgress, 
            'payslipComplete' => $payslipComplete,
            'payslipReject' => $payslipReject,
            'absenceProgress' => $absenceProgress

         ])->with('i');
      } elseif (auth()->user()->hasRole('HRD-KJ12')) {
         $user = Employee::find(auth()->user()->getEmployeeId());
         // dd('ok');
         // $units = Unit::get()->count();
         // $employees = Employee::where('kpi_id', null)->get();
         // $male = Biodata::where('gender', 'Male')->count();
         // $female = Biodata::where('gender', 'Female')->count();
         // $spkls = Spkl::orderBy('updated_at', 'desc')->paginate(5);
         // $sps = Sp::where('status', 1)->get();
         // $kontrak = Contract::where('status', 1)->where('type', 'Kontrak')->get()->count();
         // $tetap = Contract::where('status', 1)->where('type', 'Tetap')->get()->count();
         // $empty = Contract::where('type', null)->get()->count();

         $now = Carbon::now();
         $month = $now->format('m');
         // $holidays = Holiday::whereMonth('date', $month)->orderBy('date', 'asc')->get();
         // $transactions = Transaction::where('status', 0)->get();
         // dd('ok');
         $overtimes = Overtime::whereIn('location_id', [3,11,12,13,14,20])->orderBy('updated_at', 'desc')->paginate(500);
         // $now = Carbon::now();
         

         // $employees = Employee::where('status', 1)->where('location_id', 3)->get();

         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            
            ->where('contracts.loc', 'kj1-2')
            ->orWhere('contracts.loc', 'kj1-2-medco')
            ->orWhere('contracts.loc', 'kj1-2-premier-oil')
            ->orWhere('contracts.loc', 'kj1-2-petrogas')
            ->orWhere('contracts.loc', 'kj1-2-star-energy')
            ->orWhere('contracts.loc', 'kj1-2-housekeeping')
            ->where('employees.status', 1)
            ->select('employees.*')
            
            ->get();
         // dd($overtimes);

         return view('pages.dashboard.hrd-site', [
            // 'units' => $units,
            'employee' => $user,
            'employees' => $employees,
            // 'male' => $male,
            // 'female' => $female,
            // 'spkls' => $spkls,
            // 'sps' => $sps,
            // 'kontrak' => $kontrak,
            // 'tetap' => $tetap,
            // 'empty' => $empty,
            // 'month' => $now->format('F'),
            // 'year' => $now->format('Y'),
            // 'holidays' => $holidays,
            // 'transactions' => $transactions,
            'overtimes' => $overtimes
         ])->with('i');
      } elseif (auth()->user()->hasRole('HRD-KJ45')) {
         $user = Employee::find(auth()->user()->getEmployeeId());
         $units = Unit::get()->count();
         $employees = Employee::where('kpi_id', null)->get();
         $male = Biodata::where('gender', 'Male')->count();
         $female = Biodata::where('gender', 'Female')->count();
         $spkls = Spkl::orderBy('updated_at', 'desc')->paginate(5);
         $sps = Sp::where('status', 1)->get();
         $kontrak = Contract::where('status', 1)->where('type', 'Kontrak')->get()->count();
         $tetap = Contract::where('status', 1)->where('type', 'Tetap')->get()->count();
         $empty = Contract::where('type', null)->get()->count();

         $now = Carbon::now();
         $month = $now->format('m');
         $holidays = Holiday::whereMonth('date', $month)->orderBy('date', 'asc')->get();
         $transactions = Transaction::where('status', 0)->get();
         $overtimes = Overtime::whereIn('location_id', [4,5,21,22])->orderBy('updated_at', 'desc')->paginate(500);
         $now = Carbon::now();

         if (auth()->user()->hasRole('HRD-KJ12')) {
            $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
               ->where('contracts.loc', 'kj1-2')
               ->orWhere('contracts.loc', 'kj1-2-medco')
               ->orWhere('contracts.loc', 'kj1-2-premier-oil')
               ->orWhere('contracts.loc', 'kj1-2-petrogas')
               ->orWhere('contracts.loc', 'kj1-2-star-energy')
               ->orWhere('contracts.loc', 'kj1-2-housekeeping')

               ->select('employees.*')
               ->get();
         } elseif (auth()->user()->hasRole('HRD-KJ45')) {
            $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
               ->where('contracts.loc', 'kj4')->orWhere('contracts.loc', 'kj5')
               ->orWhere('contracts.loc', 'kj4-housekeeping')
               ->orWhere('contracts.loc', 'kj5-housekeeping')
               ->select('employees.*')
               ->get();
         }

         return view('pages.dashboard.hrd-site', [
            'units' => $units,
            'employee' => $user,
            'employees' => $employees,
            'male' => $male,
            'female' => $female,
            'spkls' => $spkls,
            'sps' => $sps,
            'kontrak' => $kontrak,
            'tetap' => $tetap,
            'empty' => $empty,
            'month' => $now->format('F'),
            'year' => $now->format('Y'),
            'holidays' => $holidays,
            'transactions' => $transactions,
            'overtimes' => $overtimes
         ])->with('i');
      } elseif (auth()->user()->hasRole('HRD-JGC')) {
         $user = Employee::find(auth()->user()->getEmployeeId());
         $units = Unit::get()->count();
         // $employees = Employee::where('kpi_id', null)->get();
         $male = Biodata::where('gender', 'Male')->count();
         $female = Biodata::where('gender', 'Female')->count();
         $spkls = Spkl::orderBy('updated_at', 'desc')->paginate(5);
         $sps = Sp::where('status', 1)->get();
         $kontrak = Contract::where('status', 1)->where('type', 'Kontrak')->get()->count();
         $tetap = Contract::where('status', 1)->where('type', 'Tetap')->get()->count();
         $empty = Contract::where('type', null)->get()->count();

         $now = Carbon::now();
         $month = $now->format('m');
         $holidays = Holiday::whereMonth('date', $month)->orderBy('date', 'asc')->get();
         $transactions = Transaction::where('status', 0)->get();
         $overtimes = Overtime::join('employees', 'overtimes.employee_id', '=', 'employees.id')
         ->whereIn('employees.unit_id', [10,13,14])->orderBy('overtimes.updated_at', 'desc')->select('overtimes.*')
         ->get();
         $absences = Absence::join('employees', 'absences.employee_id', '=', 'employees.id')
         ->whereIn('employees.unit_id', [10,13,14])->orderBy('absences.updated_at', 'desc')->select('absences.*')
         ->get();
         $now = Carbon::now();

         $employees = Employee::whereIn('unit_id', [10,13,14])
               ->where('status', 1)
               ->get();
         // if (auth()->user()->hasRole('HRD-KJ12')) {
            
         // } elseif (auth()->user()->hasRole('HRD-KJ45')) {
         //    $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
         //       ->where('contracts.loc', 'kj4')->orWhere('contracts.loc', 'kj5')
         //       ->select('employees.*')
         //       ->get();
         // }

         return view('pages.dashboard.hrd-site', [
            'units' => $units,
            'employee' => $user,
            'employees' => $employees,
            'male' => $male,
            'female' => $female,
            'spkls' => $spkls,
            'sps' => $sps,
            'kontrak' => $kontrak,
            'tetap' => $tetap,
            'empty' => $empty,
            'month' => $now->format('F'),
            'year' => $now->format('Y'),
            'holidays' => $holidays,
            'transactions' => $transactions,
            'overtimes' => $overtimes,
            'absences' => $absences
         ])->with('i');
      } elseif (auth()->user()->hasRole('Manager|Asst. Manager')) {
         // dd('ok');
         $employee = Employee::where('nik', auth()->user()->username)->first();
         $biodata = Biodata::where('email', auth()->user()->email)->first();
         $presences = Presence::where('employee_id', $employee->id)->orderBy('created_at', 'desc')->get();
         $pending = Presence::where('employee_id', $employee->id)->where('out_time', null)->first();
         // dd($biodata->employee->id);

         $spkls = Spkl::where('status', 1)->orWhere('status', 2)->where('department_id', $employee->department_id)->get();
         $sps = Sp::where('status', '>', 2)->where('department_id', $employee->department_id)->orderBy('updated_at', 'desc')->paginate('5');
         // dd($spkls);
         // dd('ok');
         if (count($employee->positions) > 0) {
            $teams = null;
            $pes = null;
            $recentPes = null;
         } else {
            // dd('ok');
            if ($employee->position->sub_dept_id != null) {
               // dd('ada sub');
               $teams = Employee::where('status', 1)->where('sub_dept_id', $employee->position->sub_dept_id)->where('id', '!=', $employee->id)->get();
            } else {
               $teams = Employee::where('status', 1)->where('department_id', $employee->position->department_id)->get();
            }

            $pes = Pe::where('department_id', $employee->department_id)->where('status', '>=', '0')
               ->orderBy('release_at', 'desc')
               ->get();

            $recentPes = Pe::where('department_id', $employee->department_id)->where('status', '>=', '0')
               ->orderBy('release_at', 'desc')
               ->paginate(8);
         }




         // $spNotifs = Sp::where('status', 3)->where('department_id', $employee->department_id)->orderBy('updated_at', 'desc')->get();
         $peTotal = null;
         $peNotifs = [];
         foreach($employee->positions as $pos){
            foreach($pos->department->pes->where('status', 1) as $pe){
               $peTotal = ++$peTotal;
               $peNotifs[] = $pe;
            }

          
         }






         if ($employee->nik == 11304) {
            $payrollApprovals = UnitTransaction::where('status', 2)->get();
         } elseif ($employee->nik == 'EN-2-006') {
            $payrollApprovals = UnitTransaction::where('status', 3)->get();
         } else {
            $payrollApprovals = [];
         }

         // dd(count($final));
         $employeePositions = $employee->positions;
         // dd($employeePositions);

         $spNotifs = Sp::where('status', 2)->orWhere('status', 202)->where('by_id', $employee->id)->where('department_id', $employee->department_id)->orderBy('updated_at', 'desc')->get();
         $spManNotifs = Sp::where('status', 3)->where('department_id', $employee->department_id)->orderBy('updated_at', 'desc')->get();
        

         $reqForms = AbsenceEmployee::where('manager_id', $employee->id)->whereIn('status', [2])->get();
         $recentForms = AbsenceEmployee::where('manager_id', $employee->id)->whereIn('status', [5])->orderBy('date', 'desc')->get();
         // dd($teams);
        

         $now = Carbon::now();
         // dd($now);
         $contractEnds = Contract::where('status', 1)->where('employee_id', '!=', null)->where('department_id', $employee->department_id)->whereDate('end', '>', $now)->get();
         
         $nowAddTwo = $now->addMonth(2);
         $notifContracts = $contractEnds->where('end', '<', $nowAddTwo);


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

         $teamSpkls = OvertimeEmployee::where('status', 2)->where('parent_id', null)->whereIn('employee_id', $teamId)->get();
         // dd($teamSpkls);
         $spklGroupApprovalLeaders = OvertimeParent::where('status', 1)->where('leader_id', $employee->id)->get();
         $spklGroupApprovalManagers = OvertimeParent::where('status', 2)->whereIn('by_id', $teamId)->get();

         // dd(count($teamSpkls));
         // dd($spklGroupApprovalLeaders);

         // $approvalLeaderSpklTeams = OvertimeParent::where('status', 1)->whereIn('employee_id', $teamId)->get();

         $recentTeamSpkls = OvertimeEmployee::where('status','>', 2)->whereNotIn('status',  [201,301])->whereIn('employee_id', $teamId)->get();
         $spApprovals = Sp::where('status', 3)->whereIn('employee_id', $teamId)->get();


         $now = Carbon::now();
         // dd($now);
         $contractEnds = Contract::where('type', 'Kontrak')->where('status', 1)->whereIn('employee_id', $teamId)->whereDate('end', '>', $now)->get();
         $recentAbsences = Absence::whereIn('employee_id', $teamId)->orderBy('date', 'desc')->paginate(200);
         $recentOvertimes = Overtime::whereIn('employee_id', $teamId)->orderBy('date', 'desc')->paginate(200);
         $nowAddTwo = $now->addMonth(2);
         $contractAlerts = $contractEnds->where('end', '<', $nowAddTwo);

         $stAlerts = St::where('status', 3)->whereIn('employee_id', $teamId)->get();


         
         return view('pages.dashboard.manager', [
            'recentOvertimes' => $recentOvertimes,
            'recentAbsences' => $recentAbsences,
            'employee' => $biodata->employee,
            'dates' => $dates,
            'presences' => $presences,
            'pending' => $pending,
            'spkls' => $spkls,
            'sps' => $sps,
            'teams' => $teams,
            'positions' => $employeePositions,
            'pes' => $pes,
            'recentPes' => $recentPes,
            'spNotifs' => $spNotifs,
            'spManNotifs' => $spManNotifs,
            'payrollApprovals' => $payrollApprovals,

            'broadcasts' => $broadcasts,
            'personals' => $personals,
            'reqForms' => $reqForms,
            'recentForms' => $recentForms,

            'peTotal' => $peTotal,
            'peNotifs' => $peNotifs,

            'teamSpkls' => $teamSpkls,
            'recentTeamSpkls' => $recentTeamSpkls,
            'spApprovals' => $spApprovals,
            'contractAlerts' => $contractAlerts,
            'stAlerts' => $stAlerts,

            'spklGroupApprovalLeaders' => $spklGroupApprovalLeaders,
            'spklGroupApprovalManagers' => $spklGroupApprovalManagers

            // 'approvalLeaderSpklTeams' => $approvalLeaderSpklTeams
         ]);
      } elseif (auth()->user()->hasRole('Supervisor|Leader')) {
         // dd('ok');
         $employee = Employee::where('nik', auth()->user()->username)->first();
         $biodata = Biodata::where('email', auth()->user()->email)->first();
         $presences = Presence::where('employee_id', $employee->id)->orderBy('created_at', 'desc')->get();
         $pending = Presence::where('employee_id', $employee->id)->where('out_time', null)->first();
         // dd($biodata->employee->id);

         $spkls = Spkl::where('status', '>=', 1)->where('department_id', $employee->department_id)->orderBy('created_at', 'desc')->paginate(5);
         // dd($spkls);
         // $teams = Employee::where('direct_leader_id', auth()->user()->getEmployeeId())->get();
         $teams = EmployeeLeader::where('leader_id', $employee->id)->get();

         $myteams = EmployeeLeader::join('employees', 'employee_leaders.employee_id', '=', 'employees.id')
            ->join('biodatas', 'employees.biodata_id', '=', 'biodatas.id')
            ->where('leader_id', $employee->id)
            ->select('employees.*')
            ->orderBy('biodatas.first_name', 'asc')
            ->get();

         $spteams = EmployeeLeader::join('sps', 'employee_leaders.employee_id', '=', 'sps.employee_id')
            
            ->where('employee_leaders.leader_id', $employee->id)
            ->where('sps.status', 5)
            ->select('sps.*')
            ->get();
         //  dd($myteams);
         // ->join('biodatas', 'employees.biodata_id', '=', 'biodatas.id')
         // ->where('leader_id', $employee->id)
         // ->select('employees.*')
         // ->orderBy('biodatas.first_name', 'asc')
         // ->get();
         //  dd($myteams);

         // $pes = Pe::join('employees', 'pes.employe_id', '=', 'employees.id')
         // ->where('employees.id', $employee->id)
         // ->whereIn('pes.status', [2, 101, 202])
         // ->select('pes.*')
         // ->orderBy('pes.release_at', 'desc')
         // ->get();



         // dd($teams);
         
         $spRecents = Sp::where('by_id', auth()->user()->getEmployeeId())->orderBy('updated_at', 'desc')->paginate('5');
         $peRecents = Pe::where('created_by', $employee->id)->where('status', '!=', 2)->orderBy('updated_at', 'desc')->get();
         if ($employee->designation->slug == 'supervisor') {
            $peRecents = Pe::where('department_id', $employee->department_id)->where('status', '!=', 2)->orderBy('updated_at', 'desc')->paginate(8);
         } else {
            $peRecents = Pe::where('created_by', $employee->id)->where('status', '!=', 2)->orderBy('updated_at', 'desc')->paginate(8);
         }
         $allpes = Pe::orderBy('updated_at', 'desc')->get();
         

         $reqForms = AbsenceEmployee::where('leader_id', $employee->id)->whereIn('status', [1])->get();
         $reqBackForms = AbsenceEmployee::where('cuti_backup_id', $employee->id)->orderBy('updated_at', 'desc')->get();
         $cutis = Absence::join('employees', 'absences.employee_id', '=', 'employees.id')
            ->where('employees.department_id', $employee->department_id)
            ->where('absences.type', 5)
            ->where('absences.date', '>=', $now->format('Y-m-d'))
            ->select('absences.*')
            ->get();


         $allEmployeeSpkls = OvertimeEmployee::where('status', 1)->where('parent_id', null)->where('leader_id', $employee->id)->get();
         $spklGroupApprovalLeaders = OvertimeParent::where('status', 1)->where('leader_id', $employee->id)->get();
         // dd($allEmployeeSpkls);
         $approvalEmployeeSpkl = 0;
         foreach ($myteams as $team) {
            foreach ($allEmployeeSpkls as $spkl) {
               if ($spkl->employee_id == $team->id) {
                  $approvalEmployeeSpkl = $approvalEmployeeSpkl + 1;
               }
            }
         }

         $spNotifs = Sp::where('by_id', $employee->id)->where('department_id', $employee->department_id)->where('status', 2)->orWhere('status', 202)->orderBy('updated_at', 'desc')->get();
         // dd($spNotifs);
         // $spRecomends = Sp::where('note', 'Recomendation')->where('by_id', $employee->id)->where('status', 2)->orderBy('updated_at', 'desc')->get();
         $stAlerts = St::where('leader_id', $employee->id)->where('status', 2)->orderBy('date', 'desc')->get();

         $absences = Absence::where('employee_id', $employee->id)->get();
         // dd($absences);
         $myForms = AbsenceEmployee::where('employee_id', $employee->id)->where('status', '!=', 0)->where('status', '!=', 5)->orderBy('updated_at', 'desc')->get();
         

         $teamId = [];
         foreach($myteams as $t){
            $teamId[] = $t->id;
         }


         $now = Carbon::now();
         // dd($now);
         $contractEnds = Contract::where('type', 'Kontrak')->where('status', 1)->whereIn('employee_id', $teamId)->whereDate('end', '>', $now)->get();
         
         $nowAddTwo = $now->addMonth(2);
         $contractAlerts = $contractEnds->where('end', '<', $nowAddTwo);
         // dd($notifContracts);

         // dd($spNotifs);
         
         return view('pages.dashboard.supervisor', [
            'employee' => $biodata->employee,
            'teams' => $teams,
            'myteams' => $myteams,
            'dates' => $dates,
            'presences' => $presences,
            'pending' => $pending,
            'cutis' => $cutis,
            'spkls' => $spkls,
            'allpes' => $allpes,
            'spRecents' => $spRecents,
            'peRecents' => $peRecents,

            'absences' => $absences,

            'broadcasts' => $broadcasts,
            'personals' => $personals,

            'myForms' => $myForms,

            'reqForms' => $reqForms,
            'reqBackupForms' => $reqBackForms,

            'spteams' => $spteams,
            'spNotifs' => $spNotifs,
            // 'spRecomends' => $spRecomends,
            'stAlerts' => $stAlerts,
            'approvalEmployeeSpkl' => $approvalEmployeeSpkl,
            'spklGroupApprovalLeaders' => $spklGroupApprovalLeaders,
            'contractAlerts' => $contractAlerts
         ]);
      } else {


         $employee = Employee::where('nik', auth()->user()->username)->first();
         $biodata = Biodata::where('email', auth()->user()->email)->first();
         $presences = Presence::where('employee_id', auth()->user()->getEmployeeId())->orderBy('created_at', 'desc')->get();
         $absences = Absence::where('employee_id', $employee->id)->orderBy('date', 'desc')->get();
         $pending = Presence::where('employee_id', auth()->user()->getEmployeeId())->where('out_time', null)->first();
         // dd($biodata->employee->id);

         $spkls = Spkl::where('employee_id',)->orderBy('updated_at', 'desc')->paginate(3);
         $sps = Sp::where('employee_id', auth()->user()->getEmployeeId())->where('status', 2)->get();
         $spHistories = Sp::where('employee_id', auth()->user()->getEmployeeId())->where('status', '>', 3)->get();
         // dd(auth()->user()->getEmployeeId());

         $peHistories = Pe::where('employe_id', $employee->id)->where('status', '>', 1)->paginate(3);
         $tasks = Task::where('employee_id', $employee->id)->whereIn('status', [0,1])->get();

         $now = Carbon::now();
         $currentTransaction = Transaction::where('employee_id', $employee->id)->where('status', '>=', 6)->where('payslip_status', 'show')->orderBy('cut_to', 'desc')->whereMonth('cut_to', $now)->first();
         // dd($currentTransaction);
         $cutis = Absence::join('employees', 'absences.employee_id', '=', 'employees.id')
            ->where('employees.department_id', $employee->department_id)
            ->where('absences.type', 5)
            ->where('absences.date', '>=', $now->format('Y-m-d'))
            ->select('absences.*')
            ->get();

         // $absences =

         $reqForms = AbsenceEmployee::where('leader_id', $employee->id)->whereIn('status', [1])->get();
         $myForms = AbsenceEmployee::where('employee_id', $employee->id)->where('status', '!=', 0)->where('status', '!=', 5)->orderBy('updated_at', 'desc')->get();
         $reqBackForms = AbsenceEmployee::where('cuti_backup_id', $employee->id)->where('date', '=>', $now)->get();

         $spklEmps = OvertimeEmployee::where('employee_id', $employee->id)->where('status', '>', 0)->where('status', '!=', 4)->get();
         // dd(count($absences ));
         $stAlerts = St::where('employee_id', $employee->id)->where('status', 4)->get();
         return view('pages.dashboard.employee', [
            'now' => $now,
            'employee' => $employee,
            'dates' => $dates,
            'presences' => $presences,
            'pending' => $pending,
            'spkls' => $spkls,
            'sps' => $sps,
            'spHistories' => $spHistories,

            'broadcasts' => $broadcasts,
            'personals' => $personals,
            'peHistories' => $peHistories,
            'tasks' => $tasks,
            'absences' => $absences,
            'currentTransaction' => $currentTransaction,
            'cutis' => $cutis, 
            'myForms' => $myForms,
            'reqForms' => $reqForms,
            'reqBackupForms' => $reqBackForms,
            'spklEmps' => $spklEmps,
            'stAlerts' => $stAlerts
         ])->with('i');
      }
   }

   // $date = \Carbon\Carbon::today()->subDays(7);
   // $users = User::where('created_at','>=',$date)->get();
}
