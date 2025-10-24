
@extends('layouts.app')
@section('title')
      Dashboard
@endsection
@section('content')
   <div class="page-inner mt--5">
      <div class="page-header">
         <h5 class="page-title text-info d-flex">
            {{-- <i class="fa fa-home"></i> --}}
            <div class="mr-2">
               <img src="{{asset('img/flaticon/hello.png')}}" alt="" width="30px">
            </div>
            <div >
               Welcome back, {{auth()->user()->getGender()}} {{auth()->user()->name}}
            </div>
            
            
         </h5>
      </div>
      <div class="row">
         <div class="col-sm-6 col-md-3">
            <div class="card card-primary">
               <div class="card-body">
                  <x-role />
                  <hr>
                  
                  <b>{{$employee->unit->name}}</b> - {{$employee->department->name}}<br>
                   
                  {{$employee->position->name}}
               </div>
            </div>
            <div class="card d-none d-sm-block">
               <div class="card-body p-0">
                  <table class="display  table-sm table-bordered  table-striped ">
                     <thead>
                        <tr>
                           <th colspan="2">{{$allEmployees}} Karyawan</th>
                        </tr>
                        <tr>
                           <th scope="col">Status</th>
                           <th scope="col" class="text-center">Jumlah</th>
                           
                        </tr>
                        
                     </thead>
                     <tbody>
                        <tr>
                           <td>Kontrak</td>
                           <td class="text-center">{{$kontrak}}</td>
                        </tr>
                        <tr>
                           <td>Tetap</td>
                           <td class="text-center">{{$tetap}}</td>
                        </tr>
                        <tr>
                           <td>Empty</td>
                           <td class="text-center">{{$empty}}</td>
                        </tr>
                        {{-- <tr>
                           <td>Total</td>
                           <td class="text-center">{{count($employees)}}</td>
                        </tr> --}}
                     </tbody>
                  </table>
               </div>
            </div>
            {{-- <div class="d-flex">
               <a href="{{route('employee.create')}}" class="btn btn-primary btn-block mr-2">Create</a>
               <a href="{{route('employee.import')}}" class="btn btn-primary">Import</a>
            </div> --}}

            @if (auth()->user()->hasRole('Leader'))
            <div class="card d-none d-sm-block">
               <div class="card-header bg-primary text-white p-2">
                  <small>Teams</small>
               </div>
               <div class="card-body p-0">
                  <div class="table-responsive overflow-auto" style="height: 200px">
                  <table class=" ">
                     {{-- <thead>
                        <tr>
                           <th></th>
                           <th>NIK</th>
                           <th>Name</th>
                        </tr>
                     </thead> --}}
                     <tbody>
                        @if (count($employee->positions) > 0)
                              @foreach ($positions as $pos)
                                    <tr>
                                    {{-- <td></td> --}}
                                    <td colspan="4">{{$pos->department->unit->name}} {{$pos->department->name}} ({{count($pos->department->employees)}}) </td>
                                    {{-- <td>{{$employee->biodata->fullName()}}</td> --}}
                                    </tr>
                                    @foreach ($pos->department->employees->where('status', 1) as $emp)
                                       <tr>
                                       <td></td>
                                       {{-- <td>{{$emp->sub_dept->name ?? ''}}</td> --}}
                                       {{-- <td></td> --}}
                                       <td>
                                          <a href="{{route('employee.overview.simple', enkripRambo($emp->eid))}}">{{$emp->biodata->fullName()}}</a>
                                          
                                       </td>
                                       </tr>
                                    @endforeach
                              @endforeach
                            @else
                            @foreach ($teams as $team)
                                 @if ($team->employee->status == 1)
                                 <tr>
                                    {{-- <td>{{$team->employee->nik}} </td> --}}
                                    <td><a href="{{route('employee.overview.simple', enkripRambo($team->employee_id))}}">{{$team->employee->biodata->fullName()}}</a> </td>
                                 </tr>
                                 @endif
                                 
                           @endforeach    
                        @endif
                        
                        
                        
                     </tbody>
                  </table>
                  </div>
               </div>
            </div>
            @else
            
            @endif
            {{-- reqBackForms --}}
            <div class="card d-none d-md-block">
               <div class="card-header bg-light border p-2">
                  <small class="text-uppercase"> <b># Cuti Pengganti</b> </small>
               </div>
               <div class="card-body p-0">
                  <table class=" ">
                    
                     <tbody>
                        @if (count($backupDetails) > 0)
                           @foreach ($backupDetails as $backup)
                           <tr>
                              <td>
                              {{formatDate($backup->date)}} 
                              </td>
                              <td>{{$backup->absence_employee->employee->biodata->fullName()}}</td>
                              
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
                  <small class="text-uppercase"> <b># Cuti Department {{$employee->department->name}}</b> </small>
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
         <div class="col-sm-6 col-md-9">
            {{-- <x-running-text /> --}}
            
          

         {{-- Mobile View --}}
         <div class="row">

            @if (auth()->user()->hasRole('Leader'))

            <div class="col-6 d-block d-sm-none">
               <a href="{{route('leader.absence')}}">
                  <div class="card card-info card-stats card-round">
                     <div class="card-body ">
                        <div class="row align-items-center">
                           
                           <div class="col col-stats ml-3 ml-sm-0">
                              
                              {{-- <a href="{{route('leader.absence')}}"> --}}
                                 <div class="numbers">
                                    <p class="card-category"> Approval Absensi </p>
                                    <h4 class="card-title ">
                                       @if (count($reqForms)> 0)
                                          <div class="badge badge-light">{{count($reqForms)}}</div>
                                           @else
                                           {{count($reqForms)}}
                                       @endif
                                    </h4>
                                 </div>
                              {{-- </a> --}}
                              
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            @endif
            <div class="col-6 d-block d-sm-none">
               <a href="{{route('contract.alert')}}" data-toggle="tooltip" data-placement="top" title="Fitur ini masih dalam tahap finalisasi">
                  <div class="card card-primary card-stats card-round">
                     <div class="card-body ">
                        <div class="row align-items-center">
                           
                           <div class="col col-stats ml-3 ml-sm-0">
                              
                                 <div class="numbers">
                                    <p class="card-category"> Contract </p>
                                    <h4 class="card-title"> 
                                       @if (count($notifContracts) > 0)
                                          <div class="badge badge-light">
                                             {{count($notifContracts)}}
                                          </div>
                                          @else
                                          {{count($notifContracts)}}
                                       @endif
                                    </h4>
                                 </div>
                              
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
            </div>

            <div class="col-6 d-block d-sm-none">
               <a href="{{route('hrd.spkl')}}">
                  <div class="card card-secondary card-stats card-round">
                     <div class="card-body ">
                        <div class="row align-items-center">
                           
                           <div class="col col-stats ml-3 ml-sm-0">
                              
                                 <div class="numbers">
                                    <p class="card-category"> Approval SPKL </p>
                                    <h4 class="card-title"> 
                                       @if (count($spklApprovals) > 0)
                                          <div class="badge badge-light">{{count($spklApprovals)}}</div>
                                          @else
                                          {{count($spklApprovals)}}
                                       @endif
                                    </h4>
                                 </div>
                              
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
            </div>

            <div class="col-6 d-block d-sm-none">
               {{-- <a href="{{route('hrd.absence')}}" class="btn btn-block btn-primary text-left">Monitoring <br> Form Absensi </a> --}}
               <a href="{{route('hrd.absence')}}">
                  <div class="card card-info card-stats card-round">
                     <div class="card-body ">
                        <div class="row align-items-center">
                           
                           <div class="col col-stats ml-3 ml-sm-0">
                              
                                 <div class="numbers">
                                    <p class="card-category"> Monitoring Form Absensi </p>
                                    {{-- <h4 class="card-title py-1"> 
                                       @if (count($absenceProgress) > 0)
                                          <div class="badge badge-light">{{count($absenceProgress)}}</div>
                                          @else
                                          {{count($absenceProgress)}}
                                       @endif
                                    </h4> --}}
                                 </div>
                              
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
         </div>

         <div class="card d-block d-sm-none">
            <div class="card-body p-0">
               <table class="display  table-sm table-bordered  table-striped ">
                  <thead>
                     <tr>
                        <th colspan="2">{{$allEmployees}} Karyawan</th>
                     </tr>
                     <tr>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-center">Jumlah</th>
                        
                     </tr>
                     
                  </thead>
                  <tbody>
                     <tr>
                        <td>Kontrak</td>
                        <td class="text-center">{{$kontrak}}</td>
                     </tr>
                     <tr>
                        <td>Tetap</td>
                        <td class="text-center">{{$tetap}}</td>
                     </tr>
                     <tr>
                        <td>Empty</td>
                        <td class="text-center">{{$empty}}</td>
                     </tr>
                     {{-- <tr>
                        <td>Total</td>
                        <td class="text-center">{{count($employees)}}</td>
                     </tr> --}}
                  </tbody>
               </table>
            </div>
         </div>
         <div class="row">
            @if (auth()->user()->hasRole('Leader'))
            <div class="col">
               
                  <div class="card d-block d-sm-none">
                     <div class="card-header bg-primary text-white p-2">
                        <small>Teams</small>
                     </div>
                     <div class="card-body p-0">
                        <div class="table-responsive overflow-auto" style="height: 140px">
                        <table class=" ">
                           {{-- <thead>
                              <tr>
                                 <th></th>
                                 <th>NIK</th>
                                 <th>Name</th>
                              </tr>
                           </thead> --}}
                           <tbody>
                              @if (count($employee->positions) > 0)
                                    @foreach ($positions as $pos)
                                          <tr>
                                          {{-- <td></td> --}}
                                          <td colspan="4">{{$pos->department->unit->name}} {{$pos->department->name}} ({{count($pos->department->employees)}}) </td>
                                          {{-- <td>{{$employee->biodata->fullName()}}</td> --}}
                                          </tr>
                                          @foreach ($pos->department->employees->where('status', 1) as $emp)
                                             <tr>
                                             <td></td>
                                             {{-- <td>{{$emp->sub_dept->name ?? ''}}</td> --}}
                                             {{-- <td></td> --}}
                                             <td>
                                                <a href="{{route('employee.overview.simple', enkripRambo($emp->eid))}}">{{$emp->biodata->fullName()}}</a>
                                                
                                             </td>
                                             </tr>
                                          @endforeach
                                    @endforeach
                                 @else
                                 @foreach ($teams as $team)
                                       @if ($team->employee->status == 1)
                                       <tr>
                                          {{-- <td>{{$team->employee->nik}} </td> --}}
                                          <td><a href="{{route('employee.overview.simple', enkripRambo($team->employee_id))}}">{{$team->employee->biodata->fullName()}}</a> </td>
                                       </tr>
                                       @endif
                                       
                                 @endforeach    
                              @endif
                              
                              
                              
                           </tbody>
                        </table>
                        </div>
                     </div>
                  </div>
               
            </div>
            @endif
            <div class="col">
               
                  <div class="card d-block d-sm-none">
                     <div class="card-header bg-primary text-white p-2">
                        <small class="text-uppercase"> <b># Cuti {{$employee->department->name}}</b> </small>
                     </div>
                     {{-- <div class="table-responsive overflow-auto" style="height: 140px"> --}}
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
                        <div class="card-header bg-light p-2 border">
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
                        <div class="card-header bg-light p-2 border">
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
                     {{-- </div> --}}
                  </div>
               
            </div>
         </div>

         
         

         






         <div class="row">

            @if (auth()->user()->hasRole('Leader'))
            <div class="col-md-4 d-none d-sm-block">
               <div class="card card-stats card-round border">
                  <div class="card-body ">
                     <div class="row align-items-center">
                        <div class="col-icon">
                           <div class="icon-big text-center icon-primary bubble-shadow-small">
                              <i class="fas fa-users"></i>
                           </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                           <a href="{{route('leader.absence')}}">
                              <div class="numbers">
                                 <p class="card-category">  Absensi Team </p>
                                 <h4 class="card-title">
                                    @if (count($reqForms)> 0)
                                       <div class="badge badge-danger">{{count($reqForms)}}</div>
                                        @else
                                        {{count($reqForms)}}
                                    @endif
                                 </h4>
                              </div>
                           </a>
                        </div>
                        
                     </div>
                  </div>
                  {{-- <div class="card-body">
                     <small>Melihat Request Absensi Cuti, SPT, dan lainnya yang memiliki relasi terhadap anda sebagai pengganti maupun sebagai atasan</small>
                  </div> --}}
               </div>
               
            </div>

            <div class="col-md-4 d-none d-md-block">
               <a href="{{route('leader.spkl')}}">
                  <div class="card border card-stats card-round">
                     <div class="card-body ">
                        <div class="row align-items-center">
                           <div class="col-icon">
                              <div class="icon-big text-center icon-primary bubble-shadow-small">
                                 <i class="fas fa-calendar-check"></i>
                              </div>
                           </div>
                           <div class="col col-stats ml-3 ml-sm-0">
                              
                              <div class="numbers">
                                 <p class="card-category">SPKL Team</p>
                                 <h4 class="card-title"> 
                                    @if (count($spklApprovals) > 0)
                                       <div class="badge badge-danger">{{count($spklApprovals)}}</div>
                                       @else
                                       {{count($spklApprovals)}}
                                    @endif
                                 </h4>
                              </div>
                        
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            
            @endif
            
            <div class="col-md-4  d-none d-sm-block">
               <a href="{{route('contract.alert')}}" data-toggle="tooltip" data-placement="top" title="Fitur ini masih dalam tahap finalisasi">
                  <div class="card card-stats card-round border">
                     <div class="card-body">
                        <div class="row align-items-center">
                           <div class="col-icon d-none d-md-block">
                              <div class="icon-big text-center icon-info bubble-shadow-small">
                                 <i class="fa fa-file"></i>
                              </div>
                           </div>
                           <div class="col col-stats ml-3 ml-sm-0">
                              <div class="numbers">
                                 <p class="card-category">Contract</p>
                                 <h4 class="card-title">
                                    @if (count($notifContracts) > 0)
                                        <div class="badge badge-danger">
                                          {{count($notifContracts)}}
                                        </div>
                                        @else
                                        {{count($notifContracts)}}
                                    @endif
                                    {{-- {{count($payrollApprovals)}} --}}
                                 </h4>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  
               </a>
            </div>


            @if (auth()->user()->hasRole('Leader'))
            <div class="col-md-6 d-none d-md-block">
               <a href="{{route('hrd.absence')}}">
                  <div class="card border card-stats card-round">
                     <div class="card-body ">
                        <div class="row align-items-center">
                           <div class="col-icon">
                              <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                 <i class="fas fa-users"></i>
                              </div>
                           </div>
                           <div class="col col-stats ml-3 ml-sm-0">
                              
                              <div class="numbers">
                                 <p class="card-category mb-1"> Monitoring Form Absensi </p>
                                 <h4 class="card-title"> 
                                 @if (count($absenceProgress) > 0)
                                          <div class="badge badge-danger">{{count($absenceProgress)}}</div>
                                          @else
                                          {{count($absenceProgress)}}
                                       @endif
                                 </h4>
                              </div>
                           
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
            </div>

            <div class="col-md-6 d-none d-md-block">
               <a href="{{route('hrd.spkl')}}">
                  <div class="card border card-stats card-round">
                     <div class="card-body ">
                        <div class="row align-items-center">
                           <div class="col-icon">
                              <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                 <i class="fas fa-users"></i>
                              </div>
                           </div>
                           <div class="col col-stats ml-3 ml-sm-0">
                              
                              <div class="numbers">
                                 <p class="card-category mb-1"> Monitoring Form SPKL </p>
                                 <h4 class="card-title"> 
                                 -
                                 </h4>
                              </div>
                           
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
            </div>

            
            @endif
            
            {{-- <div class="col d-none d-md-block">
               <a href="{{route('hrd.absence')}}">
                  <div class="card border card-stats card-round">
                     <div class="card-body ">
                        <div class="row align-items-center">
                           <div class="col-icon">
                              <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                 <i class="fas fa-users"></i>
                              </div>
                           </div>
                           <div class="col col-stats ml-3 ml-sm-0">
                              
                              <div class="numbers">
                                 <p class="card-category mb-1"> Monitoring Form Absensi </p>
                                 <h4 class="card-title"> 
                                 @if (count($absenceProgress) > 0)
                                          <div class="badge badge-danger">{{count($absenceProgress)}}</div>
                                          @else
                                          {{count($absenceProgress)}}
                                       @endif
                                 </h4>
                              </div>
                           
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
            </div> --}}

            {{-- <div class="col">
               <div class="card card-stats card-round border">
                  <div class="card-body ">
                     <div class="row align-items-center">
                        <div class="col-icon">
                           <div class="icon-big text-center icon-danger bubble-shadow-small">
                              <i class="fas fa-users"></i>
                           </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                           <a href="{{route('backup.cuti')}}">
                           <div class="numbers">
                              <p class="card-category"> Cuti Pengganti </p>
                              <h4 class="card-title">{{count($reqBackForms)}}</h4>
                           </div>
                        </a>
                        </div>
                     </div>
                  </div>
                 
               </div>
            </div> --}}
            
         </div>
            <div class="card">
               <div class="card-header p-2 bg-primary text-white">
                  <small>Kontrak Berakhir  ({{count($notifContracts)}})</small>
               </div>
               <div class="card-body p-0">
                  <div class="table-responsive overflow-auto" style="height: 150px">
                  <table class="display  table-sm table-bordered  table-striped ">
                     <thead>
                        
                        <tr>
                           <th scope="col">NIK</th>
                           <th scope="col" >Name</th>
                           <th>Unit</th>
                           <th>Department</th>
                           <th>Expired</th>
                        </tr>
                        
                     </thead>
                     <tbody>
                        @foreach ($notifContracts as $con)
                            <tr>
                              <td>
                                 <a href="{{route('employee.detail', [enkripRambo($con->employee->id), enkripRambo('contract')])}}">{{$con->employee->nik ?? ''}}</a> 
                                 
                              </td>
                              <td>
                                 <a href="{{route('employee.detail', [enkripRambo($con->employee->id), enkripRambo('contract')])}}"> {{$con->employee->biodata->fullName()}}</a> 
                                
                              </td>
                              <td>{{$con->employee->unit->name}}</td>
                              <td>{{$con->employee->department->name}}</td>
                              <td>{{formatDateB($con->end)}}</td>
                            </tr>
                        @endforeach
                     </tbody>
                  </table>
                  </div>
               </div>
            </div>

            <div class="card">
               <div class="card-header p-2 bg-primary text-white">
                  <small>Incomplete KPI Data</small>
               </div>
               <div class="card-body p-0">
                  <div class="table-responsive overflow-auto" style="height: 200px">
                     <table class=" table-sm table-bordered  table-striped ">
                        <thead>
                           
                           <tr>
                              <th class="text-center">No</th>
                              <th>ID</th>
                              <th>Name</th>
                              <th>KPI</th>
                              <th>Leader</th>
                              {{-- <th>Phone</th> --}}
                              <th class="text-truncate">Bisnis Unit</th>
                              <th>Department</th>
                              {{-- <th>Sub</th> --}}
                              <th  >Posisi</th>
                              {{-- <th>Kontrak/Tetap</th> --}}
                              {{-- <th class="text-right">Action</th> --}}
                           </tr>
                           
                        </thead>
                        <tbody>
                           @if (count($employees) > 0)
                              @foreach ($employees as $employee)
                                 <tr>
                                    <td class="text-center">{{++$i}}</td>
                                    <td class="text-truncate">{{$employee->contract->id_no}}</td>
                                    {{-- <td><a href="{{route('employee.detail', enkripRambo($employee->id))}}">{{$employee->name}}</a> </td> --}}
                                    <td class="text-truncate" style="max-width: 150px">
                                       {{-- <div> --}}
                                          <a href="{{route('employee.detail', [enkripRambo($employee->id), enkripRambo('basic')])}}"> {{$employee->biodata->first_name}} {{$employee->biodata->last_name}}</a> 
                                          {{-- <small class="text-muted">{{$employee->biodata->email}}</small> --}}
                                       {{-- </div> --}}
                                    
                                    </td>
                                    
                                    <td>
                                       @if ($employee->kpi_id != null)
                                       {{-- <a href="{{route('kpi.edit', enkripRambo($employee->kpi_id))}}">{{$employee->getKpi()->title}}</a> --}}
                                          {{-- <span class="text-success">OK</span> --}}
                                          <i class="fa fa-check"></i>
                                          @else
                                          Empty
                                       @endif
                                       
                                    </td>
                                    <td>
                                       @if (count($employee->getLeaders()) > 0)
                                          {{-- OK --}}
                                          <i class="fa fa-check"></i>
                                          @else
                                          Empty
                                       @endif
                                    </td>
                                    {{-- <td>{{$employee->biodata->phone}}</td> --}}
                                    
                                    <td class="text-truncate">
                                       @if (count($employee->positions) > 0)
                                             {{-- @foreach ($employee->positions as $pos)
                                                {{$pos->department->unit->name}}
                                             @endforeach --}}
                                             Multiple
                                          @else
                                          {{$employee->department->unit->name ?? ''}}
                                       @endif
                                       
                                    </td>
                                    
                                    <td class="text-truncate">
                                       {{-- {{$employee->department->name ?? ''}} --}}
                                       @if (count($employee->positions) > 0)
                                             {{-- @foreach ($employee->positions as $pos)
                                                {{$pos->department->name}}
                                             @endforeach --}}
                                             Multiple
                                          @else
                                          {{$employee->department->name ?? ''}}
                                       @endif
                                    </td>
                                    {{-- <td>
                                       @if (count($employee->positions) > 0)
                                             @foreach ($employee->positions as $pos)
                                                {{$pos->sub_dept->name ?? ''}}
                                             @endforeach
                                          @else
                                          {{$employee->sub_dept->name ?? ''}}
                                       @endif
                                    </td> --}}
                                    {{-- <td>{{$employee->contract->designation->name ?? ''}}</td> --}}
                                    <td class="text-truncate">
                                       @if (count($employee->positions) > 0)
                                             {{-- @foreach ($employee->positions as $pos)
                                                {{$pos->name}}
                                             @endforeach --}}
                                             Multiple
                                          @else
                                          {{$employee->position->name ?? ''}}
                                       @endif
                                    </td>
                                    {{-- <td>
                                       @if ($employee->contract->type == 'Kontrak')
                                       <span class="badge badge-info">Kontrak</span>
                                       @elseif($employee->contract->type == 'Tetap')
                                       <span class="badge badge-info">Tetap</span>
                                       @else
                                       <span class="badge badge-muted">Empty</span>
                                       @endif
                     
                                    </td> --}}
                                 </tr>
                              @endforeach
                              @else
                           @endif
                           
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         
         
      </div>
      
   </div>

   @push('chart-dashboard')
   <script>
       $(document).ready(function() {
         var barChart = document.getElementById('barChart').getContext('2d');

         var myBarChart = new Chart(barChart, {
            type: 'bar',
            data: {
               labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
               datasets : [{
                  label: "Resign",
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
                        beginAtZero:true
                     }
                  }]
               },
            }
         });
      })
   </script>
   @endpush
   
@endsection