@extends('layouts.app')
@section('title')
Form Absensi
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item " aria-current="page">Sumamry</li>
         <li class="breadcrumb-item active" aria-current="page">Absensi Tim</li>
      </ol>
   </nav>


   <div class="row">
      <div class="col-md-3">
         {{-- <h4>|  <b>Monitoring Absensi</b></h4>
         <hr> --}}
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            {{-- <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{ route('leader.absence') }}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Form Absensi Tim
            </a> --}}
            <a class="nav-link  text-left pl-3" id="v-pills-basic-tab" href="{{route('overtime.team')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               SPKL Tim
            </a>
            <a class="nav-link active  text-left pl-3" id="v-pills-contract-tab" href="{{route('absence.team')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Absensi Tim
            </a>
            
            
           
            
         </div>
         <hr>
         <div class="card">
            <div class="card-body">
               <small>
                  <b>#INFO</b> <br>
                  Daftar Form Request Absensi yang yang dibuat tim anda.
               </small>
            </div>
         </div>
         
         
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
        
         <div class="table-responsive p-0 mt-2">
            <table id="data" class="display basic-datatables table-sm p-0">
               <thead>
                  <tr>
                     <th>ID</th>
                     <th>Type</th>
                     {{-- <th>NIK</th> --}}
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

                  {{-- @foreach ($myteams as $team) --}}
                     @foreach ($formAbsences as $absence)
                        {{-- @if ($absence->employee_id == $team->id) --}}

                        <tr>
                           <td>
                              <a href="{{route('employee.absence.detail', [enkripRambo($absence->id), enkripRambo('monitoring')])}}">{{$absence->code ?? $absence->employee->nik }}
                                 </a></td>
                           <td>
                              <a href="{{route('employee.absence.detail',  [enkripRambo($absence->id), enkripRambo('monitoring')])}}">
                                 <x-status.absence :absence="$absence" />
                           </a>
                              
                           </td>
                           {{-- <td><a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}"> {{$absence->employee->nik}}</a></td> --}}
                           <td> {{$absence->employee->biodata->fullName()}}</td>
                           {{-- <td>{{$absence->employee->location->name}}</td> --}}
                           
                           {{-- <td>{{formatDayName($absence->date)}}</td> --}}
                           <td class="truncate">
                              <x-absence.date :absence="$absence" />  
                           </td>
                           {{-- <td>{{$absence->desc}}</td> --}}
                           <td>
                              <x-status.form :form="$absence" />
                              
                           </td>
                           {{-- <td>
                              {{$absence->release_date}}
                           </td> --}}
                        
                        </tr>
                        {{-- @endif --}}
                     @endforeach
                  
    
                  
               </tbody>

            </table>
         </div>
      </div>
   </div>

   


</div>




@endsection