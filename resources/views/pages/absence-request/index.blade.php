@extends('layouts.app')
@section('title')
Absence
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">Absence</li>
      </ol>
   </nav>

   <div class="row">
      
      <div class="col-md-3">
         {{-- <h4><b>ABSENSI SAYA</b></h4>
      <hr> --}}
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{route('employee.absence')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               List Absensi
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('employee.absence.pending')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Progress
            </a>
            
            <a class="nav-link  text-left pl-3" id="v-pills-personal-tab" href="{{route('employee.absence.draft')}}" aria-controls="v-pills-personal" aria-selected="true">
               <i class="fas fa-file-contract mr-1"></i>
               Draft
            </a>
           

            <a class="nav-link text-left pl-3" id="v-pills-document-tab" href="{{route('employee.absence.create')}}" aria-controls="v-pills-document" aria-selected="false">
               <i class="fas fa-edit mr-1"></i>
               Form Cuti/SPT/Izin
            </a>
            
         </div>
         <hr>
         <form action="">

            <div class="row">
               <div class="col-12">
                  <div class="form-group form-group-default">
                     <label>Bulan</label>
                     <select name="" id="" class="form-control">
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                     </select>
                  </div>
               </div>
               <div class="col">
                  <div class="form-group form-group-default">
                     <label>Tahun</label>
                     <select name="" id="" class="form-control">
                        <option selected value="2025">2025</option>
                        <option value="2024">2024</option>
                     </select>
                  </div>
               </div>
            </div>
            <button type="submit" class="btn btn-block btn-light border">Filter</button>
            
            
         </form>
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
         <div class="table-responsive p-0 mt-2">
            <table id="data" class="display datatables-3 table-sm p-0">
               <thead>
                  <tr>
                      <th class="">NIK</th>
                       <th class="">Name</th>
                      {{-- <th>Loc</th> --}}
                      {{-- <th>NIK</th> --}}
                     <th>Type</th>
                     {{-- <th>Day</th> --}}
                     <th>Date</th>
                     <th></th>
                     {{-- <th></th> --}}
                  </tr>
               </thead>

               <tbody>
                  @foreach ($absences as $absence)
                  <tr>
                     {{-- <td>{{$absence->employee->nik}}</td>
                      <td> {{$absence->employee->biodata->fullName()}}</td> --}}
                      {{-- <td>{{$absence->employee->location->name}}</td> --}}
                      <td class="">{{$absence->employee->nik}}</td>
                      <td class=""> {{$absence->employee->biodata->fullName()}}</td>
                      {{-- <td>{{$absence->employee->nik}}</td> --}}
                     <td >
                        <x-status.absence :absence="$absence" />
                        
                        
                     </td>
                     {{-- <td>{{formatDayName($absence->date)}}</td> --}}
                     <td>{{$absence->date}}</td>
                     <td class="text-truncate">
                        {{-- @if ($absence->getRequest() != null) 
                            <a href="{{route('employee.absence.detail', enkripRambo($absence->getRequest()->id))}}" class="badge badge-info">
                              @if ($absence->getRequest()->type == 1)
                                 Alpha
                                 @elseif($absence->getRequest()->type == 2)
                                 Terlambat ({{$absence->getRequest()->minute}} Menit)
                                 @elseif($absence->getRequest()->type == 3)
                                 ATL
                                 @elseif($absence->getRequest()->type == 4)
                                 Izin 
                                 @elseif($absence->getRequest()->type == 5)
                                 Cuti
                                 @elseif($absence->getRequest()->type == 6)
                                 SPT 
                                 @elseif($absence->getRequest()->type == 7)
                                 Sakit 
                                 @elseif($absence->getRequest()->type == 8)
                                 Dinas Luar
                                 @elseif($absence->getRequest()->type == 9)
                                 Off Kontrak
                              @endif 
                              :
                              <x-status.form :form="$absence->getRequest()" />
                              
                            </a>
                            @else
                            @if ($absence->type == 1 || $absence->type == 3)
                            <a href="{{route('employee.absence.request', enkripRambo($absence->id))}}" class="badge badge-light">Request Perubahan</a>
                            @endif
                            
                        @endif --}}

                        @if ($absence->absence_employee_id != null)
                        <a href="{{route('employee.absence.detail', [enkripRambo($absence->absence_employee_id), enkripRambo('index')])}}" >Lihat Form</a>
                        @endif
                     </td>
                     
                  </tr>

                  @endforeach
               </tbody>

            </table>
         </div>
      </div>
   </div>
   
   <!-- End Row -->


</div>




@endsection