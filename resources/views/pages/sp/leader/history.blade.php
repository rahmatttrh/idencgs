@extends('layouts.app')
@section('title')
History Formulir Pengajuan SPKL
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">History Formulir Pengajuan SPKL</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link  text-left pl-3" id="v-pills-basic-tab" href="{{ route('leader.spkl') }}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Pengajuan SPKL
            </a>
            <a class="nav-link active  text-left pl-3" id="v-pills-contract-tab" href="{{ route('leader.spkl.history') }}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               History
            </a>
            
           
            
         </div>
         <hr>
         
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
         <div class="table-responsive ">
            <table id="data" class="display basic-datatables table-sm p-0">
               <thead>
                  <tr>
                     <th>ID</th>
                     {{-- <th>NIK</th> --}}
                     <th>Name</th>
                     <th>Type</th>
                     <th>Date</th>
                     <th class="text-center">Jam</th>
                     <th>Status</th>
                  </tr>
               </thead>

               <tbody>
                  
                      @foreach ($teamSpkls as $spkl)
                          
                           <tr>
                              <td>
                                 
                                 
                              @if ($spkl->parent_id != null)
                               <a href="{{route('employee.spkl.detail.multiple', enkripRambo($spkl->parent_id))}}">{{$spkl->parent->code}}</a>
                                 @else
                                 <a href="{{route('employee.spkl.detail', enkripRambo($spkl->id))}}">{{$spkl->code}}</a>
                              @endif
                              </td>
                              {{-- <td>{{$spkl->employee->nik}}</td> --}}
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
                                    <span  class=" ">
                                    @elseif($spkl->holiday_type == 2)
                                    <span class="text-warning">
                                    @elseif($spkl->holiday_type == 3)
                                    <span class="text-danger">LN -
                                    @elseif($spkl->holiday_type == 4)
                                    <span class="text-danger">LR -
                                 @endif
                                 {{formatDate($spkl->date)}}
                                 </span>
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
                              <td>
                                 <x-status.spkl-employee :empspkl="$spkl" />
                              </td>
                              {{-- <td>
                                 <a href="{{route('employee.spkl.detail.leader', enkripRambo($spkl->id))}}">Detail</a>
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