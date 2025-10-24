@extends('layouts.app')
@section('title')
Report BPJS Kesehatan
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

<style>
   html {
      -webkit-print-color-adjust: exact;
   }

   @media print {

      header,
      footer,
      nav,
      aside,
      .hide,
      .sidebar,
      .main-header,
      .hide, .master, .discuss {
         display: none;
      }

      .main-panel {
         width: 100%;
      }

      @page {
         size: auto;
         /* auto is the initial value */
         margin: 0mm;
         /* this affects the margin in the printer settings */
      }

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
         <li class="breadcrumb-item" aria-current="page">BPJS Kesehatan </li>
         <li class="breadcrumb-item active" aria-current="page">{{$location->name}}/ </li>
      </ol>
   </nav>

   <div class="row hide mb-2">
      <div class="col">
         {{-- <a href="{{route('payroll.transaction.monthly.all', enkripRambo($unitTransaction->id))}}" class="btn btn-light border" ><i class="fa fa-backward"></i> Back</a> --}}
         <button type="button" class="btn btn-light bolight border" onclick="javascript:window.print();">
            <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
            <i class="fa fa-print"></i>
            Print PDF
         </button>
      </div>
      <div class="col-auto">
         {{-- <button type="button" class="btn btn-light border" onclick="javascript:window.print();">
            <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
            <i class="fa fa-print"></i>
            Print
         </button> --}}
      </div>
   </div>
   
   {{-- <div class="d-flex">
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
   </div> --}}
   <table>
      <thead>
                  <tr>
                     <th colspan="7" class="bg-white"><img src="{{asset('img/logo/bpjsks.png')}}" width="150px" alt=""></th>
                  </tr>
                  <tr style="padding: 0px!">
                     <th colspan="7" class="text-center bg-white p0 text-dark" style="padding: 0px !important;" >RINCIAN IURAN KARYAWAN</th>
                  </tr>
               </thead>
               <thead>
                  <tr>
                  <td>Bisnis Unit</td>
                  <td colspan="5">{{$unitTransaction->unit->name}}</td>
               </tr>
               <tr>
                  <td>Lokasi</td>
                  <td colspan="5">{{$payslipReport->location->name}}</td>
               </tr>
               <tr>
                  <td>Bulan</td>
                  <td colspan="5">{{$unitTransaction->month}}</td>
               </tr>
               <tr>
                  <td>Tahun</td>
                  <td colspan="5">{{$unitTransaction->year}}</td>
               </tr>
                <tr>
                  <td>Total Karyawan</td>
                  <td colspan="5">{{$bpjsKsReport->qty}}</td>
               </tr>
               <tr>
                  <td>Total Iuran</td>
                  <td colspan="5">{{formatRupiahB($bpjsKsReport->total_iuran)}}</td>
               </tr>
               </thead>
      <thead>
         <tr>
            <td style="padding: 0px !important;" colspan="" class="text-center">NIK</td>
            <td style="padding: 0px !important;" colspan="" class="text-center">Nama</td>
            <td style="padding: 0px !important;" colspan="" class="text-center">Program</td>
            {{-- <td style="padding: 0px !important;" class="text-center">Tarif</td> --}}
            <td style="padding: 0px !important;" class="text-center" >Upah</td>
            <td style="padding: 0px !important;" class="text-center" >Perusahaan</td>
            <td style="padding: 0px !important;" class="text-center" >Karyawan</td>
            {{-- <td style="padding: 0px !important;" class="text-center" >Jumlah Iuran</td> --}}
         </tr>
      </thead>

      <tbody>
         @foreach ($transactions as $trans)
             <tr>
               <td>{{$trans->employee->nik}}</td>
               <td> {{$trans->employee->biodata->fullName()}}</td>
               <td>BPJS Kesehatan</td>
               <td class="text-right">{{formatRupiahB($trans->employee->payroll->total)}}</td>
               
               <td class="text-right">{{formatRupiahB($trans->getDeduction('BPJS KS', 'company'))}}</td>
               <td class="text-right">{{formatRupiahB($trans->getDeduction('BPJS KS', 'employee') + $trans->getAddDeduction( 'employee'))}}</td>
            </tr>
         @endforeach
      </tbody>
   </table>




   
   
   
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