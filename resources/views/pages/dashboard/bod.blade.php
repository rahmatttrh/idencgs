
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
                  <img src="{{asset('img/flaticon/hello.png')}}" alt="" width="45px">
               </div>
               <div >
                  Welcome back, Mr. {{auth()->user()->name}}
               </div>
            
            
           
            
            
         </h5>
      </div>
      <div class="row">
        
         <div class="col-md-4">
            <div class="card card-primary">
               <div class="card-body " >
                  <b>Dashboard BOD</b>
                  <hr class="bg-white">
                  
                  @if (count($employee->positions) > 0)
                        @foreach ($positions as $pos)
                         <b>{{$pos->department->unit->name ?? '-'}} {{$pos->department->name ?? '-'}} </b> <br>
                        <small class="">{{$pos->name}}</small>
                        <br>
                        {{-- <div class="row">
                           <div class="col-md-4">
                              {{$pos->department->name}} 
                           </div>
                           <div class="col">
                              {{$pos->name}}
                           </div>
                        </div> --}}
                           {{-- <small>- {{$pos->name}}</small> <br> --}}
                        @endforeach
   
                      @else
                      <b>{{$employee->unit->name ?? '-'}} - {{$employee->department->name}}</b><br>
                      @if ($employee->position->type == 'subdept')
                          {{$employee->sub_dept->name}} 
                          <hr>
                      @endif
                      
                     <small>{{$employee->position->name}}</small>
                  @endif
                  
               </div>
            </div>

            {{-- <div class="row">
               <div class="col-md-12">
                  <a href="{{route('payroll.approval.bod')}}">
                     <div class="card card-stats card-round border">
                        <div class="card-body">
                           <div class="row align-items-center">
                              <div class="col-icon ">
                                 <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="far fa-newspaper"></i>
                                 </div>
                              </div>
                              <div class="col col-stats ml-3 ml-sm-0">
                                 <div class="numbers">
                                    <p class="card-category">Payslip Approval</p>
                                    <h4 class="card-title">
                                       @if (count($payrollApprovals) > 0)
                                           <div class="badge badge-danger">{{count($payrollApprovals)}}</div>
                                           @else
                                           {{count($payrollApprovals)}}
                                       @endif
                                      
                                    </h4>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </a>
               </div>
            </div> --}}
            
            
            {{-- <a href="{{route('payroll.approval.hrd')}}">
               <div class="card card-stats card-primary card-round">
                  <div class="card-body">
                     <div class="row">
                        <div class="col-3">
                           <div class="icon-big text-center">
                              <i class="flaticon-interface-6"></i>
                           </div>
                        </div>
                        <div class="col col-stats">
                           <div class="numbers">
                              <p class="card-category">Payslip Approval</p>
                              <h4 class="card-title">{{count($payrollApprovals)}}</h4>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </a> --}}
            <div class="row d-none d-md-block">
               <div class="col">
                  <div class="card">
                     <div class="card-header d-flex justify-content-between p-2 bg-primary text-white">
                        <small>Monitoring</small>
                     </div>
                     <div class="card-body p-0">
                        <table class="display  table-sm table-bordered">
                           <thead>
                              <tr>
                                 <th colspan="2">Employee</th>
                                 <th colspan="2">QPE</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td>Kontrak</td>
                                 <td class="text-center">{{$kontrak}}</td>
                                 <td>Draft</td>
                                 <td class="text-center">{{count($pes->where('status', 0))}}</td>
                              </tr>
                              <tr>
                                 <td>Tetap</td>
                                 <td class="text-center">{{$tetap}}</td>
                                 <td>Progress</td>
                                 <td class="text-center">{{count($pes->where('status', 1))}}</td>
                              </tr>
                              <tr>
                                 <td class="text-muted">Nonactive</td>
                                 <td class="text-center text-muted">{{count($employees->where('status', 3))}}</td>
                                 <td>Done</td>
                                 <td class="text-center">{{count($pes->where('status', 2))}}</td>
                              </tr>
                              <tr>
                                 <td>Total Active</td>
                                 <td class="text-center">{{count($employees->where('status', '!=', 3))}}</td>
                                 <td>Total</td>
                                 <td class="text-center">{{count($pes)}}</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               {{-- <div class="col">
                  <div class="card">
                     <div class="card-header d-flex justify-content-between p-2 bg-primary text-white">
                        <small>QPE</small>
                     </div>
                     <div class="card-body p-0">
                        <table class="display  table-sm table-bordered  ">
                           <thead>
                              <tr>
                                 <th colspan="2">Monitoring</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td>Draft</td>
                                 <td>{{count($pes->where('status', 0))}}</td>
                              </tr>
                              <tr>
                                 <td>Porgress</td>
                                 <td>{{count($pes->where('status', 1))}}</td>
                              </tr>
                              <tr>
                                 <td>Done</td>
                                 <td>{{count($pes->where('status', 2))}}</td>
                              </tr>
                              <tr>
                                 <td>Total</td>
                                 <td>{{count($pes)}}</td>
                              </tr>
                              
                              
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div> --}}
            </div>
            
            {{-- <div class="card">
               <div class="card-header bg-primary text-white p-2">
                  <small>Employee</small>
               </div>
               <div class="card-body p-0">
                  <table class=" ">
                     <tbody>
                        @if (count($employee->positions) > 0)
                              @foreach ($positions as $pos)
                                    <tr>
                                    <td colspan="4">{{$pos->department->unit->name}} {{$pos->department->name}} ({{count($pos->department->employees)}}) </td>
                              
                                    </tr>
                                    @foreach ($pos->department->employees->where('status', 1) as $emp)
                                       <tr>
                                       <td></td>
                                       <td>{{$emp->nik}} {{$emp->id}}</td>
                                       </tr>
                                    @endforeach
                              @endforeach
                            @else
                            @foreach ($teams as $team)
                                 @if ($team->employee->status == 1)
                                 <tr>
                                    <td>{{$team->employee->nik}} </td>
                                    <td> {{$team->employee->biodata->fullName()}}</td>
                                 </tr>
                                 @endif
                                 
                           @endforeach    
                        @endif
                        
                        
                        
                     </tbody>
                  </table>
               </div>
            </div> --}}
         </div>
         <div class="col-md-8">
            <div class="row">
               <div class="col-md-6 ">
                  <a href="{{route('leader.absence')}}" data-toggle="tooltip" data-placement="top" title="Daftar Form Absensi yang membutuhkan Approval anda">
                     <div class="card border card-stats card-round">
                        <div class="card-body ">
                           <div class="row align-items-center">
                              <div class="col-icon">
                                 <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-calendar-check"></i>
                                 </div>
                              </div>
                              <div class="col col-stats ml-3 ml-sm-0">
                                 
                                 <div class="numbers">
                                    <p class="card-category"> Approval Absensi </p>
                                    <h4 class="card-title"> 
                                       @if (count($reqForms) > 0)
                                          <span class="badge badge-danger">{{count($reqForms) }}</span> 
                                          @else
                                          {{count($reqForms)}}
                                          @endif 
                                    </h4>
                                 </div>
                              
                              </div>
                           </div>
                        </div>
                     </div>
                  </a>
               </div>
               <div class="col-md-6 ">
                  <a href="{{route('payroll.approval.bod')}}">
                     <div class="card card-stats card-round border">
                        <div class="card-body">
                           <div class="row align-items-center">
                              <div class="col-icon ">
                                 <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="far fa-newspaper"></i>
                                 </div>
                              </div>
                              <div class="col col-stats ml-3 ml-sm-0">
                                 <div class="numbers">
                                    <p class="card-category">Payslip Approval</p>
                                    <h4 class="card-title">
                                       @if (count($payrollApprovals) > 0)
                                           <div class="badge badge-danger">{{count($payrollApprovals)}}</div>
                                           @else
                                           {{count($payrollApprovals)}}
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
            
            {{-- <div class="row">
               <div class="col-md-6">
                  <a href="{{route('payroll.approval.bod')}}">
                     <div class="card card-stats card-round border">
                        <div class="card-body">
                           <div class="row align-items-center">
                              <div class="col-icon ">
                                 <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="far fa-newspaper"></i>
                                 </div>
                              </div>
                              <div class="col col-stats ml-3 ml-sm-0">
                                 <div class="numbers">
                                    <p class="card-category">Payslip Approval</p>
                                    <h4 class="card-title">{{count($payrollApprovals)}}</h4>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </a>
               </div>
            </div> --}}

            <div class="row d-block d-sm-none">
               <div class="col">
                  <div class="card">
                     <div class="card-header d-flex justify-content-between p-2 bg-primary text-white">
                        <small>Monitoring</small>
                     </div>
                     <div class="card-body p-0">
                        <table class="display  table-sm table-bordered">
                           <thead>
                              <tr>
                                 <th colspan="2">Employee</th>
                                 <th colspan="2">QPE</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td>Kontrak</td>
                                 <td class="text-center">{{$kontrak}}</td>
                                 <td>Draft</td>
                                 <td class="text-center">{{count($pes->where('status', 0))}}</td>
                              </tr>
                              <tr>
                                 <td>Tetap</td>
                                 <td class="text-center">{{$tetap}}</td>
                                 <td>Progress</td>
                                 <td class="text-center">{{count($pes->where('status', 1))}}</td>
                              </tr>
                              <tr>
                                 <td class="text-muted">Nonactive</td>
                                 <td class="text-center text-muted">{{count($employees->where('status', 3))}}</td>
                                 <td>Done</td>
                                 <td class="text-center">{{count($pes->where('status', 2))}}</td>
                              </tr>
                              <tr>
                                 <td>Total Active</td>
                                 <td class="text-center">{{count($employees->where('status', '!=', 3))}}</td>
                                 <td>Total</td>
                                 <td class="text-center">{{count($pes)}}</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               {{-- <div class="col">
                  <div class="card">
                     <div class="card-header d-flex justify-content-between p-2 bg-primary text-white">
                        <small>QPE</small>
                     </div>
                     <div class="card-body p-0">
                        <table class="display  table-sm table-bordered  ">
                           <thead>
                              <tr>
                                 <th colspan="2">Monitoring</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td>Draft</td>
                                 <td>{{count($pes->where('status', 0))}}</td>
                              </tr>
                              <tr>
                                 <td>Porgress</td>
                                 <td>{{count($pes->where('status', 1))}}</td>
                              </tr>
                              <tr>
                                 <td>Done</td>
                                 <td>{{count($pes->where('status', 2))}}</td>
                              </tr>
                              <tr>
                                 <td>Total</td>
                                 <td>{{count($pes)}}</td>
                              </tr>
                              
                              
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div> --}}
            </div>
            
            <div class="card shadow-none border">
                
                
               <div class="card-body p-0">
                 <div class="table-responsive">
                    <table>
                       <thead>
                          <tr>
                             <th rowspan="2">BSU</th>
                             <th rowspan="2" class="text-center">Total Karyawan</th>
                             <th colspan="4" class="text-center">QPE</th>
                             
                          </tr>
                          <tr>
                             
                             <th class="text-center">Draft</th>
                             <th class="text-center">Verifikasi</th>
                             <th class="text-center">Done</th>
                             <th class="text-center">Empty</th>
                          </tr>
                       </thead>
                       <tbody>
                          @foreach ($units as $unit)
                              <tr>
                                <td><a href="{{route('qpe.report.unit', [enkripRambo($unit->id),enkripRambo($semester),enkripRambo($year)])}}">{{$unit->name}}</a></td>
                                <td class="text-center">{{count($unit->getEmployeeQpe($semester, $year, 0))}}</td>
                                <td class="text-center">{{$unit->getAllQpe(0)}}</td>
                                <td class="text-center">{{$unit->getAllQpe(1)}}</td>
                                <td class="text-center">{{$unit->getAllQpe(2)}}</td>
                                <td class="text-center">{{$unit->getEmptyQpe($semester, $year)}}</td>
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