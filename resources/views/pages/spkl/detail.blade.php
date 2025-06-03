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
         {{-- <h4><b>SPKL SAYA</b></h4>
         <hr> --}}
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link  text-left pl-3" id="v-pills-basic-tab" href="{{route('employee.spkl')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               List SPKL
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('employee.spkl.progress')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Progress
            </a>
            
            <a class="nav-link  text-left pl-3" id="v-pills-personal-tab" href="{{route('employee.spkl.draft')}}" aria-controls="v-pills-personal" aria-selected="true">
               <i class="fas fa-user mr-1"></i>
               Draft
            </a>
           

            <a class="nav-link  text-left pl-3" id="v-pills-document-tab" href="{{route('employee.spkl.create')}}" aria-controls="v-pills-document" aria-selected="false">
               <i class="fas fa-file mr-1"></i>
               Form SPKL A
            </a>
            <a class="nav-link text-left pl-3" id="v-pills-document-tab" href="{{route('employee.spkl.create.multiple')}}" aria-controls="v-pills-document" aria-selected="false">
               <i class="fas fa-file mr-1"></i>
               Form SPKL B
            </a>
            
         </div>
         <hr>
         {{-- <form action="">
            <select name="" id="" class="form-control">
               <option value="">Januari</option>
               <option value="">Februari</option>
            </select>
         </form> --}}
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
         {{-- <h4>Detail Lembur/Piket</h4>
         <hr> --}}
         @if ($empSpkl->status == 0)
         <span class="btn btn-group btn-sm p-0 mb-2">
            <a href="" class="btn btn-primary btn-sm" data-target="#modal-release-spkl" data-toggle="modal">Release</a>
            <a href="" class="btn btn-light btn-sm border">Edit</a>
            <a href="" class="btn btn-light btn-sm border">Delete</a>
         </span>
         @elseif($empSpkl->status == 1)
         <a href="" class="btn btn-light btn-sm border mb-2">Approval Atasan</a>
         @endif
         
         <a href="" class="btn btn-light border btn-sm mb-2"><i class="fa fa-file"></i> Export PDF</a>
         <table>
            <tbody>
               {{-- <tr>
                  <td style="width: 150px">Status</td>
                  <td class="bg-secondary text-white">Draft</td>
               </tr> --}}
               <tr>
                  <td style="width: 150px">ID</td>
                  <td>{{$empSpkl->code}}</td>
               </tr>
               <tr>
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
                  <td>{{$empSpkl->employee->biodata->fullName()}}</td>
               </tr>
               <tr>
                  <td></td>
                  <td></td>
                  <td>{{$empSpkl->release_employee_date ?? ''}}</td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
   
   <!-- End Row -->


</div>

<div class="modal fade" id="modal-release-spkl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content text-dark">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body ">
            Release Form Pengajuan ? 
            <hr>
            Kirim Pengajuan ke atasan terkait untuk proses Approval
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary ">
               <a class="text-light" href="{{route('employee.spkl.release', enkripRambo($empSpkl->id))}}">Release</a>
            </button>
         </div>
      </div>
   </div>
</div>




@endsection