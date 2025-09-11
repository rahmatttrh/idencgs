@extends('layouts.app')
@section('title')
Form Lembur/Piket
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         {{-- <li class="breadcrumb-item " aria-current="page"><a href="{{route('employee.spkl')}}">SPKL</a> </li> --}}
         
         <li class="breadcrumb-item active" aria-current="page">Detail Form SPKL</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         @if ($empSpkl->status == 0)
         <a href="" class="btn mb-2 btn-primary m btn-block" data-target="#modal-release-spkl" data-toggle="modal">Release</a>
         @endif

         @if ($empSpkl->status == 1 && auth()->user()->getEmployeeId() == $empSpkl->leader_id)
            @if (auth()->user()->hasRole('Leader|Supervisor|Asst. Manager'))
            <span class="btn btn-group btn-block p-0" >
               <a href="" class="btn mb-2 btn-primary  btn-block" data-target="#modal-approve-spkl" data-toggle="modal">Approve</a>
               <a href="#" class="btn mb-2 btn-danger" data-target="#modal-reject-spkl" data-toggle="modal">Reject</a>
               
            </span>
            @endif
         
         @endif

         @if ($empSpkl->status == 2)
            @if (auth()->user()->hasRole('Manager') )
            <span class="btn btn-group btn-block p-0" >
               <a href="" class="btn mb-2 btn-primary  btn-block" data-target="#modal-approve-spkl" data-toggle="modal">Approve </a>
               <a href="#" class="btn mb-2 btn-danger" data-target="#modal-reject-spkl" data-toggle="modal">Reject</a>
               
            </span>
            @endif
            @if ( auth()->user()->hasRole('Asst. Manager'))
            <span class="btn btn-group btn-block p-0" >
               <a href="" class="btn mb-2 btn-primary  btn-block" data-target="#modal-approve-manager-spkl" data-toggle="modal">Approve as Man.</a>
               <a href="#" class="btn mb-2 btn-danger" data-target="#modal-reject-spkl" data-toggle="modal">Reject</a>
               
            </span>
            @endif
         
         @endif
         @if ($type == 'approval')
            <a href="{{route('leader.spkl')}}" class="btn btn-block btn-light mb-2 border"><i class="fa fa-backward"></i> Kembali ke Approval SPKL</a>
            @elseif ($type == 'approval-hrd')
            <a href="{{route('hrd.spkl')}}" class="btn btn-block btn-light mb-2 border"><i class="fa fa-backward"></i> Kembali ke Approval SPKL</a>
            @elseif ($type == 'history-hrd')
            <a href="{{route('hrd.spkl.history')}}" class="btn btn-block btn-light mb-2 border"><i class="fa fa-backward"></i> Kembali ke History SPKL</a>
            @elseif($type == 'approval-spkl')
            <a href="{{route('hrd.spkl')}}" class="btn btn-block btn-light mb-2 border"><i class="fa fa-backward"></i> Kembali ke Approval SPKL</a>
            @elseif($type == 'index')
            <a href="{{route('spkl.team')}}" class="btn btn-block btn-light mb-2 border"><i class="fa fa-backward"></i> Kembali ke Progress SPKL</a>
            @elseif($type == 'index-employee')
            <a href="{{route('employee.spkl')}}" class="btn btn-block btn-light mb-2 border"><i class="fa fa-backward"></i> Kembali ke SPKL List</a>
            @elseif($type == 'draft')
            
            <a href="{{route('employee.spkl.draft')}}" class="btn btn-block btn-light mb-2 border"><i class="fa fa-backward"></i> Kembali ke Draft SPKL</a>
            @elseif($type == 'progress')
            
            <a href="{{route('employee.spkl.progress')}}" class="btn btn-block btn-light mb-2 border"><i class="fa fa-backward"></i> Kembali ke Progress SPKL</a>
         @endif
         <table >
            <thead>
               <tr>
                  <th>DETAIL SPKL
                     @if (auth()->user()->hasRole('Administrator'))
                         [ID:{{$empSpkl->id}}]
                     @endif
                  </th>
               </tr>
               
               <tr>
                  <th>{{$empSpkl->code}}</th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td>
                     <x-status.spkl-employee :empspkl="$empSpkl" />
                     
                  </td>
               </tr>
               @if ($empSpkl->status == 201)
                   <tr>
                     
                     <td class="bg-danger text-white">
                         {{formatDateTime($empSpkl->reject_leader_date)}}
                     </td>
                   </tr>
                   <tr>
                     <td class="bg-danger text-white">{{$empSpkl->leader->biodata->fullName()}}</td>
                   </tr>
                   <tr>
                     
                     <td class="bg-danger text-white">
                         {{$empSpkl->reject_leader_desc}}
                     </td>
                   </tr>
               @endif

               @if ($empSpkl->status == 301)
                   <tr>
                     
                     <td class="bg-danger text-white">
                         {{formatDateTime($empSpkl->reject_manager_date)}}
                     </td>
                   </tr>
                   <tr>
                     <td class="bg-danger text-white">{{$empSpkl->manager->biodata->fullName()}}</td>
                   </tr>
                   <tr>
                     
                     <td class="bg-danger text-white pl-4">
                        : {{$empSpkl->reject_manager_desc}}
                     </td>
                   </tr>
               @endif
               @if ($empSpkl->status == 401)
                   <tr>
                     
                     <td class="bg-danger text-white">
                         {{formatDateTime($empSpkl->reject_hrd_date)}}
                     </td>
                   </tr>
                   <tr>
                     <td class="bg-danger text-white">HRD</td>
                   </tr>
                   <tr>
                     
                     <td class="bg-danger text-white pl-4">
                        : {{$empSpkl->reject_hrd_desc}}
                     </td>
                   </tr>
               @endif
               <tr>
                  <td>
                     @if ($empSpkl->status == 0)
                        
                        <a href="{{route('employee.spkl.edit', enkripRambo($empSpkl->id))}}" class="" >Edit</a> |
                        <a href="#" class="" data-target="#modal-delete-spkl" data-toggle="modal">Delete</a> |
                     @endif
                     <a href="{{route('export.spkl', enkripRambo($empSpkl->id))}}" class="" target="_blank"> Export PDF</a>
                  </td>
               </tr>
            </tbody>
         </table>




         @if (auth()->user()->hasRole('HRD-Payroll|HRD-KJ12|HRD-KJ45|HRD-JGC'))
             
         
            @if ($empSpkl->status == 3 ||$empSpkl->status == 4 )
            <form action="{{route('employee.spkl.hrd.approve')}}" method="POST">
            <table>
               
                  @csrf
                  <input type="text" name="empSpkl" id="empSpkl" value="{{$empSpkl->id}}" hidden>
                  <tbody>
                     <tr><td colspan="2">Form Verifikasi</td></tr>
                     <tr>
                        <td>Tipe</td>
                        <td>
                           @if ($currentSpkl)
                           <select class="form-control " required name="type" id="type">
                              {{-- <option value="" disabled selected>Select</option> --}}
                              <option {{$currentSpkl->type == 1 ? 'selected' : ''}} value="1">Lembur</option>
                              <option {{$currentSpkl->type == 2 ? 'selected' : ''}}  value="2">Piket</option>
                           </select>
                           @else
                           <select class="form-control " required name="type" id="type">
                              {{-- <option value="" disabled selected>Select</option> --}}
                              <option {{$empSpkl->type == 1 ? 'selected' : ''}} value="1">Lembur</option>
                              <option {{$empSpkl->type == 2 ? 'selected' : ''}}  value="2">Piket</option>
                           </select>
                           @endif
                        </td>
                     </tr>
                     <tr>
                        <td>Hari</td>
                        <td>
                           @if ($currentSpkl)
                           <select class="form-control" required name="holiday_type" id="holiday_type">
                              {{-- <option value="" disabled selected>Select</option> --}}
                              <option {{$currentSpkl->holiday_type == 1 ? 'selected' : ''}} value="1">Hari Kerja</option>
                              <option {{$currentSpkl->holiday_type == 2 ? 'selected' : ''}} value="2">Hari Libur</option>
                              <option {{$currentSpkl->holiday_type == 3 ? 'selected' : ''}} value="3">Hari Libur Nasional</option>
                              <option {{$currentSpkl->holiday_type == 4 ? 'selected' : ''}} value="4">Hari Libur Idul Fitri</option>
                           </select>
                              @else
                              <select class="form-control" required name="holiday_type" id="holiday_type">
                                 {{-- <option value="" disabled selected>Select</option> --}}
                                 <option {{$empSpkl->holiday_type == 1 ? 'selected' : ''}} value="1">Hari Kerja</option>
                                 <option {{$empSpkl->holiday_type == 2 ? 'selected' : ''}} value="2">Hari Libur</option>
                                 <option {{$empSpkl->holiday_type == 3 ? 'selected' : ''}} value="3">Hari Libur Nasional</option>
                                 <option {{$empSpkl->holiday_type == 4 ? 'selected' : ''}} value="4">Hari Libur Idul Fitri</option>
                              </select>

                           @endif
                           
                           
                        </td>
                     </tr>
                     <tr>
                        <td>Jam</td>
                        <td>
                           @if ($currentSpkl)
                           <input class="form-control" type="text" name="hours" id="hours" value="{{$currentSpkl->hours}}">
                           @else
                           <input class="form-control" type="text" name="hours" id="hours" value="{{$empSpkl->hours}}">
                           @endif
                           
                        </td>
                     </tr>
                  
               </form>
            </table>
            @if ($currentSpkl)
            <button class="btn btn-block btn-secondary" type="submit">Update</button>
            @else
            <button class="btn btn-block btn-primary" type="submit">Submit</button>
            @endif
            @endif
         </tbody>

         <hr>
          @if ($empSpkl->status == 3 ||$empSpkl->status == 4 )
          <a href="#" class="btn btn-danger" data-target="#modal-cancel-spkl" data-toggle="modal">Cancel</a>
          @endif
         {{-- <hr> --}}
         {{-- <div class="card">
            <div class="card-body">
               <small>Klik Submit/Update untuk validasi SPKL</small>
            </div>
         </div> --}}
         @endif

         <hr>
         Dibuat oleh : <br>
         {{$empSpkl->by->nik}} {{$empSpkl->by->biodata->fullName()}} <br>
         {{$empSpkl->created_at}}
         @if ($empSpkl->parent_id != null)
             
         
         <hr>
         <a href="{{route('employee.spkl.detail.multiple', [enkripRambo($empSpkl->parent->id), enkripRambo('spkl')])}}">SPKL GROUP {{$empSpkl->parent->code}}</a>
         @endif
         
         
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
                  <td colspan="6">{{formatDateDayB($empSpkl->date)}}</td>
               </tr>
               <tr>
                  <td colspan="2">Waktu</td>
                  <td colspan="6">{{$empSpkl->hours_start}}  sd  {{$empSpkl->hours_end}}</td>
               </tr>
               @if ($empSpkl->type == 1)
               <tr>
                  <td colspan="2">Lama</td>
                  <td colspan="6">
                     @if ($currentSpkl)
                     {{$currentSpkl->hours}}
                           @else
                           {{$empSpkl->hours}}
                           @endif
                      Jam
                  </td>
               </tr>
               @endif
              
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
                  <td>Requested by <br> User</td>
                  <td>Approved by <br>Leader </td>
                  <td>Approved by <br>Manager </td>
               </tr>
               @if ($empSpkl->status == 201 || $empSpkl->status == 301)
                   @else
                   <tr>
                    
                     <td class="text-center py-3">
                        @if ($empSpkl->status > 0)
                        <span class="text-info">Released</span>
                        @else
                        
                        @endif
                     </td>
                     <td class="text-center">
                        @if ($empSpkl->status > 1)
                        <span class="text-info">Approved</span>
                        @else
                        
                        @endif
                     </td>
                     <td class="text-center">
                        @if ($empSpkl->status > 2)
                           @if ($empSpkl->asmen_id != null)
                           <span class="text-info">Approved by Assistant Manager</span>
                              @else
                              <span class="text-info">Approved</span>
                           @endif
                        
                        @else
                        
                        @endif
                     </td>
                     {{-- <td class="text-center py-3">
                        @if ($empSpkl->status > 0)
                        <span class="text-info">Released</span>
                        @else
                        
                        @endif
                        
                        
                     </td> --}}
                  </tr>
                  <tr>
                     <td>
                         {{$empSpkl->by->biodata->fullName()}}
                     </td>
                     <td class="">
                        @if ($empSpkl->leader_id != null)
                        {{$empSpkl->leader->biodata->fullName()}}
                        @else
                        
                        @endif
                     </td>
                     <td>
                        @if ($empSpkl->status > 2)
                           @if ($empSpkl->asmen_id != null)
                           {{$empSpkl->asmen->biodata->fullName()}}
                               @else
                               {{$empSpkl->manager->biodata->fullName()}}
                           @endif
                        
                        @else
                        
                        @endif
                     </td>
                     {{-- <td>{{$empSpkl->employee->biodata->fullName()}}</td> --}}
                  </tr>
                  <tr>
                     <td>
                        @if ($empSpkl->release_employee_date)
                            {{formatDateTime($empSpkl->release_employee_date)}}
                     @endif
                     </td>
                     <td>
                        @if ($empSpkl->approve_leader_date)
                            {{formatDateTime($empSpkl->approve_leader_date)}}
                        @endif
                        {{-- {{$empSpkl->approve_leader_date ?? ''}} --}}
                     </td>
                     <td>
                        @if ($empSpkl->approve_manager_date)

                            {{formatDateTime($empSpkl->approve_manager_date)}}
                        @endif
                        @if ($empSpkl->approve_asmen_date)
                           
                            {{formatDateTime($empSpkl->approve_asmen_date)}}
                        @endif
                        {{-- {{$empSpkl->approve_manager_date ?? ''}} --}}
                     </td>

                     
                     {{-- <td>
                        @if ($empSpkl->release_employee_date)
                            {{formatDateTime($empSpkl->release_employee_date)}}
                     @endif
                     </td> --}}
                  </tr>
               @endif
               
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

