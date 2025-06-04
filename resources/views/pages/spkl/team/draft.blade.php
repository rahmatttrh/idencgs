@extends('layouts.app')
@section('title')
SPKL
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">SPKL Team</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         {{-- <h4><b>SPKL SAYA</b></h4>
         <hr> --}}
         {{-- <div class="btn btn-light border btn-block text-left mb-3"><b>SPKL SAYA</b></div> --}}
         {{-- <div class="card shadow-none border">
            <div class="card-body">
               <b>SPKL & PIKET</b>
            </div>
         </div> --}}
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            {{-- <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{route('employee.spkl')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               List SPKL
            </a> --}}
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('spkl.team')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               SPKL Team Progress
            </a>
            
            <a class="nav-link active text-left pl-3" id="v-pills-personal-tab" href="{{route('employee.spkl.draft')}}" aria-controls="v-pills-personal" aria-selected="true">
               <i class="fas fa-file-contract mr-1"></i>
               Draft
            </a>
           

            
            <a class="nav-link text-left pl-3" id="v-pills-document-tab" href="{{route('spkl.team.create')}}" aria-controls="v-pills-document" aria-selected="false">
               <i class="fas fa-file mr-1"></i>
               Form SPKL Team
            </a>
            
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
                     {{-- <th>NIK</th>
                      {{-- <th>Name</th> --}}
                      {{-- <th>Loc</th> --}}
                      <th>ID</th>
                     <th>Type</th>
                     {{-- <th>Day</th> --}}
                     <th>Date</th>
                     <th class="text-center">Karyawan</th>
                     <th>Status</th>
                     {{-- <th></th> --}}
                  </tr>
               </thead>

               <tbody>
                  @foreach ($overtimeParents as $spkl)
                  <tr>
                     <td>
                       
                         <a href="{{route('employee.spkl.detail.multiple', enkripRambo($spkl->id))}}">{{$spkl->code}}</a>
                       
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
                           <span  >
                           @elseif($spkl->holiday_type == 2)
                           <span >
                           @elseif($spkl->holiday_type == 3)
                           <span >LN -
                           @elseif($spkl->holiday_type == 4)
                           <span >LR -
                        @endif
                        <a href="#" data-target="#modal-overtime-doc-{{$spkl->id}}" data-toggle="modal" >{{formatDate($spkl->date)}}</a>
                        </span>
                     </td>
                     
                     
                     <td class="text-center">
                       
                        {{count($spkl->overtimes)}} 
                        
                     </td>
                     <td>
                        <x-status.spkl :spkl="$spkl" />
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