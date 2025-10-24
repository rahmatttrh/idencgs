@extends('layouts.app')
@section('title')
Absence
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">Monitoring Absence</li>
      </ol>
   </nav>


   




   <div class="card ">
      

      <div class="card-body px-0">

         <ul class="nav nav-tabs px-3">
            <li class="nav-item">
              <a class="nav-link active" href="{{route('admin.employee.absence')}}">Absence</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('admin.employee.spkl')}}">SPKL</a>
            </li>
           
          </ul>

         <div class="table-responsive p-0 mt-2">
            {{-- @if (auth()->user()->hasRole('Administrator'))
            <table id="data" class="datatables-7">
               <thead>
                  <tr>
                  
                     <th>ID</th>
                      <th>Name</th>
                     <th>Type</th>
                     <th>Date</th>
                     <th>Release</th>
                     <th>Atasan</th>
                     <th>Manager</th>
                     <th>HRD</th>
                  </tr>
               </thead>

               <tbody>
                  @foreach ($absences as $absence)
                  <tr>
                  
                      <td class="text-truncate">
                        
                        <a href="{{route('employee.absence.detail', [enkripRambo($absence->id), enkripRambo('monitoring')])}}">{{$absence->code}} </a>
                      </td>
                     
                      <td class="text-truncate"> <a href="{{route('employee.absence.detail', [enkripRambo($absence->id), enkripRambo('monitoring')])}}">{{$absence->employee->nik}} {{$absence->employee->biodata->fullName()}}</a></td>
                     <td class="text-truncate">
                        <x-status.absence :absence="$absence" />
                        @if (count($absence->details) > 1)
                               ({{count($absence->details)}} hari)
                           @endif
                        
                     </td>
                    
                     <td class="text-truncate">
                       
                        @if ($absence->type == 5 || $absence->type == 10)
                           @if (count($absence->details) > 0)
                                 @if (count($absence->details) > 1)
                                       
                                       {{formatDate($absence->details->first()->date)}}
                                       @else
                                       @foreach ($absence->details  as $item)
                                       
                                       {{formatDate($absence->details->first()->date)}}
                                       @endforeach
                                 @endif
                                 
                              @else
                             
                           @endif
                        
                           @else
                           {{formatDate($absence->date)}}
                     @endif
                     </td>
                     
                     <td class="text-truncate">
                        {{formatDate($absence->release_date)}}
                     </td>
                     <td class="text-truncate">
                        @if ($absence->leader_id)
                        
                        {{formatDate($absence->app_leader_date)}}
                        @endif
                        
                     </td>
                     <td class="text-truncate">
                        @if ($absence->manager_id)
                       {{formatDate($absence->app_manager_date)}}
                        @endif
                        
                     </td>
                     <td class="text-truncate">
                        {{formatDate($absence->app_hrd_date)}}
                     </td>
                     
                  </tr>

                  @endforeach
               </tbody>

            </table>
                @else --}}
                <table id="data" class="datatables-7">
               <thead>
                  <tr>
                  
                     <th>ID</th>
                     {{-- <th>NIK</th>
                      {{-- <th>Name</th> --}}
                      {{-- <th>Loc</th> --}}
                      {{-- <th>NIK</th> --}}
                      <th>Name</th>
                     <th>Type</th>
                     {{-- <th>Day</th> --}}
                     <th>Date</th>
                     <th>Status</th>
                     <th>Atasan</th>
                     <th>Manager</th>
                     <th>Last Update</th>
                  </tr>
               </thead>

               <tbody>
                  @foreach ($absences as $absence)
                  <tr>
                     {{-- <td>{{$absence->employee->nik}}</td>
                      <td> {{$absence->employee->biodata->fullName()}}</td> --}}
                      {{-- <td>{{$absence->employee->location->name}}</td> --}}
                      {{-- <td> {{$absence->employee->biodata->fullName()}}</td> --}}
                      {{-- <td>{{$absence->id}}</td> --}}
                      <td class="text-truncate">
                        @if (auth()->user()->hasRole('Administrator'))
                            ID{{$absence->id}} -
                        @endif
                        <a href="{{route('employee.absence.detail', [enkripRambo($absence->id), enkripRambo('monitoring')])}}">{{$absence->code}} </a>
                      </td>
                      {{-- <td class="text-truncate">
                        
                        <a href="{{route('employee.absence.detail', [enkripRambo($absence->id), enkripRambo('monitoring')])}}">{{$absence->employee->nik}} </a>
                        
                     </td> --}}
                      <td class="text-truncate"> <a href="{{route('employee.absence.detail', [enkripRambo($absence->id), enkripRambo('monitoring')])}}">{{$absence->employee->nik}} {{$absence->employee->biodata->fullName()}}</a></td>
                     <td class="text-truncate">
                        <x-status.absence :absence="$absence" />
                        @if (count($absence->details) > 1)
                               ({{count($absence->details)}} hari)
                           @endif
                        
                     </td>
                     {{-- <td>{{formatDayName($absence->date)}}</td> --}}
                     <td class="text-truncate">
                        <x-absence.date :absence="$absence" />
                     </td>
                     
                     <td class="text-truncate">
                        <x-status.form :form="$absence" />
                     </td>
                     <td class="text-truncate">
                        @if ($absence->leader_id)
                        
                        {{$absence->leader->biodata->fullName()}}
                        @endif
                        
                     </td>
                     <td class="text-truncate">
                        @if ($absence->manager_id)
                        {{$absence->manager->biodata->fullName()}}
                        @endif
                        
                     </td>
                     <td class="text-truncate">
                        {{$absence->updated_at}}
                     </td>
                     
                  </tr>

                  @endforeach
               </tbody>

            </table>
            {{-- @endif --}}
            
         </div>


      </div>
      <div class="card-footer">
         {{-- <a href="{{route('overtime.refresh')}}">Refresh</a> --}}
      </div>


   </div>

   
   
   <!-- End Row -->


</div>




@endsection