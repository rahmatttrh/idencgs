@extends('layouts.app')
@section('title')
Form Perubahan Absence
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         {{-- @if (auth()->user()->hasRole('Administrator'))
             @else
             @if ($user->id == $absenceEmp->leader_id || $user->id == $absenceEmp->manager_id)
               <li class="breadcrumb-item " aria-current="page"><a href="{{route('leader.absence')}}">Form Absensi</a></li>
                 @else
                 <li class="breadcrumb-item " aria-current="page"><a href="{{route('employee.absence')}}">Absensi</a></li>
             @endif
         @endif --}}
         
         <li class="breadcrumb-item active" aria-current="page">Detail Form Absensi</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">


         


         
         

         {{-- AKSI USER --}}
         @if($absenceEmp->status == 0)
            @if ($absenceEmp->type == 5 || $absenceEmp->type == 10)
               @if ($absenceEmployeeDetails)
                  @if (count($absenceEmployeeDetails) > 0)
                  <a href="" class="btn mb-2 btn-primary btn-block" data-target="#modal-release-absence-employee" data-toggle="modal">Release</a>
                  @else
                  <a href="#" class="btn mb-2 btn-light border text-muted btn-block" data-toggle="tooltip" data-placement="top" title="Anda belum memilih tanggal" >Release</a>
                  @endif 
                  @else
                  <a href="#" class="btn mb-2 btn-light border text-muted btn-block" data-toggle="tooltip" data-placement="top" title="Anda belum memilih Tanggal" >Release</a>
               @endif
                    
               @else

               <a href="" class="btn mb-2 btn-primary btn-block" data-target="#modal-release-absence-employee" data-toggle="modal">Release</a>
            @endif
         @endif
         @if($absenceEmp->status == 101 || $absenceEmp->status == 202 || $absenceEmp->status == 303)
         <a href="" class="btn mb-2 btn-primary btn-block" data-target="#modal-release-absence-employee" data-toggle="modal">Release Ulang</a>
         @endif



         {{-- VALIDASI HRD --}}
         @if (  $absenceEmp->status == 3 && auth()->user()->hasRole('HRD|HRD-Payroll|HRD-KJ12|HRD-KJ45|HRD-JGC'))
            
            <div class="btn-group btn-block" >
               <a href="#" class="btn btn-block  mb-2 btn-primary" data-target="#modal-approve-absence-employee-hrd" data-toggle="modal"><i class="fa fa-check"></i> Confirm</a>
               <a href="#" class="btn mb-2 btn-danger" data-target="#modal-reject-absence-employee-hrd" data-toggle="modal">Reject</a>
            </div>

            {{-- <div class=" btn-group btn-block" >
                        
               <a href="#" class="btn btn-block  mb-2 btn-primary" data-target="#modal-approve-absence-employee" data-toggle="modal">Approve</a>
               <a href="#" class="btn mb-2 btn-danger">Reject</a>
            </div> --}}
         @endif


         {{-- VALIDASI MANAGER --}}
         @if ($user)
            @if ($absenceEmp->manager != null)
               @if ($absenceEmp->manager_id == $user->id)
                  @if($absenceEmp->status == 2)
                  {{-- <a href="#" class="btn btn-block  mb-2 btn-primary" data-target="#modal-approve-absence-employee" data-toggle="modal">Approve as Manager</a> --}}
                  <div class=" btn-group btn-block" >
                     
                     <a href="#" class="btn btn-block  mb-2 btn-primary" data-target="#modal-approve-absence-employee" data-toggle="modal">Approve</a>
                     <a href="#" class="btn mb-2 btn-danger" data-target="#modal-reject-absence-employee" data-toggle="modal">Reject</a>
                  </div>
                  
                  
                  
                  @endif
                  
               @endif
            @endif
         @endif

         {{-- VALIDASI ASMEN --}}
         @if (  $absenceEmp->status == 2 && auth()->user()->hasRole('Asst. Manager'))
            
            <div class="btn-group btn-block" >
               <a href="#" class="btn btn-block  mb-2 btn-primary" data-target="#modal-approve-absence-employee-man" data-toggle="modal">Approve as Man. </a>
               <a href="#" class="btn mb-2 btn-danger" data-target="#modal-reject-absence-employee" data-toggle="modal">Reject</a>
            </div>

            {{-- <div class=" btn-group btn-block" >
                        
               <a href="#" class="btn btn-block  mb-2 btn-primary" data-target="#modal-approve-absence-employee" data-toggle="modal">Approve</a>
               <a href="#" class="btn mb-2 btn-danger">Reject</a>
            </div> --}}
         @endif

         {{-- VALIDASI LEADER --}}
         @if ($absenceEmp->leader != null)
            @if ($absenceEmp->leader->nik == auth()->user()->username)
               @if($absenceEmp->status == 1)
               <span class="btn btn-group btn-block p-0" >
                  @if ($absenceEmp->type == 5)
                     @if ($absenceEmp->cuti_backup_id != null)
                     <a href="" class="btn btn-block  mb-2 btn-primary" data-target="#modal-approve-absence-employee" data-toggle="modal">Approve</a>
                     @else
                     <a href="#" class="btn btn-block  mb-2 btn-light border" data-toggle="tooltip" data-placement="top" title="Anda belum memilih Karyawan Pengganti">Approve</a>
                     @endif
                     @else
                     <a href="" class="btn btn-block  mb-2 btn-primary" data-target="#modal-approve-absence-employee" data-toggle="modal">Approve</a>
                  @endif
                  
                  <a href="#" class="btn mb-2 btn-danger" data-target="#modal-reject-absence-employee" data-toggle="modal">Reject</a>
               </span>

               @if ($absenceEmp->type == 5)
                  <form action="{{route('employee.absence.update.pengganti')}}" method="POST">
                     @csrf
                     @method('put')
                     <input type="number" name="absence_employee" id="absence_employee" value="{{$absenceEmp->id}}" hidden>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group form-group-default">
                              <label>Karyawan Pengganti</label>
                              <select class="form-control"  name="cuti_backup" id="cuti_backup">
                                 <option value="" disabled selected>Select</option>
                                 
                                 {{-- @foreach ($myteams as $team)
                                 <option {{$team->employee->id == $absenceEmp->cuti_backup_id ? 'selected' : ''}} value="{{$team->employee->id}}">{{$team->employee->biodata->fullName()}} </option>
                                 @endforeach --}}

                                 @foreach ($emps as $emp)
                                 <option {{$emp->id == $absenceEmp->cuti_backup_id ? 'selected' : ''}} value="{{$emp->id}}">{{$emp->biodata->fullName()}} </option>
                                 @endforeach
                                 
                              </select>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <button class="mb-2 btn btn-primary btn-block" type="submit">Update</button>
                        </div>
                     </div>
                  </form>
               @endif
               
               <hr>
               
               
               
               @endif
               
            @endif
         @endif

        
         

         {{-- <div class=" btn-group btn-block" >
                     
            <a href="#" class="btn btn-block mb-2 btn-primary" data-target="#modal-approve-absence-employee" data-toggle="modal">Approve </a>
            <a href="#" class="btn  mb-2 btn-danger">Rejecttt</a>
         </div>
         <a href="{{route('employee.absence.draft')}}" class="btn btn-block btn-light mb-2 border"><i class="fa fa-backward"></i> Kembali ke Draft</a> --}}


         {{-- BACK BUTTON --}}
         @if ($pageType == 'draft')
            <a href="{{route('employee.absence.draft')}}" class="btn btn-block btn-light mb-2 border"><i class="fa fa-backward"></i> Kembali ke Draft</a>
            @elseif ($pageType == 'index')
            <a href="{{route('employee.absence')}}" class="btn btn-block btn-light mb-2 border"><i class="fa fa-backward"></i> Kembali ke Abence List</a>
            @elseif ($pageType == 'progress')
            <a href="{{route('employee.absence.pending')}}" class="btn btn-block btn-light mb-2 border"><i class="fa fa-backward"></i> Kembali ke Progress List</a>
            @elseif ($pageType == 'approval')
            <a href="{{route('leader.absence')}}" class="btn btn-block btn-light mb-2 border"><i class="fa fa-backward"></i> Kembali ke Approval List</a>
         @endif

         <table class=" p-0">
            @if ($absenceEmp->status == 101 || $absenceEmp->status == 202)
                @php
                    $bg = 'background-color: rgb(243, 36, 36)';
                @endphp
                @else
                @php
                    $bg = '';
                @endphp
            @endif
            <thead>
               <tr class="{{$bg}}">
                  <th colspan="3 " class="text-uppercase">{{$absenceEmp->code}} (ID:{{$absenceEmp->id}})</th>
               </tr>
               <tr>
                  <th style="{{$bg}}" colspan="3 " class="text-uppercase"><x-status.absence-type :absence="$absenceEmp" /> : <x-status.form :form="$absenceEmp" /> </th>
               </tr>
               @if ($absenceEmp->status == 101 || $absenceEmp->status == 202 || $absenceEmp->status == 303 )
                   <tr>
                     <td colspan="3">
                        @if ($absenceEmp->status == 303)
                        HRD
                            @else
                            {{$absenceEmp->rejectBy->biodata->fullName()}}
                        @endif
                     </td>
                   </tr>
                   <tr>
                     <td colspan="3">{{$absenceEmp->reject_desc}}</td>
                   </tr>
                   <tr>
                     <td colspan="3">{{formatDateTime($absenceEmp->reject_date)}}</td>
                   </tr>
               @endif

               @if ($absenceEmp->reject_desc != null)
                   <tr>
                     <td>Revisi</td>
                     <td>{{$absenceEmp->reject_desc}}</td>
                   </tr>
               @endif
               @if ($absenceEmp->type == 10)
                   <tr>
                     <th colspan="3">{{$absenceEmp->permit->name ?? ''}} ({{$absenceEmp->permit->qty ?? ''}} Hari)</th>
                   </tr>
               @endif
               
            </thead>
            <tbody>
               
               @if ($absenceEmp->type == 6)
               <tr>
                  <td></td>
                  <td>{{$absenceEmp->type_desc}}</td>
               </tr>
                   
               @endif
               <tr>
                  {{-- <td></td> --}}
                  <td colspan="3">
                     @if (auth()->user()->username == $absenceEmp->employee->nik)
                        @if ($absenceEmp->status == 0 ||$absenceEmp->status == 101 ||$absenceEmp->status == 202 ||$absenceEmp->status == 303 )
                        <a  data-target="#modal-edit-absence-employee" data-toggle="modal" href="#" >Edit</a>
                         | 
                         <a data-target="#modal-delete-absence-employee" data-toggle="modal" href="#" >Delete</a> |
                         <div class="modal fade" id="modal-delete-absence-employee-{{$absenceEmp->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    @if ($absenceEmp->type == 6)
                                    SPT
                                    @elseif($absenceEmp->type == 4)
                                    Izin
                                    
                                    @endif
                                    
                                    {{-- tanggal {{formatDate($absenceEmp->date)}} --}}
                                    ?
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger ">
                                       <a class="text-light" href="{{route('employee.absence.delete', enkripRambo($absenceEmp->id))}}">Delete</a>
                                    </button>
                                 </div>
                              </div>
                           </div>
                        </div>
                        @endif
                     @endif

                     @if ($absenceEmp->status == 101 || $absenceEmp->status == 202 || $absenceEmp->status == 303)
                         @else
                         
                     @if ($absenceEmp->type == 6 )
                           <a href="{{route('export.spt', enkripRambo($absenceEmp->id))}}" target="_blank" class="">Export PDF</a>
                        @endif
                        @if ($absenceEmp->type == 5)
                        <a href="{{route('export.cuti', enkripRambo($absenceEmp->id))}}" target="_blank" class="">Export PDF</a>
                     @endif
                     @endif
                     


                     
                  </td>
               </tr>
               
              
            </tbody>
         </table>

        
            
       
         
         <table class="">
            <thead>
               @if ($absenceEmp->status == 0 || $absenceEmp->status == 101 || $absenceEmp->status == 202 || $absenceEmp->status == 303)
                   @if ($absenceEmp->type == 5 || $absenceEmp->type == 7 || $absenceEmp->type == 10)
                   <form action="{{route('employee.absence.detail.store')}}" method="POST">
                     @csrf
                     <tr>
                        <td colspan="3">
                           
                              <input type="number" name="absence_employee" id="absence_employee" value="{{$absenceEmp->id}}" hidden>
                              <input type="date" max="9/4/2025" class="form-control" style="width: 100%" required  id="date" name="date">
                              
                           
                        </td>
                        
                     </tr>
                     <tr>
                        <td colspan="3"><button class="btn border btn-block text-info" type="submit"><i class="fa fa-plus"></i> Tambah Tanggal</button></td>
                     </tr>
                  </form>
                   @endif
               @endif
               @if ($absenceEmp->type == 10)
                   <tr>
                     <th colspan="3">{{$absenceEmp->permit->name ?? ''}} ({{$absenceEmp->permit->qty ?? ''}} Hari)</th>
                   </tr>
               @endif
               
            </thead>
            <tbody>
               {{-- <tr>
                  <td>{{$user}}</td>
               </tr> --}}
               
               @if ($user || auth()->user()->hasRole('Administrator'))
                   
                  
                  @if ($absenceEmp->type == 5 || $absenceEmp->type == 7)
                  {{-- <tr>
                     <td>OK</td>
                  </tr> --}}
                  {{-- <tr>
                     <td colspan="3">{{count($absenceEmployeeDetails)}} Hari</td>
                  </tr> --}}
                     @foreach ($absenceEmployeeDetails as $detail)
                     <tr>
                        {{-- <td></td> --}}
                        <td>
                           {{-- {{formatDayName($detail->date)}} <br> --}}
                            {{formatDate($detail->date)}} 
                           

                        {{-- {{$employee->n}} --}}
                           
                        </td>
                        {{-- @if (auth()->user()->hasRole('Karyawan'))
                        <td>-</td> --}}
                            {{-- @else --}}
                           <td>
                              @if ($absenceEmp->status == 0 || $absenceEmp->status == 101 || $absenceEmp->status == 202 || $absenceEmp->status == 303)
                              <a href="{{route('employee.absence.detail.delete', enkripRambo($detail->id))}}">Remove</a>
                              @endif

                              @if (auth()->user()->hasRole('Administrator'))
                              @else
                              @if ($user->id == $absenceEmp->leader_id && $absenceEmp->status == 1)
                                 <a href="#"  data-target="#modal-edit-tanggal-{{$detail->id}}" data-toggle="modal">Change</a> | <a data-toggle="modal" data-target="#modal-reject-tanggal-{{$detail->id}}" href="#">Reject</a>
                                 
                                 <div class="modal fade" id="modal-edit-tanggal-{{$detail->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm" role="document">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h5 class="modal-title" id="exampleModalLabel">Form Edit Tanggal</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          <form action="{{route('employee.absence.detail.update')}}" method="POST" >
                                             <div class="modal-body">
                                                @csrf
                                                @method('PUT')
                                                   {{-- <input type="number" name="employee" id="employee" value="{{$employee->id}}" hidden> --}}
                                                   <input type="number" name="detail" id="detail" value="{{$detail->id}}" hidden>
                                                   <div class="form-group form-group-default">
                                                      <label>Date</label>
                                                      <input type="date" class="form-control"  name="date" id="date" value="{{$detail->date}}"  >
                                                   </div>
                                                   <div class="form-group form-group-default">
                                                      <label>Remark</label>
                                                      <input type="text" class="form-control"  name="remark" id="remark" value="{{$detail->remark}}"  >
                                                   </div>
                                                   
                                             </div>
                                             <div class="modal-footer">
                                                <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary ">Update</button>
                                             </div>
                                          </form>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="modal fade" id="modal-reject-tanggal-{{$detail->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm" role="document">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h5 class="modal-title" id="exampleModalLabel">Form Reject Tanggal Cuti</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          
                                             <div class="modal-body">
                                                
                                                   {{-- <input type="number" name="employee" id="employee" value="{{$employee->id}}" hidden> --}}
                                                   {{formatDayName($detail->date)}} <br>
                                                   {{formatDate($detail->date)}}
                                                   <hr>
                                                   <span class="text-muted">Tanggal diatas akan dihapus dari rencana cuti karyawan</span>
                                                   
                                             </div>
                                             <div class="modal-footer">
                                                
                                                <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                                                {{-- <button type="submit" class="btn btn-primary ">Update</button> --}}
                                                <a class="btn btn-primary " href="{{route('employee.absence.detail.reject', enkripRambo($detail->id))}}">Reject</a>
                                             </div>
                                          
                                       </div>
                                    </div>
                                 </div>
                                 
                                 
                              @endif
                              @endif
   
                              @if (auth()->user()->hasRole('Administrator'))
                              @else
                              @if ($user->id == $absenceEmp->manager_id && $absenceEmp->status == 2)
                                 <a href="#"  data-target="#modal-edit-tanggal-{{$detail->id}}" data-toggle="modal">Change</a> | <a href="#modal-reject-tanggal-{{$detail->id}}">Reject</a>
                                 
                                 <div class="modal fade" id="modal-edit-tanggal-{{$detail->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm" role="document">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h5 class="modal-title" id="exampleModalLabel">Form Edit Tanggal</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          <form action="{{route('employee.absence.detail.update')}}" method="POST" >
                                             <div class="modal-body">
                                                @csrf
                                                @method('PUT')
                                                   {{-- <input type="number" name="employee" id="employee" value="{{$employee->id}}" hidden> --}}
                                                   <input type="number" name="detail" id="detail" value="{{$detail->id}}" hidden>
                                                   <div class="form-group form-group-default">
                                                      <label>Date</label>
                                                      <input type="date" class="form-control"  name="date" id="date" value="{{$detail->date}}"  >
                                                   </div>
                                                   <div class="form-group form-group-default">
                                                      <label>Remark</label>
                                                      <input type="text" class="form-control"  name="remark" id="remark" value="{{$detail->remark}}"  >
                                                   </div>
                                                   
                                             </div>
                                             <div class="modal-footer">
                                                <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary ">Update</button>
                                             </div>
                                          </form>
                                       </div>
                                    </div>
                                 </div>


                                 <div class="modal fade" id="modal-reject-tanggal-{{$detail->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm" role="document">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h5 class="modal-title" id="exampleModalLabel">Form Reject Tanggal Cuti</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          
                                          <div class="modal-body">
                                                
                                             {{-- <input type="number" name="employee" id="employee" value="{{$employee->id}}" hidden> --}}
                                             {{formatDayName($detail->date)}} <br>
                                             {{formatDate($detail->date)}}
                                             <hr>
                                             <span class="text-muted">Tanggal diatas akan dihapus dari rencana cuti karyawan</span>
                                             
                                       </div>
                                       <div class="modal-footer">
                                          
                                          <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                                          {{-- <button type="submit" class="btn btn-primary ">Update</button> --}}
                                          <a class="btn btn-primary " href="{{route('employee.absence.detail.reject', enkripRambo($detail->id))}}">Reject</a>
                                       </div>
                                          
                                       </div>
                                    </div>
                                 </div>
                                 
                                 
                              @endif
                              @endif

                              @if (auth()->user()->hasRole('HRD-Payroll') && $absenceEmp->status == 3)
                             
                              <a href="#"  data-target="#modal-remove-date-{{$detail->id}}" data-toggle="modal">Remove</a>
                              {{-- <a href="{{route('employee.absence.detail.delete', enkripRambo($detail->id))}}">Remove</a> --}}
                              <div class="modal fade" id="modal-remove-date-{{$detail->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                 <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Remove Date</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       {{-- <form action="{{route('employee.absence.detail.update')}}" method="POST" > --}}
                                          <div class="modal-body">
                                             Hapus Tanggal {{formatDate($detail->date)}} dari Form Absensi ?
                                          </div>
                                          <div class="modal-footer">
                                             <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                                             {{-- <button type="submit" class="btn btn-primary ">Update</button> --}}
                                             <a href="{{route('employee.absence.detail.delete', enkripRambo($detail->id))}}" class="btn btn-danger ">Delete</a>
                                          </div>
                                       {{-- </form> --}}
                                    </div>
                                 </div>
                              </div>
                              @endif

                              @if (auth()->user()->hasRole('HRD-Payroll') || auth()->user()->hasRole('HRD-KJ12') || auth()->user()->hasRole('HRD-KJ45') || auth()->user()->hasRole('HRD-JGC') || auth()->user()->hasRole('Administrator'))
                                 @foreach ($alpha as $a)
                                     @if ($a->date == $detail->date)
                                     <a href="#" data-target="#modal-refund-absence-{{$detail->id}}" data-toggle="modal" >Refund</a>
                                     @endif
                                 @endforeach
                              
                              @endif
                           </td>
                        {{-- @endif --}}
                       
                     </tr>

                     @foreach ($alpha as $a)
                           @if ($a->date == $detail->date)
                           <tr>
                              <td colspan="2" class="text-danger">Potongan Alpha {{formatDate($detail->date)}}</td>
                           </tr>
                           
                           @endif
                     @endforeach
                     @if ($detail->additional_id != null)
                         <tr>
                           <td colspan="2"><i class="fa fa-check text-success"></i> Pengembalian {{formatDate($detail->additional->date)}}</td>
                         </tr>
                         <tr>
                           <td colspan="2"></td>
                         </tr>
                     @endif

                        @if ($detail->remark != null)
                           <tr>
                              <td></td>
                              <td colspan="2" class="text-muted">{{$detail->remark}}</td>
                           </tr>
                        @endif

                           <div class="modal fade" id="modal-refund-absence-{{$detail->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <div class="modal-dialog " role="document">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Confirmation<br>
                                       
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                                 <form action="{{route('employee.absence.refund')}}" method="POST" >
                                    <div class="modal-body">
                                       @csrf
                                       <input type="text" value="{{$detail->id}}" name="detail" id="detail" hidden>
                                       {{-- <span>Reject this Form Absence ?</span>
                                       <hr> --}}
                                       <div class="row">
                                          <div class="col-md-6">
                                             <div class="form-group form-group-default">
                                                <label>Pengembalian ke Tanggal</label>
                                                <input type="date" class="form-control" required  name="date" id="date"  >
                                             </div>
                                          </div>
                                       </div>
                                      
                                       <small>Potongan atas tanggal {{formatDate($detail->date)}} akan dikembalikan pada Periode Gaji Berikutnya (sesuai tanggal yang dipilih)</small> <br>
                                       <br>
                                       <small>Nominal Pengembalian akan otomatis masuk ke Tunjangan Lain-lain <br> (Menu Payroll -> Others)</small>
                                    </div>
                                    <div class="modal-footer">
                                       <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                                       <a href="{{route('employee.absence.refund.delete', enkripRambo($detail->id))}}" class="btn btn-light border">Remove</a>
                                       <button type="submit" class="btn btn-danger ">Refund</button>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>

                     @endforeach
                     
                  @endif
               @endif

              
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


         @if (auth()->user()->hasRole('Administrator'))
         <hr>
         <button class="btn btn-primary btn-block" data-target="#modal-update-administrator" data-toggle="modal">Update as Administrator</button>
             <form action="{{route('employee.absence.update.file')}}" method="POST" enctype="multipart/form-data">
               @csrf
               @method('PUT')
               <input type="text" name="id" id="id" value="{{$absenceEmp->id}}" hidden>
                  <div class="form-group form-group-default">
                     <label>File</label>
                     <input type="file" required class="form-control" id="doc" name="doc">
                  </div>
                  <button type="submit" class="btn btn-primary">Update</button>
             </form>
         @endif

         <hr>
         @if (auth()->user()->hasRole('Administrator'))
                HRD approved at {{$absenceEmp->app_hrd_date}}
         @endif


         

         @if ($absenceEmp->status == 0)
         <hr>
         <small>
            <b>#INFO</b> <br>
            @if ($absenceEmp->type == 5)
            Pilih 'Tanggal', dan klik tombol 'Plus' <br>
            @endif
            
            Klik 'Release' untuk meminta Approval pihak terkait
         </small>
         @endif

         @if ($absenceEmp->type == 5)
            @if ($user)
               @if ($user->id == $absenceEmp->leader_id)
                  <hr>
                  <small>
                     <b>#INFO</b> <br>
                     Anda dapat merubah tanggal ataupun mengurangi tanggal cuti <br> <br>
                     Perubahan yang anda lakukan akan terinfokan ke karyawan 
                  </small>
               @endif
            @endif
         @endif
         
         
         

        
        
         
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
         @if ($transfer == 1)
         
         <table>
            <tbody>
               <tr>
                  <td class="bg-danger text-white">
                     Form Absensi Telat diajukan / melewati tanggal Cut Off Payslip. <br>
                     Tanggal @foreach ($alpha as $a)
                          <b>{{formatDate($a->date)}}, </b>
                     @endforeach
                     terhitung Alpha
                  </td>
               </tr>
            </tbody>
         </table>
         @endif


         <x-absence.pdf :absenceemp="$absenceEmp" :absdetails="$absenceEmployeeDetails" :cuti="$cuti" :employee="$employee" />
         @if ($absenceEmp->type == 5)
            @if (count($sameDateForms) > 0)
               <table>
                  <thead>
                     <tr>
                        <th colspan="3">Cuti ditanggal yang sama</th>
                        
                     </tr>
                  </thead>
                  <tbody>
                     {{-- @foreach ($sameDateForms->where('absence_employee_id', '!=', $absenceEmp->id) as $same)
                     @if ($same->absence_employee)
                     <tr>
                        <td>{{formatDate($same->date)}}</td>
                        <td>
                           
                           {{$same->absence_employee->employee->biodata->fullName()}}
                           
                           
                        </td>
                        <td>
                           <x-status.form :form="$same->absence_employee" />

                        </td>
                     </tr>
                     @endif
                     @endforeach --}}
                     
                  </tbody>
               </table>
            @endif
         @endif
         
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
               <a class="text-light" href="{{route('employee.absence.release', enkripRambo($absenceEmp->id))}}">
                  Release
                  @if ($absenceEmp->status == 101 || $absenceEmp->status == 202 || $absenceEmp->status == 303)
                      Ulang
                  @endif
               </a>
            </button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-delete-absence-employee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content text-dark">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body ">
            Delete Form <x-status.absence-type :absence="$absenceEmp" />
            
            ?
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger ">
               <a class="text-light" href="{{route('employee.absence.delete', enkripRambo($absenceEmp->id))}}">Delete</a>
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

