@extends('layouts.app')
@section('title')
Absence
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item" aria-current="page">Payroll</li>
         <li class="breadcrumb-item active" aria-current="page">Employee Absence</li>
      </ol>
   </nav>

   <div class="card shadow-none border ">
      <div class=" card-header d-flex justify-content-between">
         <div>
            <h3 class="">Daftar Absensi</h3>
            <h3><b>{{$employee->nik}} {{$employee->biodata->fullName()}}</b> </h3>
         </div>
        
         @if ($from == 0)
             <small>All</small>
             @else
             <small>{{formatDate($from)}} - {{formatDate($to)}}</small>
         @endif
      </div>


      <form action="{{route('payroll.overtime.multiple.delete')}}" method="post" >
         @csrf
         @error('id_item')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
         @enderror
         <div class="card-body">
         {{-- <div class="d-inline-flex align-items-center">
            <button type="submit" name="submit" class="btn btn-sm btn-danger mr-3">Delete</button>
            <div class="d-inline-flex align-items-center">
                  <span class="badge badge-muted badge-counter">
                     <span id="total">0</span>
                  </span>
            </div>
         </div>
         <hr> --}}
         
         <div class="table-responsive px-0">
            <table id="data" class="display basic-datatables table-sm">
               <thead>
                  <tr>
                     
                     <th>Type</th>
                     <th>Day</th>
                     <th>Date</th>
                     <th>Desc</th>
                     <th></th>
                  </tr>
               </thead>

               <tbody>
                  @foreach ($absences as $absence)
                  <tr>
                     
                     <td>
                        @if ($absence->status == 404)
                           <span class="text-danger">Permintaan Perubahan</span>
                            @else
                            <x-absence.type :absence="$absence" />
                        @endif
                        
                     </td>
                     <td>{{formatDayName($absence->date)}}</td>
                     <td>{{formatDate($absence->date)}}</td>
                     <td>{{$absence->desc}}</td>
                     <td class="text-truncate">
                        @if ($absence->getRequest() != null )
                        <a href="{{route('employee.absence.detail', enkripRambo($absence->getRequest()->id))}}" class="badge badge-info">
                           <x-absence.type :absence="$absence->getRequest()" />
                           :
                           <x-status.form :form="$absence->getRequest()" />
                          
                         </a>
                            @else
                            <a href="{{route('payroll.absence.edit', enkripRambo($absence->id))}}" class="">Update</a> |
                        <a href="#" data-target="#modal-delete-absence-{{$absence->id}}" data-toggle="modal">Delete</a>
                        @endif
                        
                     </td>
                  </tr>

                  <div class="modal fade" id="modal-delete-absence-{{$absence->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                              @if ($absence->type == 1)
                              Alpha
                              @elseif($absence->type == 2)
                              Terlambat ({{$absence->minute}})
                              @elseif($absence->type == 3)
                              ATL
                              @endif
                              {{$absence->employee->nik}} {{$absence->employee->biodata->fullName()}}
                              tanggal {{formatDate($absence->date)}}
                              ?
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-danger ">
                                 <a class="text-light" href="{{route('payroll.absence.delete', enkripRambo($absence->id))}}">Delete</a>
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

   </form>
      <div class="card-footer">
         <a href="{{route('overtime.refresh')}}">Refresh</a>
      </div>


   </div>
   <!-- End Row -->


</div>




@endsection