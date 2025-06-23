@extends('layouts.app')
@section('title')
SPKL
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">SPKL</li>
      </ol>
   </nav>

   <div class="row">
      
       <div class="col-md-3">
         
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link  text-left pl-3" id="v-pills-basic-tab" href="{{route('admin.employee.absence')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Form Absensi
            </a>
            <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{route('admin.employee.spkl')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Form SPKL
            </a>
            {{-- <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('employee.absence.pending')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               Progress
            </a>
            
            <a class="nav-link  text-left pl-3" id="v-pills-personal-tab" href="{{route('employee.absence.draft')}}" aria-controls="v-pills-personal" aria-selected="true">
               <i class="fas fa-user mr-1"></i>
               Draft
            </a>
           

            <a class="nav-link text-left pl-3" id="v-pills-document-tab" href="{{route('employee.absence.create')}}" aria-controls="v-pills-document" aria-selected="false">
               <i class="fas fa-file mr-1"></i>
               Form Absensi
            </a> --}}
            
         </div>
         <hr>
         {{-- <form action="">
            <select name="" id="" class="form-control">
               <option value="">Januari</option>
               <option value="">Februari</option>
            </select>
         </form> --}}
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
         <div class="table-responsive p-0 mt-2">
            <table id="data" class="display basic-datatables table-sm p-0">
               <thead>
                  <tr>
                     <th>#</th>
                      <th>ID</th>
                      <th>NIK</th>
                      <th>Name</th>
                     <th>Type</th>
                     {{-- <th>Day</th> --}}
                     <th>Date</th>
                     {{-- <th class="text-center">Qty</th> --}}
                     <th>Status</th>
                     {{-- <th></th> --}}
                     {{-- <th></th> --}}
                  </tr>
               </thead>

               <tbody>
                  @foreach ($spkls as $spkl)
                  <tr>
                     <td>{{++$i}}</td>
                     <td>
                        <a href="{{route('employee.spkl.detail', enkripRambo($spkl->id))}}">{{$spkl->code}} </a>
                        @if ($spkl->parent_id != null)
                        | <a href="{{route('employee.spkl.detail.multiple', enkripRambo($spkl->parent_id))}}">Group</a>
                            
                        @endif
                     </td>
                     <td class="text-truncate">{{$spkl->employee->nik}}</td>
                     <td>{{$spkl->employee->biodata->fullName()}}</td>
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
                     <td>
                        <x-status.spkl-employee :empspkl="$spkl" />
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