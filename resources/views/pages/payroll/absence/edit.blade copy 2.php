@extends('layouts.app')
@section('title')
Payroll Absence
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item" aria-current="page">Payroll</li>
         <li class="breadcrumb-item " aria-current="page">Absence</li>
         <li class="breadcrumb-item active" aria-current="page">Edit</li>
      </ol>
   </nav>

   <div class="card">
      <div class="card-header">
         <a class="btn btn-light btn-sm border" href="{{route('payroll.absence.employee.detail', [enkripRambo($absence->employee->id), 0, 0])}}"> <i class="fa fa-backward"></i> Kembali</a> |
         <span>Form Edit Absensi</span>
      </div>
      <div class="card-body">
         <div class="row">
            <div class="col-md-6">
               <form action="{{route('payroll.absence.update')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('put')
                  <input type="number" name="absenceId" id="absenceId" value="{{$absence->id}}" hidden>
                  <div class="form-group form-group-default">
                     <label>Employee</label>
                     <select class="form-control js-example-basic-single" style="width: 100%" required name="employee" id="employee">
                        <option value="" disabled selected>Select</option>
                        @foreach ($employees as $emp)
                        <option {{$absence->employee_id == $emp->id ? 'selected' : ''}} value="{{$emp->id}}">{{$emp->nik}} {{$emp->biodata->fullName()}}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Date</label>
                           <input type="date" required class="form-control" id="date" value="{{$absence->date}}" name="date">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Type</label>
                           <select class="form-control type" required name="type" id="type">
                              <option value="" disabled selected>Select</option>
                              <option {{$absence->type == 1 ? 'selected' : ''}} value="1">Alpha</option>
                              <option {{$absence->type == 2 ? 'selected' : ''}} value="2">Terlambat</option>
                              <option {{$absence->type == 3 ? 'selected' : ''}} value="3">ATL</option>
                              <option {{$absence->type == 4 ? 'selected' : ''}} value="4">Izin</option>
                              <option {{$absence->type == 5 ? 'selected' : ''}} value="5">Cuti</option>
                              <option {{$absence->type == 6 ? 'selected' : ''}} value="6">SPT</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-6 type_spt">
                        <div class="form-group form-group-default">
                           <label>Jenis SPT</label>
                           <select class="form-control"  name="type_spt" id="type_spt">
                              <option value="" disabled selected>Select</option>
                              <option {{$absence->type_spt == 'Tidak Absen Masuk' ? 'selected' : ''}} value="Tidak Absen Masuk">Tidak Absen Masuk</option>
                              <option {{$absence->type_spt == 'Tidak Absen Pulang' ? 'selected' : ''}} value="Tidak Absen Pulang">Tidak Absen Pulang</option>
                              <option {{$absence->type_spt == 'Tidak Absen Masuk & Pulang' ? 'selected' : ''}} value="Tidak Absen Masuk & Pulang">Tidak Absen Masuk & Pulang</option>
                           </select>
                        </div>
                     </div>

                     <div class="col-md-6 type_izin">
                        <div class="form-group form-group-default">
                           <label>Jenis Izin</label>
                           <select class="form-control"  name="type_izin" id="type_izin">
                              <option value="" disabled selected>Select</option>
                              <option {{$absence->type_izin == 'Setengah Hari' ? 'selected' : ''}} value="Setengah Hari">Setengah Hari</option>
                              <option {{$absence->type_izin == 'Satu Hari' ? 'selected' : ''}} value="Satu Hari">Satu Hari</option>
                           </select>
                        </div>
                     </div>
                  </div>


                  <div class="form-group form-group-default">
                     <label>Desc</label>
                     <input type="text" class="form-control" id="desc" value="{{$absence->desc}}" name="desc">
                  </div>

                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group form-group-default">
                           <label>Menit</label>
                           <select class="form-control"  name="minute" id="minute">
                              <option value="" disabled selected>Select</option>
                              <option  {{$absence->minute == '30' ? 'selected' : ''}} value="T1">T1</option>
                              <option {{$absence->minute == '60' ? 'selected' : ''}} value="T2">T2</option>
                              <option {{$absence->minute == '90' ? 'selected' : ''}} value="T3">T3</option>
                              <option {{$absence->minute == '120' ? 'selected' : ''}} value="T4">T4</option>
                           </select>
                        </div>
                     </div>
                     <div class="col">
                        <div class="form-group form-group-default">
                           <label>Document</label>
                           <input type="file" class="form-control" id="doc" name="doc">
                        </div>
                     </div>
                  </div>



                  <button class="btn  btn-primary" type="submit">Update</button>
               </form>
            </div>
         </div>
      </div>
   </div>
  

   


</div>

<div class="modal fade" id="modal-approve-hrd-absence" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('absence.approve.hrd')}}" method="POST" >
            <div class="modal-body">
               @csrf
               @method('PUT')
               <input type="text" value="{{$absence->id}}" name="absence" id="absence" hidden>
               <span>Approve this Request?</span>
                  
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary ">Approve</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-reject-hrd-absence" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog " role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('absence.reject.hrd')}}" method="POST" >
            <div class="modal-body">
               @csrf
               @method('PUT')
               <input type="text" value="{{$absence->id}}" name="absence" id="absence" hidden>

               {{-- <span>Approve this Request?</span>
               <hr> --}}
               <div class="form-group ">
                  <label>Reject this Request?</label>
                  <input id="desc" name="desc" type="text" required class="form-control" placeholder="Alasan penolakan..">
                  
               </div>
                  
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-danger ">Reject</button>
            </div>
         </form>
      </div>
   </div>
</div>




@endsection