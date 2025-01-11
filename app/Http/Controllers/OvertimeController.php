<?php

namespace App\Http\Controllers;

use App\Imports\OvertimesImport;
use App\Models\Employee;
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
   public function index()
   {

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
         $overtimes = Overtime::orderBy('created_at', 'desc')->paginate(800);
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
      return view('pages.payroll.overtime', [
         'overtimes' => $overtimes,
         'employees' => $employees,
         'month' => $now->format('F'),
         'year' => $now->format('Y'),
         'from' => null,
         'to' => null
         // 'holidays' => $holidays
      ])->with('i');
   }


   public function refresh(){
      $overtimes = Overtime::get();
      $employees = Employee::get();
      // foreach($employees as $emp){

      // }
      $duplicated = DB::table('overtimes')->where('type', 1)->where('employee_id', 301)
                    ->select('date', DB::raw('count(`date`) as occurences'))
                    ->groupBy('date')
                    ->having('occurences', '>', 1)
                    ->get();

      // foreach($duplicated as $dup){
      //    // dd($dup->date);
      //    $overtime = Overtime::where('type', 1)->where('employee_id', 301)->where('date', $dup->date)->first();
      //    $overtime->delete();
      // }
      dd($duplicated);



   }


   public function import()
   {

      $now = Carbon::now();
      $overtimes = Overtime::where('month', $now->format('F'))->where('year', $now->format('Y'))->orderBy('date', 'desc')->get();


      $employees = Employee::get();


      // $holidays = Holiday::orderBy('date', 'asc')->get();
      return view('pages.payroll.overtime-import', [
         'overtimes' => $overtimes,
         'employees' => $employees,
         'month' => $now->format('F'),
         'year' => $now->format('Y')
         // 'holidays' => $holidays
      ])->with('i');
   }

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


      return redirect()->route('payroll.overtime')->with('success', 'Overtime Data successfully imported');
   }


   public function filter(Request $req)
   {
      $req->validate([]);

      $employees = Employee::get();

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

      $overtimes = Overtime::whereBetween('date', [$req->from, $req->to])->get();
      $employees = Employee::get();
      return view('pages.payroll.overtime', [
         'overtimes' => $overtimes,
         'employees' => $employees,
         'month' => $req->month,
         'year' => $req->year,
         'from' => $req->from,
         'to' => $req->to
      ])->with('i');
   }


   public function store(Request $req)
   {
      // // dd('ok');
      // $req->validate([
      //    'doc' => 'required|image|mimes:jpg,jpeg,png|max:5120',
      // ]);

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
      } elseif ($req->holiday_type == 4) {
         $finalHour = $req->hours * 3;
      }

      if ($req->type == 1) {
         $finalHour = $finalHour;
      } else {

      }

      // dd($finalHour);

      
      $current = Overtime::where('type', $req->type)->where('employee_id', $employee->id)->where('date', $req->date)->where('description', $req->desc)->first();

      if ($current) {
         return redirect()->back()->with('danger', 'Data SPKL sudah ada.');
      }

      


      $date = Carbon::create($req->date);

      $overtime = Overtime::create([
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
      Log::create([
         'department_id' => $departmentId,
         'user_id' => auth()->user()->id,
         'action' => 'Add',
         'desc' => 'Data SPKL ' . $employee->nik . ' ' . $employee->biodata->fullName()
      ]);



      return redirect()->route('payroll.overtime')->with('success', 'Overtime Data successfully added');
   }






   public function calculateRate($payroll, $type, $spkl_type, $hour_type,  $hours, $holiday_type)
   {
      if ($type == 1) {
         // jika lembur


         if ($spkl_type == 1) {
            $rateOvertime = $payroll->pokok / 173;
         } else if ($spkl_type == 2) {
            $rateOvertime = $payroll->total / 173;
         }

         // dd($rateOvertime);

         if ($holiday_type == 1) {
            $finalHour = $hours;
         } elseif ($holiday_type == 2) {
            $finalHour = $hours * 2;
         } elseif ($holiday_type == 3) {
            $finalHour = $hours * 2;
         } elseif ($holiday_type == 4) {
            $finalHour = $hours * 3;
         }

         if ($hour_type == 1) {
            $rate = $finalHour * round($rateOvertime);
            // dd('ok');
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
               // dd($totalHours);
            }
            // dd('finish');
            
         }
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
      Log::create([
         'department_id' => $departmentId,
         'user_id' => auth()->user()->id,
         'action' => 'Delete',
         'desc' => 'Data SPKL date:' . $overtimeDate . ' ' . $employee->nik . ' ' . $employee->biodata->fullName()
      ]);



      return redirect()->route('payroll.overtime')->with('success', 'Overtime Data successfully deleted');
   }
}
