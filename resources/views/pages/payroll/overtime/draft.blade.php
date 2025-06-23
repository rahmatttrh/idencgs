@extends('layouts.app')
@section('title')
Draft SPKL
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item active" aria-current="page">Draft SPKL</li>
      </ol>
   </nav>

   <form action="{{route('payroll.overtime.publish')}}" method="post" >
      @csrf
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
               <a class="nav-link active text-left pl-3" id="v-pills-contract-tab" href="{{route('payroll.overtime.draft')}}" aria-controls="v-pills-contract" aria-selected="false">
                  <i class="fas fa-file-contract mr-1"></i>
                  {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
                  Draft 
               </a>
               <a class="nav-link  text-left pl-3" id="v-pills-contract-tab" href="{{route('payroll.overtime.create')}}" aria-controls="v-pills-contract" aria-selected="false">
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
            @error('id_item')
                  <div class="alert alert-danger mt-2">{{ $message }}</div>
               @enderror
               <button type="submit" name="submit" class="btn btn-sm btn-block btn-primary mr-3">Publish <span class="ml-2 badge badge-muted badge-counter">
                  <span id="total">0</span>
               </span></button>
           
               <br>
            <a href="{{route('payroll.overtime.draft.delete')}}">Delete multiple data? click here</a>
            <hr>
            <b>#INFO</b> <br>
            <small>Daftar Data SPKL yang belum aktif</small>
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
            
               
            <div class="table-responsive">
               <table id="multi-filter-select" class="display  table-sm  " >
                  <thead>
                     <tr>
                        <th>&nbsp; <input type="checkbox" id="selectall" /></th>
                        <th>Type</th>
                        <th>Employee</th>
                        <th>Location</th>
                        <th class="text-right">Date</th>
                        
                        <th class="text-center">Hours</th>
                        @if (auth()->user()->hasRole('HRD|HRD-Payroll|Administrator'))
                        <th class="text-right">Rate</th>
                        @endif
                        
                        <th></th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($overtimes as $over)
                        <tr>
                           <td class="text-center"><input type="checkbox" class="case" name="id_item[]" value="{{$over->id}}" /> </td>
                           <td>
                              {{-- @if (auth()->user()->hasRole('Administrator'))
                                 {{$over->id}}
                              @endif --}}
                              
                              @if ($over->type == 1)
                                 Lembur
                                 @else
                                 Piket
                              @endif
                           </td>
                           <td class="text-truncate">{{$over->employee->nik}} {{$over->employee->biodata->fullName()}}</td>
                           <td>{{$over->employee->location->name}}</td>
                           <td class="text-right">
                              @if ($over->holiday_type == 1)
                                 <span  class="text-info ">
                                 @elseif($over->holiday_type == 2)
                                 <span class="text-danger">
                                 @elseif($over->holiday_type == 3)
                                 <span class="text-danger">LN -
                                 @elseif($over->holiday_type == 4)
                                 <span class="text-danger">LR -
                              @endif
                              <a href="#" data-target="#modal-overtime-doc-{{$over->id}}" data-toggle="modal" class="text-white">{{formatDateDayB($over->date)}}</a>
                              </span>
                           </td>
                           
                           
                           <td class="text-center">
                              @if ($over->type == 1)
                                    @if ($over->employee->unit->hour_type == 1)
                                       {{$over->hours}}
                                       @elseif ($over->employee->unit->hour_type == 2)
                                       {{$over->hours}} ({{$over->hours_final}})
                                    @endif
                                 @else
                                 -
                              @endif
                              
                              
                           </td>
                           {{-- <td class="text-center">{{getMultiple($over->hours)}}</td> --}}
                           @if (auth()->user()->hasRole('HRD|HRD-Payroll|Administrator'))
                           <td class="text-right text-truncate">{{formatRupiah($over->rate)}}</td>
                           @endif
                           <td>
                              <a href="#" data-target="#modal-delete-overtime-{{$over->id}}" data-toggle="modal">Delete</a>
                           </td>
                        </tr>
                        <div class="modal fade" id="modal-delete-overtime-{{$over->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <div class="modal-dialog modal-sm" role="document">
                              <div class="modal-content text-dark">
                                 <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                                 <div class="modal-body ">
                                    Delete data 
                                    @if ($over->type == 1)
                                       Lembur
                                       @else
                                       Piket
                                    @endif
                                    {{$over->employee->nik}} {{$over->employee->biodata->fullName()}}
                                    tanggal {{formatDate($over->date)}}
                                    ?
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger ">
                                       <a class="text-light" href="{{route('payroll.overtime.delete', enkripRambo($over->id))}}">Delete</a>
                                    </button>
                                 </div>
                              </div>
                           </div>
                        </div>
                     @endforeach
                  </tbody>
               </table>
            </div>
            
         </div>
      
   </div>
</form>
   
   <!-- End Row -->


</div>

@push('myjs')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>
   $(document).ready(function() {
      $('.tanggal').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
      });
   });

   var total = document.getElementById("total");

   $(function() {

      $("#selectall").change(function() {
            if (this.checked) {
               $(".case").each(function() {
                  this.checked = true;
               });
               var jumlahCheck = $(".case").length;
            } else {
               $(".case").each(function() {
                  this.checked = false;
               });
               var jumlahCheck = 0;
            }

            // menampilkan output ke elemen hasil
            total.innerHTML = jumlahCheck;
            // console.log(jumlahCheck);
      });

      $(".case").click(function() {
            if ($(this).is(":checked")) {
               var isAllChecked = 0;
               var jumlahCheck = $('input:checkbox:checked').length;

               $(".case").each(function() {
                  if (!this.checked)
                        isAllChecked = 1;
               });

               if (isAllChecked == 0) {
                  $("#selectall").prop("checked", true);

                  jumlahCheck = $(".case").length;
               }


            } else {
               $("#selectall").prop("checked", false);

               jumlahCheck = $('input:checkbox:checked').length;
            }
            total.innerHTML = jumlahCheck;
            console.log(jumlahCheck);

      });


   });
</script>
@endpush




@endsection