@extends('layouts.app')
@section('title')
Form Lembur/Piket
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item " aria-current="page"><a href="{{route('employee.spkl')}}">SPKL</a> </li>
         
         <li class="breadcrumb-item active" aria-current="page">Detail Form SPKL</li>
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
                  <th>DETAIL SPKL</th>
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
                        
                        <a href="#" class="" >Edit</a> |
                        <a href="#" class="" data-target="#modal-delete-spkl" data-toggle="modal">Delete</a> |
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
         <a href="" class="btn btn-light btn-sm border mb-2">Approval Atasan</a>
         @endif
         
         <a href="" class="btn btn-light border btn-sm mb-2"><i class="fa fa-file"></i> Export PDF</a> --}}
         <table>
            <tbody>
               {{-- <tr>
                  <td style="width: 150px">Status</td>
                  <td class="bg-secondary text-white">Draft</td>
               </tr> --}}
               <tr>
                  <td class="text-center" colspan="2" rowspan="2">
                     <img src="{{asset('img/logo/enc1.png')}}" alt="" width="100">
                  </td>
                  <td class="text-center" colspan="4">
                     <h4>FORMULIR</h4>
                  </td>
                  <td class="text-center" colspan="2" rowspan="2">
                     <img src="{{asset('img/logo/ekanuri.png')}}" alt="" width="100"><br>
                     <span>PT Ekanuri</span>
                  </td>
               </tr>
               <tr class="text-center">
                  <td colspan="4">
                     <h4>PERMOHONAN 
                        @if ($empSpkl->type == 1)
                           SPKL
                            @else
                            PIKET
                        @endif
                     </h4>
                  </td>
               </tr>
               <tr class="text-center">
                  <td colspan="2">No. Dok : FM.PS.HRD.32</td>
                  <td colspan="4">Rev: 00/22</td>
                  <td colspan="2">Hal : 1 dari 1</td>
               </tr>
               <tr>
                  <td  colspan="2">ID</td>
                  <td colspan="6">{{$empSpkl->code}}</td>
               </tr>
               <tr>
                  <td  colspan="2">Nama</td>
                  <td colspan="6">{{$empSpkl->employee->biodata->fullName()}}</td>
               </tr>
               <tr>
                  <td colspan="2">NIK</td>
                  <td colspan="6">{{$empSpkl->employee->nik}}</td>
               </tr>
               <tr>
                  <td colspan="2">Jabatan</td>
                  <td colspan="6">{{$empSpkl->employee->position->name}}</td>
               </tr>
               <tr>
                  <td colspan="2">Departemen</td>
                  <td colspan="6">{{$empSpkl->employee->department->name}}</td>
               </tr>
               <tr>
                  <td colspan="2">Tanggal</td>
                  <td colspan="6">{{formatDate($empSpkl->date)}}</td>
               </tr>
               <tr>
                  <td colspan="2">Waktu</td>
                  <td colspan="6">{{$empSpkl->hours_start}}  sd  {{$empSpkl->hours_end}}</td>
               </tr>
               <tr>
                  <td colspan="2">Lama</td>
                  <td colspan="6">{{$empSpkl->hours}} Jam</td>
               </tr>
               <tr>
                  <td colspan="2">Pekerjaan</td>
                  <td colspan="6">{{$empSpkl->description}}</td>
               </tr>
               <tr>
                  <td colspan="2">Lokasi Pekerjaan</td>
                  <td colspan="6">{{$empSpkl->location}}</td>
               </tr>
            </tbody>
         </table>
         <table>
            <tbody>
               <tr>
                  <td>Requested by <br> Atasan Langsung</td>
                  <td>Approved by <br>Manager </td>
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

<div class="modal fade" id="modal-delete-spkl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content text-dark">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body ">
            Delete Form Pengajuan ? 
            <hr>
            data akan terhapus permanen dari sistem
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger ">
               <a class="text-light" href="{{route('employee.spkl.delete', enkripRambo($empSpkl->id))}}">Delete</a>
            </button>
         </div>
      </div>
   </div>
</div>




@endsection