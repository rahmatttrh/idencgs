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
         <li class="breadcrumb-item active" aria-current="page">SPKL</li>
      </ol>
   </nav>

   <div class="card shadow-none border col-md-12">
      <div class=" card-header">
         <x-overtime.overtime-tab :activeTab="request()->route()->getName()" />
      </div>

      <div class="card-body px-0">

         <div class="row">
            {{-- <div class="col-md-2">
               <h4>Form Filter Data</h4>
               <hr>
               <form action="{{route('payroll.overtime.filter')}}" method="POST">
                  @csrf
                  <div class="row">
                     
                     <div class="col-md-12">
                        <div class="form-group form-group-default">
                           <label>From</label>
                           <input type="date" name="from" id="from" value="{{$from}}" class="form-control">
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group form-group-default">
                           <label>To</label>
                           <input type="date" name="to" id="to" value="{{$to}}" class="form-control">
                        </div>
                     </div>
                     <hr>
                     <div class="col">
                        <button class="btn btn-primary" type="submit" >Filter</button>
                     </div>
                  </div>
               </form>   

               <hr>
               <a href="{{route('overtime.refresh')}}">Refresh</a>
            </div> --}}
            <div class="col-md-12">
               <form action="{{route('payroll.overtime.filter')}}" method="POST">
                  @csrf
                  <div class="row">
                     
                     <div class="col-md-2">
                        <div class="form-group form-group-default">
                           <label>From</label>
                           <input type="date" name="from" id="from" value="{{$from}}" class="form-control">
                        </div>
                     </div>
                     <div class="col-md-2">
                        <div class="form-group form-group-default">
                           <label>To</label>
                           <input type="date" name="to" id="to" value="{{$to}}" class="form-control">
                        </div>
                     </div>
                     @if (auth()->user()->hasRole('Administrator|HRD-Payroll'))
                     <div class="col-md-2">
                        <div class="form-group form-group-default">
                           <label>Lokasi</label>
                           {{-- <input id="name" name="name" type="text" class="form-control" placeholder="Fill Name"> --}}
                           <select name="loc" id="loc" required class="form-control">
                              <option selected value="" disabled>Choose </option>
                             
                                  <option {{$loc == 'KJ45' ? 'selected' : ''}} value="KJ45">KJ 4-5</option>
                              
                           </select>
                        </div>
                     </div>
                     @endif
                     
                     
                     <div class="col-2">
                        <button class="btn btn-primary" type="submit" >Filter</button> <br>
                        
                     </div>
                     {{-- <div class="col text-right">
                        
                     </div> --}}

                     @if (auth()->user()->hasRole('Administrator|HRD-Payroll'))
                     <div class="col">
                        @if ($export == true)
                           <a href="{{route('payroll.overtime.export', [$from, $to, $loc] )}}" target="_blank" class="btn btn-block btn-dark"><i class="fa fa-file-excel"></i> Export</a>
                           @endif
                     </div>
                     @endif
                  </div>
               </form>  
               
               @if ($export == false)
               <small class="ml-3 mb-2">
                  <i> *Ini adalah 1.000 data terakhir yang di input kedalam sistem </i>
               </small>
               @endif
               
               <div class="table-responsive">
                  <table id="data" class="display basic-datatables table-sm">
                     <thead>
                        <tr>
                           <th>Type</th>
                           <th>NIK</th>
                           <th>Name</th>
                           <th>Loc</th>
                           <th>Day</th>
                           <th class="text-right">Date</th>
                           
                           <th class="text-center">Hours</th>
                           {{-- <td></td> --}}
                           @if (auth()->user()->hasRole('HRD|HRD-Payroll|Administrator'))
                           <th class="text-right">Rate</th>
                           @endif
                           <th>Desc</th>
                           <th></th>
                        </tr>
                     </thead>
                     
                     <tbody>
                        @foreach ($overtimes as $over)
                            <tr>
                              {{-- <td>{{++$i}}</td> --}}
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
                              <td class="text-truncate">{{$over->employee->nik}}</td>
                              <td class="text-truncate" style="max-width: 200px">{{$over->employee->biodata->fullName()}}</td>
                              <td>{{$over->employee->location->name}}</td>
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
                                     -
                                 @endif
                                 
                                 
                              </td>
                              {{-- <td class="text-center">{{getMultiple($over->hours)}}</td> --}}
                              @if (auth()->user()->hasRole('HRD|HRD-Payroll|Administrator'))
                              <td class="text-right text-truncate">{{formatRupiah($over->rate)}}</td>
                              @endif
                              <td class="text-truncate" style="max-width: 150px">
                                 {{$over->description}}
                              </td>
                              <td class="text-truncate">
                              <a href="{{route('payroll.overtime.edit', enkripRambo($over->id))}}">Edit</a> |
                                 <a href="#" data-target="#modal-delete-overtime-{{$over->id}}" data-toggle="modal">Delete</a>
                              </td>
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
      <div class="card-footer">
         <a href="{{route('overtime.refresh')}}">Refresh</a>
      </div>


   </div>
   <!-- End Row -->


</div>




@endsection