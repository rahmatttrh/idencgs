@extends('layouts.app')
@section('title')
Payroll Report BPJS KT
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

<style>
   .p0 {
      padding: 0px !important;
   }
</style>


<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item" aria-current="page"><a href="{{route('payroll.transaction')}}">Transaction</a></li>
         <li class="breadcrumb-item" aria-current="page">{{$unitTransaction->unit->name}}</li>
         <li class="breadcrumb-item" aria-current="page">{{$unitTransaction->month}}</li>
         <li class="breadcrumb-item active" aria-current="page">Report BPJS Ketenagakerjaan </li>
      </ol>
   </nav>

   <div class="row hide mb-2">
      <div class="col">
         <a href="{{route('payroll.transaction.monthly.all', enkripRambo($unitTransaction->id))}}" class="btn btn-light border" ><i class="fa fa-backward"></i> Back</a>
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
   

   
   
   

   

   <div class="card">
      {{-- <div class="card-header p-3  d-flex justify-content-between">
         <div>
            <h4 class="text-uppercase"><b>{{$unitTransaction->unit->name}}</b> {{$unitTransaction->month}} {{$unitTransaction->year}}</h4>
            <h1><b> {{formatRupiahB($unitTransaction->unit->getUnitTransaction($unitTransaction)->sum('total'))}}</b></h1>
            <small>STATUS : <span class="text-uppercase"> <x-status.unit-transaction :unittrans="$unitTransaction"/> </span></small> <br>
            
         </div>
             
      </div> --}}
      <div class="card-body p-0">
         
         {{-- <div class="table-responsive" style=""> --}}
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
                     <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-center">{{$lastReportBpjsKt->payslip_employee ?? ''}}</td>
                     <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-right">{{formatRupiahB($lastReportBpjsKt->payslip_total ?? 0)}}</td>
                  </tr>
                  <tr>
                     <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-center">B</td>
                     <td style="padding: 0px !important;">Penambahan tenaga kerja</td>
                     <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-center">{{count($newTransactions)}}</td>
                     <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-right">{{formatrupiahB($newTransactions->sum('total'))}}</td>
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
                     <td style="padding: 0px !important;" style="padding: 0px !important;"  class="text-center">{{count($outTransactions)}}</td>
                     <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-right">{{formatrupiahB($outTransactions->sum('total'))}}</td>
                  </tr>
                  <tr>
                     <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-center">E</td>
                     <td style="padding: 0px !important;">Jumlah (A+B+C)</td>
                     <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-center">{{$reportBpjsKt->payslip_employee}}</td>
                     <td style="padding: 0px !important;" style="padding: 0px !important;" class="text-right">{{formatRupiahB($lastReportBpjsKt->payslip_total ?? 0 + $newTransactions->sum('total') )}}</td>
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
                  @if ($kt->qty > 0)
                  @php
                      $num = $num +1;
                  @endphp
                  <tr>
                     {{-- <td  class="text-center">-</td> --}}
                     @if ($num == 1 || $num == 5 || $num == 9 || $num == 13 || $num == 17 || $num == 21 || $num == 25 || $num == 29 || $num == 33 || $num == 37 || $num == 41)
                        <td   class="text-center" colspan="2" rowspan="4">{{$kt->location_name}}

                           
                        </td>
                     @endif
                     {{-- <td   class="text-center" colspan="2" >{{$kt->location_name}}</td> --}}
                     
                     <td>{{$kt->program}} 
                        @if (auth()->user()->hasRole('Administrator'))
                               ID:{{$kt->id}}
                           @endif </td>
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
                     {{-- <td class="text-right">{{formatRupiahB($totalCompany)}}</td>
                     <td class="text-right">{{formatRupiahB($totalEmployee)}}</td> --}}
                     <td class="text-right">{{formatRupiahB($bpjsKtReports->sum('total_iuran'))}}</td>
                  </tr>
                  
      
               </tbody>
               
            </table>

            <table>
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
                           {{-- @if ($hrd)
                              {{$hrd->employee->biodata->fullName()}}
                           @endif --}}
                           @if ($unit->id == 2 || $unit->id == 3 || $unit->id == 6 || $unit->id == 23 || $unit->id == 24 || $unit->id == 5 || $unit->id == 22 || $unit->id == 11 || $unit->id == 12 || $unit->id == 15 || $unit->id == 19)
                           Tri Buanawati Asri
                           @else
                           Cheppy Anugrah
                           @endif
                           
                        </td>
                        <td>
                           Saruddin Batubara
                           {{-- @if ($manHrd)
                              {{$manHrd->employee->biodata->fullName()}}
                           @endif --}}
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
         {{-- </div> --}}
      </div>
   </div>


   <hr>

   <div class="card">
      <div class="card-body">
          {{-- <h4 class="card-title mb-5">Horizontal Timeline</h4> --}}

          
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
               <span>Approve this Report and send to Manager Finance?</span>
                  
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary ">Approve</button>
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
               <span>Approve this Report and send to General Manager?</span>
                  
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary ">Approve</button>
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


@endsection