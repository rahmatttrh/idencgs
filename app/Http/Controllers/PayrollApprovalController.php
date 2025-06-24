<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PayrollApproval;
use App\Models\PayslipReport;
use App\Models\Transaction;
use App\Models\UnitTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PayrollApprovalController extends Controller
{

   public function submit(Request $req)
   {
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $unitTransaction = UnitTransaction::find($req->unitTransactionId);
      $transactions = Transaction::where('unit_transaction_id', $unitTransaction->id)->get();
      $payslipReports = PayslipReport::where('unit_transaction_id', $unitTransaction->id)->get();
      // dd($unitTransaction->id);
      $unitTransaction->update([
         'status' => 1
      ]);



      foreach ($transactions as $tran) {
         $tran->update([
            'status' => 1
         ]);
      }

      foreach($payslipReports as $report){
         $report->update([
            'status' => 0
         ]);
      }
      
      $oldApproval = PayrollApproval::where('unit_transaction_id', $unitTransaction->id)->get();
      foreach($oldApproval as $old){
         $old->delete();
      }

      PayrollApproval::create([
         'unit_transaction_id' => $unitTransaction->id,
         'employee_id' => $employee->id,
         'level' => 'hrd',
         'type' => 'submit',
      ]);

      return redirect()->back()->with('success', "Transaction Data successfully sent");
   }

   public function publish(Request $req)
   {
      $employee = Employee::where('nik', auth()->user()->username)->first();
      $unitTransaction = UnitTransaction::find($req->unitTransactionId);
      $transactions = Transaction::where('unit_transaction_id', $unitTransaction->id)->get();
      // dd($unitTransaction->id);
      $unitTransaction->update([
         'status' => 6
      ]);

      foreach ($transactions as $tran) {
         $tran->update([
            'status' => 6
         ]);
      }

      PayrollApproval::create([
         'unit_transaction_id' => $unitTransaction->id,
         'employee_id' => $employee->id,
         'level' => 'hrd',
         'type' => 'publish',
      ]);

      return redirect()->back()->with('success', "Transaction Data successfully published");
   }

   public function approveLocation(Request $req){
      $payslipReport = PayslipReport::find($req->payslipReport);

      if (auth()->user()->username == 'EN-2-001' || auth()->user()->username == 'EN-4-093') {
         $status = 1;
      } else if(auth()->user()->username == '11304'){
         $status = 2;
      } else if(auth()->user()->username == 'EN-2-006'){
         $status = 3;
      } else if(auth()->user()->username == 'BOD-002'){
         $status = 4;
      }
      $payslipReport->update([
         'status' => $status
      ]);

      return redirect()->route('payroll.transaction.monthly', enkripRambo($payslipReport->unit_transaction_id))->with('success', "Payslip Report Location berhasil di Approve");

   }

   public function rejectLocation(Request $req){
      $payslipReport = PayslipReport::find($req->payslipReport);

      if (auth()->user()->username == 'EN-2-001') {
         $status = 101;
      } else if(auth()->user()->username == '11304'){
         $status = 202;
      } else if(auth()->user()->username == 'EN-2-006'){
         $status = 303;
      } else if(auth()->user()->username == 'BOD-002'){
         $status = 404;
      }

      $employee = Employee::where('nik', auth()->user()->username)->first();

      $payslipReport->update([
         'status' => $status,
         'reject_by' => $employee->id,
         'reject_date' => Carbon::now(),
         'reject_desc' => $req->remark
      ]);

      return redirect()->route('payroll.transaction.monthly', enkripRambo($payslipReport->unit_transaction_id))->with('success', "Payslip Report Location berhasil di Reject");

   }

   public function hrd()
   {

      $unitTransactions = UnitTransaction::where('status', '=', 1)->get();

      return view('pages.payroll.approval.hrd', [
         'unitTransactions' => $unitTransactions
      ])->with('i');
   }

   public function approveHrd(Request $req)
   {

      $employee = Employee::where('nik', auth()->user()->username)->first();
      $unitTransaction = UnitTransaction::find($req->unitTransactionId);
      $transactions = Transaction::where('unit_transaction_id', $unitTransaction->id)->get();
      

      $unitTransaction->update([
         'status' => 2
      ]);

      $payslipReports = PayslipReport::where('unit_transaction_id', $unitTransaction->id)->get();
      foreach($payslipReports as $report){
         $report->update([
            'status' => 1
         ]);
      }

      foreach ($transactions as $transaction) {
         $transaction->update([
            'status' => 2
         ]);
      }

      PayrollApproval::create([
         'unit_transaction_id' => $unitTransaction->id,
         'employee_id' => $employee->id,
         'level' => 'man-hrd',
         'type' => 'approve',
      ]);

      return redirect()->back()->with('success', 'Payroll approved');
   }

   public function rejectHrd(Request $req)
   {

      $employee = Employee::where('nik', auth()->user()->username)->first();
      $unitTransaction = UnitTransaction::find($req->unitTransactionId);
      // $transactions = Transaction::where('unit_transaction_id', $unitTransaction->id)->get();

      $unitTransaction->update([
         'status' => 101,
         'reject_by' => $employee->id,
         'reject_date' => Carbon::now(),
         'reject_desc' => $req->remark
      ]);

     

      return redirect()->back()->with('success', 'Payslip Report berhasil di Reject');
   }

   public function manfin()
   {

      // dd('ok');
      $unitTransactions = UnitTransaction::where('status', '=', 2)->get();

      return view('pages.payroll.approval.hrd', [
         'unitTransactions' => $unitTransactions
      ])->with('i');
   }

   public function approveManfin(Request $req)
   {

      $employee = Employee::where('nik', auth()->user()->username)->first();
      $unitTransaction = UnitTransaction::find($req->unitTransactionId);
      $transactions = Transaction::where('unit_transaction_id', $unitTransaction->id)->get();

      $unitTransaction->update([
         'status' => 3
      ]);

      $payslipReports = PayslipReport::where('unit_transaction_id', $unitTransaction->id)->get();
      foreach($payslipReports as $report){
         $report->update([
            'status' => 2
         ]);
      }

      foreach ($transactions as $transaction) {
         $transaction->update([
            'status' => 3
         ]);
      }

      PayrollApproval::create([
         'unit_transaction_id' => $unitTransaction->id,
         'employee_id' => $employee->id,
         'level' => 'man-fin',
         'type' => 'approve',
      ]);

      return redirect()->back()->with('success', 'Payroll approved');
   }

   public function rejectManFin(Request $req)
   {

      $employee = Employee::where('nik', auth()->user()->username)->first();
      $unitTransaction = UnitTransaction::find($req->unitTransactionId);
      // $transactions = Transaction::where('unit_transaction_id', $unitTransaction->id)->get();

      $unitTransaction->update([
         'status' => 202,
         'reject_by' => $employee->id,
         'reject_date' => Carbon::now(),
         'reject_desc' => $req->remark
      ]);

     

      return redirect()->back()->with('success', 'Payslip Report berhasil di Reject');
   }

   public function gm()
   {

      $unitTransactions = UnitTransaction::where('status', '=', 3)->get();

      return view('pages.payroll.approval.hrd', [
         'unitTransactions' => $unitTransactions
      ])->with('i');
   }

   public function approveGm(Request $req)
   {

      $employee = Employee::where('nik', auth()->user()->username)->first();
      $unitTransaction = UnitTransaction::find($req->unitTransactionId);
      $transactions = Transaction::where('unit_transaction_id', $unitTransaction->id)->get();

      $unitTransaction->update([
         'status' => 4
      ]);

      $payslipReports = PayslipReport::where('unit_transaction_id', $unitTransaction->id)->get();
      foreach($payslipReports as $report){
         $report->update([
            'status' => 3
         ]);
      }

      foreach ($transactions as $transaction) {
         $transaction->update([
            'status' => 4
         ]);
      }

      PayrollApproval::create([
         'unit_transaction_id' => $unitTransaction->id,
         'employee_id' => $employee->id,
         'level' => 'gm',
         'type' => 'approve',
      ]);

      return redirect()->back()->with('success', 'Payslip Report berhasil di Approve');
   }

   public function rejectGm(Request $req)
   {

      $employee = Employee::where('nik', auth()->user()->username)->first();
      $unitTransaction = UnitTransaction::find($req->unitTransactionId);
      // $transactions = Transaction::where('unit_transaction_id', $unitTransaction->id)->get();

      $unitTransaction->update([
         'status' => 303,
         'reject_by' => $employee->id,
         'reject_date' => Carbon::now(),
         'reject_desc' => $req->remark
      ]);

      // $payslipReports = PayslipReport::where('unit_transaction_id', $unitTransaction->id)->get();
      // foreach($payslipReports as $report){
      //    $report->update([
      //       'status' => 3
      //    ]);
      // }

      // foreach ($transactions as $transaction) {
      //    $transaction->update([
      //       'status' => 4
      //    ]);
      // }

      // PayrollApproval::create([
      //    'unit_transaction_id' => $unitTransaction->id,
      //    'employee_id' => $employee->id,
      //    'level' => 'gm',
      //    'type' => 'approve',
      // ]);

      return redirect()->back()->with('success', 'Payslip Report berhasil di Reject');
   }

   public function bod()
   {

      $unitTransactions = UnitTransaction::where('status', '=', 4)->get();
      
      return view('pages.payroll.approval.hrd', [
         'unitTransactions' => $unitTransactions
      ])->with('i');
   }

   public function approveBod(Request $req)
   {

      $employee = Employee::where('nik', auth()->user()->username)->first();
      $unitTransaction = UnitTransaction::find($req->unitTransactionId);
      $transactions = Transaction::where('unit_transaction_id', $unitTransaction->id)->get();

      $unitTransaction->update([
         'status' => 5
      ]);

      $payslipReports = PayslipReport::where('unit_transaction_id', $unitTransaction->id)->get();
      foreach($payslipReports as $report){
         $report->update([
            'status' => 4
         ]);
      }

      foreach ($transactions as $transaction) {
         $transaction->update([
            'status' => 5
         ]);
      }

      PayrollApproval::create([
         'unit_transaction_id' => $unitTransaction->id,
         'employee_id' => $employee->id,
         'level' => 'bod',
         'type' => 'approve',
      ]);

      

      return redirect()->route('payroll.approval.bod', enkripRambo($unitTransaction->id))->with('success', 'Payslip Report approved');
   }

   public function rejectBod(Request $req)
   {

      $employee = Employee::where('nik', auth()->user()->username)->first();
      $unitTransaction = UnitTransaction::find($req->unitTransactionId);
      // $transactions = Transaction::where('unit_transaction_id', $unitTransaction->id)->get();

      $unitTransaction->update([
         'status' => 404,
         'reject_by' => $employee->id,
         'reject_date' => Carbon::now(),
         'reject_desc' => $req->remark
      ]);

     

      return redirect()->back()->with('success', 'Payslip Report berhasil di Reject');
   }

   public function manhrdHistory()
   {

      $unitTransactions = UnitTransaction::where('status', '>', 1)->orderBy('unit_id', 'asc')->get();

      return view('pages.payroll.approval.history', [
         'unitTransactions' => $unitTransactions
      ])->with('i');
   }

   public function manfinHistory()
   {

      $unitTransactions = UnitTransaction::where('status', '>', 2)->orderBy('unit_id', 'asc')->get();

      return view('pages.payroll.approval.history', [
         'unitTransactions' => $unitTransactions
      ])->with('i');
   }

   public function gmHistory()
   {

      $unitTransactions = UnitTransaction::where('status', '>', 3)->get();

      return view('pages.payroll.approval.history', [
         'unitTransactions' => $unitTransactions
      ])->with('i');
   }

   public function bodHistory()
   {

      $unitTransactions = UnitTransaction::where('status', '>', 4)->get();

      return view('pages.payroll.approval.history', [
         'unitTransactions' => $unitTransactions
      ])->with('i');
   }




   public function approveBodLocation(Request $req){
      $payslipReport = PayslipReport::find($req->payslipReport);
      $unitTransaction = UnitTransaction::find($payslipReport->unit_transaction_id);

      $payslipReport->update([
         'status' => 5
      ]);


      return redirect()->route('payroll.transaction.monthly', enkripRambo($unitTransaction->id))->with('success', 'Pasylip Report '. $payslipReport->location_name . ' approved' );
   }
}
