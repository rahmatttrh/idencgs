@extends('layouts.app')
@section('title')
Form Perubahan Absence
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">Form Perubahan Absence</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         
         @if($absenceEmp->status == 0)
               <a href="" class="btn btn-primary btn-block" data-target="#modal-release-absence-employee" data-toggle="modal">Release</a>
         @endif

         @if ($absenceEmp->leader != null)
            @if ($absenceEmp->leader->nik == auth()->user()->username)
               @if($absenceEmp->status <= 2)
               <a href="" class="btn  btn-primary" data-target="#modal-approve-absence-employee" data-toggle="modal">Approve</a>
               <a href="" class="btn  btn-danger">Reject</a>
               
               
               @endif
               
            @endif
         @endif

         @if ($absenceEmp->cuti_backup_id != null)
            @if ($absenceEmp->cuti_backup->nik == auth()->user()->username)
               @if($absenceEmp->status == 1)
               <a href="" class="btn btn-primary " data-target="#modal-approve-backup-absence-employee" data-toggle="modal">Approve</a>
               <a href="" class="btn btn-danger">Reject</a>
              
               @endif
            @endif
         @endif

         {{-- @if (auth()->user()->username == $absenceEmp->cuti_backup->nik)
            @if($absenceEmp->status == 1)
            <a href="" class="btn btn-primary btn-block" data-target="#modal-approve-absence-employee" data-toggle="modal">Approve</a>
            @endif
         @endif --}}
         
         <table class="mt-3">
            <thead>
               <tr>
                  <th colspan="2"><x-status.absence-type :absence="$absenceEmp" /> : <x-status.form :form="$absenceEmp" /> </th>
               </tr>
               
            </thead>
            <tbody>
               <tr>
                  <td></td>
                  <td>
                     @if (auth()->user()->username == $absenceEmp->employee->nik)
                        @if ($absenceEmp->status == 0 || $absenceEmp->status == 1 || $absenceEmp->status == 2)
                        <a href="{{route('employee.absence.edit', enkripRambo($absenceEmp->id))}}" >Edit</a> | <a href="{{route('employee.absence.delete', enkripRambo($absenceEmp->id))}}" >Delete</a>
                        @endif
                     @endif


                     
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td>
                     @if ($absenceEmp->type == 6)
                           <a href="{{route('export.spt', enkripRambo($absenceEmp->id))}}" target="_blank" class="">Export PDF</a>
                        @endif
                        @if ($absenceEmp->type == 5)
                        <a href="{{route('export.cuti', enkripRambo($absenceEmp->id))}}" target="_blank" class="">Export PDF</a>
                     @endif
                  </td>
               </tr>
            </tbody>
         </table>
         @if ($absenceEmp->absence_id != null)
         <table>
            <thead>
               
               <tr>
                  <th colspan="2">Absence</th>
               </tr>
            </thead>
            <tbody>
               {{-- <tr>
                  <t colspan="2">Perubahan Absence</td>
               </tr> --}}
               <tr>
                  <td></td>
                  <td> {{formatDate($absenceEmp->date)}}</td>
               </tr>
               <tr>
                  <td></td>
                  <td><x-status.absence-type :absence="$absenceEmp->absence"/> </td>
               </tr>
               <tr>
                  <td></td>
                  <td>{{$absenceEmp->absence->desc}} </td>
               </tr>
            </tbody>
         </table>
         <hr>
         @else 
         
         @endif
        
         
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">


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
            Release Form <x-status.absence-type :absence="$absenceEmp" />
            
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
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Backup</h5>
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


@push('myjs')
   <script>

      $(document).ready(function() {
         // console.log('report function');
         // $('#foto').hide();
         $('.type_spt').hide();
         $('.type_izin').hide();
         $('.type_late').hide();
         $('.type_cuti').hide();
         // $('.spt').hide();

         $('.type').change(function() {
            // console.log('okeee');
            var type = $(this).val();
            if (type == 6) {
            //   $('#foto').show();
              $('.type_spt').show();
              $('.type_izin').hide();
              $('.type_late').hide();
              $('.type_cuti').hide();
            } else if(type == 5) {
               //   $('#foto').show();
               $('.type_izin').hide();
               $('.type_spt').hide();
               $('.type_late').hide();
               $('.type_cuti').show();
            } else if(type == 4) {
               //   $('#foto').show();
               $('.type_izin').show();
               $('.type_spt').hide();
               $('.type_late').hide();
               $('.type_cuti').hide();
            } else  {
               //   $('#foto').show();
               $('.type_izin').hide();
               $('.type_spt').hide();
               $('.type_late').hide();
               $('.type_cuti').hide();
            } 
         })

         
      })
   </script>
@endpush




@endsection