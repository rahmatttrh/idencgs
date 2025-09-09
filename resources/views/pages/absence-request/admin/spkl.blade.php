@extends('layouts.app')
@section('title')
SPKL
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         {{-- <li class="breadcrumb-item " aria-current="page">Monitoring</li> --}}
         
         <li class="breadcrumb-item active" aria-current="page">Monitoring SPKL</li>
      </ol>
   </nav>

   <div class="card">
      <div class="card-body px-0">
         <ul class="nav nav-tabs px-3">
            <li class="nav-item">
              <a class="nav-link " href="{{route('admin.employee.absence')}}">Absence</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="{{route('admin.employee.spkl')}}">SPKL</a>
            </li>
           
          </ul>

          <div class="table-responsive mt-2 p-0">
            <table id="data" class="datatables-5">
               <thead>
                  <tr>
                     {{-- <th>#</th> --}}
                      <th>ID</th>
                      {{-- <th>NIK</th> --}}
                      <th>Name</th>
                     <th>Type</th>
                     {{-- <th>Day</th> --}}
                     <th>Date</th>
                     {{-- <th class="text-center">Qty</th> --}}
                     <th>Status</th>
                     <th>Created</th>
                     {{-- <th></th> --}}
                  </tr>
               </thead>

               <tbody>
                  {{-- @foreach ($spklGroups as $spkl)
                  <tr>
                    
                     <td  class="text-truncate">
                        
                        
                        <a href="{{route('employee.spkl.detail.multiple', [enkripRambo($spkl->id), enkripRambo('monitoring-hrd')])}}">{{$spkl->code}}</a>
                        
                     </td>
                    
                     <td  class="text-truncate">{{count($spkl->overtimes)}} Karyawan</td>
                     <td>
                        @if ($spkl->type == 1)
                            Lembur
                            @else
                            Piket
                        @endif
                     </td>
                     <td class=" text-truncate">
                        {{formatDate($spkl->date)}}
                     </td>
                     
                     
                   
                     <td class="text-truncate">
                        <x-status.spkl-employee :empspkl="$spkl" />
                     </td>
                     <td class="text-truncate">
                        {{$spkl->created_at}}
                     </td>

                  </tr>
                  @endforeach --}}
                  @foreach ($spkls as $spkl)
                  {{-- @if ($spkl->parent_id == null) --}}
                      
      
                  <tr>
                     {{-- <td>{{$spkl->id}}</td> --}}
                     <td  class="text-truncate">
                        @if (auth()->user()->hasRole('Administrator'))
                            ID{{$spkl->id}} -
                        @endif
                        <a href="{{route('employee.spkl.detail', [enkripRambo($spkl->id), enkripRambo('monitoring-admin')])}}">{{$spkl->code}} </a>
                        @if ($spkl->parent_id != null)
                        | <a href="{{route('employee.spkl.detail.multiple', [enkripRambo($spkl->parent_id), enkripRambo('monitoring-hrd')])}}">Group</a>
                            
                        @endif
                     </td>
                     {{-- <td class="text-truncate"></td> --}}
                     <td  class="text-truncate">{{$spkl->employee->nik}} {{$spkl->employee->biodata->fullName()}}</td>
                     <td>
                        @if ($spkl->type == 1)
                            Lembur
                            @else
                            Piket
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
                     <td class="text-truncate">
                        <x-status.spkl-employee :empspkl="$spkl" />
                     </td>
                     <td class="text-truncate">
                        {{$spkl->created_at}}
                     </td>

                  </tr>
                  {{-- @endif --}}
                  @endforeach


               </tbody>

            </table>
         </div>
      </div>
   </div>

  
   
   <!-- End Row -->


</div>




@endsection