<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use App\Models\Absence;
use App\Models\Additional;
use App\Models\BpjsKsReport;
use App\Models\BpjsKtReport;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Log;
use App\Models\Overtime;
use App\Models\Payroll;
use App\Models\PayrollApproval;
use App\Models\PayslipBpjsKs;
use App\Models\PayslipBpjsKt;
use App\Models\PayslipReport;
use App\Models\Reduction;
use App\Models\ReductionAdditional;
use App\Models\ReductionEmployee;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TransactionOvertime;
use App\Models\TransactionReduction;
use App\Models\Unit;
use App\Models\UnitTransaction;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{


   public function index()
   {
      $employees = Employee::get();
      $transactions = Transaction::get();
      $units = Unit::get();
      $firstUnit = Unit::get()->first();

      // foreach ($transactions as $tran) {
      //    $this->calculateTotalTransaction($tran, $tran->cut_from, $tran->cut_to);
      // }

      $unitTransactions = UnitTransaction::get();
      // foreach ($unitTransactions as $unitTrans) {
      //    $transactionUnits = Transaction::where('unit_transaction_id', $unitTrans->id)->get();

      //    $unitTrans->update([
      //       'total_salary' => $transactionUnits->sum('total')
      //    ]);
      // }


      

      return view('pages.payroll.transaction.index', [
         'employees' => $employees,
         'transactions' => $transactions,
         'units' => $units,
         'firstUnit' => $firstUnit
      ])->with('i');
   }


   public function employee()
   {
      $employee = Employee::where('nik', auth()->user()->username)->first();

      $transactions = Transaction::where('employee_id', $employee->id)->where('status', '>=', 5)->get();
      return view('pages.payroll.employee', [
         'transactions' => $transactions
      ]);
   }


   public function detail($id)
   {

      // dd('ok');
      // dd($employee->id);
      // $payroll = Payroll::find($employee->payroll_id);
      $transaction = Transaction::find(dekripRambo($id));

      $r = TransactionReduction::where('transaction_id', $transaction->id)->where('class', 'Default')->where('type', 'employee')->get();
      $transReduction = TransactionReduction::where('transaction_id', $transaction->id)->where('class', 'Default')->where('name', 'JP')->where('type', 'employee')->first();
      // $transReduction = Reduction::where('class', 'Default')->where('type', 'employee')
      // dd($transReduction);
      // if ($transReduction) {
      //    $value = $value + $transReduction->value;
      // }
      
      // dd($r);

      // dd($transaction->reductions);
      $employee = Employee::find($transaction->employee_id);
      $reductions = Reduction::where('unit_id', $employee->unit_id)->get();
      $payroll = Payroll::find($employee->payroll_id);
      $transactionReductions = TransactionReduction::where('transaction_id', $transaction->id)->get();


      $from = $transaction->cut_from;
      $to = $transaction->cut_to;

      if ($employee->join > $from && $employee->join < $to) {
         // dd('karyawan baru');
         $transaction->update([
            'remark' => 'Karyawan Baru'
         ]);
      } else {
         $transaction->update([
            'remark' => 'Karyawan Lama'
         ]);
      }

      // dd('ok');
      $overtimes = Overtime::where('date', '>=', $from)->where('date', '<=', $to)->where('employee_id', $employee->id)->where('status', 1)->get();
      // dd($overtimes);
      $totalOvertime = $overtimes->sum('rate');
      $penambahans = Additional::where('employee_id', $employee->id)->where('date', '>=', $from)->where('date', '<=', $to)->where('type', 1)->get();
      $pengurangans = Additional::where('employee_id', $employee->id)->where('date', '>=', $from)->where('date', '<=', $to)->where('type', 2)->get();
      // dd($penambahan);
      $bruto = $payroll->total + $totalOvertime;

      $absences = $employee->absences->where('month', $transaction->month);
      // $alphas = $employee->absences->where('month', $transaction->month)->where('type', 1);
      // $lates = $employee->absences->where('month', $transaction->month)->where('type', 2);
      // $izins = $employee->absences->where('month', $transaction->month)->where('type', 3);
      // dd($alphas);
      // dd('ok');


      // $reduction = $transaction->reductions->where('type', 'employee')->sum('value') + $reductionAlpha;
      $additionals = Additional::where('employee_id', $employee->id)->where('month', $transaction->month)->get();

      $alphas = $employee->absences->where('date', '>=', $from)->where('date', '<=', $to)->where('type', 1);
      $izinFullDays = $employee->absences->where('date', '>=', $from)->where('date', '<=', $to)->where('type', 4)->where('type_izin', 'Satu Hari');
      $offContratcs = $employee->absences->where('date', '>=', $from)->where('date', '<=', $to)->where('type', 9);
      $lates = $employee->absences->where('date', '>=', $from)->where('date', '<=', $to)->where('type', 2);
      // dd($lates);
      $totalMinuteLate = $lates->sum('minute');
      // dd($totalMinuteLate);
      $keterlambatan = intval(floor($totalMinuteLate / 30));

      $atls = $employee->absences->where('date', '>=', $from)->where('date', '<=', $to)->where('type', 3);
      $totalAtlLate = count($atls) * 2;


      $totalKeterlambatan = $keterlambatan + $totalAtlLate;


      // dd($totalKeterlambatan);


      if ($totalKeterlambatan == 6) {
         // dd('ok');
         $potongan = 1 * 1 / 30 * $payroll->total;
      } elseif ($totalKeterlambatan > 6) {
         $finalLate = $totalKeterlambatan - 6;
         $potongan = $finalLate * 1 / 5 * $payroll->total;
         // dd($finalLate);
         // dd($payroll->total);
      } else {
         $potongan = 0;
      }

      $izins = $employee->absences->where('date', '>=', $from)->where('date', '<=', $to)->where('type', 4);
      $totalMinuteLate = $lates->sum('minute');

      // dd(1 * 1/30 * $payroll->total);
      foreach ($alphas as $alpha) {
         $alpha->update([
            'value' => 1 * 1 / 30 * $payroll->total
         ]);
      }
      // dd($potongan);

      // dd('ok');

      // dd($alphas);


      $this->calculateTotalTransaction($transaction, $transaction->cut_from, $transaction->cut_to);

      $transactionReductionAdditionals = TransactionReduction::where('transaction_id', $transaction->id)->where('class', 'additional')->get();

      // dd($transaction->id);




      return view('pages.payroll.transaction.detail', [
         'employee' => $employee,
         'payroll' => $payroll,
         'transaction' => $transaction,
         'overtimes' => $overtimes,
         'totalOvertime' => $totalOvertime,
         'alphas' => $alphas,
         'lates' => $lates,
         'atls' => $atls,
         'izins' => $izins,
         'absences' => $absences,
         'additionals' => $additionals,
         'totalOvertime' => $totalOvertime,
         'alphas' => $alphas,
         'offContracts' => $offContratcs,
         'lates' => $lates,
         'izins' => $izins,
         'absences' => $absences,
         'additionals' => $additionals,
         'penambahans' => $penambahans,
         'pengurangans' => $pengurangans,

         'totalKeterlambatan' => $totalKeterlambatan,

         'transactionReductionAdditionals' => $transactionReductionAdditionals
      ]);
   }


   public function storeMaster(Request $req)
   {
      $unit = Unit::find($req->unit);
      $employees = Employee::where('unit_id', $unit->id)->where('status', 1)->get();
      $resignEmployees = Employee::where('unit_id', $unit->id)->where('status', 3)->where('off', '>', $req->from)->where('off', '<', $req->to)->get();
     
      
      
      $current = UnitTransaction::where('unit_id', $unit->id)->where('month', $req->month)->where('year', $req->year)->first();
      if ($current) {
         return redirect()->back()->with('danger', 'Slip Gaji ' . $unit->name . ' Bulan ' . $req->month . ' ' . $req->year . ' sudah ada');
      }
      $totalSalary = 0;
      $totalEmployee = 0;

      foreach ($employees as $employee) {
         if ($employee->payroll_id != null) {
            if ($employee->contract->loc == null) {
               return redirect()->back()->with('danger', 'Data Lokasi Kerja Kosong ' . $employee->nik . ' ' . $employee->biodata->fullName());
            }
         }
      }

      // 01 Create Unit Transaction
      $unitTransaction = UnitTransaction::create([
         'status' => 0,
         'unit_id' => $unit->id,
         'cut_from' => $req->from,
         'cut_to' => $req->to,
         'month' => $req->month,
         'year' => $req->year,
         'total_employee' => $totalEmployee,
         'total_salary' => $totalSalary
      ]);

      foreach ($employees as $emp) {
         if ($emp->payroll_id != null && $emp->join < $req->to) {
            $totalSalary = $totalSalary + $emp->payroll->total;
            $totalEmployee = $totalEmployee + 1;

            $empTransaction = Transaction::where('employee_id', $emp->id)->where('month', $req->month)->first();
            
            if (!$empTransaction) {
               $this->store($emp, $req, $unitTransaction);
            }
         }
      }

      foreach ($resignEmployees as $emp) {
         if ($emp->payroll_id != null && $emp->join < $req->to) {
            $totalSalary = $totalSalary + $emp->payroll->total;
            $totalEmployee = $totalEmployee + 1;

            $empTransaction = Transaction::where('employee_id', $emp->id)->where('month', $req->month)->first();
            if (!$empTransaction) {
               $this->store($emp, $req, $unitTransaction);
            }
         }
      }

      $unitTransaction->update([
         'total_employee' => $totalEmployee,
         'total_salary' => $totalSalary
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
         'action' => 'Generate',
         'desc' => 'Payslip ' . $unitTransaction->unit->name . ' Bulan ' . $unitTransaction->month
      ]);




      return redirect()->back()->with('success', 'Master Transaction successfully created');

      // dd($totalSalary);
   }

   public function deleteMaster($id)
   {
      // dd('delete');
      $unitTransaction = UnitTransaction::find(dekripRambo($id));
      $transactions = Transaction::where('unit_transaction_id', $unitTransaction->id)->get();

      foreach ($transactions as $tran) {
         $details = TransactionDetail::where('transaction_id', $tran->id)->get();
         $overtimes = TransactionOvertime::where('transaction_id', $tran->id)->get();
         $reductions = TransactionReduction::where('transaction_id', $tran->id)->get();

         foreach ($details as $detail) {
            $detail->delete();
         }
         foreach ($overtimes as $overtime) {
            $overtime->delete();
         }
         foreach ($reductions as $reduction) {
            $reduction->delete();
         }


         $tran->delete();
      }

      $unitName = $unitTransaction->unit->name;
      $month = $unitTransaction->month;

      // dd($unitTransaction->id);
      $unitTransaction->delete();

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
         'desc' => 'Master Payslip ' . $unitName . ' Bulan ' . $month
      ]);

      return redirect()->back()->with('success', 'Data Transaction successfully deleted');
   }

   public function monthly($id)
   {
      // dd('ok');
      $unitTransaction = UnitTransaction::find(dekripRambo($id));
      $unit = Unit::find($unitTransaction->unit_id);
      $units = Unit::get();
      $locations = Location::get();
      $firstLoc = Location::orderBy('id', 'asc')->first();
      $transactions = Transaction::where('unit_id', $unit->id)->where('month', $unitTransaction->month)->where('year', $unitTransaction->year)->get();

      // $manhrd = PayrollApproval::where('unit_transaction_id', $unitTransaction->id)->where('level', 'man-hrd')->where('type', 'approve')->first();
      // $manfin = PayrollApproval::where('unit_transaction_id', $unitTransaction->id)->where('level', 'man-fin')->where('type', 'approve')->first();
      // $gm = PayrollApproval::where('unit_transaction_id', $unitTransaction->id)->where('level', 'gm')->where('type', 'approve')->first();
      // $bod = PayrollApproval::where('unit_transaction_id', $unitTransaction->id)->where('level', 'bod')->where('type', 'approve')->first();


      // dd($manhrd);

      $reportBpjsKs = PayslipBpjsKs::where('unit_transaction_id', $unitTransaction->id)->first();
      $reportBpjsKt = PayslipBpjsKt::where('unit_transaction_id', $unitTransaction->id)->first();
      $hrd = PayrollApproval::where('unit_transaction_id', $unitTransaction->id)->where('level', 'hrd')->first();
      $manHrd = PayrollApproval::where('unit_transaction_id', $unitTransaction->id)->where('level', 'man-hrd')->first();
      $manFin = PayrollApproval::where('unit_transaction_id', $unitTransaction->id)->where('level', 'man-fin')->first();
      $gm = PayrollApproval::where('unit_transaction_id', $unitTransaction->id)->where('level', 'gm')->first();
      $bod = PayrollApproval::where('unit_transaction_id', $unitTransaction->id)->where('level', 'bod')->first();

      // foreach ($locations as $loc){
      //    if ($loc->totalEmployee($unit->id) > 0){
      //       PayslipReport::create([
      //          'unit_transaction_id' => $unitTransaction->id,
      //          'location_id' => $loc->id,
      //          'location_name' => $loc->name,
      //          'qty' => count($loc->getUnitTransaction($unit->id, $unitTransaction)),
      //          'pokok' => $loc->getValue($unit->id, $unitTransaction, 'Gaji Pokok'),
      //          'jabatan' => $loc->getValue($unit->id, $unitTransaction,  'Tunj. Jabatan'),
      //          'ops' => $loc->getValue($unit->id, $unitTransaction, 'Tunj. OPS'),
      //          'kinerja' => $loc->getValue($unit->id, $unitTransaction, 'Tunj. Kinerja'),
      //          'fungsional' => $loc->getValue($unit->id, $unitTransaction, 'Tunj. Fungsional'),
      //          'total' => $loc->getValueGaji($unit->id, $unitTransaction),

      //          'lain' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_penambahan'),
      //          'lembur' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('overtime'),

      //          'bruto' => $loc->getValueGaji($unit->id, $unitTransaction) + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('overtime') + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_penambahan'),

      //          'bpjskt' => $loc->getReduction($unit->id, $unitTransaction, 'JHT'),
      //          'bpjsks' => $loc->getReduction($unit->id, $unitTransaction, 'BPJS KS'),
      //          'jp' => $loc->getReduction($unit->id, $unitTransaction, 'JP'),
      //          'absen' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_absence'),
      //          'terlambat' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_late'),
      //          'gaji_bersih' => ($loc->getValueGaji($unit->id, $unitTransaction) + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('overtime') + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_penambahan') - ($loc->getReduction($unit->id, $unitTransaction, 'JHT') + $loc->getReduction($unit->id, $unitTransaction, 'BPJS KS') + $loc->getReductionAdditional($unit->id, $unitTransaction) + $loc->getReduction($unit->id, $unitTransaction, 'JP') + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_absence') + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_late')))


      //       ]);
            
      //    }
      // }


      
      

      // unit_transactions
      // looping locations
      // get data transactions berdasarkan unit_transaction_id dan location_id
      // get value (sum) transaction_details berdasarkan transaction_id
      // get value (sum) transaction_reductions berdasarkan transaction_id




      // $employees = Employee::join('contracts', 'employees.contract_id', '=', 'contracts.id')
            
      // ->where('contracts.loc', 'kj1-2')
      // ->orWhere('contracts.loc', 'kj1-2-medco')
      // ->orWhere('contracts.loc', 'kj1-2-premier-oil')
      // ->orWhere('contracts.loc', 'kj1-2-petrogas')
      // ->orWhere('contracts.loc', 'kj1-2-star-energy')
      // ->orWhere('contracts.loc', 'kj1-2-housekeeping')
      // ->select('employees.*')
      // ->get();

      // dd('ok');

      $payslipReport = PayslipReport::where('unit_transaction_id', $unitTransaction->id)->first();
      
      if ($payslipReport == null) {
         foreach ($locations as $loc){
            if ($loc->totalEmployee($unit->id) > 0){
               PayslipReport::create([
                  'unit_transaction_id' => $unitTransaction->id,
                  'location_id' => $loc->id,
                  'location_name' => $loc->name,
                  'qty' => count($loc->getUnitTransaction($unit->id, $unitTransaction)),
                  'pokok' => $loc->getValue($unit->id, $unitTransaction, 'Gaji Pokok'),
                  'jabatan' => $loc->getValue($unit->id, $unitTransaction,  'Tunj. Jabatan'),
                  'ops' => $loc->getValue($unit->id, $unitTransaction, 'Tunj. OPS'),
                  'kinerja' => $loc->getValue($unit->id, $unitTransaction, 'Tunj. Kinerja'),
                  'fungsional' => $loc->getValue($unit->id, $unitTransaction, 'Tunj. Fungsional'),
                  'total' => $loc->getValueGaji($unit->id, $unitTransaction),
   
                  'lain' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_penambahan'),
                  'lembur' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('overtime'),
   
                  'bruto' => $loc->getValueGaji($unit->id, $unitTransaction) + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('overtime') + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_penambahan'),
   
                  'bpjskt' => $loc->getReduction($unit->id, $unitTransaction, 'JHT'),
                  'bpjsks' => $loc->getReduction($unit->id, $unitTransaction, 'BPJS KS'),
                  'jp' => $loc->getReduction($unit->id, $unitTransaction, 'JP'),
                  'absen' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_absence'),
                  'terlambat' => $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_late'),
                  'gaji_bersih' => ($loc->getValueGaji($unit->id, $unitTransaction) + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('overtime') + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('additional_penambahan') - ($loc->getReduction($unit->id, $unitTransaction, 'JHT') + $loc->getReduction($unit->id, $unitTransaction, 'BPJS KS') + $loc->getReductionAdditional($unit->id, $unitTransaction) + $loc->getReduction($unit->id, $unitTransaction, 'JP') + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_absence') + $loc->getUnitTransaction($unit->id, $unitTransaction)->sum('reduction_late')))
   
               ]);
               
            }
         }
      }

      $bpjsKsReport = BpjsKsReport::where('unit_transaction_id', $unitTransaction->id)->first();
      if ($bpjsKsReport == null) {
         foreach ($locations as $loc){
            if ($loc->totalEmployee($unitTransaction->unit->id) > 0){
               $bpjsKsReport = BpjsKsReport::where('unit_transaction_id', $unitTransaction->id)->where('location_id', $loc->id)->first();
               if ($bpjsKsReport == null) {
                  BpjsKsReport::create([
                     'unit_transaction_id' => $unitTransaction->id,
                     'location_id' => $loc->id,
                     'location_name' => $loc->name,
                     'program' => 'Jaminan Kesehatan',
                     'tarif' => $unitTransaction->unit->reductions->where('name', 'BPJS KS')->first()->company + $unitTransaction->unit->reductions->where('name', 'BPJS KS')->first()->employee,
                     'qty' => count($loc->getUnitTransaction($unitTransaction->unit_id, $unitTransaction)),
                     'upah' => $loc->getUnitTransactionBpjs($unitTransaction->unit_id, $unitTransaction),
                     'perusahaan' => $loc->getDeductionReal($unitTransaction, 'BPJS KS', 'company'),
                     'karyawan' => $loc->getDeduction($unitTransaction, 'BPJS KS', 'employee'),
                     'total_iuran' => $loc->getDeductionReal($unitTransaction, 'BPJS KS', 'company')+$loc->getDeduction($unitTransaction, 'BPJS KS', 'employee'),
                     'additional_iuran' => $loc->getDeductionAdditional($unitTransaction, 'employee')
                  ]);
               }
            }
         }
      }

      $bpjsKtReport = BpjsKtReport::where('unit_transaction_id', $unitTransaction->id)->first();
      if ($bpjsKtReport == null) {
         foreach ($locations as $loc){
            if ($loc->totalEmployee($unitTransaction->unit->id) > 0){
               BpjsKtReport::create([
                  'unit_transaction_id' => $unitTransaction->id,
                  'location_id' => $loc->id,
                  'location_name' => $loc->name,
                  'program' => 'Jaminan Kecelakaan Kerja (JKK)',
                  'tarif' => $unitTransaction->unit->reductions->where('name', 'JKK')->first()->company + $unitTransaction->unit->reductions->where('name', 'JKK')->first()->employee,
                  'qty' => count($loc->getUnitTransaction($unitTransaction->unit_id, $unitTransaction)),
                  'upah' => $loc->getUnitTransactionBpjs($unitTransaction->unit_id, $unitTransaction),
                  'perusahaan' => $loc->getDeductionReal($unitTransaction, 'JKK', 'company'),
                  'karyawan' => $loc->getDeduction($unitTransaction, 'JKK', 'employee'),
                  'total_iuran' => $loc->getDeductionReal($unitTransaction, 'JKK', 'company')+$loc->getDeduction($unitTransaction, 'JKK', 'employee'),
               ]);
               BpjsKtReport::create([
                  'unit_transaction_id' => $unitTransaction->id,
                  'location_id' => $loc->id,
                  'location_name' => $loc->name,
                  'program' => 'Jaminan Hari Tua (JHT)',
                  'tarif' => $unitTransaction->unit->reductions->where('name', 'JHT')->first()->company + $unitTransaction->unit->reductions->where('name', 'JHT')->first()->employee,
                  'qty' => count($loc->getUnitTransaction($unitTransaction->unit_id, $unitTransaction)),
                  'upah' => $loc->getUnitTransactionBpjs($unitTransaction->unit_id, $unitTransaction),
                  'perusahaan' => $loc->getDeductionReal($unitTransaction, 'JHT', 'company'),
                  'karyawan' => $loc->getDeduction($unitTransaction, 'JHT', 'employee'),
                  'total_iuran' => $loc->getDeductionReal($unitTransaction, 'JHT', 'company')+$loc->getDeduction($unitTransaction, 'JHT', 'employee'),
               ]);
               BpjsKtReport::create([
                  'unit_transaction_id' => $unitTransaction->id,
                  'location_id' => $loc->id,
                  'location_name' => $loc->name,
                  'program' => 'Jaminan Kematian (JKM)',
                  'tarif' => $unitTransaction->unit->reductions->where('name', 'JKM')->first()->company + $unitTransaction->unit->reductions->where('name', 'JKM')->first()->employee,
                  'qty' => count($loc->getUnitTransaction($unitTransaction->unit_id, $unitTransaction)),
                  'upah' => $loc->getUnitTransactionBpjs($unitTransaction->unit_id, $unitTransaction),
                  'perusahaan' => $loc->getDeductionReal($unitTransaction, 'JKM', 'company'),
                  'karyawan' => $loc->getDeduction($unitTransaction, 'JKM', 'employee'),
                  'total_iuran' => $loc->getDeductionReal($unitTransaction, 'JKM', 'company')+$loc->getDeduction($unitTransaction, 'JKM', 'employee'),
               ]);
               BpjsKtReport::create([
                  'unit_transaction_id' => $unitTransaction->id,
                  'location_id' => $loc->id,
                  'location_name' => $loc->name,
                  'program' => 'Jaminan Pensiun',
                  'tarif' => $unitTransaction->unit->reductions->where('name', 'JP')->first()->company + $unitTransaction->unit->reductions->where('name', 'JP')->first()->employee,
                  'qty' => count($loc->getUnitTransaction($unitTransaction->unit_id, $unitTransaction)),
                  'upah' => $loc->getUnitTransactionBpjs($unitTransaction->unit_id, $unitTransaction),
                  'perusahaan' => $loc->getDeductionReal($unitTransaction, 'JP', 'company'),
                  'karyawan' => $loc->getDeduction($unitTransaction, 'JP', 'employee'),
                  'total_iuran' => $loc->getDeductionReal($unitTransaction, 'JP', 'company')+$loc->getDeduction($unitTransaction, 'JP', 'employee'),
               ]);
            }
         }
      }
      

      $payslipReports = PayslipReport::where('unit_transaction_id', $unitTransaction->id)->get();
      $bpjsKsReports = BpjsKsReport::where('unit_transaction_id', $unitTransaction->id)->get();
      $bpjsKtReports = BpjsKtReport::where('unit_transaction_id', $unitTransaction->id)->get();
      // dd($bpjsKsReports);

      return view('pages.payroll.transaction.monthly-loc', [
         'unit' => $unit,
         'units' => $units,
         'locations' => $locations,
         'firstLoc' => $firstLoc,
         'unitTransaction' => $unitTransaction,
         'transactions' => $transactions,

         'hrd' => $hrd,
         'manHrd' => $manHrd,
         'manFin' => $manFin,
         'gm' => $gm,
         'bod' => $bod,

         'reportBpjsKs' => $reportBpjsKs,
         'reportBpjsKt' => $reportBpjsKt,

         'payslipReports' => $payslipReports,
         'bpjsKsReports' => $bpjsKsReports,
         'bpjsKtReports' => $bpjsKtReports
      ])->with('i');
   }

   public function location($unit, $loc)
   {
      // dd('ok');
      $unitTransaction = UnitTransaction::find(dekripRambo($unit));
      $location = Location::find(dekripRambo($loc));
      $transactions = Transaction::where('month', $unitTransaction->month)->where('year', $unitTransaction->year)->where('unit_transaction_id', $unitTransaction->id)->where('location_id', $location->id)->orderBy('name', 'asc')->get();
      // dd($unitTransaction->id);
      // dd($transactions);

      $payslipReport = PayslipReport::where('unit_transaction_id', $unitTransaction->id)->where('location_id', $location->id)->first();

      return view('pages.payroll.report.payslip-loc', [
         'unitTransaction' => $unitTransaction,
         'transactions' => $transactions,
         'location' => $location,
         'payslipReport' => $payslipReport
      ])->with('i');
   }

   public function reportEmployee($id)
   {
      $transaction = Transaction::find(dekripRambo($id));

      return view('pages.payroll.report.payslip-employee', [
         'transaction' => $transaction
      ]);
   }



   public function export($id)
   {
      $unitTransaction = UnitTransaction::find(dekripRambo($id));
      return Excel::download(new TransactionExport($unitTransaction), 'Transaction ' . $unitTransaction->unit->name . ' ' . $unitTransaction->month . ' ' . $unitTransaction->year . '.xlsx');
   }


   public function store($emp, $req, $unitTransaction)
   {
      $employee = Employee::find($emp->id);
      $payroll = Payroll::find($employee->payroll_id);
      $locations = Location::get();

      foreach ($locations as $loc) {
         if ($loc->code == $employee->contract->loc) {
            $location = $loc->id;
         }
      }

      // if ($employee->contract->loc == null) {
      //    return redirect()->back()->with('danger', 'Data Lokasi Kerja Kosong '. $employee->nik . ' ' . $employee->biodata->fullName());
      // }

      $now = Carbon::today();
      $month = $now->format('F');
      // dd($month);
      $year = $now->format('Y');
      // dd($now->format('d/m/Y'));

      // $reductionEmployees = ReductionEmployee::where('employee_id', $employee->id)->get();
      // dd($reductionEmployees);


      // 02 Create Transaction by employee
      $transaction = Transaction::create([
         'status' => 0,
         'unit_transaction_id' => $unitTransaction->id,
         'unit_id' => $emp->unit_id,
         'location_id' => $location,
         'employee_id' => $employee->id,
         'name' => $employee->biodata->first_name,
         'payroll_id' => $payroll->id,
         'cut_from' => $req->from,
         'cut_to' => $req->to,
         'month' => $req->month,
         'year' => $req->year,
         'total' => 0,
         'payslip_status' => $payroll->payslip_status
      ]);


      // 03 Create transaction detail Gaji Pokok
      TransactionDetail::create([
         'transaction_id' => $transaction->id,
         'type' => 'basic',
         'desc' => 'Gaji Pokok',
         'value' => $payroll->pokok,
      ]);

      // 04 Create transaction detail Tunj Jabatan
      TransactionDetail::create([
         'transaction_id' => $transaction->id,
         'type' => 'basic',
         'desc' => 'Tunj. Jabatan',
         'value' => $payroll->tunj_jabatan,
      ]);

      // 05 Create transaction detail Tunj OPS
      TransactionDetail::create([
         'transaction_id' => $transaction->id,
         'type' => 'basic',
         'desc' => 'Tunj. OPS',
         'value' => $payroll->tunj_ops,
      ]);

      // 06 Create transaction detail Tunj Kinerja
      TransactionDetail::create([
         'transaction_id' => $transaction->id,
         'type' => 'basic',
         'desc' => 'Tunj. Kinerja',
         'value' => $payroll->tunj_kinerja,
      ]);

      // 07 Create transaction detail Tunj Fungsional
      TransactionDetail::create([
         'transaction_id' => $transaction->id,
         'type' => 'basic',
         'desc' => 'Tunj. Fungsional',
         'value' => $payroll->tunj_fungsional,
      ]);

      // 08 Create transaction detail insentif
      TransactionDetail::create([
         'transaction_id' => $transaction->id,
         'type' => 'basic',
         'desc' => 'Insentif',
         'value' => $payroll->insentif,
      ]);

      $reductions = Reduction::where('unit_id', $employee->unit_id)->get();

      
      $reductionEmployees = ReductionEmployee::where('employee_id', $employee->id)->where('type', 'Default')->get();
      foreach ($reductionEmployees as $red) {
        

         if ($red->status == 1) {

            //09 Create Transaction Reduction berdasarkan Reduction Employee beban perusahaan
            TransactionReduction::create([
               'transaction_id' => $transaction->id,
               'reduction_id' => $red->reduction_id,
               'reduction_employee_id' => $red->id,
               'class' => $red->type,
               'type' => 'company',
               'location_id' => $location,
               'name' => $red->reduction->name . $red->description,
               'value' => $red->company_value,
               'value_real' => $red->company_value_real,
               // 'value' => $bebanPerusahaan,
               // 'value_real' => $bebanPerusahaanReal
            ]);

            //10 Create Transaction Reduction berdasarkan Reduction Employee beban karyawan
            TransactionReduction::create([
               'transaction_id' => $transaction->id,
               'reduction_id' => $red->reduction_id,
               'reduction_employee_id' => $red->id,
               'class' => $red->type,
               'type' => 'employee',
               'location_id' => $location,
               'name' => $red->reduction->name . $red->description,
               'value' => $red->employee_value,
               'value_real' => $red->employee_value_real,
               // 'value' => $bebanKaryawan,
               // 'value_real' => $bebanKaryawanReal
            ]);
         }
      }

      $reductionAddEmployees = ReductionEmployee::where('employee_id', $employee->id)->where('type', 'Additional')->get();
      foreach ($reductionAddEmployees as $red) {

         //11 Create Transaction Reduction Additional berdasarkan Reduction Employee beban perusahaan
         TransactionReduction::create([
            'transaction_id' => $transaction->id,
            'reduction_id' => $red->reduction_id,
            'reduction_employee_id' => $red->id,
            'class' => $red->type,
            'type' => 'company',
            'location_id' => $location,
            'name' => $red->reduction->name . $red->description,
            'value' => $red->company_value,
            'value_real' => $red->company_value_real,
         ]);

         //12 Create Transaction Reduction Additional berdasarkan Reduction Employee beban karyawan
         TransactionReduction::create([
            'transaction_id' => $transaction->id,
            'reduction_id' => $red->reduction_id,
            'reduction_employee_id' => $red->id,
            'class' => $red->type,
            'type' => 'employee',
            'location_id' => $location,
            'name' => $red->reduction->name . $red->description,
            'value' => $red->employee_value,
            'value_real' => $red->employee_value_real,
         ]);
      }


      // 13 Update ketika karyawan baru
      if ($employee->join > $req->from) {
         $transaction->update([
            'remark' => 'Karyawan Baru'
         ]);
      }

      // 14 Kalkulasi total transaction
      $this->calculateTotalTransaction($transaction, $req->from, $req->to);


      return redirect()->back()->with('success', 'Payroll Transaction successfully added');
   }



   public function calculateTotalTransaction($transaction, $from, $to)
   {
      $employee = Employee::find($transaction->employee_id);
      $payroll = Payroll::find($employee->payroll_id);
      $transactionDetails = TransactionDetail::where('transaction_id', $transaction->id)->get();

      $overtimes = Overtime::where('date', '>=', $from)->where('date', '<=', $to)->where('employee_id', $employee->id)->where('status', 1)->get();
      // dd($from);
      

      $alphas = $employee->absences->where('date', '>=', $from)->where('date', '<=', $to)->where('type', 1);
      $izinFullDays = $employee->absences->where('date', '>=', $from)->where('date', '<=', $to)->where('type', 4)->where('type_izin', 'Satu Hari');
      foreach ($alphas as $alpha) {

         $alpha->update([
            'value' => 1 * 1 / 30 * $payroll->total
         ]);
      }

      foreach ($izinFullDays as $izin) {

         $izin->update([
            'value' => 1 * 1 / 30 * $payroll->total
         ]);
      }
      $totalAlpha = $alphas->sum('value') + $izinFullDays->sum('value');

      $offContracts = $employee->absences->where('date', '>=', $from)->where('date', '<=', $to)->where('type', 9);
      foreach ($offContracts as $off) {

         $off->update([
            'value' => 1 * 1 / 30 * $payroll->total
         ]);
      }
      $totalOffContract = $offContracts->sum('value');



      $lates = $employee->absences->where('date', '>=', $from)->where('date', '<=', $to)->where('type', 2);
      $totalMinuteLate = $lates->sum('minute');
      // dd($totalMinuteLate);
      $keterlambatan = intval(floor($totalMinuteLate / 30));
      // dd($keterlambatan);
      $atls = $employee->absences->where('date', '>=', $from)->where('date', '<=', $to)->where('type', 3);
      $totalAtlLate = count($atls) * 2;


      $totalKeterlambatan = $keterlambatan + $totalAtlLate;


      // dd($totalKeterlambatan);


      if ($totalKeterlambatan == 6) {
         $potongan = 1 * 1 / 30 * $payroll->total;
      } elseif ($totalKeterlambatan > 6) {
         $potonganFirst = 1 * 1 / 30 * $payroll->total;

         $sisaLate = $totalKeterlambatan - 6;
         $potonganSecond = $potonganFirst * 1 / 5 * $sisaLate;
         $potongan = $potonganFirst +  $potonganSecond;
         // dd($finalLate);
         // dd($payroll->total);
      } else {
         $potongan = 0;
      }




      $izins = $employee->absences->where('month', $transaction->month)->where('type', 3);

      // additoinal penambahan & pengurangan
      $addPenambahan = Additional::where('employee_id', $employee->id)->where('date', '>=', $from)->where('date', '<=', $to)->where('type', 1)->get()->sum('value');
      $addPengurangan = Additional::where('employee_id', $employee->id)->where('date', '>=', $from)->where('date', '<=', $to)->where('type', 2)->get()->sum('value');


      // $reductionAlpha = null;
      // foreach ($alphas as $alpha) {
      //    $reductionAlpha = $reductionAlpha + 1 * 1 / 30 * $payroll->total;
      // }


      // dd($overtimes->sum('rate'));
      $redAdditionals = ReductionEmployee::where('employee_id', $employee->id)->where('type', 'Additional')->get();

      $totalReduction = $transaction->reductions->where('type', 'employee')->sum('value');
      // dd($totalReduction);
      $totalOvertime = $overtimes->sum('rate');
      $totalReductionAbsence = $totalAlpha + $totalOffContract;


      $bruto = $transactionDetails->sum('value') + $addPenambahan + $totalOvertime;
      $total_deduction =  $totalReduction  + $totalReductionAbsence  + $addPengurangan  + $potongan ;


      $transaction->update([
         'overtime' => $totalOvertime,
         'reduction' => $totalReduction,
         'reduction_absence' => $totalReductionAbsence,
         'reduction_late' => $potongan,
         'additional_penambahan' => $addPenambahan,
         'additional_pengurangan' => $addPengurangan,
         'bruto' => $bruto,
         'total_deduction' => $total_deduction,
         'total' => $bruto - $total_deduction
      ]);

      // dd($payroll->total);

      if ($employee->join > $transaction->cut_from && $employee->join < $transaction->cut_to) {
         $datetime0 = new DateTime($transaction->cut_to);
         $datetime1 = new DateTime($transaction->cut_from);
         $datetime2 = new DateTime($employee->join);
         $interval = $datetime1->diff($datetime2);
         // dd($interval->days);
         $rate = 1 * 1 / 30 * $payroll->total;
         $qty = 0;
         foreach (range(0, $interval->days) as $item) {
            $qty += 1;
         }

         $offQty = $qty - 2;
         // dd($interval->days);

         // for ($x = 0; $x <= $interval->days; $x++) {
         //    $qty += 1;
         // }

         // dd($interval);
         $reductionOff = $rate * $offQty;
         $transaction->update([
            'remark' => 'Karyawan Baru',
            'off' => $offQty,
            'reduction_off' => $reductionOff,
            'total' => $transaction->total - $reductionOff
         ]);
      } 
      elseif($employee->off > $transaction->cut_from && $employee->off < $transaction->cut_to){
         $datetime1 = new DateTime($employee->off);
         $datetime2 = new DateTime($transaction->cut_to);
         $interval = $datetime1->diff($datetime2);
         // dd($interval->days);
         $rate = 1 * 1 / 30 * $payroll->total;
         $qty = 0;
         foreach (range(0, $interval->days) as $item) {
            $qty += 1;
         }

         $offQty = $qty - 1;
         // dd($interval->days);

         // for ($x = 0; $x <= $interval->days; $x++) {
         //    $qty += 1;
         // }

         // dd($interval);
         $reductionOff = $rate * $offQty;
         $transaction->update([
            'remark' => 'Karyawan Out',
            'off' => $offQty,
            'reduction_off' => $reductionOff,
            'total' => $transaction->total - $reductionOff
         ]);
      } 
      else {
         $transaction->update([
            'remark' => null,
            'off' => 0,
            'reduction_off' => 0,
            'total' => ($transactionDetails->sum('value') + $totalOvertime + $addPenambahan) - ($totalReduction  + $totalReductionAbsence + $addPengurangan +  $potongan)
         ]);
      }
   }
}
