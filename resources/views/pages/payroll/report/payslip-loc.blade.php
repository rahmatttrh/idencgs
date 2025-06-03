@extends('layouts.app')
@section('title')
Payroll Transaction
@endsection
@section('content')

<style>
   .hori-timeline .events {
      border-top: 3px solid #e9ecef;
   }
   .hori-timeline .events .event-list {
      display: block;
      position: relative;
      text-align: center;
      padding-top: 70px;
      margin-right: 0;
   }
   .hori-timeline .events .event-list:before {
      content: "";
      position: absolute;
      height: 36px;
      border-right: 2px dashed #dee2e6;
      top: 0;
   }
   .hori-timeline .events .event-list .event-date {
      position: absolute;
      top: 38px;
      left: 0;
      right: 0;
      width: 75px;
      margin: 0 auto;
      border-radius: 4px;
      padding: 2px 4px;
   }
   @media (min-width: 1140px) {
      .hori-timeline .events .event-list {
         display: inline-block;
         width: 24%;
         padding-top: 45px;
      }
      .hori-timeline .events .event-list .event-date {
         top: -12px;
      }
   }
   .bg-soft-primary {
      background-color: rgba(64,144,203,.3)!important;
   }
   .bg-soft-success {
      background-color: rgba(71,189,154,.3)!important;
   }
   .bg-soft-danger {
      background-color: rgba(231,76,94,.3)!important;
   }
   .bg-soft-warning {
      background-color: rgba(249,213,112,.3)!important;
   }
   .card {
      border: none;
      margin-bottom: 24px;
      -webkit-box-shadow: 0 0 13px 0 rgba(236,236,241,.44);
      box-shadow: 0 0 13px 0 rgba(236,236,241,.44);
   }
