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
         <li class="breadcrumb-item active" aria-current="page">SPKL Employee</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         {{-- <div class="btn btl-light btn-block text-left mb-3 border">
            <b><i>SPKL KARYAWAN</i></b>
         </div> --}}
         {{-- <div class="btn btn-light border btn-block text-left mb-3">SPKL KARYAWAN</div>
          --}}
         <table>
            <thead>
               <tr><th colspan="2">SPKL Karyawan</th></tr>
            </thead>
            <tbody>
               <tr>
                  <td colspan="2">Employee</td>
               </tr>
               <tr>
                  <td></td>
                  <td>
                    {{$employee->nik}}
                     
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td>
                    {{$employee->biodata->fullName()}}
                     
                  </td>
               </tr>
               <tr>
                  <td colspan="2">Periode</td>
                  
               </tr>
               <tr>
                  <td></td>
                  <td>
                     @if ($from != 0)
                     {{formatDate($from)}} - {{formatDate($to)}}
                     @else
                     All
                     @endif
                  </td>
               </tr>
               
               <tr>
                  <td colspan="2">Detail</td>
               </tr>
               <tr>
                  <td></td>
                  <td>
                     Rp. {{formatRupiahB($employee->getOvertimes($from, $to)->sum('rate'))}}
                  </td>

               </tr>
               <tr>
                  <td></td>
                  <td>
                     Lembur :
                     @if ($employee->unit->hour_type == 1)
                     {{$employee->getOvertimes($from, $to)->where('type', 1)->sum('hours')}}
                        @elseif ($employee->unit->hour_type == 2)
                        {{$employee->getOvertimes($from, $to)->where('type', 1)->sum('hours_final')}}
                     @endif
                     Jam
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td>
                     Piket : 
                     {{$employee->getOvertimes($from, $to)->where('type', 2)->sum('hours_final')}} Kali
                  </td>
               </tr>
               

             
               
            </tbody>
         </table>
         <hr>
         <b>#INFO</b> <br>
         <small>LN = Libur Nasional</small>
      </div>
      <div class="col-md-9">
         <div class="table-responsive px-0">
            <table id="data" class="display basic-datatables table-sm">
               <thead>
                  <tr>
                     @if (auth()->user()->hasRole('HRD|HRD-Payroll'))
                     <th>&nbsp; <input type="checkbox" id="selectall" /></th>
                     @endif
                     <th>Type</th>
                     {{-- <th>NIK</th>
                     <th>Name</th> --}}
                     {{-- <th>Loc</th> --}}
                     <th>Day</th>
                     <th class="text-right">Date</th>
                     
                     <th class="text-center text-truncate">Qty (Jam)</th>
                     {{-- <td></td> --}}
                     @if (auth()->user()->hasRole('HRD-Payroll|Administrator'))
                     <th class="text-right">Rate</th>
                     @endif
                     <th>Desc</th>
                     @if (auth()->user()->hasRole('Administrator|HRD|HRD-Payroll|HRD-KJ12|HRD-KJ45|HRD-JGC'))
                     <th></th>
                     @endif
                     {{-- @if (auth()->user()->hasRole('Administrator'))
                     <th></th>
                     @endif --}}
                  </tr>
               </thead>
               
               <tbody>
                  @foreach ($overtimes as $over)
                     <tr>
                        {{-- <td>{{++$i}}</td> --}}
                        @if (auth()->user()->hasRole('HRD|HRD-Payroll'))
                        <td class="text-center"><input type="checkbox" class="case" name="id_item[]" value="{{$over->id}}" /> </td>
                        @endif
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
                        {{-- <td class="text-truncate">{{$over->employee->nik}}</td>
                        <td class="text-truncate" style="max-width: 200px">{{$over->employee->biodata->fullName()}}</td> --}}
                        {{-- <td>{{$over->employee->location->name}}</td> --}}
                        <td>{{formatDayName($over->date)}}</td>
                        <td class="text-right text-truncate">
                           @if ($over->holiday_type == 1)
                              <span  class="text-info ">
                              @elseif($over->holiday_type == 2)
                              <span class="text-warning">
                              @elseif($over->holiday_type == 3)
                              <span class="text-danger">LN -
                              @elseif($over->holiday_type == 4)
                              <span class="text-danger">LR -
                           @endif
                           <a href="#" data-target="#modal-overtime-doc-{{$over->id}}" data-toggle="modal" class="text-white">{{formatDate($over->date)}}</a>
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
                              1
                           @endif
                           
                           
                        </td>
                        {{-- <td class="text-center">{{getMultiple($over->hours)}}</td> --}}
                        @if (auth()->user()->hasRole('HRD-Payroll|Administrator'))
                        <td class="text-right text-truncate">{{formatRupiah($over->rate)}}</td>
                        @endif
                        <td class="text-truncate" style="max-width: 150px" data-toggle="tooltip" data-placement="top" title="{{$over->description}}">
                           {{$over->description}}
                        </td>
                        @if (auth()->user()->hasRole('Administrator|HRD|HRD-Payroll|HRD-KJ12|HRD-KJ45|HRD-JGC'))
                        <td class="text-truncate">
                        <a href="{{route('payroll.overtime.edit', enkripRambo($over->id))}}">Edit</a> |
                           <a href="#" data-target="#modal-delete-overtime-{{$over->id}}" data-toggle="modal">Delete</a>
                        </td>
                        @endif
                        {{-- @if (auth()->user()->hasRole('Administrator'))
                        <td>{{formatDateTime($over->created_at)}}</td>
                        @endif --}}
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