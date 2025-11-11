<?php

namespace App\Http\Controllers;

use App\Imports\PayrollsImport;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Log;
use App\Models\Overtime;
use App\Models\Payroll;
use App\Models\PayrollHistory;
use App\Models\Reduction;
use App\Models\ReductionAdditional;
use App\Models\ReductionEmployee;
use App\Models\Transaction;
use App\Models\Unit;
use App\Models\UnitTransaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PayrollController extends Controller
{

   public function calibrate($unit){
      // dd('ok');
      $units = Unit::get();
      $payrolls = Payroll::get();
      // foreach ($payrolls as $pay) {
      //    $pay->update([
      //       'payslip_status' => 'show'
      //    ]);
      // }
      $employees = Employee::where('status', 1)->where('unit_id', dekripRambo($unit))->get();
      // dd($employees);
      // $transactionCon = new TransactionController;
      // $transactions = Transaction::where('status', '!=', 3)->get();
      // foreach ($transactions as $tran) {
      //    $transactionCon->calculateTotalTransaction($tran, $tran->cut_from, $tran->cut_to);
      // }
      $locations = Location::get();
      foreach($employees as $employee){


         $redEmpExists = ReductionEmployee::where('employee_id', $employee->id)->get();
         // dd($redEmpExists);
         foreach($redEmpExists as $red){
            $red->delete();
         }
         
         
         $payroll = Payroll::find($employee->payroll_id);
         $reductions = Reduction::where('unit_id', $employee->unit_id)->get();


         $redAdditionals = ReductionAdditional::where('employee_id', $employee->id)->get();
         

         foreach ($locations as $loc) {
            if ($loc->code == $employee->contract->loc) {
               $location = $loc->id;
            }
         }
         if ($payroll != null) {
            // dd('ada');
            // if ($employee->unit_id == 9) {
            //    $payTotal = $payroll->pokok;
            // } else {
            //    $payTotal = $payroll->total;
            // }

            $payTotal = $payroll->total;
            foreach ($reductions as $red) {
               $currentRed = ReductionEmployee::where('reduction_id', $red->id)->where('employee_id', $employee->id)->first();
               // dd($red->max_salary);


               if ($payTotal <= $red->min_salary) {
                  // dd('kurang dari minimum gaji');
                  $salary = $red->min_salary;
                  $realSalary = $payTotal;
                  // dd($employee->nik);
   
                  $bebanPerusahaan = ($red->company * $salary) / 100;
                  $bebanKaryawan = ($red->employee * $realSalary) / 100;
                  // dd($bebanKaryawan);
                  $bebanKaryawanReal = ($red->employee * $salary) / 100;
                  $selisih = $bebanKaryawanReal - $bebanKaryawan;
                  // dd($selisih);
                  $bebanPerusahaanReal = $bebanPerusahaan + $selisih;
                  // $bebanKaryawanReal = ($red->reduction->employee * $salary) / 100;
                  // $selisih = $bebanKaryawanReal - $bebanKaryawan;
                  // $bebanPerusahaanReal = $bebanPerusahaan + $selisih;
   
               } else if ($payTotal >= $red->min_salary) {
                  if ($payTotal > $red->max_salary) {
                     // dd('ok');
                     if ($red->max_salary != 0) {
                        $salary = $payTotal;
                        $bebanPerusahaan = ($red->company * $red->max_salary) / 100;
                        $bebanKaryawan = ($red->employee * $red->max_salary) / 100;
                        $bebanKaryawanReal = 0;
                        $bebanPerusahaanReal = $bebanPerusahaan;
                     } else {
                        $salary = $payTotal;
                        $bebanPerusahaan = ($red->company * $salary) / 100;
                        $bebanKaryawan = ($red->employee * $salary) / 100;
                        $bebanKaryawanReal = 0;
                        $bebanPerusahaanReal = $bebanPerusahaan;
                     }
                  } else {
                     $salary = $payTotal;
                     $bebanPerusahaan = ($red->company * $salary) / 100;
                     $bebanKaryawan = ($red->employee * $salary) / 100;
                     $bebanKaryawanReal = 0;
                     $bebanPerusahaanReal = $bebanPerusahaan;
                  }
               }
               // dd($salary);
               // if($employee->unit_id == 9){
               //    if ($payroll->pokok <= $red->min_salary) {
               //       // dd('kurang dari minimum gaji');
               //       $salary = $red->min_salary;
               //       $realSalary = $payroll->pokok;
      
               //       $bebanPerusahaan = ($red->company * $salary) / 100;
               //       $bebanKaryawan = ($red->employee * $realSalary) / 100;
               //       $bebanKaryawanReal = ($red->employee * $salary) / 100;
               //       $selisih = $bebanKaryawanReal - $bebanKaryawan;
               //       $bebanPerusahaanReal = $bebanPerusahaan + $selisih;
               //       // $bebanKaryawanReal = ($red->reduction->employee * $salary) / 100;
               //       // $selisih = $bebanKaryawanReal - $bebanKaryawan;
               //       // $bebanPerusahaanReal = $bebanPerusahaan + $selisih;
      
               //    } else if ($payroll->pokok >= $red->min_salary) {
               //       if ($payroll->pokok > $red->max_salary) {
               //          // dd('ok');
               //          if ($red->max_salary != 0) {
               //             $salary = $payroll->pokok;
               //             $bebanPerusahaan = ($red->company * $red->max_salary) / 100;
               //             $bebanKaryawan = ($red->employee * $red->max_salary) / 100;
               //             $bebanKaryawanReal = 0;
               //             $bebanPerusahaanReal = $bebanPerusahaan;
               //          } else {
               //             $salary = $payroll->pokok;
               //             $bebanPerusahaan = ($red->company * $salary) / 100;
               //             $bebanKaryawan = ($red->employee * $salary) / 100;
               //             $bebanKaryawanReal = 0;
               //             $bebanPerusahaanReal = $bebanPerusahaan;
               //          }
               //       } else {
               //          $salary = $payroll->pokok;
               //          $bebanPerusahaan = ($red->company * $salary) / 100;
               //          $bebanKaryawan = ($red->employee * $salary) / 100;
               //          $bebanKaryawanReal = 0;
               //          $bebanPerusahaanReal = $bebanPerusahaan;
               //       }
               //    }
               // } else {
               //    if ($payroll->total <= $red->min_salary) {
               //       // dd('kurang dari minimum gaji');
               //       $salary = $red->min_salary;
               //       $realSalary = $payroll->total;
      
               //       $bebanPerusahaan = ($red->company * $salary) / 100;
               //       $bebanKaryawan = ($red->employee * $realSalary) / 100;
               //       $bebanKaryawanReal = ($red->employee * $salary) / 100;
               //       $selisih = $bebanKaryawanReal - $bebanKaryawan;
               //       $bebanPerusahaanReal = $bebanPerusahaan + $selisih;
               //       // $bebanKaryawanReal = ($red->reduction->employee * $salary) / 100;
               //       // $selisih = $bebanKaryawanReal - $bebanKaryawan;
               //       // $bebanPerusahaanReal = $bebanPerusahaan + $selisih;
      
               //    } else if ($payroll->total >= $red->min_salary) {
               //       if ($payroll->total > $red->max_salary) {
               //          // dd('ok');
               //          if ($red->max_salary != 0) {
               //             $salary = $payroll->total;
               //             $bebanPerusahaan = ($red->company * $red->max_salary) / 100;
               //             $bebanKaryawan = ($red->employee * $red->max_salary) / 100;
               //             $bebanKaryawanReal = 0;
               //             $bebanPerusahaanReal = $bebanPerusahaan;
               //          } else {
               //             $salary = $payroll->total;
               //             $bebanPerusahaan = ($red->company * $salary) / 100;
               //             $bebanKaryawan = ($red->employee * $salary) / 100;
               //             $bebanKaryawanReal = 0;
               //             $bebanPerusahaanReal = $bebanPerusahaan;
               //          }
               //       } else {
               //          $salary = $payroll->total;
               //          $bebanPerusahaan = ($red->company * $salary) / 100;
               //          $bebanKaryawan = ($red->employee * $salary) / 100;
               //          $bebanKaryawanReal = 0;
               //          $bebanPerusahaanReal = $bebanPerusahaan;
               //       }
               //    }
               // }
   
               // dd($bebanPerusahaan);
               if (!$currentRed) {
                  ReductionEmployee::create([
                     'reduction_id' => $red->id,
                     'type' => 'Default',
                     'location_id' => $location,
                     'employee_id' => $employee->id,
                     'status' => 1,
                     'employee_value' => $bebanKaryawan,
                     'employee_value_real' => $bebanKaryawanReal,
                     'company_value' => $bebanPerusahaan,
                     'company_value_real' => $bebanPerusahaanReal,
   
                  ]);
               } else {
                  $currentRed->update([
                     'reduction_id' => $red->id,
                     'type' => 'Default',
                     'location_id' => $location,
                     'employee_id' => $employee->id,
                     // 'status' => 1,
                     'employee_value' => $bebanKaryawan,
                     'employee_value_real' => $bebanKaryawanReal,
                     'company_value' => $bebanPerusahaan,
                     'company_value_real' => $bebanPerusahaanReal,
                  ]);
               }
            }
            $redEmployees = ReductionEmployee::where('employee_id', $employee->id)->get();
            // dd('ok');
         } else {
            // dd('empty');

            $redEmployees = [];
         }

         // dd($redEmployees);


      }



      return redirect()->back()->with('success', 'Data Payroll selesai di kalibrasi');
   }

   public function index()
   {
      
      
      $firstUnit = Unit::first();
      $employees = Employee::where('status', 1)->where('unit_id', $firstUnit->id)->get();
     

      $units = Unit::get();
      $activeUnit = Unit::get()->first();
      // $allPayrolls = Payroll::get();
         
      //    foreach($allPayrolls as $pay){
      //       $pay->update([
      //          'payslip_status' => 'show'
      //       ]);
      //    }

      //    dd('ok');

      if (auth()->user()->hasRole('Administrator')) {
         # code...
         
      } else {
         $user = Employee::where('nik', auth()->user()->username)->first();
         if ($user->loc == 'Medan') {
            $firstUnit = Unit::find(7);
            $employees = Employee::where('loc', 'Medan')->where('status', 1)->where('unit_id', $firstUnit->id)->get();
            $activeUnit = Unit::where('id', 7)->get()->first();
            $units = Unit::where('id', 7)->get();
         }
      }
      
      return view('pages.payroll.setup.gaji', [
         'employees' => $employees,
         'units' => $units,
         'activeUnit' => $activeUnit
      ])->with('i');

   }

   public function indexUnit($id)
   {
      
      $activeUnit = Unit::find(dekripRambo($id));
      $employees = Employee::where('status', 1)->where('unit_id', $activeUnit->id)->get();
      // $units = Unit::get();

      $units = Unit::get();
      // $transactionCon = new TransactionController;
      // $transactions = Transaction::where('status', '!=', 3)->get();
      // foreach ($transactions as $tran) {
      //    $transactionCon->calculateTotalTransaction($tran, $tran->cut_from, $tran->cut_to);
      // }

      if (auth()->user()->hasRole('Administrator')) {
         # code...
      } else {
         $user = Employee::where('nik', auth()->user()->username)->first();
         if ($user->loc == 'Medan') {
            $firstUnit = Unit::find(7);
            $employees = Employee::where('loc', 'Medan')->where('status', 1)->where('unit_id', $firstUnit->id)->get();
            $activeUnit = Unit::where('id', 7)->get()->first();
            $units = Unit::where('id', 7)->get();
         }
      }

      return view('pages.payroll.setup.gaji', [
         'employees' => $employees,
         'units' => $units,
         'activeUnit' => $activeUnit
      ])->with('i');
   }

   public function import()
   {
      $employees = Employee::where('status', 1)->get();
      $units = Unit::get();
      return view('pages.payroll.setup.import', [
         'employees' => $employees,
         'units' => $units
      ])->with('i');
   }

   public function importStore(Request $req)
   {

      $req->validate([
         'excel' => 'required'
      ]);
      $file = $req->file('excel');
      $fileName = $file->getClientOriginalName();
      $file->move('PayrollData', $fileName);

      try {
         // Excel::import(new CargoItemImport($parent->id), $req->file('file-cargo'));
         Excel::import(new PayrollsImport, public_path('/PayrollData/' . $fileName));
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
         'desc' => 'Payroll Data '
      ]);


      return redirect()->route('payroll')->with('success', 'Payroll Data successfully imported');
   }




   public function unit()
   {
      
      $units = Unit::get();
      $firstUnit = Unit::get()->first();

      if (auth()->user()->hasRole('Administrator')) {
         # code...
      } else {
         $user = Employee::where('nik', auth()->user()->username)->first();
         if ($user->loc == 'Medan') {
            $firstUnit = Unit::find(7);
            
            $units = Unit::where('id', 7)->get();
         }
      }
      return view('pages.payroll.setup.unit', [
         'units' => $units,
         'firstUnit' => $firstUnit
      ])->with('i');
   }

   public function setup()
   {
      $employees = Employee::where('status', 1)->get();
      $units = Unit::get();
      $firstUnit = Unit::get()->first();
      return view('pages.payroll.setup', [
         'employees' => $employees,
         'units' => $units,
         'firstUnit' => $firstUnit
      ])->with('i');
   }

   public function detail($id)
   {

      $employee = Employee::find(dekripRambo($id));
      $payroll = Payroll::find($employee->payroll_id);
      $payrollHistories = PayrollHistory::where('employee_id', $employee->id)->get();
      // dd('ok');
      $reductions = Reduction::where('unit_id', $employee->unit_id)->get();
      // dd($payroll);
      // dd($reductions);

      $redAdditionals = ReductionAdditional::where('employee_id', $employee->id)->get();
      // dd($redAdditionals->sum('employee_value'));

      $locations = Location::get();


      // if (auth()->user()->hasRole('Administrator')) {
      //    $redEmpExists = ReductionEmployee::where('employee_id', $employee->id)->get();
      //    foreach($redEmpExists as $red){
      //       $red->delete();
      //    }
         
         
      //    $payroll = Payroll::find($employee->payroll_id);
      //    $reductions = Reduction::where('unit_id', $employee->unit_id)->get();


      //    $redAdditionals = ReductionAdditional::where('employee_id', $employee->id)->get();
         

      //    foreach ($locations as $loc) {
      //       if ($loc->code == $employee->contract->loc) {
      //          $location = $loc->id;
      //       }
      //    }
      //    if ($payroll != null) {
      //       // dd('ada');
      //       if ($employee->unit_id == 9) {
      //          $payTotal = $payroll->pokok;
      //       } else {
      //          $payTotal = $payroll->total;
      //       }
      //       foreach ($reductions as $red) {
      //          $currentRed = ReductionEmployee::where('reduction_id', $red->id)->where('employee_id', $employee->id)->first();
      //          // dd($red->max_salary);


      //          if ($payTotal <= $red->min_salary) {
      //             // dd('kurang dari minimum gaji');
      //             $salary = $red->min_salary;
      //             $realSalary = $payTotal;
      //             // dd($employee->nik);
   
      //             $bebanPerusahaan = ($red->company * $salary) / 100;
      //             $bebanKaryawan = ($red->employee * $realSalary) / 100;
      //             // dd($bebanKaryawan);
      //             $bebanKaryawanReal = ($red->employee * $salary) / 100;
      //             $selisih = $bebanKaryawanReal - $bebanKaryawan;
      //             $bebanPerusahaanReal = $bebanPerusahaan + $selisih;
      //             // $bebanKaryawanReal = ($red->reduction->employee * $salary) / 100;
      //             // $selisih = $bebanKaryawanReal - $bebanKaryawan;
      //             // $bebanPerusahaanReal = $bebanPerusahaan + $selisih;
   
      //          } else if ($payTotal >= $red->min_salary) {
      //             if ($payTotal > $red->max_salary) {
      //                // dd('ok');
      //                if ($red->max_salary != 0) {
      //                   $salary = $payTotal;
      //                   $bebanPerusahaan = ($red->company * $red->max_salary) / 100;
      //                   $bebanKaryawan = ($red->employee * $red->max_salary) / 100;
      //                   $bebanKaryawanReal = 0;
      //                   $bebanPerusahaanReal = $bebanPerusahaan;
      //                } else {
      //                   $salary = $payTotal;
      //                   $bebanPerusahaan = ($red->company * $salary) / 100;
      //                   $bebanKaryawan = ($red->employee * $salary) / 100;
      //                   $bebanKaryawanReal = 0;
      //                   $bebanPerusahaanReal = $bebanPerusahaan;
      //                }
      //             } else {
      //                $salary = $payTotal;
      //                $bebanPerusahaan = ($red->company * $salary) / 100;
      //                $bebanKaryawan = ($red->employee * $salary) / 100;
      //                $bebanKaryawanReal = 0;
      //                $bebanPerusahaanReal = $bebanPerusahaan;
      //             }
      //          }
              
   
               
      //          if (!$currentRed) {
      //             ReductionEmployee::create([
      //                'reduction_id' => $red->id,
      //                'type' => 'Default',
      //                'location_id' => $location,
      //                'employee_id' => $employee->id,
      //                'status' => 1,
      //                'employee_value' => $bebanKaryawan,
      //                'employee_value_real' => $bebanKaryawanReal,
      //                'company_value' => $bebanPerusahaan,
      //                'company_value_real' => $bebanPerusahaanReal,
   
      //             ]);
      //          } else {
      //             $currentRed->update([
      //                'reduction_id' => $red->id,
      //                'type' => 'Default',
      //                'location_id' => $location,
      //                'employee_id' => $employee->id,
      //                // 'status' => 1,
      //                'employee_value' => $bebanKaryawan,
      //                'employee_value_real' => $bebanKaryawanReal,
      //                'company_value' => $bebanPerusahaan,
      //                'company_value_real' => $bebanPerusahaanReal,
      //             ]);
      //          }
      //       }
      //       $redEmployees = ReductionEmployee::where('employee_id', $employee->id)->get();
      //       // dd('ok');
      //    } else {
      //       // dd('empty');

      //       $redEmployees = [];
      //    }
      // }
      






      foreach ($locations as $loc) {
         if ($loc->code == $employee->contract->loc) {
            $location = $loc->id;
         }
      }




      $redEmployees = ReductionEmployee::where('employee_id', $employee->id)->where('type', 'Default')->get();

      // foreach($redEmployees as $redemp){
      //    $redemp->delete();
      // }


      // foreach ($reductions as $red) {
      //    if ($payroll->total > $red->max_salary) {
      //       dd($red->name);
      //    }
      // }

      // dd('ok');
      // dd($reductions);
      if ($payroll != null) {
         // dd('ada');
         // if ($employee->unit_id == 9) {
         //    $payTotal = $payroll->pokok;
         // } else {
         //    $payTotal = $payroll->total;
         // }

        
         $payTotal = $payroll->total;
         foreach ($reductions as $red) {
            $currentRed = ReductionEmployee::where('reduction_id', $red->id)->where('employee_id', $employee->id)->first();
            // dd($red->max_salary);
            
            
            
               // dd($red->min_salary);
               if ($payTotal <= $red->min_salary) {
                  // dd('kurang dari minimum gaji');
                  $salary = $red->min_salary;
                  $realSalary = $payroll->total;
   
                  $bebanPerusahaan = ($red->company * $salary) / 100;
                  $bebanKaryawan = ($red->employee * $realSalary) / 100;
                  $bebanKaryawanReal = ($red->employee * $salary) / 100;
                  $selisih = $bebanKaryawanReal - $bebanKaryawan;
                  $bebanPerusahaanReal = $bebanPerusahaan + $selisih;
                  // $bebanKaryawanReal = ($red->reduction->employee * $salary) / 100;
                  // $selisih = $bebanKaryawanReal - $bebanKaryawan;
                  // $bebanPerusahaanReal = $bebanPerusahaan + $selisih;
   
               } else if ($payTotal >= $red->min_salary) {
                  if ($payTotal > $red->max_salary) {
                     // dd('ok');
                     if ($red->max_salary != 0) {
                        
                        $salary = $payTotal;
                        $bebanPerusahaan = ($red->company * $red->max_salary) / 100;
                        $bebanKaryawan = ($red->employee * $red->max_salary) / 100;
                        $bebanKaryawanReal = 0;
                        $bebanPerusahaanReal = $bebanPerusahaan;
                     } else {
                        $salary = $payTotal;
                        $bebanPerusahaan = ($red->company * $salary) / 100;
                        $bebanKaryawan = ($red->employee * $salary) / 100;
                        $bebanKaryawanReal = 0;
                        $bebanPerusahaanReal = $bebanPerusahaan;
                     }
                  } else {
                     $salary = $payTotal;
                     $bebanPerusahaan = ($red->company * $salary) / 100;
                     $bebanKaryawan = ($red->employee * $salary) / 100;
                     $bebanKaryawanReal = 0;
                     $bebanPerusahaanReal = $bebanPerusahaan;
                  }
               }
            
            



            // if (!$currentRed) {
            //    // dd('ok');
            //    ReductionEmployee::create([
            //       'reduction_id' => $red->id,
            //       'type' => 'Default',
            //       'location_id' => $location,
            //       'employee_id' => $employee->id,
            //       'status' => 1,
            //       'employee_value' => $bebanKaryawan,
            //       'employee_value_real' => $bebanKaryawanReal,
            //       'company_value' => $bebanPerusahaan,
            //       'company_value_real' => $bebanPerusahaanReal,

            //    ]);
            // } else {
            //    // dd($bebanKaryawan);
            //    // dd('ok');

            //    $currentRed->update([
            //       'reduction_id' => $red->id,
            //       'type' => 'Default',
            //       'location_id' => $location,
            //       'employee_id' => $employee->id,
            //       // 'status' => 1,
            //       'employee_value' => $bebanKaryawan,
            //       'employee_value_real' => $bebanKaryawanReal,
            //       'company_value' => $bebanPerusahaan,
            //       'company_value_real' => $bebanPerusahaanReal,
            //    ]);
            // }
         }
          
         $redEmployees = ReductionEmployee::where('employee_id', $employee->id)->where('type', 'Default')->get();
         // dd('ok');
      } else {
         // dd('empty');
        
         $payTotal = 0;
         $redEmployees = [];
      }

      // dd($redEmployees);
      // $bpjs = Reduction::where('unit_id', $employee->unit->id)->where('name', 'BPJS KS')->first();
      // if ($payroll != null){
      //    if ($payTotal <= $bpjs->min_salary ) {
      //       $book2 = $bpjs->min_salary;
      //    } elseif($payTotal >= $bpjs->min_salary){
      //       if ($payTotal > $bpjs->max_salary){
      //          $book2 = $bpjs->max_salary;
      //       } else {
      //          $book2 =$payTotal;
      //       }
      //    }
      // } else{
      //    $book2 = 0;
      // }
      $book2 = 0;

      // $payroll->update([
      //    'book2' => $book2
      // ]);



      // $redEmployees = ReductionEmployee::where('employee_id', $employee->id)->get();

      // dd($redEmployees);
      // dd($redAdditionals);
      $redAddEmployees = ReductionEmployee::where('employee_id', $employee->id)->where('type', 'Additional')->get();

      return view('pages.payroll.detail', [
         'employee' => $employee,
         'reductions' => $reductions,
         'redEmployees' => $redEmployees,
         'redAddEmployees' => $redAddEmployees,
         'redAdditionals' => $redAdditionals,
         'book2' => $book2,

         'payrollHistories' => $payrollHistories
      ]);
   }


   public function update(Request $req)
   {
      $employee = Employee::find($req->employee);

      // dd('ok');
      $payroll = Payroll::find($employee->payroll_id);

      $locations = Location::get();
      $locId = null;
      foreach ($locations as $loc) {
         if ($employee->contract->loc == $loc->code) {
            $locId = $loc->id;
         }
      }

      // dd($locId);

      $locations = Location::get();
      $locId = null;
      foreach ($locations as $loc) {
         if ($employee->contract->loc == $loc->code) {
            $locId = $loc->id;
         }
      }

      // dd($locId);

      if ($payroll) {

         if (request('doc')) {
            if ($payroll->doc) {
               Storage::delete($payroll->doc);
            }


            $doc = request()->file('doc')->store('doc/payroll');
         } elseif ($payroll->doc) {
            $doc = $payroll->doc;
         } else {
            $doc = null;
         }

         $total = preg_replace('/[Rp. ]/', '', $req->pokok) + preg_replace('/[Rp. ]/', '', $req->tunj_jabatan) + preg_replace('/[Rp. ]/', '', $req->tunj_ops) + preg_replace('/[Rp. ]/', '', $req->tunj_kinerja) + preg_replace('/[Rp. ]/', '', $req->tunj_fungsional) + preg_replace('/[Rp. ]/', '', $req->insentif);

         // dd($okee);
         $payroll->update([
            'location_id' => $locId,
            'pokok' => preg_replace('/[Rp. ]/', '', $req->pokok),
            'tunj_jabatan' => preg_replace('/[Rp. ]/', '', $req->tunj_jabatan),
            'tunj_ops' => preg_replace('/[Rp. ]/', '', $req->tunj_ops),
            'tunj_kinerja' => preg_replace('/[Rp. ]/', '', $req->tunj_kinerja),
            'tunj_fungsional' => preg_replace('/[Rp. ]/', '', $req->tunj_fungsional),
            'insentif' => preg_replace('/[Rp. ]/', '', $req->insentif),
            'total' => $total,
            'doc' => $doc,
            // 'berlaku' => $req->berlaku
         ]);
      } else {

         if (request('doc')) {


            $doc = request()->file('doc')->store('doc/payroll');
         } else {
            $doc = null;
         }

         $total = $req->pokok + $req->tunj_jabatan + $req->tunj_ops + $req->tunj_kinerja + $req->tunj_fungsional + $req->insentif;


         $payroll = Payroll::create([
            'location_id' => $locId,
            'pokok' => $req->pokok,
            'tunj_jabatan' => $req->tunj_jabatan,
            'tunj_ops' => $req->tunj_ops,
            'tunj_kinerja' => $req->tunj_kinerja,
            'tunj_fungsional' => $req->tunj_fungsional,
            'insentif' => $req->insentif,
            'total' => $total,
            'doc' => $doc
         ]);

         $employee->update([
            'payroll_id' => $payroll->id
         ]);
      }

      $reductions = Reduction::where('unit_id', $employee->unit_id)->get();
      $locations = Location::get();

      foreach ($locations as $loc) {
         if ($loc->code == $employee->contract->loc) {
            $location = $loc->id;
         }
      }

      foreach ($reductions as $red) {
         $currentRed = ReductionEmployee::where('reduction_id', $red->id)->where('employee_id', $employee->id)->first();

         if ($payroll->total <= $red->min_salary) {
            $salary = $red->min_salary;
            $realSalary = $payroll->total;

            $bebanPerusahaan = ($red->company * $salary) / 100;
            $bebanKaryawan = ($red->employee * $realSalary) / 100;
            $bebanKaryawanReal = ($red->employee * $salary) / 100;
            $selisih = $bebanKaryawanReal - $bebanKaryawan;
            $bebanPerusahaanReal = $bebanPerusahaan + $selisih;
         } else if ($payroll->total >= $red->min_salary) {
            if ($payroll->total > $red->max_salary) {
               // dd('ok');
               if ($red->max_salary != 0) {
                  $salary = $payroll->total;
                  $bebanPerusahaan = ($red->company * $red->max_salary) / 100;
                  $bebanKaryawan = ($red->employee * $red->max_salary) / 100;
                  $bebanKaryawanReal = 0;
                  $bebanPerusahaanReal = $bebanPerusahaan;
               } else {
                  $salary = $payroll->total;
                  $bebanPerusahaan = ($red->company * $salary) / 100;
                  $bebanKaryawan = ($red->employee * $salary) / 100;
                  $bebanKaryawanReal = 0;
                  $bebanPerusahaanReal = $bebanPerusahaan;
               }
            } else {
               $salary = $payroll->total;
               $bebanPerusahaan = ($red->company * $salary) / 100;
               $bebanKaryawan = ($red->employee * $salary) / 100;
               $bebanKaryawanReal = 0;
               $bebanPerusahaanReal = $bebanPerusahaan;
            }
         }

         if (!$currentRed) {
            ReductionEmployee::create([
               'reduction_id' => $red->id,
               'location_id' => $location,
               'employee_id' => $employee->id,
               // 'status' => 1,
               'type' => 'Default',
               'employee_value' => $bebanKaryawan,
               'employee_value_real' => $bebanKaryawanReal,
               'company_value' => $bebanPerusahaan,
               'company_value_real' => $bebanPerusahaanReal,

            ]);
         } else {
            $currentRed->update([
               'reduction_id' => $red->id,
               'location_id' => $location,
               'employee_id' => $employee->id,
               // 'status' => 1,
               'type' => 'Default',
               'employee_value' => $bebanKaryawan,
               'employee_value_real' => $bebanKaryawanReal,
               'company_value' => $bebanPerusahaan,
               'company_value_real' => $bebanPerusahaanReal,
            ]);
         }
      }

      $transactionCon = new TransactionController;
      $transactions = Transaction::where('status', 0)->where('employee_id', $employee->id)->get();

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
         'action' => 'Update',
         'desc' => 'Payroll ' . $employee->nik . ' ' . $employee->biodata->fullname()
      ]);

      return redirect()->back()->with('success', 'Payroll successfully updated');
   }

   public function updateNominal(Request $req){
      $req->validate([]);


      // $overtimes = Overtime::where('employee_id', $req->employeeId)->where('date', '>=', $req->berlaku )->get();
      // dd($overtimes);
      $payroll = Payroll::find($req->payrollId);
      PayrollHistory::create([
         'employee_id' => $req->employeeId,
         'location_id' => $payroll->location_id,
         'pokok' => $payroll->pokok,
         'tunj_jabatan' => $payroll->tunj_jabatan,
         'tunj_ops' => $payroll->tunj_ops,
         'tunj_kinerja' => $payroll->tunj_kinerja,
         'tunj_fungsional' => $payroll->tunj_fungsional,
         'insentif' => $payroll->insentif,
         'total' => $payroll->total,
         'doc' => $payroll->doc,
         'berlaku' => $payroll->berlaku
      ]);


      if (request('doc')) {
         $doc = request()->file('doc')->store('doc/payroll');
      } else {
         $doc = null;
      }
      $total = preg_replace('/[Rp. ]/', '', $req->pokok) + preg_replace('/[Rp. ]/', '', $req->tunj_jabatan) + preg_replace('/[Rp. ]/', '', $req->tunj_ops) + preg_replace('/[Rp. ]/', '', $req->tunj_kinerja) + preg_replace('/[Rp. ]/', '', $req->tunj_fungsional) + preg_replace('/[Rp. ]/', '', $req->insentif);

      $payroll->update([
         'pokok' => preg_replace('/[Rp. ]/', '', $req->pokok),
         'tunj_jabatan' => preg_replace('/[Rp. ]/', '', $req->tunj_jabatan),
         'tunj_ops' => preg_replace('/[Rp. ]/', '', $req->tunj_ops),
         'tunj_kinerja' => preg_replace('/[Rp. ]/', '', $req->tunj_kinerja),
         'tunj_fungsional' => preg_replace('/[Rp. ]/', '', $req->tunj_fungsional),
         'insentif' => preg_replace('/[Rp. ]/', '', $req->insentif),
         'total' => $total,
         'doc' => $doc,
         'berlaku' => $req->berlaku
      ]);

      $employee = Employee::find($req->employeeId);
      $spkl_type = $employee->unit->spkl_type;
      $hour_type = $employee->unit->hour_type;

      $overtimes = Overtime::where('employee_id', $req->employeeId)->where('date', '>=', $req->berlaku )->get();
      $overtime = new OvertimeController;
      // $rate = $overtime->calculateRate($payroll, $req->type, $spkl_type, $hour_type, $req->hours, $req->holiday_type);
      
      foreach($overtimes as $over){
         $rate = $overtime->calculateRate($payroll, $over->type, $spkl_type, $hour_type, $over->hours, $over->holiday_type);
         $over->update([
            'rate' => $rate
         ]);
      }

      return redirect()->back()->with('success', 'Nominal Payroll berhasil diupdate. ' . count($overtimes). ' Data SPKL di kalkulasi ulang' );





   }

   public function updateBook2(Request $req)
   {
      $employee = Employee::find($req->employee);

      $payroll = Payroll::find($employee->payroll_id);
      $payroll->update([
         'book2' => $req->book2
      ]);

      $locations = Location::get();
      $locId = null;
      foreach ($locations as $loc) {
         if ($employee->contract->loc == $loc->code) {
            $locId = $loc->id;
         }
      }

      

      // dd($locId);

      if ($payroll) {

         if (request('doc')) {
            if ($payroll->doc) {
               Storage::delete($payroll->doc);
            }


            $doc = request()->file('doc')->store('doc/payroll');
         } elseif ($payroll->doc) {
            $doc = $payroll->doc;
         } else {
            $doc = null;
         }

         $total = preg_replace('/[Rp. ]/', '', $req->pokok) + preg_replace('/[Rp. ]/', '', $req->tunj_jabatan) + preg_replace('/[Rp. ]/', '', $req->tunj_ops) + preg_replace('/[Rp. ]/', '', $req->tunj_kinerja) + preg_replace('/[Rp. ]/', '', $req->tunj_fungsional) + preg_replace('/[Rp. ]/', '', $req->insentif);


         $payroll->update([
            'location_id' => $locId,
            'pokok' => preg_replace('/[Rp. ]/', '', $req->pokok),
            'tunj_jabatan' => preg_replace('/[Rp. ]/', '', $req->tunj_jabatan),
            'tunj_ops' => preg_replace('/[Rp. ]/', '', $req->tunj_ops),
            'tunj_kinerja' => preg_replace('/[Rp. ]/', '', $req->tunj_kinerja),
            'tunj_fungsional' => preg_replace('/[Rp. ]/', '', $req->tunj_fungsional),
            'insentif' => preg_replace('/[Rp. ]/', '', $req->insentif),
            'total' => $total,
            'doc' => $doc,
            'berlaku' => $req->berlaku
         ]);
      } else {

         if (request('doc')) {


            $doc = request()->file('doc')->store('doc/payroll');
         } else {
            $doc = null;
         }

         $total = $req->pokok + $req->tunj_jabatan + $req->tunj_ops + $req->tunj_kinerja + $req->tunj_fungsional + $req->insentif;


         $payroll = Payroll::create([
            'location_id' => $locId,
            'pokok' => $req->pokok,
            'tunj_jabatan' => $req->tunj_jabatan,
            'tunj_ops' => $req->tunj_ops,
            'tunj_kinerja' => $req->tunj_kinerja,
            'tunj_fungsional' => $req->tunj_fungsional,
            'insentif' => $req->insentif,
            'total' => $total,
            'doc' => $doc
         ]);

         $employee->update([
            'payroll_id' => $payroll->id
         ]);
      }

      $reductions = Reduction::where('unit_id', $employee->unit_id)->get();
      $locations = Location::get();

      foreach ($locations as $loc) {
         if ($loc->code == $employee->contract->loc) {
            $location = $loc->id;
         }
      }

      foreach ($reductions as $red) {
         $currentRed = ReductionEmployee::where('reduction_id', $red->id)->where('employee_id', $employee->id)->first();

         if ($payroll->total <= $red->min_salary) {
            $salary = $red->min_salary;
            $realSalary = $payroll->total;

            $bebanPerusahaan = ($red->company * $salary) / 100;
            $bebanKaryawan = ($red->employee * $realSalary) / 100;
            $bebanKaryawanReal = ($red->employee * $salary) / 100;
            $selisih = $bebanKaryawanReal - $bebanKaryawan;
            $bebanPerusahaanReal = $bebanPerusahaan + $selisih;
         } else if ($payroll->total >= $red->min_salary) {
            if ($payroll->total > $red->max_salary) {
               // dd('ok');
               if ($red->max_salary != 0) {
                  $salary = $payroll->total;
                  $bebanPerusahaan = ($red->company * $red->max_salary) / 100;
                  $bebanKaryawan = ($red->employee * $red->max_salary) / 100;
                  $bebanKaryawanReal = 0;
                  $bebanPerusahaanReal = $bebanPerusahaan;
               } else {
                  $salary = $payroll->total;
                  $bebanPerusahaan = ($red->company * $salary) / 100;
                  $bebanKaryawan = ($red->employee * $salary) / 100;
                  $bebanKaryawanReal = 0;
                  $bebanPerusahaanReal = $bebanPerusahaan;
               }
            } else {
               $salary = $payroll->total;
               $bebanPerusahaan = ($red->company * $salary) / 100;
               $bebanKaryawan = ($red->employee * $salary) / 100;
               $bebanKaryawanReal = 0;
               $bebanPerusahaanReal = $bebanPerusahaan;
            }
         }

         if (!$currentRed) {
            ReductionEmployee::create([
               'reduction_id' => $red->id,
               'location_id' => $location,
               'employee_id' => $employee->id,
               // 'status' => 1,
               'type' => 'Default',
               'employee_value' => $bebanKaryawan,
               'employee_value_real' => $bebanKaryawanReal,
               'company_value' => $bebanPerusahaan,
               'company_value_real' => $bebanPerusahaanReal,

            ]);
         } else {
            $currentRed->update([
               'reduction_id' => $red->id,
               'location_id' => $location,
               'employee_id' => $employee->id,
               // 'status' => 1,
               'type' => 'Default',
               'employee_value' => $bebanKaryawan,
               'employee_value_real' => $bebanKaryawanReal,
               'company_value' => $bebanPerusahaan,
               'company_value_real' => $bebanPerusahaanReal,
            ]);
         }
      }

      $transactionCon = new TransactionController;
      $transactions = Transaction::where('status', 0)->where('employee_id', $employee->id)->get();

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
         'action' => 'Update',
         'desc' => 'Payroll ' . $employee->nik . ' ' . $employee->biodata->fullname()
      ]);

      return redirect()->back()->with('success', 'Payroll successfully updated');
   }


   public function unitUpdatePph(Request $req)
   {
      $unit = Unit::find($req->unit);
      $unit->update([
         // 'pph' => $req->pph,
         'spkl_type' => $req->spkl_type,
         'hour_type' => $req->hour_type
      ]);



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
         'desc' => 'Setup Default ' . $unit->name
      ]);

      return redirect()->back()->with('success', 'Setup Unit Payroll successfully updated');
   }


   public function report()
   {
      $units = Unit::get();
      $locations = Location::get();
      $transactions = Transaction::get();
      return view('pages.payroll.report', [
         'units' => $units,
         'locations' => $locations,
         'transactions' => $transactions,
         'location' => null,
         'month' => null,
         'year' => null
      ]);
   }

   public function getReport(Request $req)
   {
      // if ($req->unit) {
      //    if ($req->location) {
      //       $transactions = Transaction::where('unit_id', $req->unit)->where('location_id', $req->location)->where('month', $req->month)->where('year', $req->year)->get();
      //    } else {
      //       $transactions = Transaction::where('unit_id', $req->unit)->where('month', $req->month)->where('year', $req->year)->get();
      //    }

      // } else {
      //    $transactions = Transaction::where('location_id', $req->location)->where('month', $req->month)->where('year', $req->year)->get();
      // }
      $transactions = Transaction::where('location_id', $req->location)->where('month', $req->month)->where('year', $req->year)->get();
      $units = Unit::get();
      $locations = Location::get();

      return view('pages.payroll.report', [
         'transactions' => $transactions,
         'locations' => $locations,
         'units' => $units,
         'location' => $req->location,
         'month' => $req->month,
         'year' => $req->year
      ]);
   }



   public function payslipUpdate(Request $req)
   {
      $employee = Employee::find($req->employeeId);
      $payroll = Payroll::find($employee->payroll_id);



      $payroll->update([
         'payslip_status' => $req->status
      ]);
      // dd($employee->nik);  
      return redirect()->back()->with('success', "Payslip Status updated");
   }

   public function payslipShow(Request $req)
   {
      $transaction = Transaction::find($req->transactionId);

      $transaction->update([
         'payslip_status' => 'show'
      ]);
      // dd($employee->nik);  
      return redirect()->back()->with('success', "Payslip Status updated");
   }

   public function payslipHide(Request $req)
   {
      $transaction = Transaction::find($req->transactionId);

      $transaction->update([
         'payslip_status' => 'hide'
      ]);
      // dd($employee->nik);  
      return redirect()->back()->with('success', "Payslip Status updated");
   }

   public function exportPdf($id)
   {
      $transaction = Transaction::find(dekripRambo($id));
      $employee = Employee::find($transaction->employee_id);

      $from = $transaction->cut_from;
      $to = $transaction->cut_to;
      $alphas = $employee->absences->where('date', '>=', $from)->where('date', '<=', $to)->where('year', $transaction->year)->where('type', 1);
      $lates = $employee->absences->where('date', '>=', $from)->where('date', '<=', $to)->where('year', $transaction->year)->where('type', 2);
      $atls = $employee->absences->where('date', '>=', $from)->where('date', '<=', $to)->where('year', $transaction->year)->where('type', 3);
      $izins = $employee->absences->where('date', '>=', $from)->where('date', '<=', $to)->where('year', $transaction->year)->where('type', 4);
      $overtimes = Overtime::where('date', '>=', $from)->where('date', '<=', $to)->where('employee_id', $employee->id)->get();

      return view('pages.payroll.transaction.payslip-pdf', [
         'transaction' => $transaction,
         'alphas' => $alphas,
         'lates' => $lates,
         'atls' => $atls,
         'izins' => $izins,
         'overtimes' => $overtimes
      ]);
   }
}
