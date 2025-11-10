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

    table thead tr th {
      font-size: 9px !important;
      padding-right: 2px !important;
      padding-left: 2px !important;
   }

   table tbody tr td {
      font-size: 11px !important;
      padding-right: 0px !important;
      padding-left: 0px !important;
      padding-top: 5px !important;
      padding-bottom: 5px !important;
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
         @if (auth()->user()->username == 'EN-2-001' || auth()->user()->username == '11304' || auth()->user()->username == 'EN-2-006' || auth()->user()->username == 'BOD-002' || auth()->user()->username == 'BOD-005'  || auth()->user()->username == 'EN-4-093' )
         @else
         <li class="breadcrumb-item" aria-current="page"><a href="{{route('payroll.transaction.monthly.all', enkripRambo($unitTransaction->id))}}">Transaction</a></li>
         @endif
         <li class="breadcrumb-item" aria-current="page">{{$unit->name}}</li>
         <li class="breadcrumb-item " aria-current="page">{{$unitTransaction->month}}</li>
         <li class="breadcrumb-item active" aria-current="page">Payslip Report </li>
      </ol>
   </nav>
   
   <div class="d-flex justify-content-between p-0">
      {{-- @if (auth()->user()->username == 'EN-2-001'  )
         
            <a href="{{route('payroll.approval.hrd', enkripRambo($unitTransaction->id))}}" class="btn btn-light border mb-2  mr-2 "><i class="fa fa-backward"></i> Approval List</a>
        
            <a href="{{route('payroll.approval.manhrd.history')}}" class="btn btn-light border mb-2  mr-2 ">Lihat History</a>
        
      
      @elseif (auth()->user()->username == '11304' )
         <a href="{{route('payroll.approval.manfin', enkripRambo($unitTransaction->id))}}" class="btn btn-light border mb-2  mr-2 "><i class="fa fa-backward"></i> Approval List</a>
         <a href="{{route('payroll.approval.manfin.history', enkripRambo($unitTransaction->id))}}" class="btn btn-light border mb-2  mr-2 "><i class="fa fa-backward"></i> Lihat History</a>
      @elseif (auth()->user()->username == 'EN-2-006' )
         <a href="{{route('payroll.approval.gm', enkripRambo($unitTransaction->id))}}" class="btn btn-light border mb-2  mr-2 "><i class="fa fa-backward"></i> Approval List</a>
         <a href="{{route('payroll.approval.gm.history', enkripRambo($unitTransaction->id))}}" class="btn btn-light border mb-2  mr-2 "><i class="fa fa-backward"></i> Lihat History</a>
      @elseif ( auth()->user()->username == 'BOD-002' )
        
         <a href="{{route('payroll.approval.bod', enkripRambo($unitTransaction->id))}}" class="btn btn-light border mb-2  mr-2 "><i class="fa fa-backward"></i> Approval List</a>
         <a href="{{route('payroll.approval.bod.history')}}" class="btn btn-light border mb-2  mr-2 ">Lihat History</a>
         
      @else
      <a href="{{route('payroll.transaction.monthly.all', enkripRambo($unitTransaction->id))}}" class="btn btn-light border mb-2  mr-2 "><i class="fa fa-backward"></i> Back</a>
      @endif --}}

      {{-- <div class="d-flex justify-content-between"> --}}
         
         
         {{-- Action Approval --}}  
         
      
         {{-- @if (auth()->user()->username == '11304' && $unitTransaction->status == 2)
         <div class="btn-group  mb-2">
            @php
                $approve = 1;
               @endphp
               @foreach ($payslipReports as $rep)
                  @if ($rep->status == 202)
                     @php
                           $approve = 0;
                     @endphp
                  @endif
               @endforeach
               @if ($approve == 1)
               <a href="#" class="btn btn-primary " data-target="#modal-approve-fin-tu" data-toggle="modal">Final Approve</a>
                  @else
                  <a href="#" class="btn btn-light border " data-toggle="tooltip" title="Tidak dapat Approve karna ada lokasi yang di Reject">Final Approve</a>
               @endif
            
               <a href="" class="btn btn-danger  " data-target="#modal-reject-manfin-tu" data-toggle="modal">Reject</a>
         </div>
         @endif --}}

         {{-- @if (auth()->user()->username == 'EN-2-006' && $unitTransaction->status == 3)
         <div class="btn-group  mb-2">
            @php
                $approve = 1;
            @endphp
            @foreach ($payslipReports as $rep)
                @if ($rep->status == 303)
                    @php
                        $approve = 0;
                    @endphp
                @endif
            @endforeach
            @if ($approve == 1)
               <a href="#" class="btn btn-primary" data-target="#modal-approve-gm-tu" data-toggle="modal">Final Approve</a>
               @else
               <a href="#" class="btn btn-light border" data-toggle="tooltip" title="Tidak dapat Approve karna ada lokasi yang di Reject">Final Approve</a>
            @endif
            
            <a href="#" class="btn btn-danger" data-target="#modal-reject-gm-tu" data-toggle="modal">Reject</a>
         </div>
         @endif --}}

         {{-- @if (auth()->user()->username == 'BOD-002' && $unitTransaction->status == 4)
         <div class="btn-group ml-2 mb-2">
            @php
                $approve = 1;
               @endphp
               @foreach ($payslipReports as $rep)
                  @if ($rep->status == 404)
                     @php
                           $approve = 0;
                     @endphp
                  @endif
               @endforeach
               @if ($approve == 1)
               <a href="#" class="btn btn-primary" data-target="#modal-approve-bod-tu" data-toggle="modal">Final Approve</a>
                  @else
                  <a href="#" class="btn btn-light border mb-2" data-toggle="tooltip" title="Tidak dapat Approve karna ada lokasi yang di Reject">Final Approve</a>
               @endif
            
               <a href="" class="btn btn-danger  mb-2" data-target="#modal-reject-bod-tu" data-toggle="modal">Reject</a>
         </div>
         @endif --}}

         {{-- <a class="btn  btn-light border mb-2" href="{{route('payroll.transaction.export', enkripRambo($unitTransaction->id))}}"><i class="fa fa-file"></i> Export to Excel</a> --}}
      {{-- </div> --}}
   </div>


   
   
   {{-- <div class="hori-timeline mt-3" dir="ltr">
      <ul class="list-inline events">
          
          <li class="list-inline-item event-list">
              <div class="px-4">
               
               @if ($manHrd)
                  <div class="event-date bg-primary text-white">MANAGER HRD</div>
                  <h5 class="font-size-16">{{formatDateTime($manhrd->created_at)}}</h5>
                  
                  @else  
                  <div class="event-date bg-light border">HRD MANAGER</div>
                  <h5 class="font-size-16">Waiting</h5>
                  
               @endif
                  
              </div>
          </li>
          <li class="list-inline-item event-list">
              <div class="px-4">
               @if ($manFin)
                  <div class="event-date bg-primary text-white">MANAGER FINANCE</div>
                  <h5 class="font-size-16">{{formatDateTime($manfin->created_at)}}</h5>
                  
                  @else  
                  <div class="event-date bg-light border">MANAGER FINANCE</div>
                  <h5 class="font-size-16">Waiting</h5>
                  
               @endif
              </div>
          </li>
          <li class="list-inline-item event-list">
              <div class="px-4">
               @if ($gm)
                  <div class="event-date bg-primary text-white">GENERAL MANAGER</div>
                  <h5 class="font-size-16">{{formatDateTime($gm->created_at)}}</h5>
                  
                  @else  
                  <div class="event-date bg-light border">GENERAL MANAGER</div>
                  <h5 class="font-size-16">Waiting</h5>
                  
               @endif
              </div>
          </li>
          <li class="list-inline-item event-list">
             <div class="px-4">
               @if ($bod)
                  <div class="event-date bg-primary text-white">DIREKSI / BOD</div>
                  <h5 class="font-size-16">{{formatDateTime($bod->created_at)}}</h5>
                  
                  @else  
                  <div class="event-date bg-light border">DIREKSI / BOD </div>
                  <h5 class="font-size-16">Waiting</h5>
                  
               @endif
             </div>
         </li>
          
      </ul>
   </div> --}}
   @php
       $projectBersih = 0;
   @endphp

   @foreach ($payslipReports as $report)

   @if (count($report->projects) > 0)
                            
                        
      @foreach ($report->projects as $pro)
         @php
             $projectBersih = $projectBersih + $pro->gaji_bersih;
         @endphp
      @endforeach
   @endif

       
   @endforeach

   <div class="card card-with-nav shadow-none border">
      <div class="card-header  d-flex justify-content-between ">
         <div class="mt-3">
            <div class="o">PAYSLIP REPORT</div>
         
            <h2 class="text-uppercase mt-2"> PT {{$unit->name}}  {{$unitTransaction->month}} {{$unitTransaction->year}}</h2>
            
            {{-- <span>{{$unitTransaction->month}} {{$unitTransaction->year}}</span> --}}
            {{-- <hr> --}}
             <span>{{formatRupiahB($payslipReports->sum('gaji_bersih') + $projectBersih)}}</span> <br>
             <hr>
             @if (auth()->user()->username == '11304' )
             <a class="mr-2" href="{{route('payroll.approval.manfin')}}"><i class="fa fa-backward"></i> Back</a>
             @endif
             @if (auth()->user()->username == 'EN-2-006' )
             <a class="mr-2" href="{{route('payroll.approval.gm')}}"><i class="fa fa-backward"></i> Back</a>
             @endif
             @if (auth()->user()->username == 'EN-2-001' )
             <a class="mr-2" href="{{route('payroll.approval.gm')}}"><i class="fa fa-backward"></i> Back</a>
             @endif
             @if (auth()->user()->username == 'BOD-002' || auth()->user()->username == 'BOD-005')
             <a class="mr-2" href="{{route('payroll.approval.bod')}}"><i class="fa fa-backward"></i> Back</a>
             @endif

             @if ($unitTransaction->file != null)
             <a href="#" class="" data-target="#modal-open-attachment" data-toggle="modal"><i class="fa fa-file"></i> Open Attachment</a> |
             @endif 
             <a class="" href="{{route('payroll.transaction.export', enkripRambo($unitTransaction->id))}}"><i class="fa fa-file"></i> Export to Excel</a> | <a class="" href="{{route('payroll.transaction.export.pdf', enkripRambo($unitTransaction->id))}}" target="_blank"><i class="fa fa-file"></i> Export to PDF</a>
            
         </div>
         
         <div class="text-right pt-3">
            {{-- <h2 class="mt-3"> <b>{{formatRupiahB($payslipReports->sum('gaji_bersih'))}}</b></h2> --}}
            {{-- <small></small><br> --}}
            @if ($unitTransaction->status == 101 || $unitTransaction->status == 202 || $unitTransaction->status == 303 || $unitTransaction->status == 404)
               <div class="card card-danger">
                  <div class="card-body">
                     <span class="text-uppercase"> <x-status.unit-transaction :unittrans="$unitTransaction"/> </span> <br>
                     {{$unitTransaction->rejectBy->biodata->fullName()}} <br>
                {{formatDateTime($unitTransaction->reject_date)}} <br>
                {{$unitTransaction->reject_desc}}
                  </div>
               </div>              
                @else
                <div class="card card-light border">
                  <div class="card-body text-center">
                     <span class=""> <x-status.unit-transaction :unittrans="$unitTransaction"/> </span>
                  </div>
                  <div class="card-footer">
                     @if ($unitTransaction->status == 1)
                        @if (auth()->user()->username == 'EN-2-001' || auth()->user()->username == 'EN-4-093')
                           <div class="btn-group ">
                              @php
                              $approve = 1;
                              @endphp
                              @foreach ($payslipReports as $rep)
                                 @if ($rep->status == 101)
                                    @php
                                          $approve = 0;
                                    @endphp
                                 @endif
                              @endforeach
                              @if ($approve == 1)
                              <a href="#" class="btn btn-primary btn-sm  " data-target="#modal-approve-hrd-tu" data-toggle="modal"><i class="fa fa-check"></i> Final Approve</a>
                                 @else
                                 <a href="#" class="btn btn-light border btn-sm" data-toggle="tooltip" title="Tidak dapat Approve karna ada lokasi yang di Reject">Final Approve</a>
                              @endif
                              {{-- <a href="#" class="btn btn-primary   " data-target="#modal-approve-hrd-tu" data-toggle="modal">Final Approve</a> --}}
                              <a href="" class="btn btn-light border btn-sm " data-target="#modal-reject-hrd-tu" data-toggle="modal"> Reject</a>
                           </div>
                        @endif
                     @endif

                     {{-- Manager Finance --}}
                     @if (auth()->user()->username == '11304' && $unitTransaction->status == 2)
                        <div class="btn-group  mb-2">
                           @php
                              $approve = 1;
                              @endphp
                              @foreach ($payslipReports as $rep)
                                 @if ($rep->status == 202)
                                    @php
                                          $approve = 0;
                                    @endphp
                                 @endif
                              @endforeach
                              @if ($approve == 1)
                              <a href="#" class="btn btn-primary " data-target="#modal-approve-fin-tu" data-toggle="modal">Final Approve</a>
                                 @else
                                 <a href="#" class="btn btn-light border " data-toggle="tooltip" title="Tidak dapat Approve karna ada lokasi yang di Reject">Final Approve</a>
                              @endif
                           
                              <a href="" class="btn btn-danger  " data-target="#modal-reject-manfin-tu" data-toggle="modal">Reject</a>
                        </div>
                     @endif


                     {{-- GM --}}
                     @if (auth()->user()->username == 'EN-2-006' && $unitTransaction->status == 3)
                     <div class="btn-group  mb-2">
                        @php
                           $approve = 1;
                        @endphp
                        @foreach ($payslipReports as $rep)
                           @if ($rep->status == 303)
                              @php
                                    $approve = 0;
                              @endphp
                           @endif
                        @endforeach
                        @if ($approve == 1)
                           <a href="#" class="btn btn-primary" data-target="#modal-approve-gm-tu" data-toggle="modal">Final Approve</a>
                           @else
                           <a href="#" class="btn btn-light border" data-toggle="tooltip" title="Tidak dapat Approve karna ada lokasi yang di Reject">Final Approve</a>
                        @endif
                        
                        <a href="#" class="btn btn-danger" data-target="#modal-reject-gm-tu" data-toggle="modal">Reject</a>
                     </div>
                     @endif

                     {{-- BOD --}}
                     @if (auth()->user()->username == 'BOD-002' || auth()->user()->username == 'BOD-005')
                        @if ($unitTransaction->status == 4)
                            
                        
                        <div class="btn-group ml-2 mb-2">
                           @php
                              $approve = 1;
                              @endphp
                              @foreach ($payslipReports as $rep)
                                 @if ($rep->status == 404)
                                    @php
                                          $approve = 0;
                                    @endphp
                                 @endif
                              @endforeach
                              @if ($approve == 1)
                              <a href="#" class="btn btn-primary mb-2" data-target="#modal-approve-bod-tu" data-toggle="modal">Final Approve</a>
                                 @else
                                 <a href="#" class="btn btn-light border mb-2" data-toggle="tooltip" title="Tidak dapat Approve karna ada lokasi yang di Reject">Final Approve</a>
                              @endif
                           
                              <a href="" class="btn btn-danger  mb-2" data-target="#modal-reject-bod-tu" data-toggle="modal">Reject</a>
                        </div>
                        @endif
                     @endif
                  </div>
               </div>
               
            @endif
            
         </div>
         
      </div>
      <div class="card-header">
         <div class="row row-nav-line">
            <ul class="nav nav-tabs nav-line nav-color-secondary" role="tablist">
               <li class="nav-item"> <a class="nav-link show active" id="pills-payslip-tab-nobd" data-toggle="pill" href="#pills-payslip-nobd" role="tab" aria-controls="pills-payslip-nobd" aria-selected="true">Payslip Report</a> </li>
               @if (auth()->user()->username == 'EN-2-001' || auth()->user()->username == '11304' || auth()->user()->username == 'EN-2-006' || auth()->user()->username == 'BOD-002' || auth()->user()->username == 'BOD-005' || auth()->user()->hasRole('Administrator') || auth()->user()->username == 'EN-4-093')
               <li class="nav-item"> <a class="nav-link " id="pills-ks-tab-nobd" data-toggle="pill" href="#pills-ks-nobd" role="tab" aria-controls="pills-ks-nobd" aria-selected="true">BPJS Kesehatan</a> </li>
               <li class="nav-item"> <a class="nav-link " id="pills-kt-tab-nobd" data-toggle="pill" href="#pills-kt-nobd" role="tab" aria-controls="pills-kt-nobd" aria-selected="true">BPJS Ketenagakerjaan</a> </li>
               <li class="nav-item"> <a class="nav-link " id="pills-timeline-tab-nobd" data-toggle="pill" href="#pills-timeline-nobd" role="tab" aria-controls="pills-timeline-nobd" aria-selected="true">Timeline</a> </li>
               @endif
            </ul>
         </div>
      </div>
      <div class="card-body p-0" style="padding: 0px !important">
         <div class="tab-content p-0" id="pills-without-border-tabContent">

            {{-- Tab Payslip Report --}}
            <div class="tab-pane  fade show active p-0" id="pills-payslip-nobd" role="tabpanel" aria-labelledby="pills-payslip-tab-nobd">
               {{-- <div class="mb-2">
                  
               </div> --}}
               {{-- <h1>{{count($transactions)}}</h1> --}}
               <div class="table-responsive p-0" style="overflow-x: auto;">
                  <table id="data" class=" ">
                     <thead >
                        <tr class="text-white">
                           <th rowspan="2" class="text-white" colspan="2">Loc</th>
                           <th rowspan="2" class="text-white ">Jml Pgw</th>
                           
                           <th colspan="9" class="text-center text-white">Pendapatan</th>
                           <th colspan="6" class="text-center text-white">Potongan</th>
                           <th rowspan="2" class="text-center text-white">Gaji Bersih</th>
                        </tr>
                        <tr>
                           <th class="text-center text-white text-truncate">Gaji Pokok</th>
                           <th class="text-center text-white text-truncate">Tunj. Jabatan</th>
                           <th class="text-center text-white text-truncate">Tunj. OPS</th>
                           <th class="text-center text-white text-truncate">Tunj. Kinerja</th>
                           <th class="text-center text-white text-truncate">Tunj. Fungsional</th>
                           <th class="text-center text-white text-truncate">Total Gaji</th>
                           <th class="text-center text-white text-truncate">Lembur</th>
                           <th class="text-center text-white text-truncate">Lain-Lain</th>
                           <th class="text-center text-white text-truncate">Total Bruto</th>
                           <th class="text-center text-white text-truncate">BPJS TK</th>
                           <th class="text-center text-white text-truncate">BPJS KS</th>
                           <th class="text-center text-white text-truncate">JP</th>
                           <th class="text-center text-white text-truncate">Absen</th>

                           <th class="text-center text-white text-truncate">Terlambat</th>
                           <th class="text-center text-white text-truncate">Lain-lain</th>
                           
                        </tr>
                     </thead>
      
                     <tbody>

                        @php
                            $proTotalQty = 0;
                            $proPokok = 0;
                            $proJabatan = 0;
                            $proOps = 0;
                            $proKinerja = 0;
                            $proFung = 0;
                            $proTotal = 0;
                            $proLembur = 0;
                            $proLain = 0;
                            $proBruto = 0;
                            $proBpjskt = 0;
                            $proBpjsks = 0;
                            $proJp = 0;
                            $proAbsen = 0;
                            $proTerlambat = 0;
                            $proBersih = 0;
                        @endphp
                        @foreach ($payslipReports as $report)

                        @if ($report->qty > 0 || count($report->projects) > 0 )

                        {{-- @if ($report->qty > 0 || count($report->projects) > 0 )
                            
                        @endif --}}
                        <tr>
                           @if (auth()->user()->username == 'EN-2-001' || auth()->user()->username == 'EN-4-093')
                              @if ($report->status == 1)
                                 <td class="text-truncate bg-success" colspan="2"><a class="text-white" href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                                 @elseif ($report->status == 101)  
                                    <td class="text-truncate bg-danger text-white" colspan="2">
                                       <a class="text-white" href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a> <br>
                                       {{$report->status}} :
                                       <small>{{$report->reject_desc}}</small>
                                    </td>
                                    
                                 @else
                                 <td class="text-truncate  " colspan="2"><a  href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                              @endif
                           @endif

                           @if (auth()->user()->username == '11304')
                              @if ($report->status >= 2)
                              <td class="text-truncate bg-success" colspan="2"><a class="text-white" href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                                 @else
                                 <td class="text-truncate  " colspan="2"><a  href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                              @endif
                           @endif

                           @if (auth()->user()->username == 'EN-2-006')
                           
                              @if ($report->status == 3 || $report->status == 4)
                              
                               <td class="text-truncate bg-success" colspan="2"><a class="text-white" href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                               @elseif ($report->status == 303)  
                                 <td class="text-truncate bg-danger text-white" colspan="2">
                                    <a class="text-white" href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a> <br>
                                    {{$report->status}} :
                                    <small>{{$report->reject_desc}}</small>
                                 </td>
                               @else
                                 <td class="text-truncate  " colspan="2"><a  href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                              @endif
                           @endif

                           @if (auth()->user()->username == 'BOD-002' || auth()->user()->username == 'BOD-005')
                              @if ($report->status >= 4)
                              <td class="text-truncate bg-success" colspan="2"><a class="text-white" href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                                 @else
                                 <td class="text-truncate  " colspan="2"><a  href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                              @endif
                           @endif

                           @if (auth()->user()->hasRole('Administrator|HRD-Payroll|HRD') &&  auth()->user()->username != 'EN-2-001' && auth()->user()->username != 'EN-4-093')
                                 @if ($report->status == 101 || $report->status == 202 || $report->status == 303 || $report->status == 404)
                                 <td class="text-truncate bg-danger text-white " colspan="2"><a class="text-white" href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                                    @else
                                    <td class="text-truncate  " colspan="2"><a  href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                                 @endif
                              
                           @endif
                           
                           
                           <td class="text-center text-truncate">{{$report->qty}}</td>
                           
                           <td class="text-right text-truncate">{{formatRupiahB($report->pokok)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($report->jabatan)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($report->ops)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($report->kinerja)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($report->fungsional)}}</td>
   
                           <td class="text-right text-truncate">{{formatRupiahB($report->total)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($report->lembur)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($report->lain)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($report->bruto)}}</td>
   
                           {{-- Potongan --}}
                           {{-- <td class="text-right text-truncate">{{formatRupiahB(2/100 * $loc->getValueGaji($unit->id, $unitTransaction))}}</td> --}}
                           <td class="text-right text-truncate">{{formatRupiahB($report->bpjskt)}}</td>
                           
                           <td class="text-right text-truncate">{{formatRupiahB($report->bpjsks)}}
                              {{-- @if (auth()->user()->hasRole('Administratro'))
                               Add : {{$loc->getReductionAdditional($unit->id, $unitTransaction)}}
                                  
                              @endif --}}
                           </td>
                           <td class="text-right text-truncate">{{formatRupiahB($report->jp)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($report->absen)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($report->terlambat)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($report->additional_pengurangan)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($report->gaji_bersih)}}</td>
                        </tr>

                        {{-- @php
                           
                            $proPokok = 0;
                            $proJabatan = 0;
                            $proOps = 0;
                            $proKinerja = 0;
                            $proFung = 0;
                            $proTotal = 0;
                            $proLembur = 0;
                            $proLain = 0;
                            $proBruto = 0;
                            $proBpjskt = 0;
                            $proBpjsks = 0;
                            $proJp = 0;
                            $proAbsen = 0;
                            $proTerlambat = 0;
                            $proBersih = 0;
                        @endphp --}}
                        @if (count($report->projects) > 0)
                            
                        
                        @foreach ($report->projects as $pro)
                        <tr>
                           <td></td>
                           <td class=" text-truncate">{{$pro->project->name}} </td>
                           <td class="text-center text-truncate">
                              @if (auth()->user()->hasRole('Administrator'))
                                  {{count($pro->project->getUnitTransaction($unit->id, $unitTransaction, $pro->location_id))}}
                              @endif
                              {{$pro->qty}}
                           </td>
                  
                           <td class="text-right text-truncate">{{formatRupiahB($pro->pokok)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($pro->jabatan)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($pro->ops)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($pro->kinerja)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($pro->fungsional)}}</td>
   
                           <td class="text-right text-truncate">{{formatRupiahB($pro->total)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($pro->lembur)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($pro->lain)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($pro->bruto)}}</td>
   
                           {{-- Potongan --}}
                           {{-- <td class="text-right text-truncate">{{formatRupiahB(2/100 * $loc->getValueGaji($unit->id, $unitTransaction))}}</td> --}}
                           <td class="text-right text-truncate">{{formatRupiahB($pro->bpjskt)}}</td>
                           
                           <td class="text-right text-truncate">{{formatRupiahB($pro->bpjsks)}}
                              {{-- @if (auth()->user()->hasRole('Administratro'))
                              Add : {{$loc->getReductionAdditional($unit->id, $unitTransaction)}}
                                 
                              @endif --}}
                           </td>
                           <td class="text-right text-truncate">{{formatRupiahB($pro->jp)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($pro->absen)}}</td>
                           <td class="text-right text-truncate">{{formatRupiahB($pro->terlambat)}}</td>
                           <td class="text-right text-truncate">0</td>
                           <td class="text-right text-truncate">{{formatRupiahB($pro->gaji_bersih)}}</td>
                        </tr>

                        
                        @php
                           $proTotalQty = $proTotalQty + $pro->qty ;
                            $proPokok = $proPokok + $pro->pokok ;
                            $proJabatan = $proJabatan + $pro->jabatan;
                            $proOps = $proOps + $pro->ops;
                            $proKinerja = $proKinerja + $pro->kinerja;
                            $proFung = $proFung + $pro->fungsional;
                            $proTotal = $proTotal + $pro->total;
                            $proLembur = $proLembur + $pro->lembur;
                            $proLain = $proLain + $pro->lain;
                            $proBruto = $proBruto + $pro->bruto;
                            $proBpjskt = $proBpjskt + $pro->bpjskt;
                            $proBpjsks = $proBpjsks + $pro->bpjsks;
                            $proJp = $proJp + $pro->jp;
                            $proAbsen =  $proAbsen + $pro->absen;
                            $proTerlambat += $pro->terlambat;
                            $proBersih = $proBersih + $pro->gaji_bersih;
                        @endphp

                        
                            
                        @endforeach
                        @endif
                        

                           

                        @endif
                        
                        @endforeach

                        {{-- <h4>{{$report->projects->sum('qty')}}</h4> --}}

                        <tr>
                           <td colspan="2" class="text-right" colspan="2"><b> Total</b></td>
                           {{-- <td><b></b></td> --}}
                           <td>{{$payslipReports->sum('qty') + $proTotalQty }} </td>
                           <td class="text-right text-truncate"><b> {{formatRupiahB($payslipReports->sum('pokok') + $proPokok )}}</b></b></td>
                           <td class="text-right text-truncate"><b>{{formatRupiahB($payslipReports->sum('jabatan') + $proJabatan)}}</b></td>
                           <td class="text-right text-truncate"><b>{{formatRupiahB($payslipReports->sum('ops') + $proOps)}}</b></td>
                           <td class="text-right text-truncate"><b>{{formatRupiahB($payslipReports->sum('kinerja') + $proKinerja)}}</b></td>
                           <td class="text-right text-truncate"><b>{{formatRupiahB($payslipReports->sum('fungsional') + $proFung)}}</b></td>
                           <td class="text-right text-truncate"><b>{{formatRupiahB($payslipReports->sum('total') + $proTotal)}}</b></td>
                           <td class="text-right text-truncate"><b>{{formatRupiahB($payslipReports->sum('lembur') + $proLembur)}}</b></td>
                           <td class="text-right text-truncate"><b>{{formatRupiahB($payslipReports->sum('lain') + $proLain)}}</b></td>
                           <td class="text-right text-truncate"><b>{{formatRupiahB($payslipReports->sum('bruto') + $proBruto)}}</b></td>
                           <td class="text-right text-truncate"><b>{{formatRupiahB($payslipReports->sum('bpjskt') + $proBpjskt)}}</b></td>
                           <td class="text-right text-truncate"><b>{{formatRupiahB($payslipReports->sum('bpjsks') + $proBpjsks)}}</b></td>
                           <td class="text-right text-truncate"><b>{{formatRupiahB($payslipReports->sum('jp') + $proJp)}}</b></td>
                           <td class="text-right text-truncate"><b>{{formatRupiahB($payslipReports->sum('absen') + $proAbsen)}}</b></td>
                           <td class="text-right text-truncate"><b>{{formatRupiahB($payslipReports->sum('terlambat') + $proTerlambat)}}</b> </td>
                           <td class="text-right text-truncate"><b>{{formatRupiahB($payslipReports->sum('additional_pengurangan') )}}</b></td>
                           <td class="text-right text-truncate"><b>{{formatRupiahB($payslipReports->sum('gaji_bersih') + $proBersih)}}</b></td>
                        </tr>
                        
                        
                        
                     </tbody>
                  </table>
               </div>
               
            </div>

            <div class="tab-pane fade " id="pills-ks-nobd" role="tabpanel" aria-labelledby="pills-ks-tab-nobd">
               @if (auth()->user()->username == 'EN-2-001' || auth()->user()->username == '11304' || auth()->user()->username == 'EN-2-006' || auth()->user()->username == 'BOD-002' || auth()->user()->username == 'BOD-005' || auth()->user()->hasRole('Administrator') || auth()->user()->username == 'EN-4-093' )
                  <table  >
                     <thead>
                        <tr>
                           <th colspan="4 p-2" class="bg-white"><img src="{{asset('img/logo/bpjsks.png')}}" width="150px" alt=""></th>
                        </tr>
                        <tr style="padding: 0px!">
                           <th colspan="4" class="text-center bg-white p0" style="padding: 0px !important;" >RINCIAN IURAN</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td colspan="4" style="padding: 0px !important;"  >BAGIAN I - Perusahaan</td>
                        </tr>
                        <tr>
                           <td style="padding: 0px !important;">1</td>
                           <td style="padding: 0px !important;">NAMA INSTANSI/BADAN/PERUSAHAAN</td>
                           <td style="padding: 0px !important;" colspan="2">PT {{$unit->name}}</td>
                        </tr>
                        <tr>
                           <td style="padding: 0px !important;"></td>
                           <td style="padding: 0px !important;">KODE BADAN USAHA</td>
                           <td style="padding: 0px !important;" colspan="2">{{$unit->kode}}</td>
                        </tr>
                        <tr>
                           <td style="padding: 0px !important;"></td>
                           <td style="padding: 0px !important;">ALAMAT</td>
                           <td style="padding: 0px !important;" colspan="2">{{$unit->alamat}}</td>
                        </tr>
                        <tr>
                           <td style="padding: 0px !important;"></td>
                           <td style="padding: 0px !important;">TELP</td>
                           <td style="padding: 0px !important;" colspan="2">{{$unit->telp}}</td>
                        </tr>
                        <tr>
                           <td style="padding: 0px !important;" colspan="3"></td>
                        </tr>
                        <tr>
                           <td style="padding: 0px !important;">2</td>
                           <td style="padding: 0px !important;">IURAN UNTUK BULAN</td>
                           <td style="padding: 0px !important;"colspan="2" class="">{{$reportBpjsKs->month}} {{$reportBpjsKs->year}}</td>
                        </tr>
                        <tr>
                           <td style="padding: 0px !important;"></td>
                           <td style="padding: 0px !important;">KODE VIRTUAL ACCOUNT</td>
                           <td style="padding: 0px !important;" colspan="2">{{$unit->va}}</td>
                        </tr>
                        <tr>
                           <td style="padding: 0px !important;"></td>
                           <td style="padding: 0px !important;">BANK TEMPAT PEMBAYARAN IURAN</td>
                           <td style="padding: 0px !important;" colspan="2">{{$unit->bank}}</td>
                        </tr>
                        <tr>
                           <td style="padding: 0px !important;" colspan="4">-</td>
                        </tr>
                        <tr>
                           <td style="padding: 0px !important;" colspan="4">BAGIAN II : Rekapitulasi tenaga kerja dan upah</td>
                        </tr>
                        
                        <tr>
                           <td style="padding: 0px !important;" colspan="2" rowspan="2" class="text-center">Iuran</td>
                           <td style="padding: 0px !important;" colspan="2" class="text-center">Jumlah</td>
                        </tr>
                        <tr>
                           <td style="padding: 0px !important;" class="text-center">Tenaga Kerja</td>
                           <td style="padding: 0px !important;" class="text-center">Upah (Rp.)</td>
                        </tr>
      
                        <tr>
                           <td style="padding: 0px !important;" style="padding: 0px !important;">A</td>
                           <td style="padding: 0px !important;">Bulan lalu</td>
                           <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-center">{{$reportBpjsKs->payslip_employee}}</td>
                           <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-right">{{formatRupiahB($reportBpjsKs->payslip_total)}}</td>
                        </tr>
                        <tr>
                           <td style="padding: 0px !important;" style="padding: 0px !important;">B</td>
                           <td style="padding: 0px !important;">Penambahan tenaga kerja</td>
                           <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-center">0</td>
                           <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-right">0</td>
                        </tr>
                        <tr>
                           <td style="padding: 0px !important;" style="padding: 0px !important;">C</td>
                           <td style="padding: 0px !important;">Pengurangan tenaga kerja</td>
                           <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-center">0</td>
                           <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-right">0</td>
                        </tr>
                        <tr>
                           <td style="padding: 0px !important;" style="padding: 0px !important;">D</td>
                           <td style="padding: 0px !important;">Perubahan Upah</td>
                           <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-center">0</td>
                           <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-right">0</td>
                        </tr>
                        <tr>
                           <td style="padding: 0px !important;" style="padding: 0px !important;">E</td>
                           <td style="padding: 0px !important;">Jumlah (A+B+C)</td>
                           <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-center">0</td>
                           <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-right">0</td>
                        </tr>
                        
      
                     </tbody>
                     
                  </table>

                  <table>
                     <tbody>
                        <tr>
                           <td style="padding: 0px !important;" colspan="9">BAGIAN III : Rincian Iuran bulan ini</td>
                        </tr>
                        <tr>
                        
                        <tr>
                           <td style="padding: 0px !important;" colspan="3" class="text-center">Program</td>
                           <td style="padding: 0px !important;" class="text-center">Tarif</td>
                           <td style="padding: 0px !important;" class="text-center">Tenaga <br> Kerja</td>
                           <td style="padding: 0px !important;" class="text-center" >Upah</td>
                           <td style="padding: 0px !important;" class="text-center" >Perusahaan</td>
                           <td style="padding: 0px !important;" class="text-center" >Karyawan</td>
                           <td style="padding: 0px !important;" class="text-center" >Jumlah Iuran</td>
                        </tr>

                        @php
                           $additional_karyawan =  0;
                        @endphp
                        

                        @foreach ($bpjsKsReports as $bpjs)
                        @if ($bpjs->qty >= 0)
                        <tr>
                           <tr>
                              <td rowspan="2"></td>
                              <td rowspan="2" class="text-center">{{$bpjs->location_name}}</td>
                              <td>Jaminan Kesehatan</td>
                              <td class="text-center">{{$bpjs->tarif}} %</td>
                              <td class="text-center">{{$bpjs->qty}}</td>
                              <td class="text-right" >{{formatRupiahB($bpjs->upah)}}</td>
                              <td class="text-right">{{formatRupiahB($bpjs->perusahaan)}}</td>
                              <td class="text-right">{{formatRupiahB($bpjs->karyawan)}}</td>
                              <td class="text-right">{{formatRupiahB($bpjs->total_iuran)}}</td>
                           </tr>
                           <tr>
                              <td>Iuran Tambahan</td>
                              <td class="text-center">1%</td>
                              <td class="text-center">-</td>
                              <td></td>
                              <td></td>
                              <td class="text-right"> {{formatRupiahB($bpjs->additional_iuran)}}</td>
                              <td class="text-right">{{formatRupiahB($bpjs->additional_iuran)}}</td>
                           </tr>
                        </tr>
                        @php
                           $additional_karyawan =  $additional_karyawan + $bpjs->additional_iuran
                        @endphp
                        @endif
                           
                            
                        @endforeach
                        <tr>
                           <td colspan="2"></td>
                           <td><b>Total</b></td>
                           <td class="text-center"><b>{{$bpjsKsReports->sum('qty')}}</b></td>
                           <td></td>
                           <td class="text-right"><b>{{formatRupiahB($bpjsKsReports->sum('upah'))}}</b></td>
                           <td class="text-right"><b>{{formatRupiahB($bpjsKsReports->sum('perusahaan'))}}</b></td>
                           <td class="text-right"><b>{{formatRupiahB($bpjsKsReports->sum('karyawan') + $additional_karyawan )}}</b></td>
                           <td class="text-right"><b>{{formatRupiahB($bpjsKsReports->sum('total_iuran') + $bpjsKsReports->sum('additional_iuran'))}}</b></td>
                           
                        </tr>
                        
                     
                        <tr>
                           <td colspan="9">BAGIAN IV - Jumlah Seluruhnya</td>
                           
                        </tr>
                        <tr>
                           <td></td>
                           <td colspan="3">Jumlah seluruhnya (III-IV+V)</td>
                           
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td class="text-right"><b>{{formatRupiahB($bpjsKsReports->sum('total_iuran') + $bpjsKsReports->sum('additional_iuran'))}}</b></td>
                        </tr>
                     </tbody>
                     
                  </table>
      
                  {{-- <table>
                     <tbody>
                        <tr>
                           <td colspan="">Jakarta,</td>
                        </tr>
                        <tr>
                           <td colspan="">Dibuat oleh,</td>
                           <td colspan="">-</td>
                           <td colspan="">Diperiksa oleh</td>
                           <td colspan=""></td>
                           <td colspan="">Disetujui oleh</td>
                        </tr>
                        <tr>
                           <td colspan="" style="height: 80px" class="text-center">
                              @if ($hrd)
                              {{formatDateTime($hrd->created_at)}} 
                              @endif
                           </td>
                           <td colspan="" style="height: 80px" class="text-center">
                              @if ($manHrd)
                              {{formatDateTime($manHrd->created_at)}} 
                              @endif
                           </td>
                           <td colspan="" style="height: 80px" class="text-center">
                              @if ($manFin)
                              {{formatDateTime($manFin->created_at)}} 
                              @endif
                           </td>
                           <td colspan="" style="height: 80px" class="text-center">
                              @if ($gm)
                              {{formatDateTime($gm->created_at)}} 
                              @endif
                           </td>
                           <td colspan="" style="height: 80px" class="text-center">
                              @if ($bod)
                              {{formatDateTime($bod->created_at)}} 
                              @endif
                           </td>
                        </tr>
                        <tr>
                           <td>
                              @if ($hrd)
                                 {{$hrd->employee->biodata->fullName()}}
                              @endif
                              
                           </td>
                           <td>
                              @if ($manHrd)
                                 {{$manHrd->employee->biodata->fullName()}}
                              @endif
                           </td>
                           <td>
                              @if ($manFin)
                                 {{$manFin->employee->biodata->fullName()}}
                              @endif
                           </td>
                           <td>
                              @if ($gm)
                                 {{$gm->employee->biodata->fullName()}}
                              @endif
                              
                           </td>
                           <td>
                              @if ($bod)
                              {{$bod->employee->biodata->fullName()}}
                              @endif
                           </td>
                        </tr>
                        <tr>
                           <td>Payroll</td>
                           <td>HRD Manager</td>
                           <td>Manager Finance</td>
                           <td>GM Finance & Acc</td>
                           <td>Direktur</td>
                        </tr>
                     </tbody>
                  </table> --}}
               @endif
            </div>

            <div class="tab-pane fade " id="pills-kt-nobd" role="tabpanel" aria-labelledby="pills-kt-tab-nobd">
               
               <table  >
                  <thead>
                     <tr>
                        <th colspan="4" class="bg-white px-2 py-2"><img src="{{asset('img/logo/bpjskt.png')}}" width="150px" alt=""></th>
                     </tr>
                     <tr style="padding: 0px!">
                        <th colspan="4" class="text-center bg-white p0" style="padding: 0px !important;" >RINCIAN IURAN</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td colspan="4" style="padding: 0px !important;" class="bg-success" >BAGIAN I - Perusahaan</td>
                     </tr>
                     <tr>
                        <td style="padding: 0px !important;" class="text-center">1</td>
                        <td style="padding: 0px !important;">NAMA INSTANSI/BADAN/PERUSAHAAN</td>
                        <td style="padding: 0px !important;" colspan="2">PT {{$unit->name}}</td>
                     </tr>
                     {{-- <tr>
                        <td style="padding: 0px !important;"></td>
                        <td style="padding: 0px !important;">KODE BADAN USAHA</td>
                        <td style="padding: 0px !important;" colspan="2">01143486</td>
                     </tr> --}}
                     <tr>
                        <td style="padding: 0px !important;"></td>
                        <td style="padding: 0px !important;">ALAMAT</td>
                        <td style="padding: 0px !important;" colspan="2">{{$unit->alamat}}</td>
                     </tr>
                     <tr>
                        <td style="padding: 0px !important;"></td>
                        <td style="padding: 0px !important;">Nomor Pendaftaran Perusahan (NPP) </td>
                        <td style="padding: 0px !important;" colspan="2">{{$unit->npp}}</td>
                     </tr>
                     <tr>
                        <td style="padding: 0px !important; height: 20px" colspan="3" ></td>
                     </tr>
                     <tr>
                        <td style="padding: 0px !important;" class="text-center">2</td>
                        <td style="padding: 0px !important;">Iuran untuk bulan / thn</td>
                        <td style="padding: 0px !important;"colspan="2" class="">{{$reportBpjsKt->month}} {{$reportBpjsKt->year}}</td>
                     </tr>
                    
                     <tr>
                        <td style="padding: 0px !important;" class="text-center">3</td>
                        <td style="padding: 0px !important;">Iuran disetor melalui  </td>
                        <td style="padding: 0px !important;" colspan="2">Bank {{$unit->bank}}</td>
                     </tr>
                     {{-- <tr>
                        <td style="padding: 0px !important;" colspan="4">-</td>
                     </tr> --}}
                     <tr>
                        <td style="padding: 0px !important;" colspan="4" class="bg-success">BAGIAN II : Rekapitulasi tenaga kerja dan upah</td>
                     </tr>
                     
                     <tr>
                        <td style="padding: 0px !important;" colspan="2" rowspan="2" class="text-center">Iuran</td>
                        <td style="padding: 0px !important;" colspan="2" class="text-center">Jumlah</td>
                     </tr>
                     <tr>
                        <td style="padding: 0px !important;" class="text-center">Tenaga Kerja</td>
                        <td style="padding: 0px !important;" class="text-center">Upah (Rp.)</td>
                     </tr>
   
                     <tr>
                        <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-center">A</td>
                        <td style="padding: 0px !important;">Bulan lalu</td>
                        <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-center">0</td>
                        <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-right">0</td>
                     </tr>
                     <tr>
                        <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-center">B</td>
                        <td style="padding: 0px !important;">Penambahan tenaga kerja</td>
                        <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-center">0</td>
                        <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-right">0</td>
                     </tr>
                     <tr>
                        <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-center">C</td>
                        <td style="padding: 0px !important;">Pengurangan tenaga kerja</td>
                        <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-center">0</td>
                        <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-right">0</td>
                     </tr>
                     <tr>
                        <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-center">D</td>
                        <td style="padding: 0px !important;">Perubahan Upah</td>
                        <td style="padding: 0px !important;" style="padding: 0px !important;"  class="text-center"></td>
                        <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-right"></td>
                     </tr>
                     <tr>
                        <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-center">E</td>
                        <td style="padding: 0px !important;">Jumlah (A+B+C)</td>
                        <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-center">0</td>
                        <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-right">0</td>
                     </tr>
                     
   
                  </tbody>
                  
               </table>
               <table>
                  <tbody>
                     <tr>
                        <td style="padding: 0px !important;" colspan="9" class="bg-success">BAGIAN III : Rincian Iuran bulan ini</td>
                     </tr>
                     <tr>
                     
                     <tr>
                        {{-- <td style="padding: 0px !important;" colspan="2">(1)</td> --}}
                        <td style="padding: 0px !important;" colspan="3" class="text-center">Program</td>
                        <td style="padding: 0px !important;" class="text-center">Tarif</td>
                        <td style="padding: 0px !important;" class="text-center">Tenaga <br> Kerja</td>
                        <td style="padding: 0px !important;" class="text-center" >Upah</td>
                        <td style="padding: 0px !important;" class="text-center" >Perusahaan</td>
                        <td style="padding: 0px !important;" class="text-center" >Karyawan</td>
                        <td style="padding: 0px !important;" class="text-center" >Jumlah Iuran</td>
                     </tr>

                     @php
                        $num = 0;
                        $totalEmployee = 0;
                        $totalCompany = 0;

                        $totalJkk = 0;
                        $totalJht = 0;
                        $totalJkm = 0;
                        $totalJp = 0;

                        $totalJkkCom = 0;
                        $totalJhtCom = 0;
                        $totalJkmCom = 0;
                        $totalJpCom = 0;

                        $totalUpah = 0;
                        $totalUpahJp = 0
                     @endphp

                     @foreach ($bpjsKtReports as $kt)
                     @if ($kt->qty >= 0)
                     <tr>
                        {{-- <td  class="text-center">-</td> --}}
                        <td   class="text-center" colspan="2">{{$kt->location_name}}</td>
                        <td>{{$kt->program}}</td>
                        <td class="text-center">{{$kt->tarif}} %</td>
                        <td class="text-center">{{$kt->qty}}</td>
                        <td class="text-right" >{{formatRupiahB($kt->upah)}}</td>
                        <td class="text-right">{{formatRupiahB($kt->perusahaan)}}</td>
                        <td class="text-right">{{formatRupiahB($kt->karyawan)}}</td>
                        <td class="text-right">{{formatRupiahB($kt->total_iuran)}}</td>
                     </tr>

                     @if ($kt->program == 'Jaminan Kecelakaan Kerja (JKK)')
                     @php
                         $totalJkk = $totalJkk +$kt->karyawan;
                         $totalJkkCom = $totalJkkCom +$kt->karyawan;
                         $totalUpah = $totalUpah + $kt->upah;
                     @endphp
                  @endif
                  @if ($kt->program == 'Jaminan Hari Tua (JHT)')
                     @php
                           $totalJht = $totalJht +$kt->karyawan;
                           $totalJhtCom = $totalJhtCom +$kt->perusahaan;
                           $totalUpah = $totalUpah + $kt->upah;
                     @endphp
                  @endif
                  @if ($kt->program == 'Jaminan Kematian (JKM)')
                     @php
                           $totalJkm = $totalJkm +$kt->karyawan;
                           $totalJkmCom = $totalJkmCom +$kt->perusahaan;
                           $totalUpah = $totalUpah + $kt->upah;
                     @endphp
                  @endif
                  @if ($kt->program == 'Jaminan Pensiun')
                     @php
                           $totalJp = $totalJp +$kt->karyawan;
                           $totalJpCom = $totalJpCom +$kt->perusahaan;
                           $totalUpahJp = $totalUpahJp + $kt->upah;
                     @endphp
                  @endif

                  @php
                      $totalEmployee = $totalEmployee + $kt->karyawan;
                      $totalCompany = $totalCompany + $kt->perusahaan;
                  @endphp
                     @endif
                        

                       
                     @endforeach

                     <tr>
                     <td colspan="9"></td>
                  </tr>
                  <tr>
                     <td></td>
                     <td></td>
                     <td>Total JKK, JKM, JHT</td>
                     <td></td>
                     <td></td>
                     <td class="text-right">{{formatRupiahB($totalUpah)}}</td>
                     <td class="text-right">{{formatRupiahB($totalJkkCom + $totalJkmCom + $totalJhtCom)}}</td>
                     <td class="text-right">{{formatRupiahB($totalJkk + $totalJkm + $totalJht)}}</td>
                     <td class="text-right">{{formatRupiahB($totalJkk + $totalJkm + $totalJht + $totalJkkCom + $totalJkmCom + $totalJhtCom)}}</td>
                  </tr>
                  <tr>
                     <td></td>
                     <td></td>
                     <td>Total JP</td>
                     <td></td>
                     <td></td>
                     <td class="text-right">{{formatRupiahB($totalUpahJp)}}</td>
                     <td class="text-right">{{formatRupiahB($totalJpCom)}}</td>
                     <td class="text-right">{{formatRupiahB($totalJp)}}</td>
                     <td class="text-right">{{formatRupiahB($totalJp + $totalJpCom)}}</td>
                  </tr>
                     {{-- <tr>
                          
                        <td>Jumlah (a+b+c+d)</td>
                        <td  class="text-center">1%</td>
                        <td  class="text-center">-</td>
                        <td></td>
                        <td class="text-right"> </td>
                        <td class="text-right"> </td>
                        <td class="text-right"></td>
                     </tr> --}}

                     <tr>
                        <td colspan="9" class="bg-success">BAGIAN IV - Jumlah Seluruhnya</td>
                        
                     </tr>
                     <tr>
                        {{-- <td></td> --}}
                        <td colspan="4">Jumlah seluruhnya (III-IV+V)</td>
                        
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">{{formatRupiahB($bpjsKtReports->sum('total_iuran'))}}</td>
                     </tr>
                     
         
                  </tbody>
                  
               </table>
   
               {{-- <table>
                  <tbody>
                     <tr>
                        <td colspan="">Jakarta,</td>
                     </tr>
                     <tr>
                        <td colspan="">Dibuat oleh,</td>
                        <td colspan="">-</td>
                        <td colspan="">Diperiksa oleh</td>
                        <td colspan=""></td>
                        <td colspan="">Disetujui oleh</td>
                     </tr>
                     <tr>
                        <td colspan="" style="height: 80px" class="text-center">
                           @if ($hrd)
                           {{formatDateTime($hrd->created_at)}} 
                           @endif
                        </td>
                        <td colspan="" style="height: 80px" class="text-center">
                           @if ($manHrd)
                           {{formatDateTime($manHrd->created_at)}} 
                           @endif
                        </td>
                        <td colspan="" style="height: 80px" class="text-center">
                           @if ($manFin)
                           {{formatDateTime($manFin->created_at)}} 
                           @endif
                        </td>
                        <td colspan="" style="height: 80px" class="text-center">
                           @if ($gm)
                           {{formatDateTime($gm->created_at)}} 
                           @endif
                        </td>
                        <td colspan="" style="height: 80px" class="text-center">
                           @if ($bod)
                           {{formatDateTime($bod->created_at)}} 
                           @endif
                        </td>
                     </tr>
                     <tr>
                        <td>
                           @if ($hrd)
                              {{$hrd->employee->biodata->fullName()}}
                           @endif
                           
                        </td>
                        <td>
                           @if ($manHrd)
                              {{$manHrd->employee->biodata->fullName()}}
                           @endif
                        </td>
                        <td>
                           @if ($manFin)
                              {{$manFin->employee->biodata->fullName()}}
                           @endif
                        </td>
                        <td>
                           @if ($gm)
                              {{$gm->employee->biodata->fullName()}}
                           @endif
                           
                        </td>
                        <td>
                           @if ($bod)
                           {{$bod->employee->biodata->fullName()}}
                           @endif
                        </td>
                     </tr>
                     <tr>
                        <td>Payroll</td>
                        <td>HRD Manager</td>
                        <td>Manager Finance</td>
                        <td>GM Finance & Acc</td>
                        <td>Direktur</td>
                     </tr>
                  </tbody>
               </table> --}}
               
            </div>

            <div class="tab-pane fade " id="pills-timeline-nobd" role="tabpanel" aria-labelledby="pills-timeline-tab-nobd">
               <div class="hori-timeline mt-3" dir="ltr">
                  <ul class="list-inline events">
                      
                      <li class="list-inline-item event-list">
                          <div class="px-4">
                           
                           @if ($manHrd)
                              <div class="event-date bg-primary text-white">MANAGER HRD</div>
                              <h5 class="font-size-16">{{formatDateTime($manHrd->created_at)}}</h5>
                              
                              @else  
                              <div class="event-date bg-light border">HRD MANAGER</div>
                              <h5 class="font-size-16">Waiting</h5>
                              
                           @endif
                              
                              {{-- <p class="text-muted">Everyone realizes why a new common language one could refuse translators.</p> --}}
                              {{-- <div>
                                  <a href="#" class="btn btn-primary btn-sm">Read more</a>
                              </div> --}}
                          </div>
                      </li>
                      <li class="list-inline-item event-list">
                          <div class="px-4">
                           @if ($manFin)
                              <div class="event-date bg-primary text-white">MANAGER FINANCE</div>
                              <h5 class="font-size-16">{{formatDateTime($manFin->created_at)}}</h5>
                              
                              @else  
                              <div class="event-date bg-light border">MANAGER FINANCE</div>
                              <h5 class="font-size-16">Waiting</h5>
                              
                           @endif
                              {{-- <p class="text-muted">If several languages coalesce the grammar of the resulting simple and regular</p>
                              <div>
                                  <a href="#" class="btn btn-primary btn-sm">Read more</a>
                              </div> --}}
                          </div>
                      </li>
                      <li class="list-inline-item event-list">
                          <div class="px-4">
                           @if ($gm)
                              <div class="event-date bg-primary text-white">GENERAL MANAGER</div>
                              <h5 class="font-size-16">{{formatDateTime($gm->created_at)}}</h5>
                              @elseif($unitTransaction->status == 303)
                              <div class="event-date bg-danger border text-white">GENERAL MANAGER</div>
                              <h5 class="font-size-16">Reject {{formatDateTime($unitTransaction->reject_date)}}</h5>
                              @else  
                                    @if ($gm == null && $unitTransaction->status > 3)
                                    <div class="event-date bg-light border">GENERAL MANAGER</div>
                                    <h5 class="font-size-16">Approved Manual</h5>
                                    @else
                                    <div class="event-date bg-light border">GENERAL MANAGER <br><br> </div>
                                    <h5 class="font-size-16">Waiting</h5>
                                    @endif
                              
                           @endif
                          </div>
                      </li>
                      <li class="list-inline-item event-list">
                         <div class="px-4">
                           @if ($bod)
                              <div class="event-date bg-primary text-white">DIREKSI / BOD</div>
                              <h5 class="font-size-16">{{formatDateTime($bod->created_at)}}</h5>
                              
                              @else  

                              @if ($bod == null && $unitTransaction->status > 4)
                              <div class="event-date bg-light border">DIREKSI</div>
                              <h5 class="font-size-16">Approved Manual</h5>
                              @else
                              <div class="event-date bg-light border">DIREKSI <br><br> </div>
                              <h5 class="font-size-16">Waiting</h5>
                              @endif
                              
                           @endif
                         </div>
                     </li>
                      
                  </ul>
               </div>
               
            </div>
           

         </div>

      </div>
      <div class="card-footer">
         <table>
            <tbody>
               <tr>
                  <td colspan="">Jakarta,
                      @if ($hrd)
                     {{formatDateB($hrd->created_at)}} 
                     @endif
                  </td>
               </tr>
               <tr>
                  <td colspan="">Dibuat oleh,</td>
                  <td colspan="">-</td>
                  <td colspan="">Diperiksa oleh</td>
                  <td colspan=""></td>
                  <td colspan="">Disetujui oleh</td>
               </tr>
               <tr>
                  <td colspan="" style="height: 80px" class="text-center">
                     @if ($hrd)
                     {{formatDateTime($hrd->created_at)}} 
                     @endif
                  </td>
                  <td colspan="" style="height: 80px" class="text-center">
                     @if ($manHrd)
                     {{formatDateTime($manHrd->created_at)}} 
                     @endif
                     @if ($manHrd == null && $unitTransaction->status > 1)
                     <span>Approve Manual</span>
                     @endif
                  </td>
                  <td colspan="" style="height: 80px" class="text-center">
                     @if ($manFin)
                     {{formatDateTime($manFin->created_at)}} 
                     @endif
                     @if ($manFin == null && $unitTransaction->status > 2)
                     <span>Approve Manual</span>
                     @endif
                  </td>
                  <td colspan="" style="height: 80px" class="text-center">
                     @if ($gm)
                     {{formatDateTime($gm->created_at)}} 
                     @endif
                     @if ($gm == null && $unitTransaction->status > 3)
                     <span>Approve Manual</span>
                     @endif
                  </td>
                  <td colspan="" style="height: 80px" class="text-center">
                     @if ($bod)
                     {{formatDateTime($bod->created_at)}} 
                     @endif
                     @if ($bod == null && $unitTransaction->status > 4)
                     <span>Approve Manual</span>
                     @endif
                  </td>
               </tr>
               <tr>
                  <td>
                     @if ($hrd)
                        {{$hrd->employee->biodata->fullName()}}
                     @endif
                     
                  </td>
                  <td>
                     {{-- @if ($manHrd)
                        {{$manHrd->employee->biodata->fullName()}}
                     @endif --}}
                     Saruddin Batubara
                  </td>
                  <td>
                     Andrianto
                     {{-- @if ($manFin)
                        {{$manFin->employee->biodata->fullName()}}
                     @endif --}}
                  </td>
                  <td>
                     Andi Kurniawan Nasution
                     {{-- @if ($gm)
                        {{$gm->employee->biodata->fullName()}}
                     @endif --}}
                     
                  </td>
                  <td>
                     
                     @if ($unit->id == 2 || $unit->id == 3 || $unit->id == 6 || $unit->id == 23 || $unit->id == 24 || $unit->id == 5 || $unit->id == 22 || $unit->id == 11 || $unit->id == 12 || $unit->id == 15 || $unit->id == 19)
                     Indra Muhammad Anwar
                     @else
                     Wildan Muhammad Anwar
                     @endif

                     {{-- @if ($bod)
                     {{$bod->employee->biodata->fullName()}}
                     @endif --}}
                  </td>
               </tr>
               <tr>
                  <td>Payroll</td>
                  <td>HRD Manager</td>
                  <td>Manager Finance</td>
                  <td>GM Finance & Acc</td>
                  <td>Direktur</td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>

   
   

   


   
   


   
   
   
</div>

<div class="modal fade" id="modal-export" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Export Excel</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         
         <div class="modal-body">

           
            
         </div>
         <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">SIMPLE DATA</button> --}}
            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
            <a  href="{{route('employee.export.simple')}}" class="btn btn-info">SIMPLE DATA</a>
            <a  href="{{route('employee.export')}}" class="btn btn-primary">FULL DATA</a>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-submit-tu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('payroll.submit.master.transaction')}}" method="POST" >
            <div class="modal-body">
               @csrf
               <input type="text" value="{{$unitTransaction->id}}" name="unitTransactionId" id="unitTransactionId" hidden>
               <span>Submit this Report and send to HRD Manager?</span>
                  
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary ">Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-publish-tu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('payroll.publish')}}" method="POST" >
            <div class="modal-body">
               @csrf
               <input type="text" value="{{$unitTransaction->id}}" name="unitTransactionId" id="unitTransactionId" hidden>
               <span>Publish PaySlip dan tampilkan di Dashboard Karyawan?</span>
                  
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary ">Publish</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-approve-hrd-tu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('payroll.approve.hrd')}}" method="POST" >
            <div class="modal-body">
               @csrf
               <input type="text" value="{{$unitTransaction->id}}" name="unitTransactionId" id="unitTransactionId" hidden>
               <span>Approve Payslip Report ?</span> 
               <hr>
               <small>Aksi ini akan otomatis menyetujui Payslip Report semua lokasi</small>
                  
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary ">Approve</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="modal-reject-hrd-tu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm Reject<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('payroll.reject.hrd')}}" method="POST" >
            <div class="modal-body">
               @csrf
               <input type="text" value="{{$unitTransaction->id}}" name="unitTransactionId" id="unitTransactionId" hidden>
               <span>Reject this Report and send back to HRD?</span>
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

