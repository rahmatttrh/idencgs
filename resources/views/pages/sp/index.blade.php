@extends('layouts.app')
@section('title')
SP
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item active" aria-current="page">SP & Teguran</li>
      </ol>
   </nav>



   <div class="row">
      <div class="col-md-3">
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{ route('sp') }}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               SP & Teguran
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{ route('sp.create') }}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Form SP
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{ route('st.create') }}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Form Teguran
            </a>
            
           
            
         </div>
         <hr>
         <div class="card">
            <div class="card-body">
               <small>Daftar SP & Teguran Karyawan.</small>
            </div>
         </div>
         
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
          {{-- <h4>Pengajuan SPKL</h4> --}}
         
          <table id="" class="display datatables-4 table-sm table-bordered  table-striped ">
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

               
               @if (count($employee->positions) > 0)
                  @foreach ($employee->positions as $pos)
                     {{-- <tr>
                     <td colspan="6">{{$pos->department->unit->name}} {{$pos->department->name}}</td>
                     </tr> --}}
                     @foreach ($pos->department->sps()->orderBy('updated_at', 'desc')->get() as $sp)
                        <tr>
                           {{-- <th></th> --}}
                           <td><a href="{{route('sp.detail', enkripRambo($sp->id))}}">{{$sp->code}}</a></td>
                           <td class="text-truncate">{{$sp->employee->nik}}</td>
                           <td  class="text-truncate"> {{$sp->employee->biodata->fullName()}}</td>
                           
                           {{-- <td>{{$sp->employee->biodata->first_name}} {{$sp->employee->biodata->last_name}}</td> --}}
                           
                           <td>SP {{$sp->level}}</td>
                           <td  class="text-truncate">{{$sp->date_from}}</td>
                           <td class="text-truncate">
                              <x-status.sp :sp="$sp" />
                           </td>
                           
                        </tr>
                     @endforeach

                     @foreach ($pos->department->sts()->orderBy('updated_at', 'desc')->get() as $st)
                        <tr>
                           {{-- <th></th> --}}
                           <td><a href="{{route('st.detail', enkripRambo($st->id))}}">{{$st->code}}</a> </td>
                           <td class="text-truncate">{{$st->employee->nik}} </td>
                           <td class="text-truncate">{{$st->employee->biodata->fullName()}}</td>
                           {{-- <td>{{$sp->code}}</td> --}}
                           {{-- <td>{{$sp->employee->biodata->first_name}} {{$sp->employee->biodata->last_name}}</td> --}}
                           
                           <td>Teguran</td>
                           <td class="text-truncate">
                              {{$st->date}}
                           </td>
                           <td class="text-truncate">
                              <x-status.st :st="$st" />
                           </td>
                           
                        </tr>
                     @endforeach
                  @endforeach
                  @else
                     @foreach ($sps as $sp)
                        <tr>
                           {{-- <th></th> --}}
                           <td><a href="{{route('sp.detail', enkripRambo($sp->id))}}">{{$sp->code}}</a> </td>
                           <td>{{$sp->employee->nik}}</td>
                           <td>{{$sp->employee->biodata->fullName()}}</td>
                           {{-- <td>{{$sp->code}}</td> --}}
                           {{-- <td>{{$sp->employee->biodata->first_name}} {{$sp->employee->biodata->last_name}}</td> --}}
                           
                           <td>SP {{$sp->level}}</td>
                           <td class="text-truncate">{{$sp->date}}</td>
                           <td class="text-truncate">
                              <x-status.sp :sp="$sp" />
                           </td>
                           
                        </tr>
                     @endforeach
                     @foreach ($sts as $st)
                        <tr>
                           {{-- <th></th> --}}
                           <td><a href="{{route('st.detail', enkripRambo($st->id))}}">{{$st->code}}</a> </td>
                           <td class="text-truncate">{{$st->employee->nik}} </td>
                           <td class="text-truncate">{{$st->employee->biodata->fullName()}}</td>
                           {{-- <td>{{$sp->code}}</td> --}}
                           {{-- <td>{{$sp->employee->biodata->first_name}} {{$sp->employee->biodata->last_name}}</td> --}}
                           
                           <td>Teguran</td>
                           <td class="text-truncate">
                              {{$st->date}} 
                           </td>
                           <td class="text-truncate">
                              <x-status.st :st="$st" />
                           </td>
                           
                        </tr>
                     @endforeach
               @endif
               
            </tbody>
         </table>
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