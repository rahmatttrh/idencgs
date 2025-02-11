@extends('layouts.app')
@section('title')
Form Absence
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item" aria-current="page">Absence</li>
         <li class="breadcrumb-item active" aria-current="page">Form</li>
      </ol>
   </nav>

   <div class="card shadow-none border ">
      <div class=" card-header">
         
            Detail Absensi
        
        
      </div>

      <div class="card-body">
         <div class="row">
            <div class="col-md-7">
               <form action="{{route('employee.absence.store')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Date</label>
                           <input type="date" required class="form-control" id="date" name="date" value="{{$absenceEmployee->date}}">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Type {{$absenceEmployee->type}}</label>
                           <select class="form-control type" required name="type" id="type">
                              <option value="" disabled selected>Select</option>
                              
                              <option {{$absenceEmployee->type == 4 ? 'selected' : ''  }} value="4">Izin</option>
                              <option {{$absenceEmployee->type == 5 ? 'selected' : ''  }} value="5">Cuti</option>
                              <option {{$absenceEmployee->type == 6 ? 'selected' : ''  }} value="6">SPT</option>
                              <option {{$absenceEmployee->type == 7 ? 'selected' : ''  }} value="7">Sakit</option>
                           </select>
                        </div>
                     </div>
                     

                     @if ($absenceEmployee->type == 4)
                     <div class="col-md-6 type_izin">
                        <div class="form-group form-group-default">
                           <label>Jenis Izin</label>
                           <select class="form-control"  name="type_izin" id="type_izin">
                              <option value="" disabled selected>Select</option>
                              <option value="Setengah Hari">Setengah Hari</option>
                              <option value="Satu Hari">Satu Hari</option>
                           </select>
                        </div>
                     </div>
                     @endif
                  </div>


                  @if ($absenceEmployee->type == 6)
                      
                  
                  <div class="form-group form-group-default type_spt">
                     <label>Maksud Perintah Tugas</label>
                     <textarea  class="form-control" id="desc" name="desc" rows="2">{{$absenceEmployee->desc}}</textarea>
                  </div>

                  <div class="row type_spt">
                     <div class="col-md-6 ">
                        <div class="form-group form-group-default">
                           <label>Jenis SPT</label>
                           <select class="form-control"  name="type_desc" id="type_desc">
                              <option value="" disabled selected>Select</option>
                              <option {{$absenceEmployee->type_desc == 'Tidak Absen Masuk' ? 'selected' : ''  }}  value="Tidak Absen Masuk">Tidak Absen Masuk</option>
                              <option {{$absenceEmployee->type_desc == 'Tidak Absen Pulang' ? 'selected' : ''  }} value="Tidak Absen Pulang">Tidak Absen Pulang</option>
                              <option {{$absenceEmployee->type_desc == 'Tidak Absen Masuk & Pulang' ? 'selected' : ''  }} value="Tidak Absen Masuk & Pulang">Tidak Absen Masuk & Pulang</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="form-group form-group-default">
                           <label>Alat Transportasi</label>
                           <select class="form-control"  name="transport" id="transport">
                              <option value="" disabled selected>Select</option>
                              <option {{$absenceEmployee->transport == 'Pesawat' ? 'selected' : ''  }} value="Pesawat">Pesawat</option>
                              <option {{$absenceEmployee->transport == 'Mobil' ? 'selected' : ''  }} value="Mobil">Mobil</option>
                              <option {{$absenceEmployee->transport == 'Kereta' ? 'selected' : ''  }} value="Kereta">Kereta</option>
                              <option {{$absenceEmployee->transport == 'Motor' ? 'selected' : ''  }} value="Motor">Motor</option>
                              <option {{$absenceEmployee->transport == 'Bus' ? 'selected' : ''  }} value="Bus">Bus</option>
                              <option {{$absenceEmployee->transport == 'Taxi' ? 'selected' : ''  }} value="Taxi">Taxi</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="form-group form-group-default">
                           <label>Tujuan</label>
                           <input type="text" class="form-control" id="destination" name="destination" value="{{$absenceEmployee->transport}}">
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="form-group form-group-default">
                           <label>Berangkat Dari</label>
                           <input type="text" class="form-control" id="from" name="from" value="{{$absenceEmployee->from}}">
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="form-group form-group-default">
                           <label>Tempat Transit</label>
                           <input type="text" class="form-control" id="transit" name="transit" value="{{$absenceEmployee->transit}}">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Lama Tugas</label>
                           <input type="text" class="form-control" id="duration" name="duration" value="{{$absenceEmployee->duration}}">
                        </div>
                     </div>
                  </div>

                  <div class="row type_spt">
                     <div class="col-6 ">
                        <div class="form-group form-group-default">
                           <label>Tanggal/Jam Berangkat</label>
                           <input type="datetime-local" class="form-control" id="departure" name="departure" value="{{$absenceEmployee->departure}}">
                        </div>
                     </div>
                     <div class="col-6 type_spt">
                        <div class="form-group form-group-default">
                           <label>Tanggal/Jam Kembali</label>
                           <input type="datetime-local" class="form-control" id="return" name="return" value="{{$absenceEmployee->return}}">
                        </div>
                     </div>
                  </div>

                  @endif


                  <div class="form-group form-group-default type_spt">
                     <label>Keterangan</label>
                     <input type="text" class="form-control" id="remark" name="remark" value="{{$absenceEmployee->remark}}">
                  </div>
                  <div class="form-group form-group-default">
                     <label>Document</label>
                     <input type="file" class="form-control" id="doc" name="doc">
                  </div>
                  <hr>
                  {{-- <button class="btn  btn-primary" type="submit">Update</button> --}}

                  


                  

                  
                  



                  
               </form>
            </div>
            <div class="col-md-5 ">
            
               <div class="card card-primary shadow-none">
                  <div class="card-body">
                     Status :  <br>
                     Menunggu Approval Atasan Langsung
                  </div>
               </div>
               <a href="" class="btn btn-primary btn-block" data-target="#modal-approve-absence-employee" data-toggle="modal">Approve</a>
               @if ($absenceEmployee->type == 6)
                  <a href="" class="btn btn-light border btn-block">Export PDF</a>
               @endif
            </div>
         </div>
         


      </div>


   </div>
   <!-- End Row -->


</div>


<div class="modal fade" id="modal-approve-absence-employee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content text-dark">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body ">
            Approve Pengajuan 
            @if ($absenceEmployee->type == 6)
                SPT
            @endif
            ?
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary ">
               <a class="text-light" href="{{route('employee.absence.approve', enkripRambo($absenceEmployee->id))}}">Approve</a>
            </button>
         </div>
      </div>
   </div>
</div>





@endsection