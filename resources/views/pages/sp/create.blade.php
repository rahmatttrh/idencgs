@extends('layouts.app')
@section('title')
SP
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item " aria-current="page">Surat Peringatan</li>
         <li class="breadcrumb-item active" aria-current="page">Create</li>
      </ol>
   </nav>
   <div class="row">
      <div class="col-md-3">
         <h4><b>Surat Peringatan</b></h4>
         <hr>
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link  text-left pl-3" id="v-pills-basic-tab" href="{{ route('sp') }}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Surat Peringatan
            </a>
           
            
            @if (auth()->user()->hasRole('HRD|HRD-Manager|HRD-Recruitment|HRD-Payroll|HRD-KJ45|HRD-KJ12'))
            <a class="nav-link  active text-left pl-3" id="v-pills-contract-tab" href="{{route('sp.hrd.create')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Form Surat Peringatan
            </a>
          
               {{-- <li class="nav-item"> <a class="nav-link " href="{{route('sp.hrd.create')}}"  aria-controls="pills-doc-nobd" aria-selected="true">Create SP</a> </li> --}}
                           {{-- <a href="{{route('sp.hrd.create')}}" class="btn btn-primary btn-sm">Create SP</a>
                           <hr> --}}
                     @endif

                     <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{ route('sp.export') }}" aria-controls="v-pills-contract" aria-selected="false">
                        <i class="fas fa-file-contract mr-1"></i>
                        {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
                        Export
                     </a>
            
           
            
         </div>
         <hr>
         <small>
            <b>#INFO</b> <br>
            Pilih 'Type' Existing untuk input data SP yang sudah final <br><br>
            Surat Peringatan akan mempengaruhi nilai PE
         </small>
      </div>
      <div class="col-md-9">
         <form action="{{route('sp.hrd.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
         
               <div class="row">
                  <div class="col">
                     <div class="form-group form-group-default">
                        <label>Employee*</label>
                        <select class="form-control employee js-example-basic-single" required id="employee" name="employee">
                           <option value="" selected disabled>Select Employee</option>
                           @foreach ($allEmployees as $emp)
                                 <option value="{{$emp->id}}">{{$emp->nik}} {{$emp->biodata->fullName()}} </option>
                           @endforeach
                           
                        </select>
                        
         
                     </div>
                     
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-7">
                     <div class="form-group form-group-default">
                        <label>Type*</label>
                        <select class="form-control   required id="type" name="type">
                           <option value="" selected disabled>Select Type</option>
                           <option value="1">Existing</option>
                           <option value="2">Recomendation</option>
                        </select>
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group form-group-default">
                        <label>Date</label>
                        <input type="date"  class="form-control" name="date_from" id="date_from">
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group form-group-default">
                        <label>Level*</label>
                        <select class="form-control" required id="level" name="level">
                           {{-- <option value="" selected disabled>Select level</option> --}}
                           <option value="I">SP I</option>
                           <option value="II">SP II</option>
                           <option value="III">SP III</option>
                        </select>
      
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group form-group-default">
                        <label>To Leader*</label>
                        <select class="form-control to " required  id="to" name="to">
                           
                           
                        </select>
                        
         
                     </div>
                  </div>
                  
               </div>
      
               
               <div class="form-group form-group-default">
                  <label>Alasan*</label>
                  <textarea  class="form-control" name="reason" id="reason" rows="3"></textarea>
               </div>
               <div class="form-group form-group-default">
                  <label>Peraturan yang dilanggar*</label>
                  <input type="text"  class="form-control" name="rule" id="rule">
               </div>
               <div class="form-group form-group-default">
                  <label>File attachment</label>
                  <input type="file" class="form-control" name="file" id="file">
               </div>
               <hr>
               <button type="submit" class="btn  btn-primary">Submit</button>
               <hr>
               <small>* SP akan otomatis aktif ketika klik Submit</small>
      
              
         </div>
      </form>
      </div>
   </div>
   


   
</div>

@push('myjs')
   <script>
      console.log('get_aktif_sp');
      $(".sp").hide();
   

      $(document).ready(function() {
         $('.employee').change(function() {
            
            var employee = $('#employee').val();
            var _token = $('meta[name="csrf-token"]').attr('content');
            // console.log('okeee');
            console.log('employeeId:' + employee);
            
            $.ajax({
               url: "/fetch/sp/active/" + employee ,
               method: "GET",
               dataType: 'json',

               success: function(result) {
                  // console.log('near :' + result.near);
                  // console.log('result :' + result.result);
                  
                  console.log('status :' + result.success);
                  if (result.success == true) {
                     $('.result').empty()
                     console.log('adaaa');
                     $(".sp").show();
                  } else {
                     $('.result').empty()
                     console.log('kosong');
                     $(".sp").hide();
                  }
                  

                  $.each(result.result, function(i, index) {
                     $('.result').html(result.result);

                  });
               },
               error: function(error) {
                  console.log(error)
               }

            })
         })
      })
   </script>

<script>
   console.log('get_leaders');

   $(document).ready(function() {

      $('.employee').change(function() {
         var employee = $('.employee').val();
         var _token = $('meta[name="csrf-token"]').attr('content');
         // console.log('okeee');
         console.log('employee :' + employee);
         
         $.ajax({
            url: "/fetch/leader/" + employee ,
            method: "GET",
            dataType: 'json',

            success: function(result) {
               
               $.each(result.result, function(i, index) {
                  $('.to').html(result.result);

               });
            },
            error: function(error) {
               console.log(error)
            }

         })
      })
   })
</script>
@endpush



@endsection