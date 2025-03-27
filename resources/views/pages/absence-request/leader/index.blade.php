@extends('layouts.app')
@section('title')
Formulir Pengajuan
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">Formulir Pengajuan</li>
      </ol>
   </nav>

   <div class="card shadow-none border">
      <div class=" card-header">
         <div>
            <!-- resources/views/components/tab-absence.blade.php -->
        
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link{{ $activeTab === 'index' ? ' active' : '' }}" href="{{ route('leader.absence') }}">Formulir Pengajuan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ $activeTab === 'history' ? ' active' : '' }}" href="{{ route('leader.absence.history') }}">History</a>
                </li>
                
                
            </ul>
        
        </div>
      </div>

      <div class="card-body ">

         <div class="row">
            
            <div class="col-md-12">
               
               <div class="table-responsive ">
                  <table id="data" class="">
                     <thead>
                        <tr>
                           <th>Type</th>
                           <th>NIK</th>
                            <th>Name</th>
                            {{-- <th>Loc</th> --}}
                           
                           {{-- <th>Day</th> --}}
                           <th>Date</th>
                           <th>Desc</th>
                           <th>Status</th>
                           {{-- <th></th> --}}
                        </tr>
                     </thead>

                     <tbody>
                        @if (count($reqForms) + count($reqBackForms) > 0)
                              @foreach ($reqForms as $absence)
                              <tr>
                                 <td>
                                    <a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}">
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
                                       SPT
                                       @elseif($absence->type == 7)
                                       Sakit 
                                       @elseif($absence->type == 8)
                                       Dinas Luar
                                       @elseif($absence->type == 9)
                                       Off Kontrak
                                       @endif
                                    @endif
                                 </a>
                                    
                                 </td>
                                 <td><a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}"> {{$absence->employee->nik}}</a></td>
                                 <td> {{$absence->employee->biodata->fullName()}}</td>
                                 {{-- <td>{{$absence->employee->location->name}}</td> --}}
                                 
                                 {{-- <td>{{formatDayName($absence->date)}}</td> --}}
                                 <td>{{formatDate($absence->date)}}</td>
                                 <td>{{$absence->desc}}</td>
                                 <td>
                                    <x-status.form :form="$absence" />
                                    
                                 </td>
                                
                              </tr>
                              @endforeach
                              @foreach ($reqBackForms as $absence)
                                 <tr>
                                    <td>
                                       <a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}">
                                          <x-absence.type :absence="$absence" />
                                       </a>
                                       
                                    </td>
                                    <td><a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}"> {{$absence->employee->nik}}</a></td>
                                    <td> {{$absence->employee->biodata->fullName()}}</td>
                                    {{-- <td>{{$absence->employee->location->name}}</td> --}}
                                    
                                    <td>{{formatDayName($absence->date)}}</td>
                                    <td>{{formatDate($absence->date)}}</td>
                                    <td>{{$absence->desc}}</td>
                                    <td>
                                       <x-status.form :form="$absence" />
                                    
                                    </td>
                                 
                                 </tr>

                                 
                                 @endforeach
                            @else
                            <tr>
                              <td colspan="7" class="text-center">Tidak ada Pengajuan</td>
                            </tr>
                        @endif
                        

                        
                     </tbody>

                  </table>
               </div>
               <!-- End Table  -->

               <div class="card-footer">
                  {{-- <a href="{{route('absence.refresh')}}">Refresh</a> --}}
               </div>

            </div>
         </div>


      </div>


   </div>
   <!-- End Row -->


</div>




@endsection