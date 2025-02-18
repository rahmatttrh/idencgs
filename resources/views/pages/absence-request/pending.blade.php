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

   <div class="card shadow-none border">
      <div class=" card-header">
         <div>
            <!-- resources/views/components/tab-absence.blade.php -->
        
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link{{ $activeTab === 'index' ? ' active' : '' }}" href="{{ route('employee.absence') }}">Absence</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ $activeTab === 'pending' ? ' active' : '' }}" href="{{ route('employee.absence.pending') }}">Pending Request</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link{{ $activeTab === 'draft' ? ' active' : '' }}" href="{{ route('employee.absence.draft') }}">Drafting</a>
               </li>
                <li class="nav-item">
                    <a class="nav-link{{ $activeTab === 'form' ? ' active' : '' }}" href="{{ route('employee.absence.create') }}">Create</a>
                </li>
                
            </ul>
        
        </div>
      </div>

      <div class="card-body ">

         <div class="row">
            
            <div class="col-md-12">
               
               <div class="table-responsive p-0">
                  <table id="data" class="display basic-datatables table-sm p-0">
                     <thead>
                        <tr>
                           {{-- <th>NIK</th>
                            <th>Name</th> --}}
                            {{-- <th>Loc</th> --}}
                           <th>Type</th>
                           <th>Day</th>
                           <th>Date</th>
                           <th>Desc</th>
                           <th>Status</th>
                           <th></th>
                        </tr>
                     </thead>

                     <tbody>
                        @foreach ($absences->where('status', 1) as $absence)
                        <tr>
                           {{-- <td>{{$absence->employee->nik}}</td>
                            <td> {{$absence->employee->biodata->fullName()}}</td> --}}
                            {{-- <td>{{$absence->employee->location->name}}</td> --}}
                           <td>
                              @if ($absence->status == 404)
                                 <span class="text-danger">Permintaan Perubahan</span>
                                  @else
                                  @if ($absence->type == 1)
                                 Alpha
                                 @elseif($absence->type == 2)
                                 Terlambat ({{$absence->minute}} Menit)
                                 @elseif($absence->type == 3)
                                 ATL
                                 @elseif($absence->type == 4)
                                 Izin ({{$absence->type_izin}})
                                 @elseif($absence->type == 5)
                                 Cuti
                                 @elseif($absence->type == 6)
                                 SPT ({{$absence->type_spt}})
                                 @elseif($absence->type == 7)
                                 Sakit 
                                 @elseif($absence->type == 8)
                                 Dinas Luar
                                 @elseif($absence->type == 9)
                                 Off Kontrak
                                 @endif
                              @endif
                              
                           </td>
                           <td>{{formatDayName($absence->date)}}</td>
                           <td>{{formatDate($absence->date)}}</td>
                           <td>{{$absence->desc}}</td>
                           <td>
                              @if ($absence->status == 1)
                                  <span class="text-primary">Approval Atasan</span>
                              @endif
                           </td>
                           <td class="text-truncate">
                            <a  href="{{route('employee.absence.detail', enkripRambo($absence->id))}}" class="">Detail</a> |
                              <a href="#"  data-target="#modal-delete-absence-employee-{{$absence->id}}" data-toggle="modal">Delete</a>
                           </td>
                        </tr>

                        <div class="modal fade" id="modal-delete-absence-employee-{{$absence->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <div class="modal-dialog modal-sm" role="document">
                              <div class="modal-content text-dark">
                                 <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                                 <div class="modal-body ">
                                    Delete data
                                    @if ($absence->type == 6)
                                    SPT
                                    @elseif($absence->type == 4)
                                    Izin
                                    
                                    @endif
                                    
                                    tanggal {{formatDate($absence->date)}}
                                    ?
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger ">
                                       <a class="text-light" href="{{route('employee.absence.delete', enkripRambo($absence->id))}}">Delete</a>
                                    </button>
                                 </div>
                              </div>
                           </div>
                        </div>
                        @endforeach
                     </tbody>

                  </table>
               </div>
               <!-- End Table  -->

               

            </div>
         </div>


      </div>


   </div>
   <!-- End Row -->


</div>




@endsection