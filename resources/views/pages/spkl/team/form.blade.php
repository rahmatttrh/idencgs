@extends('layouts.app')
@section('title')
SPKL
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">SPKL Team</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         {{-- <h4><b>SPKL SAYA</b></h4>
         <hr> --}}
         {{-- <div class="btn btn-light border btn-block text-left mb-3"><b>SPKL SAYA</b></div> --}}
         {{-- <div class="card shadow-none border">
            <div class="card-body">
               <b>SPKL & PIKET</b>
            </div>
         </div> --}}
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            {{-- <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{route('employee.spkl')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               List SPKL
            </a> --}}
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('spkl.team')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               SPKL Team Progress
            </a>
            
            <a class="nav-link  text-left pl-3" id="v-pills-personal-tab" href="{{route('spkl.team.draft')}}" aria-controls="v-pills-personal" aria-selected="true">
               <i class="fas fa-file-contract mr-1"></i>
               Draft
            </a>
           

            
            <a class="nav-link active text-left pl-3" id="v-pills-document-tab" href="{{route('spkl.team.create')}}" aria-controls="v-pills-document" aria-selected="false">
               <i class="fas fa-edit mr-1"></i>
               Form SPKL Team
            </a>
            
         </div>
         <hr>
         <small>
            Form ini digunakan Leader/Atasan jika anda ingin membuat Form SPKL beberapa karyawan (tim anda) dalam satu form
         </small>
         {{-- <form action="">
            <select name="" id="" class="form-control">
               <option value="">Januari</option>
               <option value="">Februari</option>
            </select>
         </form> --}}
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
         <form action="{{route('employee.spkl.store.multiple')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
               <div class="col-12">
                  
                     
                     <div class="row">
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              <label>Date</label>
                              <input type="date" required class="form-control" id="date" name="date" >
                           </div>
                        </div>
                        <div class="col-md-8">
                           <div class="form-group form-group-default ">
                              <label>Atasan</label>
                              <select class="form-control " required name="leader" id="leader">
                                 {{-- <option selected value="{{$leader->id}}">{{$leader->biodata->fullName()}}</option> --}}
                                 <option value="" disabled selected>Select</option>
                                 @foreach ($employeeLeaders as $lead)
                                    <option  value="{{$lead->leader->id}}">{{$lead->leader->biodata->fullName()}}</option>
                                 @endforeach
                                
                              </select>
                           </div>
                           {{-- <div class="form-group form-group-default">
                              <label>Masuk/Libur</label>
                              <select class="form-control " required name="holiday_type" id="holiday_type">
                                 <option value="" disabled selected>Select</option>
                                 <option value="1">Masuk</option>
                                 <option value="2">Libur Off</option>
                                 <option value="3">Libur Nasional</option>
                                 <option value="4">Idul Fitri</option>
                              </select>
                           </div> --}}
                        </div>
                        
                        
                        
                     </div>

                     <div class="form-group form-group-default">
                        <label>Karyawan</label>
                        <select  id="employee" style="width: 100%" required  class="form-control js-example-basic-multiple" name="employees[]" multiple="multiple">
                           <option value="all" >All</option>
                           @foreach ($teams as $team)
                                 @if ($team->employee->status == 1)
                                 <option value="{{$team->employee->id}}">{{$team->employee->biodata->fullName()}}</option>
                                 {{-- <tr>
                                    <td>{{$team->employee->nik}} </td>
                                    <td> {{$team->employee->biodata->fullName()}}</td>
                                 </tr> --}}
                                 @endif
                           @endforeach 
                           {{-- @foreach ($employees as $emp)
                               
                           @endforeach --}}
                        </select>
                     </div>
                     
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Piket/Lembur</label>
                              <select class="form-control " required name="type" id="type">
                                 <option value="" disabled selected>Select</option>
                                 <option value="1">Lembur</option>
                                 <option value="2">Piket</option>
                              </select>
                           </div>
                        </div>
                        <div class="col">
                           <div class="form-group form-group-default">
                              <label>Jam Mulai</label>
                              <input type="time" class="form-control" id="hours_start" name="hours_start" >
                           </div>
                        </div>
                        <div class="col">
                           <div class="form-group form-group-default">
                              <label>Jam Selesai</label>
                              <input type="time" class="form-control" id="hours_end" name="hours_end" >
                           </div>
                        </div>
         
                     </div>
                     <div class="form-group form-group-default">
                        <label>Pekerjaan</label>
                        <textarea type="text"  class="form-control" id="desc" name="desc" rows="3" ></textarea>
                     </div>
                    
                     
                     
                     
                     
                  
               </div>
               
               
            </div>

            <div class="row">
               <div class="col-md-4">
                  <div class="form-group form-group-default">
                     <label>Lokasi Pekerjaan</label>
                     <select class="form-control "  required name="location" id="location">
                        <option value="" disabled selected>Select</option>
                        @foreach ($locations as $loc)
                        <option value="{{$loc->name}}">{{$loc->name}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
              
               <div class="col">
                  <div class="form-group form-group-default">
                     <label>Document</label>
                     <input type="file"  class="form-control" id="doc" name="doc" >
                  </div>
                  
               </div>
            </div>
            <div class="form-check">
               <label class="form-check-label">
                  <input class="form-check-input" type="checkbox" value="" name="rest">
                  <span class="form-check-sign">Kurangi jam istirahat</span>
               </label>
            </div>
            <hr>
            <button class="btn btn-light border" type="submit"><i class="fa fa-save"></i> Save to Draft</button>
         </form>
      </div>
   </div>
   
   <!-- End Row -->


</div>




@endsection