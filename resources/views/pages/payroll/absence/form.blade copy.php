@extends('layouts.app')
@section('title')
Payroll Absence
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item" aria-current="page">Payroll</li>
         <li class="breadcrumb-item active" aria-current="page">Absence</li>
      </ol>
   </nav>

   <div class="card shadow-none border ">
      <div class=" card-header">
         <x-absence-tab :activeTab="request()->route()->getName()" />
      </div>

      <div class="card-body ">
         <div class="row">
            <div class="col-md-6">
               
            </div>
         </div>
         


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