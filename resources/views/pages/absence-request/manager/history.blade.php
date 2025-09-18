@extends('layouts.app')
@section('title')
History Formulir Pengajuan
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">History Formulir Pengajuan</li>
      </ol>
   </nav>
   <div class="card">
      <div class="card-body px-0">
         <ul class="nav nav-tabs px-3">
            <li class="nav-item">
              <a class="nav-link " href="{{ route('leader.absence') }}">Approval Absensi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="{{ route('leader.absence.history') }}">Riwayat</a>
            </li>

         </ul>



         <div class="table-responsive  mt-2 px-0">
            <table id="data" class="datatables-3">
               <thead>
                  <tr>
                     <th>ID</th>
                     <th>Type</th>
                     <th>NIK</th>
                      <th>Name</th>
                      {{-- <th>Loc</th> --}}
                     
                     {{-- <th>Day</th> --}}
                     <th>Date</th>
                     {{-- <th>Desc</th> --}}
                     <th>Status</th>
                     {{-- <th></th> --}}
                  </tr>
               </thead>

               <tbody>
                  @foreach ($reqForms as $absence)
                                    
                     <tr>
                        <td>
                           <a href="{{route('employee.absence.detail', [enkripRambo($absence->id), enkripRambo('history')])}}">
                              {{$absence->code}}
                           </a>
                           
                        </td>
                        <td class="text-truncate">
                           <a href="{{route('employee.absence.detail', [enkripRambo($absence->id), enkripRambo('history')])}}">
                              <x-status.absence :absence="$absence" />
                           </a>
                           
                        </td>
                        <td class="text-truncate"><a href="{{route('employee.absence.detail', [enkripRambo($absence->id), enkripRambo('history')])}}"> {{$absence->employee->nik}}</a></td>
                        <td class="text-truncate"> {{$absence->employee->biodata->fullName()}}</td>
                        {{-- <td>{{$absence->employee->location->name}}</td> --}}
                        
                        {{-- <td>{{formatDayName($absence->date)}}</td> --}}
                        <td class="text-truncate">
                           <x-absence.date :absence="$absence" />
                        </td>
                        {{-- <td>{{$absence->desc}}</td> --}}
                        <td class="text-truncate">
                           <x-status.form :form="$absence" />
                           
                        </td>
                     
                     </tr>
                  @endforeach
                  
                  
                  
               </tbody>

            </table>
         </div>





      </div>
   </div>


   


</div>




@endsection