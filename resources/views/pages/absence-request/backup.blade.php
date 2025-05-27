@extends('layouts.app')
@section('title')
Form Absensi
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">Form Absensi</li>
      </ol>
   </nav>


   <div class="row">
      <div class="col-md-3">
         <h4><b>Cuti Pengganti</b></h4>
         
         <hr>
         <small>
            <b>#INFO</b> <br>
            Daftar Form Request Absensi yang mempunyai relasi terhadap anda sebagai Karyawan Pengganti.
         </small>
         
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
        
         <div class="table-responsive ">
            <table id="data" class="display basic-datatables table-sm p-0">
               <thead>
                  <tr>
                     <th>ID</th>
                     <th>Type</th>
                     <th>NIK</th>
                     <th>Name</th>
                      {{-- <th>Loc</th> --}}
                     
                     {{-- <th>Day</th> --}}
                     <th>Date</th>
                     {{-- <th>Desc</th> --}}
                     <th>Status</th>
                     {{-- <th></th> --}}
                  </tr>
               </thead>

               <tbody>

                  {{-- @foreach ($myteams as $team) --}}
                     @foreach ($reqForms as $absence)
                        {{-- @if ($absence->employee_id == $team->id) --}}
                        <tr>
                           <td>
                              <a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}">
                                    {{$absence->code}}
                              </a>
                           </td>
                           <td>
                              {{-- <a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}"> --}}
                                 <x-status.absence :absence="$absence" />
                           {{-- </a> --}}
                              
                           </td>
                           <td>
                              {{$absence->employee->nik}}
                           </td>
                           <td> {{$absence->employee->biodata->fullName()}}</td>
                           {{-- <td>{{$absence->employee->location->name}}</td> --}}
                           
                           {{-- <td>{{formatDayName($absence->date)}}</td> --}}
                           <td>
                              @if ($absence->type == 5 || $absence->type == 10)
                        
                                 @if (count($absence->details) > 0)
                                       @foreach ($absence->details  as $item)
                                          {{formatDate($item->date)}} -
                                       @endforeach
                                    @else
                                    Tanggal belum dipilih
                                 @endif
                                    
                                    @else
                                    {{formatDate($absence->date)}}
                              @endif
                           </td>
                           {{-- <td>{{$absence->desc}}</td> --}}
                           <td>
                              <x-status.form :form="$absence" />
                              
                           </td>
                           {{-- <td>
                              {{$absence->updated_at}}
                           </td> --}}
                        
                        </tr>
                        {{-- @endif --}}
                     @endforeach
                  
                  {{-- @endforeach --}}

                  {{-- @foreach ($reqBackForms as $absence)
                        
                        <tr>
                           <td>
                              <a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}">
                                 <x-status.absence :absence="$absence" />
                           </a>
                              
                           </td>
                           <td><a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}"> {{$absence->employee->nik}}</a></td>
                           <td> {{$absence->employee->biodata->fullName()}}</td>
                           <td>{{formatDate($absence->date)}}</td>
                           <td>
                              <x-status.form :form="$absence" />
                              
                           </td>
                           <td>
                              {{$absence->created_at}}
                           </td>
                        
                        </tr>
                        
                     @endforeach --}}


                  
                  

                  
               </tbody>

            </table>
         </div>
      </div>
   </div>

   


</div>




@endsection