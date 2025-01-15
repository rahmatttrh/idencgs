@extends('layouts.app')
@section('title')
SPKL Import
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item" aria-current="page">Payroll</li>
         <li class="breadcrumb-item active" aria-current="page">SPKL Import</li>
      </ol>
   </nav>

   <div class="card shadow-none border col-md-12">
      <div class=" card-header">
         <x-overtime.overtime-tab :activeTab="request()->route()->getName()" />
      </div>

      <div class="card-body px-0">

         <div class="row">
            <div class="col-md-5">
               <img src="{{asset('img/xls-file.png')}}" class="img mb-4" height="110" alt="">
               <form action="{{route('overtime.import.store')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group ">
                     <label>File Excel</label>
                     <input id="excel" name="excel" type="file" class="form-control-file">
                     @error('excel')
                     <small class="text-danger"><i>{{ $message }}</i></small>
                     @enderror
                  </div>
                  <hr>
                  <div class="form-group">
                     <button type="submit" class="btn btn-primary">Import</button>
                  </div>

               </form>
            </div>
            <div class="col-md-7">
               <div class="card card-light border shadow-none">
                  <div class="card-body ">
                     {{-- <div class="card-opening">Import Excel</div> --}}
                     
                     <div class="card-detail">
                        <a href="/documents/template-spkl-rev.xlsx" class="btn btn-success btn-rounded">Download Template</a>
                     </div>
                     {{-- <div class="card-desc text-left">
                        Kolom Business Unit, Department, Sub Department, Position diisi dengan angka ID yang bisa dilihat di Master Data
                     </div> --}}
                  </div>
                  <div class="card-footer">
                     <b>Panduan Pengisian Template Excel SPKL</b>
                     <hr>
                        - Kolom Type hanya bisa di isi ' <b>Lembur atau Piket</b> '<br>
                        - Kolom Tipe Libur hanya bisa di isi ' <b>Masuk, Libur, Libur Nasional, Idhul Fitri</b> ' <br>
                     
                        
                  </div>
               </div>
            </div>
         </div>


      </div>


   </div>
   <!-- End Row -->


</div>




@endsection