<div class="modal fade" id="modal-approve-fin-tu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('payroll.approve.manfin')}}" method="POST" >
            <div class="modal-body">
               @csrf
               <input type="text" value="{{$unitTransaction->id}}" name="unitTransactionId" id="unitTransactionId" hidden>
               <span>Approve this Payslip Report and send to General Manager?</span>
               <hr>
               <small class="text-muted">
                  Aksi ini akan otomatis menyetujui payslip report semua lokasi
               </small>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary ">Approve</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="modal-reject-manfin-tu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm Reject<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('payroll.reject.manfin')}}" method="POST" >
            <div class="modal-body">
               @csrf
               <input type="text" value="{{$unitTransaction->id}}" name="unitTransactionId" id="unitTransactionId" hidden>
               <span>Reject this Report and send back to HRD?</span>
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

<div class="modal fade" id="modal-approve-gm-tu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('payroll.approve.gm')}}" method="POST" >
            <div class="modal-body">
               @csrf
               <input type="text" value="{{$unitTransaction->id}}" name="unitTransactionId" id="unitTransactionId" hidden>
               <span>Approve this Report and send to Direksi/BOD?</span>
                  
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary ">Approve</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="modal-reject-gm-tu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm Reject<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('payroll.reject.gm')}}" method="POST" >
            <div class="modal-body">
               @csrf
               <input type="text" value="{{$unitTransaction->id}}" name="unitTransactionId" id="unitTransactionId" hidden>
               <span>Reject this Report and send back to HRD?</span>
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





