<?php

namespace App\Http\Controllers;

use App\Exports\OvertimeExport;
use App\Imports\OvertimesImport;
use App\Models\Employee;
use App\Models\EmployeeLeader;
use App\Models\Holiday;
use App\Models\Location;
use App\Models\Log;
use App\Models\Overtime;
use App\Models\Payroll;
use App\Models\Transaction;
use App\Models\TransactionReduction;
use App\Models\Unit;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class OvertimeController extends Controller
{

   public function debug(){
      // dd('okeee');
      $overtimes = Overtime::join('employees', 'overtimes.employee_id', '=', 'employees.id')
      ->whereIn('employees.unit_id', [7,8,9])
      ->select('overtimes.*')
      ->get();

      foreach ($overtimes as $over) {
         $employee = Employee::find($over->employee_id);
            $spkl_type = $employee->unit->spkl_type;
         $hour_type = $employee->unit->hour_type;
         // $hoursFinal = 0;
         if ($over->holiday_type == 1) {
            $finalHour = $over->hours;
            if ($hour_type == 2) {
               // dd('test');
               $multiHours = $over->hours - 1;
               $finalHour = $multiHours * 2 + 1.5;
               // dd($finalHour);
            }
         } elseif ($over->holiday_type == 2) {
            $finalHour = $over->hours * 2;
         } elseif ($over->holiday_type == 3) {
            $finalHour = $over->hours * 2;
            // $employee = Employee::where('payroll_id', $payroll->id)->first();
               if ($employee->unit_id ==  7 || $employee->unit_id ==  8 || $employee->unit_id ==  9) {
                  // dd('ok');
                  if ($over->hours <= 7) {
                     $finalHour = $over->hours * 2;
                  } else{
                     // dd('ok');
                     $hours7 = 14;
                     $sisa1 = $over->hours - 7;
                     $hours8 = 3;
                     if ($sisa1 > 1) {
                        $sisa2 = $sisa1 - 1;
                        $hours9 = $sisa2 * 4;
                     } else {
                        $hours9 = 0;
                     }
      
                     $finalHour = $hours7 + $hours8 + $hours9;
                     // dd($finalHour);

                  }
               } else {
                  if ($over->hours <= 8) {
                     $finalHour = $over->hours * 2;
                  } else{
                     $hours8 = 16;
                     $sisa1 = $over->hours - 8;
                     $hours9 = 3;
                     if ($sisa1 > 1) {
                        $sisa2 = $sisa1 - 1;
                        $hours10 = $sisa2 * 4;
                     } else {
                        $hours10 = 0;
                     }
      
                     $finalHour = $hours8 + $hours9 + $hours10;
                  }
               }
         } elseif ($over->holiday_type == 4) {
            $finalHour = $over->hours * 3;
         }

         $over->update([
            'hours_final' => $finalHour
         ]);
      }

      return redirect()->back()->with('success', 'successfully fixing');


   }

   public function team(){
      // $overtimes = Overtime::get();
      $now = Carbon::now();
      $export = false;
      $loc = 'All';
      $locations = Location::get();

      $employee = Employee::where('nik', auth()->user()->username)->first();
      

      $myTeamOvertimes = EmployeeLeader::join('overtimes', 'employee_leaders.employee_id', '=', 'overtimes.employee_id')
     
      ->where('leader_id', $employee->id)
      ->select('overtimes.*')
      ->get();

      $employees = Employee::join('employee_leaders', 'employees.id', '=', 'employee_leaders.employee_id')
            
            ->where('leader_id', $employee->id)
            ->select('employees.*')
            ->get();

     

      
      return view('pages.payroll.overtime.team', [
         'employee' => $employee,
         'employees' => $employees,
         'export' => $export,
         'loc' => $loc,
         'locations' => $locations,
         'overtimes' => $myTeamOvertimes,
         // 'employees' => $employees,
         'month' => $now->format('F'),
         'year' => $now->format('Y'),
         'from' => 0,
         'to' => 0
         // 'holidays' => $holidays
      ])->with('i');
   }


   public function filterTeam(Request $req){
      // $overtimes = Overtime::get();
      $now = Carbon::now();
      $export = false;
      $loc = 'All';
      $locations = Location::get();

      $employee = Employee::where('nik', auth()->user()->username)->first();
      

      $employees = Employee::join('employee_leaders', 'employees.id', '=', 'employee_leaders.employee_id') 
            ->where('leader_id', $employee->id)
            ->select('employees.*')
            ->get();

     

      
      return view('pages.payroll.overtime.team', [
         'employee' => $employee,
         'employees' => $employees,
         'export' => $export,
         'loc' => $loc,
         'locations' => $locations,
         // 'overtimes' => $myTeamOvertimes,
         // 'employees' => $employees,
         'month' => $now->format('F'),
         'year' => $now->format('Y'),
         'from' => $req->from,
         'to' => $req->to
         // 'holidays' => $holidays
      ])->with('i');
   }

   public function index()
   {

      $now = Carbon::now();
      // $overtimes = Overtime::get();

      // foreach($overtimes as $over){
      //    $over->update([
      //       'status' => 1
      //    ]);
      // }

      $export = false;
      $loc = 'All';
      $locations = Location::get();

      


      if (auth()->user()->hasRole('HRD-KJ12')) {
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj1-2')
            ->select('employees.*')
            ->get();

            $employees = Employee::where('status', 1)->where('location_id', 3)->get();

         $overtimes = Overtime::orderBy('updated_at', 'desc')->where('location_id', 3)->paginate(2000);
      } elseif (auth()->user()->hasRole('HRD-KJ45')) {

         // dd('ok');
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj4')->orWhere('contracts.loc', 'kj5')
            ->select('employees.*')
            ->get();

            $employees = Employee::where('status', 1)->where('location_id', 4)->orWhere('location_id', 5)->get();
         $overtimes = Overtime::orderBy('updated_at', 'desc')->where('location_id', 4)->orWhere('location_id', 5)->paginate(2000);
         // dd($overtimes);
      } elseif (auth()->user()->hasRole('HRD-JGC')) {

         // dd('ok');
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'jgc')
            ->select('employees.*')
            ->get();

         $employees = Employee::where('status', 1)->where('location_id', 10)->orWhere('unit_id', 13)->orWhere('unit_id', 14)->get();
         $overtimes = Overtime::orderBy('updated_at', 'desc')->where('location_id', 2)->paginate(2000);
         // dd($overtimes);
      } else {

         $employees = Employee::where('status', 1)->get();
         $overtimes = Overtime::orderBy('updated_at', 'desc')->paginate(1000);
      }

      


      // $employee = Employee::find(301);
      // $spkl_type = $employee->unit->spkl_type;
      // $hour_type = $employee->unit->hour_type;
      // $payroll = Payroll::find($employee->payroll_id);


      // $overtimes = Overtime::where('employee_id', '301')->orderBy('created_at', 'desc')->get();
      // foreach($overtimes as $over){
      //    $rate = $this->calculateRate($payroll, $over->type, $spkl_type, $hour_type, $over->hours, $over->holiday_type);
         
      //    if ($over->holiday_type == 1) {
      //       $finalHour = $over->hours;
      //       if ($hour_type == 2) {
      //          // dd('test');
      //          $multiHours = $over->hours - 1;
      //          $finalHour = $multiHours * 2 + 1.5;
      //          // dd($finalHour);
      //       }
      //    } elseif ($over->holiday_type == 2) {
      //       $finalHour = $over->hours * 2;
      //    } elseif ($over->holiday_type == 3) {
      //       $finalHour = $over->hours * 2;
      //    } elseif ($over->holiday_type == 4) {
      //       $finalHour = $over->hours * 3;
      //    }

      //    $over->update([
      //       'hours_final' => $finalHour,
      //       'rate' => round($rate),
      //    ]);
      // }

      


      
      




      // $debugOver = Overtime::find(713);
      // $employee = Employee::find($debugOver->employee_id);
      // $payroll = Payroll::find($employee->payroll_id);
      // $spkl_type = $employee->unit->spkl_type;
      // $newRate = $this->calculateRate($payroll, $debugOver->type, $spkl_type, $debugOver->hour_type, $debugOver->hours, $debugOver->holiday_type);
      // dd($newRate);

      // foreach($overtimes as $over){
      //    $employee = Employee::find($over->employee_id);
      //    $payroll = Payroll::find($employee->payroll_id);
      //    $spkl_type = $employee->unit->spkl_type;
      //    $newRate = $this->calculateRate($payroll, $over->type, $spkl_type, $over->hour_type, $over->hours, $over->holiday_type);

      //    $over->update([
      //       'rate' => $newRate
      //    ]);
      // }
      // $testOver = Overtime::find(1);

      // dd('ok');



      // foreach ($overtimes as $over) {
      //    $employee = Employee::find($over->employee_id);
      //    $spkl_type = $employee->unit->spkl_type;
      //    $hour_type = $employee->unit->hour_type;
      //    $payroll = Payroll::find($employee->payroll_id);
      //    $rate = $this->calculateRate($payroll, $over->type, $spkl_type, $hour_type, $over->hours, $over->holiday_type);

      //    $over->update([
      //       'rate' => $rate
      //    ]);

      //    $transactionCon = new TransactionController;
      //    $transactions = Transaction::where('status', '!=', 3)->where('employee_id', $employee->id)->get();

      //    foreach ($transactions as $tran) {
      //       $transactionCon->calculateTotalTransaction($tran, $tran->cut_from, $tran->cut_to);
      //    }

      //    // if ($over->hours == 0) {
      //    //    $over->delete();
      //    // }
      // }



      // $transactionReductions = TransactionReduction::get();
      // foreach ($transactionReductions as $tr) {
      //    $transaction = Transaction::find($tr->transaction_id);
      //    $tr->update([
      //       'month' => $transaction->month,
      //       'year' => $transaction->year
      //    ]);
      // }
      // if (auth()->user()->hasRole('HRD-KJ12')) {
      //    $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
      //       ->where('contracts.loc', 'kj1-2')
      //       ->select('employees.*')
      //       ->get();
      // } elseif (auth()->user()->hasRole('HRD-KJ45')) {
      //    $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
      //       ->where('contracts.loc', 'kj4')->orWhere('contracts.loc', 'kj5')
      //       ->select('employees.*')
      //       ->get();
      // } else {
      //    $employees = Employee::get();
      // }
      // $employees = Employee::get();
      // $holidays = Holiday::orderBy('date', 'asc')->get();
      // dd($overtimes);
      // dd('ok');
      return view('pages.payroll.overtime.employee', [
         'export' => $export,
         'loc' => $loc,
         'from' => 0,
         'to' => 0,
         'locations' => $locations,
         'overtimes' => $overtimes,
         'employees' => $employees,
         'month' => $now->format('F'),
         'year' => $now->format('Y'),
         // 'holidays' => $holidays
      ])->with('i');
   }

   public function indexEmployee()
   {

      $now = Carbon::now();
     

      $export = false;
      $loc = 'All';
      $locations = Location::get();

      


      if (auth()->user()->hasRole('HRD-KJ12')) {
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj1-2')
            ->select('employees.*')
            ->get();

         
      } elseif (auth()->user()->hasRole('HRD-KJ45')) {

         // dd('ok');
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj4')->orWhere('contracts.loc', 'kj5')
            ->select('employees.*')
            ->get();
         
      } elseif (auth()->user()->hasRole('HRD-JGC')) {

         // dd('ok');
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'jgc')
            ->select('employees.*')
            ->get();
         
      } else {

         $employees = Employee::where('status', 1)->get();
      }


      return view('pages.payroll.overtime.employee', [
         
         'employees' => $employees,
      ])->with('i');
   }

   public function indexEmployeeDetail($id, $from, $to)
   {
      $employee = Employee::find(dekripRambo($id));
      $now = Carbon::now();
     

      $export = false;
      $loc = 'All';
      $locations = Location::get();

      if ($from == 0) {
         $overtimes = Overtime::where('employee_id', $employee->id)->orderBy('updated_at', 'desc')->get();
      } else {
         $overtimes = Overtime::where('employee_id', $employee->id)->whereBetween('date', [$from, $to])->orderBy('updated_at', 'desc')->get();
      }
      


      return view('pages.payroll.overtime.employee-detail', [
         'from' => $from,
         'to' => $to,
         'employee' => $employee,
         'overtimes' => $overtimes,
      ])->with('i');
   }


   public function refresh(){
      // dd('ok');
      $overtimes = Overtime::where('type', 2)->get();
      
      foreach($overtimes as $over){
         if ($over->holiday_type == 1) {
            $finalHour = 1 ;
            
         } elseif ($over->holiday_type == 2) {
            // $rate = 1 * $rateOvertime;
            $finalHour = 1 ;
            // dd($rate);
         } elseif ($over->holiday_type == 3) {
            $finalHour = 2 ;
         } elseif ($over->holiday_type == 4) {
            $finalHour = 3 ;
         }

         $over->update([
            'hours' => $finalHour,
            'hours_final' => $finalHour
         ]);
      }



      // foreach($employees as $emp){
      //    $duplicated = DB::table('overtimes')->where('type', 2)->where('employee_id', $emp->id)
      //               ->select('date', DB::raw('count(`date`) as occurences'))
      //               ->groupBy('date')
      //               ->having('occurences', '>', 1)
      //               ->get();

      //    foreach($duplicated as $dup){
      //       // dd($dup->date);
      //       $overtime = Overtime::where('type', 2)->where('employee_id', $emp->id)->where('date', $dup->date)->first();
      //       $overtime->delete();
      //    }
      // }

      // $duplicated = DB::table('overtimes')->where('type', 1)->where('employee_id', 150)
      //               ->select('date', DB::raw('count(`date`) as occurences'))
      //               ->groupBy('date')
      //               ->having('occurences', '>', 1)
      //               ->get();

      //    foreach($duplicated as $dup){
      //       // dd($dup->date);
      //       $overtime = Overtime::where('type', 1)->where('employee_id', 150)->where('date', $dup->date)->where('description', null)->first();
      //       $overtime->delete();
      //    }

      
      
      // dd($overtimes);



      // foreach($employees as $emp){
      //    $payroll = Payroll::find($emp->payroll_id);
      //    $hourType = $emp->unit->hour_type;
      //    $spklType = $emp->unit->spkl_type;

      //    if ($hourType == 2) {
      //       $overtimes = Overtime::where('employee_id', $emp->id)->get();
      //       foreach($overtimes as $over){
      //          $rate = $this->calculateRate($payroll, $over->type, $spklType, $hourType, $over->hours, $over->holiday_type);

      //          if ($over->holiday_type == 1) {
      //             $finalHour = $over->hours;
      //             if ($hourType == 2) {
      //                $multiHours = $over->hours - 1;
      //                $finalHour = $multiHours * 2 + 1.5;
      //             }
      //          } elseif ($over->holiday_type == 2){
      //             $finalHour = $over->hours * 2;
      //          } elseif ($over->holiday_type == 3){
      //             $finalHour = $over->hours * 2;
      //          } elseif ($over->holiday_type == 4){
      //             $finalHour = $over->hours * 3;
      //          }

      //          $over->update([
      //             'hours_final' => $finalHour,
      //             'rate' => round($rate)
      //          ]);
      //       }
      //    } else {
      //       $overtimes = Overtime::where('employee_id', $emp->id)->get();
      //       foreach($overtimes as $over){
      //          $rate = $this->calculateRate($payroll, $over->type, $spklType, $hourType, $over->hours, $over->holiday_type);

               

      //          $over->update([
      //             // 'hours_final' => $finalHour,
      //             'rate' => round($rate)
      //          ]);
      //       }
      //    }
      // }

      // foreach()


      // $emp = Employee::find(17);
      // $payroll = Payroll::find($emp->payroll_id);
      // $hourType = $emp->unit->hour_type;
      // $spklType = $emp->unit->spkl_type;

      // if ($hourType == 2) {
      //    $overtimes = Overtime::where('employee_id', $emp->id)->get();
      //    foreach($overtimes as $over){
      //       $rate = $this->calculateRate($payroll, $over->type, $spklType, $hourType, $over->hours, $over->holiday_type);

      //       if ($over->holiday_type == 1) {
      //          $finalHour = $over->hours;
      //          if ($hourType == 2) {
      //             $multiHours = $over->hours - 1;
      //             $finalHour = $multiHours * 2 + 1.5;
      //          }
      //       } elseif ($over->holiday_type == 2){
      //          $finalHour = $over->hours * 2;
      //       } elseif ($over->holiday_type == 3){
      //          $finalHour = $over->hours * 2;
      //       } elseif ($over->holiday_type == 4){
      //          $finalHour = $over->hours * 3;
      //       }

      //       $over->update([
      //          'hours_final' => $finalHour,
      //          'rate' => round($rate)
      //       ]);
      //    }
      // }

      return redirect()->back()->with('success', 'Data SPKL Refreshed');




   }

   public function create(){
      $now = Carbon::now();
      // $overtimes = Overtime::get();


      if (auth()->user()->hasRole('HRD-KJ12')) {
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj1-2')
            ->where('employees.status', 1)
            ->select('employees.*')
            ->get();

         $overtimes = Overtime::orderBy('created_at', 'desc')->where('location_id', 3)->paginate(800);
      } elseif (auth()->user()->hasRole('HRD-KJ45')) {

         // dd('ok');
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj4')->orWhere('contracts.loc', 'kj5')
            ->where('employees.status', 1)
            ->select('employees.*')
            ->get();
         $overtimes = Overtime::orderBy('created_at', 'desc')->where('location_id', 4)->orWhere('location_id', 5)->paginate(800);
         // dd($overtimes);
      } elseif (auth()->user()->hasRole('HRD-JGC')) {

         // dd('ok');
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'jgc')
            ->where('employees.status', 1)
            ->select('employees.*')
            ->get();
         $overtimes = Overtime::orderBy('updated_at', 'desc')->where('location_id', 2)->paginate(2000);
         // dd($overtimes);
      } else {

         $employees = Employee::where('status', 1)->get();
         $overtimes = Overtime::orderBy('created_at', 'desc')->paginate(800);
      }

      return view('pages.payroll.overtime.create', [
         'overtimes' => $overtimes,
         'employees' => $employees,
         'month' => $now->format('F'),
         'year' => $now->format('Y'),
         'from' => null,
         'to' => null
         // 'holidays' => $holidays
      ])->with('i');
   }

   public function import(){
      $now = Carbon::now();
      // $overtimes = Overtime::get();


      // if (auth()->user()->hasRole('HRD-KJ12')) {
      //    $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
      //       ->where('contracts.loc', 'kj1-2')
      //       ->select('employees.*')
      //       ->get();

      //    $overtimes = Overtime::orderBy('created_at', 'desc')->where('location_id', 3)->paginate(800);
      // } elseif (auth()->user()->hasRole('HRD-KJ45')) {

      //    // dd('ok');
      //    $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
      //       ->where('contracts.loc', 'kj4')->orWhere('contracts.loc', 'kj5')
      //       ->select('employees.*')
      //       ->get();
      //    $overtimes = Overtime::orderBy('created_at', 'desc')->where('location_id', 4)->orWhere('location_id', 5)->paginate(800);
      //    // dd($overtimes);
      // } else {

      //    $employees = Employee::get();
      //    $overtimes = Overtime::orderBy('created_at', 'desc')->paginate(800);
      // }

      return view('pages.payroll.overtime.import', [
         // 'overtimes' => $overtimes,
         // 'employees' => $employees,
         // 'month' => $now->format('F'),
         // 'year' => $now->format('Y'),
         // 'from' => null,
         // 'to' => null
         // 'holidays' => $holidays
      ])->with('i');
   }

   public function draft(){
      $now = Carbon::now();
      // $overtimes = Overtime::get();

      


      if (auth()->user()->hasRole('HRD-KJ12')) {
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj1-2')
            ->select('employees.*')
            ->get();

         $overtimes = Overtime::where('status', 0)->orderBy('created_at', 'desc')->where('location_id', 3)->paginate(800);
      } elseif (auth()->user()->hasRole('HRD-KJ45')) {

         // dd('ok');
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj4')->orWhere('contracts.loc', 'kj5')
            ->select('employees.*')
            ->get();
         $overtimes = Overtime::where('status', 0)->orderBy('created_at', 'desc')->where('location_id', 4)->orWhere('location_id', 5)->paginate(800);
         // dd($overtimes);
      } else {

         $employees = Employee::get();
         $overtimes = Overtime::where('status', 0)->orderBy('created_at', 'desc')->paginate();
      }
      // dd('ok');

      return view('pages.payroll.overtime.draft', [
         'overtimes' => $overtimes,
         'employees' => $employees,
         'month' => $now->format('F'),
         'year' => $now->format('Y'),
         'from' => null,
         'to' => null
         // 'holidays' => $holidays
      ])->with('i');
   }

   public function draftDelete(){
      $now = Carbon::now();
      // $overtimes = Overtime::get();

      


      if (auth()->user()->hasRole('HRD-KJ12')) {
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj1-2')
            ->select('employees.*')
            ->get();

         $overtimes = Overtime::orderBy('created_at', 'desc')->where('location_id', 3)->paginate(800);
      } elseif (auth()->user()->hasRole('HRD-KJ45')) {

         // dd('ok');
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj4')->orWhere('contracts.loc', 'kj5')
            ->select('employees.*')
            ->get();
         $overtimes = Overtime::orderBy('created_at', 'desc')->where('location_id', 4)->orWhere('location_id', 5)->paginate(800);
         // dd($overtimes);
      } else {

         $employees = Employee::get();
         $overtimes = Overtime::where('status', 0)->orderBy('created_at', 'desc')->paginate(12);
      }

      return view('pages.payroll.overtime.draft-delete', [
         'overtimes' => $overtimes,
         'employees' => $employees,
         'month' => $now->format('F'),
         'year' => $now->format('Y'),
         'from' => null,
         'to' => null
         // 'holidays' => $holidays
      ])->with('i');
   }

   public function indexDelete(){
      $now = Carbon::now();
      // $overtimes = Overtime::get();

      


      if (auth()->user()->hasRole('HRD-KJ12')) {
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj1-2')
            ->select('employees.*')
            ->get();

         $overtimes = Overtime::orderBy('created_at', 'desc')->where('location_id', 3)->paginate(800);
      } elseif (auth()->user()->hasRole('HRD-KJ45')) {

         // dd('ok');
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj4')->orWhere('contracts.loc', 'kj5')
            ->select('employees.*')
            ->get();
         $overtimes = Overtime::orderBy('created_at', 'desc')->where('location_id', 4)->orWhere('location_id', 5)->paginate(800);
         // dd($overtimes);
      } else {

         $employees = Employee::get();
         $overtimes = Overtime::where('status', 1)->orderBy('created_at', 'desc')->paginate(1500);
      }

      return view('pages.payroll.overtime.index-delete', [
         'overtimes' => $overtimes,
         'employees' => $employees,
         'month' => $now->format('F'),
         'year' => $now->format('Y'),
         'from' => null,
         'to' => null
         // 'holidays' => $holidays
      ])->with('i');
   }

   public function indexDeleteFilter(Request $req){
      $now = Carbon::now();
      // $overtimes = Overtime::get();

      


      $overtimes = Overtime::whereBetween('date', [$req->from, $req->to])->get();

      return view('pages.payroll.overtime.index-delete-filter', [
         'overtimes' => $overtimes,
         // 'employees' => $employees,
         'month' => $now->format('F'),
         'year' => $now->format('Y'),
         'from' => $req->from,
         'to' => $req->to
         // 'holidays' => $holidays
      ])->with('i');
   }

   public function publish(Request $req)
   {
      $req->validate([
         'id_item' => 'required',
      ]);

      $arrayItem = $req->id_item;
      $jumlah = count($arrayItem);

      for ($i = 0; $i < $jumlah; $i++) {
         $overtime = Overtime::find($arrayItem[$i]);

         $overtime->update([
            'status' => 1,
            // 'user_id' => $user->id
         ]);

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
         'action' => 'Publish',
         'desc' => 'SPKL Data'
      ]);
      return redirect()->route('payroll.overtime')->with('success', 'SPKL Data successfully published');
   }

   public function edit($id){

      $employees = Employee::where('status', 1)->get();
      $overtime = Overtime::find(dekripRambo($id));

      return view('pages.payroll.overtime.edit', [
         'employees' => $employees,
         'overtime' => $overtime
      ]);
   }


   // public function import()
   // {

   //    $now = Carbon::now();
   //    $overtimes = Overtime::where('month', $now->format('F'))->where('year', $now->format('Y'))->orderBy('date', 'desc')->get();


   //    $employees = Employee::get();


   //    // $holidays = Holiday::orderBy('date', 'asc')->get();
   //    return view('pages.payroll.overtime-import', [
   //       'overtimes' => $overtimes,
   //       'employees' => $employees,
   //       'month' => $now->format('F'),
   //       'year' => $now->format('Y')
   //       // 'holidays' => $holidays
   //    ])->with('i');
   // }

   public function importStore(Request $req)
   {

      $req->validate([
         'excel' => 'required'
      ]);
      $file = $req->file('excel');
      $fileName = $file->getClientOriginalName();
      $file->move('OvertimeData', $fileName);

      try {
         // Excel::import(new CargoItemImport($parent->id), $req->file('file-cargo'));
         Excel::import(new OvertimesImport, public_path('/OvertimeData/' . $fileName));
      } catch (Exception $e) {
         return redirect()->back()->with('danger', 'Import Failed ' . $e->getMessage());
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
         'action' => 'Import',
         'desc' => 'Data SPKL '
      ]);


      return redirect()->route('payroll.overtime.draft')->with('success', 'Overtime Data successfully imported');
   }


   public function filter(Request $req)
   {
      $req->validate([]);

      // $employees = Employee::get();

      // if ($req->month == 'all') {
      //    if ($req->year == 'all') {
      //       $overtimes = Overtime::orderBy('date', 'desc')->get();
      //    } else {
      //       // dd('ok');
      //       $overtimes = Overtime::where('year', $req->year)->orderBy('date', 'desc')->get();
      //    }
      // } elseif ($req->year == 'all') {
      //    if ($req->month == 'all') {
      //       $overtimes = Overtime::orderBy('date', 'desc')->get();
      //    } else {
      //       $overtimes = Overtime::where('month', $req->month)->orderBy('date', 'desc')->get();
      //    }
      // } else {
      //    $overtimes = Overtime::where('month', $req->month)->where('year', $req->year)->orderBy('date', 'desc')->get();
      // }

      // dd($req->loc);

      if (auth()->user()->hasRole('HRD-KJ12')) {
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj1-2')
            ->select('employees.*')
            ->get();

         $overtimes = Overtime::whereBetween('date', [$req->from, $req->to])->orderBy('updated_at', 'desc')->where('location_id', 3)->paginate(2000);
      } elseif (auth()->user()->hasRole('HRD-KJ45')) {

         // dd('ok');
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj4')->orWhere('contracts.loc', 'kj5')
            ->select('employees.*')
            ->get();
         $overtimes = Overtime::whereBetween('date', [$req->from, $req->to])->orderBy('updated_at', 'desc')->where('location_id', 4)->orWhere('location_id', 5)->paginate(2000);
         // dd($overtimes);
      } elseif (auth()->user()->hasRole('HRD-JGC')) {

         // dd('ok');
         // $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
         //    ->where('contracts.loc', 'jgc')
         //    ->select('employees.*')
         //    ->get();
         $overtimes = Overtime::whereBetween('date', [$req->from, $req->to])->orderBy('updated_at', 'desc')->where('location_id', 2)->paginate(2000);
         // dd($overtimes);
      } else {

         // $employees = Employee::get();
         $overtimes = Overtime::whereBetween('date', [$req->from, $req->to])->orderBy('updated_at', 'desc')->paginate(1000);
      }

      if ($req->loc == 'KJ45') {
         $overtimes = Overtime::whereBetween('date', [$req->from, $req->to])->where('location_id', 4)->orWhere('location_id', 5)->get();
      } else {
         $overtimes = Overtime::whereBetween('date', [$req->from, $req->to])->get();
      }


      $loc = $req->loc;
      $employees = Employee::get();
      $export = true;
      return view('pages.payroll.overtime.index', [
         'loc' => $loc,
         'export' => $export,
         'overtimes' => $overtimes,
         'employees' => $employees,
         'month' => $req->month,
         'year' => $req->year,
         'from' => $req->from,
         'to' => $req->to
      ])->with('i');
   }

   public function filterEmployee(Request $req)
   {
      $req->validate([]);

      // $employees = Employee::get();

      // if ($req->month == 'all') {
      //    if ($req->year == 'all') {
      //       $overtimes = Overtime::orderBy('date', 'desc')->get();
      //    } else {
      //       // dd('ok');
      //       $overtimes = Overtime::where('year', $req->year)->orderBy('date', 'desc')->get();
      //    }
      // } elseif ($req->year == 'all') {
      //    if ($req->month == 'all') {
      //       $overtimes = Overtime::orderBy('date', 'desc')->get();
      //    } else {
      //       $overtimes = Overtime::where('month', $req->month)->orderBy('date', 'desc')->get();
      //    }
      // } else {
      //    $overtimes = Overtime::where('month', $req->month)->where('year', $req->year)->orderBy('date', 'desc')->get();
      // }

      // dd($req->loc);

      if (auth()->user()->hasRole('HRD-KJ12')) {
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj1-2')
            ->select('employees.*')
            ->get();

         $employees = Employee::where('status', 1)->where('location_id', 3)->get();

         $overtimes = Overtime::whereBetween('date', [$req->from, $req->to])->orderBy('updated_at', 'desc')->where('location_id', 3)->paginate(2000);
      } elseif (auth()->user()->hasRole('HRD-KJ45')) {

         // dd('ok');
         $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            ->where('contracts.loc', 'kj4')->orWhere('contracts.loc', 'kj5')
            ->select('employees.*')
            ->get();

            $employees = Employee::where('status', 1)->where('location_id', 4)->orWhere('location_id', 5)->get();
         $overtimes = Overtime::whereBetween('date', [$req->from, $req->to])->orderBy('updated_at', 'desc')->where('location_id', 4)->orWhere('location_id', 5)->paginate(2000);
         // dd($overtimes);
      } elseif (auth()->user()->hasRole('HRD-JGC')) {

         // dd('ok');
         // $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
         //    ->where('contracts.loc', 'jgc')
         //    ->select('employees.*')
         //    ->get();
         $employees = Employee::where('status', 1)->where('location_id', 10)->orWhere('unit_id', 13)->orWhere('unit_id', 14)->get();
         $overtimes = Overtime::whereBetween('date', [$req->from, $req->to])->orderBy('updated_at', 'desc')->where('location_id', 2)->paginate(2000);
         // dd($overtimes);
      } else {

         // $employees = Employee::get();
         $employees = Employee::where('status', 1)->get();
         $overtimes = Overtime::whereBetween('date', [$req->from, $req->to])->orderBy('updated_at', 'desc')->paginate(1000);
      }

      if ($req->loc == 'KJ45') {
         $overtimes = Overtime::whereBetween('date', [$req->from, $req->to])->where('location_id', 4)->orWhere('location_id', 5)->get();
      } else {
         $overtimes = Overtime::whereBetween('date', [$req->from, $req->to])->get();
      }


      $loc = $req->loc;
      // $employees = Employee::get();
      $export = true;
      
      return view('pages.payroll.overtime.employee', [
         'loc' => $loc,
         'from' => $req->from,
         'to' => $req->to,
         'export' => $export,
         'overtimes' => $overtimes,
         'employees' => $employees,
         'month' => $req->month,
         'year' => $req->year,
         'from' => $req->from,
         'to' => $req->to
      ])->with('i');
   }

   public function overtimeExcel($from, $to, $loc){
      // dd($loc);
      return Excel::download(new OvertimeExport($from, $to, $loc), 'spkl-' . $loc .'-' . $from  .'- '. $to .'.xlsx');
   }


   public function store(Request $req)
   {
      // dd('ok');
      // $req->validate([
      //    'doc' => 'required|image|mimes:jpg,jpeg,png|max:5120',
      // ]);
      // dd($req->holiday_type);
      // dd($req->employee);

      $employee = Employee::find($req->employee);
      $transaction = Transaction::find($req->transaction);
      $spkl_type = $employee->unit->spkl_type;
      $hour_type = $employee->unit->hour_type;
      $payroll = Payroll::find($employee->payroll_id);

      // Cek jika karyawan tsb blm di set payroll
      if (!$payroll) {
         return redirect()->route('payroll.overtime')->with('danger', $employee->nik . ' ' . $employee->biodata->fullName() . ' belum ada data Gaji Karyawan');
      }

      // dd($hour_type);

      $locations = Location::get();
      $locId = null;
      foreach ($locations as $loc) {
         if ($loc->code == $employee->contract->loc) {
            $locId = $loc->id;
         }
      }



      $rate = $this->calculateRate($payroll, $req->type, $spkl_type, $hour_type, $req->hours, $req->holiday_type);

      if (request('doc')) {
         $doc = request()->file('doc')->store('doc/overtime');
      } else {
         $doc = null;
      }

      // $hoursFinal = 0;
      if ($req->holiday_type == 1) {
         $finalHour = $req->hours;
         if ($hour_type == 2) {
            // dd('test');
            $multiHours = $req->hours - 1;
            $finalHour = $multiHours * 2 + 1.5;
            // dd($finalHour);
         }
      } elseif ($req->holiday_type == 2) {
         $finalHour = $req->hours * 2;
      } elseif ($req->holiday_type == 3) {
         $finalHour = $req->hours * 2;
         // $employee = Employee::where('payroll_id', $payroll->id)->first();
            if ($employee->unit_id ==  7 || $employee->unit_id ==  8 || $employee->unit_id ==  9) {
               // dd('ok');
               if ($req->hours <= 7) {
                  $finalHour = $req->hours * 2;
               } else{
                  // dd('ok');
                  $hours7 = 14;
                  $sisa1 = $req->hours - 7;
                  $hours8 = 3;
                  if ($sisa1 > 1) {
                     $sisa2 = $sisa1 - 1;
                     $hours9 = $sisa2 * 4;
                  } else {
                     $hours9 = 0;
                  }
   
                  $finalHour = $hours7 + $hours8 + $hours9;
                  // dd($finalHour);

               }
            } else {
               if ($req->hours <= 8) {
                  $finalHour = $req->hours * 2;
               } else{
                  $hours8 = 16;
                  $sisa1 = $req->hours - 8;
                  $hours9 = 3;
                  if ($sisa1 > 1) {
                     $sisa2 = $sisa1 - 1;
                     $hours10 = $sisa2 * 4;
                  } else {
                     $hours10 = 0;
                  }
   
                  $finalHour = $hours8 + $hours9 + $hours10;
               }
            }
      } elseif ($req->holiday_type == 4) {
         $finalHour = $req->hours * 3;
      }

      if ($req->type == 1) {
         $hours = $req->hours;
         $finalHour = $finalHour;
      } else {
         if ($req->holiday_type == 1) {
            $finalHour = 1 ;
            
         } elseif ($req->holiday_type == 2) {
            // $rate = 1 * $rateOvertime;
            $finalHour = 1 ;
            // dd($rate);
         } elseif ($req->holiday_type == 3) {
            $finalHour = 2 ;
         } elseif ($req->holiday_type == 4) {
            $finalHour = 3 ;
         }

         $hours = $finalHour;
      }

      // dd($finalHour);

      
      $current = Overtime::where('type', $req->type)->where('employee_id', $employee->id)->where('date', $req->date)->where('description', $req->desc)->first();

      if ($current) {
         return redirect()->back()->with('danger', 'Data SPKL sudah ada.');
      }

      
   

      $date = Carbon::create($req->date);

      $overtime = Overtime::create([
         'status' => 1,
         'location_id' => $locId,
         'employee_id' => $employee->id,
         'month' => $date->format('F'),
         'year' => $date->format('Y'),
         'date' => $req->date,
         'type' => $req->type,
         'hour_type' => $hour_type,
         'holiday_type' => $req->holiday_type,
         'hours' => $hours,
         'hours_final' => $finalHour,
         'rate' => round($rate),
         'description' => $req->desc,
         'doc' => $doc
      ]);

      // $overtimes = Overtime::where('month', $transaction->month)->get();
      // $totalOvertime = $overtimes->sum('rate');
      // $transactionCon = new TransactionController;
      // $transactions = Transaction::where('status', '!=', 3)->where('employee_id', $employee->id)->get();

      // foreach ($transactions as $tran) {
      //    $transactionCon->calculateTotalTransaction($tran, $tran->cut_from, $tran->cut_to);
      // }

      // dd($overtime->id);

      if (auth()->user()->hasRole('Administrator')) {
         $departmentId = null;
      } else {
         $user = Employee::find(auth()->user()->getEmployeeId());
         $departmentId = $user->department_id;
      }
      Log::create([
         'department_id' => $departmentId,
         'user_id' => auth()->user()->id,
         'action' => 'Add',
         'desc' => 'Data SPKL ' . $overtime->id . ' ' . $employee->nik . ' ' . $employee->biodata->fullName()
      ]);



      return redirect()->back()->with('success', 'Overtime Data successfully added');
   }


   public function update(Request $req)
   {
      // // dd('ok');
      // $req->validate([
      //    'doc' => 'required|image|mimes:jpg,jpeg,png|max:5120',
      // ]);

      $overtime = Overtime::find($req->overtimeId);

      $employee = Employee::find($req->employee);
      $spkl_type = $employee->unit->spkl_type;
      $hour_type = $employee->unit->hour_type;
      $payroll = Payroll::find($employee->payroll_id);

     

      // dd($hour_type);

      $locations = Location::get();
      $locId = null;
      foreach ($locations as $loc) {
         if ($loc->code == $employee->contract->loc) {
            $locId = $loc->id;
         }
      }



      $rate = $this->calculateRate($payroll, $req->type, $spkl_type, $hour_type, $req->hours, $req->holiday_type);

      if (request('doc')) {
         $doc = request()->file('doc')->store('doc/overtime');
      } else {
         $doc = null;
      }

      // $hoursFinal = 0;
      if ($req->holiday_type == 1) {
         $finalHour = $req->hours;
         if ($hour_type == 2) {
            // dd('test');
            $multiHours = $req->hours - 1;
            $finalHour = $multiHours * 2 + 1.5;
            // dd($finalHour);
         }
      } elseif ($req->holiday_type == 2) {
         $finalHour = $req->hours * 2;
      } elseif ($req->holiday_type == 3) {
         $finalHour = $req->hours * 2;
      } elseif ($req->holiday_type == 4) {
         $finalHour = $req->hours * 3;
      }

      if ($req->type == 1) {
         $finalHour = $finalHour;
      } else {

      }

      // dd($finalHour);

      
      // $current = Overtime::where('type', $req->type)->where('employee_id', $employee->id)->where('date', $req->date)->where('description', $req->desc)->first();

      // if ($current) {
      //    return redirect()->back()->with('danger', 'Data SPKL sudah ada.');
      // }

      


      $date = Carbon::create($req->date);

      $overtime->update([
         'location_id' => $locId,
         'employee_id' => $employee->id,
         'month' => $date->format('F'),
         'year' => $date->format('Y'),
         'date' => $req->date,
         'type' => $req->type,
         'hour_type' => $hour_type,
         'holiday_type' => $req->holiday_type,
         'hours' => $req->hours,
         'hours_final' => $finalHour,
         'rate' => round($rate),
         'description' => $req->desc,
         'doc' => $doc
      ]);

      // $overtimes = Overtime::where('month', $transaction->month)->get();
      // $totalOvertime = $overtimes->sum('rate');
      $transactionCon = new TransactionController;
      $transactions = Transaction::where('status', '!=', 3)->where('employee_id', $employee->id)->get();

      foreach ($transactions as $tran) {
         $transactionCon->calculateTotalTransaction($tran, $tran->cut_from, $tran->cut_to);
      }

      if (auth()->user()->hasRole('Administrator')) {
         $departmentId = null;
      } else {
         $user = Employee::find(auth()->user()->getEmployeeId());
         $departmentId = $user->department_id;
      }
      // dd($overtime->id);
      Log::create([
         'department_id' => $departmentId,
         'user_id' => auth()->user()->id,
         'action' => 'Update',
         'desc' => 'Data SPKL ' . $employee->nik . ' ' . $employee->biodata->fullName()
      ]);



      return redirect()->back()->with('success', 'Overtime Data successfully added');
   }






   public function calculateRate($payroll, $type, $spkl_type, $hour_type,  $hours, $holiday_type)
   {
      if ($type == 1) {
         // jika lembur
         // dd('lembur');

         if ($spkl_type == 1) {
            $rateOvertime = $payroll->pokok / 173;
         } else if ($spkl_type == 2) {
            $rateOvertime = $payroll->total / 173;
         }

         // dd($rateOvertime);

         // dd($rateOvertime);

         if ($holiday_type == 1) {
            $finalHour = $hours;
         } elseif ($holiday_type == 2) {
            $finalHour = $hours;
         } elseif ($holiday_type == 3) {
            $employee = Employee::where('payroll_id', $payroll->id)->first();
            if ($employee->unit_id ==  7 || $employee->unit_id ==  8 || $employee->unit_id ==  9) {
               // dd('ok');
               if ($hours <= 7) {
                  $finalHour = $hours * 2;
               } else{
                  // dd('ok');
                  $hours7 = 14;
                  $sisa1 = $hours - 7;
                  $hours8 = 3;
                  if ($sisa1 > 1) {
                     $sisa2 = $sisa1 - 1;
                     $hours9 = $sisa2 * 4;
                  } else {
                     $hours9 = 0;
                  }
   
                  $finalHour = $hours7 + $hours8 + $hours9;
                  // dd($finalHour);

               }
            } else {
               if ($hours <= 8) {
                  $finalHour = $hours * 2;
               } else{
                  $hours8 = 16;
                  $sisa1 = $hours - 8;
                  $hours9 = 3;
                  if ($sisa1 > 1) {
                     $sisa2 = $sisa1 - 1;
                     $hours10 = $sisa2 * 4;
                  } else {
                     $hours10 = 0;
                  }
   
                  $finalHour = $hours8 + $hours9 + $hours10;
               }
            }
            
            
         } elseif ($holiday_type == 4) {
            $finalHour = $hours * 3;
         }

         if ($hour_type == 1) {
            $rate = $finalHour * round($rateOvertime);
         } else {
            // dd('okee');
            if ($holiday_type == 2) {
               $rate = $finalHour * round($rateOvertime);
            } elseif ($holiday_type == 3) {
               $rate = $finalHour * round($rateOvertime);
            } else {
               // dd($hours);
               $multiHours = $hours - 1;
               $totalHours = $multiHours * 2 + 1.5;
               // dd($totalHours);
               $rate = $totalHours * round($rateOvertime);
               // dd($rateOvertime);
            }
         }

         // dd($finalHour);
      } else {
         // dd('ok');
         $rateOvertime = round(1 / 30 * $payroll->total);
         if ($holiday_type == 1) {
            $rate = 1 * $rateOvertime;
         } elseif ($holiday_type == 2) {
            $rate = 1 * $rateOvertime;
            // dd($rate);
            $rate = 1 * $rateOvertime;
         } elseif ($holiday_type == 3) {
            $rate = 2 * $rateOvertime;
         } elseif ($holiday_type == 4) {
            $rate = 3 * $rateOvertime;
         }
      }


      // dd($finalHour);
      return $rate;
   }

   public function calculateRateB($type, $spkl_type, $hour_type, $payroll, $hours, $holiday_type)
   {



      if ($spkl_type == 1) {
         $rateOvertime = $payroll->pokok / 173;
      } else if ($spkl_type == 2) {
         $rateOvertime = $payroll->total / 173;
      }

      if ($hour_type == 1) {
         $rate = $hours * $rateOvertime;
      } else {
         $multiHours = $hours - 1;
         $totalHours = $multiHours * 2 + 1.5;
         $rate = $totalHours * $rateOvertime;
      }

      return $rate;
   }

   public function delete($id)
   {

      $overtime = Overtime::find(dekripRambo($id));
      $employee = Employee::find($overtime->employee_id);
      Storage::delete($overtime->doc);
      $overtimeId = $overtime->id;
      $overtimeDate = $overtime->date;
      $overtime->delete();

      // $transactionCon = new TransactionController;
      // $transactions = Transaction::where('status', '!=', 3)->where('employee_id', $employee->id)->get();

      // foreach ($transactions as $tran) {
      //    $transactionCon->calculateTotalTransaction($tran, $tran->cut_from, $tran->cut_to);
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
         'action' => 'Delete',
         'desc' => 'Data SPKL date:' . $overtimeDate . ' ' . $employee->nik . ' ' . $employee->biodata->fullName()
      ]);

      // dd('deleted');

      return redirect()->route('payroll.overtime')->with('success', 'Overtime Data successfully deleted');
   }

   public function deleteMultiple(Request $req)
   {
      $req->validate([
         'id_item' => 'required',
      ]);

      $arrayItem = $req->id_item;
      $jumlah = count($arrayItem);

      for ($i = 0; $i < $jumlah; $i++) {
         $overtime = Overtime::find($arrayItem[$i]);

         $overtime->delete();

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
         'action' => 'Delete Multiple',
         'desc' => 'SPKL Data'
      ]);
      return redirect()->back()->with('success', 'SPKL Data deleted');
   }
}
