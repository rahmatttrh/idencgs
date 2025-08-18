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
         <table id="data" class="display basic-datatables table-sm p-0">
            <thead>
               <tr>
                  <th>NIK</th>
                  <th>Name</th>
                  {{-- <th>Location</th> --}}
                  {{-- <th>Unit</th> --}}
                  <th class="text-center">Alpha</th>
                  <th class="text-center">Terlambat</th>
                  <th class="text-center">ATL</th>
                  <th class="text-center">Izin</th>
                  <th class="text-center">Cuti</th>
                  <th class="text-center">Sakit</th>
                  {{-- <th class="text-right">Rate</th> --}}
               </tr>
            </thead>

            <tbody>

               @if (count($employee->positions) > 0)
                     @foreach ($employee->positions as $pos)
                           
                           @foreach ($pos->department->employees->where('status', 1) as $emp)
                           <tr>
                              <td class="text-truncate">{{$emp->nik}}</td>
                              <td class="text-truncate" style="max-width: 140px"> 
                                 <a href="{{route('payroll.absence.employee.detail', [enkripRambo($emp->id), $from, $to])}}">{{$emp->biodata->fullName()}}</a>
                              </td>
                              {{-- <td>{{$emp->location->name ?? '-'}}</td> --}}
                              {{-- <td class="text-truncate" style="max-width: 100px">{{$emp->unit->name}}</td> --}}
                              {{-- <td>{{$emp->department->name}}</td> --}}
                              <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 1))}}</td>
                              <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 2))}}</td>
                              <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 3))}}</td>
                              <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 4))}}</td>
                              <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 5))}}</td>
                              <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 7))}}</td>
                              {{-- <td class="text-right">{{formatRupiahB($emp->getOvertimes($from, $to)->sum('rate'))}}</td> --}}
                            </tr>
                           @endforeach
                     @endforeach
                   @else
                   @foreach ($employees as $emp)
                        @php
                              $bio = DB::table('biodatas')->where('id', $emp->biodata_id)->first();
                        @endphp
                        <tr>
                           <td class="text-truncate">{{$emp->nik}}</td>
                           <td class="text-truncate" style="max-width: 140px"> 
                              <a href="{{route('payroll.absence.employee.detail', [enkripRambo($emp->id), $from, $to])}}">{{$emp->biodata->fullName()}}</a>
                           </td>
                           {{-- <td>{{$emp->location->name ?? '-'}}</td> --}}
                           {{-- <td class="text-truncate" style="max-width: 100px">{{$emp->unit->name}}</td> --}}
                           {{-- <td>{{$emp->department->name}}</td> --}}
                           <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 1))}}</td>
                           <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 2))}}</td>
                           <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 3))}}</td>
                           <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 4))}}</td>
                           <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 5))}}</td>
                           <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 7))}}</td>
                           {{-- <td class="text-right">{{formatRupiahB($emp->getOvertimes($from, $to)->sum('rate'))}}</td> --}}
                         </tr>
                     @endforeach
               @endif


               {{-- @foreach ($absences as $absence)
               <tr>
                  <td>{{$absence->employee->nik}}</td>
                   <td> {{$absence->employee->biodata->fullName()}}</td>
                   <td>{{$absence->employee->location->name}}</td>
                  <td>
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
                        SPT ({{$absence->type_spt}})
                        @elseif($absence->type == 7)
                        Sakit 
                        @elseif($absence->type == 8)
                        Dinas Luar
                        @elseif($absence->type == 9)
                        Off Kontrak
                        @endif
                     @endif
                     
                  </td>
                  <td>{{formatDayName($absence->date)}}</td>
                  <td>{{formatDate($absence->date)}}</td>
                  <td>{{$absence->desc}}</td>
                 
               </tr>

               <div class="modal fade" id="modal-delete-absence-{{$absence->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-sm" role="document">
                     <div class="modal-content text-dark">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body ">
                           Delete data
                           @if ($absence->type == 1)
                           Alpha
                           @elseif($absence->type == 2)
                           Terlambat ({{$absence->minute}})
                           @elseif($absence->type == 3)
                           ATL
                           @endif
                           {{$absence->employee->nik}} {{$absence->employee->biodata->fullName()}}
                           tanggal {{formatDate($absence->date)}}
                           ?
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                           <button type="button" class="btn btn-danger ">
                              <a class="text-light" href="{{route('payroll.absence.delete', enkripRambo($absence->id))}}">Delete</a>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
               @endforeach --}}
            </tbody>

         </table>
        
         <div class="table-responsive p-0 mt-2">
            <table id="data" class="display datatables-3 table-sm p-0">
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