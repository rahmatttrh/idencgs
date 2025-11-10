@extends('layouts.app-doc')
@section('title')
Summary QPE
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
            <h1>QPE REPORT</h1>
            <span>Semester {{$semester}} / {{$year}}</span>


            <table class="mt-2">
               
            </table>
            <br>
            <table>
               <tbody>
                  <tr>
                     <th class="text-center ">NIK</th>
                     <th class="text-center ">Karyawan</th>
                     <th class="text-center ">Discipline</th>
                     <th class="text-center ">KPI</th>
                     <th class="text-center ">Behavior</th>
                     <th class="text-center ">Achievement</th>
                  </tr>

                  @foreach ($pes as $pe)
                      <tr>
                        <td>{{$pe->employe->nik}}</td>
                        <td>{{$pe->employe->biodata->fullName()}}</td>
                        <td class="text-center">{{$pe->discipline}}</td>
                        <td class="text-center">{{$pe->kpi}}</td>
                        <td class="text-center">{{$pe->behavior}}</td>
                        <td class="text-center"><b>{{$pe->achievement}}</b></td>
                      </tr>
                  @endforeach
                  
               </tbody>
            </table>
         </div>
         
      </div>
   </div>
</div>
@endsection