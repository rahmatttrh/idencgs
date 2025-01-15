@extends('layouts.app')
@section('title')
SPKL Create
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item" aria-current="page">Payroll</li>
         <li class="breadcrumb-item active" aria-current="page">SPKL Create</li>
      </ol>
   </nav>

   <div class="card shadow-none border col-md-12">
      <div class=" card-header">
         <x-overtime.overtime-tab :activeTab="request()->route()->getName()" />
      </div>

      <div class="card-body px-0">

         <form action="{{route('payroll.overtime.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
               <div class="col-6">
                  
                     {{-- <input type="number" name="employee" id="employee" value="{{$transaction->employee_id}}" hidden>
                     <input type="number" name="spkl_type" id="spkl_type" value="{{$transaction->employee->unit->spkl_type}}" hidden>
                     <input type="number" name="transaction" id="transaction" value="{{$transaction->id}}" hidden> --}}
                     <div class="form-group form-group-default">
                        <label>Employee</label>
                        <select class="form-control js-example-basic-single" style="width: 100%" required name="employee" id="employee">
                           <option value="" disabled selected>Select</option>
                           @foreach ($employees as $emp)
                              <option value="{{$emp->id}}">{{$emp->nik}} {{$emp->biodata->fullName()}}</option>
                           @endforeach
                        </select>
                        {{-- <input type="number" class="form-control" id="hours" name="hours" > --}}
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Date</label>
                              <input type="date" required class="form-control" id="date" name="date" >
                           </div>
                        </div>
                        <div class="col">
                           <div class="form-group form-group-default">
                              <label>Piket/Lembur</label>
                              <select class="form-control " required name="type" id="type">
                                 <option value="" disabled selected>Select</option>
                                 <option value="1">Lembur</option>
                                 <option value="2">Piket</option>
                              </select>
                           </div>
                        </div>
                        
                        
                     </div>
                     <div class="row">
                        <div class="col">
                           <div class="form-group form-group-default">
                              <label>Masuk/Libur</label>
                              <select class="form-control " required name="holiday_type" id="holiday_type">
                                 <option value="" disabled selected>Select</option>
                                 <option value="1">Masuk</option>
                                 <option value="2">Libur Off</option>
                                 <option value="3">Libur Nasional</option>
                                 <option value="4">Idul Fitri</option>
                              </select>
                           </div>
                        </div>
                        <div class="col">
                           <div class="form-group form-group-default">
                              <label>Hours</label>
                              <input type="number" class="form-control" id="hours" name="hours" >
                           </div>
                        </div>
         
                     </div>
                     <div class="form-group form-group-default">
                        <label>Note</label>
                        <input type="text"  class="form-control" id="desc" name="desc" >
                     </div>
                     
                     
                     
                     
                  
               </div>
               <div class="col">
                  <div class="form-group form-group-default">
                     <label>Document</label>
                     <input type="file"  class="form-control" id="doc" name="doc" >
                  </div>
                  <button class="btn btn-primary" type="submit">Add</button>
               </div>
            </div>
         </form>


      </div>


   </div>
   <!-- End Row -->


</div>




@endsection