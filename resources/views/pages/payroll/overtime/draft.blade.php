@extends('layouts.app')
@section('title')
SPKL
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item" aria-current="page">Payroll</li>
         <li class="breadcrumb-item active" aria-current="page">SPKL</li>
      </ol>
   </nav>

   <div class="card shadow-none border col-md-12">
      <div class=" card-header">
         <x-overtime.overtime-tab :activeTab="request()->route()->getName()" />
      </div>

      <form action="{{route('payroll.overtime.publish')}}" method="post" >
         @csrf
         @error('id_item')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
         @enderror
         <div class="card-body px-0">
            {{-- <div class="card-header"> 
               <div class="card-title">Draft</div>
            </div>  --}}
            <div class="d-inline-flex align-items-center">
               <button type="submit" name="submit" class="btn btn-sm btn-primary mr-3">Publish</button>
               <div class="d-inline-flex align-items-center">
                     <span class="badge badge-muted badge-counter">
                        <span id="total">0</span>
                     </span>
               </div>
            </div>
            <hr>
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
                        <x-modal.delete :id="$over->id" :body="$over->employee->biodata->fullName()" url="{{route('payroll.overtime.delete', enkripRambo($over->id))}}" />
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </form>


   </div>
   <!-- End Row -->


</div>

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




@endsection