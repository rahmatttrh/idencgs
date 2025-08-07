@extends('layouts.app')
@section('title')
Cuti Edit
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item active" aria-current="page">Cuti Edit</li>
      </ol>
   </nav>

   <div class="card shadow-none border ">
      
      {{-- <div class="card-header">
         
      </div> --}}

      <div class="card-body">
         <h4>Info Cuti Karyawan </h4>
         <hr>
         
         
            <div class="row">
               <div class="col-6">
                  <div class="card shadow-none">
                     <div class="card-header d-flex justify-content-between p-2 bg-primary text-white">
                        <small> <i class="fas fa-file-contract"></i> Periode Cuti</small>
                           
                              @if ($cuti->start)
                           <span>{{formatDate($cuti->start)}} - {{formatDate($cuti->end)}}</span>
                           @endif
                     </div>
                     <div class="card-header d-flex justify-content-end p-2 bg-primary text-white">
                        <small>  </small>
                           
                             
                           <span><b> Sisa Cuti {{$cuti->sisa}}</b></span>
                           
                     </div>
                     <div class="card-body p-0">
                        <div class="table-responsive " >
                           <table class="display  table-sm table-bordered  ">
                              
                            
                                 <tbody>
                                    @if ($cuti->employee->contract->type == 'Tetap')
                                       <tr>
                                          <td>JOIN</td>
                                          <td>{{formatDate($cuti->employee->join)}}</td>
                                       </tr>
                                       <tr>
                                          <td>PENETAPAN</td>
                                          <td>{{formatDate($cuti->employee->contract->determination)}}</td>
                                       </tr>
                                       @elseif($cuti->employee->contract->type == 'Kontrak')
                                       <tr>
                                          <td>PERIODE KONTRAK</td>
                                          <td>{{formatDate($cuti->employee->contract->start)}} - {{formatDate($cuti->employee->contract->end)}}</td>
                                       </tr>
                                    
                                    @endif
                                    <tr>
                                       <td></td>
                                    </tr>
                                    <tr>
                                       <td>NIK</td>
                                       <td>{{$cuti->employee->nik}}</td>
                                    </tr>
                                    <tr>
                                       <td>Name</td>
                                       <td><a href="{{route('employee.detail', [enkripRambo($cuti->employee->id), enkripRambo('basic')])}}">{{$cuti->employee->biodata->fullName()}}</a> </td>
                                    </tr>
                                    <tr>
                                       <td>Tipe</td>
                                       <td>{{$cuti->employee->contract->type}}</td>
                                    </tr>
                                    {{-- <tr>
                                       <td>Sisa Cuti</td>
                                       <td></td>
                                    </tr> --}}
            
                                   
                                 </tbody>
               
                           </table>
                        </div>
                     </div>
                     
                  </div>
                  {{-- <small>{{$cuti->employee->nik}}</small>
                  <h4>{{$cuti->employee->biodata->fullName()}}</h4>
                  <hr> --}}
                 
                  
                     {{-- <input type="text" name="cutiId" id="cutiId" value="{{$cuti->id}}" hidden> --}}
                     
                     <div class="card shadow-none ">
                        <div class="card-header d-flex justify-content-between p-2 bg-dark text-white">
                           <small> <i class="fas fa-file-contract"></i> Riwayat Cuti : {{count($absences)}}</small>
                           
                              
                           <span><a href="#" data-target="#modal-add-cuti-history" class="text-white" data-toggle="modal">Add</a> </span>
                           
                        
                        </div>
                        <div class="card-body p-0">
                           <div class="table-responsive overflow-auto" style="height: 150px">
                              <table id="data" class="display table-sm p-0">
                                 <thead>
                                    
                                    <tr>
                                       <th>Type</th>
                                       <th>Day</th>
                                       <th>Date</th>
                                       <th>Desc</th>
                                       <th></th>
                                    </tr>
                                 </thead>
            
                                 <tbody>
                                    @foreach ($absences as $absence)
                                    <tr>
                                       <td>Cuti</td>
                                       <td>{{formatDayName($absence->date)}}</td>
                                       <td>{{$absence->date}}</td>
                                       <td>{{$absence->desc}}</td>
                                       <td>
                                          <a href="#" data-target="#modal-delete-absence-{{$absence->id}}" data-toggle="modal">Delete</a>
                                       </td>
                                    </tr>

                                    <div class="modal fade" id="modal-delete-absence-{{$absence->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                       <div class="modal-dialog modal-sm" role="document">
                                          <div class="modal-content text-dark">
                                             <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                   <span aria-hidden="true">&times;</span>
                                                </button>
                                             </div>
                                             <div class="modal-body ">
                                                Delete data Cuti {{formatDate($absence->date)}} {{$absence->employee->biodata->fullName()}}
                                                ?
                                             </div>
                                             <div class="modal-footer">
                                                <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-danger ">
                                                   <a class="text-light" href="{{route('payroll.absence.delete', enkripRambo($absence->id))}}">Delete</a>
                                                </button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
            
                                   
                                    @endforeach
                                 </tbody>
            
                              </table>
                           </div>
                        </div>
                        <div class="card-footer">
                           {{-- <small class="text-muted">*Ini adalah 8 data QPE terkini, klik <a href="{{route('qpe')}}">Disini</a> untuk melihat seluruh data QPE.</small> --}}
                        </div>
                     </div>
                     
                     
                     
                     
                     
                  
               </div>
               
               <div class="col-md-6">
                  <h4>Form Update Cuti</h4>
                  
               <hr>
               <form action="{{route('cuti.update')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('put')
                  <input type="number" name="cutiId" id="cutiId" value="{{$cuti->id}}" hidden>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Periode Start</label>
                           <input type="date"  class="form-control" id="periode_start" name="periode_start" value="{{$cuti->start}}" >
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Periode End</label>
                           <input type="date"  class="form-control" id="periode_end" name="periode_end" value="{{$cuti->end}}" >
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Cuti Tahunan</label>
                           <input type="number"  class="form-control" id="tahunan" name="tahunan" value="{{$cuti->tahunan}}" >
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Cuti Masa Kerja</label>
                           <input type="number"  class="form-control" id="masa_kerja" name="masa_kerja" value="{{$cuti->masa_kerja}}" >
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Cuti Extend ( <b>Dipakai  {{$cuti->extend_left}}</b> )</label>
                           <input type="number"  class="form-control" id="extend" name="extend" value="{{$cuti->extend}}" >
                           
                        </div>
                        
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Cuti Extend Expired</label>
                           <input type="date"  class="form-control" id="expired" name="expired" value="{{$cuti->expired}}" >
                        </div>
                     </div>

                     {{-- <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Total Cuti</label>
                           <input type="number"  class="form-control" id="total" name="total" value="{{$cuti->total}}" >
                        </div>
                     </div> --}}
                     {{-- <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Cuti Digunakan</label>
                           <input type="number"  class="form-control" id="used" name="used" value="{{$cuti->used}}" >
                        </div>
                     </div> --}}
                     {{-- <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Sisa Cuti</label>
                           <input type="number"  class="form-control" id="sisa" name="sisa" value="{{$cuti->sisa}}" >
                        </div>
                     </div> --}}
                     
                     
                     
                  </div>
                  <hr>
                  <button class="btn btn-primary" type="submit">Update</button>
                  {{-- <div class="row">
                     <div class="col">
                        <div class="card shadow-none border">
                           <div class="card-header">
                              Total
                           </div>
                           <div class="card-body">
                              <h2>{{$cuti->total}}</h2>
                           </div>
                        </div>
                     </div>
                     <div class="col">
                        <div class="card shadow-none border">
                           <div class="card-header">
                              Used
                           </div>
                           <div class="card-body">
                              <h2>{{$cuti->used}}</h2>
                           </div>
                        </div>
                     </div>
                     <div class="col">
                        <div class="card shadow-none border">
                           <div class="card-header bg-info text-white">
                              Sisa
                           </div>
                           <div class="card-body">
                              <h2>{{$cuti->sisa}}</h2>
                           </div>
                        </div>
                     </div>
                  </div> --}}
                  
                  
                  
                  
                  {{-- <div class="form-group form-group-default">
                     <label>Document</label>
                     <input type="file"  class="form-control" id="doc" name="doc" >
                  </div> --}}
               </form>
               </div>
            </div>
        


      </div>


   </div>
   <!-- End Row -->


</div>

<div class="modal fade" id="modal-add-cuti-history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Add Riwayat Cuti<br>
               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('payroll.absence.store')}}" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
               @csrf
               <input type="number" name="employee" id="employee" value="{{$cuti->employee_id}}" hidden >
               <input type="number" name="type" id="type" value="5" hidden >
               {{-- <input type="text" value="{{$unitTransaction->id}}" name="unitTransactionId" id="unitTransactionId" hidden> --}}
               {{-- <span>Submit this Report and send to HRD Manager?</span> --}}
               <div class="form-group form-group-default">
                  <label>Date*</label>
                  <input type="date" required class="form-control" id="date" name="date">
               </div>
               <div class="form-group form-group-default">
                  <label>Document</label>
                  <input type="file" class="form-control" id="doc" name="doc">
               </div>
                  
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary ">Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>




@endsection