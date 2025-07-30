@extends('layouts.app')
@section('title')
SP Detail
@endsection
@section('content')

<style>
   html {
      -webkit-print-color-adjust: exact;
   }

   @media print {

      header,
      footer,
      nav,
      aside,
      .sidebar,
      .main-header,
      .hide, .master, .discuss {
         display: none;
      }

      .main-panel {
         width: 100%;
      }

      @page {
         size: auto;
         /* auto is the initial value */
         margin: 0mm;
         /* this affects the margin in the printer settings */
      }

   }
</style>

<div class="page-inner">
  
   <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-11">
         <div class="row hide align-items-center">
            <div class="col">

               <x-status.st :st="$st" />
               


               <h5 class="page-title">{{$st->code}}</h5>
               
            </div>
            <div class="col-auto">
               @if (auth()->user()->hasRole('HRD|HRD-Payroll'))
               <a href="{{route('st')}}" class="btn  btn-light border "> Back</a>
                   @else

                   
                   <a href="{{route('sp')}}" class="btn  btn-light border "> SP & Teguran List</a>
                   @if (auth()->user()->hasRole('Leader|Supervisor'))
                   
                     <a href="{{route('sp.leader.approval')}}" class="btn  btn-light border ">Approval List</a>
                       @elseif(auth()->user()->hasRole('Asst. Manager|Manager'))
                       
                       <a href="{{route('sp.manager.approval')}}" class="btn  btn-light border ">Approval List</a>
                   @endif
               @endif
               
                  @if (auth()->user()->hasRole('Administrator|HRD|HRD-Payroll|HRD-Recruitment'))
                     @if ($st->status == 2 )
                     <div class="btn-group ">
                        <a href="#" class="btn  btn-danger" data-toggle="modal" data-target="#modal-delete-st"><i class="fa fa-trash"></i> Delete</a>
                        <a href="#" class="btn  btn-dark " ><i class="fa fa-edit"></i>Edit</a>
                     </div>
                     @endif

                     @if ( $st->status == 1)
                     <div class="btn-group ">
                        <a href="#" class="btn  btn-danger" data-toggle="modal" data-target="#modal-delete-st"><i class="fa fa-trash"></i> Reject</a>
                        {{-- <a href="#" class="btn  btn-dark " ><i class="fa fa-edit"></i>Reject</a> --}}
                     </div>
                     @endif
                  @endif

                  @if (auth()->user()->getEmployeeId() == $st->leader_id)
                     @if ($st->status == 1)
                        <div class="btn-group ">
                           <a href="#" class="btn  btn-danger" data-toggle="modal" data-target="#modal-delete-st"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                     @endif
                     @if ($st->status == 2)
                     <div class="btn-group ">
                        <a href="#" class="btn  btn-primary" data-toggle="modal" data-target="#modal-approve-st"><i class="fa fa-check"></i> Send to Manager</a>
                        <a href="#" class="btn  btn-danger " ><i class="fa fa-xmark"></i> Reject</a>
                     </div>
                     @endif
                  @endif

                  @if (auth()->user()->hasRole('Manager|Asst.Manager'))
                     @if ($st->status == 3)
                     <div class="btn-group ">
                        <a href="#" class="btn  btn-primary" data-toggle="modal" data-target="#modal-approve-st"><i class="fa fa-check"></i> Approve</a>
                        <a href="#" class="btn  btn-danger " ><i class="fa fa-xmark"></i> Reject</a>
                     </div>
                     @endif
                  @endif

                  @if (auth()->user()->getEmployeeId() == $st->employee_id)
                     @if ($st->status == 4)
                     <div class="btn-group ">
                        <a href="#" class="btn  btn-primary" data-toggle="modal" data-target="#modal-approve-st"><i class="fa fa-check"></i> Confirmasi</a>
                        {{-- <a href="#" class="btn  btn-danger " ><i class="fa fa-xmark"></i> Reject</a> --}}
                     </div>
                     @endif
                  @endif
                  
                  {{-- <div class="btn btn-light border  ">Status : <x-status.st :st="$st" /></div> --}}


               @if ($st->status > 1 )
               <button type="button" class="btn shadow-lg btn-light border" onclick="javascript:window.print();">
                  <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
                  <i class="fa fa-print"></i>
                  Print
               </button>
               @endif
               

            </div>
            @if ($st->status != 1)
            <div class="col-md-12">
               <div class="card">
                  <div class="card-body">
                     Kronologi : {{$st->desc}}
                  </div>
               </div>
            </div>
            @endif
            
         </div>
         

         
         
         
         {{-- <div class="row hide align-items-center">
            <div class="col">

               
               


               <h5 class="page-title">{{$st->code}}</h5>

            </div>
            @if (auth()->user()->hasRole('HRD|HRD-Payroll|HRD-Recruitment'))
            <div class="col-auto">
               <a href="#" class="" data-toggle="modal" data-target="#modal-delete-st">Delete</a>
            </div>
            @endif
            
            
         </div> --}}

         @if ($st->status == 1)
             @if (auth()->user()->hasRole('HRD|HRD-Payroll'))
             <div class="card">
               <div class="card-header">
                  <b>Draft Teguran </b>
               </div>
               <div class="card-body">
                  <form action="{{route('st.hrd.approve')}}" method="POST" enctype="multipart/form-data">
                     @csrf
                     @method('PUT')
                     <div class="row">
                        <div class="col">
                           
                              <input type="hidden" name="st" id="st" value="{{$st->id}}">
                              <div class="form-group form-group-default">
                                 <label>Employee</label>
                                 <input type="text" readonly class="form-control" name="date_from" required id="date_from" value="{{$st->employee->biodata->fullName()}}">
                              </div>
                              <div class="row">
                                 
                                 <div class="col-md-5">
                                    <div class="form-group form-group-default">
                                       <label>Tanggal </label>
                                       <input type="date" class="form-control" name="date" required id="date" value="{{$st->date}}">
                                    </div>
                                 </div>
                                 {{-- <div class="col-md-7">
                                    
                                 </div> --}}
                              </div>
                              
                              <div class="form-group form-group-default">
                                 <label>Alasan</label>
                                 <input type="text" required class="form-control" name="desc" id="desc" value="{{$st->reason  }}">
                              </div>
                              <div class="form-group form-group-default">
                                 <label>Peraturan yang dilanggar</label>
                                 <input type="text" required class="form-control" name="rule" id="rule" value="{{old('rule')}}">
                              </div>
                              {{-- <div class="form-group form-group-default">
                                 <label>File attachment</label>
                                 <input type="file" class="form-control" name="date_from" required id="date_from" value="{{$sp->date_from}}">
                              </div> --}}
                              <hr>
                              <button type="submit" class="btn btn-primary">Approve</button>
                        
                        </div>
                        <div class="col">
                           <div class="form-group form-group-default">
                              <label>File attachment</label>
                              <input type="file" class="form-control" name="file"  id="file" >
                           </div>
                           <div class="form-group form-group-default">
                              <label>Kronologi</label>
                              <textarea class="form-control" rows="6" name="desc" id="desc" >{{$st->desc}}</textarea>
                           </div>
     
                           dibuat oleh : <br>
                            {{$st->byId->nik}} {{$st->byId->biodata->fullName()}} <br>
                            {{$st->created_at}}
                        </div>
                     </div>
                  </form>
               </div>
             </div>
             
             @endif
         @endif
         
             
         {{-- @if ($st->status > 1) --}}
         <div class="row">
            <div class="col-md-12">
               
               <div class="card card-invoice">
                  <div class="card-header text-center">
                     <br>
                     <h2><b>SURAT TEGURAN</b></h2>
                           <b>{{$st->code}}</b>
                  </div>
                  <div class="card-body pt-4 px-4" style="font-size: 16px">
                     {{-- <div class="d-flex justify-content-between">
                        <div>
                           <img src="{{asset('img/logo/enc2.jpg')}}" alt="company logo"><br>
                        </div>
                        <div class="text-center">
                           <h3><b>SURAT PERINGATAN {{$sp->level}}</b></h3>
                           <b>{{$sp->code}}</b>
                        </div>
                     </div> --}}
                     
                     {{-- <hr> --}}
                     <br>
                     <p >Kepada Yth.</p>
               
                     <div class="row">
                        <div class="col-12">
                           <div class="row">
                              <div class="col-3">Nama</div>
                              <div class="col">: {{$st->employee->biodata->fullName()}}</div>
                           </div>
                           <div class="row">
                              <div class="col-3">NIK</div>
                              <div class="col">: {{$st->employee->nik}}</div>
                           </div>
                           <div class="row">
                              <div class="col-3">Jabatan</div>
                              <div class="col">: {{$st->employee->position->name}}</div>
                           </div>
                           <div class="row">
                              <div class="col-3">Departemen/Divisi</div>
                              <div class="col">: {{$st->employee->department->name}}</div>
                           </div>
                           <div class="row mt-4">
                              <div class="col-12">Sehubungan dengan pelanggaran yang {{$gen}} lakukan, yaitu :</div>
                           </div>
                           <br>
                           <div class="row mb-1 mt-1">
                              <div class="col">
                                 <b>{{$st->reason}}</b>
                              </div>
                           </div>
                        </div>
                     </div>
               
                     <br>
                     Maka sesuai dengan peraturan yang berlaku ( <b>Peraturan Perusahaan {{$st->rule ?? '-'}}</b> ) kepada {{$gen}} diberikan sanksi berupa <b>SURAT TEGURAN</b>.
                     <br><br>
                     Setelah {{$gen}} menerima SURAT TEGURAN ini, diharapkan {{$gen}} dapat merubah sikap {{$gen}} dan kembali bekerja dengan baik. 
                     
                     <br><br> Semoga dapat dimengerti dan dimaklumi. 
               
                     
               
                     <br><br>
                     <div class="page-divider">

                  </div>
                  <table>
                     <tbody>
                        <tr>
                           <th>Diajukan oleh</th>
                           <th>Disetujui oleh</th>
                           <th>Diketahui oleh</th>
                           <th>Diterima</th>
                        </tr>
                        <tr>
                           <td style="height: 80px" class="">
                              @if ($st->leader_app_date != null)
                              
                                 {{$st->leader->biodata->fullName()}} <br>
                                 <small class="text-muted">{{$st->leader->position->name}}</small>
                                 @else
                                 -
                              @endif
                           </td>
                           <td>
                              @if ($st->manager_app_date != null)
                              
                                 {{$st->manager->biodata->fullName()}} <br>
                                 <small class="text-muted">{{$st->manager->position->name}}</small>
                                 @else
                                 -
                              @endif

                           </td>
                           <td>
                              @if ($st->hrd_id != null)
                              
                                 {{$st->hrd->biodata->fullName()}} <br>
                                 <small class="text-muted">{{$st->hrd->position->name}}</small>
                                 @else
                                 -
                              @endif
                              

                           </td>
                           <td>
                              @if ($st->employee_app_date != null)
                              
                                 {{$st->employee->biodata->fullName()}} <br>
                                 <small class="text-muted">{{$st->employee->position->name}}</small>
                                 @else
                                 -
                              @endif
                           </td>
                        </tr>
                        <tr>
                           <td>
                              @if ($st->leader_app_date != null)
                              {{formatDateTime($st->leader_app_date)}}
                              @else
                              -
                              @endif
                           </td>
                           <td>
                              @if ($st->manager_app_date != null)
                              {{formatDateTime($st->manager_app_date)}}
                              @else
                              -
                              @endif
                           </td>
                           <td>
                              @if ($st->hrd_app_date != null)
                              {{formatDateTime($st->hrd_app_date)}}
                              @else
                              -
                              @endif
                           </td>
                           <td>
                              @if ($st->employee_app_date != null)
                              {{formatDateTime($st->employee_app_date)}}
                              @else
                              -
                              @endif
                           </td>
                           
                        </tr>
                        {{-- Test : {{$sp->by->biodata->fullName()}} --}}
                        

                        @if ($st->note)
                        {{-- {{$sp->note}} --}}
                        <tr>
                           <td colspan="4">
                              @if ($st->note == 'Recomendation')
                                 <small style="font-size: 12px">Rekomendasi HRD</small>
                                 @else
                                 <small style="font-size: 12px">Excisting SP</small>
                              @endif
                           </td>
                        </tr>
                        @endif

                     </tbody>
                  </table>
                     
                  </div>
                  <br><br>
                  <div class="card-footer">
                     
                  </div>
               </div>
            </div>
         </div>

        
         {{-- @endif --}}
         
      </div>
      
      
      
   </div>
</div>

<div class="modal fade" id="modal-delete-st" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content text-dark">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body ">
            Delete Surat Teguran {{$st->code}} ?
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger ">
               <a class="text-light" href="{{route('st.delete', enkripRambo($st->id))}}">Delete</a>
            </button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-approve-st" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content text-dark">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body ">
            Approve Surat Teguran {{$st->code}} ?
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary ">
               <a class="text-light" href="{{route('st.approve', enkripRambo($st->id))}}">Approve</a>
            </button>
         </div>
      </div>
   </div>
</div>










{{-- <x-sp.modal.submit :sp="$sp" /> --}}





@endsection