@extends('layouts.app')
@section('title')
Form SPKL
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">Pengajuan SPKL</li>
      </ol>
   </nav>

   <div class="card ">
      

      <div class="card-body px-0">

         <ul class="nav nav-tabs px-3">
            <li class="nav-item">
               <a class="nav-link active" href="{{route('hrd.spkl')}}">Approval SPKL  
                  {{-- @if (count($spklApprovals) > 0)
                  <span class="badge badge-danger">{{count($spklApprovals)}} </span>
                  @endif --}}
                  @if (count($spklApprovals) > 0)
                  <span class="text-danger"><b>({{count($spklApprovals)}})</b></span>
                  @endif
                  
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="{{route('hrd.spkl.monitoring')}}">Monitoring SPKL</a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="{{route('hrd.spkl.history')}}">History SPKL</a>
             </li>
            {{-- <li class="nav-item">
              <a class="nav-link" href="{{route('admin.employee.spkl')}}">SPKL</a>
            </li> --}}
           
          </ul>

          <div class="table-responsive mt-2 ">
            <table id="data" class="datatables-3 ">
               <thead>
                  <tr>
                     <th>ID</th>
                     {{-- <th>NIK</th> --}}
                     <th>Name</th>
                     <th>Type</th>
                     <th>Date</th>
                     <th class="text-center">Jam</th>
                     <th>Status</th>
                     <th>Atasan</th>
                     <th>Manager</th>
                     {{-- <th>Action</th> --}}
                  </tr>
               </thead>

               <tbody>
                  
                      @foreach ($spklApprovals as $spkl)
                          
                           <tr>
                              <td class="text-truncate">
                                 
                                 
                              {{-- @if ($spkl->parent_id != null)
                               <a href="{{route('employee.spkl.detail.multiple', [enkripRambo($spkl->parent_id), enkripRambo('approval-hrd')])}}">{{$spkl->parent->code}}</a>
                                 @else --}}
                                 <a href="{{route('employee.spkl.detail', [enkripRambo($spkl->id), enkripRambo('approval-hrd')])}}">{{$spkl->code}}</a>
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
                              
                              <td class=" text-truncate">
                                 
                                 {{$spkl->date}}
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
                              <td class="text-truncate">
                                 <x-status.spkl-employee :empspkl="$spkl" />
                              </td>
                              <td class="text-truncate">
                                 @if ($spkl->leader_id != null)
                                     {{$spkl->leader->biodata->fullName()}}
                                 @endif
                              </td>
                              <td class="text-truncate">
                                 @if ($spkl->manager_id != null)
                                     {{$spkl->manager->biodata->fullName()}}
                                 @endif
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
         {{-- <a href="{{route('overtime.refresh')}}">Refresh</a> --}}
         <small>Daftar Formulir SPKL yang menunggu konfirmasi HRD</small>
      </div>


   </div>



   


</div>




@endsection