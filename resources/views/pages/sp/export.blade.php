@extends('layouts.app')
@section('title')
SP
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item active" aria-current="page">Surat Peringatan</li>
      </ol>
   </nav>
   <div class="row">
      <div class="col-md-3">
         <h4><b>Surat Peringatan</b></h4>
         <hr>
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link  text-left pl-3" id="v-pills-basic-tab" href="{{ route('sp') }}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               SP Karyawan
            </a>
            <a class="nav-link active  text-left pl-3" id="v-pills-contract-tab" href="{{ route('hrd.absence.history') }}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Export 
            </a>
            @if (auth()->user()->hasRole('HRD|HRD-Manager|HRD-Recruitment|HRD-Payroll'))
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('sp.hrd.create')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Create SP
            </a>
            @endif
            
           
            
         </div>
         <hr>
         <small>
            <b>#INFO</b> <br>
            Daftar Surat Peringatan Karyawan
         </small>
      </div>
      <div class="col-md-9">
         <form action="{{route('sp.export')}}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- <input type="number" name="employee" id="employee" value="{{$transaction->employee_id}}" hidden>
            <input type="number" name="spkl_type" id="spkl_type" value="{{$transaction->employee->unit->spkl_type}}" hidden>
            <input type="number" name="transaction" id="transaction" value="{{$transaction->id}}" hidden> --}}
            
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group form-group-default">
                     <label>From</label>
                     <input type="date" required class="form-control" id="from" name="from" >
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group form-group-default">
                     <label>To</label>
                     <input type="date" required class="form-control" id="to" name="to" >
                  </div>
               </div>
               <div class="col-md-4">
                  <button class="btn btn-block btn-primary" type="submit">Export</button>
               </div>
               
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
@endpush



@endsection