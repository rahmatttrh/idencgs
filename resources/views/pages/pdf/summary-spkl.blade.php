@extends('layouts.app-doc')
@section('title')
Summary SPKL
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
         {{-- <div class="card-footer d-print-none">
            <small>*Disarankan merubah layout ke mode <b>landscape</b> setelah klik tombol 'Print' untuk hasil yang lebih baik.</small>
         </div> --}}
         <div class="card-header">
            <h4>{{$start->format('MY')}}</h4>
         </div>
         <div class="card-body p-0">
           
            <table>
               <thead>
                  <tr>
                     {{-- <th>NIK</th> --}}
                     <th>Name</th>
                     @foreach ($dates as $date)
                         <th>{{$date->format('d')}}</th>
                     @endforeach
                  </tr>
               </thead>
               <tbody>
                  @foreach ($employees as $emp)
                      <tr>
                        {{-- <td></td> --}}
                        <td>
                           {{$emp->biodata->fullName()}} <br>
                           {{$emp->nik}}
                        </td>
                        @foreach ($dates as $date)
                           @if ($emp->getSpklDate($date->format('Y-m-d')) != null )
                              <td>
                                 L :{{$emp->getSpklDate($date->format('Y-m-d'))->where('type', 1)->sum('hours_final')}}
                                 P : {{$emp->getSpklDate($date->format('Y-m-d'))->where('type', 2)->sum('hours_final')}}
                                 {{-- @foreach ($emp->getSpklDate($date->format('Y-m-d'))->where('type', 1) as $over)
                                     {{$over->hours_final}}
                                 @endforeach --}}
                              </td>
                               @else
                               <td>-</td>
                           @endif
                           
                        @endforeach
                      </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
         
      </div>
   </div>
</div>
@endsection