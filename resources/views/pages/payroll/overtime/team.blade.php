@extends('layouts.app')
@section('title')
SPKL Team
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item" aria-current="page">Summary</li>
         <li class="breadcrumb-item active" aria-current="page">SPKL Tim</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{route('overtime.team')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               SPKL Tim
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('absence.team')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Absensi Tim
            </a>
            
            
            
         </div>
         <hr>
               <form class="" action="{{route('payroll.overtime.filter.team')}}" method="POST">
                  @csrf
                  <div class="row">
                     
                     <div class="col-md-12">
                        <div class="form-group form-group-default">
                           <label>From</label>
                           <input type="date" name="from" id="from" value="{{$from}}" class="form-control">
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group form-group-default">
                           <label>To</label>
                           <input type="date" name="to" id="to" value="{{$to}}" class="form-control">
                        </div>
                     </div>
                    
                     
                     
                     <div class="col-12">
                        <button class="btn btn-light border btn-block" type="submit" >Filter Summary</button> <br>
                        
                     </div>
                     {{-- <div class="col text-right">
                        
                     </div> --}}

                     @if (auth()->user()->hasRole('Administrator|HRD-Payroll'))
                     <div class="col">
                        @if ($export == true)
                           <a href="{{route('payroll.overtime.export', [$from, $to, $loc] )}}" target="_blank" class="btn btn-block btn-dark"><i class="fa fa-file-excel"></i> Export</a>
                           @endif
                     </div>
                     @endif
                  </div>
               </form>  
      </div>
      <div class="col">
         <div class="table-responsive">
            <table id="data" class="display basic-datatables-order table-sm">
               <thead>
                  <tr>
                     <th>NIK</th>
                     <th>Name</th>
                     <th>Posisition</th>
                     <th class="text-center">Lembur</th>
                     <th class="text-center">Piket</th>
                     @if (auth()->user()->hasRole('HRD|HRD-Payroll'))
                        <th class="text-right">Rate</th>
                     @endif
                     
                  </tr>
               </thead>
               
               <tbody>
                  @if (count($employee->positions) > 0)
                        @foreach ($employee->positions as $pos)
                              
                              @foreach ($pos->department->employees->where('status', 1) as $emp)
                                 <tr>
                                 <td>{{$emp->nik}}</td>
                                 {{-- <td>{{$emp->sub_dept->name ?? ''}}</td> --}}
                                 {{-- <td></td> --}}
                                 <td class="text-truncate" style="max-width: 140px"> 
                                    <a href="{{route('payroll.overtime.employee.detail', [enkripRambo($emp->id), $from, $to])}}">{{$emp->biodata->fullName()}}</a>
                                 </td>
                                 <td>{{$emp->position->name}}</td>
                                 <td class="text-center">{{count($emp->getOvertimes($from, $to)->where('type', 1))}}</td>
                              <td class="text-center">{{count($emp->getOvertimes($from, $to)->where('type', 2))}}</td>
                              @if (auth()->user()->hasRole('HRD|HRD-Payroll'))
                              <td class="text-right">{{formatRupiahB($emp->getOvertimes($from, $to)->sum('rate'))}}</td>
                              @endif
                                 </tr>
                              @endforeach
                        @endforeach
                      @else
                      @foreach ($employees as $emp)
                           @php
                                 $bio = DB::table('biodatas')->where('id', $emp->biodata_id)->first();
                                 // $employee = DB::table('employees')->where('id', $emp->id)->first();
                           @endphp
                           <tr>
                              <td class="text-truncate">{{$emp->nik}} </td>
                              <td class="text-truncate" style="max-width: 140px"> 
                                 <a href="{{route('payroll.overtime.employee.detail', [enkripRambo($emp->id), $from, $to])}}">{{$bio->first_name}} {{$bio->last_name}}</a>
                              </td>
                              <td>{{$emp->position->name}}</td>
                              {{-- <td>{{$emp->location->name ?? '-'}}</td> --}}
                              {{-- <td class="text-truncate" style="max-width: 100px">{{$emp->unit->name}}</td> --}}
                              {{-- <td>{{$emp->department->name}}</td> --}}
                              <td class="text-center">{{count($emp->getOvertimes($from, $to)->where('type', 1))}}</td>
                              <td class="text-center">{{count($emp->getOvertimes($from, $to)->where('type', 2))}}</td>
                              @if (auth()->user()->hasRole('HRD|HRD-Payroll'))
                              <td class="text-right">{{formatRupiahB($emp->getOvertimes($from, $to)->sum('rate'))}}</td>
                              @endif
                           </tr>
                        @endforeach
                  @endif
                  
               </tbody>
               
            </table>
         </div>
      </div>
   </div>



</div>




@endsection