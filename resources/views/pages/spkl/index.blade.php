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
         {{-- <h4><b>SPKL SAYA</b></h4>
         <hr> --}}
         {{-- <div class="btn btn-light border btn-block text-left mb-3"><b>SPKL SAYA</b></div> --}}
         {{-- <div class="card shadow-none border">
            <div class="card-body">
               <b>SPKL & PIKET</b>
            </div>
         </div> --}}
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{route('employee.spkl')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               List SPKL
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('employee.spkl.progress')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Progress
            </a>
            
            <a class="nav-link  text-left pl-3" id="v-pills-personal-tab" href="{{route('employee.spkl.draft')}}" aria-controls="v-pills-personal" aria-selected="true">
               <i class="fas fa-user mr-1"></i>
               Draft
            </a>
           

            <a class="nav-link text-left pl-3" id="v-pills-document-tab" href="{{route('employee.spkl.create')}}" aria-controls="v-pills-document" aria-selected="false">
               <i class="fas fa-file mr-1"></i>
               Form SPKL 
            </a>
            {{-- <a class="nav-link text-left pl-3" id="v-pills-document-tab" href="{{route('employee.spkl.create.multiple')}}" aria-controls="v-pills-document" aria-selected="false">
               <i class="fas fa-file mr-1"></i>
               Form SPKL B
            </a> --}}
            
         </div>
         <hr>
         <form action="{{route('employee.spkl.filter')}}" method="post">
            @csrf
            <div class="row">
               <div class="col-12">
                  <div class="form-group form-group-default">
                     <label>Dari</label>
                     <input class="form-control" type="date" name="from" id="from">
                  </div>
               </div>
               <div class="col">
                  <div class="form-group form-group-default">
                     <label>Sampai</label>
                     <input class="form-control" type="date" name="to" id="to">
                  </div>
               </div>
            </div>
            <button type="submit" class="btn btn-block btn-light border">Filter</button>
            
            
         </form>
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
         <div class="badge badge-info">{{$desc}}</div>
         <div class="table-responsive p-0 mt-2">
            <table id="data" class="display datatables-2 table-sm p-0">
               <thead>
                  <tr>
                     {{-- <th>NIK</th>
                      {{-- <th>Name</th> --}}
                      {{-- <th>Loc</th> --}}
                      <th>Employee</th>
                      {{-- <th>Name</th> --}}
                     <th>Type</th>
                     {{-- <th>Day</th> --}}
                     <th>Date</th>
                     <th class="text-center">Qty</th>
                     {{-- <th></th> --}}
                     {{-- <th></th> --}}
                     {{-- <th></th> --}}
                  </tr>
               </thead>

               <tbody>
                  @foreach ($spkls as $spkl)
                  <tr>
                     <td>
                        @if ($spkl->overtime_employee_id != null)
                           <a href="{{route('employee.spkl.detail', [enkripRambo($spkl->overtime_employee_id), enkripRambo('index-employee')])}}">{{$spkl->employee->nik}} {{$spkl->employee->biodata->fullName()}}</a>
                           @else
                           {{$spkl->employee->nik}} {{$spkl->employee->biodata->fullName()}}
                        @endif
                        
                     </td>
                     {{-- <td></td> --}}
                     <td>
                        @if ($spkl->holiday_type == 1)
                           <span  class="text-info ">
                           @elseif($spkl->holiday_type == 2)
                           <span class="text-warning">
                           @elseif($spkl->holiday_type == 3)
                           <span class="text-danger">LN -
                           @elseif($spkl->holiday_type == 4)
                           <span class="text-danger">LR -
                        @endif
                           </span>
                        @if ($spkl->type == 1)
                            Lembur
                            @else
                            Piket
                        @endif
                     </td>
                     <td class=" text-truncate">
                        
                        {{-- <a href="#" data-target="#modal-overtime-doc-{{$spkl->id}}" data-toggle="modal" class="text-white">{{formatDate($spkl->date)}}</a> --}}
                        {{$spkl->date}}
                     </td>
                     
                     
                     <td class="text-center">
                        @if ($spkl->type == 1)
                              @if ($spkl->employee->unit->hour_type == 1)
                                 {{$spkl->hours}}
                                 @elseif ($spkl->employee->unit->hour_type == 2)
                                 {{$spkl->hours}} ({{$spkl->hours_final}}) 
                              @endif
                           @else
                           1
                        @endif
                        
                        
                     </td>
                     {{-- <td>
                        @if ($spkl->overtime_employee_id != null)
                           <a href="">Detail</a>
                        @endif
                     </td> --}}

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