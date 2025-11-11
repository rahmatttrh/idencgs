
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

            {{-- <div class="card">
               <div class="card-header p-2 bg-primary text-white">
                  <i class="fas fa-desktop"></i> <small>Monitoring</small>
               </div>
               <div class="card-body p-0">
                  <table class="display  table-sm table-bordered">
                     <thead>
                        <tr>
                           <th colspan="2">Transaction</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td>Draft</td>
                           <td class="text-center">0</td>
                        </tr>
                        <tr>
                           <td>Completed</td>
                           <td class="text-center">0</td>
                        </tr>
                        
                     </tbody>
                  </table>
                  
               </div>
            </div> --}}

            {{-- <a href="{{route('hrd.absence')}}" class="btn btn-block btn-primary"><i class="fa fa-file"></i> Monitoring Form Absensi</a> --}}
            
            
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
            
            
         </div>
         <div class="col-sm-6 col-md-9">
            {{-- <x-running-text /> --}}
            {{-- <div class="row">
               <div class="col-md-4">
                  <a href="{{route('payroll.approval.gm')}}">
                     <div class="card card-stats card-round border">
                        <div class="card-body">
                           <div class="row align-items-center">
                              <div class="col-icon d-none d-md-block">
                                 <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="far fa-newspaper"></i>
                                 </div>
                              </div>
                              <div class="col col-stats ml-3 ml-sm-0">
                                 <div class="numbers">
                                    <p class="card-category">Payslip</p>
                                    <h4 class="card-title">1</h4>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     
                  </a>
               </div>
            </div> --}}
            {{-- <div class="row">
               <div class="col-md-6">
                  
                  
               </div>
            </div> --}}
            @if (count($broadcasts) > 0)
            @foreach ($broadcasts as $broad)
            <div class="d-none d-sm-block">
               <div class="alert alert-info shadow-sm">
   
                  <div class="card-opening">
                     <h4>
                        <img src="{{asset('img/flaticon/promote.png')}}" height="28" alt="" class="mr-1">
                        <b>Broadcast dari HRD</b>
                     </h4>
                  </div>
                  {{-- <hr> --}}
                  <div class="card-desc">
                     {{$broad->title}}.
                     {{-- <div class="text-truncate" style="max-width: 200px">
                        {{strip_tags($broad->body)}}
                     </div> --}}
                     <a href="{{route('announcement.detail', enkripRambo($broad->id))}}">Klik Disini</a> untuk melihat lebih detail
                     
                  </div>
               </div>
            </div>
            @endforeach
         @endif

         @if (count($personals) > 0)
            @foreach ($personals as $pers)
            <div class="d-none d-sm-block">
               <div class="alert alert-danger shadow-sm">
   
                  <div class="card-opening">
                     <h4>
                        {{-- <img src="{{asset('img/flaticon/promote.png')}}" height="28" alt="" class="mr-1"> --}}
                        <b>Personal Message</b>
                     </h4>
                  </div>
                  {{-- <hr> --}}
                  <div class="card-desc">
                     
                     {{$pers->title}}.
                     <a href="{{route('announcement.detail', enkripRambo($pers->id))}}">Klik Disini</a> untuk melihat lebih detail
                        <hr>
                        <small class="text-muted">* Ini adalah pesan personal yang hanya dikirim ke anda</small>
                  </div>
               </div>
            </div>
            @endforeach
         @endif

            @if (count($broadcasts) > 0)
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
         @endif

        

         {{-- Mobile View --}}
         <div class="row">
            <div class="col-6 d-block d-sm-none">
               <a href="{{route('hrd.spkl')}}">
                  <div class="card card-info card-stats card-round">
                     <div class="card-body ">
                        <div class="row align-items-center">
                           
                           <div class="col col-stats ml-3 ml-sm-0">
                              
                                 <div class="numbers">
                                    <p class="card-category"> Approval SPKL </p>
                                    <h4 class="card-title py-1"> 
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

            <div class="col-6 d-block d-sm-none">
               <a href="{{route('hrd.absence.approval')}}">
                  <div class="card card-primary card-stats card-round">
                     <div class="card-body ">
                        <div class="row align-items-center">
                           
                           <div class="col col-stats ml-3 ml-sm-0">
                              
                                 <div class="numbers">
                                    <p class="card-category"> Approval Form Cuti/SPT/Izin  </p>
                                    <h4 class="card-title py-1"> 
                                       @if (count($absenceApprovals) > 0)
                                       <div class="badge badge-danger">{{count($absenceApprovals)}}</div>
                                       @else
                                       {{count($absenceApprovals)}}
                                    @endif
                                    </h4>
                                 </div>
                              
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
            </div>

            
         </div>

         <div class="row">
            
            <div class="col">
               <div class="card d-block d-sm-none">
                  <div class="card-header bg-light border p-2">
                     <small class="text-uppercase"> <b># Cuti {{$employee->department->name}}</b> </small>
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
         

         






         <div class="row">
            <div class="col-md-6 d-none d-md-block">
               <div class="card border card-stats card-round">
                  <div class="card-body ">
                     <div class="row align-items-center">
                        <div class="col-icon">
                           <div class="icon-big text-center icon-info bubble-shadow-small">
                              <i class="fas fa-calendar-check"></i>
                           </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                           <a href="{{route('hrd.spkl')}}">
                           <div class="numbers">
                              <p class="card-category"> Approval SPKL </p>
                              <h4 class="card-title"> 
                                 @if (count($spklApprovals) > 0)
                                     <div class="badge badge-danger">{{count($spklApprovals)}}</div>
                                     @else
                                     {{count($spklApprovals)}}
                                 @endif
                              </h4>
                           </div>
                        </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 d-none d-md-block">
               <div class="card border card-stats card-round">
                  <div class="card-body ">
                     <div class="row align-items-center">
                        <div class="col-icon">
                           <div class="icon-big text-center icon-info bubble-shadow-small">
                              <i class="fas fa-calendar-check"></i>
                           </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                           <a href="{{route('hrd.absence.approval')}}">
                           <div class="numbers">
                              <p class="card-category"> Approval Form Cuti/SPT/Izin </p>
                              <h4 class="card-title"> 
                                 @if (count($absenceApprovals) > 0)
                                     <div class="badge badge-danger">{{count($absenceApprovals)}}</div>
                                     @else
                                     {{count($absenceApprovals)}}
                                 @endif
                              </h4>
                           </div>
                        </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            
            
         </div>

         

            

            <div class="card">
               <div class="card-header p-2 bg-primary text-white">
                  <small>Recent Absence</small>
               </div>
               <div class="card-body p-0">
                  <div class="table-responsive overflow-auto" style="max-height: 300px">
                     <table class="display  table-sm table-bordered   ">
                        <thead>
                           <tr>
                              {{-- <th class="text-center" style="width: 30px">No</th> --}}
                              {{-- @if (auth()->user()->hasRole('Administrator'))
                              <th>ID</th>
                              @endif --}}
                              {{-- <th class="text-center">#</th> --}}
                              <th>NIK</th>
                              <th>Name</th>
                              <th>Type</th>
         
                              <th>Date</th>
                              
                              {{-- <th>Status</th> --}}
                           </tr>
                        </thead>
                        
                        <tbody>
                           @foreach ($recentAbsences as $abs)
                               <tr>
                                 {{-- <td class="text-center">{{++$i}}</td> --}}
                                 <td>{{$abs->employee->nik}} </td>
                                 <td>{{$abs->employee->biodata->fullName()}}</td>
                                 
                                 <td><x-status.absence :absence="$abs" /></td>
                                 <td>{{formatDate($abs->date)}}</td>
                               </tr>
                           @endforeach
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