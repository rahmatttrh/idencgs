@extends('layouts.app-doc')
@section('title')
Summary Absence
@endsection
@section('content')

<style>
   html {
      -webkit-print-color-adjust: exact;
   }

   table,
   th,
   td {
      
      /* border: 1px solid black;
      border-collapse: collapse; */
   }

   .ttd {
      font-size: 10px;
   }

   table td {
      /* font-size: 10px; */
      padding-top: 5px;
      padding-bottom: 5px;
      padding-left: 5px;
      padding-right: 5px;
      border: 1px solid rgb(180, 173, 173);
   }

   table th {
      /* font-size: 10px; */
      padding-top: 5px;
      padding-bottom: 5px;
      padding-left: 5px;
      padding-right: 5px;
      background-color: rgb(200, 200, 202);
      border: 1px solid rgb(180, 173, 173);
   }



   table {
      width: 100%;
      border: 1px solid rgb(180, 173, 173);
   }


   .border-none {
      border: none;
   }

   /* table td {
      font-size: 8px;
   } */
</style>


<div class="page-body">
   <div class="container-xl">
      <div class="card card-lg">
         {{-- <div class="card-footer d-print-none">
            <small>*Disarankan merubah layout ke mode <b>landscape</b> setelah klik tombol 'Print' untuk hasil yang lebih baik.</small>
         </div> --}}
         <div class="card-body">
            <h1>SUMMARY REPORT ABSENSI</h1>
            <span>Periode {{formatDateB($from)}} - {{formatDateB($to)}}</span>


            <table class="mt-2">
               <tbody>
                  <tr>
                     <td style="width: 100px">Nama</td>
                     <td>{{$employee->biodata->fullName()}}</td>
                  </tr>
                  <tr>
                     <td >NIK</td>
                     <td>{{$employee->nik}}</td>
                  </tr>
                  <tr>
                     <td >Divisi</td>
                     <td>{{$employee->contract->department->name}}</td>
                  </tr>
                  <tr>
                     <td >Jabatan</td>
                     <td>{{$employee->contract->position->name}}</td>
                  </tr>
                  <tr>
                     <td >Lokasi</td>
                     <td>{{$employee->location->name}}</td>
                  </tr>
               </tbody>
            </table>
            <br>
            <table>
               <tbody>
                  <tr>
                     <th class="text-center ">T</th>
                     <th class="text-center ">ATL</th>
                     <th class="text-center ">I</th>
                     <th class="text-center ">S</th>
                     <th class="text-center ">A</th>
                     <th class="text-center ">C</th>
                  </tr>
                  <tr>
                     <td class="text-center">
                        @if (count($absences->where('type', 2)) > 0)
                        {{count($absences->where('type', 2))}}
                        @else
                        0
                        @endif
                     </td>

                     <td class="text-center py-2">
                        @if (count($absences->where('type', 3)) > 0)
                        {{count($absences->where('type', 3))}}
                        @else
                        0
                        @endif
                     </td>
                     <td class="text-center">
                        @if (count($absences->where('type', 4)) > 0)
                           {{count($absences->where('type', 4))}}
                           @else
                           0
                        @endif
                     </td>
                     <td class="text-center">
                        @if (count($absences->where('type', 7)) > 0)
                        {{count($absences->where('type', 7))}}
                        @else
                        0
                        @endif
                     </td>
                     <td class="text-center">
                        @if (count($absences->where('type', 1)) > 0)
                        {{count($absences->where('type', 1))}}
                        @else
                        0
                        @endif
                     </td>
                     <td class="text-center">
                        @if (count($absences->where('type', 5)) > 0)
                        {{count($absences->where('type', 5))}}
                        @else
                        0
                        @endif
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
         
      </div>
   </div>
</div>
@endsection