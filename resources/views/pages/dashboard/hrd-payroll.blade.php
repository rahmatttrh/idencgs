
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

            <a href="{{route('hrd.absence')}}" class="btn btn-block btn-primary">Monitoring Form Absensi</a>
            <hr>
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
                           <h4 class="card-title">{{count($reqBackupForms)}}</h4>
                        </div>
                     </a>
                     </div>
                  </div>
               </div>
               <div class="card-body">
                  <small>Daftar Cuti yang memiliki relasi terhadap anda sebagai Karyawan Pengganti</small>
               </div>
            </div>
            {{-- <div class="card card-stats card-round">
               <div class="card-body ">
                  <div class="row align-items-center">
                     
                     <div class="col col-stats ml-3 ml-sm-0">
                        <a href="{{route('hrd.absence')}}">
                        <div class="numbers">
                           <p class="card-category"> Monitoring Request Absensi </p>
                           <h4 class="card-title">{{count($reqForms)}}</h4>
                        </div>
                     </a>
                     </div>
                  </div>
               </div>
            </div> --}}

            
           

            {{-- <span>Hari Libur {{$month}}</span> 
            <hr>
            @foreach ($holidays as $holi)
                <span class="badge badge-primary">{{formatDateDay($holi->date)}}</span>
            @endforeach --}}
            
         </div>
         <div class="col-sm-6 col-md-9">
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

            <div class="card">
               <div class="card-header p-2 bg-primary text-white">
                  <small>Recent Transaction</small>
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
                              <th class="text-center">#</th>
                              <th>Unit</th>
                              <th>Month</th>
                              
                              
                              <th>Year</th>
                              <th class="text-right">Total</th>
                              
                              <th class="text-center">Status</th>
                           </tr>
                        </thead>
                        
                        <tbody>
                           @foreach ($unitTransactions as $trans)
                               <tr>
                                 <td class="text-center">{{++$i}}</td>
                                 <td><a href="{{route('payroll.transaction.monthly.all', enkripRambo($trans->id))}}">{{$trans->unit->name}}</a></td>
                                 <td>{{$trans->month}}</td>
                                 <td>{{$trans->year}}</td>
                                 <td class="text-right">{{formatRupiahB($trans->total_salary)}}</td>
                                 <td class="text-center">
                                    <x-status.unit-transaction :unittrans="$trans" />
                                 </td>
                               </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>

            <div class="card">
               <div class="card-header p-2 bg-primary text-white">
                  <small>Daftar Karyawan yang belum di Setup Payroll  <b>({{count($emptyPayroll)}})</b></small>
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
                              <th>Unit</th>
         
                              <th>Department</th>
                              
                              {{-- <th>Status</th> --}}
                           </tr>
                        </thead>
                        
                        <tbody>
                           @foreach ($emptyPayroll as $empty)
                               <tr>
                                 {{-- <td class="text-center">{{++$i}}</td> --}}
                                 <td>{{$empty->nik}} </td>
                                 <td><a href="{{route('payroll.detail', enkripRambo($empty->id))}}">{{$empty->biodata->fullName()}}</a></td>
                                 
                                 <td>{{$empty->unit->name}}</td>
                                 <td>{{$empty->department->name}}</td>
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