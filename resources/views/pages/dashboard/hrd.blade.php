
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
               Welcome back, {{auth()->user()->getGender()}} {{auth()->user()->name}}
            </div>
            
            
         </h5>
      </div>
      

      <div class="row">
        
         <div class="col-md-3">
            <div class="card card-primary">
               {{-- <div class="card-header">
                  Dashboard SPV
               </div> --}}
               <div class="card-body">
                  {{-- <span class="badge badge-dark">Level :</span> --}}
                  <x-role />
                  <br>
                  <br>
                  
                  {{-- Dashboard HRD <hr class="bg-white"> --}}
                  <h3><b class="">{{$employee->unit->name}}</b> {{$employee->department->name}}</h3>
                     
                   
                  {{$employee->position->name}}
                  
                  {{-- @if (auth()->user()->hasRole('HRD'))
                     HRD
                  @endif
                  @if (auth()->user()->hasRole('Supervisor'))
                     SPV
                  @endif --}}
               </div>
            </div>


            <div class="row d-none d-sm-block">
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
                        @foreach ($myEmployees as $emp)
                        <tr>
                           
                           <td> {{$emp->biodata->fullName()}}</td>
                        </tr>
                            
                        @endforeach
                        
                        
                        
                     </tbody>
                  </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-9">
            {{-- <x-running-text /> --}}

            {{-- Mobile View --}}

            <div class="row">
               <div class="col-6 d-block d-sm-none">
                  <a href="{{route('payroll.approval.hrd')}}">
                     <div class="card card-info card-stats card-round">
                        <div class="card-body ">
                           <div class="row align-items-center">
                              
                              <div class="col col-stats ml-3 ml-sm-0">
                                 
                                 {{-- <a href="{{route('leader.absence')}}"> --}}
                                    <div class="numbers">
                                       <p class="card-category"> Payslip </p>
                                       <h4 class="card-title py-1">
                                          @if (count($payrollApprovals) > 0)
                                             <div class="badge badge-light">{{count($payrollApprovals)}}</div>
                                             @else
                                             {{count($payrollApprovals)}}
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

               <div class="col-6 d-block d-sm-none">
                  <a href="{{route('qpe.verification')}}">
                     <div class="card card-primary card-stats card-round">
                        <div class="card-body ">
                           <div class="row align-items-center">
                              
                              <div class="col col-stats ml-3 ml-sm-0">
                                 
                                 {{-- <a href="{{route('leader.absence')}}"> --}}
                                    <div class="numbers">
                                       <p class="card-category"> PE </p>
                                       <h4 class="card-title py-1">
                                          @if (count($peApprovals) > 0)
                                          <div class="badge badge-light">{{count($peApprovals)}}</div>
                                          @else
                                          {{count($peApprovals)}}
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

               <div class="col-6 d-block d-sm-none">
                  <a href="#">
                     <div class="card card-danger card-stats card-round">
                        <div class="card-body ">
                           <div class="row align-items-center">
                              
                              <div class="col col-stats ml-3 ml-sm-0">
                                 
                                 {{-- <a href="{{route('leader.absence')}}"> --}}
                                    <div class="numbers">
                                       <p class="card-category"> SP </p>
                                       <h4 class="card-title py-1">
                                          @if (count($spApprovals) > 0)
                                           <div class="badge badge-light">{{count($spApprovals)}}</div>
                                           @else
                                           {{count($spApprovals)}}
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

               <div class="col-6 d-block d-sm-none">
                  <a href="{{route('leader.absence')}}">
                     <div class="card card-info card-stats card-round">
                        <div class="card-body ">
                           <div class="row align-items-center">
                              
                              <div class="col col-stats ml-3 ml-sm-0">
                                 
                                 {{-- <a href="{{route('leader.absence')}}"> --}}
                                    <div class="numbers">
                                       <p class="card-category"> Absensi</p>
                                       <h4 class="card-title py-1">
                                          @if (count($reqForms) > 0)
                                             <div class="badge badge-light">
                                                {{count($reqForms) }}
                                             </div>
                                             @else
                                             {{count($reqForms) }}
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

               <div class="col-6 d-block d-sm-none">
                  <a href="{{route('hrd.spkl')}}">
                     <div class="card card-primary card-stats card-round">
                        <div class="card-body ">
                           <div class="row align-items-center">
                              
                              <div class="col col-stats ml-3 ml-sm-0">
                                 
                                 {{-- <a href="{{route('leader.absence')}}"> --}}
                                    <div class="numbers">
                                       <p class="card-category"> SPKL</p>
                                       <h4 class="card-title py-1">
                                          @if (count($spklApprovals) > 0)
                                              <div class="badge badge-light">{{count($spklApprovals)}}</div>
                                              @else
                                              {{count($spklApprovals)}}
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

               <div class="col-6 d-block d-sm-none">
                  <a href="{{route('contract.alert')}}">
                     <div class="card card-secondary card-stats card-round">
                        <div class="card-body ">
                           <div class="row align-items-center">
                              
                              <div class="col col-stats ml-3 ml-sm-0">
                                 
                                 {{-- <a href="{{route('leader.absence')}}"> --}}
                                    <div class="numbers">
                                       <p class="card-category"> Contract</p>
                                       <h4 class="card-title py-1">
                                          @if (count($notifContracts) > 0)
                                           <div class="badge badge-light">
                                             {{count($notifContracts)}}
                                           </div>
                                           @else
                                           {{count($notifContracts)}}
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
            </div>

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
            
            <div class="card d-block d-sm-none">
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
                                       <td>{{$emp->nik}} {{$emp->id}}</td>
                                       </tr>
                                    @endforeach
                              @endforeach
                            @else
                            @foreach ($teams as $team)
                                 @if ($team->employee->status == 1)
                                 <tr>
                                    {{-- <td>{{$team->employee->nik}} </td> --}}
                                    <td>
                                       <a href="{{route('employee.overview.simple', enkripRambo($team->employee_id))}}">{{$team->employee->biodata->fullName()}}</a>
                                       
                                       </td>
                                 </tr>
                                 @endif
                                 
                           @endforeach    
                        @endif
                        
                        
                        
                     </tbody>
                  </table>
                  </div>
               </div>
            </div>

            {{-- End Mobile View --}}








            <div class="row ">
               <div class="col-6 col-md-4  d-none d-sm-block">
                  <a href="{{route('payroll.approval.hrd')}}" data-toggle="tooltip" data-placement="top" title="Daftar Payslip Report yang membutuhkan Approval anda">
                     <div class="card card-stats card-round border">
                        <div class="card-body">
                           <div class="row align-items-center">
                              <div class="col-icon d-none d-md-block">
                                 <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fa fa-money-bill"></i>
                                 </div>
                              </div>
                              <div class="col col-stats ml-3 ml-sm-0">
                                 <div class="numbers">
                                    <p class="card-category">Payslip</p>
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

               <div class="col-6 col-md-4  d-none d-sm-block">
                  <a href="{{route('qpe.verification')}}" data-toggle="tooltip" data-placement="top" title="Daftar PE yang membutuhkan Approval anda">
                     <div class="card card-stats card-round border">
                        <div class="card-body">
                           <div class="row align-items-center">
                              <div class="col-icon d-none d-md-block">
                                 <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-star"></i>
                                 </div>
                              </div>
                              <div class="col col-stats ml-3 ml-sm-0">
                                 
                                 <div class="numbers">
                                    <p class="card-category">PE</p>
                                    <h4 class="card-title">
                                       @if (count($peApprovals) > 0)
                                          <div class="badge badge-danger">{{count($peApprovals)}}</div>
                                          @else
                                          {{count($peApprovals)}}
                                       @endif
                                    </h4>
                                 </div>
                                 
                              </div>
                           </div>
                        </div>
                     </div>
                  </a>
                  
               </div>
               <div class="col-6 col-md-4  d-none d-sm-block">
                  <a href="{{route('sp.approval.hrd')}}" data-toggle="tooltip" data-placement="top" title="Daftar SP dari User yang membutuhkan Approval anda">
                     <div class="card card-stats card-round border">
                        <div class="card-body">
                           <div class="row align-items-center">
                              <div class="col-icon d-none d-md-block">
                                 <div class="icon-big text-center icon-danger bubble-shadow-small">
                                    <i class="fas fa-bolt"></i>
                                 </div>
                              </div>
                              <div class="col col-stats ml-3 ml-sm-0">
                                 <div class="numbers">
                                    <p class="card-category">SP & Teguran</p>
                                    <h4 class="card-title">
                                       @if (count($spApprovals) + count($stApprovals) > 0)
                                           <div class="badge badge-danger">{{count($spApprovals) + count($stApprovals)}}</div>
                                           @else
                                           {{count($spApprovals)}}
                                       @endif
                                    </h4>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     
                  </a>
               </div>
               <div class="col-6 col-md-4  d-none d-sm-block">
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
                     {{-- <div class="card card-stats card-primary card-round">
                        <div class="card-body">
                           <div class="row">
                              <div class="col-3">
                                 <div class="icon-big text-center">
                                    <i class="flaticon-interface-6"></i>
                                 </div>
                              </div>
                              <div class="col col-stats">
                                 <div class="numbers">
                                    <p class="card-category">Payroll</p>
                                    <h4 class="card-title">{{count($payrollApprovals)}}</h4>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div> --}}
                  </a>
               </div>
               <div class="col-md-4 d-none d-sm-block">
                  <a href="{{route('leader.absence')}}" data-toggle="tooltip" data-placement="top" title="Daftar Form Absensi Department HRD yang membutuhkan Approval anda">
                     <div class="card card-stats card-round border">
                        <div class="card-body ">
                           <div class="row align-items-center">
                              <div class="col-icon">
                                 <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                 </div>
                              </div>
                              <div class="col col-stats ml-3 ml-sm-0">
                                 
                                    <div class="numbers">
                                       <p class="card-category">Absensi Team</p>
                                       <h4 class="card-title">
                                          @if (count($reqForms) > 0)
                                             <div class="badge badge-danger">
                                                {{count($reqForms) }}
                                             </div>
                                             @else
                                             {{count($reqForms) }}
                                          @endif
                                          
                                       </h4>
                                    </div>
                                 
                              </div>
                              
                           </div>
                        </div>
                        {{-- <div class="card-body">
                           <small>Melihat Request Absensi Cuti, SPT, dan lainnya yang memiliki relasi terhadap anda sebagai pengganti maupun sebagai atasan</small>
                        </div> --}}
                     </div>
                  </a>
                  
               </div>
               <div class="col-6 col-md-4  d-none d-sm-block">
                  <a href="{{route('leader.spkl')}}" data-toggle="tooltip" data-placement="top" title="Daftar Form SPKL Karyawan yang membutuhkan Approval anda">
                     <div class="card card-stats card-round border">
                        <div class="card-body">
                           <div class="row align-items-center">
                              <div class="col-icon d-none d-md-block">
                                 <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fa fa-clock"></i>
                                 </div>
                              </div>
                              <div class="col col-stats ml-3 ml-sm-0">
                                 
                                    <div class="numbers">
                                       <p class="card-category"> SPKL Team </p>
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
               
               

               
      
               {{-- <div class="col-6 col-md-4  d-none d-sm-block">
      
                  <a href="{{route('payroll.absence.approval')}}">
                     <div class="card card-stats card-round border">
                        <div class="card-body">
                           <div class="row align-items-center">
                              <div class="col-icon d-none d-md-block">
                                 <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="far fa-newspaper"></i>
                                 </div>
                              </div>
                              <div class="col col-stats ml-3 ml-sm-0">
                                 <div class="numbers">
                                    <p class="card-category">Absence</p>
                                    <h4 class="card-title">{{count($absenceApprovals)}}</h4>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                    
                  </a>
               </div> --}}

               
      
              
              
            </div>
            
            
            <div class="card " >
               <div class="card-header d-flex justify-content-between p-2 bg-primary text-white">
                  <small>Latest QPE</small>
                  <a href="{{route('qpe')}}" class="text-white">more...</a>
               </div>
               <div class="card-body p-0 " >
                  <div class="table-responsive overflow-auto" style="height: 150px">
                     <table class="" >
                        <thead>
                           
                           <tr class="">
                              {{-- <th scope="col">#</th> --}}
                              {{-- <th></th> --}}
                              <th>Employee</th>
                              <th>Semester</th>
                              <th>Achievement</th>
                              <th>Status</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($recentPes as $pe)
                              <tr>
                                 {{-- <th></th> --}}
                                 <td>
                                    {{-- <a href="{{route('sp.detail', enkripRambo($pe->id))}}">{{$pe->code}}</a> --}}
                                    @if($pe->status == '0' || $pe->status == '101')
                                    <a href="/qpe/edit/{{enkripRambo($pe->kpa->id)}}">{{$pe->employe->nik}} {{$pe->employe->biodata->fullName()}} </a>
                                    @elseif($pe->status == '1' || $pe->status == '202' )
                                    <a href="/qpe/approval/{{enkripRambo($pe->kpa->id)}}">{{$pe->employe->nik}} {{$pe->employe->biodata->fullName()}} </a>
                                    @else
                                    <a href="/qpe/show/{{enkripRambo($pe->kpa->id)}}">{{$pe->employe->nik}} {{$pe->employe->biodata->fullName()}} </a>
                                    @endif
                                 </td>
                                 <td>{{$pe->semester}} / {{$pe->tahun}}</td>
                                 <td>{{$pe->achievement}}</td>
                                 <td>
                                    <x-status.pe :pe="$pe" />
                                 </td>
                              </tr>
                              @endforeach
      
                        </tbody>
                     </table>
                  </div>
               </div>
               {{-- <div class="card-footer">
                  <small class="text-muted">*Ini adalah 8 data QPE terkini, klik <a href="{{route('qpe')}}">Disini</a> untuk melihat seluruh data QPE.</small>
               </div> --}}
            </div>
           
            <div class="card">
               <div class="card-header p-2 bg-danger text-white">
                  <small>Latest SP</small>
               </div>
               <div class="card-body p-0">
                  <div class="table-responsive overflow-auto" style="height: 150px">
                     <table class="display  table-sm table-bordered  table-striped ">
                        <thead>
                           
                           <tr>
                              <th>ID</th>
                              <th scope="col">Level</th>
                              <th>NIK</th>
                              <th scope="col" >Name</th>
                              {{-- <th>Unit</th>
                              <th>Department</th> --}}
                              <th>Status</th>
                           </tr>
                           
                        </thead>
                        <tbody>
                           @if (count($sps) > 0)
                              @foreach ($sps as $sp)
                              <tr>
                                 <td><a href="{{route('sp.detail', enkripRambo($sp->id))}}">{{$sp->code}}</a></td>
                                 <td>SP {{$sp->level}}</td>
                                 <td>{{$sp->employee->nik}}</td>
                                 <td>{{$sp->employee->biodata->fullName()}}</td>
                                 <td><x-status.sp :sp="$sp" /> </td>
                              </tr>
                              @endforeach
                              @else
                              <tr>
                                 <td colspan="5" class="text-center">Empty</td>
                              </tr>
                           @endif
                           
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>

            {{-- <div class="card">
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
            </div> --}}
            
            
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