</style>

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         @if (auth()->user()->username == 'EN-2-001' || auth()->user()->username == '11304' || auth()->user()->username == 'EN-2-006' || auth()->user()->username == 'BOD-002' )
         @else
         <li class="breadcrumb-item" aria-current="page"><a href="{{route('payroll.transaction.monthly.all', enkripRambo($unitTransaction->id))}}">Transaction</a></li>
         @endif
         <li class="breadcrumb-item" aria-current="page">{{$unitTransaction->unit->name}}</li>
         <li class="breadcrumb-item" aria-current="page">{{$unitTransaction->month}}</li>
         <li class="breadcrumb-item" aria-current="page">Payslip Report </li>
         <li class="breadcrumb-item active" aria-current="page">{{$location->name}}/ </li>
      </ol>
   </nav>
   
   <div class="d-flex">
      <a href="{{route('payroll.transaction.monthly', enkripRambo($unitTransaction->id))}}" class="btn btn-light border mb-2  mr-2 "><i class="fa fa-backward"></i> Back</a>
      
      @if (auth()->user()->username == 'EN-2-001')
         @if ($payslipReport->status == null)
            <div class="btn-group ml-2 mb-2">
               <a href="#" class="btn btn-primary" data-target="#approve-payslip-loc" data-toggle="modal">Approve</a>
               <a href="" class="btn btn-danger">Reject</a>
            </div>
         @endif   
      @endif

      @if (auth()->user()->username == '11304')
         @if ($payslipReport->status == 1)
            <div class="btn-group ml-2 mb-2">
               <a href="#" class="btn btn-primary" data-target="#approve-payslip-loc" data-toggle="modal">Approve</a>
               <a href="" class="btn btn-danger">Reject</a>
            </div>
         @endif   
      @endif

      
      @if (auth()->user()->username == 'EN-2-006')
      
         @if ($payslipReport->status == 2)
         
            <div class="btn-group ml-2 mb-2">
               <a href="#" class="btn btn-primary" data-target="#approve-payslip-loc" data-toggle="modal">Approve</a>
               <a href="#" class="btn btn-danger" data-target="#reject-payslip-loc" data-toggle="modal">Reject</a>
            </div>
         @endif   
      @endif
   </div>
   

   <div class="card  shadow-none border">
      <div class="card-header  d-flex justify-content-between ">
         <div class="">
            <h4 class="text-uppercase"><b>PAYSLIP REPORT </b> 
            </h4>
            <h2 class="text-uppercase">
                 {{$unitTransaction->unit->name}} <br> <span>{{$payslipReport->location->name}}</span> <br> {{$unitTransaction->month}} {{$unitTransaction->year}}
            </h2>
            <small>{{count($transactions)}} Transaksi</small>
         </div>
         <span>
            @if (auth()->user()->username == 'EN-2-001')
               @if ($payslipReport->status == 1)
                  <span>Approved Man. HRD</span>
                  @else
                  <span>Waiting Validation</span>
               @endif
            @endif

            @if (auth()->user()->username == '11304')
               @if ($payslipReport->status == 2)
                  <span>Approved Man. Finance</span>
                  @else
                  <span>Waiting Validation</span>
               @endif
            @endif

            @if (auth()->user()->username == 'EN-2-006' || auth()->user()->hasRole('Administrator|HRD-Payroll|HRD'))
               @if ($payslipReport->status == 3)
                  <span>Approved GM</span>
                  @else
                     @if ($payslipReport->status == 303)
                        <div class="card card-danger">
                           <div class="card-body">
                              <span class=""><b>Reject GM</b></span><br>
                        {{$payslipReport->rejectBy->nik}} {{$payslipReport->rejectBy->biodata->fullName()}} <br>
                        {{formatDateTime($payslipReport->reject_date)}} <br>
                        {{$payslipReport->reject_desc}}
                           </div>
                        </div>
                        
                        @else
                        <span>Waiting Validation</span>
                     @endif
                  
               @endif
            @endif
           
         </span>
         
         {{-- <div class="text-right">
            <h2 class="mt-3"> <b>{{formatRupiahB($unitTransaction->unit->getUnitTransaction($unitTransaction)->sum('total'))}}</b> <br>Total Karyawan <span class="text-uppercase"> {{count($location->getUnitTransaction($unitTransaction->unit->id, $unitTransaction))}} </span> </h2>
         </div> --}}
         
      </div>
      {{-- <div class="card-header">
         <div class="row row-nav-line">
            <ul class="nav nav-tabs nav-line nav-color-secondary" role="tablist">
               <li class="nav-item"> <a class="nav-link show active" id="pills-payslip-tab-nobd" data-toggle="pill" href="#pills-payslip-nobd" role="tab" aria-controls="pills-payslip-nobd" aria-selected="true">Payslip Report</a> </li>
               @if (auth()->user()->username == 'EN-2-001' || auth()->user()->username == '11304' || auth()->user()->username == 'EN-2-006' || auth()->user()->username == 'BOD-002' )
               <li class="nav-item"> <a class="nav-link " id="pills-ks-tab-nobd" data-toggle="pill" href="#pills-ks-nobd" role="tab" aria-controls="pills-ks-nobd" aria-selected="true">BPJS Kesehatan</a> </li>
               <li class="nav-item"> <a class="nav-link " id="pills-kt-tab-nobd" data-toggle="pill" href="#pills-kt-nobd" role="tab" aria-controls="pills-kt-nobd" aria-selected="true">BPJS Ketenagakerjaan</a> </li>
               @endif
            </ul>
         </div>
      </div> --}}
      {{-- {{count(transactions)}} --}}
      <div class="card-body p-0">
         <div class="table-responsive p-0 pt-2" style="overflow-x: auto;">
            <table id="data" class="display  table-sm">
               <thead >
                  
                  <tr>
                     <th class="text-white">NIK</th>
                     <th class="text-white">Name</th>
                     <th class="text-center text-white">Gaji Pokok</th>
                     <th class="text-center text-white">Tunj. Jabatan</th>
                     <th class="text-center text-white">Tunj. OPS</th>
                     <th class="text-center text-white">Tunj. Kinerja</th>
                     <th class="text-center text-white">Tunj. Fungsional</th>
                     <th class="text-center text-white">Total Gaji</th>
                     <th class="text-center text-white">Lembur</th>
                     <th class="text-center text-white">Lain-Lain</th>
                     <th class="text-center text-white">Total Bruto</th>
                     <th class="text-center text-white">BPJS TK</th>
                     <th class="text-center text-white">BPJS KS</th>
                     {{-- <th class="text-center text-white">BPJS Additional</th> --}}
                     <th class="text-center text-white">JP</th>
                     <th class="text-center text-white">Absen</th>
                     <th class="text-center text-white">Terlambat</th>
                     <th class="text-center text-white">Total</th>
                     
                  </tr>
               </thead>

               <tbody>
                  @php
                     $totalPokok = 0;
                     $totalJabatan = 0;
                     $totalOps = 0;
                     $totalKinerja = 0;
                     $totalFungsional = 0;
                     $totalGaji = 0;
                     $totalOvertime = 0;
                     $totalAdditionalPenambahan = 0;
                     $totalBruto = 0;
                     $totalTk = 0;
                     $totalKs = 0;
                     $totalJp = 0;
                     $totalAbsence = 0;
                     $totalLate = 0;
                     $totalGrand = 0;
                  @endphp

                  @foreach ($transactions as $transaction)
                  @if ($transaction->remark == 'Karyawan Baru')
                     
                     @php
                        
                        $proratePokok = $transaction->employee->payroll->pokok / 30;
                        $qtyPokok = 30 - $transaction->off;
                        $nominalPokok = $proratePokok * $qtyPokok;

                        $prorateJabatan = $transaction->employee->payroll->tunj_jabatan / 30;
                        $qtyJabatan = 30 - $transaction->off;
                        $nominalJabatan = $prorateJabatan * $qtyJabatan;

                        $prorateOps = $transaction->employee->payroll->tunj_ops / 30;
                        $qtyOps = 30 - $transaction->off;
                        $nominalOps = $prorateOps * $qtyOps;

                        $prorateKinerja = $transaction->employee->payroll->tunj_kinerja / 30;
                        $qtyKinerja = 30 - $transaction->off;
                        $nominalKinerja = $prorateKinerja * $qtyKinerja;

                        $prorateFungsional = $transaction->employee->payroll->tunj_fungsional / 30;
                        $qtyFungsional = 30 - $transaction->off;
                        $nominalFungsional = $prorateFungsional * $qtyFungsional;

                        $prorateTotal = $transaction->employee->payroll->total / 30;
                        $qtyTotal = 30 - $transaction->off;
                        $nominalTotal = $prorateTotal * $qtyTotal;
                     @endphp
                     <tr>
                        <td class="text-truncate"><a href="{{route('payroll.transaction.report.employee', enkripRambo($transaction->id))}}">{{$transaction->employee->nik}} </a></td>
                        <td class="text-truncate" style="max-width: 150px" ><a href="{{route('payroll.transaction.report.employee', enkripRambo($transaction->id))}}">{{$transaction->employee->biodata->fullName()}}</a></td>
                        <td class="text-right">{{formatRupiahB($nominalPokok)}}</td>
                        <td class="text-right">{{formatRupiahB($nominalJabatan)}}</td>
                        <td class="text-right">{{formatRupiahB($nominalOps)}}</td>
                        <td class="text-right">{{formatRupiahB($nominalKinerja)}}</td>
                        <td class="text-right">{{formatRupiahB($nominalFungsional)}}</td>
                        <td class="text-right">{{formatRupiahB($nominalTotal)}}</td>
                        <td class="text-right">{{formatRupiahB($transaction->overtime)}}</td>
                        <td class="text-right">{{formatRupiahB($transaction->additional_penambahan)}}</td>
                        <td class="text-right">{{formatRupiahB($nominalTotal + $transaction->overtime + $transaction->additional_penambahan)}}</td>
                     
                        <td class="text-right">
                           {{-- @if ($transaction->getDeduction('JHT', 'employee') != null )
                              {{formatRupiahB(2/100 * $transaction->employee->payroll->total)}}
                              @else
                              0
                           @endif --}}
                           {{formatRupiahB($transaction->getDeduction('JHT', 'employee'))}}
                           {{-- {{formatRupiahB($loc->getReduction($unit->id, $unitTransaction, 'JHT'))}} --}}
                        </td>
                        <td class="text-right">{{formatRupiahB($transaction->getDeduction('BPJS KS', 'employee') + $transaction->getAddDeduction( 'employee'))}}</td>
                        {{-- <td class="text-right">{{formatRupiahB()}}</td> --}}
                        <td class="text-right">{{formatRupiahB($transaction->getDeduction('JP', 'employee'))}} </td>
                        <td class="text-right">{{formatRupiahB($transaction->reduction_absence)}}</td>
                        <td class="text-right">{{formatRupiahB($transaction->reduction_late)}}</td>
                        <td class="text-right">{{formatRupiahB($transaction->total)}}</td>
                     
                     </tr>

                     @php
                        $pokok =  $nominalPokok;
                        $jabatan = $nominalJabatan;
                        $ops = $nominalOps;
                        $kinerja = $nominalKinerja;
                        $fungsional = $nominalFungsional;
                        $gaji = $nominalTotal;
                        $overtime = $transaction->overtime;
                        $additional_penambahan = $transaction->additional_penambahan;
                        $bruto = $nominalTotal + $transaction->overtime + $transaction->additional_penambahan;
                        // $tk = 2/100 * $transaction->employee->payroll->total;
                        $tk = $transaction->getDeduction('JHT', 'employee');
                        $ks = $transaction->getDeduction('BPJS KS', 'employee') + $transaction->getAddDeduction( 'employee');
                        $ksAdd = $transaction->getDeductionAdditional();
                        $jp = $transaction->getDeduction('JP', 'employee');
                        $abs = $transaction->reduction_absence;
                        $late = $transaction->reduction_late;
                        $total = $transaction->total;

                        $totalPokok += $pokok;
                        $totalJabatan += $jabatan;
                        $totalOps += $ops;
                        $totalKinerja += $kinerja;
                        $totalFungsional += $fungsional;
                        $totalGaji += $gaji;
                        $totalOvertime += $transaction->overtime;
                        $totalAdditionalPenambahan  += $additional_penambahan;
                        
                        $totalBruto += $bruto;
                        $totalTk += $tk;
                        $totalKs += $ks;
                        $totalKsAdd = $ksAdd;
                        $totalJp += $jp;
                        $totalAbsence += $abs;
                        $totalLate += $late;
                        $totalGrand += $total;
                     @endphp
                     @else
                     <tr>
                        <td class="text-truncate"><a href="{{route('payroll.transaction.report.employee', enkripRambo($transaction->id))}}">{{$transaction->employee->nik}} </a></td>
                        <td class="text-truncate" style="max-width: 150px" ><a href="{{route('payroll.transaction.report.employee', enkripRambo($transaction->id))}}">{{$transaction->employee->biodata->fullName()}}</a></td>
                        <td class="text-right">{{formatRupiahB($transaction->employee->payroll->pokok)}}</td>
                        <td class="text-right">{{formatRupiahB($transaction->employee->payroll->tunj_jabatan)}}</td>
                        <td class="text-right">{{formatRupiahB($transaction->employee->payroll->tunj_ops)}}</td>
                        <td class="text-right">{{formatRupiahB($transaction->employee->payroll->tunj_kinerja)}}</td>
                        <td class="text-right">{{formatRupiahB($transaction->employee->payroll->tunj_fungsional)}}</td>
                        <td class="text-right">{{formatRupiahB($transaction->employee->payroll->total)}}</td>
                        <td class="text-right">{{formatRupiahB($transaction->overtime)}}</td>
                        <td class="text-right">{{formatRupiahB($transaction->additional_penambahan)}}</td>
                        <td class="text-right">{{formatRupiahB($transaction->employee->payroll->total + $transaction->overtime + $transaction->additional_penambahan)}}</td>
                     
                        <td class="text-right">
                           {{-- @if ($transaction->getDeduction('JHT', 'employee') != null )
                              {{formatRupiahB(2/100 * $transaction->employee->payroll->total)}}
                              @else
                              0
                           @endif --}}
                           {{formatRupiahB($transaction->getDeduction('JHT', 'employee'))}}
                           {{-- {{formatRupiahB($loc->getReduction($unit->id, $unitTransaction, 'JHT'))}} --}}
                        </td>
                        <td class="text-right">{{formatRupiahB($transaction->getDeduction('BPJS KS', 'employee') + $transaction->getAddDeduction( 'employee'))}}</td>
                        {{-- <td class="text-right">{{formatRupiahB()}}</td> --}}
                        <td class="text-right">{{formatRupiahB($transaction->getDeduction('JP', 'employee'))}} </td>
                        <td class="text-right">{{formatRupiahB($transaction->reduction_absence)}}</td>
                        <td class="text-right">{{formatRupiahB($transaction->reduction_late)}}</td>
                        <td class="text-right">{{formatRupiahB($transaction->total)}}</td>
                     
                     </tr>

                     @php
                        $pokok =  $transaction->employee->payroll->pokok;
                        $jabatan = $transaction->employee->payroll->tunj_jabatan;
                        $ops = $transaction->employee->payroll->tunj_ops;
                        $kinerja = $transaction->employee->payroll->tunj_kinerja;
                        $fungsional = $transaction->employee->payroll->tunj_fungsional;
                        $gaji = $transaction->employee->payroll->total;
                        $overtime = $transaction->overtime;
                        $additional_penambahan = $transaction->additional_penambahan;
                        $bruto = $transaction->employee->payroll->total + $transaction->overtime + $transaction->additional_penambahan;
                        // $tk = 2/100 * $transaction->employee->payroll->total;
                        $tk = $transaction->getDeduction('JHT', 'employee');
                        $ks = $transaction->getDeduction('BPJS KS', 'employee') + $transaction->getAddDeduction( 'employee');
                        $ksAdd = $transaction->getDeductionAdditional();
                        $jp = $transaction->getDeduction('JP', 'employee');
                        $abs = $transaction->reduction_absence;
                        $late = $transaction->reduction_late;
                        $total = $transaction->total;

                        $totalPokok += $pokok;
                        $totalJabatan += $jabatan;
                        $totalOps += $ops;
                        $totalKinerja += $kinerja;
                        $totalFungsional += $fungsional;
                        $totalGaji += $gaji;
                        $totalOvertime += $transaction->overtime;
                        $totalAdditionalPenambahan  += $additional_penambahan;
                        
                        $totalBruto += $bruto;
                        $totalTk += $tk;
                        $totalKs += $ks;
                        $totalKsAdd = $ksAdd;
                        $totalJp += $jp;
                        $totalAbsence += $abs;
                        $totalLate += $late;
                        $totalGrand += $total;
                     @endphp
                  @endif
                     
                  @endforeach
                  
                  
                  <tr>
                     <td colspan="2" class="text-right"><b> Total</b></td>
                     <td class="text-right text-truncate"><b> {{formatRupiahB($totalPokok)}}</b></b></td>
                     <td class="text-right text-truncate"><b>{{formatRupiahB($totalJabatan)}}</b></td>
                     <td class="text-right text-truncate"><b>{{formatRupiahB($totalOps)}}</b></td>
                     <td class="text-right text-truncate"><b>{{formatRupiahB($totalKinerja)}}</b></td>
                     <td class="text-right text-truncate"><b>{{formatRupiahB($totalFungsional)}}</b></td>
                     <td class="text-right text-truncate"><b>{{formatRupiahB($totalGaji)}}</b></td>
                     <td class="text-right text-truncate"><b>{{formatRupiahB($totalOvertime)}} </b></td>
                     <td class="text-right text-truncate"><b>{{formatRupiahB($totalAdditionalPenambahan)}}</b></td>
                     <td class="text-right text-truncate"><b>{{formatRupiahB($totalBruto)}}</b></td>
                     <td class="text-right text-truncate"><b>{{formatRupiahB($totalTk)}}</b></td>
                     <td class="text-right text-truncate"><b>{{formatRupiahB($totalKs + $totalKsAdd)}}</b></td>
                     {{-- <td class="text-right text-truncate"><b>{{formatRupiahB($totalKsAdd)}}</b></td> --}}
                     <td class="text-right text-truncate"><b>{{formatRupiahB($totalJp)}}</b></td>
                     <td class="text-right text-truncate"><b>{{formatRupiahB($totalAbsence)}}</b></td>
                     <td class="text-right text-truncate"><b>{{formatRupiahB($totalLate)}}</b></td>
                     <td class="text-right text-truncate"><b>{{formatRupiahB($totalGrand)}}</b></td>
                  </tr>
                  
                  
                  
               </tbody>
            </table>
         </div>

      </div>
   </div>
   

   


   
   


   <hr>

   
   
   
</div>

<div class="modal fade" id="approve-payslip-loc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('payroll.approve.loc')}}" method="POST" >
            <div class="modal-body">
               @csrf
               <input type="text" value="{{$payslipReport->id}}" name="payslipReport" id="payslipReport" hidden>
               <span>Approve this Payslip Report {{$payslipReport->unit_transaction->unit->name}} {{$payslipReport->location_name}}?</span>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary ">Approve</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="reject-payslip-loc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm Reject<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('payroll.reject.loc')}}" method="POST" >
            <div class="modal-body">
               @csrf
               <input type="text" value="{{$payslipReport->id}}" name="payslipReport" id="payslipReport" hidden>
               <span>Reject this Payslip Report {{$payslipReport->unit_transaction->unit->name}} {{$payslipReport->location_name}}?</span>
               <hr>
               <div class="form-group form-group-default">
                  <label>Remark</label>
                  <input type="text" class="form-control"  name="remark" id="remark"  >
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-danger ">Reject</button>
            </div>
         </form>
      </div>
   </div>
</div>


@endsection