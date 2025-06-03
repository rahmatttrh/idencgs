@extends('layouts.app')
@section('title')
Formulir Pengajuan
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">Monitoring Request Absensi Karyawan</li>
      </ol>
   </nav>
   <div class="row">
      <div class="col-md-3">
         <h4><b>Monitoring Form Absensi</b></h4>
         <hr>
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{ route('hrd.absence') }}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Form Absensi Karyawan
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{ route('hrd.absence.history') }}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               History
            </a>
            
           
            
         </div>
         <hr>
         <small>
            <b>#INFO</b> <br>
            Daftar Form Request Absensi yang dibuat oleh Karyawan
         </small>
         
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
         
         <div class="table-responsive ">
            <table id="data" class="basic-datatables">
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
                     {{-- <th></th> --}}
                  </tr>
               </thead>

               <tbody>
                  @foreach ($reqForms as $absence)
                  <tr>
                     <td>
                        <a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}">
                           {{$absence->code}}
                        </a>
                     </td>
                     <td class="text-truncate">
                        <a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}">
                           <x-status.absence :absence="$absence" />
                     </a>
                        
                     </td>
                     <td class="text-truncate"><a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}"> {{$absence->employee->nik}}</a></td>
                      <td> {{$absence->employee->biodata->fullName()}}</td>
                      {{-- <td>{{$absence->employee->location->name}}</td> --}}
                     
                     {{-- <td>{{formatDayName($absence->date)}}</td> --}}
                     <td>
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
                  </tr>

                  
                  @endforeach
               </tbody>

            </table>
         </div>
      </div>
   </div>

  


</div>




@endsection