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
         <h4><b>Approval Absensi</b></h4>
         <hr>
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{ route('leader.absence') }}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Request Absensi/Cuti
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{ route('leader.absence.history') }}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               History
            </a>
            
           
            
         </div>
         <hr>
         <small>
            <b>#INFO</b> <br>
            Daftar Form Request Absensi yang membutuhkan approval anda.
         </small>
         
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
         {{-- <div class="table-responsive ">
            <table id="data" class="">
               <thead>
                  <tr>
                     <th>Type</th>
                     <th>NIK</th>
                     <th>Name</th>
                     <th>Date</th>
                     <th>Desc</th>
                     <th>Status</th>
                  </tr>
               </thead>

               <tbody>
                  @if (count($reqForms) + count($reqBackForms) > 0)
                        @foreach ($reqForms as $absence)
                        <tr>
                           <td>
                              <a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}">
                              @if ($absence->status == 404)
                                 <span class="text-danger">Permintaan Perubahan</span>
                                 @else
                                 @if ($absence->type == 1)
                                 Alpha
                                 @elseif($absence->type == 2)
                                 Terlambat ({{$absence->minute}} Menit)
                                 @elseif($absence->type == 3)
                                 ATL
                                 @elseif($absence->type == 4)
                                 Izin ({{$absence->type_izin}})
                                 @elseif($absence->type == 5)
                                 Cuti
                                 @elseif($absence->type == 6)
                                 SPT
                                 @elseif($absence->type == 7)
                                 Sakit 
                                 @elseif($absence->type == 8)
                                 Dinas Luar
                                 @elseif($absence->type == 9)
                                 Off Kontrak
                                 @endif
                              @endif
                           </a>
                              
                           </td>
                           <td><a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}"> {{$absence->employee->nik}}</a></td>
                           <td> {{$absence->employee->biodata->fullName()}}</td>
                           <td>{{formatDate($absence->date)}}</td>
                           <td>{{$absence->desc}}</td>
                           <td>
                              <x-status.form :form="$absence" />
                              
                           </td>
                          
                        </tr>
                        @endforeach
                        @foreach ($reqBackForms as $absence)
                           <tr>
                              <td>
                                 <a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}">
                                    <x-absence.type :absence="$absence" />
                                 </a>
                                 
                              </td>
                              <td><a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}"> {{$absence->employee->nik}}</a></td>
                              <td> {{$absence->employee->biodata->fullName()}}</td>
                              <td>{{formatDate($absence->date)}}</td>
                              <td>{{$absence->desc}}</td>
                              <td>
                                 <x-status.form :form="$absence" />
                                 
                              </td>
                           
                           </tr>

                           
                           @endforeach
                      @else
                      <tr>
                        <td colspan="7" class="text-center">Tidak ada Pengajuan</td>
                      </tr>
                  @endif
                  

                  
               </tbody>

            </table>
         </div>
         <hr> --}}
         <div class="table-responsive ">
            <table id="data" class="">
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
                     <th></th>
                  </tr>
               </thead>

               <tbody>

                  {{-- @foreach ($myteams as $team) --}}
                     @foreach ($allReqForms as $absence)
                        {{-- @if ($absence->employee_id == $team->id) --}}

                        <tr>
                           <td><a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}">{{$absence->code}}</a></td>
                           <td>
                              <a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}">
                                 <x-status.absence :absence="$absence" />
                           </a>
                              
                           </td>
                           <td><a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}"> {{$absence->employee->nik}}</a></td>
                           <td> {{$absence->employee->biodata->fullName()}}</td>
                           {{-- <td>{{$absence->employee->location->name}}</td> --}}
                           
                           {{-- <td>{{formatDayName($absence->date)}}</td> --}}
                           <td>
                              @if ($absence->type == 5 || $absence->type == 10)
                        
                                 @if (count($absence->details) > 0)
                                    {{count($absence->details)}} Hari
                                       {{-- @foreach ($absence->details  as $item)
                                          {{formatDate($item->date)}} -
                                       @endforeach --}}
                                    @else
                                    Tanggal belum dipilih
                                 @endif
                                    
                                    @else
                                    {{formatDate($absence->date)}}
                              @endif
                           </td>
                           {{-- <td>{{$absence->desc}}</td> --}}
                           <td>
                              <x-status.form :form="$absence" />
                              
                           </td>
                           <td>
                              {{$absence->updated_at}}
                           </td>
                        
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