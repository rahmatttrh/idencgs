@extends('layouts.app-doc')
@section('title')
Cuti
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
      padding-top: 3px;
  padding-bottom: 3px;
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
                     <td class="text-center" colspan="4">
                        <h4>FORMULIR</h4>
                     </td>
                     <td class="text-center" colspan="2" rowspan="2">
                        <img src="{{asset('img/logo/ekanuri.png')}}" alt="" width="100"><br>
                        <span>PT Ekanuri</span>
                     </td>
                  </tr>
                  <tr class="text-center">
                     <td colspan="4"><h4>PERMOHONAN CUTI KARYAWAN</h4></td>
                  </tr>
                  <tr class="text-center">
                     <td colspan="2">No. Dok : FM.PS.HRD.32</td>
                     <td colspan="4">Rev: 00/22</td>
                     <td colspan="2">Hal : 1 dari 1</td>
                  </tr>
                  

                  <tr>
                     <td colspan="">Periode Hak Cuti</td>
                     <td colspan="7">{{formatYear($cuti->start)}} / {{formatYear($cuti->end)}}</td>
                  </tr>
                  <tr>
                     <td colspan="">Perusahaan</td>
                     <td colspan="7">{{$employee->unit->name}}</td>
                  </tr>
                  <tr>
                     <td colspan="">Nama</td>
                     <td colspan="7">{{$employee->biodata->fullName()}}</td>
                  </tr>
                  <tr>
                     <td colspan="">NIK</td>
                     <td colspan="7">{{$employee->nik}}</td>
                  </tr>
                  <tr>
                     <td colspan="">Jabatan/Dept</td>
                     <td colspan="7">{{$employee->position->name}}/{{$employee->department->name}}</td>
                  </tr>
                  <tr>
                     <td colspan="">Tanggal Masuk Kerja</td>
                     <td colspan="7">{{formatDate($employee->join)}}</td>
                  </tr>


                  <tr class="text-center">
                     <td>Jumlah Cuti yang sudah diambil</td>
                     <td>Lama Cuti yang akan diambil</td>
                     <td>Tanggal Mulai Cuti</td>
                     <td>sampai dengan</td>
                     <td>Sisa Cuti</td>
                     <td>Keperluan</td>
                     <td>Nama Karyawan Pengganti</td>
                     <td>Alamat/No. Telp 
                        yang dapat dihubungi</td>
                  </tr>

                  <tr class="text-center">
                     <td style="height: 40px">{{$cuti->used}}</td>
                     <td>{{$absenceEmp->cuti_qty}}</td>
                     <td>{{formatDate($absenceEmp->cuti_start)}}</td>
                     <td>{{formatDate($absenceEmp->cuti_end)}}</td>
                     <td>{{$cuti->sisa}}</td>
                     <td>{{$absenceEmp->desc}}</td>
                     <td>{{$absenceEmp->cuti_backup->biodata->fullName()}}</td>
                     <td>{{$absenceEmp->cuti_backup->biodata->phone}}</td>
                  </tr>

                  <tr>
                     <td class="bg-dark text-light text-truncate">Diajukan Oleh :</td>
                     <td class="bg-dark text-light text-truncate">Pengganti :</td>
                     <td class="bg-dark text-light text-truncate">Disetujui Oleh :</td>
                     <td class="bg-dark text-light text-truncate">Diketahui Oleh :</td>
                     <td colspan="4" >Masuk Kembali
                        
                     </td>
                  </tr>
                  <tr>
                     <td class="text-center" style="height: 70px">
                        @if ($absenceEmp->status >= 1)
                           <span class="text-success"><i>CREATED</i></span> <br>
                           {{-- <small>{{formatDateTime($absenceEmp->release_date)}}</small> --}}
                        @endif
                     </td>
                     <td class="text-center">
                        @if ($absenceEmp->status >= 2)
                           <span class="text-success"><i>APPROVED</i></span> <br>
                           {{-- <small>{{formatDateTime($absenceEmp->app_backup_date)}}</small> --}}
                        @endif
                     </td>
                     <td class="text-center">
                        @if ($absenceEmp->status >= 3)
                           <span class="text-success"><i>APPROVED</i></span><br>
                           {{-- <small>{{formatDateTime($absenceEmp->app_leader_date)}}</small> --}}
                        @endif
                     </td>
                     <td class="text-center">
                        @if ($absenceEmp->status == 5)
                           <span class="text-success"><i>VALIDATED</i></span>
                        @endif
                     </td>
                     <td colspan="4" rowspan="2">Catatan :</td>
                  </tr>
                  <tr>
                     <td>{{$absenceEmp->employee->biodata->fullName()}}</td>
                     <td>{{$absenceEmp->cuti_backup->biodata->fullName()}}</td>
                     <td>{{$absenceEmp->leader->biodata->fullName()}}</td>
                     <td>HRD</td>
                     {{-- <td colspan="4"></td> --}}
                  </tr>
                  <tr>
                     <td>
                        @if ($absenceEmp->status >= 1)
                           <small>{{formatDateTime($absenceEmp->release_date)}}</small>
                        @endif
                     </td>
                     <td>
                        @if ($absenceEmp->status >= 2)
                           <small>{{formatDateTime($absenceEmp->app_backup_date)}}</small>
                        @endif
                     </td>
                     <td>
                        @if ($absenceEmp->status >= 3)
                           <small>{{formatDateTime($absenceEmp->app_leader_date)}}</small>
                        @endif
                     </td>
                     <td>
                        @if ($absenceEmp->status == 5)
                        <small>{{formatDateTime($absenceEmp->app_hrd_date)}}</small>
                        @endif
                     </td>
                     <td colspan="4" class="text-end">Lembar 1 : HRD</td>
                  </tr>
                  

                  
               </tbody>
            </table>
            
            <table>
               <tbody>
                  <tr>
                     <td colspan="8"></td>
                  </tr>
                  <tr>
                     <td class="text-center" colspan="2" rowspan="2">
                        <img src="{{asset('img/logo/enc1.png')}}" alt="" width="100">
                     </td>
                     <td class="text-center" colspan="4">
                        <h4>FORMULIR</h4>
                     </td>
                     <td class="text-center" colspan="2" rowspan="2">
                        <img src="{{asset('img/logo/ekanuri.png')}}" alt="" width="100"><br>
                        <span>PT Ekanuri</span>
                     </td>
                  </tr>
                  <tr class="text-center">
                     <td colspan="4"><h4>PERMOHONAN CUTI KARYAWAN</h4></td>
                  </tr>
                  <tr class="text-center">
                     <td colspan="2">No. Dok : FM.PS.HRD.32</td>
                     <td colspan="4">Rev: 00/22</td>
                     <td colspan="2">Hal : 1 dari 1</td>
                  </tr>
                  

                  <tr>
                     <td colspan="">Periode Hak Cuti</td>
                     <td colspan="7">{{formatYear($cuti->start)}} / {{formatYear($cuti->end)}}</td>
                  </tr>
                  <tr>
                     <td colspan="">Perusahaan</td>
                     <td colspan="7">{{$employee->unit->name}}</td>
                  </tr>
                  <tr>
                     <td colspan="">Nama</td>
                     <td colspan="7">{{$employee->biodata->fullName()}}</td>
                  </tr>
                  <tr>
                     <td colspan="">NIK</td>
                     <td colspan="7">{{$employee->nik}}</td>
                  </tr>
                  <tr>
                     <td colspan="">Jabatan/Dept</td>
                     <td colspan="7">{{$employee->position->name}}/{{$employee->department->name}}</td>
                  </tr>
                  <tr>
                     <td colspan="">Tanggal Masuk Kerja</td>
                     <td colspan="7">{{formatDate($employee->join)}}</td>
                  </tr>


                  <tr class="text-center">
                     <td>Jumlah Cuti yang sudah diambil</td>
                     <td>Lama Cuti yang akan diambil</td>
                     <td>Tanggal Mulai Cuti</td>
                     <td>sampai dengan</td>
                     <td>Sisa Cuti</td>
                     <td>Keperluan</td>
                     <td>Nama Karyawan Pengganti</td>
                     <td>Alamat/No. Telp 
                        yang dapat dihubungi</td>
                  </tr>

                  <tr class="text-center">
                     <td style="height: 40px">{{$cuti->used}}</td>
                     <td>{{$absenceEmp->cuti_qty}}</td>
                     <td>{{formatDate($absenceEmp->cuti_start)}}</td>
                     <td>{{formatDate($absenceEmp->cuti_end)}}</td>
                     <td>{{$cuti->used}}</td>
                     <td>{{$absenceEmp->desc}}</td>
                     <td>{{$absenceEmp->cuti_backup->biodata->fullName()}}</td>
                     <td>{{$absenceEmp->cuti_backup->biodata->phone}}</td>
                  </tr>

                  <tr>
                     <td class="bg-dark text-light text-truncate">Diajukan Oleh :</td>
                     <td class="bg-dark text-light text-truncate">Pengganti :</td>
                     <td class="bg-dark text-light text-truncate">Disetujui Oleh :</td>
                     <td class="bg-dark text-light text-truncate">Diketahui Oleh :</td>
                     <td colspan="4">
                        Masuk Kembali 
                     </td>
                  </tr>
                  <tr>
                     <td class="text-center" style="height: 70px">
                        @if ($absenceEmp->status >= 1)
                           <span class="text-success"><i>CREATED</i></span> <br>
                           {{-- <small>{{formatDateTime($absenceEmp->release_date)}}</small> --}}
                        @endif
                     </td>
                     <td class="text-center">
                        @if ($absenceEmp->status >= 2)
                           <span class="text-success"><i>APPROVED</i></span> <br>
                           {{-- <small>{{formatDateTime($absenceEmp->app_backup_date)}}</small> --}}
                        @endif
                     </td>
                     <td class="text-center">
                        @if ($absenceEmp->status >= 3)
                           <span class="text-success"><i>APPROVED</i></span><br>
                           {{-- <small>{{formatDateTime($absenceEmp->app_leader_date)}}</small> --}}
                        @endif
                     </td>
                     <td class="text-center">
                        @if ($absenceEmp->status == 5)
                           <span class="text-success"><i>VALIDATED</i></span>
                        @endif
                     </td>
                     <td colspan="4" rowspan="2">Catatan :</td>
                  </tr>
                  <tr>
                     <td>{{$absenceEmp->employee->biodata->fullName()}}</td>
                     <td>{{$absenceEmp->cuti_backup->biodata->fullName()}}</td>
                     <td>{{$absenceEmp->leader->biodata->fullName()}}</td>
                     <td>HRD</td>
                     {{-- <td colspan="4"></td> --}}
                  </tr>
                  <tr>
                     <td>
                        @if ($absenceEmp->status >= 1)
                           <small>{{formatDateTime($absenceEmp->release_date)}}</small>
                        @endif
                     </td>
                     <td>
                        @if ($absenceEmp->status >= 2)
                           <small>{{formatDateTime($absenceEmp->app_backup_date)}}</small>
                        @endif
                     </td>
                     <td>
                        @if ($absenceEmp->status >= 3)
                           <small>{{formatDateTime($absenceEmp->app_leader_date)}}</small>
                        @endif
                     </td>
                     <td>
                        @if ($absenceEmp->status == 5)
                        <small>{{formatDateTime($absenceEmp->app_hrd_date)}}</small>
                        @endif
                     </td>
                     <td colspan="4" class="text-end">Lembar 2 : Karyawan</td>
                  </tr>
                  

                  
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection