@extends('layouts.app-doc')
@section('title')
PDF Example
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
      /* padding-top: 5px;
  padding-bottom: 5px; */
      padding-left: 5px;
      padding-right: 5px;
   }

   table th {
      font-size: 10px;
      /* padding-top: 5px;
      padding-bottom: 5px; */
      padding-left: 5px;
      padding-right: 5px;
      background-color: rgb(88, 88, 88);
      color: white;
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
         <!-- Page title actions -->
         <div class="col-auto ms-auto d-print-none">
            <button type="button" class="btn btn-light" onclick="javascript:window.print();">
               <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
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
         {{-- <div class="card-header">
            <h2>QPE LIST</h2>
         </div> --}}
         <div class="card-body p-2">
            <h2>{{$title}}</h2>
            
            <table>
               <thead>
                  <tr>
                      {{-- <th class="text-white text-center" style="width: 20px">No </th> --}}
                      {{-- @if (auth()->user()->hasRole('Administrator'))
                         <th>ID</th>
                         @endif --}}
                      <th>NIK</th>
                      <th class="text-white">Employe</th>
                      <th class="text-white">Level</th>
                      <th class="text-white">Semester</th>
                      <th class="text-white text-center">Dis</th>
                      <th class="text-white text-center">KPI</th>
                      <th class="text-white text-center">Behav</th>
                      
                      <th class="text-white text-center">Achieve</th>
                      <th class="text-white">Status</th>
                      {{-- <th class="text-right text-white"></th> --}}
                      {{-- <th></th> --}}
                  </tr>
              </thead>
              <tbody>
                @foreach ($pes->sortByDesc('updated_at') as $pe)
                   <tr>
                      {{-- <td class="text-center text-truncate">{{++$i}} 
                         @if (auth()->user()->hasRole('Administrator'))
                         -
                            {{$pe->id}} 
                         
                         @endif   
                      </td> --}}
                     
                         {{-- @if (auth()->user()->hasRole('Administrator'))
                         <td>
                            {{$pe->id}} 
                         </td>
                         @endif --}}
                      
                      <td class="text-truncate" >
                         @if($pe->status == '0' || $pe->status == '101')
                         <a href="/qpe/edit/{{enkripRambo($pe->kpa->id)}}">{{$pe->employe->nik}}  </a>
                         @elseif($pe->status == '1' || $pe->status == '202' )
                         <a href="/qpe/approval/{{enkripRambo($pe->kpa->id)}}">{{$pe->employe->nik}}  </a>
                         @else
                         <a href="/qpe/show/{{enkripRambo($pe->kpa->id)}}">{{$pe->employe->nik}}  </a>
                         @endif
                      </td>
                      <td class="text-truncate" style="max-width: 100px">
                         @if($pe->status == '0' || $pe->status == '101')
                         <a href="/qpe/edit/{{enkripRambo($pe->kpa->id)}}">{{$pe->employe->biodata->fullName()}} </a>
                         @elseif($pe->status == '1' || $pe->status == '202' )
                         <a href="/qpe/approval/{{enkripRambo($pe->kpa->id)}}">{{$pe->employe->biodata->fullName()}} </a>
                         @else
                         <a href="/qpe/show/{{enkripRambo($pe->kpa->id)}}">{{$pe->employe->biodata->fullName()}} </a>
                         @endif
                      </td>
                      <td class="text-truncate" style="max-width: 60px">{{$pe->employe->designation->name}}</td>
                      <td>{{$pe->semester}} / {{$pe->tahun}}</td>
                      <td class="text-center">
                         <span class="">{{$pe->discipline}}</span>
                      </td>
                      <td class="text-center">
                         <span class="">{{$pe->kpi}}</span>
                      </td>
                      <td class="text-center">
                         <span class="">{{$pe->behavior}}</span>
                      </td>
                      
                      <td class="text-center">
                         {{-- <span class="badge badge-primary badge-lg"><b>{{$pe->achievement}}</b></span> --}}
                         <span class="">{{$pe->achievement}}</span>
                      </td>
                      <td>
                         <x-status.qpe-plain :pe="$pe" />
                      </td>
                     
                      
                      {{-- <td>
                         <a href="#"  data-toggle="modal" data-target="#modal-delete-{{$pe->id}}"> Delete</a>
                      </td> --}}
                   </tr>
                   
                @endforeach
              </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection