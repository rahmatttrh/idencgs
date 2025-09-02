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

   <div class="card ">
      

      <div class="card-body px-0">

         <ul class="nav nav-tabs px-4">
            <li class="nav-item">
              <a class="nav-link " href="{{route('hrd.spkl')}}">
               Approval SPKL
               @if (count($spklApprovals) > 0)
                  <span class="badge badge-danger">{{count($spklApprovals)}} </span>
                  @endif
            </a>
            </li>
            <li class="nav-item">
               <a class="nav-link active" href="{{route('hrd.spkl.history')}}">Monitoring  Form SPKL</a>
             </li>
            {{-- <li class="nav-item">
              <a class="nav-link" href="{{route('admin.employee.spkl')}}">SPKL</a>
            </li> --}}
           
          </ul>

          <div class="table-responsive mt-2">
            <table id="data" class="datatables-3 table-sm ">
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
                  
                      @foreach ($spklHistories as $spkl)
                          
                           <tr>
                              <td class="text-truncate">
                                 
                                 
                              {{-- @if ($spkl->parent_id != null)
                               <a href="{{route('employee.spkl.detail.multiple', [enkripRambo($spkl->parent_id), enkripRambo('history')])}}">{{$spkl->parent->code}}</a>
                                 @else --}}
                                 <a href="{{route('employee.spkl.detail', [enkripRambo($spkl->id), enkripRambo('history-hrd')])}}">{{$spkl->code}}</a>
                              {{-- @endif --}}
                              </td>
                              {{-- <td>{{$spkl->employee->nik}}</td> --}}
                              <td class="text-truncate">{{$spkl->employee->nik}} {{$spkl->employee->biodata->fullName()}}</td>
                              <td>
                                 @if ($spkl->type == 1)
                                    Lembur
                                    @else
                                    Piket
                                 @endif
                                 @if ($spkl->holiday_type == 1)
                                    <span  class=" ">
                                    @elseif($spkl->holiday_type == 2)
                                    <span class="text-warning">
                                    @elseif($spkl->holiday_type == 3)
                                    <span class="text-danger">LN -
                                    @elseif($spkl->holiday_type == 4)
                                    <span class="text-danger">LR -
                                 @endif
                                 </span>
                              </td>
                              
                              <td class=" text-truncate">{{$spkl->date}}</td>
                              
                              
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
                              <td class="text-truncate">
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
      <div class="card-footer">
         <small>Daftar Formulir SPKL yang dibuat oleh semua Karyawan</small>
         {{-- <a href="{{route('overtime.refresh')}}">Refresh</a> --}}
      </div>


   </div>


   


</div>




@endsection