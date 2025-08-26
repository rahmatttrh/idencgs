@extends('layouts.app')
@section('title')
Summary SPKL
@endsection
@section('content')
<style>
   .btn-rm {
    background: none;
    color: inherit;
    border: none;
    padding: 0;
    font: inherit;
    cursor: pointer;
    outline: inherit;
}
</style>

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item active" aria-current="page">Summary SPKL</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         {{-- <div class="btn btl-light btn-block text-left mb-3 border">
            <b><i>SPKL KARYAWAN</i></b>
         </div> --}}
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link  text-left pl-3" id="v-pills-basic-tab" href="{{route('payroll.overtime')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Summary SPKL
            </a>

            <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{route('payroll.overtime.recent')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-clock mr-1"></i>
               Recent Input
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('payroll.overtime.draft')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Draft 
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('payroll.overtime.create')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Form Add SPKL
            </a>
            
            <a class="nav-link  text-left pl-3" id="v-pills-personal-tab" href="{{route('payroll.overtime.import')}}" aria-controls="v-pills-personal" aria-selected="true">
               <i class="fas fa-user mr-1"></i>
               Import by Excel
            </a>
           

            
            
         </div>
         <hr>
         <b>#INFO</b> <br>
         <small>Daftar 500 data SPKL yang terakhir di input</small>
         
        
      </div>
      <div class="col-md-9">
         <div class="table-responsive">
            <table id="data" class="display datatables-4 table-sm">
               <thead>
                  <tr>
                     <th>Type</th>
                     <th>NIK</th>
                     <th>Name</th>
                     <th>Loc</th>
                     {{-- <th>Day</th> --}}
                     <th class="text-right">Date</th>
                     
                     <th class="text-center">Hours</th>
                     @if (auth()->user()->hasRole('HRD|HRD-Payroll|Administrator'))
                     <th class="text-right">Rate</th>
                     @endif
                     {{-- <th>Desc</th> --}}
                     <th></th>
                  </tr>
               </thead>
               
               <tbody>
                  @foreach ($overtimes as $over)
                      <tr>
                        <td>
                           @if ($over->overtime_employee_id == null)
                              <a href="{{route('payroll.overtime.edit', [enkripRambo($over->id), enkripRambo('summary')])}}">
                                 @if ($over->type == 1)
                                    Lembur
                                    @else
                                    Piket
                                 @endif
                              </a>
                              @else
                              <a href="{{route('employee.spkl.detail', [enkripRambo($over->overtime_employee_id), enkripRambo('summary')])}}">
                                 @if ($over->type == 1)
                                    Lembur
                                    @else
                                    Piket
                                 @endif
                              </a>
                           @endif

                           @if ($over->holiday_type == 1)
                              <span  class="text-info ">
                              @elseif($over->holiday_type == 2)
                              <span class="text-danger">
                              @elseif($over->holiday_type == 3)
                              <span class="text-danger">LN
                              @elseif($over->holiday_type == 4)
                              <span class="text-danger">LR 
                           
                           {{-- <a href="#" data-target="#modal-overtime-doc-{{$over->id}}" data-toggle="modal" class="text-white">{{formatDate($over->date)}}</a> --}}
                           </span>
                           @endif
                           

                           {{-- {{$over->status}} --}}
                           
                        </td>
                        <td class="text-truncate">{{$over->employee->nik}}</td>
                        <td class="text-truncate" style="max-width: 200px">{{$over->employee->biodata->fullName()}}</td>
                        <td>{{$over->employee->location->name}}</td>
                        {{-- <td>{{formatDayName($over->date)}}</td> --}}
                        <td class="text-right text-truncate">
                           

                           {{$over->date}}
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
                        @if (auth()->user()->hasRole('HRD|HRD-Payroll|Administrator'))
                        <td class="text-right text-truncate">{{formatRupiah($over->rate)}}</td>
                        @endif
                        {{-- <td class="text-truncate" style="max-width: 150px">
                           {{$over->description}}
                        </td> --}}
                        <td class="text-truncate">
                           {{-- <a href="{{route('payroll.overtime.edit', enkripRambo($over->id))}}">Edit</a> | --}}
                           @if ($over->overtime_employee_id == null)
                           <a href="#" data-target="#modal-delete-overtime-{{$over->id}}" data-toggle="modal">Delete</a>
                           @else 
                           <small class="text-muted">By Form</small>
                           @endif
                           
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
   
   <!-- End Row -->


</div>




@endsection