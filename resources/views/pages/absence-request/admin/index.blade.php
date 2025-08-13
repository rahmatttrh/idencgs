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
            <table id="data" class="datatables-5">
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
                     <th>Created</th>
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
                        
                     </td>
                     {{-- <td>{{formatDayName($absence->date)}}</td> --}}
                     <td class="text-truncate">
                        <x-absence.date :absence="$absence" />
                     </td>
                     <td class="text-truncate">
                        <x-status.form :form="$absence" />
                     </td>
                     <td class="text-truncate">
                        {{$absence->updated_at}}
                     </td>
                     
                  </tr>

                  @endforeach
               </tbody>

            </table>
         </div>


      </div>
      <div class="card-footer">
         {{-- <a href="{{route('overtime.refresh')}}">Refresh</a> --}}
      </div>


   </div>

   
   
   <!-- End Row -->


</div>




@endsection