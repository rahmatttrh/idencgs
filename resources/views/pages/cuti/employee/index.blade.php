@extends('layouts.app')
@section('title')
Cuti Info
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item active" aria-current="page">Info Cuti</li>
      </ol>
   </nav>

   <div class="card shadow-none border ">
      
      {{-- <div class="card-header">
         <h3>Info Cuti</h3>
      </div> --}}

      <div class="card-body">
         <h4>Info Cuti Karyawan </h4>
         <hr>
         
         <div class="row">
            <div class="col-md-7">
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
                              
                              <tbody>
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
                                    <td>{{$cuti->sisa}}</td>
                                 </tr> --}}
         
                                
                              </tbody>
            
                           </tbody>
                        </table>
                     </div>
                  </div>
                  
               </div>
               <div class="row">
                  <div class="col">
                     <div class="card shadow-none">
                  
                        <div class="card-body p-0">
                           <div class="table-responsive " >
                              <table class="display  table-sm table-bordered  ">
                                 <thead>
                                    <tr>
                                       <th colspan="2">Detail Cuti</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    
                                    <tbody>
                                       <tr>
                                          <td>Cuti Tahunan</td>
                                          <td class="text-center">{{$cuti->tahunan}}</td>
                                       </tr>
                                       <tr>
                                          <td>Cuti Masa Kerja</td>
                                          <td class="text-center">{{$cuti->masa_kerja}}</td>
                                       </tr>
                                       
                                       <tr>
                                          <td>Total</td>
                                          <td class="text-center">{{$cuti->tahunan + $cuti->masa_kerja}}</td>
                                       </tr>
               
                                      
                                    </tbody>
                  
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        
                     </div>
                  </div>
                  <div class="col">
                     @if ($cuti->employee->contract->type == 'Tetap')
                         
                     
                     <div class="card shadow-none">
                  
                        <div class="card-body p-0">
                           <div class="table-responsive " >
                              <table class="display  table-sm table-bordered  ">
                                 <thead>
                                    <tr>
                                       <th colspan="2">Cuti Tahun Sebelumnya</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    
                                    <tbody>
                                       <tr>
                                          <td>Kadaluarsa</td>
                                          <td class="text-center">@if ($cuti->expired)
                                             {{formatDate($cuti->expired)}}
                                             @endif</td>
                                       </tr>
                                       <tr>
                                          <td>
                                             Jumlah 
                                             
                                          </td>
                                          <td class="text-center">{{$cuti->extend}}</td>
                                       </tr>
                                       <tr>
                                          <td>
                                             Digunakan 
                                             
                                          </td>
                                          <td class="text-center">{{$cuti->extend_left}}</td>
                                       </tr>
                                      
                                       {{-- <tr>
                                          <td>Total</td>
                                          <td class="text-center">{{$cuti->total}}</td>
                                       </tr> --}}
               
                                      
                                    </tbody>
                  
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        
                     </div>
                     @endif
                  </div>
               </div>
               
              
               
            </div>
            <div class="col-md-5">
               <div class="card shadow-none border">
                  <div class="card-header d-flex justify-content-between p-2 bg-light">
                     <small> <i class="fas fa-file-contract"></i> Riwayat Cuti</small>
                     
                        
                     <span>{{count($absences)}}</span>
                     
                  
                  </div>
                  <div class="card-body p-0">
                     <div class="table-responsive overflow-auto" style="height: 250px">
                        <table id="data" class="display table-sm p-0">
                           <thead>
                              {{-- <tr>
                                 <th colspan="3">Riwayat Cuti</th>
                                 <th>{{count($absences)}}</th>
                              </tr> --}}
                              <tr>
                                 <th>Type</th>
                                 {{-- <th>Day</th> --}}
                                 <th>Date</th>
                                 <th>Desc</th>
                                 {{-- <th></th> --}}
                              </tr>
                           </thead>
      
                           <tbody>
                              @foreach ($absences as $absence)
                              <tr>
                                 <td>Cuti</td>
                                 {{-- <td>{{formatDayName($absence->date)}}</td> --}}
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
            </div>
            
         </div>


      </div>


   </div>
   <!-- End Row -->


</div>




@endsection