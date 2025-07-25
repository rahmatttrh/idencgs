@extends('layouts.app')
@section('title')
Surat Teguran
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item active" aria-current="page">Surat Teguran</li>
      </ol>
   </nav>
   <div class="row">
      <div class="col-md-3">
         {{-- <h4><b>Surat Peringatan</b></h4>
         <hr> --}}
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            
            <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{ route('st') }}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Surat Teguran
            </a>
            
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('st.hrd.create')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Form Surat Teguran
            </a>
             
           
            
         </div>
         <hr>
         <small>
            <b>#INFO</b> <br>
            Daftar Surat Peringatan Karyawan
         </small>
      </div>
      <div class="col-md-9">
         <div class="table-responsive">
            <table id="" class="display datatables-3 table-sm table-bordered  table-striped ">
               <thead>
                  <tr>
                     {{-- <th class="text-center" style="width: 10px">No</th> --}}
                     <th>ID</th>
                     <th>NIK</th>
                     <th>Name</th>
                     <th>Date</th>
                     <th>Status</th>
                  </tr>
               </thead>
               <tbody>

                  @foreach ($sts as $st)
                  <tr>
                     {{-- <td class="text-center">{{++$i}}</td> --}}
                     <td><a href="{{route('st.detail', enkripRambo($st->id))}}">{{$st->code}}</a> </td>
                     <td>{{$st->employee->nik}}</td>
                     <td> {{$st->employee->biodata->fullName()}}</td>
                     {{-- <td>{{$sp->employee->nik}}</td> --}}
                     {{-- <td>{{formatDate($sp->date)}}</td> --}}
                     <td>{{$st->date}}</td>
                     <td>
                        <x-status.st :st="$st" />
                     </td>
                     

                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
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