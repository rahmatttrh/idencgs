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
                           <h2>PAYSLIP REPORT </h2>
                           <h5>LOKASI</h5>
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
                        <td class="px-1 py-1" style="font-size: 10px; width: 90px">Unit</td>
                        <th colspan="17" class="px-1 py-1" style="font-size: 10px">{{$unit->name}}</th>
                     </tr>
                     <tr>
                        <td class="px-1 py-1" style="font-size: 10px">Lokasi</td>
                        <th colspan="17" class="px-1 py-1" style="font-size: 10px">{{$payslipReport->location->name}}</th>
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
                        <td class="px-1 py-1" style="font-size: 10px">Transaksi</td>
                        <th colspan="17" class="px-1 py-1" style="font-size: 10px">
                           {{count($transactions)}} 
                        </th>
                     </tr>
                     <tr>
                        <td class="px-1 py-1" style="font-size: 10px">Total</td>
                        <th colspan="17" class="px-1 py-1" style="font-size: 10px">
                           {{formatRupiahB($transactions->sum('total'))}}
                        </th>
                     </tr>
                  </tbody>
                  
               </table>

               <table id="data" class="display  table-sm">
                  <thead >
                     
                     <tr>
                        <th style="font-size: 8px" class="">NIK</th>
                        <th style="font-size: 8px" class="">Name</th>
                        <th style="font-size: 8px" class="">Posisi</th>
                        <th style="font-size: 8px" class="text-center ">Gaji Pokok</th>
                        <th style="font-size: 8px" class="text-center ">Tunj. Jabatan</th>
                        <th style="font-size: 8px" class="text-center ">Tunj. OPS</th>
                        <th style="font-size: 8px" class="text-center ">Tunj. Kinerja</th>
                        <th style="font-size: 8px" class="text-center ">Tunj. Fungsional</th>
                        <th style="font-size: 8px" class="text-center ">Total Gaji</th>
                        <th style="font-size: 8px" class="text-center ">Lembur</th>
                        <th style="font-size: 8px" class="text-center ">Lain-Lain</th>
                        <th style="font-size: 8px" class="text-center ">Total Bruto</th>
                        <th style="font-size: 8px" class="text-center ">BPJS TK</th>
                        <th style="font-size: 8px" class="text-center ">BPJS KS</th>
                        {{-- <th style="font-size: 8px" class="text-center ">BPJS Additional</th> --}}
                        <th style="font-size: 8px" class="text-center ">JP</th>
                        <th style="font-size: 8px" class="text-center ">Absen</th>
                        <th style="font-size: 8px" class="text-center ">Terlambat</th>
                        <th style="font-size: 8px" class="text-center ">Potongan Lain</th>
                        <th style="font-size: 8px" class="text-center ">Total</th>
                        
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
                        $totalAdditionalPengurangan = 0;
                        $totalGrand = 0;
                     @endphp
   
                     @foreach ($transactions as $transaction)
                     @if ($transaction->remark == 'Karyawan Baru' || $transaction->remark == 'Karyawan Out' )
                        
                        @php
                           
                           $proratePokok = $transaction->employee->payroll->pokok / 30;
                           $qtyPokok = 30 - $transaction->off ;
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
                           <td class="text-truncate">{{$transaction->employee->nik}} 
                              {{-- @if (auth()->user()->hasRole('Administrator'))
                                  {{$transaction->employee->project->name ?? ''}}
                              @endif    --}}
                           </td>
                           <td class="text-truncate" style="max-width: 150px" >{{$transaction->employee->biodata->fullName()}}</td>
                            <td class="text-truncate"">{{$transaction->employee->contract->position->name ?? ''}}</td>
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
                           <td class="text-right">{{formatRupiahB($transaction->reduction_absence + $transaction->reduction_off)}}</td>
                           <td class="text-right">{{formatRupiahB($transaction->reduction_late)}}</td>
                           <td class="text-right">{{formatRupiahB($transaction->additional_pengurangan)}}</td>
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
                           $additional_pengurangan = $transaction->additional_pengurangan;
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
                           $totalAdditionalPengurangan  += $additional_pengurangan;
                           $totalGrand += $total;
                        @endphp
                       
                        
                        
                        
                        @else
                        <tr>
                           <td class="text-truncate">{{$transaction->employee->nik}} </td>
                           <td class="text-truncate" style="max-width: 150px" >{{$transaction->employee->biodata->fullName()}}</td>
                           <td class="text-truncate"">{{$transaction->employee->contract->position->name ?? ''}}</td>
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
                           <td class="text-right">{{formatRupiahB($transaction->reduction_absence + $transaction->reduction_off)}}</td>
                           <td class="text-right">{{formatRupiahB($transaction->reduction_late)}}</td>
                           <td class="text-right">{{formatRupiahB($transaction->additional_pengurangan)}}</td>
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
                           $additional_pengurangan = $transaction->additional_pengurangan;
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
                           $totalAdditionalPengurangan  += $additional_pengurangan;
                           $totalGrand += $total;
                        @endphp
                     @endif
                        
                     @endforeach
                     
                     
                     <tr>
                        <td colspan="3" class="text-end"><b> Total</b></td>
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
                        <td class="text-right text-truncate"><b>{{formatRupiahB($totalAdditionalPengurangan)}}</b></td>
                        
                        <td class="text-right text-truncate"><b>{{formatRupiahB($totalGrand)}}</b></td>
                     </tr>
                     
                     
                     
                  </tbody>
               </table>

               {{-- <table>
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
                           
                           <h3 ><i>Approved</i></h3>
                           @endif
                        </td>
                        <td colspan="" style="height: 80px" class="text-center">
                           @if ($manHrd)
                           <h3 ><i>Approved</i></h3>
                          
                           @endif
                        </td>
                        <td colspan="" style="height: 80px" class="text-center">
                           @if ($manFin)
                           <h3 ><i>Approved</i></h3>
                          
                           @endif
                        </td>
                        <td colspan="" style="height: 80px" class="text-center">
                           @if ($gm)
                           <h3 ><i>Approved</i></h3>
                          
                           @endif
                        </td>
                        <td colspan="" style="height: 80px" class="text-center">
                           @if ($bod)
                           <h3 ><i>Approved</i></h3>
                           
                           @endif
                        </td>
                     </tr>
                     <tr>
                        <td colspan="">
                           @if ($hrd)
                              {{$hrd->employee->biodata->fullName()}}
                           @endif
                           
                        </td>
                        <td>
                           Saruddin Batubara
                           
                        </td>
                        <td>
                           Andrianto
                          
                        </td>
                        <td>
                           Andi Kurniawan Nasution
                           
                           
                        </td>
                        <td>
                           @if ($unit->id == 2 || $unit->id == 3 || $unit->id == 6 || $unit->id == 23 || $unit->id == 24 || $unit->id == 5 || $unit->id == 22 || $unit->id == 11 || $unit->id == 12 || $unit->id == 15 || $unit->id == 19)
                           Indra Muhammad Anwar
                           @else
                           Wildan Muhammad Anwar
                           @endif
                           
                        </td>
                     </tr>
                     <tr>
                        <td>
                           @if ($hrd)
                           HRD Payroll 
                           {{formatDateTime($hrd->created_at)}} 
                           @endif
                           
                        </td>
                        <td>HRD Manager 
                           @if ($manHrd)
                          
                           {{formatDateTime($manHrd->created_at)}} 
                           @endif
                        </td>
                        <td>Manager Finance
                           @if ($manFin)
                           
                           {{formatDateTime($manFin->created_at)}} 
                           @endif
                        </td>
                        <td>GM Finance & Acc
                           @if ($gm)
                          
                           {{formatDateTime($gm->created_at)}} 
                           @endif
                        </td>
                        <td>Direktur
                           @if ($bod)
                           
                           {{formatDateTime($bod->created_at)}} 
                           @endif
                        </td>
                     </tr>
                  </tbody>
               </table> --}}
            
         </div>
         
      </div>
   </div>
</div>
@endsection