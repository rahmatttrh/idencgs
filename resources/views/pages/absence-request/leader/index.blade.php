@extends('layouts.app')
@section('title')
Form Absensi
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">Form Absensi</li>
      </ol>
   </nav>


   <div class="row">
      <div class="col-md-3">
         {{-- <h4><b>Approval Absensi</b></h4>
         <hr> --}}
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{ route('leader.absence') }}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Pengajuan Absensi
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{ route('leader.absence.history') }}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               History
            </a>
            
           
            
         </div>
         <hr>

         <div class="card">
            <div class="card-body">
               <small>Daftar Form Request Absensi yang membutuhkan approval anda.</small>
            </div>
         </div>
         {{-- <small>
            <b>#INFO</b> <br>
            
         </small> --}}
         
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
        
         <div class="table-responsive ">
            <table id="data" class="datatables-4">
               <thead>
                  <tr>
                     <th>IDDD</th>
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

                  {{-- @foreach ($myteams as $team) --}}
                     @foreach ($allReqForms as $absence)
                        {{-- @if ($absence->employee_id == $team->id) --}}

                        <tr>
                           <td><a href="{{route('employee.absence.detail', [enkripRambo($absence->id), enkripRambo('approval')])}}">{{$absence->code}}</a></td>
                           <td class="text-truncate">
                              <a href="{{route('employee.absence.detail', [enkripRambo($absence->id), enkripRambo('approval')])}}">
                                 <x-status.absence :absence="$absence" />
                                 @if (count($absence->details) > 1)
                                 ({{count($absence->details)}} hari)
                              @endif
                           </a>
                              
                           </td>
                           <td class="text-truncate">{{$absence->employee->nik}}</td>
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
                           {{-- <td>
                              {{$absence->release_date}}
                           </td> --}}
                        
                        </tr>
                        {{-- @endif --}}
                     @endforeach
                  
                  {{-- @endforeach --}}

                  {{-- @foreach ($reqBackForms as $absence)
                        
                        <tr>
                           <td>
                              <a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}">
                                 <x-status.absence :absence="$absence" />
                           </a>
                              
                           </td>
                           <td><a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}"> {{$absence->employee->nik}}</a></td>
                           <td> {{$absence->employee->biodata->fullName()}}</td>
                           <td>{{formatDate($absence->date)}}</td>
                           <td>
                              <x-status.form :form="$absence" />
                              
                           </td>
                           <td>
                              {{$absence->created_at}}
                           </td>
                        
                        </tr>
                        
                     @endforeach --}}


                  
                  

                  
               </tbody>

            </table>
         </div>
      </div>
   </div>



  

   


</div>




@endsection