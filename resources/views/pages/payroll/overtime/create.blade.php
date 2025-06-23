@extends('layouts.app')
@section('title')
Form SPKL
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item active" aria-current="page">Form SPKL</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         {{-- <div class="btn btl-light btn-block text-left mb-3 border">
            <b><i>SPKL KARYAWAN</i></b>
         </div> --}}
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link  text-left pl-3" id="v-pills-basic-tab" href="{{route('payroll.overtime')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Summary SPKL
            </a>
            <a class="nav-link  text-left pl-3" id="v-pills-basic-tab" href="{{route('payroll.overtime.recent')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-clock mr-1"></i>
               Recent Input
            </a>
            <a class="nav-link  text-left pl-3" id="v-pills-contract-tab" href="{{route('payroll.overtime.draft')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Draft 
            </a>
            <a class="nav-link active text-left pl-3" id="v-pills-contract-tab" href="{{route('payroll.overtime.create')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Form Add SPKL
            </a>
            
            <a class="nav-link  text-left pl-3" id="v-pills-personal-tab" href="{{route('payroll.overtime.import')}}" aria-controls="v-pills-personal" aria-selected="true">
               <i class="fas fa-user mr-1"></i>
               Import by Excel
            </a>
           

            
            
         </div>
         <hr>
         {{-- <table>
            <tbody>
               <tr>
                  <td colspan="3">Recent add</td>
               </tr>
               @foreach ($absences as $abs)
               <tr>
                   <td class="text-truncate" style="max-width: 120px">{{$abs->employee->nik}} </td>
                   <td>{{formatDate($abs->date)}}</td>
                   <td><x-status.absence-type :absence="$abs" /> </td>
                  </tr>
               @endforeach
            </tbody>
         </table> --}}
        
      </div>
      <div class="col-md-9">
         <form action="{{route('payroll.overtime.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
               <div class="col-12">
                  
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
                              <input type="decimal" class="form-control" id="hours" name="hours" >
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

@push('myjs')
   <script>

      $(document).ready(function() {
         // console.log('report function');
         // $('#foto').hide();
         $('.type_spt').hide();
         $('.type_izin').hide();
         $('.type_late').hide();

         $('.type').change(function() {
            // console.log('okeee');
            var type = $(this).val();
            if(type == 1){
               $('.type_spt').hide();
              $('.type_izin').hide();
              $('.type_late').hide();
            } else if (type == 2) {
               //   $('#foto').show();
              $('.type_spt').hide();
              $('.type_izin').hide();
              $('.type_late').show();
            } else if (type == 6) {
               //   $('#foto').show();
              $('.type_spt').show();
              $('.type_izin').hide();
              $('.type_late').hide();
            } else if(type == 4) {
               //   $('#foto').show();
               $('.type_izin').show();
               $('.type_spt').hide();
            } else if(type == 2) {
               //   $('#foto').show();
               $('.type_izin').show();
               $('.type_spt').hide();
               $('.type_late').hide();
            } else {
               $('.type_izin').hide();
               $('.type_spt').hide();
               $('.type_late').hide();
            }
         })

         
      })
   </script>
@endpush




@endsection