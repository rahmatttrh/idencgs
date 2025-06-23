@extends('layouts.app')
@section('title')
Contract Alert
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">Contract Alert</li>
      </ol>
   </nav>
   <div class="row">
      <div class="col-md-3">
         {{-- <h4><b>Monitoring Form Absensi</b></h4>
         <hr> --}}
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{ route('hrd.absence') }}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Contract Alert
            </a>
            
            
           
            
         </div>
         <hr>
         <div class="card">
            
            <div class="card-body">
               <small>Kontrak Kerja Karyawan yang akan berakhir dalam waktu 2 bulan kedepan</small>
            </div>
         </div>


         {{-- <small>
            <b>#INFO</b> <br>
            Daftar Form Request Absensi yang dibuat oleh Karyawan
         </small> --}}
         
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
         
         <div class="table-responsive ">
            <table id="myTable" class="display basic-datatables table-sm table-bordered  table-striped ">
               <thead>
                  
                  <tr>
                     <th scope="col">NIK</th>
                     <th scope="col" >Name</th>
                     <th>Unit</th>
                     <th>Department</th>
                     <th>Expired</th>
                  </tr>
                  
               </thead>
                <tfoot>
                        <tr>
                           <th class=""></th>
                           <td @disabled(true) colspan=""></td>
                           <th ></th>
                           <th></th>
                           <th></th>
                        </tr>
                     </tfoot>
               <tbody>
                  @foreach ($contractAlerts as $con)
                      <tr>
                        <td>
                           <a href="{{route('employee.detail', [enkripRambo($con->employee->id), enkripRambo('contract')])}}">{{$con->employee->nik ?? ''}}</a> 
                           
                        </td>
                        <td>
                           <a href="{{route('employee.detail', [enkripRambo($con->employee->id), enkripRambo('contract')])}}"> {{$con->employee->biodata->fullName()}}</a> 
                          
                        </td>
                        <td>{{$con->employee->unit->name}}</td>
                        <td>{{$con->employee->department->name}}</td>
                        <td>{{formatDateB($con->end)}}</td>
                      </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>

  


</div>




@endsection