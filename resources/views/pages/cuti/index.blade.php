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

   <div class="card shadow-none border col-md-12">
      <div class=" card-header">
         <x-cuti.cuti-tab :activeTab="request()->route()->getName()" />
      </div>

      <div class="card-body px-0">

         <div class="row">
            
            <div class="col-md-12">
              
               <div class="table-responsive">
                  <table id="data" class="display basic-datatables table-sm">
                     <thead>
                        <tr>
                           <th>NIK</th>
                           <th>Name</th>
                           <th>Type</th>
                           <th class="text-center">Tahunan</th>
                           <th class="text-center text-truncate">Masa Kerja</th>
                           <th class="text-center">Extend</th>
                           <th class="text-center">Total</th>
                           <th class="text-center">Dipakai</th>
                           <th class="text-center">Sisa</th>
                           <th>Periode</th>
                           {{-- <th></th> --}}
                        </tr>
                     </thead>
                     
                     <tbody>
                        @foreach ($cutis as $cuti)
                        @if ($cuti->employee->status == 1)
                            
                        
                        <tr>
                           <td class="text-truncate">{{$cuti->employee->nik}}</td>
                           <td class="text-truncate" style="max-width: 200px">
                              <a href="{{route('cuti.edit', enkripRambo($cuti->id))}}">{{$cuti->employee->biodata->fullName()}}</a>
                              
                           </td>
                           <td>{{$cuti->employee->contract->type}}</td>
                           <td class="text-center">{{$cuti->tahunan}}</td>
                           <td class="text-center">{{$cuti->masa_kerja}}</td>
                           <td class="text-center">{{$cuti->extend}}</td>
                           <td class="text-center">{{$cuti->total}}</td>
                           <td class="text-center">{{$cuti->used}}</td>
                           <th class="text-center">{{$cuti->sisa}}</th>
                           <td class="text-truncate">
                              @if ($cuti->start)
                                 <span>{{formatDate($cuti->start)}} - {{formatDate($cuti->end)}}</span>
                                 @endif
                           </td>
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
         <a href="{{route('overtime.refresh')}}">Refresh</a>
      </div>


   </div>
   <!-- End Row -->


</div>




@endsection