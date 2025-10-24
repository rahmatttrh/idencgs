@extends('layouts.app-doc')
@section('title')
Payslip Report 
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
                           {{-- <h5>LOKASI</h5> --}}
                        </td>
                        <td class="text-center" colspan="2">
                           
                           
                        </td>
                     </tr>
                  </tbody>
               </table>
               <table>
                  <tbody>
                     
                     
                     <tr>
                        <td class="px-1 py-1" style="font-size: 10px; width: 90px">Unit</td>
                        <th colspan="17" class="px-1 py-1" style="font-size: 10px">All</th>
                     </tr>
                     <tr>
                        <td class="px-1 py-1" style="font-size: 10px">Lokasi</td>
                        <th colspan="17" class="px-1 py-1" style="font-size: 10px">All</th>
                     </tr>

                     
                     <tr>
                        <td class="px-1 py-1" style="font-size: 10px">Bulan</td>
                        <th colspan="17" class="px-1 py-1" style="font-size: 10px">Oktober</th>
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
                     
                  </tbody>
                  
               </table>

               <table id="data" class="display  table-sm">
                  <thead >
                     
                     <tr>
                        <th style="font-size: 8px" class="">NIK</th>
                        <th style="font-size: 8px" class="">Name</th>
                        
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
                     
                     
                     {{-- <tr>
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
                        <td class="text-right text-truncate"><b>{{formatRupiahB($totalJp)}}</b></td>
                        <td class="text-right text-truncate"><b>{{formatRupiahB($totalAbsence)}}</b></td>
                        <td class="text-right text-truncate"><b>{{formatRupiahB($totalLate)}}</b></td>
                        <td class="text-right text-truncate"><b>{{formatRupiahB($totalAdditionalPengurangan)}}</b></td>
                        
                        <td class="text-right text-truncate"><b>{{formatRupiahB($totalGrand)}}</b></td>
                     </tr> --}}
                     
                     
                     
                  </tbody>
               </table>

               
            {{-- </div> --}}
         </div>
         
      </div>
   </div>
</div>
@endsection