<div class="modal fade" id="modal-approve-absence-employee-man" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
               <a class="text-light" href="{{route('employee.absence.approve.man', enkripRambo($absenceEmp->id))}}">Approve as Manager</a>
            </button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-approve-absence-employee-hrd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content text-dark">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body ">
            Konfirmasi Pengajuan Form
            
            <x-status.absence :absence="$absenceEmp" /> <br>

            {{$absenceEmp->code}}
            
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary ">
               <a class="text-light" href="{{route('employee.absence.approve.hrd', enkripRambo($absenceEmp->id))}}">Confirm as HRD</a>
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

<div class="modal fade" id="modal-reject-absence-employee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm Reject<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('employee.absence.reject')}}" method="POST" >
            <div class="modal-body">
               @csrf
               <input type="text" value="{{$absenceEmp->id}}" name="absEmp" id="absEmp" hidden>
               <span>Reject this Form Absence ?</span>
               <hr>
               <div class="form-group form-group-default">
                  <label>Remark</label>
                  <input type="text" class="form-control" required  name="remark" id="remark"  >
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

<div class="modal fade" id="modal-reject-absence-employee-hrd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog " role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Reject Form Absensi by HRD<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('employee.absence.reject.hrd')}}" method="POST" >
            <div class="modal-body">

               @csrf
               @method('PUT')
               <input type="text" value="{{$absenceEmp->id}}" name="absEmpId" id="absEmpId" hidden>
               <span>Mengembalikan Form <x-status.absence-type :absence="$absenceEmp" /> ke User terkait untuk di Revisi</span><br>
               <table class="mt-2">
                  <tbody>
                     <tr>
                        <td>Jenis Form</td>
                        <td><x-status.absence-type :absence="$absenceEmp" /></td>
                     </tr>
                     <tr>
                        <td>Form ID</td>
                        <td>{{$absenceEmp->code}}</td>
                     </tr>
                     <tr>
                        <td>Karyawan</td>
                     <td>{{$absenceEmp->employee->nik}} {{$absenceEmp->employee->biodata->fullName()}}</td>
                     </tr>
                     
                     
                  </tbody>
               </table>
               <hr>
               <textarea name="reject_desc" id="reject_desc" cols="30" rows="3" required placeholder="Deskripsi penolakan..." class="form-control"></textarea>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-danger ">Reject</button>
            </div>
         </form>
      </div>
   </div>
