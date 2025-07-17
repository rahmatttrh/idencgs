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
         {{-- <h4><b>Surat Peringatan</b></h4>
         <hr> --}}
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{ route('sp') }}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Surat Peringatan
            </a>
           
            
            @if (auth()->user()->hasRole('HRD|HRD-Manager|HRD-Recruitment|HRD-Payroll|HRD-KJ45|HRD-KJ12'))
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('sp.hrd.create')}}" aria-controls="v-pills-contract" aria-selected="false">
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
            Daftar Surat Peringatan Karyawan
         </small>
      </div>
      <div class="col-md-9">
         <div class="table-responsive">
            <table id="" class="display basic-datatables table-sm table-bordered  table-striped ">
               <thead>
                  <tr>
                     {{-- <th class="text-center" style="width: 10px">No</th> --}}
                     <th>ID</th>
                     <th>NIK</th>
                     <th>Name</th>
                     
                     
                     <th>Level</th>
                     
                     <th>Date</th>
                     <th>Status</th>
                  </tr>
               </thead>
               <tbody>

                  {{-- novi
                  $2y$10$mpL93naoGVjJFMhL/RFR0upzQQRyQZMcnBrJVy6m80BeB1AFxl.M2 --}}

                  {{-- $2y$10$Z5gH9fEqeWD3wbXsDQtUk.i7Ko7HKJOHpo7/WWKkdzDh7cl6R9jQy --}}
                  @if (auth()->user()->hasRole('Administrator|HRD|HRD-Recruitment|HRD-Payroll'))
                  
                     @foreach ($sps as $sp)
                     <tr>
                        {{-- <td class="text-center">{{++$i}}</td> --}}
                        <td><a href="{{route('sp.detail', enkripRambo($sp->id))}}">{{$sp->code}}</a> </td>
                        <td class="text-truncate">{{$sp->employee->nik}}</td>
                        <td> {{$sp->employee->biodata->fullName()}}</td>
                        {{-- <td>{{$sp->employee->nik}}</td> --}}
                        {{-- <td>{{formatDate($sp->date)}}</td> --}}
                        <td>SP {{$sp->level}}</td>
                        
                        <td class="text-truncate">{{$sp->date_from}}</td>
                        <td class="text-truncate">
                           <x-status.sp :sp="$sp" />
                        </td>
                        {{-- <td class="text-truncate" style="max-width: 240px">{{$sp->desc}}</td> --}}

                     </tr>
                     @endforeach

                     @elseif(auth()->user()->hasRole('HRD-KJ45|HRD-KJ12'))
                     @foreach ($sps as $sp)
                        @foreach ($allEmployees as $emp)
                            @if ($sp->employee_id == $emp->id)
                            <tr>
                              {{-- <td class="text-center">{{++$i}}</td> --}}
                              <td><a href="{{route('sp.detail', enkripRambo($sp->id))}}">{{$sp->code}}</a> </td>
                              <td>{{$sp->employee->nik}}</td>
                              <td> {{$sp->employee->biodata->fullName()}}</td>
                              {{-- <td>{{$sp->employee->nik}}</td> --}}
                              {{-- <td>{{formatDate($sp->date)}}</td> --}}
                              <td>SP {{$sp->level}}</td>
                              
                              <td>{{formatDate($sp->date_from)}}</td>
                              <td>
                                 <x-status.sp :sp="$sp" />
                              </td>
                              {{-- <td class="text-truncate" style="max-width: 240px">{{$sp->desc}}</td> --}}
   
                           </tr>
                            @endif
                        @endforeach
                        
                     @endforeach
                  @else
                     @if (count($employee->positions) > 0)
                        @foreach ($employee->positions as $pos)
                           {{-- <tr>
                           <td colspan="6">{{$pos->department->unit->name}} {{$pos->department->name}}</td>
                           </tr> --}}
                           @foreach ($pos->department->sps()->orderBy('updated_at', 'desc')->get() as $sp)
                              <tr>
                                 {{-- <th></th> --}}
                                 <td>{{$sp->code}}</td>
                                 <td>{{$sp->employee->nik}}</td>
                                 <td><a href="{{route('sp.detail', enkripRambo($sp->id))}}"> {{$sp->employee->biodata->fullName()}}</a></td>
                                 
                                 {{-- <td>{{$sp->employee->biodata->first_name}} {{$sp->employee->biodata->last_name}}</td> --}}
                                 
                                 <td>SP {{$sp->level}}</td>
                                 <td>
                                    <x-status.sp :sp="$sp" />
                                 </td>
                                 <td>{{formatDate($sp->date_from)}}</td>
                              </tr>
                           @endforeach
                        @endforeach
                        @else
                        @foreach ($sps as $sp)
                           <tr>
                              {{-- <th></th> --}}
                              <td><a href="{{route('sp.detail', enkripRambo($sp->id))}}">{{$sp->code}}</a> </td>
                              <td><a href="{{route('sp.detail', enkripRambo($sp->id))}}">{{$sp->employee->nik}} {{$sp->employee->biodata->fullName()}}</a></td>
                              <td>{{$sp->code}}</td>
                              {{-- <td>{{$sp->employee->biodata->first_name}} {{$sp->employee->biodata->last_name}}</td> --}}
                              
                              <td>SP {{$sp->level}}</td>
                              <td>
                                 <x-status.sp :sp="$sp" />
                              </td>
                              <td>{{formatDate($sp->date_from)}}</td>
                           </tr>
                        @endforeach
                     @endif
                     
                  @endif
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