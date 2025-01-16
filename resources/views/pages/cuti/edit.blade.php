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
      
      <div class="card-header">
         <h3>{{$cuti->employee->nik}} {{$cuti->employee->biodata->fullName()}}</h3>
      </div>

      <div class="card-body">
         
         <form action="{{route('cuti.update')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
               <div class="col-6">
                  <div class="row">
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
                           <div class="card-header bg-info text-white">
                              Sisa
                           </div>
                           <div class="card-body">
                              <h2>{{$cuti->sisa}}</h2>
                           </div>
                        </div>
                     </div>
                  </div>
                  <input type="text" name="cutiId" id="cutiId" value="{{$cuti->id}}" hidden>
                     
                     <div class="row">
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
                              <label>Cuti Extend</label>
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
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Cuti Digunakan</label>
                              <input type="number"  class="form-control" id="used" name="used" value="{{$cuti->used}}" >
                           </div>
                        </div>
                        {{-- <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Sisa Cuti</label>
                              <input type="number"  class="form-control" id="sisa" name="sisa" value="{{$cuti->sisa}}" >
                           </div>
                        </div> --}}
                        
                        
                        
                     </div>
                     <hr>
                     <button class="btn btn-primary" type="submit">Update</button>
                     
                     
                     
                     
                     
                  
               </div>
               <div class="col-md-6">
                  
                  
                  <div class="card">
                     <div class="card-header d-flex justify-content-between p-2 bg-dark text-white">
                        <small> <i class="fas fa-file-contract"></i> Periode</small>
                        
                           @if ($cuti->start)
                        <span>{{formatDate($cuti->start)}} - {{formatDate($cuti->end)}}</span>
                        @endif
                     
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
                                    {{-- <th></th> --}}
                                 </tr>
                              </thead>
         
                              <tbody>
                                 @foreach ($absences as $absence)
                                 <tr>
                                    <td>Cuti</td>
                                    <td>{{formatDayName($absence->date)}}</td>
                                    <td>{{formatDate($absence->date)}}</td>
                                    <td>{{$absence->desc}}</td>
                                    
                                 </tr>
         
                                
                                 @endforeach
                              </tbody>
         
                           </table>
                        </div>
                     </div>
                     <div class="card-footer">
                        {{-- <small class="text-muted">*Ini adalah 8 data QPE terkini, klik <a href="{{route('qpe')}}">Disini</a> untuk melihat seluruh data QPE.</small> --}}
                     </div>
                  </div>
                  
                  {{-- <div class="form-group form-group-default">
                     <label>Document</label>
                     <input type="file"  class="form-control" id="doc" name="doc" >
                  </div> --}}
                  
               </div>
            </div>
         </form>


      </div>


   </div>
   <!-- End Row -->


</div>




@endsection