</div>


<div class="modal fade" id="modal-edit-absence-employee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog " role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Form Absensi<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('employee.absence.update')}}" method="POST" enctype="multipart/form-data">
            <div class="modal-body">

               @csrf
               @method('PUT')
               <input type="text" value="{{$absenceEmp->id}}" name="absenceEmp" id="absenceEmp" hidden>
               <table class="mt-2">
                  <tbody>
                     <tr>
                        <td>Jenis Form</td>
                        <td><x-status.absence-type :absence="$absenceEmp" /></td>
                     </tr>
                     <tr>
                        <td>Form ID</td>
                        <td>{{$absenceEmp->code}}</td>
                     </tr>
                     
                     
                     
                  </tbody>
               </table>
               <hr>
               <div class="row">
                  @if ($absenceEmp->type != 5 && $absenceEmp->type != 7 && $absenceEmp->type != 10) 
                  <div class="col-md-12">
                     <div class="form-group form-group-default">
                        <label>Date</label>
                        <input type="date" required class="form-control" id="date" name="date" value="{{$absenceEmp->date}}">
                     </div>
                  </div>
                  @endif

                  <div class="col-md-6">
                     <div class="form-group form-group-default ">
                        <label>Atasan Langsung</label>
                        <select class="form-control "  name="leader" id="leader">
                           <option value="" disabled selected>Select</option>
                           @foreach ($employeeLeaders as $lead)
                              <option {{$lead->leader->id == $absenceEmp->leader_id ? 'selected' : ''}}  value="{{$lead->leader_id}}">{{$lead->leader->biodata->fullName()}}</option>
                           @endforeach
                           {{-- <option  value="4">Izin</option>
                           <option value="5">Cuti</option>
                           <option  value="6">SPT</option>
                           <option value="7">Sakit</option> --}}
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default ">
                        <label>Manager</label>
                        <select class="form-control "  name="manager" id="manager">
                           <option value="" disabled selected>Select</option>
                           @foreach ($managers as $man)
                              <option {{$man->id == $absenceEmp->manager_id ? 'selected' : ''}}  value="{{$man->id}}">{{$man->biodata->fullName()}}</option>
                           @endforeach
                           {{-- <option  value="4">Izin</option>
                           <option value="5">Cuti</option>
                           <option  value="6">SPT</option>
                           <option value="7">Sakit</option> --}}
                        </select>
                     </div>
                  </div>
                  
                 
                  {{-- IZIN --}}
                  @if ($absenceEmp->type == 4)
                  <div class="col-md-6 type_izin">
                     <div class="form-group form-group-default">
                        <label>Jenis Izin</label>
                        <select class="form-control"  name="type_izin" id="type_izin">
                           <option value="" disabled selected>Select</option>
                           <option {{$absenceEmp->type_desc == 'Setengah Hari' ? 'selected' : '' }} value="Setengah Hari">Setengah Hari</option>
                           <option value="Satu Hari">Satu Hari</option>
                        </select>
                     </div>
                  </div>
                  @endif


                  {{-- CUTI --}}
                  @if ($absenceEmp->type == 5)
               
                     
                     

                     
                     <div class="col-md-12">
                        <div class="form-group form-group-default">
                           <label>Keperluan</label>
                           <input type="text" class="form-control" id="keperluan" name="keperluan" value="{{$absenceEmp->desc}}">
                        </div>
                     </div>
               
                  @endif


                  {{-- SPT --}}
                  @if ($absenceEmp->type == 6)
                
                     
                  

                  
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
                              {{-- <option {{$absenceEmp->transport == 'Pesawat' ? 'selected' : ''  }} value="Pesawat">Pesawat</option> --}}
                              <option {{$absenceEmp->transport == 'Mobil' ? 'selected' : ''  }} value="Mobil">Mobil</option>
                              {{-- <option {{$absenceEmp->transport == 'Kereta' ? 'selected' : ''  }} value="Kereta">Kereta</option> --}}
                              <option {{$absenceEmp->transport == 'Motor' ? 'selected' : ''  }} value="Motor">Motor</option>
                              {{-- <option {{$absenceEmp->transport == 'Bus' ? 'selected' : ''  }} value="Bus">Bus</option> --}}
                              {{-- <option {{$absenceEmp->transport == 'Taxi' ? 'selected' : ''  }} value="Taxi">Taxi</option> --}}
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
                  

                  
                     <div class="col-6 ">
                        <div class="form-group form-group-default">
                           <label>Tanggal/Jam Berangkat</label>
                           <input type="datetime-local" class="form-control" id="departure" name="departure" value="{{$absenceEmp->departure}}">
                        </div>
                     </div>
                     <div class="col-6 ">
                        <div class="form-group form-group-default">
                           <label>Tanggal/Jam Kembali</label>
                           <input type="datetime-local" class="form-control" id="return" name="return" value="{{$absenceEmp->return}}">
                        </div>
                     </div>
                  

                  @endif


                  {{-- IZIN RESMI --}}
                  @if ($absenceEmp->type == 10)
                     <div class="col-md-12">
                        <div class="form-group form-group-default">
                           <label>Jenis Izin Resmi</label>
                           <select class="form-control"  name="permit" id="permit">
                              <option value="" disabled >Select</option>
                              @foreach ($permits as $permit)
                              <option {{$absenceEmp->permit_id == $permit->id ? 'selected' : ''}} value="{{$permit->id}}">{{$permit->name}} {{$permit->desc}} - {{$permit->qty}} Hari</option>
                              @endforeach
                              
                           </select>
                        </div>
                     </div>
                  @endif

                  {{-- IZIN --}}
                  @if ($absenceEmp->type == 4)
                     <div class="col-md-12 ">
                        <div class="form-group form-group-default">
                           <label>Jenis Izin</label>
                           <select class="form-control"  name="type_izin" id="type_izin">
                              {{-- <option value="" disabled selected>Select</option> --}}
                              <option {{$absenceEmp->type_desc == 'Setengah Hari' ? 'selected' : ''}} value="Setengah Hari">Setengah Hari</option>
                              <option {{$absenceEmp->type_desc == 'Satu Hari' ? 'selected' : ''}} value="Satu Hari">Satu Hari</option>
                           </select>
                           @error('type_izin')
                           <small class="text-danger">Ada kesalahan!</small>
                           @enderror
                        </div>
                     </div>
                     <div class="col-6 ">
                        <div class="form-group form-group-default">
                           <label>Dari </label>
                           <input type="time" class="form-control" id="permit_from" name="permit_from" value="{{formatTime($absenceEmp->departure)}}">
                           @error('permit_from')
                           <small class="text-danger">Ada kesalahan!</small>
                           @enderror
                        </div>
                     </div>
                     <div class="col-6 ">
                        <div class="form-group form-group-default">
                           <label>Sampai</label>
                           <input type="time" class="form-control" id="permit_to" name="permit_to" value="{{formatTime($absenceEmp->return)}}">
                           @error('permit_to')
                           <small class="text-danger">Ada kesalahan!</small>
                           @enderror
                        </div>
                     </div>
                     <div class="col-md-12">
                     <div class="form-group form-group-default">
                        <label>Description</label>
                        <textarea type="text" class="form-control" id="desc_izin" name="desc_izin" rows="3">{{$absenceEmp->desc}}</textarea>
                     </div>
                     </div>

                     
                  @endif

                  
               </div>

               <div class="form-group form-group-default">
                  <label>Document Lampiran</label>
                  <input type="file" class="form-control" id="doc" name="doc">
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary ">Update</button>
            </div>
         </form>
      </div>
   </div>
