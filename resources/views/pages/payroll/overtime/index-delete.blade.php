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

   <div class="card shadow-none border">
      <div class="card-header">
         SPKL Delete Multiple
      </div>
      <div class="card-body">
         <form action="{{route('payroll.overtime.index.delete.filter')}}" method="POST">
            @csrf
            <div class="row">
               <div class="col-md-2">
                  <div class="form-group form-group-default">
                     <label>From</label>
                     <input type="date" name="from" id="from" value="{{$from}}" class="form-control">
                  </div>
               </div>
               <div class="col-md-2">
                  <div class="form-group form-group-default">
                     <label>To</label>
                     <input type="date" name="to" id="to" value="{{$to}}" class="form-control">
                  </div>
               </div>
               
               
               
               <div class="col-2">
                  <button class="btn btn-primary" type="submit" >Filter</button> <br>
                  
               </div>
               
            </div>
         </form> 
      </div>
       


      


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