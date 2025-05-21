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
         <h4><b>ABSENSI</b></h4>
         <hr>
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link  text-left pl-3" id="v-pills-basic-tab" href="{{route('employee.absence')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               List Absensi
            </a>
            <a class="nav-link active  text-left pl-3" id="v-pills-contract-tab" href="{{route('employee.absence.pending')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Progress
            </a>
            
            <a class="nav-link  text-left pl-3" id="v-pills-personal-tab" href="{{route('employee.absence.draft')}}" aria-controls="v-pills-personal" aria-selected="true">
               <i class="fas fa-user mr-1"></i>
               Draft
            </a>
           

            <a class="nav-link text-left pl-3" id="v-pills-document-tab" href="{{route('employee.absence.create')}}" aria-controls="v-pills-document" aria-selected="false">
               <i class="fas fa-file mr-1"></i>
               Form Absensi
            </a>
            
         </div>
         <hr>
         <div class="card">
            <div class="card-body">
               <small>Daftar pengajuan yang masih dalam tahap persetujuan</small>
            </div>
         </div>
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
         <div class="table-responsive p-0">
            <table id="data" class="display basic-datatables table-sm p-0">
               <thead>
                  <tr>
                     {{-- <th>NIK</th>
                      <th>Name</th> --}}
                      {{-- <th>Loc</th> --}}
                     <th>Type</th>
                     {{-- <th>Day</th> --}}
                     <th>Date</th>
                     <th>Desc</th>
                     <th>Status</th>
                     <th></th>
                  </tr>
               </thead>

               <tbody>
                  @foreach ($absences as $absence)
                  <tr>
                     {{-- <td>{{$absence->employee->nik}}</td>
                      <td> {{$absence->employee->biodata->fullName()}}</td> --}}
                      {{-- <td>{{$absence->employee->location->name}}</td> --}}
                     <td>
                        @if ($absence->status == 404)
                           <span class="text-danger">Permintaan Perubahan</span>
                            @else
                            <x-status.absence :absence="$absence" />
                        @endif
                        
                     </td>
                     {{-- <td>{{formatDayName($absence->date)}}</td> --}}
                     <td>
                        @if ($absence->type == 5)
                              @if (count($absence->details) > 0)
                                    @foreach ($absence->details  as $item)
                                       {{formatDate($item->date)}} -
                                    @endforeach
                                 @else
                                 Tanggal belum dipilih
                              @endif
                           {{-- {{count($absence->details)}} Hari --}}
                              @else
                              {{formatDate($absence->date)}}
                        @endif
                     </td>
                     <td>{{$absence->desc}}</td>
                     <td>
                        @if ($absence->status == 1 || $absence->status == 2)
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
      </div>
   </div>



</div>




@endsection