@extends('layouts.app')
@section('title')
Employee
@endsection
@section('content')


<style>
   
</style>


<div class="page-inner">
   <div class="page-header d-flex">

      <h5 class="page-title">SPKL</h5>
      <ul class="breadcrumbs">
         <li class="nav-home">
            <a href="/">
               <i class="flaticon-home"></i>
            </a>
         </li>
         <li class="separator">
            <i class="flaticon-right-arrow"></i>
         </li>
         <li class="nav-item">
            <a href="#">Employee</a>
         </li>
         <li class="separator">
            <i class="flaticon-right-arrow"></i>
         </li>
         <li class="nav-item">
            <a href="#">SPKL</a>
         </li>
      </ul>
      <div class="ml-auto">
         <button class="btn btn-light border btn-round " data-toggle="dropdown">
            <i class="fa fa-ellipsis-h"></i>
         </button>
         <div class="dropdown-menu">


            <a class="dropdown-item" style="text-decoration: none" href="{{route('employee.create')}}">Create</a>
            <a class="dropdown-item" style="text-decoration: none" href="{{route('employee.import')}}">Import</a>
            
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" style="text-decoration: none" href="" target="_blank">Print Preview</a>
         </div>
      </div>
   </div>

   

   <div class="row">
      <div class="col-md-3">
         <h4>Form Create</h4>
         <hr>
         <form action="{{route('employee.spkl.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
               <div class="col-12">
                  
                     {{-- <input type="number" name="employee" id="employee" value="{{$transaction->employee_id}}" hidden>
                     <input type="number" name="spkl_type" id="spkl_type" value="{{$transaction->employee->unit->spkl_type}}" hidden>
                     <input type="number" name="transaction" id="transaction" value="{{$transaction->id}}" hidden> --}}
                     
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group form-group-default">
                              <label>Date</label>
                              <input type="date" required class="form-control" id="date" name="date" >
                           </div>
                        </div>
                        <div class="col-md-12">
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
                              <input type="number" class="form-control" id="hours" name="hours" >
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
         <hr>
         Fitur masih dalam tahap pengembangan :)
      </div>
      <div class="col-md-9">
         {{-- <div class="row">
            <div class="col-md-4">
               <div class="card">
                  <div class="card-body">
                     April 12 Hours
                  </div>
               </div>
            </div>
         </div> --}}
         <div class="table-responsive p-0">
            <table id="" class="basic-datatables " >
               <thead>
                  <tr>
                     <th>ID</th>
                     <th>Date</th>
                     <th>Out</th>
                     <th>Loc</th>
                     <th style="max-width: 50px">Desc</th>
                     <th>Status</th>
                     {{-- <th></th> --}}
                     {{-- <th>Desc</th> --}}
                     
                  </tr>
               </thead>
              
               <tbody>

                  @foreach ($spkls as $spkl)
                  <tr>
                     <td><a href="{{route('spkl.detail', enkripRambo($spkl->id))}}">{{$spkl->code}}</a></td>
                     <td>{{formatDate($spkl->date)}}</td>
                     <td> {{formatTime($spkl->end)}}</td>
                     <td>{{$spkl->loc}}</td>
                     <td style="max-width: 250px" class="text-truncate">{{$spkl->desc}}</td>
                     <td>
                        <x-status.spkl :spkl="$spkl" />
                     </td>
                     {{-- <td>
                        <a href="{{route('spkl.detail')}}" class="btn btn-sm btn-primary">Detail</a>
                     </td> --}}
                  
                  </tr>
                  @endforeach
                  
                  
                  
               </tbody>
            </table>
         </div>
         <hr>

         <div class="row">
            <div class="col-md-7 ">
               <div class="table-responsive pl-3">
                  <table>
                     <tbody>
                        <tr>
                           <td>April</td>
                           <td>8 Hours</td>
                           <td>Mei</td>
                           <td>2 Hours</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
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