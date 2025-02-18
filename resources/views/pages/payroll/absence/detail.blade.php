@extends('layouts.app')
@section('title')
Absence Detail
@endsection
@section('content')

<style>
   html {
      -webkit-print-color-adjust: exact;
   }

   table,
   th,
   td {
      
      border: 1px solid black;
      border-collapse: collapse;
   }

   .ttd {
      font-size: 10px;
   }

   table td {
      font-size: 10px;
      padding-top: 3px;
  padding-bottom: 3px;
      padding-left: 5px;
      padding-right: 5px;
   }



   table {
      width: 100%;
   }


   .border-none {
      border: none;
   }
</style>

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item" aria-current="page">Absence</li>
         <li class="breadcrumb-item active" aria-current="page">Detail</li>
      </ol>
   </nav>
   <div class="card shadow-none border">
      <div class="card-header">Detail Absensi</div>
      <div class="card-body">
         <div class="row">
            <div class="col-md-7">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label>Name</label>
                        <span> {{$absence->employee->biodata->fullName()}}</span>
                        {{-- <input type="date" required class="form-control" readonly id="date" name="date" value="{{$absenceEmp->date}}"> --}}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label>NIK</label>
                        <span> {{$absence->employee->nik}} </span>
                        {{-- <input type="date" required class="form-control" readonly id="date" name="date" value="{{$absenceEmp->date}}"> --}}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label>Date</label>
                        <span> {{formatDate($absence->date)}} </span>
                        {{-- <input type="date" required class="form-control" readonly id="date" name="date" value="{{$absenceEmp->date}}"> --}}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label>Status</label>
                        <span>
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
                        </span>
                        {{-- <input type="date" required class="form-control" readonly id="date" name="date" value="{{$absenceEmp->date}}"> --}}
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group form-group-default">
                        <label>Description</label>
                        <span> {{$absence->desc ?? '-'}} </span>
                        {{-- <input type="date" required class="form-control" readonly id="date" name="date" value="{{$absenceEmp->date}}"> --}}
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-5">
               <div class="card card-light shadow-none border">
                  <div class="card-header">
                     <a href="{{route('employee.absence.detail', enkripRambo($absenceEmp->id))}}">
                        @if($absenceEmp->type == 4)
                           Izin ({{$absenceEmp->type_izin}})
                           @elseif($absenceEmp->type == 5)
                           Cuti
                           @elseif($absenceEmp->type == 6)
                           SPT 
                           @elseif($absenceEmp->type == 7)
                           Sakit 
                           
                        @endif
                        {{formatDate($absenceEmp->date)}}
                     </a>
                  </div>
                  <div class="card-body">
                     
                     @if ($absenceEmp->status == 0)
                         Draft
                         @elseif($absenceEmp->status == 1)
                         Menunggu Approval Atasan
                     @endif

                     {{-- <br> <br>
                     <a href="">Approve</a> | <a href="">Reject</a> --}}
                     {{-- @if ($absenceEmp->type == 6)
                        <a href="{{route('export.spt', enkripRambo($absenceEmp->id))}}" >Export PDF</a>
                     @endif

                     @if ($absenceEmp->type == 5)
                     <a href="{{route('export.cuti', enkripRambo($absenceEmp->id))}}" >Export PDF</a>
                  @endif --}}
                  </div>
               </div>
            </div>
         </div>
         
         
      </div>
   </div>

   {{-- <div class="card shadow-none border ">
      <div class=" card-header">
         
            Form Pengajuan
        
        
      </div>

      <div class="card-body">
         <div class="row">
            <div class="col-md-7">
               <form action="{{route('employee.absence.update')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')

                  <input type="number" name="absenceEmp" id="absenceEmp" value="{{$absenceEmp->id}}" hidden>
                  <input type="number" name="type" id="type" value="{{$absenceEmp->type}}" hidden>
                  <input type="number" name="leader" id="leader" value="{{$absenceEmp->leader_id}}" hidden>
                  <input type="date" name="date" id="date" value="{{$absenceEmp->date}}" hidden>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Date</label>
                           <span>{{formatDate($absenceEmp->date)}}</span>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Jenis </label>
                           <span>
                              @if ($absenceEmp->type == 1)
                              Alpha
                              @elseif($absenceEmp->type == 2)
                              Terlambat ({{$absenceEmp->minute}} Menit)
                              @elseif($absenceEmp->type == 3)
                              ATL
                              @elseif($absenceEmp->type == 4)
                              Izin ({{$absenceEmp->type_izin}})
                              @elseif($absenceEmp->type == 5)
                              Cuti
                              @elseif($absenceEmp->type == 6)
                              SPT 
                              @elseif($absenceEmp->type == 7)
                              Sakit 
                              @elseif($absenceEmp->type == 8)
                              Dinas Luar
                              @elseif($absenceEmp->type == 9)
                              Off Kontrak
                           @endif
                           </span>
                           
                        </div>
                     </div>

                     
                     

                     @if ($absenceEmp->type == 4)
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

                  @if ($absenceEmp->type == 5)
                  
                     <div class="form-group form-group-default">
                        <label>Persetujuan</label>
                        <span> {{$absenceEmp->leader->biodata->fullName()}}</span>
                     </div>
                     <div class="row">
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <label>Lama Cuti</label>
                              <span>{{$absenceEmp->cuti_qty}}</span>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <label>Mulai Cuti</label>
                              <span>{{formatDate($absenceEmp->cuti_start)}}</span>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <label>Sampai dengan</label>
                              <span>{{formatDate($absenceEmp->cuti_end)}}</span>
                           </div>
                        </div>
   
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Cuti Diambil</label>
                              <span>{{$cuti->used}}</span>
                          </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Sisa Cuti </label>
                              <span>{{$cuti->sisa}}</span>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group form-group-default">
                              <label>Keperluan</label>
                              <span>{{$absenceEmp->desc}}</span>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group form-group-default">
                              <label>Karyawan Pengganti</label>
                              <span>{{$absenceEmp->cuti_backup->biodata->fullName()}}</span>
                              
                           </div>
                        </div>
                     </div>
                     
                  @endif



                  @if ($absenceEmp->type == 6)
                  
                     <div class="form-group form-group-default">
                        <label>Pemberi Perintah</label>
                        <span> {{$absenceEmp->leader->biodata->fullName()}}</span>
                     </div>
                     
                     <div class="form-group form-group-default type_spt">
                        <label>Maksud Perintah Tugas</label>
                        <textarea  class="form-control" id="desc" name="desc" rows="2">{{$absenceEmp->desc}}</textarea>
                     </div>

                     <div class="row type_spt">
                        <div class="col-md-6 ">
                           <div class="form-group form-group-default">
                              <label>Jenis SPT</label>
                              <select class="form-control"  name="type_desc" id="type_desc">
                                 <option value="" disabled selected>Select</option>
                                 <option {{$absenceEmp->type_desc == 'Tidak Absen Masuk' ? 'selected' : ''  }}  value="Tidak Absen Masuk">Tidak Absen Masuk</option>
                                 <option {{$absenceEmp->type_desc == 'Tidak Absen Pulang' ? 'selected' : ''  }} value="Tidak Absen Pulang">Tidak Absen Pulang</option>
                                 <option {{$absenceEmp->type_desc == 'Tidak Absen Masuk & Pulang' ? 'selected' : ''  }} value="Tidak Absen Masuk & Pulang">Tidak Absen Masuk & Pulang</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-6">
                           <div class="form-group form-group-default">
                              <label>Alat Transportasi</label>
                              <select class="form-control"  name="transport" id="transport">
                                 <option value="" disabled selected>Select</option>
                                 <option {{$absenceEmp->transport == 'Pesawat' ? 'selected' : ''  }} value="Pesawat">Pesawat</option>
                                 <option {{$absenceEmp->transport == 'Mobil' ? 'selected' : ''  }} value="Mobil">Mobil</option>
                                 <option {{$absenceEmp->transport == 'Kereta' ? 'selected' : ''  }} value="Kereta">Kereta</option>
                                 <option {{$absenceEmp->transport == 'Motor' ? 'selected' : ''  }} value="Motor">Motor</option>
                                 <option {{$absenceEmp->transport == 'Bus' ? 'selected' : ''  }} value="Bus">Bus</option>
                                 <option {{$absenceEmp->transport == 'Taxi' ? 'selected' : ''  }} value="Taxi">Taxi</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-6">
                           <div class="form-group form-group-default">
                              <label>Tujuan</label>
                              <input type="text" class="form-control" id="destination" name="destination" value="{{$absenceEmp->destination}}">
                           </div>
                        </div>
                        <div class="col-6">
                           <div class="form-group form-group-default">
                              <label>Berangkat Dari</label>
                              <input type="text" class="form-control" id="from" name="from" value="{{$absenceEmp->from}}">
                           </div>
                        </div>
                        <div class="col-6">
                           <div class="form-group form-group-default">
                              <label>Tempat Transit</label>
                              <input type="text" class="form-control" id="transit" name="transit" value="{{$absenceEmp->transit}}">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Lama Tugas</label>
                              <input type="text" class="form-control" id="duration" name="duration" value="{{$absenceEmp->duration}}">
                           </div>
                        </div>
                     </div>

                     <div class="row type_spt">
                        <div class="col-6 ">
                           <div class="form-group form-group-default">
                              <label>Tanggal/Jam Berangkat</label>
                              <input type="datetime-local" class="form-control" id="departure" name="departure" value="{{$absenceEmp->departure}}">
                           </div>
                        </div>
                        <div class="col-6 type_spt">
                           <div class="form-group form-group-default">
                              <label>Tanggal/Jam Kembali</label>
                              <input type="datetime-local" class="form-control" id="return" name="return" value="{{$absenceEmp->return}}">
                           </div>
                        </div>
                     </div>

                  @endif


                  <div class="form-group form-group-default type_spt">
                     <label>Keterangan</label>
                     <span>{{$absenceEmp->remark ?? '-'}}</span>
                    </div>
                 
                  <hr>

                  
                  
               </form>
            </div>
            <div class="col-md-5 ">
            
               <div class="card card-light shadow-none border">
                  <div class="card-body">
                     Status :  
                     @if ($absenceEmp->status == 0)
                         Draft
                         @elseif($absenceEmp->status == 1)
                         Menunggu Approval Atasan Langsung
                     @endif
                  </div>
               </div>
               
               @if($absenceEmp->status == 0)
               <a href="" class="btn btn-primary btn-block" data-target="#modal-release-absence-employee" data-toggle="modal">Release</a>
               @endif

               @if($absenceEmp->status == 1)
               <a href="" class="btn btn-primary btn-block" data-target="#modal-approve-absence-employee" data-toggle="modal">Approve</a>
               @endif


               @if ($absenceEmp->type == 6)
                  <a href="{{route('export.spt', enkripRambo($absenceEmp->id))}}" class="btn btn-light border btn-block">Export PDF</a>
               @endif

               @if ($absenceEmp->type == 5)
               <a href="{{route('export.cuti', enkripRambo($absenceEmp->id))}}" class="btn btn-light border btn-block">Export PDF</a>
            @endif
            </div>
         </div>
         


      </div>


   </div> --}}

   <div class="card card-lg">
      <div class="card-body">
         <div class="d-flex justify-content-between">
            <span>
               <x-status.form :form="$absenceEmp" />
            </span>
            <span>
               @if ($absenceEmp->type == 6)
                     <a href="{{route('export.spt', enkripRambo($absenceEmp->id))}}" target="_blank" >Export PDF</a>
                  @endif

                  @if ($absenceEmp->type == 5)
                  <a href="{{route('export.cuti', enkripRambo($absenceEmp->id))}}" target="_blank" >Export PDF</a>
               @endif
            </span>
         </div>
         
         <hr>

         <x-absence.pdf :absenceemp="$absenceEmp" :cuti="$cuti" :employee="$employee" />

         
      </div>
   </div>
   <!-- End Row -->


</div>


<div class="modal fade" id="modal-release-absence-employee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content text-dark">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body ">
            Release Pengajuan 
            @if ($absenceEmp->type == 6)
                SPT
            @endif
            ?
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary ">
               <a class="text-light" href="{{route('employee.absence.release', enkripRambo($absenceEmp->id))}}">Release</a>
            </button>
         </div>
      </div>
   </div>
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
            @if ($absenceEmp->type == 6)
                SPT
            @endif
            ?
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary ">
               <a class="text-light" href="{{route('employee.absence.approve', enkripRambo($absenceEmp->id))}}">Approve</a>
            </button>
         </div>
      </div>
   </div>
</div>





@endsection