<div class="modal fade" id="modal-approve-spkl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content text-dark">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body ">
            Approve Form Pengajuan SPKL ? 
            <hr>
            
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary ">
               <a class="text-light" href="{{route('leader.spkl.approve', enkripRambo($empSpkl->id))}}">Approve</a>
            </button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-approve-manager-spkl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content text-dark">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body ">
            Approve Form Pengajuan SPKL ? 
            <hr>
            Data SPKL akan otomatis terkirim ke HRD untuk validasi
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary ">
               <a class="text-light" href="{{route('leader.spkl.manager.approve', enkripRambo($empSpkl->id))}}">Approve as Manager</a>
            </button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-reject-spkl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm Reject<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('leader.spkl.reject')}}" method="POST" >
            <div class="modal-body">
               @csrf
               <input type="text" value="{{$empSpkl->id}}" name="spklEmp" id="spklEmp" hidden>
               <span>Reject Pengajuan SPKL ?</span>
               <hr>
               <div class="form-group form-group-default">
                  <label>Remark</label>
                  <input type="text" class="form-control"  name="desc" required id="desc"  >
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

<div class="modal fade" id="modal-cancel-spkl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog " role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('employee.spkl.hrd.reject')}}" method="POST" >
            <div class="modal-body">
               @csrf
               <input type="text" value="{{$empSpkl->id}}" name="spklEmp" id="spklEmp" hidden>
               <span>
                  Cancel Pengajuan SPKL An.  {{$empSpkl->employee->nik}} {{$empSpkl->employee->biodata->fullName()}}
                  Tanggal {{formatDate($empSpkl->date)}}

               </span>
               <hr>
               <div class="form-group form-group-default">
                  <label>Remark</label>
                  <input type="text" class="form-control"  name="desc" required id="desc"  >
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-danger ">Cancel</button>
            </div>
         </form>
      </div>
   </div>
</div>




@endsection