</div>



<div class="modal fade" id="modal-update-administrator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update as Administrator<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('employee.absence.reject')}}" method="POST" >
            <div class="modal-body">
               @csrf

               @if ($absenceEmp->type == 4)

               <div class="row">
                  <div class="col-md-8">

                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group date form-group-default">
                              <label>Date</label>
                              <input type="text" readonly  class="form-control" id="date" name="date" value="FORM IZIN">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group date form-group-default">
                              <label>Date</label>
                              <input type="date"  class="form-control" id="date" name="date" value="{{$absenceEmp->date}}">
                           </div>
                        </div>
                        <div class="col-md-6 ">
                           <div class="form-group form-group-default">
                              <label>Jenis Izin</label>
                              <select class="form-control"  name="type_izin" id="type_izin">
                              
                                 <option  {{$absenceEmp->type_izin == 'Setengah Hari' ? 'selected' : ''}} value="Setengah Hari">Setengah Hari</option>
                                 <option {{$absenceEmp->type_izin == 'Satu Hari' ? 'selected' : ''}} value="Satu Hari">Satu Hari</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-6 ">
                           <div class="form-group form-group-default">
                              <label>Awal/Akhir</label>
                              <select class="form-control"  name="remark" id="remark">
                                 <option value="" disabled selected>Select</option>
                                 <option {{$absenceEmp->remark == 'Tidak Absen Masuk' ? 'selected' : ''}} value="Tidak Absen Masuk">Tidak Absen Masuk</option>
                                 <option {{$absenceEmp->remark == 'Tidak Absen Pulang' ? 'selected' : ''}} value="Tidak Absen Pulang">Tidak Absen Pulang</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-6 ">
                           <div class="form-group form-group-default">
                              <label>Dari</label>
                              <input type="time" class="form-control" id="permit_from" name="permit_from" value="{{$absenceEmp->permit_from}}">
                           </div>
                        </div>
                        <div class="col-6 ">
                           <div class="form-group form-group-default">
                              <label>Sampai</label>
                              <input type="time" class="form-control" id="permit_to" name="permit_to" value="{{$absenceEmp->permit_to}}">
                           </div>
                        </div>

                        <div class="col-6 ">
                           <div class="form-group form-group-default ">
                              <label>Atasan</label>
                              <select class="form-control "  name="persetujuan" id="persetujuan">
                                 <option value="" disabled selected>Select</option>
                                 {{-- <option selected value="{{$leader->id}}">{{$leader->biodata->fullName()}}</option> --}}
                                 <option value="" disabled selected>Select</option>
                                 @foreach ($employeeLeaders as $lead)
                                    <option  value="{{$lead->leader->id}}">{{$lead->leader->biodata->fullName()}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        @if ($employee->designation_id == 6)
                            @else
                            <div class="col-6 ">
                              <div class="form-group form-group-default ">
                                 <label>Manager</label>
                                 <select class="form-control "  name="manager" id="manager">
                                    <option value="" disabled selected>Select</option>
                                    @foreach ($managers as $man)
                                       <option {{$absenceEmp->manager_id == $man->id ? 'selected' : ''}}  selected value="{{$man->id}}">{{$man->biodata->fullName()}}</option>
                                    @endforeach
                                    {{-- <option  value="4">Izin</option>
                                    <option value="5">Cuti</option>
                                    <option  value="6">SPT</option>
                                    <option value="7">Sakit</option> --}}
                                 </select>
                              </div>
                           </div>
                        @endif
                     </div>

                     
                        <div class="form-group form-group-default">
                           <label>Description</label>
                           <textarea type="text" class="form-control" id="desc_izin" name="desc_izin" rows="3">{{$absenceEmp->desc}}
                           </textarea>
                        </div>
                        <div class="form-group form-group-default">
                           <label>LAMPIRAN DOKUMEN (FOTO/PDF)</label>
                           <input type="file" class="form-control" id="doc" name="doc">
                        </div>
                     

                  </div>


                  <div class="col-md-4">
                     <div class="form-group form-group-default">
                        <label>Status</label>
                        <select class="form-control"  name="status" id="status">
                           <option {{$absenceEmp->status == 0 ? 'selected' : ''}} value="0">Draft</option>
                           <option {{$absenceEmp->status == 1 ? 'selected' : ''}}  value="1">Approval Atasan</option>
                           <option {{$absenceEmp->status == 2 ? 'selected' : ''}}  value="2">Approval Manager</option>
                           <option {{$absenceEmp->status == 2 ? 'selected' : ''}}  value="3">Verifikasi HRD</option>
                           <option {{$absenceEmp->status == 5 ? 'selected' : ''}}  value="5">Published</option>
                        </select>
                     </div>
                  </div>
               </div>
               
               
               
               <div class="row ">
                  
               </div>
               <div class="row">
                  
               </div>
               
               @endif
               
               
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary ">Update</button>
            </div>
         </form>
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