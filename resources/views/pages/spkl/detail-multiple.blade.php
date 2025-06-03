@extends('layouts.app')
@section('title')
Form Lembur/Piket
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">Form Lembur - Piket</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         @if ($empSpkl->status == 0)
         <a href="" class="btn mb-2 btn-primary m btn-block" data-target="#modal-release-spkl" data-toggle="modal">Release</a>
         @endif
         <table >
            <thead>
               <tr>
                  <th>SPKL Multiple</th>
               </tr>
               
               <tr>
                  <th>{{$empSpkl->code}}</th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td>
                     @if ($empSpkl->status == 0)
                     Draft
                     @else
                     Approval Atasan
                     @endif
                  </td>
               </tr>
               <tr>
                  <td>
                     @if ($empSpkl->status == 0)
                        
                        <a href="" class="">Edit</a> |
                        <a href="" class="">Delete</a> |
                     @endif
                     <a href="" class=""> Export PDF</a>
                  </td>
               </tr>
            </tbody>
         </table>
      </div>
      <div class="col-md-9">
         {{-- <h4>Detail Lembur/Piket</h4>
         <hr> --}}
         {{-- @if ($empSpkl->status == 0)
         <span class="btn btn-group btn-sm p-0 mb-2">
            <a href="" class="btn btn-primary btn-sm" data-target="#modal-release-spkl" data-toggle="modal">Release</a>
            <a href="" class="btn btn-light btn-sm border">Edit</a>
            <a href="" class="btn btn-light btn-sm border">Delete</a>
         </span>
         @elseif($empSpkl->status == 1)
         <a href="" class="btn btn-light btn-sm border mb-2">Menunggu Approval Atasan</a>
         @endif --}}
         
         {{-- <a href="" class="btn btn-light border btn-sm mb-2"><i class="fa fa-file"></i> Export PDF</a> --}}
         <table>
            <tbody>
               {{-- <tr>
                  <td style="width: 150px">Nama</td>
                  <td>{{$empSpkl->employee->biodata->fullName()}}</td>
               </tr>
               <tr>
                  <td>NIK</td>
                  <td>{{$empSpkl->employee->nik}}</td>
               </tr>
               <tr>
                  <td>Jabatan</td>
                  <td>{{$empSpkl->employee->position->name}}</td>
               </tr>
               <tr>
                  <td>Departemen</td>
                  <td>{{$empSpkl->employee->department->name}}</td>
               </tr> --}}
               <tr>
                  <td style="width: 150px">ID</td>
                  <td>{{$empSpkl->code}}</td>
               </tr>
               <tr>
                  <td>Tanggal</td>
                  <td>{{formatDate($empSpkl->date)}}</td>
               </tr>
               <tr>
                  <td>Waktu</td>
                  <td>{{$empSpkl->hours_start}}  sd  {{$empSpkl->hours_end}}</td>
               </tr>
               <tr>
                  <td>Lama Lembur</td>
                  <td>{{$empSpkl->hours}} Jam</td>
               </tr>
               <tr>
                  <td>Pekerjaan</td>
                  <td>{{$empSpkl->description}}</td>
               </tr>
               <tr>
                  <td>Lokasi Pekerjaan</td>
                  <td>{{$empSpkl->location}}</td>
               </tr>
            </tbody>
         </table>
         <table>
            <tbody>
               <tr>
                  <td>Requested by <br> Atasan Langsung</td>
                  <td>Approved by <br>GM/Manager </td>
                  <td>Employee</td>
               </tr>
               <tr>
                  <td>-</td>
                  <td>-</td>
                  <td class="text-center py-3">
                     @if ($empSpkl->status > 0)
                     <span class="text-info">Released</span>
                     @else
                     
                     @endif
                     
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td></td>
                  <td>
                     {{$empSpkl->by->biodata->fullName()}}
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td></td>
                  <td>{{$empSpkl->release_employee_date ?? ''}}</td>
               </tr>
            </tbody>
         </table>
         <hr>
         <table>
            <thead>
               <tr>
                  <th colspan="2">Daftar Karyawan</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($empSpkl->overtimes as $over)
                   <tr>
                     <td>{{$over->employee->nik}}</td>
                     <td>{{$over->employee->biodata->fullName()}}</td>
                   </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
   
   <!-- End Row -->


</div>

<div class="modal fade" id="modal-release-spkl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog " role="document">
      <div class="modal-content text-dark">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body ">
            Release Form Pengajuan Multple Karyawan ? 
            <hr>
            <span class="text-muted">Mengirim Form Pengajuan ke atasan terkait untuk proses Approval</span>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary ">
               <a class="text-light" href="{{route('employee.spkl.release.multiple', enkripRambo($empSpkl->id))}}">Release</a>
            </button>
         </div>
      </div>
   </div>
</div>




@endsection