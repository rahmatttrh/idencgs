@extends('layouts.app')

@section('title')
Employee Overview
@endsection

@section('content')
<div class="page-inner">
   
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
        
         <li class="breadcrumb-item active" aria-current="page">Employee</li>
         
         <li class="breadcrumb-item active" aria-current="page">Overview</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-6">
         <div class="card">
            {{-- <div class="card-header bg-light border p-2">
               <small><b>Disiplin</b></small>
            </div> --}}
            <div class="card-body p-0">
               <table class=" ">
                  <thead>
                     <tr>
                        <th style="width: 100px">Nama</th>
                        <th>{{$employee->biodata->fullName()}}</th>
                     </tr>
                     <tr>
                        <th>NIK</th>
                        <th>{{$employee->nik}}</th>
                     </tr>
                     <tr>
                        <th>Position</th>
                        <th>{{$employee->position->name}}</th>
                     </tr>
                  </thead>
                  
               </table>
            </div>
         </div>
         {{-- <div class="card">
            <div class="card-body">
               <h4>{{$employee->biodata->first_name}} {{$employee->biodata->last_name}}</h4>
               <small>{{$employee->position->name}}</small>
            </div>
         </div> --}}
      </div>
      <div class="col-md-6">
         <form action="{{route('payroll.overtime.filter')}}" method="POST">
            @csrf
            <div class="row">
               
               <div class="col-md-4">
                  <div class="form-group form-group-default">
                     <label>From</label>
                     <input type="date" name="from" id="from"  class="form-control">
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group form-group-default">
                     <label>To</label>
                     <input type="date" name="to" id="to"  class="form-control">
                  </div>
               </div>
               <hr>
               <div class="col-md-4">
                  <button class="btn btn-block btn-primary" type="submit" >Filter</button>
               </div>
            </div>
         </form>  
      </div>
   </div>
   

   <div class="row">
      <div class="col-md-6">
         <div class="card">
            {{-- <div class="card-header bg-light border p-2">
               <small><b>Disiplin</b></small>
            </div> --}}
            <div class="card-body p-0">
               <table class=" ">
                  <thead>
                     <tr>
                        <th>Alpha</th>
                        <th colspan="3">{{count($disciplines->where('type', 1))}}</th>
                     </tr>
                     <tr>
                        <th>Terlambat</th>
                        <th colspan="3">{{$disciplines->where('type', 2)->sum('minute') / 30 }}</th>
                     </tr>
                     <tr>
                        <th>Sakit</th>
                        <th colspan="3">{{count($disciplines->where('type', 7))}}</th>
                     </tr>
                     <tr>
                        <th>Izin</th>
                        <th colspan="3">{{count($disciplines->where('type', 4))}}</th>
                     </tr>
                     <tr>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Desc</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($disciplines as $dis)
                         <tr>
                           <td>
                              @if ($dis->type == 1)
                                 Alpha
                                 @elseif($dis->type == 2)
                                 Terlambat ({{$dis->minute}} Menit)
                                 @elseif($dis->type == 3)
                                 ATL
                                 @elseif($dis->type == 4)
                                 Izin ({{$dis->type_izin}})
                                 @elseif($dis->type == 5)
                                 Cuti
                                 @elseif($dis->type == 6)
                                 SPT ({{$dis->type_spt}})
                                 @elseif($dis->type == 7)
                                 Sakit 
                                 @elseif($dis->type == 8)
                                 Dinas Luar
                                 @elseif($dis->type == 9)
                                 Off Kontrak
                                 @endif
                           </td>
                           <td>{{formatDate($dis->date)}}</td>
                           <td>{{$dis->desc}}</td>
                         </tr>
                     @endforeach
                     
                     
                     
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="card">
            {{-- <div class="card-header bg-light border p-2">
               <small><b>Lembur</b></small>
            </div> --}}
            <div class="card-body p-0">
               <table class=" ">
                  <thead>
                     <tr>
                        <th>Lembur</th>
                        <th colspan="3">{{count($overs->where('type', 1))}}</th>
                     </tr>
                     <tr>
                        <th>Piket</th>
                        <th colspan="3">{{count($overs->where('type', 2))}}</th>
                     </tr>
                     <tr>
                        <th>Type</th>
                        <th class="text-right">Date</th>
                        
                        <th class="text-center">Hours</th>
                        {{-- <td></td> --}}
                        @if (auth()->user()->hasRole('HRD|HRD-Payroll|Administrator'))
                        <th class="text-right">Rate</th>
                        @endif
                        <th>Desc</th>
                     </tr>
                  </thead>
                  
                  <tbody>
                     @foreach ($overs as $over)
                         <tr>
                           {{-- <td>{{++$i}}</td> --}}
                           <td>
                             
                              
                              @if ($over->type == 1)
                                  Lembur
                                  @else
                                  Piket
                              @endif
                           </td>
                           
                           <td class="text-right">
                              @if ($over->holiday_type == 1)
                                 <span  class="text-info ">
                                 @elseif($over->holiday_type == 2)
                                 <span class="text-danger">
                                 @elseif($over->holiday_type == 3)
                                 <span class="text-danger">LN -
                                 @elseif($over->holiday_type == 4)
                                 <span class="text-danger">LR -
                              @endif
                              <a href="#" data-target="#modal-overtime-doc-{{$over->id}}" data-toggle="modal" class="text-white">{{formatDate($over->date)}}</a>
                              </span>
                           </td>
                           
                           
                           <td class="text-center">
                              @if ($over->type == 1)
                                    @if ($over->employee->unit->hour_type == 1)
                                       {{$over->hours}}
                                       @elseif ($over->employee->unit->hour_type == 2)
                                       {{$over->hours}} ({{$over->hours_final}})
                                    @endif
                                  @else
                                  -
                              @endif
                              
                              
                           </td>
                           {{-- <td class="text-center">{{getMultiple($over->hours)}}</td> --}}
                           @if (auth()->user()->hasRole('HRD|HRD-Payroll|Administrator'))
                           <td class="text-right text-truncate">{{formatRupiah($over->rate)}}</td>
                           @endif
                           <td>{{$over->description}}</td>
                           
                         </tr>
   
                        
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
  
</div>

@endsection