@extends('layouts.app')
@section('title')
Absence
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">Absence</li>
      </ol>
   </nav>

   <div class="card shadow-none border">
      <div class=" card-header">
         <div>
            <!-- resources/views/components/tab-absence.blade.php -->
        
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link{{ $activeTab === 'index' ? ' active' : '' }}" href="{{ route('employee.absence') }}">Absence</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ $activeTab === 'pending' ? ' active' : '' }}" href="{{ route('employee.absence.pending') }}">Pending Request</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ $activeTab === 'form' ? ' active' : '' }}" href="{{ route('employee.absence.create') }}">Create</a>
                </li>
                
            </ul>
        
        </div>
      </div>

      <div class="card-body ">

         <div class="row">
            <div class="col-md-2">
               <form action="{{route('payroll.absence.filter')}}" method="POST">
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
                     
                     
                     <div class="col-md-12">
                        <button class="btn btn-primary btn-block" type="submit">Filter</button>
                     </div>

                     
                  </div>

                  <!--  End Filter Table  -->
               </form>
            </div>
            <div class="col-md-10">
               
               <div class="table-responsive p-0">
                  <table id="data" class="display basic-datatables table-sm p-0">
                     <thead>
                        <tr>
                           {{-- <th>NIK</th>
                            <th>Name</th> --}}
                            {{-- <th>Loc</th> --}}
                           <th>Type</th>
                           <th>Day</th>
                           <th>Date</th>
                           <th></th>
                           {{-- <th></th> --}}
                        </tr>
                     </thead>

                     <tbody>
                        @foreach ($absences as $absence)
                        <tr>
                           {{-- <td>{{$absence->employee->nik}}</td>
                            <td> {{$absence->employee->biodata->fullName()}}</td> --}}
                            {{-- <td>{{$absence->employee->location->name}}</td> --}}
                           <td >
                              <span data-toggle="tooltip" data-placement="top" title="{{$absence->desc ?? '-'}}">
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
                           </span>
                              
                           </td>
                           <td>{{formatDayName($absence->date)}}</td>
                           <td>{{formatDate($absence->date)}}</td>
                           <td>
                              @if ($absence->getRequest() != null)
                                  <span class="badge badge-info">Requested :
                                    @if ($absence->getRequest()->status == 0)
                                        Validasi Atasan
                                    @endif
                                  </span>
                                  @else
                                  @if ($absence->type == 1 || $absence->type == 3)
                                  <a href="{{route('employee.absence.request', enkripRambo($absence->id))}}" class="btn btn-sm btn-light border">Request</a>
                                  @endif
                                  
                              @endif
                           </td>
                           
                        </tr>

                        @endforeach
                     </tbody>

                  </table>
               </div>
               <!-- End Table  -->

               <div class="card-footer">
                  <a href="{{route('absence.refresh')}}">Refresh</a>
               </div>

            </div>
         </div>


      </div>


   </div>
   <!-- End Row -->


</div>




@endsection