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


   


   <div class="card">
      <div class="card-body px-0">
         <ul class="nav nav-tabs px-3">
            <li class="nav-item">
              <a class="nav-link active" href="{{ route('leader.spkl') }}">Approval SPKL</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="{{ route('leader.spkl.history') }}">Riwayat</a>
            </li>
           
          </ul>

          <form action="{{route('spkl.approve.multiple')}}" method="post" >
            @csrf
            @method('POST')

            @if (auth()->user()->hasRole('Manager|Asst. Manager|Supervisor'))
                
            
            <button  class="btn btn-primary m-3" data-toggle="tooltip" data-placement="top" title="Click to approve multiple SPKL"  type="submit"><i class="fas fa-check"></i> Approve Multiple SPKL</button>
            @endif
            <div class="table-responsive mt-2 p-0 ">
               <table id="data" class="display datatables-3  table-sm p-0">
                  <thead>
                     
                     <tr>
                        <th></th>
                        <th>ID</th>
                        {{-- <th>NIK</th> --}}
                        <th>Name</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th class="text-center">Jam</th>
                        <th>Status</th>
                        {{-- <th>Action</th> --}}
                     </tr>
                  </thead>

                  <tbody>

                     @foreach ($spklGroupApprovalLeaders as $spkl)
                     <tr>
                        <td>
                           <input  type="checkbox" name="checkSpklGroup[]" value="{{$spkl->id}}" id="checkSpkl-{{$spkl->id}}">
                           {{-- <input {{$editable == 0 ? 'readonly' : ''}} class="idSpkl" type="checkbox" name="idSpkl" id="idSpkl"> --}}
                        </td>
                        <td>
                           
                           
                        
                        <a href="{{route('employee.spkl.detail.multiple', [enkripRambo($spkl->id), enkripRambo('approval')])}}">{{$spkl->code}}</a>
                           
                        </td>
                        {{-- <td>{{$spkl->employee->nik}}</td> --}}
                        <td>{{count($spkl->overtimes)}} Karyawan</td>
                        <td>
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
                           @if ($spkl->type == 1)
                              Lembur
                              @else
                              Piket
                           @endif
                        </td>
                        <td class=" text-truncate">
                           
                           {{$spkl->date}}
                           
                        </td>

                        <td class="text-center text-truncate">
                        
                           {{$spkl->hours}}
                           
                        </td>

                        
                        <td>
                           <x-status.spkl-employee :empspkl="$spkl" />
                        </td>
                     

                     </tr>
                     @endforeach
                     
                     @foreach ($spklGroupApprovalManagers as $spkl)
                     <tr>
                        <td>
                           <input  type="checkbox" name="checkSpklGroup[]" value="{{$spkl->id}}" id="checkSpkl-{{$spkl->id}}">
                           {{-- <input {{$editable == 0 ? 'readonly' : ''}} class="idSpkl" type="checkbox" name="idSpkl" id="idSpkl"> --}}
                        </td>
                        <td>
                           
                           
                        
                        <a href="{{route('employee.spkl.detail.multiple', [enkripRambo($spkl->id), enkripRambo('approval')])}}">{{$spkl->code}}</a>
                           
                        </td>
                        {{-- <td>{{$spkl->employee->nik}}</td> --}}
                        <td>{{count($spkl->overtimes)}} Karyawan</td>
                        <td>
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
                           @if ($spkl->type == 1)
                              Lembur
                              @else
                              Piket
                           @endif
                        </td>
                        <td class=" text-truncate">
                           
                           {{$spkl->date}}
                           
                        </td>
                        <td class="text-center text-truncate">
                        
                           {{$spkl->hours}}
                           
                        </td>
                        
                        <td>
                           <x-status.spkl-employee :empspkl="$spkl" />
                        </td>
                     

                     </tr>
                     @endforeach
                     
                     @foreach ($teamSpkls as $spkl)
                        @if ($spkl->parent_id == null)
                           
                        
                        <tr>
                           <td>
                              <input  type="checkbox" name="checkSpkl[]" value="{{$spkl->id}}" id="checkSpkl-{{$spkl->id}}">
                              {{-- <input {{$editable == 0 ? 'readonly' : ''}} class="idSpkl" type="checkbox" name="idSpkl" id="idSpkl"> --}}
                           </td>
                           <td>
                              
                              
                           @if ($spkl->parent_id != null)
                              <a href="{{route('employee.spkl.detail.multiple', enkripRambo($spkl->parent_id))}}">{{$spkl->parent->code}}</a>
                              @else
                              <a href="{{route('employee.spkl.detail', [enkripRambo($spkl->id), enkripRambo('approval')])}}">{{$spkl->code}}</a>
                           @endif
                           </td>
                           {{-- <td>{{$spkl->employee->nik}}</td> --}}
                           <td>{{$spkl->employee->biodata->fullName()}}</td>
                           <td>
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
                              @if ($spkl->type == 1)
                                 Lembur
                                 @else
                                 Piket
                              @endif
                           </td>
                           <td class=" text-truncate">
                              
                              {{$spkl->date}}
                              
                           </td>
                           <td class="text-center text-truncate">
                        
                              {{$spkl->hours}}
                              
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
                           {{-- <td>
                              <a href="{{route('employee.spkl.detail.leader', enkripRambo($spkl->id))}}">Detail</a>
                           </td> --}}
      
                        </tr>
                        @endif
                        
                     @endforeach

                     @foreach ($spklApprovalManager as $spkl)
                     @if ($spkl->parent_id == null)
                        <tr>
                           <td>
                              <input  type="checkbox" name="checkSpkl[]" value="{{$spkl->id}}" id="checkSpkl-{{$spkl->id}}">
                              {{-- <input {{$editable == 0 ? 'readonly' : ''}} class="idActivity" type="checkbox" name="idActivity" id="idActivity"> --}}
                           </td>
                           <td>
                              
                              
                           
                           <a href="{{route('employee.spkl.detail', [enkripRambo($spkl->id), enkripRambo('approval')])}}">{{$spkl->code}}</a>
                              
                           </td>
                           {{-- <td>{{$spkl->employee->nik}}</td> --}}
                           <td>{{$spkl->employee->biodata->fullName()}}</td>
                           <td>
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
                              @if ($spkl->type == 1)
                                 Lembur
                                 @else
                                 Piket
                              @endif
                           </td>
                           <td class=" text-truncate">
                              
                              {{$spkl->date}}
                              
                           </td>
                           <td class=" text-center text-truncate">
                        
                              {{$spkl->hours}}
                              
                           </td>
                           
                           <td>
                              <x-status.spkl-employee :empspkl="$spkl" />
                           </td>
                        

                        </tr>
                        @endif
                     @endforeach
                     
                     
                  </tbody>

               </table>
            </div>
            
          </form>
      </div>
      <div class="card-footer">
         <small>Daftar SPKL yang membutuhkan persetujuan anda</small>
      </div>
   </div>

   


</div>




@endsection