@extends('layouts.app')
@section('title')
Dashboard
@endsection
@section('content')

<style>
   table th {
      background-color: white;
      color: rgb(78, 77, 77);
   }
</style>

<div class="page-inner mt--5">
   <div class="page-header">
      <h5 class="page-title text-info d-flex">
         <div class="mr-2">
            <img src="{{asset('img/flaticon/hello.png')}}" alt="" width="30px">
         </div>
         <div >
            Welcome back, {{auth()->user()->getGender()}} {{auth()->user()->name}}
         </div>
         
         
      </h5>
   </div>
   <div class="row">
      <div class="col-md-3">
         {{-- <div class="card">
            <div class="card-body">
               @if (auth()->user()->hasRole('HRD-Recruitment'))
                 Hak Akses :  HRD Recruitment
               @endif
            </div>
         </div> --}}
         {{-- ANNOUNCE --}}
         

         @if (count($sps) > 0)
         <div class="card ">
            <div class="card-header bg-danger text-white"><b>Surat Peringatan <i class="fa fa-exclamation"></i></b></div>
            <div class="card-body">
               @foreach ($sps as $sp)
               <a href="{{route('sp.detail', enkripRambo($sp->id))}}">{{$sp->code}} - SP {{$sp->level}}</a>
                 <br>
               @endforeach
            </div>
         </div>
         @endif
         {{-- @if ($pending != null)
         <a href="" class="btn btn-primary btn-block shadow-sm" data-toggle="modal" data-target="#modal-out">Out</a>
         @else
         <a href="" class="btn btn-danger btn-block shadow-sm" data-toggle="modal" data-target="#modal-in">In</a>
         @endif
         <hr> --}}
         <div class="card  bg-primary text-white ">
           
            <div class="card-body">

               <h4>{{$employee->unit->name}}</h4>
               
            </div>
            <div class="card-footer d-flex justify-content-between">

               <div>
                  Department <br>
                  Posisi <br>
               </div>
               <div class="text-right">
                  {{$employee->department->name}} <br>
                  {{$employee->position->name}} <br>
               </div>
               
            </div>
         </div>
         
         
         <div class="card border card-stats card-round d-none d-md-block">
            <div class="card-body ">
               <div class="row align-items-center">
                  <div class="col-icon">
                     <div class="icon-big text-center icon-primary bubble-shadow-small">
                        <i class="fas fa-users"></i>
                     </div>
                  </div>
                  <div class="col col-stats ml-3 ml-sm-0">
                     <a href="{{route('backup.cuti')}}">
                     <div class="numbers">
                        <p class="card-category">Cuti Pengganti </p>
                        <h4 class="card-title">{{count($reqBackupForms)}}</h4>
                     </div>
                  </a>
                  </div>
                  
               </div>
            </div>
         </div>
         {{-- <a href="{{route('employee.absence.create')}}" class="btn btn-primary border btn-block mb-2"><i class="fa fa-file"></i> Form SPT/Cuti/Izin</a> --}}
         <div class="card d-none d-md-block">
            <div class="card-header bg-light border p-2">
               <small class="text-uppercase"> <b># Cuti department {{$employee->department->name}}</b> </small>
            </div>
            <div class="card-body p-0">
               <table class=" ">
                 
                  <tbody>
                     @if (count($cutis) > 0)
                     @foreach ($cutis as $cuti)
                     <tr>
                        <td>
                          {{formatDate($cuti->date)}} 
                        </td>
                        <td>{{$cuti->employee->biodata->fullName()}}</td>
                        
                     </tr>
                     @endforeach
                     @else
                     <tr>
                        <td colspan="1" class="text-center">Empty</td>
                     </tr>
                     @endif


                  </tbody>
               </table>
            </div>
            <div class="card-header bg-light border p-2">
               <small class="text-uppercase"> <b># Recent PE</b> </small>
            </div>
            <div class="card-body p-0">
               <table class=" ">
                  {{-- <thead >

                     <tr class="bg-primary text-white">
                        <th scope="col">ID</th>
                        
                     </tr>
                  </thead> --}}
                  <tbody>
                     @if (count($peHistories) > 0)
                     @foreach ($peHistories as $peHis)
                     <tr>
                        <td>
                           <a href="/qpe/show/{{enkripRambo($peHis->kpa->id)}}">Semester {{$peHis->semester}} / {{$peHis->tahun}}</a>
                        </td>
                        
                     </tr>
                     @endforeach
                     @else
                     <tr>
                        <td colspan="1" class="text-center">Empty</td>
                     </tr>
                     @endif


                  </tbody>
               </table>
            </div>
            <div class="card-header bg-light border p-2">
               <b># RECENT SP</b>
            </div>
            <div class="card-body p-0">
               <table class=" ">
                  
                  <tbody>
                     @if (count($spHistories) > 0)
                     @foreach ($spHistories as $spHis)
                     <tr>
                        <td>
                           <a href="{{route('sp.detail', enkripRambo($spHis->id))}}">{{$spHis->code}} - SP {{$spHis->level}}</a>
                        </td>
                        
                     </tr>
                     @endforeach
                     @else
                     <tr>
                        <td colspan="1" class="">Empty</td>
                     </tr>
                     @endif


                  </tbody>
               </table>
            </div>
         </div>

         

         {{-- <div class="card">
            <div class="card-header bg-danger text-white p-2">
               <small class="text-uppercase">Recent SP</small>
            </div>
            <div class="card-body p-0">
               <table class=" ">
                  <thead >

                     <tr class="bg-danger text-white">
                        <th scope="col">ID</th>
                        
                     </tr>
                  </thead>
                  <tbody>
                     @if (count($spHistories) > 0)
                     @foreach ($spHistories as $spHis)
                     <tr>
                        <td>
                           <a href="{{route('sp.detail', enkripRambo($spHis->id))}}">{{$spHis->code}} - SP {{$spHis->level}}</a>
                        </td>
                        
                     </tr>
                     @endforeach
                     @else
                     <tr>
                        <td colspan="1" class="text-center">Empty</td>
                     </tr>
                     @endif


                  </tbody>
               </table>
            </div>
         </div> --}}

      </div>


      <div class="col-md-9">
         {{-- <x-running-text /> --}}
         {{-- @if (count($broadcasts) > 0)
            @foreach ($broadcasts as $broad)
            <div class="d-none d-sm-block">
               <div class="alert alert-info shadow-sm">
   
                  <div class="card-opening">
                     <h4>
                        <img src="{{asset('img/flaticon/promote.png')}}" height="28" alt="" class="mr-1">
                        <b>Broadcast dari HRD</b>
                     </h4>
                  </div>
                  <div class="card-desc">
                     {{$broad->title}}.
                     <a href="{{route('announcement.detail', enkripRambo($broad->id))}}">Klik Disini</a> untuk melihat lebih detail
                     
                  </div>
               </div>
            </div>
            @endforeach
         @endif --}}

         @if (count($personals) > 0)
            @foreach ($personals as $pers)
            <div class="d-none d-sm-block">
               <div class="alert alert-danger shadow-sm">
   
                  <div class="card-opening">
                     <h4><b>Personal Message</b>
                     </h4>
                  </div>
                  <div class="card-desc">
                     
                     {{$pers->title}}. {!! $pers->body !!} 
                     {{-- <a href="{{route('announcement.detail', enkripRambo($pers->id))}}">Klik Disini</a> untuk melihat lebih detail --}}
                        {{-- <hr>
                        <small class="text-muted">* Ini adalah pesan personal yang hanya dikirim ke anda</small> --}}
                  </div>
               </div>
            </div>
            @endforeach
         @endif


         @if (count($sps) > 0)
            <div class="d-none d-sm-block">
               <div class="alert alert-danger shadow-sm">

                  <div class="card-opening">
                     <h4>
                        <img src="{{asset('img/flaticon/promote.png')}}" height="28" alt="" class="mr-1">
                        <b>Announcement</b>
                     </h4>
                  </div>
                  <hr>
                  <div class="card-desc">
                     
                        @foreach ($sps as $sp)
                        S orry, you've got SP {{$sp->level}} {{$sp->code}}, <a href="{{route('sp.detail', enkripRambo($sp->id))}}">click here to confirm </a><br>
                           
                        @endforeach
                     
                  </div>
               </div>
               <hr>
            </div>
         @endif

         @if ($currentTransaction)
           
            <div class="d-none d-sm-block">
               <div class="alert alert-info shadow-sm">
   
                  <div class="card-opening">
                     <h4>
                        <img src="{{asset('img/flaticon/budget.png')}}" height="28" alt="" class="mr-1">
                        <b>Slip Gaji {{$currentTransaction->month}}</b> sudah terbit ! 
                     </h4>
                  </div>
                  {{-- <hr> --}}
                  <div class="card-desc">
                     <a href="{{route('payroll.transaction.detail', enkripRambo($currentTransaction->id))}}">Klik Disini</a> untuk melihat lebih detail
                     
                  </div>
               </div>
            </div>
         @endif

         <div class="row">
            <div class="col-6 d-block d-sm-none">
               <div class="card card-info card-stats card-round ">
                  <div class="card-body ">
                     <div class="row align-items-center">
                       
                        <div class="col col-stats ml-3 ml-sm-0">
                           <a href="{{route('backup.cuti')}}">
                           <div class="numbers">
                              <p class="card-category">Cuti Pengganti </p>
                              <h4 class="card-title">
                                 @if (count($reqBackupForms) > 0)
                                 {{count($reqBackupForms)}}
                                 @else
                                 {{count($reqBackupForms)}}
                                 @endif
                                 
                              </h4>
                           </div>
                        </a>
                        </div>
                        
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-6 d-block d-sm-none">
               <div class="table-responsive overflow-auto" style="height: 110px">
               <div class="card ">

                  <div class="card-header bg-light border p-2">
                     <small class="text-uppercase"> <b># Cuti department {{$employee->department->name}}</b> </small>
                  </div>
                  <div class="card-body p-0">
                     <table class=" ">
                       
                        <tbody>
                           @if (count($cutis) > 0)
                           @foreach ($cutis as $cuti)
                           <tr>
                              <td>
                                {{formatDate($cuti->date)}} 
                              </td>
                              <td>{{$cuti->employee->biodata->fullName()}}</td>
                              
                           </tr>
                           @endforeach
                           @else
                           <tr>
                              <td colspan="1" class="text-center">Empty</td>
                           </tr>
                           @endif
      
      
                        </tbody>
                     </table>
                  </div>
                  <div class="card-header bg-light border p-2">
                     <small class="text-uppercase"> <b># Recent PE</b> </small>
                  </div>
                  <div class="card-body p-0">
                     <table class=" ">
                        {{-- <thead >
      
                           <tr class="bg-primary text-white">
                              <th scope="col">ID</th>
                              
                           </tr>
                        </thead> --}}
                        <tbody>
                           @if (count($peHistories) > 0)
                           @foreach ($peHistories as $peHis)
                           <tr>
                              <td>
                                 <a href="/qpe/show/{{enkripRambo($peHis->kpa->id)}}">Semester {{$peHis->semester}} / {{$peHis->tahun}}</a>
                              </td>
                              
                           </tr>
                           @endforeach
                           @else
                           <tr>
                              <td colspan="1" class="text-center">Empty</td>
                           </tr>
                           @endif
      
      
                        </tbody>
                     </table>
                  </div>
                  <div class="card-header bg-light border p-2">
                     <b># RECENT SP</b>
                  </div>
                  <div class="card-body p-0">
                     <table class=" ">
                        
                        <tbody>
                           @if (count($spHistories) > 0)
                           @foreach ($spHistories as $spHis)
                           <tr>
                              <td>
                                 <a href="{{route('sp.detail', enkripRambo($spHis->id))}}">{{$spHis->code}} - SP {{$spHis->level}}</a>
                              </td>
                              
                           </tr>
                           @endforeach
                           @else
                           <tr>
                              <td colspan="1" class="">Empty</td>
                           </tr>
                           @endif
      
      
                        </tbody>
                     </table>
                  </div>
               </div>
               </div>
            </div>
         </div>
        

         <div class="row">
            <div class="col-md-5">
               <div class="card">
                  <div class="card-header bg-primary text-white p-2">
                     <small class="text-uppercase">Personal Absensi</small>
                  </div>
                  <div class="card-body p-0">
                     @if (count($absences) > 0)
                     <div class="table-responsive overflow-auto" style="height: 180px">
                        <table class=" table-sm p-0 ">
                           <thead>
                              <tr>
                                 {{-- <th>Employee</th> --}}
                                 <th>Type</th>
                                 <th>Date</th>
                                 {{-- <th></th> --}}
                              </tr>
                           </thead>
         
                           <tbody>
                              @foreach ($absences as $absence)
                              
                              <tr>
                                 {{-- <td>{{$absence->employee->nik}} {{$absence->employee->biodata->fullName()}}</td> --}}
                                 <td>
      
                                    <x-status.absence :absence="$absence" />
                                    
                                 
                                 </td>
                                 <td>{{formatDateC($absence->date)}}</td>
                                
                              </tr>
                              @endforeach
                           </tbody>
         
                        </table>
                     </div>
                     @else
                     <div class="text-center p-2">Empty</div>
                     @endif
                     
                  </div>
                  <div class="card-footer p-2">
                     <small class="text-muted">
                        Data Absensi HRD
                     </small>
                  </div>
               </div>
            </div>
            <div class="col-md-7">
               <div class="card">
                  <div class="card-header bg-primary text-white p-2">
                     <small class="text-uppercase">Personal Form Cuti/SPT/Izin/Sakit </small>
                  </div>
                  <div class="card-body p-0">
                     @if (count($myForms) > 0)
                     <div class="table-responsive overflow-auto" style="height: 90px">
                        <table class=" table-sm p-0 ">
                           
         
                           <tbody>
                              @foreach ($myForms as $absence)
                                  <tr>
                                    <td> 
                                       <a  href="{{route('employee.absence.detail', [enkripRambo($absence->id), enkripRambo('progress')])}}" class=""><x-status.absence :absence="$absence" /></a>
                                       
                                    </td>
                                    <td>
                                       <x-absence.date :absence="$absence" />
                                     </td>
                                     @if ($absence->status == 101 || $absence->status == 201)
                                       <td class="bg-danger text-white">
                                          @else
                                          <td>
                                    @endif
                                    
                                       <x-status.form :form="$absence" />
                                    </td>
                                  </tr>
                              @endforeach
                             
                           </tbody>
         
                        </table>
                     </div>
                     @else
                     <div class="text-center p-2">Empty</div>
                     @endif
                     
                  </div>
                  {{-- <div class="card-footer">
                     <small class="text-muted">Jika data diatas tidak sesuai, lakukan perubahan data absensi dengan klik 'Update'</small>
                  </div> --}}
               </div>

               @if ($employee->unit_id == 10 || $employee->unit_id == 13 || $employee->unit_id == 14)
               @else
               <div class="card">
                  <div class="card-header bg-primary text-white p-2">
                     <small class="text-uppercase">Personal Pengajuan SPKL </small>
                  </div>
                  <div class="card-body p-0">
                     @if (count($spklEmps) > 0)
                     <div class="table-responsive overflow-auto" style="height: 90px">
                        <table class=" table-sm p-0 ">
                           
            
                           <tbody>
                              @foreach ($spklEmps as $spkl)
                              <tr>
                                 {{-- <td>
                                    <a href="{{route('employee.spkl.detail', enkripRambo($spkl->id))}}">{{$spkl->code}} </a>
                                    @if ($spkl->parent_id != null)
                                    | <a href="{{route('employee.spkl.detail.multiple', enkripRambo($spkl->parent_id))}}">Lihat Group</a>
                                        
                                    @endif
                                 </td> --}}
                                 {{-- <td>{{$spkl->employee->nik}}</td>
                                 <td>{{$spkl->employee->biodata->fullName()}}</td> --}}
                                 <td>
                                    <a href="{{route('employee.spkl.detail', [enkripRambo($spkl->id), enkripRambo('progress')])}}">
                                       @if ($spkl->type == 1)
                                       Lembur
                                       @else
                                       Piket
                                   @endif
                                    </a>
                                    @if ($spkl->parent_id != null)
                                    | <a href="{{route('employee.spkl.detail.multiple', [enkripRambo($spkl->parent_id), enkripRambo('dashboard')])}}">Lihat Group</a>
                                        
                                    @endif
                                   
                                 </td>
                                 <td class=" text-truncate">
                                    {{formatDate($spkl->date)}}
                                 </td>
                                 
                                 
                                 {{-- <td class="text-center">
                                    @if ($spkl->type == 1)
                                          @if ($spkl->employee->unit->hour_type == 1)
                                             {{$spkl->hours}}
                                             @elseif ($spkl->employee->unit->hour_type == 2)
                                             {{$spkl->hours}} ({{$spkl->hours_final}}) 
                                          @endif
                                       @else
                                       1
                                    @endif
                                    
                                    
                                 </td> --}}
                                 @if ($spkl->status == 201 || $spkl->status == 201)
                                     <td class="bg-danger text-white">
                                       @else
                                       <td>
                                 @endif
                                 
                                    <x-status.spkl-employee :empspkl="$spkl" />
                                 </td>
            
                              </tr>
                              @endforeach
                           </tbody>
         
                        </table>
                     </div>
                     @else
                     <div class="text-center p-2">Empty</div>
                     @endif
                     
                  </div>
                  {{-- <div class="card-footer">
                     <small class="text-muted">Jika data diatas tidak sesuai, lakukan perubahan data absensi dengan klik 'Update'</small>
                  </div> --}}
               </div>
               @endif
               
            </div>
         </div>

         

         <div class="card">
            <div class="card-header bg-primary text-white p-2">
               <small class="text-uppercase">Task List</small>
            </div>
            <div class="card-body p-0">
               <div class="table-responsive overflow-auto" style="height: 200px">
                  <table class=" ">
                     <thead>
         
                        <tr>
                           <th class="text-center">#</th>
                           <th class="">Kategori</th>
                           <th class="">Action Plan</th>
                           <th class="text-center">Target</th>
                           <th class="text-center">Closed</th>
                           <th>Status</th>
                           {{-- <th>Date</th> --}}
                           {{-- <th colspan="3" class="text-center">Tap In</th>
                           <th colspan="3" class="text-center">Tap Out</th>
                           <th rowspan="3" class="text-center">Work Hours</th> --}}
                        </tr>
                        
                     </thead>
                     <tbody>
                        @foreach ($tasks as $task)
                           <tr>
                              <td>{{++$i}}</td>
                              <td>{{$task->category}}</td>
                              <td><a href="{{route('task.detail', enkripRambo($task->id))}}">{{$task->plan}}</a></td>
                              <td>{{formatDate($task->target)}}</td>
                              <td>
                                 @if ($task->closed)
                                 {{formatDate($task->closed)}}
                                    @else
                                    -
                                 @endif
                              </td>
                              @if ($task->status == 0)
                                 <td class="bg-danger text-light">Open</td>
                                 @elseif($task->status == 1)
                                 <td class="bg-info text-light">Progress</td>
                                 @else
                                 <td class="bg-success text-light">Closed</td>
                                 
                              @endif
                              
                           </tr>
                        @endforeach
                        {{-- <tr>
                           <td>1</td>
                           <td>MARS</td>
                           <td>Fitur Drop Cargo by Material Man</td>
                           <td>17/10/2024</td>
                           <td>17/10/2024</td>
                           <td>Done</td>
                        </tr> --}}
         
                     </tbody>
                  </table>
               </div>
               
            </div>
         </div>
      </div>
   </div>
