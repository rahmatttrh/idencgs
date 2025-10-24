@extends('layouts.app')
@section('title')
Cuti
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item active" aria-current="page">Cuti Karyawan</li>
      </ol>
   </nav>

   <div class="card  col-md-12">
      <div class=" card-header">
         <x-cuti.cuti-tab :activeTab="request()->route()->getName()" />
      </div>

      <div class="card-body px-0">

         <div class="row">
            
            <div class="col-md-12">
              
               <div class="table-responsive">
                  <table id="data" class="display datatables-10 table-sm">
                     <thead>
                        <tr>
                           <th>NIK</th>
                           <th>Name</th>
                           <th>Type</th>
                           <th class="text-center">Tahunan</th>
                           <th class="text-center ">Masa <br> Kerja</th>
                           <th class="text-center">Extend</th>
                           <th class="text-center">Total</th>
                           <th class="text-center">Dipakai</th>
                           <th class="text-center">Sisa</th>
                           <th>Mulai</th>
                           <th>Berakhir</th>
                           {{-- <th></th> --}}
                        </tr>
                     </thead>
                     
                     <tbody>
                        @foreach ($cutis as $cuti)
                           
                           @if ($cuti->employee_id != null)
                               
                           
                           <tr>
                              <td class="text-truncate">{{$cuti->employee->nik}}</td>
                              <td class="text-truncate" >
                                 <a href="{{route('cuti.edit', enkripRambo($cuti->id))}}">{{$cuti->employee->biodata->fullName()}}</a>
                                 <br>
                                 <small>@if ($cuti->employee->contract->type == 'Tetap')
                                       
                                        Join  {{formatDate($cuti->employee->join)}} |
                                        Penetapan {{formatDate($cuti->employee->contract->determination)}}
                                       
                                          
                                       @elseif($cuti->employee->contract->type == 'Kontrak')
                                       Kontrak 
                                          {{formatDate($cuti->employee->contract->start)}} - {{formatDate($cuti->employee->contract->end)}}
                                      
                                    
                                    @endif</small>
                              </td>
                              <td>{{$cuti->employee->contract->type ?? 'z'}}</td>
                              <td class="text-center">{{$cuti->tahunan}}</td>
                              <td class="text-center">{{$cuti->masa_kerja}}</td>
                              <td class="text-center">{{$cuti->extend}}</td>
                              <td class="text-center">{{$cuti->total}}</td>
                              <td class="text-center">{{$cuti->used}}</td>
                              <th class="text-center">{{$cuti->sisa}}</th>
                              <td class="text-truncate">
                                 @if ($cuti->start)
                                    <span>{{$cuti->start}}</span>
                                    @else
                                    -
                                    @endif
                              </td>
                              <td class="text-truncate">
                                 @if ($cuti->end)
                                 {{$cuti->end}}
                                 @else
                                 -
                                 @endif
                              </td>
                              {{-- <td>
                                 @if ($cuti->employee->contract->type == 'Tetap')
                                       
                                        Join  {{formatDate($cuti->employee->join)}} /
                                        Penetapan {{formatDate($cuti->employee->contract->determination)}}
                                       
                                          
                                       @elseif($cuti->employee->contract->type == 'Kontrak')
                                       Kontrak 
                                          {{formatDate($cuti->employee->contract->start)}} - {{formatDate($cuti->employee->contract->end)}}
                                      
                                    
                                    @endif
                              </td> --}}
                              {{-- <td><a class="btn btn-sm btn-primary" href="{{route('cuti.edit', enkripRambo($cuti->id))}}">Edit</a></td> --}}
                           </tr>
                           @endif
                                    
                        @endforeach
                        
                     </tbody>
                     
                  </table>
               </div>
            </div>
         </div>


      </div>
      <div class="card-footer">
         {{-- <a href="{{route('overtime.refresh')}}">Refresh</a> --}}
      </div>


   </div>
   <!-- End Row -->


</div>




@endsection