@extends('layouts.app')
@section('title')
Form Absensi
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">Form Absensi</li>
      </ol>
   </nav>


   <div class="row">
      <div class="col-md-3">
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{ route('leader.absence') }}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Form Lembur/Piket
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{ route('leader.absence.history') }}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               History
            </a>
            
           
            
         </div>
         <hr>
         
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
         <h4>Detail Lembur/Piket</h4>
         <hr>
         @if ($empSpkl->status == 0)
         <span class="btn btn-group btn-sm p-0 mb-2">
            <a href="" class="btn btn-primary btn-sm" data-target="#modal-release-spkl" data-toggle="modal">Release</a>
            <a href="" class="btn btn-light btn-sm border">Edit</a>
            <a href="" class="btn btn-light btn-sm border">Delete</a>
         </span>
         @elseif($empSpkl->status == 1)
         {{-- <a href="" class="btn btn-light btn-sm border mb-2">Menunggu Approval Atasan</a> --}}
         @if ($approval == 1)
         <span class="btn btn-group btn-sm p-0 mb-2">
            <a href="" class="btn btn-primary btn-sm" data-target="#modal-release-spkl" data-toggle="modal">Approve</a>
            <a href="" class="btn btn-light btn-sm border">Reject</a>
         </span>
         @endif
         @endif
         
         <a href="" class="btn btn-light border btn-sm mb-2"><i class="fa fa-file"></i> Export PDF</a>
         <table>
            <tbody>
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
               {{-- <tr>
                  <td>Lokasi Pekerjaan</td>
                  <td></td>
               </tr> --}}
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
                     <span class="text-info">Released</span>
                     
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

   


</div>




@endsection