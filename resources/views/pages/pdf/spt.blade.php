@extends('layouts.app-doc')
@section('title')
SPT
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
</style>

<div class="container-xl">
   <!-- Page title -->
   {{-- <div class="page-header d-print-none">
      <div class="row align-items-center">
         <div class="col">
            <h2 class="page-title">
               Preview PE
            </h2>
         </div>
         <div class="col-auto ms-auto d-print-none">
            <button type="button" class="btn btn-light" onclick="javascript:window.print();">
               <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                  <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                  <rect x="7" y="13" width="10" height="8" rx="2" />
               </svg>
               Print
            </button>
         </div>
      </div>
   </div> --}}
</div>
<div class="page-body">
   <div class="container-xl">
      <div class="card card-lg">
         <div class="card-body">
            <table>
               <tbody>
                  <tr>
                     <td class="text-center" colspan="2" rowspan="2">
                        <img src="{{asset('img/logo/enc1.png')}}" alt="" width="100">
                     </td>
                     <td class="text-center" colspan="2">
                        <h4>FORMULIR</h4>
                     </td>
                     <td class="text-center" colspan="2" rowspan="2">
                        <img src="{{asset('img/logo/ekanuri.png')}}" alt="" width="100"><br>
                        <span>PT Ekanuri</span>
                     </td>
                  </tr>
                  <tr class="text-center">
                     <td><h4>SURAT PERINTAH TUGAS</h4></td>
                  </tr>
                  <tr class="text-center">
                     <td colspan="2">No. Dok : FM.PS.HRD.19</td>
                     <td colspan="2">Rev: 01/22</td>
                     <td colspan="2">Hal : 1 dari 1</td>
                  </tr>
                  <tr class="text-center">
                     <td colspan="6">Nomor : ……../HRD/SPT/…../20…</td>
                  </tr>



                  {{-- Body --}}
                  <tr>
                     <td colspan="6"><b>1. Pemberi Perintah</b></td>
                  </tr>
                  <tr>
                     <td style="width: 20px"></td>
                     <td colspan="1">Nama</td>
                     <td colspan="4" class="">{{$absenceEmp->leader->biodata->fullName()}}</td>
                  </tr>
                  <tr>
                     <td style="width: 20px"></td>
                     <td colspan="1">Jabatan</td>
                     <td colspan="4" class="">{{$absenceEmp->leader->position->name}}</td>
                  </tr>
                 

                  <tr>
                     <td colspan="6"><b>2. Karyawan yang diperintahkan</b></td>
                  </tr>
                  <tr>
                     <td style="width: 20px"></td>
                     <td colspan="1" style="width: 250px">Nama</td>
                     <td colspan="4" class="">{{$absenceEmp->employee->biodata->fullName()}}</td>
                  </tr>
                  <tr>
                     <td style="width: 20px"></td>
                     <td colspan="1">NIK</td>
                     <td colspan="4" class="">{{$absenceEmp->employee->nik}}</td>
                  </tr>
                  <tr>
                     <td style="width: 20px"></td>
                     <td colspan="1">Departemen</td>
                     <td colspan="4" class="">{{$absenceEmp->employee->department->name}}</td>
                  </tr>
                  <tr>
                     <td style="width: 20px"></td>
                     <td colspan="1">Jabatan</td>
                     <td colspan="4" class="">{{$absenceEmp->employee->position->name}}</td>
                  </tr>
                 
                  <tr>
                     <td colspan="2"><b>3. Maksud Perintah Tugas</b></td>
                     <td colspan="4" class="">
                        <textarea  name="" id="" style="width: 100%" rows="3" readonly>{{$absenceEmp->desc}}</textarea>
                        
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2"><b>4. Alat angkutan yang di pergunakan</b></td>
                     <td colspan="4" class="">
                        <span>{{$absenceEmp->transport}}</span>
                        {{-- <textarea  name="" id="" style="width: 100%" rows="3" readonly>{{$absenceEmp->desc}}</textarea> --}}
                        
                     </td>
                  </tr>
                  
                  <tr>
                     <td colspan="2"><b>4. Tempat Tujuan</b></td>
                     <td colspan="4" class="">
                        <span>{{$absenceEmp->destination}}</span>
                        {{-- <textarea  name="" id="" style="width: 100%" rows="3" readonly>{{$absenceEmp->desc}}</textarea> --}}
                        
                     </td>
                  </tr>
                  <tr>
                     <td style="width: 20px"></td>
                     <td colspan="1">Berangkat dari</td>
                     <td colspan="4" class="">{{$absenceEmp->from}}</td>
                  </tr>
                  <tr>
                     <td style="width: 20px"></td>
                     <td colspan="1">Tempat transit</td>
                     <td colspan="4" class="">{{$absenceEmp->transit}}</td>
                  </tr>
                  <tr>
                     <td style="width: 20px"></td>
                     <td colspan="1">Lama tugas</td>
                     <td colspan="4" class="">{{$absenceEmp->duration}}</td>
                  </tr>
                  <tr>
                     <td style="width: 20px"></td>
                     <td colspan="1">Tanggal/Jam Berangkat</td>
                     <td colspan="4" class="">{{formatDateTime($absenceEmp->departure)}}</td>
                  </tr>
                  <tr>
                     <td style="width: 20px"></td>
                     <td colspan="1">Tanggal/Jam Kembali</td>
                     <td colspan="4" class="">{{formatDateTime($absenceEmp->return)}}</td>
                  </tr>
                  <tr>
                     <td colspan="2"><b>5. Keterangan</b></td>
                     <td colspan="4" class="">
                        <textarea  name="" id="" style="width: 100%" rows="3" readonly>{{$absenceEmp->remark}}</textarea>
                        
                     </td>
                  </tr>
                  <tr>
                     <td colspan="6" class="text-center text-dark" style="background-color: rgb(167, 164, 164)" ><h4>Surat Perintah Tugas ini berlaku selama yang bersangkutan menjadi karyawan  PT. EKA NURI.</h4></td>
                  </tr>



                  <tr>
                     <td colspan="6">Jakarta, {{formatDate($absenceEmp->date)}}</td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <table>
                           <tbody>
                              <tr class="bg-dark text-light">
                                 <td>Pemberi Perintah</td>
                              </tr>
                              <tr>
                                 <td style="height: 100px" class="text-center">
                                    @if ($absenceEmp->status >= 3)
                                        <i class="text-success">APPROVED</i>
                                    @endif
                                 </td>
                              </tr>
                              <tr>
                                 <td>
                                 Nama : {{$absenceEmp->leader->biodata->fullName()}}
                              </td>
                              </tr>
                           </tbody>
                        </table>
                        {{-- <div class="card">
                           <div class="card-header bg-dark text-light"></div>
                           <div class="card-body" style="height: 100px">

                           </div>
                           <div class="card-footer">
                              Nama : {{$absenceEmp->leader->biodata->fullName()}}
                           </div>
                        </div> --}}
                     </td>
                  </tr>
                  <tr>
                     <td colspan="6">Tembusan : <br>
                     - <br>
                     -
                     </td>
                  </tr>
                  

                  
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection