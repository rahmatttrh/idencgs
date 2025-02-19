@extends('layouts.app')
@section('title')
Payroll Absence
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item" aria-current="page">Payroll</li>
         <li class="breadcrumb-item active" aria-current="page">Absence</li>
      </ol>
   </nav>

   <div class="card shadow-none border ">
      <div class=" card-header">
         <x-overtime.overtime-team-tab :activeTab="request()->route()->getName()" />
      </div>

      <div class="card-body">

         <div class="row">
            <div class="col-md-2">
               <h4>Filter Data</h4>
               <hr>
               <form action="{{route('payroll.absence.filter.team')}}" method="POST">
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
                     @if (auth()->user()->hasRole('Administrator|HRD-Payroll'))
                     <div class="col-md-12">
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
                     
                     <div class="col-12">
                        <button class="btn btn-primary btn-block" type="submit">Filter</button>
                     </div>

                     @if (auth()->user()->hasRole('Administrator|HRD-Payroll'))
                     <div class="col">

                        @if ($export == true)
                           <a href="{{route('payroll.absence.export.data', [$from, $to, $loc] )}}" target="_blank" class="btn btn-block btn-dark"><i class="fa fa-file-excel"></i> Export</a>
                           @endif
                     </div>
                     @endif
                  </div>

                  <!--  End Filter Table  -->
               </form>
            </div>
            <div class="col-md-10">
               
               <div class="table-responsive p-0">
                  <table id="data" class="display basic-datatables table-sm p-0">
                     <thead>
                        <tr>
                           <th>NIK</th>
                           <th>Name</th>
                           {{-- <th>Location</th> --}}
                           {{-- <th>Unit</th> --}}
                           <th class="text-center">Alpha</th>
                           <th class="text-center">Terlambat</th>
                           <th class="text-center">ATL</th>
                           <th class="text-center">Izin</th>
                           <th class="text-center">Cuti</th>
                           <th class="text-center">Sakit</th>
                           {{-- <th class="text-right">Rate</th> --}}
                        </tr>
                     </thead>

                     <tbody>

                        @if (count($employee->positions) > 0)
                              @foreach ($employee->positions as $pos)
                                    
                                    @foreach ($pos->department->employees->where('status', 1) as $emp)
                                    <tr>
                                       <td class="text-truncate">{{$emp->nik}}</td>
                                       <td class="text-truncate" style="max-width: 140px"> 
                                          <a href="{{route('payroll.absence.employee.detail', [enkripRambo($emp->id), $from, $to])}}">{{$emp->biodata->fullName()}}</a>
                                       </td>
                                       {{-- <td>{{$emp->location->name ?? '-'}}</td> --}}
                                       {{-- <td class="text-truncate" style="max-width: 100px">{{$emp->unit->name}}</td> --}}
                                       {{-- <td>{{$emp->department->name}}</td> --}}
                                       <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 1))}}</td>
                                       <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 2))}}</td>
                                       <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 3))}}</td>
                                       <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 4))}}</td>
                                       <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 5))}}</td>
                                       <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 7))}}</td>
                                       {{-- <td class="text-right">{{formatRupiahB($emp->getOvertimes($from, $to)->sum('rate'))}}</td> --}}
                                     </tr>
                                    @endforeach
                              @endforeach
                            @else
                            @foreach ($employees as $emp)
                                 @php
                                       $bio = DB::table('biodatas')->where('id', $emp->biodata_id)->first();
                                 @endphp
                                 <tr>
                                    <td class="text-truncate">{{$emp->nik}}</td>
                                    <td class="text-truncate" style="max-width: 140px"> 
                                       <a href="{{route('payroll.absence.employee.detail', [enkripRambo($emp->id), $from, $to])}}">{{$emp->biodata->fullName()}}</a>
                                    </td>
                                    {{-- <td>{{$emp->location->name ?? '-'}}</td> --}}
                                    {{-- <td class="text-truncate" style="max-width: 100px">{{$emp->unit->name}}</td> --}}
                                    {{-- <td>{{$emp->department->name}}</td> --}}
                                    <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 1))}}</td>
                                    <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 2))}}</td>
                                    <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 3))}}</td>
                                    <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 4))}}</td>
                                    <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 5))}}</td>
                                    <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 7))}}</td>
                                    {{-- <td class="text-right">{{formatRupiahB($emp->getOvertimes($from, $to)->sum('rate'))}}</td> --}}
                                  </tr>
                              @endforeach
                        @endif


                        {{-- @foreach ($absences as $absence)
                        <tr>
                           <td>{{$absence->employee->nik}}</td>
                            <td> {{$absence->employee->biodata->fullName()}}</td>
                            <td>{{$absence->employee->location->name}}</td>
                           <td>
                              @if ($absence->status == 404)
                                 <span class="text-danger">Permintaan Perubahan</span>
                                  @else
                                  @if ($absence->type == 1)
                                 Alpha
                                 @elseif($absence->type == 2)
                                 Terlambat ({{$absence->minute}} Menit)
                                 @elseif($absence->type == 3)
                                 ATL
                                 @elseif($absence->type == 4)
                                 Izin ({{$absence->type_izin}})
                                 @elseif($absence->type == 5)
                                 Cuti
                                 @elseif($absence->type == 6)
                                 SPT ({{$absence->type_spt}})
                                 @elseif($absence->type == 7)
                                 Sakit 
                                 @elseif($absence->type == 8)
                                 Dinas Luar
                                 @elseif($absence->type == 9)
                                 Off Kontrak
                                 @endif
                              @endif
                              
                           </td>
                           <td>{{formatDayName($absence->date)}}</td>
                           <td>{{formatDate($absence->date)}}</td>
                           <td>{{$absence->desc}}</td>
                          
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
                                    Delete data
                                    @if ($absence->type == 1)
                                    Alpha
                                    @elseif($absence->type == 2)
                                    Terlambat ({{$absence->minute}})
                                    @elseif($absence->type == 3)
                                    ATL
                                    @endif
                                    {{$absence->employee->nik}} {{$absence->employee->biodata->fullName()}}
                                    tanggal {{formatDate($absence->date)}}
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
                        @endforeach --}}
                     </tbody>

                  </table>
               </div>
               <!-- End Table  -->

            </div>
         </div>


      </div>


   </div>
   <!-- End Row -->


</div>




@endsection