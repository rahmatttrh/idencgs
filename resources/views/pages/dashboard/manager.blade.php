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
         {{-- <div class="btn btn-primary btn-block">Manager</div>
         <hr> --}}
         {{-- <div class="d-block d-sm-none">
            <div class="alert alert-info shadow-sm">

                  <div class="card-opening">
                     <h4>
                        <img src="{{asset('img/flaticon/promote.png')}}" height="28" alt="" class="mr-1">
                        <b>Announcement</b>
                     </h4>
                  </div>
                  <hr>
                  <div class="card-desc">
                     Tanggal 8 & 9 Februari Libur Nasional dan Cuti Bersama
                  </div>
                 
            </div>
         </div> --}}
         {{-- <div class="card card-profile card-secondary ">
            <div class="card-header" style="background-image: url({{asset('img/blogpost.jpg')}})">
               <div class="profile-picture">
                  <div class="avatar avatar-xl">
                     @if ($employee->picture)
                     <img src="{{asset('storage/' . $employee->picture)}}" alt="..." class="avatar-img rounded-circle">
                     @else
                     <img src="{{asset('img/user.png')}}" alt="..." class="avatar-img rounded-circle">
                     @endif</div>
               </div>
            </div>
            <div class="card-body">
               <div class="user-profile text-center">
                  <div class="name">{{$employee->biodata->first_name}} {{$employee->biodata->last_name}}</div>
                  <div class="job">{{$employee->position->name}}</div>
               </div>
               
               
            </div>
            
         </div> --}}
         <div class="card card-primary">
            <div class="card-body " >
               <b>Dashboard Manager</b>
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
         <div class="card d-none d-md-block">
            <div class="card-header bg-primary text-white p-2">
               <small>Teams</small>
            </div>
            <div class="card-body p-0">
               <div class="table-responsive overflow-auto" style="height: 250px">
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
                                          <a href="{{route('employee.overview.simple', enkripRambo($emp->id))}}">{{$emp->biodata->fullName()}}</a>
                                       </td>
                                       </tr>
                                    @endforeach
                              @endforeach
                            @else
                            @foreach ($teams as $emp)
                                 <tr>
                                 <td></td>
                                 {{-- <td>{{$emp->sub_dept->name}}</td> --}}
                                 {{-- <td></td> --}}
                                 <td>
                                    <a href="{{route('employee.overview.simple', enkripRambo($emp->id))}}">{{$emp->biodata->fullName()}}</a>
                                    
                                 </td>
                                 </tr>
                              @endforeach
                        @endif
                        
                        
                        
                     </tbody>
                  </table>
               </div>
               
            </div>
         </div>
      </div>
      <div class="col-md-9">
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
         @endif

         @if (count($personals) > 0)
            @foreach ($personals as $pers)
            <div class="d-none d-sm-block">
               <div class="alert alert-danger shadow-sm">
   
                  <div class="card-opening">
                     <h4><b>Personal Message</b>
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

         
         {{-- <div class="d-none d-sm-block">
            <div class="alert alert-danger shadow-sm">

               <div class="card-opening">
                  <h4>
                     <img src="{{asset('img/flaticon/promote.png')}}" height="28" alt="" class="mr-1">
                     <b>SP Need Approval</b>
                  </h4>
               </div>
               
               <div class="card-desc">
                  @if (count($spManNotifs) > 0)

                     @foreach ($spManNotifs as $spmn)
                     SP {{$spmn->level}} {{$spmn->employee->nik}} {{$spmn->employee->biodata->fullName()}} .
                     <a href="{{route('sp.detail', enkripRambo($spmn->id))}}">Click here</a> to confirm
                      <br>
                     @endforeach

                  @endif
                 
                  <hr>
                     <small class="text-muted">* Kami butuh konfirmasi anda mengenai SP diatas</small>
               </div>
            </div>
         </div>
         @endif --}}

         {{-- Mobile View --}}
         <div class="row ">

            @if (auth()->user()->username == 11304 )
               <div class="col-6 d-block d-sm-none">
                  <a href="{{route('payroll.approval.manfin')}}" data-toggle="tooltip" data-placement="top" title="Daftar Payslip Report yang membutuhkan Approval anda">
                     <div class="card card-info card-stats card-round">
                        <div class="card-body">
                           <div class="row align-items-center">
                              
                              <div class="col col-stats ml-3 ml-sm-0">
                                 <div class="numbers">
                                    <p class="card-category">Payslip</p>
                                    <h4 class="card-title">
                                       @if (count($payrollApprovals) > 0)
                                           <div class="badge badge-light">{{count($payrollApprovals)}}</div>
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
            
            @endif
            @if ( auth()->user()->username == 'EN-2-006')
               <div class="col-6 d-block d-sm-none">
                  <a href="{{route('payroll.approval.gm')}}" data-toggle="tooltip" data-placement="top" title="Daftar Payslip Report yang membutuhkan Approval anda">
                     <div class="card card-info card-stats card-round ">
                        <div class="card-body">
                           <div class="row align-items-center">
                              
                              <div class="col col-stats ml-3 ml-sm-0">
                                 <div class="numbers">
                                    <p class="card-category">Payslip</p>
                                    <h4 class="card-title">
                                       @if (count($payrollApprovals) > 0)
                                           <div class="badge badge-light">{{count($payrollApprovals)}}</div>
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
            @endif


            <div class="col-6 d-block d-sm-none">
               <div class="card card-info card-stats card-round">
                  <div class="card-body ">
                     <div class="row align-items-center">
                        
                        <div class="col col-stats ml-3 ml-sm-0">
                           <a href="{{route('leader.absence')}}">
                              <div class="numbers">
                                 <p class="card-category">Absensi </p>
                                 <h4 class="card-title"> 
                                    @if (count($reqForms) > 0)
                                    <span class="badge badge-light">{{count($reqForms) }}</span> 
                                    @else
                                    {{count($reqForms)}}
                                    
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
               <div class="card card-primary card-stats card-round">
                  <div class="card-body ">
                     <div class="row align-items-center">
                        
                        <div class="col col-stats ml-3 ml-sm-0">
                           <a href="{{route('leader.spkl')}}">
                              <div class="numbers">
                                 <p class="card-category"> Approval SPKL </p>
                                 <h4 class="card-title"> 
                                    @if (count($teamSpkls) > 0)
                                    <span class="badge badge-light">{{count($teamSpkls) }}</span> 
                                    @else
                                    {{count($teamSpkls) }}
                                    
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
               <div class="card card-secondary card-stats card-round">
                  <div class="card-body ">
                     <div class="row align-items-center">
                        
                        <div class="col col-stats ml-3 ml-sm-0">
                           <a href="{{route('qpe.verification')}}">
                           <div class="numbers">
                              <p class="card-category"> Approval PE </p>
                              <h4 class="card-title">
                                 @if ($peTotal > 0)
                                     <div class="badge badge-light">
                                       {{$peTotal }}
                                     </div>
                                     @else
                                     0
                                     
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
               <div class="card card-danger card-stats card-round">
                  <div class="card-body ">
                     <div class="row align-items-center">
                        
                        <div class="col col-stats ml-3 ml-sm-0">
                           <a href="{{route('sp.manager.approval')}}">
                              <div class="numbers">
                                 <p class="card-category"> Approval SP </p>
                                 <h4 class="card-title">
                                    @if (count($spApprovals) > 0)
                                        <div class="badge badge-light">
                                          {{count($spApprovals) }}
                                        </div>
                                        @else
                                        
                                        {{count($spApprovals) }}
                                    @endif
                                 </h4>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            

            {{-- <div class="col-6 d-block d-sm-none">
               <div class="card ">
                  <div class="card-header bg-primary text-white p-2">
                     <small>Team</small>
                  </div>
                  <div class="card-body p-0">
                     <div class="table-responsive overflow-auto" style="height: 70px">
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
                                            
                                             <td>
                                                <a href="{{route('employee.overview.simple', enkripRambo($emp->id))}}">{{$emp->biodata->fullName()}}</a>
                                             </td>
                                             </tr>
                                          @endforeach
                                    @endforeach
                                  @else
                                  @foreach ($teams as $emp)
                                       <tr>
                                       <td></td>
                                      
                                       <td>
                                          <a href="{{route('employee.overview.simple', enkripRambo($emp->id))}}">{{$emp->biodata->fullName()}}</a>
                                          
                                       </td>
                                       </tr>
                                    @endforeach
                              @endif
                              
                              
                              
                           </tbody>
                        </table>
                     </div>
                     
                  </div>
               </div>
            </div> --}}
         </div>

         <div class="card d-block d-sm-none">
            <div class="card-header bg-primary text-white p-2">
               <small>Teams</small>
            </div>
            <div class="card-body p-0">
               <div class="table-responsive overflow-auto" style="height: 250px">
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
                                          <a href="{{route('employee.overview.simple', enkripRambo($emp->id))}}">{{$emp->biodata->fullName()}}</a>
                                       </td>
                                       </tr>
                                    @endforeach
                              @endforeach
                            @else
                            @foreach ($teams as $emp)
                                 <tr>
                                 <td></td>
                                 {{-- <td>{{$emp->sub_dept->name}}</td> --}}
                                 {{-- <td></td> --}}
                                 <td>
                                    <a href="{{route('employee.overview.simple', enkripRambo($emp->id))}}">{{$emp->biodata->fullName()}}</a>
                                    
                                 </td>
                                 </tr>
                              @endforeach
                        @endif
                        
                        
                        
                     </tbody>
                  </table>
               </div>
               
            </div>
         </div>


         {{-- End Mobile View --}}

         
         <div class="row">
            <div class="col-md-4 d-none d-md-block">
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
            <div class="col-md-4 d-none d-md-block">
               <a href="{{route('leader.spkl')}}" data-toggle="tooltip" data-placement="top" title="Daftar Form SPKL yang membutuhkan Approval anda">
                  <div class="card border card-stats card-round">
                     <div class="card-body ">
                        <div class="row align-items-center">
                           <div class="col-icon">
                              <div class="icon-big text-center icon-primary bubble-shadow-small">
                                 <i class="fas fa-clock"></i>
                              </div>
                           </div>
                           <div class="col col-stats ml-3 ml-sm-0">
                              
                              <div class="numbers">
                                 <p class="card-category"> Approval SPKL </p>
                                 <h4 class="card-title"> 
                                    @if (count($teamSpkls) > 0)
                                       <span class="badge badge-danger">{{count($teamSpkls) }}</span> 
                                       @else
                                       {{count($teamSpkls)}}
                                       @endif 
                                 </h4>
                              </div>
                           
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-md-4 d-none d-md-block">
               <a href="{{route('qpe.verification')}}" data-toggle="tooltip" data-placement="top" title="Daftar PE yang membutuhkan Approval anda">
                  <div class="card border card-stats card-round">
                     <div class="card-body ">
                        <div class="row align-items-center">
                           <div class="col-icon">
                              <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                 <i class="fas fa-star"></i>
                              </div>
                           </div>
                           <div class="col col-stats ml-3 ml-sm-0">
                              
                              <div class="numbers">
                                 <p class="card-category"> Approval PE </p>
                                 <h4 class="card-title">
                                    @if ($peTotal > 0)
                                       <div class="badge badge-danger">
                                          {{$peTotal }}
                                       </div>
                                       @else
                                       0
                                    @endif
                                 </h4>
                              </div>
                           
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-md-4 d-none d-md-block">
               <a href="{{route('sp.manager.approval')}}" data-toggle="tooltip" data-placement="top" title="Daftar Form SP yang membutuhkan Approval anda">
                  <div class="card border card-stats card-round">
                     <div class="card-body ">
                        <div class="row align-items-center">
                           <div class="col-icon">
                              <div class="icon-big text-center icon-danger bubble-shadow-small">
                                 <i class="fas fa-bolt"></i>
                              </div>
                           </div>
                           <div class="col col-stats ml-3 ml-sm-0">
                              
                              <div class="numbers">
                                 <p class="card-category"> Approval SP </p>
                                 <h4 class="card-title">
                                    @if (count($spApprovals) > 0)
                                       <div class="badge badge-danger">
                                          {{count($spApprovals) }}
                                       </div>
                                       @else
                                       {{count($spApprovals) }}
                                    @endif
                                 </h4>
                              </div>
                        
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-md-4">
               <div class="card card-stats card-round">
                  <div class="card-body ">
                     <div class="row align-items-center">
                        <div class="col-icon">
                           <div class="icon-big text-center icon-primary bubble-shadow-small">
                              <i class="fas fa-file"></i>
                           </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                           <a href="{{route('contract.alert.leader')}}">
                           <div class="numbers">
                              <p class="card-category">Contract Alert </p>
                              <h4 class="card-title">
                                 @if (count($contractAlerts) > 0)
                                    <div class="badge badge-primary">{{count($contractAlerts)}}</div>
                                     @else
                                     {{count($contractAlerts)}}
                                 @endif
                              </h4>
                           </div>
                        </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @if (auth()->user()->username == 11304 )
               <div class="col-md-4">
                  <a href="{{route('payroll.approval.manfin')}}" data-toggle="tooltip" data-placement="top" title="Daftar Payslip Report yang membutuhkan Approval anda">
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
                                    <h4 class="card-title">{{count($payrollApprovals)}}</h4>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </a>
               </div>
            
            @endif
            @if ( auth()->user()->username == 'EN-2-006')
               <div class="col-md-6">
                  <a href="{{route('payroll.approval.gm')}}" data-toggle="tooltip" data-placement="top" title="Daftar Payslip Report yang membutuhkan Approval anda">
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
                                    <h4 class="card-title">{{count($payrollApprovals)}}</h4>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </a>
               </div>
            @endif
         </div>

        
         <div class="row">
            <div class="col-md-6">
               <div class="card">
                  <div class="card-header p-2 bg-primary text-white">
                     <small>Monitoring Absensi</small>
                  </div>
                  <div class="card-body p-0">
                     <div class="table-responsive overflow-auto" style="height: 145px">
                     <table class=" ">
                        <thead>
                           
                           <tr class="">
                             
                              <th>Name</th>
                              <th>Type</th>
                              <th scope="col">Date</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($recentForms as $form)
                               <tr>
                                 <td>
                                    <a href="{{route('employee.absence.detail', enkripRambo($form->id))}}">{{$form->employee->biodata->fullName()}}</a>
                                    
                                    
                                 </td>
                                 <td>
                                    <x-status.absence :absence="$form" />
                                 </td>
                                 <td>
                                    <x-absence.date :absence="$form" />
                                 </td>

                               </tr>
                           @endforeach
                        </tbody>
                     </table>
                     </div>
                  </div>
               </div>
               
            </div>
            <div class="col-md-6">
               <div class="card">
                  <div class="card-header p-2 bg-primary text-white">
                     <small>Monitoring SPKL</small>
                  </div>
                  <div class="card-body p-0">
                     <div class="table-responsive overflow-auto" style="height: 145px">
                     <table class=" ">
                        <thead>
                           <tr>
                              
                               <th>Name</th>
                              <th>Type</th>
                              {{-- <th>Day</th> --}}
                              <th>Date</th>
                             
                              {{-- <th>Status</th> --}}
                              {{-- <th></th> --}}
                              {{-- <th></th> --}}
                           </tr>
                        </thead>
         
                        <tbody>
                           @foreach ($recentTeamSpkls as $spkl)
                           <tr>
                              <td>
                                 <a href="{{route('employee.spkl.detail', enkripRambo($spkl->id))}}">{{$spkl->employee->biodata->fullName()}} </a>
                                 @if ($spkl->parent_id != null)
                                 | <a href="{{route('employee.spkl.detail.multiple', enkripRambo($spkl->parent_id))}}">Lihat Group</a>
                                     
                                 @endif
                              </td>
                              
                              
                              <td>
                                 @if ($spkl->type == 1)
                                     Lembur
                                     @else
                                     Piket
                                 @endif
                              </td>
                              <td class=" text-truncate">
                                 @if ($spkl->holiday_type == 1)
                                    <span  class="text-info ">
                                    @elseif($spkl->holiday_type == 2)
                                    <span class="text-warning">
                                    @elseif($spkl->holiday_type == 3)
                                    <span class="text-danger">LN -
                                    @elseif($spkl->holiday_type == 4)
                                    <span class="text-danger">LR -
                                 @endif
                                 <a href="#" data-target="#modal-overtime-doc-{{$spkl->id}}" data-toggle="modal" class="text-white">{{formatDate($spkl->date)}}</a>
                                 </span>
                              </td>
                              
                              
                              
                              {{-- <td>
                                 <x-status.spkl-employee :empspkl="$spkl" />
                              </td> --}}
         
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                     </div>
                  </div>
               </div>


               
               
              
            </div>
         </div>

         <div class="row">
            <div class="col-md-6">
               <div class="card">
                  <div class="card-header d-flex justify-content-between p-2 bg-primary text-white">
                     <small>APPROVAL PE</small>
                     <a href="{{route('qpe')}}" class="text-white">more...</a>
                  </div>
                  <div class="card-body p-0">
                     <div class="table-responsive overflow-auto" style="height: 120px">
                     <table class=" ">
                        {{-- <thead>
                           
                           <tr class="">
                              
                              <th></th>
                              <th>Employee</th>
                              <th>Semester</th>
                           </tr>
                        </thead> --}}
                        <tbody>
      
                           
                           @foreach ($positions as $pos)
                               {{-- <tr>
                                 <td colspan="6">{{$pos->department->unit->name}} {{$pos->department->name}}</td>
                               </tr> --}}
                               @foreach ($pos->department->pes()->where('status', 1)->orderBy('updated_at', 'desc')->get() as $pe)
                                 {{-- @if ($pe->status != 2) --}}
                                 <tr>
                                    {{-- <td></td> --}}
                                    <td class="text-truncate">
                                       {{-- <a href="{{route('sp.detail', enkripRambo($pe->id))}}">{{$pe->code}}</a> --}}
                                       @if($pe->status == '0' || $pe->status == '101')
                                       <a href="/qpe/edit/{{enkripRambo($pe->kpa->id)}}"> {{$pe->employe->biodata->fullName()}} </a>
                                       @elseif($pe->status == '1' || $pe->status == '202' )
                                       <a href="/qpe/approval/{{enkripRambo($pe->kpa->id)}}"> {{$pe->employe->biodata->fullName()}} </a>
                                       @else
                                       <a href="/qpe/show/{{enkripRambo($pe->kpa->id)}}"> {{$pe->employe->biodata->fullName()}} </a>
                                       @endif
                                    </td>
                                    <td>{{$pe->semester}} / {{$pe->tahun}}</td>
                                    <td>{{$pe->achievement}}</td>
                                    {{-- <td>
                                       <x-status.pe :pe="$pe" />
                                    </td> --}}
                                 </tr>
                                 {{-- @endif --}}
                                 
                               @endforeach
                           @endforeach
                           <tr>
                              <td colspan="6"></td>
                           </tr>
                           @if ($recentPes)
                              @foreach ($recentPes as $pe)
                                 <tr>
                                    <td></td>
                                    <td class="text-truncate">
                                       {{-- <a href="{{route('sp.detail', enkripRambo($pe->id))}}">{{$pe->code}}</a> --}}
                                       @if($pe->status == '0' || $pe->status == '101')
                                       <a href="/qpe/edit/{{enkripRambo($pe->kpa->id)}}"> {{$pe->employe->biodata->fullName()}} </a>
                                       @elseif($pe->status == '1' || $pe->status == '202' )
                                       <a href="/qpe/approval/{{enkripRambo($pe->kpa->id)}}"> {{$pe->employe->biodata->fullName()}} </a>
                                       @else
                                       <a href="/qpe/show/{{enkripRambo($pe->kpa->id)}}"> {{$pe->employe->biodata->fullName()}} </a>
                                       @endif
                                    </td>
                                    <td>{{$pe->semester}} / {{$pe->tahun}}</td>
                                    <td>{{$pe->achievement}}</td>
                                    <td>
                                       <x-status.pe :pe="$pe" />
                                    </td>
                                 </tr>
                              @endforeach
                           @endif
                           
                        </tbody>
                     </table>
                     </div>
                  </div>
                  {{-- <div class="card-footer">
                     <small class="text-muted">*Ini adalah 8 data QPE terkini, klik <a href="{{route('qpe')}}">Disini</a> untuk melihat seluruh data QPE.</small>
                  </div> --}}
               </div>
            </div>
            <div class="col-md-6">
               <div class="card">
                  <div class="card-header p-2 bg-danger text-white">
                     <small>Recent SP</small>
                  </div>
                  <div class="card-body p-0">
                     <div class="table-responsive overflow-auto" style="height: 120px">
                     <table class=" ">
                        {{-- <thead>
                           
                           <tr class="">
                             
                              <th></th>
                              <th >Name</th>
                              
                              <th>Level</th>
                              <th scope="col">Status</th>
                           </tr>
                        </thead> --}}
                        <tbody>
                           {{-- @if (count($sps) > 0) --}}
                           @foreach ($positions as $pos)
                               {{-- <tr>
                                 <td colspan="6">{{$pos->department->unit->name}} {{$pos->department->name}}</td>
                               </tr> --}}
                               @foreach ($pos->department->sps()->paginate(3) as $sp)
                               <tr>
                                 {{-- <th></th> --}}
                                 <td><a href="{{route('sp.detail', enkripRambo($sp->id))}}">{{$sp->employee->biodata->fullName()}}</a></td>
                                 {{-- <td>{{$sp->code}}</td> --}}
                                 {{-- <td>{{$sp->employee->biodata->first_name}} {{$sp->employee->biodata->last_name}}</td> --}}
                                 
                                 <td>SP {{$sp->level}}</td>
                                 <td>
                                    <x-status.sp :sp="$sp" />
                                 </td>
                              </tr>
                               @endforeach
                           @endforeach
                           {{-- @else
                           <tr>
                              <td colspan="5" class="text-center">Empty</td>
                           </tr> --}}
                           {{-- @endif --}}
                           {{-- @foreach ($sps as $sp)
                               
                           @endforeach --}}
                        </tbody>
                     </table>
                     </div>
                  </div>
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
                     <input type="date" class="form-control"  name="date" id="date" value="{{$presence->in_date}}">
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
                           <input type="time" class="form-control"  name="time" id="time" value="{{$presence->in_time}}" >
                        </div>
                     </div>
                  </div>
                  
               </div>
               <div class="col-md-6">
                  <div class="badge badge-info mb-2">Out</div>
                  {{-- <hr> --}}
                  <div class="form-group form-group-default">
                     <label>Date</label>
                     <input type="date" class="form-control"  name="date" id="date" value="{{$presence->out_date}}">
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
                           <input type="time" class="form-control"  name="time" id="time" value="{{$presence->out_time}}" >
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
   <div class="modal-dialog modal-sm" role="document">
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
               <input type="date" class="form-control"  name="date" id="date" >
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
                     <input type="time" class="form-control"  name="time" id="time" >
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
               <input type="date" class="form-control"  name="date" id="date" >
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
                     <input type="time" class="form-control"  name="time" id="time" >
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