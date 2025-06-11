
@extends('layouts.app')
@section('title')
      Dashboard
@endsection
@section('content')
   <div class="page-inner mt--5">
      <div class="page-header">
         <h5 class="page-title text-info">
            {{-- <i class="fa fa-home"></i> --}}
            Welcome back, {{auth()->user()->getGender()}} {{auth()->user()->name}}
            
            
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
            <div class="card">
               <div class="card-body p-0">
                  <table class="display  table-sm table-bordered  table-striped ">
                     <thead>
                        <tr>
                           <th colspan="2">{{count($employees)}} Karyawan</th>
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
            <div class="card">
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
            <div class="card card-stats card-round border">
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
                           <p class="card-category"> Cuti Pengganti </p>
                           <h4 class="card-title">{{count($reqBackForms)}}</h4>
                        </div>
                     </a>
                     </div>
                  </div>
               </div>
               <div class="card-body">
                  <small>Daftar Cuti yang memiliki relasi terhadap anda sebagai Karyawan Pengganti</small>
               </div>
            </div>
            @endif

            
            
         </div>
         <div class="col-sm-6 col-md-9">
            
            {{-- @if (count($broadcasts) > 0)
            @foreach ($broadcasts as $broad)
            <div class="d-none d-sm-block">
               <div class="alert alert-info shadow-sm">
   
                  <div class="card-opening">
                     <h4>
                        <img src="{{asset('img/flaticon/promote.png')}}" height="28" alt="" class="mr-1">
                        <b>Broadcast</b>
                     </h4>
                  </div>
                  <div class="card-desc">
                     {{$broad->title}}.
                     <a href="{{route('announcement.detail', enkripRambo($broad->id))}}">Click here</a> to see more detail
                     
                  </div>
               </div>
            </div>
            @endforeach
         @endif --}}

         {{-- @if (count($personals) > 0)
            @foreach ($personals as $pers)
            <div class="d-none d-sm-block">
               <div class="alert alert-danger shadow-sm">
   
                  <div class="card-opening">
                     <h4>
                         <b>Personal Message</b>
                     </h4>
                  </div>
                  <div class="card-desc">
                     
                     {{$pers->title}}.
                     <a href="{{route('announcement.detail', enkripRambo($pers->id))}}">Click here</a> to see more detail
                        <hr>
                        <small class="text-muted">* Ini adalah pesan personal yang hanya dikirim ke anda</small>
                  </div>
               </div>
            </div>
            @endforeach
         @endif --}}
         <div class="row">

            @if (auth()->user()->hasRole('Leader'))
            <div class="col-md-6">
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
                                 <p class="card-category"> Approval Form Absensi </p>
                                 <h4 class="card-title">{{count($reqForms) + count($reqBackForms)}}</h4>
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
            <div class="col">
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
                  {{-- <div class="card-body">
                     <small>Daftar Cuti yang memiliki relasi terhadap anda sebagai Karyawan Pengganti</small>
                  </div> --}}
               </div>
            </div>
            @endif
            
         </div>
            <div class="card">
               <div class="card-header p-2 bg-primary text-white">
                  <small>Kontrak Berakhir  ({{count($notifContracts)}})</small>
               </div>
               <div class="card-body p-0">
                  <div class="table-responsive overflow-auto" style="height: 210px">
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
                  <div class="table-responsive overflow-auto" style="height: 290px">
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