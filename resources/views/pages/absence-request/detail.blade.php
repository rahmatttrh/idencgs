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


   @if ($absenceEmp->status == 0)
       
   
   <div class="card shadow-none border ">
      <div class=" card-header d-flex justify-content-between">
            <span>
               Detail Formulir {{$type}} 
            </span>
            

            <span>
               Status : 
               @if ($absenceEmp->status == 0)
                  Draft
                  @elseif($absenceEmp->status == 1)
                  Menunggu Approval Atasan Langsung
               @endif
            </span>

        
        
      </div>

      <div class="card-body">
         <div class="row">
            <div class="col-md-7">
               <form action="{{route('employee.absence.update')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')

                  <input type="number" id="absenceEmp" name="absenceEmp" value="{{$absenceEmp->id}}" hidden>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Date</label>
                           <input type="date" required class="form-control" id="date" name="date" value="{{$absenceEmp->date}}">
                        </div>
                     </div>
                     {{-- <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label class="mb-2 ">{{$type}} </label>
                           <span>
                              Status : 
                              @if ($absenceEmp->status == 0)
                                 Draft
                                 @elseif($absenceEmp->status == 1)
                                 Menunggu Approval Atasan Langsung
                              @endif
                           </span>
                        </div>
                     </div> --}}
                    
                     

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
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Persetujuan</label>
                              <select class="form-control " required name="persetujuan" id="persetujuan">
                                 <option value="" disabled selected>Select</option>
                                 @foreach ($employeeLeaders as $lead)
                                    <option {{$absenceEmp->leader_id == $lead->leader_id ? 'selected' : ''}}  value="{{$lead->leader_id}}">{{$lead->leader->biodata->fullName()}}</option>
                                 @endforeach
                                 {{-- <option  value="4">Izin</option>
                                 <option value="5">Cuti</option>
                                 <option  value="6">SPT</option>
                                 <option value="7">Sakit</option> --}}
                              </select>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Karyawan Pengganti</label>
                              <select class="form-control"  name="cuti_backup" id="cuti_backup">
                                 <option value="" disabled selected>Select</option>
                                 @foreach ($employees as $emp)
                                 <option {{$absenceEmp->cuti_backup_id == $emp->id ? 'selected' : ''}} value="{{$emp->id}}">{{$emp->biodata->fullName()}}</option>
                                 @endforeach
                                 
                              
                              </select>
                           </div>
                        </div>
                        {{-- <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <label>Jumlah Cuti </label>
                              <input type="text" class="form-control" id="cuti_taken" name="cuti_taken" value="{{$absenceEmp->cuti_taken}}">
                           </div>
                        </div> --}}
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Cuti Diambil</label>
                              <input type="text" class="form-control" id="cuti_qty" name="cuti_qty" readonly value="{{$cuti->used}}">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Sisa Cuti </label>
                              <input type="text" class="form-control"  id="cuti_qty" name="cuti_qty" readonly value="{{$cuti->sisa}}">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <label>Lama Cuti</label>
                              <input type="text" class="form-control" readonly id="cuti_qty" name="cuti_qty" value="{{$absenceEmp->cuti_qty}}">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <label>Mulai cuti</label>
                              <input type="date" class="form-control" readonly id="cuti_start" name="cuti_start" value="{{$absenceEmp->cuti_start}}">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <label>Sampai dengan</label>
                              <input type="date" class="form-control "  readonly id="cuti_end" name="cuti_end" value="{{$absenceEmp->cuti_end}}">
                           </div>
                        </div>

                        
                        <div class="col-md-12">
                           <div class="form-group form-group-default">
                              <label>Keperluan</label>
                              <input type="text" class="form-control" id="keperluan" name="keperluan" value="{{$absenceEmp->desc}}">
                           </div>
                        </div>
                        
                     </div>
                  @endif


                  @if ($absenceEmp->type == 6)
                      
                     <div class="form-group form-group-default">
                        <label>Pemberi Perintah</label>
                        <select class="form-control " required name="leader" id="leader">
                           <option value="" disabled selected>Select</option>
                           @foreach ($employeeLeaders as $lead)
                              <option {{$absenceEmp->leader_id == $lead->leader_id ? 'selected' : ''}}  value="{{$lead->leader_id}}">{{$lead->leader->biodata->fullName()}}</option>
                           @endforeach
                           {{-- <option  value="4">Izin</option>
                           <option value="5">Cuti</option>
                           <option  value="6">SPT</option>
                           <option value="7">Sakit</option> --}}
                        </select>
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
                     <input type="text" class="form-control" id="remark" name="remark" value="{{$absenceEmp->remark}}">
                  </div>
                  <div class="form-group form-group-default">
                     <label>Document</label>
                     <input type="file" class="form-control" id="doc" name="doc">
                  </div>
                  <hr>
                  @if ($absenceEmp->status == 0)
                  <button class="btn  btn-primary" type="submit">Update</button>
                  <a href="{{route('employee.absence.delete', enkripRambo($absenceEmp->id))}}" class="btn btn-danger">Delete</a>
                  @endif

                  


                  

                  
                  



                  
               </form>
            </div>
            <div class="col-md-5 ">
            


               @if ($absenceEmp->type == 5)
                  <form action="{{route('employee.absence.detail.store')}}" method="POST">
                     @csrf
                     <input type="number" name="absence_employee" id="absence_employee" value="{{$absenceEmp->id}}" hidden>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Tanggal Cuti</label>
                              <input type="date" required class="form-control" id="date" name="date">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <button class="btn btn-primary btn-block" type="submit">Add</button>
                        </div>
                     </div>
                  </form>
                  <table>
                     <tbody>
                        @foreach ($absenceEmployeeDetails as $detail)
                        <tr>
                           <td>{{formatDate($detail->date)}}</td>
                           <td><a href="{{route('employee.absence.detail.delete', enkripRambo($detail->id))}}">Remove</a></td>
                        </tr>
                        @endforeach
                        
                     </tbody>
                  </table>
                  <hr>
               @endif
               
               @if($absenceEmp->status == 0)
               <a href="" class="btn btn-primary btn-block" data-target="#modal-release-absence-employee" data-toggle="modal">Release</a>
               @endif

               @if($absenceEmp->status == 1)
               <a href="" class="btn btn-primary btn-block" data-target="#modal-approve-absence-employee" data-toggle="modal">Approve</a>
               @endif
               
               @if ($absenceEmp->type == 6)
                  <a href="{{route('export.spt', enkripRambo($absenceEmp->id))}}" target="_blank" class="btn btn-light border btn-block">Export PDF</a>
               @endif
               @if ($absenceEmp->type == 5)
               <a href="{{route('export.cuti', enkripRambo($absenceEmp->id))}}" target="_blank" class="btn btn-light border btn-block">Export PDF</a>
            @endif
               <hr>

               @if ($absenceEmp->absence_id != null)
                   
               
               <span>Perubahan untuk :</span> <br>
               @if ($absenceEmp->absence->type == 1)
                  Alpha
                  @elseif($absenceEmp->absence->type == 2)
                  Terlambat ({{$absenceEmp->absence->minute}} Menit)
                  @elseif($absenceEmp->absence->type == 3)
                  ATL
                  @elseif($absenceEmp->absence->type == 4)
                  Izin ({{$absenceEmp->absence->type_izin}})
                  @elseif($absenceEmp->absence->type == 5)
                  Cuti
                  @elseif($absenceEmp->absence->type == 6)
                  SPT ({{$absenceEmp->absence->type_spt}})
                  @elseif($absenceEmp->absence->type == 7)
                  Sakit 
                  @elseif($absenceEmp->absence->type == 8)
                  Dinas Luar
                  @elseif($absenceEmp->absence->type == 9)
                  Off Kontrak
               @endif
               {{formatDate($absenceEmp->absence->date)}} <br>
               - {{$absenceEmp->absence->desc}}
               @endif
            </div>
         </div>
         


      </div>


   </div>
   @endif
   <!-- End Row -->

   <div class="card">
      <div class="card-body">
         <div class="d-flex justify-content-between">
            <span>
               @if ($absenceEmp->leader != null)
                  @if ($absenceEmp->leader->nik == auth()->user()->username)
                     <a href="{{route('leader.absence')}}" class="btn btn-sm btn-light border"><< Kembali</a> |
                     @if($absenceEmp->status <= 2)
                     <a href="" class="btn btn-sm btn-primary" data-target="#modal-approve-absence-employee" data-toggle="modal">Approve</a>
                     <a href="" class="btn btn-sm btn-danger">Reject</a>
                     @elseif($absenceEmp->status > 2)

                     <a  class="btn btn-sm btn-light border">Status : <x-status.form :form="$absenceEmp" /></a>
                     
                     @endif
                     
                  @endif
               @endif
              


               @if ($absenceEmp->cuti_backup_id != null)
                  @if ($absenceEmp->cuti_backup->nik == auth()->user()->username)
                  <a href="{{route('leader.absence')}}" class="btn btn-sm btn-light border"><< Kembali</a> |
                     @if($absenceEmp->status == 1)
                     <a href="" class="btn btn-primary" data-target="#modal-approve-backup-absence-employee" data-toggle="modal">Approve</a>
                     <a href="" class="btn btn-danger">Reject</a>
                     @elseif($absenceEmp->status == 5)
                     Published
                     @endif
                     
                  @endif
               @endif

               

               @if ( auth()->user()->hasRole('HRD-Spv|HRD-Payroll'))
               <a href="{{route('hrd.absence')}}" class="btn btn-sm btn-light border"><< Kembali</a> |
                  @if($absenceEmp->status == 3)
                  <a href="" class="btn btn-sm btn-primary" data-target="#modal-approve-hrd-absence-employee" data-toggle="modal">Approve</a>
                  <a href="" class="btn btn-sm btn-danger">Reject</a>
                  @elseif($absenceEmp->status == 5)
                  Published
                  @endif
                   
               @endif

               @if ($absenceEmp->employee->nik == auth()->user()->username)
                   <x-status.form :form="$absenceEmp" />
               @endif
               {{-- <a href="" class="btn btn-primary">Approve</a>   --}}
               
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

<div class="modal fade" id="modal-approve-backup-absence-employee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            @if ($absenceEmp->type == 5)
                CUTI
                @elseif($absenceEmp->type == 6)
                SPT
            @endif
            ?
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary ">
               <a class="text-light" href="{{route('employee.absence.approve.pengganti', enkripRambo($absenceEmp->id))}}">Approve</a>
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
            @if ($absenceEmp->type == 5)
                CUTI
                @elseif($absenceEmp->type == 6)
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

<div class="modal fade" id="modal-approve-hrd-absence-employee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            @if ($absenceEmp->type == 5)
                CUTI
                @elseif($absenceEmp->type == 6)
                SPT
            @endif
            ?
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary ">
               <a class="text-light" href="{{route('employee.absence.approve.hrd', enkripRambo($absenceEmp->id))}}">Approve</a>
            </button>
         </div>
      </div>
   </div>
</div>





@endsection