</div>

@foreach ($presences as $presence)
<div class="modal fade" id="modal-presence-{{$presence->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog " role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Presence</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('employee.presence.in')}}" method="POST">
            @csrf
            <div class="modal-body">

               <div class="row">
                  <div class="col-md-6">
                     <div class="badge badge-info mb-2">In</div>
                     {{-- <hr> --}}
                     <div class="form-group form-group-default">
                        <label>Date</label>
                        <input type="date" class="form-control" name="date" id="date" value="{{$presence->in_date}}">
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Location</label>
                              <select class="form-control" name="loc" id="loc">
                                 <option {{$presence->in_loc == 'HW' ?  'selected' : ''}} value="HW">HW</option>
                                 <option {{$presence->in_loc == 'JGC' ?  'selected' : ''}} value="JGC">JGC</option>
                                 <option {{$presence->in_loc == 'KJ' ?  'selected' : ''}} value="KJ">KJ</option>
                                 <option {{$presence->in_loc == 'GS' ?  'selected' : ''}} value="GS">GS</option>
                              </select>
                              {{-- <input id="Name" type="text" class="form-control" > --}}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Time</label>
                              <input type="time" class="form-control" name="time" id="time" value="{{$presence->in_time}}">
                           </div>
                        </div>
                     </div>

                  </div>
                  <div class="col-md-6">
                     <div class="badge badge-info mb-2">Out</div>
                     {{-- <hr> --}}
                     <div class="form-group form-group-default">
                        <label>Date</label>
                        <input type="date" class="form-control" name="date" id="date" value="{{$presence->out_date}}">
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Location</label>
                              <select class="form-control" name="loc" id="loc">
                                 <option {{$presence->out_loc == 'HW' ?  'selected' : ''}} value="HW">HW</option>
                                 <option {{$presence->out_loc == 'JGC' ?  'selected' : ''}} value="JGC">JGC</option>
                                 <option {{$presence->out_loc == 'KJ' ?  'selected' : ''}} value="KJ">KJ</option>
                                 <option {{$presence->out_loc == 'GS' ?  'selected' : ''}} value="GS">GS</option>
                              </select>
                              {{-- <input id="Name" type="text" class="form-control" > --}}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Time</label>
                              <input type="time" class="form-control" name="time" id="time" value="{{$presence->out_time}}">
                           </div>
                        </div>
                     </div>

                  </div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-3">
                     Work Hours <br>
                     Overtime <br>
                  </div>
                  <div class="col-9">
                     : <b>{{$presence->total}}</b> <br>
                     : <b>0</b>
                  </div>
               </div>

            </div>
            <div class="modal-footer">
               {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
               {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
            </div>
         </form>
      </div>
   </div>
</div>
@endforeach

<div class="modal fade" id="modal-in" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kamu sudah tiba dikantor?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('employee.presence.in')}}" method="POST">
            @csrf
            <div class="modal-body">
               <div class="form-group form-group-default">
                  <label>Date</label>
                  <input type="date" class="form-control" name="date" id="date">
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label>Location</label>
                        <select class="form-control" name="loc" id="loc">
                           <option value="HW">HW</option>
                           <option value="JGC">JGC</option>
                           <option value="KJ">KJ</option>
                           <option value="GS">GS</option>
                        </select>
                        {{-- <input id="Name" type="text" class="form-control" > --}}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label>Time</label>
                        <input type="time" class="form-control" name="time" id="time">
                     </div>
                  </div>
               </div>
               <hr>
               Fitur ini masih dalam tahap pengembangan :)

            </div>
            <div class="modal-footer">
               {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
               <button type="submit" class="btn btn-primary" disabled>Submit</button>
               
               
            </div>
         </form>
      </div>
   </div>
</div>

@if ($pending != null)
<div class="modal fade" id="modal-out" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kamu sudah selesai bekerja?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('employee.presence.out')}}" method="POST">
            @csrf
            @method('PUT')

            <input type="number" id="presence" name="presence" value="{{$pending->id}}" hidden>
            <div class="modal-body">
               <div class="form-group form-group-default">
                  <label>Date</label>
                  <input type="date" class="form-control" name="date" id="date">
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label>Select Location</label>
                        <select class="form-control" name="loc" id="loc">
                           <option value="HW">HW</option>
                           <option value="JGC">JGC</option>
                           <option value="KJ">KJ</option>
                           <option value="GS">GS</option>
                        </select>
                        {{-- <input id="Name" type="text" class="form-control" > --}}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label>Time</label>
                        <input type="time" class="form-control" name="time" id="time">
                     </div>
                  </div>
               </div>

            </div>
            <div class="modal-footer">
               {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
               <button type="submit" class="btn btn-primary">Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endif

@push('chart-dashboard')
<script>
   $(document).ready(function() {
      var barChart = document.getElementById('barChart').getContext('2d');

      var myBarChart = new Chart(barChart, {
         type: 'bar',
         data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
               label: "Sales",
               backgroundColor: 'rgb(23, 125, 255)',
               borderColor: 'rgb(23, 125, 255)',
               data: [3, 2, 9, 5, 4, 6, 4, 6, 7, 8, 7, 4],
            }],
         },
         options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
               yAxes: [{
                  ticks: {
                     beginAtZero: true
                  }
               }]
            },
         }
      });
   })
</script>
@endpush

@endsection