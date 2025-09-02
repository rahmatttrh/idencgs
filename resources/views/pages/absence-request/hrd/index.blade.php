@extends('layouts.app')
@section('title')
Monitoring Form Absensi
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">Monitoring Form Absensi </li>
      </ol>
   </nav>

   <div class="card ">
      

      <div class="card-body px-0">

         <ul class="nav nav-tabs px-3">
            <li class="nav-item">
              <a class="nav-link {{$activeTab == 'approval' ? 'active' : ''}}" href="{{route('hrd.absence.approval')}}">
                  Approval Absence
                  @if ($totalApproval > 0)
                     <span class="badge badge-danger">{{$totalApproval}}</span>
                  @endif
               </a>
            </li>

            
            <li class="nav-item">
               <a class="nav-link {{$activeTab == 'index' ? 'active' : ''}}" href="{{route('hrd.absence')}}">Monitoring  Form Absence</a>
             </li>
            {{-- <li class="nav-item">
              <a class="nav-link" href="{{route('admin.employee.spkl')}}">SPKL</a>
            </li> --}}
           
         </ul>

         <div class="table-responsive mt-2">
            <table id="data" class="datatables-6">
               <thead>
                  <tr>
                     <th>ID</th>
                     <th>Type</th>
                     <th>NIK</th>
                      <th>Name</th>
                      {{-- <th>Loc</th> --}}
                     
                     {{-- <th>Day</th> --}}
                     <th>Date</th>
                     {{-- <th>Desc</th> --}}
                     <th>Status</th>
                     <th>Last Updated</th>
                  </tr>
               </thead>

               <tbody>
                  @foreach ($reqForms as $absence)
                  <tr>
                     <td class="text-truncate">
                        <a href="{{route('employee.absence.detail', [enkripRambo($absence->id), enkripRambo('monitoring')])}}">
                           {{$absence->code}}
                        </a>
                     </td>
                     <td class="text-truncate">
                        <a href="{{route('employee.absence.detail', [enkripRambo($absence->id), enkripRambo('monitoring')])}}">
                           <x-status.absence :absence="$absence" />
                           @if (count($absence->details) > 1)
                               ({{count($absence->details)}} hari)
                           @endif
                        
                        </a>
                        
                     </td>
                     <td class="text-truncate"><a href="{{route('employee.absence.detail', [enkripRambo($absence->id), enkripRambo('monitoring')])}}"> {{$absence->employee->nik}}</a></td>
                      <td class="text-truncate"> {{$absence->employee->biodata->fullName()}}</td>
                      {{-- <td>{{$absence->employee->location->name}}</td> --}}
                     
                     {{-- <td>{{formatDayName($absence->date)}}</td> --}}
                     <td class="text-truncate" >
                       <x-absence.date :absence="$absence" />
                     </td>
                     {{-- <td>{{$absence->desc}}</td> --}}
                     <td class="text-truncate">
                        <x-status.form :form="$absence" />
                        {{-- @if ($absence->status == 1)
                            <span class="text-primary">Approval Atasan</span>
                        @endif --}}
                     </td>
                     {{-- <td class="text-truncate">
                      <a  href="{{route('employee.absence.detail', enkripRambo($absence->id))}}" class="">Detail</a> |
                        <a href="#"  data-target="#modal-delete-absence-employee-{{$absence->id}}" data-toggle="modal">Delete</a>
                     </td> --}}
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
         @if ($activeTab == 'approval')
             <small>Daftar Formulir Absensi (Cuti/SPT/Izin/Sakit) yang menunggu konfirmasi HRD</small>
         @endif

         @if ($activeTab == 'index')
             <small>Daftar Formulir Absensi (Cuti/SPT/Izin/Sakit) yang dibuat oleh semua Karyawan</small>
         @endif
         {{-- <a href="{{route('overtime.refresh')}}">Refresh</a> --}}
      </div>


   </div>




  


</div>




@endsection