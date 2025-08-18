@extends('layouts.app')
@section('title')
Summary Absence
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item active" aria-current="page">Summary Absence</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         <div class="btn btl-light btn-block text-left mb-3 border">
            <b><i>ABSENSI KARYAWAN</i></b>
         </div>
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link text-left pl-3" id="v-pills-basic-tab" href="{{route('payroll.absence')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Summary Absence
            </a>
             <a class="nav-link  text-left pl-3" id="v-pills-basic-tab" href="{{route('payroll.absence.recent')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-clock mr-1"></i>
               Recent 
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('payroll.absence.create')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Form Absence
            </a>
            
            <a class="nav-link  text-left pl-3" id="v-pills-personal-tab" href="{{route('payroll.absence.import')}}" aria-controls="v-pills-personal" aria-selected="true">
               <i class="fas fa-user mr-1"></i>
               Import by Excel
            </a>
           

            
            
         </div>
         {{-- <hr> --}}
         {{-- <a class="btn btn-light border btn-block" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
            Show Form Filter
          </a> --}}
          <hr>
          <table>
            <thead>
               <tr><th colspan="2">Absence/Employee</th></tr>
            </thead>
            <tbody>
               
               <tr>
                  <td colspan="2">Periode</td>
                  
               </tr>
               <tr>
                  <td></td>
                  <td>
                     @if ($from != 0)
                     {{formatDate($from)}} - {{formatDate($to)}}
                     @else
                     All
                     @endif
                  </td>
               </tr>
               <tr>
                  <td colspan="2">Employee</td>
               </tr>
               <tr>
                  <td></td>
                  <td>
                    {{$employee->nik}}
                     
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td>
                    {{$employee->biodata->fullName()}}
                     
                  </td>
               </tr>
               

             
               
            </tbody>
          </table>
          <table>
            <tbody>
               @if (count($absences->where('type', 1)) > 0)
               <tr>
                  <td>Alpha</td>
                  <td>{{count($absences->where('type', 1))}}</td>
               </tr>
               @endif
               @if (count($absences->where('type', 2)) > 0)
               <tr>
                  <td>Terlambat</td>
                  <td>{{count($absences->where('type', 2))}}</td>
               </tr>
               @endif
               @if (count($absences->where('type', 3)) > 0)
               <tr>
                  <td>ATL</td>
                  <td>{{count($absences->where('type', 3))}}</td>
               </tr>
               @endif
               @if (count($absences->where('type', 4)) > 0)
               <tr>
                  <td>Izin</td>
                  <td>{{count($absences->where('type', 4))}}</td>
               </tr>
               @endif
               @if (count($absences->where('type', 5)) > 0)
               <tr>
                  <td>Cuti</td>
                  <td>{{count($absences->where('type', 5))}}</td>
               </tr>
               @endif
               @if (count($absences->where('type', 6)) > 0)
               <tr>
                  <td>SPT</td>
                  <td>{{count($absences->where('type', 6))}}</td>
               </tr>
               @endif
               @if (count($absences->where('type', 7)) > 0)
               <tr>
                  <td>Sakit</td>
                  <td>{{count($absences->where('type', 7))}}</td>
               </tr>
               @endif
               @if (count($absences->where('type', 8)) > 0)
               <tr>
                  <td>Dinas Luar</td>
                  <td>{{count($absences->where('type', 8))}}</td>
               </tr>
               @endif
               @if (count($absences->where('type', 9)) > 0)
               <tr>
                  <td>Off Contract</td>
                  <td>{{count($absences->where('type', 9))}}</td>
               </tr>
               @endif
               
            </tbody>
          </table>
        
      </div>
      <div class="col-md-9">
         <div class="table-responsive px-0">
            <table id="data" class="display datatables-2 table-sm">
               <thead>
                  <tr>
                     <th>ID</th>
                     <th>Type</th>
                     {{-- <th>Change</th> --}}
                     <th>Day</th>
                     <th>Date</th>
                     {{-- <th>Desc</th> --}}
                     @if (auth()->user()->hasRole('Karyawan|Leader|Supervisor|Manager|Asst. Manager|BOD'))
                           <th></th>
                         @else
                         <th></th>
                     @endif
                     
                  </tr>
               </thead>

               <tbody>
                  @foreach ($absences as $absence)
                  <tr>
                     <td>{{$absence->id}}</td>
                     <td>
                        @if ($absence->status == 404)
                           <span class="text-danger">Permintaan Perubahan</span>
                            @else

                            @if ($absence->getRequest() != null )
                            <a href="{{route('employee.absence.detail', [enkripRambo($absence->getRequest()->id), enkripRambo('monitoring')])}}" class="badge badge-info">
                              <x-absence.type :absence="$absence->getRequest()" />
                              :
                              <x-status.form :form="$absence->getRequest()" />
                             
                            </a>
                            @else
                            <x-status.absence :absence="$absence" />
                            @endif
                            
                        @endif

                        
                        
                     </td>
                     {{-- <td>
                        @if ($absence->getRequest() != null )
                        <a href="{{route('employee.absence.detail', [enkripRambo($absence->getRequest()->id), enkripRambo('monitoring')])}}" class="badge badge-info">
                           <x-absence.type :absence="$absence->getRequest()" />
                           :
                           <x-status.form :form="$absence->getRequest()" />
                          
                         </a>
                         @endif
                     </td> --}}
                     <td>{{formatDayName($absence->date)}}</td>
                     <td>{{$absence->date}}</td>
                     {{-- <td>{{$absence->desc}}</td> --}}
                     <td class="text-truncate">
                        @if (auth()->user()->hasRole('HRD|HRD-Payroll|HRD-Spv|HRD-KJ12|HRD-KJ45|Administrator|HRD-JGC|HRD-Staff|HRD-Recruitment'))
                              <a href="{{route('payroll.absence.edit', enkripRambo($absence->id))}}" class="">Update</a> |
                              <a href="#" data-target="#modal-delete-absence-{{$absence->id}}" data-toggle="modal">Delete</a>
                              @else
                              
                           @endif
                        
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
                  @endforeach
               </tbody>
               
            </table>
         </div>
      </div>
   </div>
   
   <!-- End Row -->


</div>




@endsection