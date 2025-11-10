@extends('layouts.app-doc')
@section('title')
Payslip Report {{$unit->name}} {{$unitTransaction->month}} {{$unitTransaction->year}}
@endsection
@section('content')

<style>
   html {
      -webkit-print-color-adjust: exact;
   }

   table,
   th,
   td {
      
      border: 1px solid black;
      border-collapse: collapse;
   }

   .ttd {
      font-size: 10px;
   }

   table td {
      font-size: 10px;
      padding-top: 5px;
  padding-bottom: 5px;
      padding-left: 5px;
      padding-right: 5px;
   }



   table {
      width: 100%;
   }


   .border-none {
      border: none;
   }

   table td {
      font-size: 8px;
   }
</style>


<div class="page-body">
   <div class="container-xl">
      <div class="card card-lg">
         <div class="card-footer d-print-none">
            <small>*Disarankan merubah layout ke mode <b>landscape</b> setelah klik tombol 'Print' untuk hasil yang lebih baik.</small>
         </div>
         <div class="card-body p-0">
            {{-- <div class="table-responsive"> --}}
               <table>
                  <tbody>
                     <tr>
                        <td class="text-center" colspan="2">
                           <img src="{{asset('img/logo/enc1.png')}}" alt="" width="100">
                        </td>
                        <td class="text-center" colspan="2">
                           <h2>PAYSLIP REPORT</h2>
                        </td>
                        <td class="text-center" colspan="2">
                           @if ( $unit->id == 10)
                              <img src="{{asset('img/logo/peip.jpeg')}}" alt="" width="50"><br>
                              <span>PT {{$unit->name}}</span>
                              @elseif($unit->id == 5 || $unit->id == 22)
                              <img src="{{asset('img/logo/ekajaya-kridatama.jpeg')}}" alt="" width="150"><br>
                              {{-- <span>PT {{$unit->name}}</span> --}}
                              @elseif($unit->id == 7 || $unit->id == 8 || $unit->id == 9 || $unit->id == 20)
                              <img src="{{asset('img/logo/kci-new.jpeg')}}" alt="" width="70"><br>
                              <span>PT {{$unit->name}}</span>
                              @elseif($unit->id == 15)
                              <img src="{{asset('img/logo/sms.jpeg')}}" alt="" width="70"><br>
                              <span>PT {{$unit->name}}</span>
                              @elseif($unit->id == 19)
                              <img src="{{asset('img/logo/gti.png')}}" alt="" width="110"><br>
                              {{-- <span>PT {{$unit->name}}</span> --}}
                              
                                @elseif($unit->id == 14)
                              <img src="{{asset('img/logo/esper.png')}}" alt="" width="140"><br>
                              <span>PT {{$unit->name}}</span>
                              @elseif($unit->id == 13)
                              <img src="{{asset('img/logo/esmar.jpeg')}}" alt="" width="120"><br>
                              {{-- <span>PT {{$unit->name}}</span> --}}
                              @elseif($unit->id == 4)
                              <img src="{{asset('img/logo/enanugrah.jpeg')}}" alt="" width="170"><br>
                              {{-- <span>PT {{$unit->name}}</span> --}}
                              @elseif($unit->id == 17)
                              <img src="{{asset('img/logo/cli.jpeg')}}" alt="" width="120"><br>
                              {{-- <span>PT {{$unit->name}}</span> --}}
                               @elseif($unit->id == 3 || $unit->id == 6 || $unit->id == 23 || $unit->id == 24)
                              <img src="{{asset('img/logo/perkasa.jpeg')}}" alt="" width="190"><br>
                              {{-- <span>PT {{$unit->name}}</span> --}}
                              @elseif($unit->id == 12)
                              <img src="{{asset('img/logo/rajawali.jpeg')}}" alt="" width="120"><br>
                              <span>PT {{$unit->name}}</span>
                              @elseif($unit->id == 11)
                              <img src="{{asset('img/logo/robin-b.jpeg')}}" alt="" width="50"><br>
                              <span>PT {{$unit->name}}</span>
                               @else
                               
                               <img src="{{asset('img/logo/ekanuri.png')}}" alt="" width="100"><br>
                              <span>PT {{$unit->name}}</span>
                           @endif
                           
                        </td>
                     </tr>
                  </tbody>
               </table>
               <table>
                  <tbody>
                     
                     
                     <tr>
                        <td class="px-1 py-1" style="font-size: 10px">Unit</td>
                        <th colspan="17" class="px-1 py-1" style="font-size: 10px">{{$unit->name}}</th>
                     </tr>
                     <tr>
                        <td class="px-1 py-1" style="font-size: 10px">Bulan</td>
                        <th colspan="17" class="px-1 py-1" style="font-size: 10px">{{$unitTransaction->month}} {{$unitTransaction->year}}</th>
                     </tr>
                     {{-- <tr>
                        <th class="px-1 py-1" style="font-size: 10px">Tahun</th>
                        <th colspan="17" class="px-1 py-1" style="font-size: 10px">{{$unitTransaction->year}}</th>
                     </tr> --}}
                     <tr>
                        <td class="px-1 py-1" style="font-size: 10px">Total</td>
                        <th colspan="17" class="px-1 py-1" style="font-size: 10px">
                           {{formatRupiahB($payslipReports->sum('gaji_bersih'))}}
                        </th>
                     </tr>
                  </tbody>
                  <tbody>
                     <tr>
                        <th rowspan="2" style="font-size: 8px" class="text-center">Loc</th>
                        <th rowspan="2" style="font-size: 8px" class="text-center">Jmlh Pgw</th>
                        <th colspan="9" style="font-size: 8px" class="text-center">Pendapatan</th>
                        <th colspan="6" style="font-size: 8px" class="text-center">Potogan</th>
                        <th rowspan="2" style="font-size: 8px" class="text-center">Gaji Bersih</th>
                     </tr>
                     <tr>
                        <th style="font-size: 8px" class="text-center">Gaji Pokok</th>
                        <th style="font-size: 8px" class="text-center">Tunj. Jabatan</th>
                        <th style="font-size: 8px" class="text-center">Tunj. OPS</th>
                        <th style="font-size: 8px" class="text-center">Tunj. Kinerja</th>
                        <th style="font-size: 8px" class="text-center">Tunj. Fungsional</th>
                        <th style="font-size: 8px" class="text-center">Toatal Gaji</th>
                        <th style="font-size: 8px" class="text-center">Lembur</th>
                        <th style="font-size: 8px" class="text-center">Lain-lain</th>
                        <th style="font-size: 8px" class="text-center">Total Bruto</th>
                        <th style="font-size: 8px" class="text-center">BPJK TK</th>
                        <th style="font-size: 8px" class="text-center">BPJS KS</th>
                        <th style="font-size: 8px" class="text-center">JP</th>
                        <th style="font-size: 8px" class="text-center">Absen</th>
                        <th style="font-size: 8px" class="text-center">Terlambat</th>
                        <th style="font-size: 8px" class="text-center">Lain-lain</th>
                     </tr>




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

                           @if ($report->qty > 0 || count($report->projects) > 0)
                           <tr>
                              @if (auth()->user()->username == 'EN-2-001' || auth()->user()->username == 'EN-4-093')
                                 @if ($report->status == 1)
                                    <td class="text-truncate bg-success" ><a class="text-white" href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                                    @elseif ($report->status == 101)  
                                       <td class="text-truncate bg-danger text-white" >
                                          <a class="text-white" href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a> <br>
                                          {{$report->status}} :
                                          <small>{{$report->reject_desc}}</small>
                                       </td>
                                       
                                    @else
                                    <td class="text-truncate  " ><a  href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                                 @endif
                              @endif

                              @if (auth()->user()->username == '11304')
                                 @if ($report->status >= 2)
                                 <td class="text-truncate bg-success" ><a class="text-white" href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                                    @else
                                    <td class="text-truncate  " ><a  href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                                 @endif
                              @endif

                              @if (auth()->user()->username == 'EN-2-006')
                              
                                 @if ($report->status == 3 || $report->status == 4)
                                 
                                 <td class="text-truncate bg-success" ><a class="text-white" href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                                 @elseif ($report->status == 303)  
                                    <td class="text-truncate bg-danger text-white" >
                                       <a class="text-white" href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a> <br>
                                       {{$report->status}} :
                                       <small>{{$report->reject_desc}}</small>
                                    </td>
                                 @else
                                    <td class="text-truncate  " ><a  href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                                 @endif
                              @endif

                              @if (auth()->user()->username == 'BOD-002')
                                 @if ($report->status >= 4)
                                 <td class="text-truncate bg-success" ><a class="text-white" href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                                    @else
                                    <td class="text-truncate  " ><a  href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                                 @endif
                              @endif

                              @if (auth()->user()->hasRole('Administrator|HRD-Payroll|HRD') &&  auth()->user()->username != 'EN-2-001' && auth()->user()->username != 'EN-4-093')
                                    @if ($report->status == 101 || $report->status == 202 || $report->status == 303 || $report->status == 404)
                                    <td class="text-truncate bg-danger text-white " ><a class="text-white" href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                                       @else
                                       <td class="text-truncate  " ><a  href="{{route('transaction.location', [enkripRambo($unitTransaction->id), enkripRambo($report->location_id)])}}">{{$report->location_name}}</a></td>
                                    @endif
                                 
                              @endif
                              
                              
                              <td class="text-center text-truncate">{{$report->qty}}</td>
                              
                              <td class="text-end text-truncate">{{formatRupiahB($report->pokok)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($report->jabatan)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($report->ops)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($report->kinerja)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($report->fungsional)}}</td>
      
                              <td class="text-end text-truncate">{{formatRupiahB($report->total)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($report->lembur)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($report->lain)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($report->bruto)}}</td>
      
                              {{-- Potongan --}}
                              {{-- <td class="text-end text-truncate">{{formatRupiahB(2/100 * $loc->getValueGaji($unit->id, $unitTransaction))}}</td> --}}
                              <td class="text-end text-truncate">{{formatRupiahB($report->bpjskt)}}</td>
                              
                              <td class="text-end text-truncate">{{formatRupiahB($report->bpjsks)}}
                                 {{-- @if (auth()->user()->hasRole('Administratro'))
                                 Add : {{$loc->getReductionAdditional($unit->id, $unitTransaction)}}
                                    
                                 @endif --}}
                              </td>
                              <td class="text-end text-truncate">{{formatRupiahB($report->jp)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($report->absen)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($report->terlambat)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($report->additional_pengurangan)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($report->gaji_bersih)}}</td>
                           </tr>

                           @php
                              
                              
                           @endphp
                           @if (count($report->projects) > 0)
                              
                           
                           @foreach ($report->projects as $pro)
                           <tr>
                              
                              <td class=" text-truncate pl-4"> - {{$pro->project->name}} </td>
                              <td class="text-center text-truncate">{{$pro->qty}}</td>
                     
                              <td class="text-end text-truncate">{{formatRupiahB($pro->pokok)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($pro->jabatan)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($pro->ops)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($pro->kinerja)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($pro->fungsional)}}</td>
      
                              <td class="text-end text-truncate">{{formatRupiahB($pro->total)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($pro->lembur)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($pro->lain)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($pro->bruto)}}</td>
      
                              {{-- Potongan --}}
                              {{-- <td class="text-end text-truncate">{{formatRupiahB(2/100 * $loc->getValueGaji($unit->id, $unitTransaction))}}</td> --}}
                              <td class="text-end text-truncate">{{formatRupiahB($pro->bpjskt)}}</td>
                              
                              <td class="text-end text-truncate">{{formatRupiahB($pro->bpjsks)}}
                                 {{-- @if (auth()->user()->hasRole('Administratro'))
                                 Add : {{$loc->getReductionAdditional($unit->id, $unitTransaction)}}
                                    
                                 @endif --}}
                              </td>
                              <td class="text-end text-truncate">{{formatRupiahB($pro->jp)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($pro->absen)}}</td>
                              <td class="text-end text-truncate">{{formatRupiahB($pro->terlambat)}}</td>
                              <td class="text-end text-truncate">0</td>
                              <td class="text-end text-truncate">{{formatRupiahB($pro->gaji_bersih)}}</td>
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
                              $proTerlambat = $proTerlambat + $pro->terlambat;
                              $proBersih = $proBersih + $pro->gaji_bersih;
                           @endphp

                           
                              
                           @endforeach
                           @endif
                           

                              

                           @endif
                           
                           @endforeach

                           {{-- <h4>{{$report->projects->sum('qty')}}</h4> --}}

                           <tr>
                              <td  class="text-end" ><b> Total</b></td>
                              {{-- <td><b></b></td> --}}
                              <td class="text-center">{{$payslipReports->sum('qty') + $proTotalQty }} </td>
                              <td class="text-end text-truncate"><b> {{formatRupiahB($payslipReports->sum('pokok') + $proPokok )}}</b></b></td>
                              <td class="text-end text-truncate"><b>{{formatRupiahB($payslipReports->sum('jabatan') + $proJabatan)}}</b></td>
                              <td class="text-end text-truncate"><b>{{formatRupiahB($payslipReports->sum('ops') + $proOps)}}</b></td>
                              <td class="text-end text-truncate"><b>{{formatRupiahB($payslipReports->sum('kinerja') + $proKinerja)}}</b></td>
                              <td class="text-end text-truncate"><b>{{formatRupiahB($payslipReports->sum('fungsional') + $proFung)}}</b></td>
                              <td class="text-end text-truncate"><b>{{formatRupiahB($payslipReports->sum('total') + $proTotal)}}</b></td>
                              <td class="text-end text-truncate"><b>{{formatRupiahB($payslipReports->sum('lembur') + $proLembur)}}</b></td>
                              <td class="text-end text-truncate"><b>{{formatRupiahB($payslipReports->sum('lain') + $proLain)}}</b></td>
                              <td class="text-end text-truncate"><b>{{formatRupiahB($payslipReports->sum('bruto') + $proBruto)}}</b></td>
                              <td class="text-end text-truncate"><b>{{formatRupiahB($payslipReports->sum('bpjskt') + $proBpjskt)}}</b></td>
                              <td class="text-end text-truncate"><b>{{formatRupiahB($payslipReports->sum('bpjsks') + $proBpjsks)}}</b></td>
                              <td class="text-end text-truncate"><b>{{formatRupiahB($payslipReports->sum('jp') + $proJp)}}</b></td>
                              <td class="text-end text-truncate"><b>{{formatRupiahB($payslipReports->sum('absen') + $proAbsen)}}</b></td>
                              <td class="text-end text-truncate"><b>{{formatRupiahB($payslipReports->sum('terlambat') + $proTerlambat)}}</b></td>
                              <td class="text-end text-truncate"><b>{{formatRupiahB($payslipReports->sum('additional_pengurangan') )}}</b></td>
                              <td class="text-end text-truncate"><b>{{formatRupiahB($payslipReports->sum('gaji_bersih') + $proBersih)}}</b></td>
                           </tr>
                  </tbody>
               </table>

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
                        <td colspan="" >
                           Dibuat oleh,
                           
                        </td>
                        <td colspan="">-</td>
                        <td colspan="">Diperiksa oleh</td>
                        <td colspan=""></td>
                        <td colspan="">Disetujui oleh</td>
                     </tr>
                     <tr>
                        <td colspan="" style="height: 80px" class="text-center">
                           @if ($hrd)
                           {{-- {{formatDateTime($hrd->created_at)}}  --}}
                           <h3 ><i>Approved</i></h3>
                           @endif
                        </td>
                        <td colspan="" style="height: 80px" class="text-center">
                           @if ($manHrd)
                           <h3 ><i>Approved</i></h3>
                           {{-- {{formatDateTime($manHrd->created_at)}}  --}}
                           @endif
                           @if ($manHrd == null && $unitTransaction->status > 1)
                           <h3 ><i>Approved Manual</i></h3>
                           @endif
                        </td>
                        <td colspan="" style="height: 80px" class="text-center">
                           @if ($manFin)
                           <h3 ><i>Approved</i></h3>
                           {{-- {{formatDateTime($manFin->created_at)}}  --}}
                           @endif
                           @if ($manFin == null && $unitTransaction->status > 2)
                           <h3 ><i>Approved Manual</i></h3>
                           @endif
                        </td>
                        <td colspan="" style="height: 80px" class="text-center">
                           @if ($gm)
                           <h3 ><i>Approved</i></h3>
                           {{-- {{formatDateTime($gm->created_at)}}  --}}
                           @endif
                           @if ($gm == null && $unitTransaction->status > 3)
                           <h3 ><i>Approved Manual</i></h3>
                           @endif
                        </td>
                        <td colspan="" style="height: 80px" class="text-center">
                           @if ($bod)
                           <h3 ><i>Approved</i></h3>
                           {{-- {{formatDateTime($bod->created_at)}}  --}}
                           @endif
                           @if ($bod == null && $unitTransaction->status > 4)
                           <h3 ><i>Approved Manual</i></h3>
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
                        <td>
                           HRD Payroll 
                           @if ($hrd)
                           
                           {{formatDateTime($hrd->created_at)}} 
                           @endif
                           {{-- Payroll --}}
                        </td>
                        <td>HRD Manager 
                           @if ($manHrd)
                           {{-- <h3 ><i>Approved</i></h3> --}}
                           {{formatDateTime($manHrd->created_at)}} 
                           @endif
                        </td>
                        <td>Manager Finance
                           @if ($manFin)
                           {{-- <h3 ><i>Approved</i></h3> --}}
                           {{formatDateTime($manFin->created_at)}} 
                           @endif
                        </td>
                        <td>GM Finance & Acc
                           @if ($gm)
                           {{-- <h3 ><i>Approved</i></h3> --}}
                           {{formatDateTime($gm->created_at)}} 
                           @endif
                        </td>
                        <td>Direktur
                           @if ($bod)
                           {{-- <h3 ><i>Approved</i></h3> --}}
                           {{formatDateTime($bod->created_at)}} 
                           @endif
                        </td>
                     </tr>
                  </tbody>
               </table>
            {{-- </div> --}}
         </div>
         
      </div>
   </div>
</div>
@endsection