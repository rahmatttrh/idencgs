@extends('layouts.app')
@section('title')
Edit History Training
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">Edit History Training</li>
      </ol>
   </nav>
   <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
      <li class="nav-item">
         <a class="nav-link active" id="pills-home-tab"  href="#">Form Edit Training History</a>
      </li>
      <li class="nav-item">
         <a class="nav-link " id="pills-home-tab"  href="{{route('training.history')}}">Training History</a>
      </li>
      <li class="nav-item">
         <a class="nav-link " id="pills-profile-tab" href="{{route('training.history.create')}}">Input Training History</a>
      </li>
     
     
   </ul>
   
   {{-- <div class="btn btn-light border">
      Form Edit Training History
   </div> --}}
      {{-- <h4></h4> --}}
      <hr>
      <div class="row">
         <div class="col-md-8">
            <form action="{{route('training.history.update')}}" method="POST" enctype="multipart/form-data">
               @csrf
               @method('PUT')
               <input type="text" name="history" id="history" value="{{$trainingHistory->id}}" hidden>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group form-group-default">
                     <label>Karyawan </label>
                     <select class="form-control select2b" required name="employee" id="employee">
                        <option value="" disabled selected>Select</option>
                        @foreach ($employees as $emp)
                            <option {{$trainingHistory->employee_id == $emp->id ? 'selected' : ''}} value="{{$emp->id}}">{{$emp->nik}} {{$emp->biodata->fullName()}}</option>
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
                            <option {{$trainingHistory->training_id == $train->id ? 'selected' : ''}} value="{{$train->id}}">{{$train->title}} </option>
                        @endforeach
                     </select>
                  </div>
                  
               </div>
               <div class="col-md-6">
                  <div class="form-group form-group-default">
                     <label>Tipe Pelatihan</label>
                     <select class="form-control " required name="type" id="type">
                        <option value="" disabled selected>Select</option>
                        <option {{$trainingHistory->type == 'Internal' ? 'selected' : ''}} value="Internal">Internal</option>
                        <option {{$trainingHistory->type == 'External' ? 'selected' : ''}} value="External">External</option>
                     </select>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group form-group-default">
                     <label>Jenis Sertifikat</label>
                     <select class="form-control " required name="type_sertificate" id="type_sertificate">
                        <option value="" disabled selected>Select</option>
                        <option {{$trainingHistory->type_sertificate == 'Attendence' ? 'selected' : ''}} value="Attendence">Attendence</option>
                        <option {{$trainingHistory->type_sertificate == 'Migas' ? 'selected' : ''}} value="Migas">Migas</option>
                        <option {{$trainingHistory->type_sertificate == 'Kemnaker' ? 'selected' : ''}} value="Kemnaker">Kemnaker</option>
                        <option {{$trainingHistory->type_sertificate == 'Disnaker' ? 'selected' : ''}} value="Disnaker">Disnaker</option>
                        <option {{$trainingHistory->type_sertificate == 'Perhubla' ? 'selected' : ''}} value="Perhubla">Perhubla</option>
                        <option {{$trainingHistory->type_sertificate == 'BNSP' ? 'selected' : ''}} value="BNSP">BNSP</option>
                        <option {{$trainingHistory->type_sertificate == 'ENC Academy' ? 'selected' : ''}} value="ENC Academy">ENC Academy</option>
                     </select>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group form-group-default">
                     <label>Periode</label>
                     <input type="text" class="form-control" id="periode" name="periode" value="{{$trainingHistory->periode}}">
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group form-group-default">
                     <label>Tanggal Berlaku</label>
                     <input type="date" class="form-control" id="expired" name="expired" value="{{$trainingHistory->expired}}">
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group form-group-default">
                     <label>Vendor</label>
                     <input type="text" class="form-control" id="vendor" name="vendor" value="{{$trainingHistory->vendor}}">
                  </div>
               </div>
            </div>
            <div class="form-group form-group-default">
               <label>Sertifikat</label>
               <input type="file" class="form-control" id="doc" name="doc">
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Update</button>
         </form>
         </div>
      </div>
   


</div>




@endsection