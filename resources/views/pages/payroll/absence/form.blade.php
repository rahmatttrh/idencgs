@extends('layouts.app')
@section('title')
Payroll Absence
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item" aria-current="page">Payroll</li>
         <li class="breadcrumb-item active" aria-current="page">Absence</li>
      </ol>
   </nav>

   <div class="card shadow-none border col-md-12">
      <div class=" card-header">
         <x-absence-tab :activeTab="request()->route()->getName()" />
      </div>

      <div class="card-body px-0">
         <div class="row">
            <div class="col-md-6">
               <form action="{{route('payroll.absence.store')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group form-group-default">
                     <label>Employee</label>
                     <select class="form-control js-example-basic-single" style="width: 100%" required name="employee" id="employee">
                        <option value="" disabled selected>Select</option>
                        @foreach ($employees as $emp)
                        <option value="{{$emp->id}}">{{$emp->nik}} {{$emp->biodata->fullName()}}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Date</label>
                           <input type="date" required class="form-control" id="date" name="date">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Type</label>
                           <select class="form-control type" required name="type" id="type">
                              <option value="" disabled selected>Select</option>
                              <option value="1">Alpha</option>
                              <option value="2">Terlambat</option>
                              <option value="3">ATL</option>
                              <option value="4">Izin</option>
                              <option value="5">Cuti</option>
                              <option value="6">SPT</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-6 type_spt">
                        <div class="form-group form-group-default">
                           <label>Jenis SPT</label>
                           <select class="form-control"  name="type_spt" id="type_spt">
                              <option value="" disabled selected>Select</option>
                              <option value="Tidak Absen Masuk">Tidak Absen Masuk</option>
                              <option value="Tidak Absen Pulang">Tidak Absen Pulang</option>
                              <option value="Tidak Absen Masuk & Pulang">Tidak Absen Masuk & Pulang</option>
                           </select>
                        </div>
                     </div>

                     <div class="col-md-6 type_izin">
                        <div class="form-group form-group-default">
                           <label>Jenis Izin</label>
                           <select class="form-control"  name="type_izin" id="type_izin">
                              <option value="" disabled selected>Select</option>
                              <option value="Setengah Hari">Setengah Hari</option>
                              <option value="Satu Hari">Satu Hari</option>
                           </select>
                        </div>
                     </div>
                  </div>


                  <div class="form-group form-group-default">
                     <label>Desc</label>
                     <input type="text" class="form-control" id="desc" name="desc">
                  </div>

                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group form-group-default">
                           <label>Menit</label>
                           <input type="number" class="form-control" id="minute" name="minute">
                        </div>
                     </div>
                     <div class="col">
                        <div class="form-group form-group-default">
                           <label>Document</label>
                           <input type="file" class="form-control" id="doc" name="doc">
                        </div>
                     </div>
                  </div>



                  <button class="btn  btn-primary" type="submit">Add</button>
               </form>
            </div>
         </div>
         


      </div>


   </div>
   <!-- End Row -->


</div>

@push('myjs')
   <script>

      $(document).ready(function() {
         // console.log('report function');
         // $('#foto').hide();
         $('.type_spt').hide();
         $('.type_izin').hide();

         $('.type').change(function() {
            // console.log('okeee');
            var type = $(this).val();
            if (type == 6) {
            //   $('#foto').show();
              $('.type_spt').show();
            } else if(type == 4) {
            //   $('#foto').show();
            $('.type_izin').show();
            $('.type_spt').hide();
            } 
         })

         
      })
   </script>
@endpush



@endsection