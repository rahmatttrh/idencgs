@extends('layouts.app')
@section('title')
Import Absence
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item active" aria-current="page">Import Absence</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link  text-left pl-3" id="v-pills-basic-tab" href="{{route('payroll.absence')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Summary Absence
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('payroll.absence.create')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Form Absence
            </a>
            
            <a class="nav-link active text-left pl-3" id="v-pills-personal-tab" href="{{route('payroll.absence.import')}}" aria-controls="v-pills-personal" aria-selected="true">
               <i class="fas fa-user mr-1"></i>
               Import by Excel
            </a>
           

            
            
         </div>
         <hr>
        
      </div>
      <div class="col-md-9">
         <div class="d-flex">
            <img src="{{asset('img/xls-file.png')}}" class="img mb-4" height="150" alt="">
            <form action="{{route('payroll.absence.import.store')}}" method="POST" enctype="multipart/form-data">
               @csrf
   
               <div class="form-group ">
                  <label>File Excel</label>
                  <input id="excel" name="excel" type="file" class="form-control-file">
                  @error('excel')
                  <small class="text-danger"><i>{{ $message }}</i></small>
                  @enderror
               </div>
               {{-- <hr> --}}
               <div class="form-group">
                  <button type="submit" class="btn btn-primary">Import</button>
               </div>
   
            </form>
         </div>
         
         
        
         <hr>
         <div class="card  shadow-none border">
            <div class="card-header">
               Download Template Excel
            </div>
            <div class="card-body ">
               {{-- <div class="card-opening  text-center">Template Excel Absence</div> --}}
               {{-- <div class="card-desc text-center">
                  Make sure your document format is the same as the system requirements. Or you can download the template in the link below
               </div> --}}
               
               <!-- <a href="{{route('payroll.absence.export')}}">
                  <button type="submit" class="btn btn-success  btn-rounded">Download Template</button>
               </a> -->
               <form action="{{route('payroll.absence.template')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group ">
                           <label>Pilih Tanggal <span class="text-danger">*</span> </label>
                           <input class="form-control" type="date" name="date" id="dateInput" max="<?php echo date('Y-m-d'); ?>" required>
                           @error('excel')
                           <small class="text-danger"><i>{{ $message }}</i></small>
                           @enderror
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group ">
                           <label>Pilih Bisnis Unit <span class="text-danger">*</span> </label>
                           <select name="bu" id="" class="form-control" required>
                              <option value="">-Pilih Bisnis Unit-</option>
                              <option value="all">All</option>
                              @foreach($units as $unit)
                              <option value="{{$unit->id}}">{{$unit->name}}</option>
                              @endforeach
                           </select>
                           @error('excel')
                           <small class="text-danger"><i>{{ $message }}</i></small>
                           @enderror
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group ">
                           <label>Pilih Lokasi <span class="text-danger">*</span> </label>
                           <select name="location" id="" class="form-control" required>
                              <option value="">-Pilih Lokasi-</option>
                              <option value="all">All</option>
                              @foreach($locations as $location)
                              <option value="{{$location->id}}">{{$location->name}}</option>
                              @endforeach
                           </select>
                           @error('excel')
                           <small class="text-danger"><i>{{ $message }}</i></small>
                           @enderror
                        </div>
                     </div>
                     <div class="col">
                      <div class="form-group">
                          <button type="submit" class="btn btn-success  btn-rounded">Download Template</button>
                       </div>
                     </div>
                  </div>
                  

               </form>
            </div>
            <div class="card-footer">
              <b>Panduan Pengisian Template Excel Absensi</b>
              <hr>
               - Kolom <b>Type</b> diisi 'Alpha/Terlambat/ATL/Izin/Cuti/SPT/Sakit/Dinas Luar/Off Kontrak'<br>
               - Kolom <b>Keterlambatan</b> wajib diisi ketika value <b>Type</b> 'Terlambat' <br>
               - Kolom <b>Keterlambatan</b> diisi 'T1/T2/T3/T4'

            </div>
         </div>
      </div>
   </div>
   
   <!-- End Row -->


</div>




@endsection