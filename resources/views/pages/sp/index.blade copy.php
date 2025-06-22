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
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{ route('sp') }}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Surat Peringatan
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{ route('sp.create') }}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Form SP
            </a>
            
           
            
         </div>
         <hr>
         <div class="card">
            <div class="card-body">
               <small>Daftar Surat Peringatan Karyawan.</small>
            </div>
         </div>
         
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
          {{-- <h4>Pengajuan SPKL</h4> --}}
         
          <table id="" class="display basic-datatables table-sm table-bordered  table-striped ">
            <thead>
               <tr>
                  {{-- <th class="text-center" style="width: 10px">No</th> --}}
                  <th>ID</th>
                  <th>NIK</th>
                  <th>Name</th>
                  
                  
                  <th>Level</th>
                  <th>Status</th>
                  <th>Date</th>
               </tr>
            </thead>
            <tbody>

               {{-- novi
               $2y$10$mpL93naoGVjJFMhL/RFR0upzQQRyQZMcnBrJVy6m80BeB1AFxl.M2 --}}

               {{-- $2y$10$Z5gH9fEqeWD3wbXsDQtUk.i7Ko7HKJOHpo7/WWKkdzDh7cl6R9jQy --}}
               @if (auth()->user()->hasRole('Administrator|HRD|HRD-Recruitment'))
               @foreach ($sps as $sp)
               <tr>
                  {{-- <td class="text-center">{{++$i}}</td> --}}
                  <td><a href="{{route('sp.detail', enkripRambo($sp->id))}}">{{$sp->code}}</a> </td>
                  <td>{{$sp->employee->nik}}</td>
                  <td> {{$sp->employee->biodata->fullName()}}</td>
                  {{-- <td>{{$sp->employee->nik}}</td> --}}
                  {{-- <td>{{formatDate($sp->date)}}</td> --}}
                  <td>SP {{$sp->level}}</td>
                  <td>
                     <x-status.sp :sp="$sp" />
                  </td>
                  <td>{{formatDate($sp->date_from)}}</td>
                  {{-- <td class="text-truncate" style="max-width: 240px">{{$sp->desc}}</td> --}}

               </tr>
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
                           <td><a href="{{route('sp.detail', enkripRambo($sp->id))}}">{{$sp->employee->nik}} </a></td>
                           <td>{{$sp->employee->biodata->fullName()}}</td>
                           {{-- <td>{{$sp->code}}</td> --}}
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
   

   <div class="tab-content" id="v-pills-tabContent">
      <div class="tab-pane fade show active" id="v-pills-basic" role="tabpanel" aria-labelledby="v-pills-basic-tab">
         <div class="card card-with-nav shadow-none border">
            <div class="card-header">
               <div class="row row-nav-line">
                  <ul class="nav nav-tabs nav-line nav-color-secondary" role="tablist">
                     <li class="nav-item"> <a class="nav-link show active" id="pills-index-tab-nobd" data-toggle="pill" href="#pills-index-nobd" role="tab" aria-controls="pills-index-nobd" aria-selected="true">SP</a> </li>
                     @if (auth()->user()->hasRole('Administrator|HRD|HRD-Payroll|HRD-Recruitment|HRD-Payroll'))
                     <li class="nav-item"> <a class="nav-link " id="pills-doc-tab-nobd" data-toggle="pill" href="#pills-doc-nobd" role="tab" aria-controls="pills-doc-nobd" aria-selected="true">Export</a> </li>
                     @endif
                     @if (auth()->user()->hasRole('HRD|HRD-Manager|HRD-Recruitment|HRD-Payroll'))
                     <li class="nav-item"> <a class="nav-link " href="{{route('sp.hrd.create')}}"  aria-controls="pills-doc-nobd" aria-selected="true">Create SP</a> </li>
                               {{-- <a href="{{route('sp.hrd.create')}}" class="btn btn-primary btn-sm">Create SP</a>
                               <hr> --}}
                           @endif
                     
                     
                  </ul>
               </div>
            </div>
            <div class="card-body">
               <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                  <div class="tab-pane fade show active p-0" id="pills-index-nobd" role="tabpanel" aria-labelledby="pills-index-tab-nobd">
                     <div class="row">
                        <div class="col-md-4">
                           <h4>Form Pengajuan SP</h4>
                           <hr>
                           <form action="{{route('sp.store')}}" method="POST" enctype="multipart/form-data">
                              @csrf
                              
                              <div class="row">
                                 <div class="col-md-12">
                                    <div class="form-group form-group-default">
                                       <label>Employee*</label>
                                       <select class="form-control employee js-example-basic-single" required id="employee" name="employee">
                                          <option value="" selected disabled>Select Employee</option>
                                          @if (auth()->user()->hasRole('Manager|Asst. Manager|HRD'))
                                             @foreach ($employee->positions as $pos)
                                                @foreach ($pos->department->employees as $emp)
                                                <option value="{{$emp->id}}">{{$emp->nik}} {{$emp->biodata->fullName()}} </option>
                                                @endforeach
                                             @endforeach
                                                {{-- @foreach ($employees as $emp)
                                                <option value="{{$emp->id}}">{{$emp->nik}} {{$emp->biodata->fullName()}} </option>
                                                @endforeach --}}
                                             @elseif(auth()->user()->hasRole('HRD|Administrator') || auth()->user()->hasRole('HRD-Spv|HRD-Payroll'))
                                                @foreach ($allEmployees as $emp)
                                                   <option value="{{$emp->id}}">{{$emp->nik}} {{$emp->biodata->fullName()}} </option>
                                                @endforeach
                                             @else 
                                                @foreach ($employees as $emp)
                                                   <option value="{{$emp->employee->id}}">{{$emp->employee->nik}} {{$emp->employee->biodata->fullName()}} </option>
                                                @endforeach
                                          @endif
                                          
                                       </select>
                                       
                        
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                       <label>Level*</label>
                                       <select class="form-control" required id="level" name="level">
                                          <option value="" selected disabled>Select level</option>
                                          <option value="I">SP I</option>
                                          <option value="II">SP II</option>
                                          <option value="III">SP III</option>
                                       </select>
               
                                    </div>
                                 </div>
                                 
                              </div>
               
                           
                              <div class="form-group form-group-default">
                                 <label>Alasan*</label>
                                 <input type="text" required class="form-control" name="reason" id="reason">
                              </div>
               
                              <div class="form-group form-group-default">
                                 <label>Kronologi*</label>
                                 <textarea class="form-control" required name="desc" id="desc" rows="4"></textarea>
                              </div>
                              <div class="form-group form-group-default">
                                 <label>File attachment</label>
                                 <input type="file" class="form-control" name="file" id="file">
                              </div>
                              <hr>
                              <button type="submit" class="btn btn-block btn-primary">Submit</button>
                           </form>
                        </div>
                  
                        <div class="col">
                           
                           
                           {{-- @if (auth()->user()->hasRole('HRD|HRD-Manager|HRD-Recruitment|HRD-Payroll'))
                               <a href="{{route('sp.hrd.create')}}" class="btn btn-primary btn-sm">Create SP</a>
                               <hr>
                           @endif --}}
                           <div class="table-responsive">
                              <table id="" class="display basic-datatables table-sm table-bordered  table-striped ">
                                 <thead>
                                    <tr>
                                       {{-- <th class="text-center" style="width: 10px">No</th> --}}
                                       <th>ID</th>
                                       <th>NIK</th>
                                       <th>Name</th>
                                       
                                       
                                       <th>Level</th>
                                       <th>Status</th>
                                       <th>Date</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                  
                                    {{-- novi
                                    $2y$10$mpL93naoGVjJFMhL/RFR0upzQQRyQZMcnBrJVy6m80BeB1AFxl.M2 --}}
                  
                                    {{-- $2y$10$Z5gH9fEqeWD3wbXsDQtUk.i7Ko7HKJOHpo7/WWKkdzDh7cl6R9jQy --}}
                                    @if (auth()->user()->hasRole('Administrator|HRD|HRD-Recruitment'))
                                    @foreach ($sps as $sp)
                                    <tr>
                                       {{-- <td class="text-center">{{++$i}}</td> --}}
                                       <td><a href="{{route('sp.detail', enkripRambo($sp->id))}}">{{$sp->code}}</a> </td>
                                       <td>{{$sp->employee->nik}}</td>
                                       <td> {{$sp->employee->biodata->fullName()}}</td>
                                       {{-- <td>{{$sp->employee->nik}}</td> --}}
                                       {{-- <td>{{formatDate($sp->date)}}</td> --}}
                                       <td>SP {{$sp->level}}</td>
                                       <td>
                                          <x-status.sp :sp="$sp" />
                                       </td>
                                       <td>{{formatDate($sp->date_from)}}</td>
                                       {{-- <td class="text-truncate" style="max-width: 240px">{{$sp->desc}}</td> --}}
                  
                                    </tr>
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
                                                <td><a href="{{route('sp.detail', enkripRambo($sp->id))}}">{{$sp->employee->nik}} </a></td>
                                                <td>{{$sp->employee->biodata->fullName()}}</td>
                                                {{-- <td>{{$sp->code}}</td> --}}
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
      
                  <div class="tab-pane fade" id="pills-doc-nobd" role="tabpanel" aria-labelledby="pills-doc-tab-nobd">
                     <div class="row">
                        <div class="col-md-4">
                           <form action="{{route('sp.export')}}" method="POST" enctype="multipart/form-data">
                              @csrf
                              {{-- <input type="number" name="employee" id="employee" value="{{$transaction->employee_id}}" hidden>
                              <input type="number" name="spkl_type" id="spkl_type" value="{{$transaction->employee->unit->spkl_type}}" hidden>
                              <input type="number" name="transaction" id="transaction" value="{{$transaction->id}}" hidden> --}}
                              
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                       <label>From</label>
                                       <input type="date" required class="form-control" id="from" name="from" >
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                       <label>To</label>
                                       <input type="date" required class="form-control" id="to" name="to" >
                                    </div>
                                 </div>
                                 
                                 
                              </div>
                              <hr>
                              
                              
                              
                              <button class="btn btn-block btn-primary" type="submit">Export</button>
                           </form>
                        </div>
                     </div>
                    
                     
                  </div>

                  
      
      
               </div>
      
            </div>
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