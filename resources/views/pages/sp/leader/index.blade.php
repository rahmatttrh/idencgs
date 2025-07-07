@extends('layouts.app')
@section('title')
Rekomendasi SP
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">Rekomendasi Surat Peringatan & Teguran</li>
      </ol>
   </nav>


   <div class="row">
      <div class="col-md-3">
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{ route('sp.leader.approval') }}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Surat Peringatan & Teguran
            </a>
           
            
           
            
         </div>
         <hr>
         <div class="card">
            <div class="card-body">
               <small>Daftar Rekomendasi Surat Peringatan dan Teguran dari HRD yang membutuhkan Approval anda.</small>
            </div>
         </div>
         
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
          {{-- <h4>Pengajuan SPKL</h4> --}}
         
         <div class="table-responsive p-0 ">
            <table id="data" class="display basic-datatables table-sm p-0">
               <thead>
                  <tr>
                     {{-- <th class="text-center" style="width: 10px">No</th> --}}
                     <th>Jenis</th>
                     <th>ID</th>
                     {{-- <th>NIK</th> --}}
                     <th>Name</th>
                     
                     
                     <th>Desc</th>
                     <th>Status</th>
                     <th>Date</th>
                  </tr>
               </thead>
               <tbody>

                  @foreach ($spApprovals as $sp)
                  <tr>
                     {{-- <td class="text-center">{{++$i}}</td> --}}
                     <td>Peringatan</td>
                     <td><a href="{{route('sp.detail', enkripRambo($sp->id))}}">{{$sp->code}}</a> </td>
                     {{-- <td>{{$sp->employee->nik}}</td> --}}
                     <td> {{$sp->employee->biodata->fullName()}}</td>
                     {{-- <td>{{$sp->employee->nik}}</td> --}}
                     {{-- <td>{{formatDate($sp->date)}}</td> --}}
                     <td>SP {{$sp->level}}</td>
                     <td>
                        <x-status.sp :sp="$sp" />
                     </td>
                     <td>{{formatDate($sp->date_from)}}</td>
                     {{-- <td class="text-truncate" style="max-width: 240px">{{$sp->desc}}</td> --}}

                  </tr>
                  @endforeach

                  @foreach ($stAlerts as $st)
                  <tr>
                     {{-- <td class="text-center">{{++$i}}</td> --}}
                     <td>Teguran</td>
                     <td><a href="{{route('st.detail', enkripRambo($st->id))}}">{{$st->code}}</a> </td>
                     {{-- <td>{{$st->employee->nik}}</td> --}}
                     <td> {{$st->employee->biodata->fullName()}}</td>
                     {{-- <td>{{$sp->employee->nik}}</td> --}}
                     {{-- <td>{{formatDate($sp->date)}}</td> --}}
                     <td>{{$st->desc}}</td>
                     <td>
                        <x-status.st :st="$st" />
                     </td>
                     <td>{{formatDate($st->date)}}</td>
                     {{-- <td class="text-truncate" style="max-width: 240px">{{$sp->desc}}</td> --}}

                  </tr>
                  @endforeach
               </tbody>

            </table>
         </div>
      </div>
   </div>

   


</div>




@endsection