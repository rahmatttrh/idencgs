@extends('layouts.app')
@section('title')
SPKL
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item" aria-current="page">Payroll</li>
         <li class="breadcrumb-item active" aria-current="page">SPKL Employee</li>
      </ol>
   </nav>

   <div class="card shadow-none border ">
      <div class=" card-header d-flex justify-content-between">
         <div>
            @if (auth()->user()->hasRole('HRD|HRD-Payroll|HRD-KJ12|HRD-KJ45|HRD-JGC'))
            <a class="btn btn-light btn-sm border" href="{{route('payroll.overtime')}}"><i class="fa fa-backward"></i> Kembali</a>
            @else
            <a class="btn btn-light btn-sm border" href="{{route('overtime.team')}}"><i class="fa fa-backward"></i> Kembali</a>
            @endif
             |
            <span class="">SPKL List</b></span>
            
         </div>
         
         {{-- @if ($from == 0)
             <small>All</small>
             @else
             <small>{{formatDate($from)}} - {{formatDate($to)}}</small>
         @endif --}}
         
      </div>


      <form action="{{route('payroll.overtime.multiple.delete')}}" method="post" >
         @csrf
         @error('id_item')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
         @enderror
         <div class="card-body">
            @if (auth()->user()->hasRole('HRD|HRD-Payroll'))
            <div class="d-inline-flex align-items-center">
               <button type="submit" name="submit" class="btn btn-sm btn-danger mr-3">Delete</button>
               <div class="d-inline-flex align-items-center">
                     <span class="badge badge-muted badge-counter">
                        <span id="total">0</span>
                     </span>
               </div>
            </div>
            <hr>
            @endif
            
            <div class="row">
               <div class="col-md-3">
                  <div class="card shadow-none border">
                     <div class="card-body">
                        <h4>{{$employee->nik}}</h4>
                        <h4>{{$employee->biodata->fullName()}}</h4>
                     </div>
                     <div class="card-footer">
                        @if ($from == 0)
                        <small>Periode : All</small>
                        @else
                        <small>{{formatDate($from)}} - {{formatDate($to)}}</small>
                     @endif
                     </div>
                  </div>
                  @if (auth()->user()->hasRole('Administrator'))
                  <a href="{{route('overtime.refresh')}}">Refresh</a>
                  @endif
                  
               </div>
               <div class="col-md-9">
                  <div class="table-responsive px-0">
                     <table id="data" class="display basic-datatables table-sm">
                        <thead>
                           <tr>
                              @if (auth()->user()->hasRole('HRD|HRD-Payroll'))
                              <th>&nbsp; <input type="checkbox" id="selectall" /></th>
                              @endif
                              <th>Type</th>
                              {{-- <th>NIK</th>
                              <th>Name</th> --}}
                              {{-- <th>Loc</th> --}}
                              <th>Day</th>
                              <th class="text-right">Date</th>
                              
                              <th class="text-center">Qty</th>
                              {{-- <td></td> --}}
                              @if (auth()->user()->hasRole('HRD|HRD-Payroll|Administrator'))
                              <th class="text-right">Rate</th>
                              @endif
                              <th>Desc</th>
                              @if (auth()->user()->hasRole('Administrator|HRD|HRD-Payroll|HRD-KJ12|HRD-KJ45|HRD-JGC'))
                              <th></th>
                              @endif
                              @if (auth()->user()->hasRole('Administrator'))
                              <th></th>
                              @endif
                           </tr>
                        </thead>
                        
                        <tbody>
                           @foreach ($overtimes as $over)
                              <tr>
                                 {{-- <td>{{++$i}}</td> --}}
                                 @if (auth()->user()->hasRole('HRD|HRD-Payroll'))
                                 <td class="text-center"><input type="checkbox" class="case" name="id_item[]" value="{{$over->id}}" /> </td>
                                 @endif
                                 <td>
                                    {{-- @if (auth()->user()->hasRole('Administrator'))
                                       {{$over->id}}
                                    @endif --}}
                                    
                                    @if ($over->type == 1)
                                       Lembur
                                       @else
                                       Piket
                                    @endif
                                    
                                 </td>
                                 {{-- <td class="text-truncate">{{$over->employee->nik}}</td>
                                 <td class="text-truncate" style="max-width: 200px">{{$over->employee->biodata->fullName()}}</td> --}}
                                 {{-- <td>{{$over->employee->location->name}}</td> --}}
                                 <td>{{formatDayName($over->date)}}</td>
                                 <td class="text-right text-truncate">
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
                                       {{$over->hours_final}}
                                    @endif
                                    
                                    
                                 </td>
                                 {{-- <td class="text-center">{{getMultiple($over->hours)}}</td> --}}
                                 @if (auth()->user()->hasRole('HRD|HRD-Payroll|Administrator'))
                                 <td class="text-right text-truncate">{{formatRupiah($over->rate)}}</td>
                                 @endif
                                 <td class="text-truncate" style="max-width: 150px">
                                    {{$over->description}}
                                 </td>
                                 @if (auth()->user()->hasRole('Administrator|HRD|HRD-Payroll|HRD-KJ12|HRD-KJ45|HRD-JGC'))
                                 <td class="text-truncate">
                                 <a href="{{route('payroll.overtime.edit', enkripRambo($over->id))}}">Edit</a> |
                                    <a href="#" data-target="#modal-delete-overtime-{{$over->id}}" data-toggle="modal">Delete</a>
                                 </td>
                                 @endif
                                 @if (auth()->user()->hasRole('Administrator'))
                                 <td>{{formatDateTime($over->created_at)}}</td>
                                 @endif
                              </tr>
      
                              <div class="modal fade" id="modal-delete-overtime-{{$over->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                          @if ($over->type == 1)
                                             Lembur
                                             @else
                                             Piket
                                          @endif
                                          {{$over->employee->nik}} {{$over->employee->biodata->fullName()}}
                                          tanggal {{formatDate($over->date)}}
                                          ?
                                       </div>
                                       <div class="modal-footer">
                                          <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                                          <button type="button" class="btn btn-danger ">
                                             <a class="text-light" href="{{route('payroll.overtime.delete', enkripRambo($over->id))}}">Delete</a>
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
            </div>
            


         </div>

      </form>
      {{-- <div class="card-footer">
         <a href="{{route('overtime.refresh')}}">Refresh</a>
      </div> --}}


   </div>
   <!-- End Row -->


</div>




@endsection