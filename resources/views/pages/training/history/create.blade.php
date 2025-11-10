@extends('layouts.app')
@section('title')
Create History Training
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">Create History Training</li>
      </ol>
   </nav>
   <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
      <li class="nav-item">
         <a class="nav-link " id="pills-home-tab"  href="{{route('training.history')}}">Training History</a>
      </li>
      <li class="nav-item">
         <a class="nav-link active" id="pills-profile-tab" href="{{route('training.history.create')}}">Input Training History</a>
      </li>
     
     
   </ul>
   <hr>
   
      <div class="row">
         <div class="col-md-8">
            <form action="{{route('training.history.store')}}" method="POST" enctype="multipart/form-data">
               @csrf
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group form-group-default">
                     <label>Karyawan</label>
                     <select class="form-control select2b" required name="employee" id="employee">
                        <option value="" disabled selected>Select</option>
                        @foreach ($employees as $emp)
                            <option value="{{$emp->id}}">{{$emp->nik}} {{$emp->biodata->fullName()}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group form-group-default">
                     <label>Pelatihan</label>
                     <select class="form-control select2" required name="training" id="training">
                        <option value="" disabled selected>Select</option>
                        @foreach ($trainings as $train)
                            <option value="{{$train->id}}">{{$train->title}} </option>
                        @endforeach
                     </select>
                  </div>
                  
               </div>
               <div class="col-md-6">
                  <div class="form-group form-group-default">
                     <label>Tipe Pelatihan</label>
                     <select class="form-control " required name="type" id="type">
                        <option value="" disabled selected>Select</option>
                        <option value="Internal">Internal</option>
                        <option value="External">External</option>
                     </select>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group form-group-default">
                     <label>Jenis Sertifikat</label>
                     <select class="form-control " required name="type_sertificate" id="type_sertificate">
                        <option value="" disabled selected>Select</option>
                        <option value="Attendance">Attendance</option>
                        <option value="Migas">Migas</option>
                        <option value="Kemnaker">Kemnaker</option>
                        <option value="Disnaker">Disnaker</option>
                        <option value="Perhubla">Perhubla</option>
                        <option value="BNSP">BNSP</option>
                        <option value="ENC Academy">ENC Academy</option>
                     </select>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group form-group-default">
                     <label>Periode</label>
                     <input type="text" class="form-control" id="periode" name="periode">
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group form-group-default">
                     <label>Tanggal Berlaku</label>
                     <input type="date" class="form-control" id="expired" name="expired">
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group form-group-default">
                     <label>Vendor</label>
                     <input type="text" class="form-control" id="vendor" name="vendor">
                  </div>
               </div>
            </div>
            <div class="form-group form-group-default">
               <label>Sertifikat</label>
               <input type="file" class="form-control" id="doc" name="doc">
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Submit</button>
         </form>
         </div>
      </div>
   


</div>




@endsection