@extends('layouts.app')
@section('title')
History Formulir Pengajuan
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">History Formulir Pengajuan</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         <h4><b>History Approval Absensi</b></h4>
         <hr>
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link  text-left pl-3" id="v-pills-basic-tab" href="{{ route('leader.absence') }}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Request Absensi/Cuti
            </a>
            <a class="nav-link active  text-left pl-3" id="v-pills-contract-tab" href="{{ route('leader.absence.history') }}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               History
            </a>
            <hr>
         <small>
            <b>#INFO</b> <br>
            Daftar Riwayat Form Request Absensi yang memiliki relasi terhadap anda, sebagai pengganti maupun sebagai atasan
         </small>
            
           
            
         </div>
         <hr>
         
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
         <div class="table-responsive ">
            <table id="data" class="basic-datatables">
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
                  @foreach ($reqForms as $absence)
                                    
                                    <tr>
                                       <td>
                                          {{$absence->code}}
                                       </td>
                                       <td>
                                          <a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}">
                                             <x-status.absence :absence="$absence" />
                                       </a>
                                          
                                       </td>
                                       <td><a href="{{route('employee.absence.detail', enkripRambo($absence->id))}}"> {{$absence->employee->nik}}</a></td>
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
                                    
                                    </tr>
                        @endforeach
                  
                  
                  
               </tbody>

            </table>
         </div>
      </div>
   </div>

   


</div>




@endsection