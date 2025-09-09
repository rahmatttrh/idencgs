@extends('layouts.app')
@section('title')
Peyslip Employee Report
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
         
         <li class="breadcrumb-item" aria-current="page"><a href="#">Transaction</a></li>
        
         <li class="breadcrumb-item" aria-current="page">Payslip Report </li>
         <li class="breadcrumb-item active" aria-current="page">Employee</li>
      </ol>
   </nav>
   
   {{-- <div class="d-flex">
      <a href="{{route('payroll.transaction.monthly', enkripRambo($unitTransaction->id))}}" class="btn btn-light border mb-2  mr-2 "><i class="fa fa-backward"></i> Back</a>

      
   </div> --}}
   

   <div class="card  shadow-none border">
      <div class="card-header  d-flex justify-content-between ">
         <div class="mt-3">
            <h2 class="text-uppercase"><b>PAYSLIP REPORT {{$transaction->id}}</b> 
               <br><span>{{$transaction->employee->nik}}</span> {{$transaction->employee->biodata->fullName()}} </h2>
            
            
         </div>
         
         <div class="text-right">
            <h2 class="mt-3"> <b>{{formatRupiahB($transaction->total)}}</b>  </h2>
         </div>
         
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
      <div class="card-body p-0">
         <div class="table-responsive p-0 " style="overflow-x: auto;">
            <table id="data" class="display  table-sm">
               <thead >
                  
                  <tr>
                     <th></th>
                     <th class="text-white">Description</th>
                     <th class="text-right text-white">Value</th>
                     
                     
                  </tr>
               </thead>

               <tbody>
                  <tr>
                     <td rowspan="8" class="text-center">Pendapatan</td>
                     <td>Gaji Pokok</td>
                     <td class="text-right">{{formatRupiahB($transaction->details->where('desc', 'Gaji Pokok')->first()->value)}}</td>
                  </tr>
                  <tr>
                     <td>Tunjangan Jabatan</td>
                     <td class="text-right">{{formatRupiahB($transaction->payroll->tunj_jabatan)}}</td>
                  </tr>
                  <tr>
                     <td>Tunjungan Operasional</td>
                     <td class="text-right">{{formatRupiahB($transaction->payroll->tunj_ops)}}</td>
                  </tr>
                  <tr>
                     <td>Tunjungan Kinerja</td>
                     <td class="text-right">{{formatRupiahB($transaction->payroll->tunj_kinerja)}}</td>
                  </tr>
                  <tr>
                     <td>Total Gaji</td>
                     <td class="text-right">{{formatRupiahB($transaction->payroll->total)}}</td>
                  </tr>
                  <tr>
                     <td>Lembur</td>
                     <td class="text-right">{{formatRupiahB($transaction->overtime)}}</td>
                  </tr>
                  <tr>
                     <td>Lain-lain</td>
                     <td class="text-right">{{formatRupiahB($transaction->payroll->additional_penambahan)}}</td>
                  </tr>
                  <tr>
                     <td>Total Bruto</td>
                     <td class="text-right">{{formatRupiahB($transaction->employee->payroll->total + $transaction->overtime + $transaction->additional_penambahan)}}</td>
                  </tr>
                  <tr>
                     <td colspan="3" style="height: 10px"></td>
                  </tr>
                  <tr>
                     <td rowspan="5" class="text-center">Potongan</td>
                     <td>BPJS Ketenagakerjaan</td>
                     <td class="text-right">
                        {{-- @if ($transaction->getDeduction('JHT', 'employee') != null )
                              {{formatRupiahB(2/100 * $transaction->employee->payroll->total)}}
                              @else
                              0
                           @endif --}}
                           {{formatRupiahB($transaction->getDeduction('JHT', 'employee'))}}
                        {{-- {{formatRupiahB(2/100 * $transaction->employee->payroll->total)}} --}}
                     </td>
                  </tr>
                  <tr>
                     <td>BPJS Kesehatan</td>
                     <td class="text-right">{{formatRupiahB($transaction->getDeduction('BPJS KS', 'employee'))}}</td>
                  </tr>
                  <tr>
                     <td>Jaminan Pensiun</td>
                     <td class="text-right">{{formatRupiahB($transaction->getDeduction('JP', 'employee'))}}</td>
                  </tr>
                  <tr>
                     <td>Absen</td>
                     <td class="text-right">{{formatRupiahB($transaction->reduction_absence)}}</td>
                  </tr>
                  <tr>
                     <td>Terlambat</td>
                     <td class="text-right">{{formatRupiahB($transaction->reduction_late)}}</td>
                  </tr>
                  <tr>
                     <td colspan="3" style="height: 10px"></td>
                  </tr>
                  <tr>
                     <th colspan="2" class="text-right">Total</th>
                     <td class="text-right">{{formatRupiahB($transaction->total)}}</td>
                  </tr>
               </tbody>
            </table>
         </div>

      </div>
   </div>
   

   


   
   


   <hr>

   <div class="card">
      <div class="card-body">
          {{-- <h4 class="card-title mb-5">Horizontal Timeline</h4> --}}

          
      </div>
   </div>
   
   
</div>




@endsection