<div class="modal fade" id="modal-approve-bod-tu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('payroll.approve.bod')}}" method="POST" >
            <div class="modal-body">
               @csrf
               <input type="text" value="{{$unitTransaction->id}}" name="unitTransactionId" id="unitTransactionId" hidden>
               <span>Approve this Payroll Report ?</span>
                  
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary ">Approve</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="modal-reject-bod-tu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm Reject<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('payroll.reject.bod')}}" method="POST" >
            <div class="modal-body">
               @csrf
               <input type="text" value="{{$unitTransaction->id}}" name="unitTransactionId" id="unitTransactionId" hidden>
               <span>Reject this Report and send back to HRD?</span>
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



<div class="modal fade" id="modal-open-attachment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Attachment<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>

         <div class="modal-body">
            @php

            $ekstensi = strtolower(pathinfo($unitTransaction->file, PATHINFO_EXTENSION));
            
            
            @endphp  
                     
               {{-- {{$absenceemp->doc}} --}}
               @if ($unitTransaction->file != null)
      
                     
      
                  @if ($ekstensi == 'pdf')
                  <iframe  src="/storage/{{$unitTransaction->file}}" style="width:100%; height:550px;" frameborder="0"></iframe>
                  @else
                  <img width="100%" src="/storage/{{$unitTransaction->file}}" alt="">
                  @endif
                  
                  
               @endif
                     
         </div>
         
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               {{-- <button type="submit" class="btn btn-primary ">Publish</button> --}}
            </div>
         
      </div>
   </div>
</div>


@endsection