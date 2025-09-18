@extends('layouts.app')
@section('title')
Form Lembur/Piket
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">Form Lembur - Piket</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         {{-- <h4><b>SPKL SAYA</b></h4>
         <hr> --}}
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link  text-left pl-3" id="v-pills-basic-tab" href="{{route('employee.spkl')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               List SPKL
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('employee.spkl.progress')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Progress
            </a>
            
            <a class="nav-link  text-left pl-3" id="v-pills-personal-tab" href="{{route('employee.spkl.draft')}}" aria-controls="v-pills-personal" aria-selected="true">
               <i class="fas fa-user mr-1"></i>
               Draft
            </a>
           

            <a class="nav-link active text-left pl-3" id="v-pills-document-tab" href="{{route('employee.spkl.create')}}" aria-controls="v-pills-document" aria-selected="false">
               <i class="fas fa-file mr-1"></i>
               Form SPKL 
            </a>
            {{-- <a class="nav-link text-left pl-3" id="v-pills-document-tab" href="{{route('employee.spkl.create.multiple')}}" aria-controls="v-pills-document" aria-selected="false">
               <i class="fas fa-file mr-1"></i>
               Form SPKL B
            </a> --}}
            
         </div>
         <hr>
         <b>#INFO</b> <br>
         <small>Form SPKL digunakan untuk pengajuan lembur/piket satu karyawan</small> <br> <br>
         <small>"Jam Mulai" dan "Jam Selesai" wajib diisi untuk pengajuan Lembur</small>
        
         <hr>
      </div>
      <div class="col-md-9">
         {{-- <h4>Form Pengajuan Lembur & Piket</h4> --}}
         <div class="badge badge-info">Form Pengajuan Lembur & Piket</div>
         <hr>

         @if ($employee->location_id >= 3 && $employee->location_id <= 6)
            <h1>Pemberitahuan</h1>
            <hr>
            <p>Untuk karyawan area Kalijapat, pembuatan From SPKL Staff diserahkan ke Team Leader.</p>
            <p>Dipersilahkan menghubungi Team Leader jika anda ingin membuat Form SPKL</p>
             @else
               <form action="{{route('employee.spkl.store')}}" method="POST" enctype="multipart/form-data">
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
                              </div>
                              <div class="col">
                                 <div class="form-group form-group-default">
                                    <label>Type</label>
                                    <select class="form-control " required name="holiday_type" id="holiday_type">
                                       <option value="" disabled selected>Select</option>
                                       <option value="1">Hari Kerja</option>
                                       <option value="2">Hari Libur</option>
                                       <option value="3">Hari Libur Nasional</option>
                                       <option value="4">Hari Libur Idul Fitri</option>
                                    </select>
                                 </div>
                              </div>
                              
                              
                              
                           </div>
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="form-group form-group-default">
                                    <label>Piket/Lembur</label>
                                    <select class="form-control " required name="type" id="type">
                                       <option value="" disabled selected>Select</option>
                                       <option value="1">Lembur</option>
                                       <option value="2">Piket</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group form-group-default">
                                    <label>Jam Mulai</label>
                                    <input type="time" class="form-control" id="hours_start" name="hours_start" >
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group form-group-default">
                                    <label>Jam Selesai</label>
                                    <input type="time" class="form-control" id="hours_end" name="hours_end" >
                                 </div>
                              </div>
                              {{-- <div class="col-md-4">
                                 <div class="form-group form-group-default">
                                    <label>Jam Mulai</label>
                                    <input type="datetime-local" class="form-control" id="hours_start" name="hours_start" >
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group form-group-default">
                                    <label>Jam Selesai</label>
                                    <input type="datetime-local" class="form-control" id="hours_end" name="hours_end" >
                                 </div>
                              </div> --}}
               
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
                              <option value="Workspace">Workspace</option>
                           </select>
                        </div>
                     </div>
                  
                     <div class="col">
                        <div class="form-group form-group-default">
                           <label>LAMPIRAN DOKUMEN (FOTO/PDF)</label>
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
                  
                  <div class="row">
                  
                  </div>
                  <hr>
                  <button class="btn btn-light border" type="submit"><i class="fa fa-save"></i> Save to Draft</button>
               </form>
               @endif
      </div>
   </div>
   
   <!-- End Row -->


</div>




@endsection