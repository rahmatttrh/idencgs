@extends('layouts.app')
@section('title')
Form Absence
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item active" aria-current="page">Form Absence</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link  text-left pl-3" id="v-pills-basic-tab" href="{{route('payroll.absence')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Summary Absence
            </a>
            <a class="nav-link active text-left pl-3" id="v-pills-contract-tab" href="{{route('payroll.absence.create')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Form Absence
            </a>
            
            <a class="nav-link  text-left pl-3" id="v-pills-personal-tab" href="{{route('payroll.absence.import')}}" aria-controls="v-pills-personal" aria-selected="true">
               <i class="fas fa-user mr-1"></i>
               Import by Excel
            </a>
           

            
            
         </div>
         <hr>
         <b>#INFO</b><br>
         <small>Form Absence ini digunakan untuk input data final dari Alpha,Cuti, SPT, ATL dll yang sudah melalui proses Approval Manual.</small><br><br>
         <small>Jika anda ingin mengajukan Cuti/SPT/Izin pribadi melalui sistem. Silahkan untuk membuka menu 'Absensi Saya' di menu sidebar</small>

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
         <form action="{{route('payroll.absence.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
           
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group form-group-default">
                     <label>Date</label>
                     <input type="date" required class="form-control" id="date" name="date">
                  </div>
               </div>
               <div class="col-md-8">
                  <div class="form-group form-group-default">
                     <label>Employee</label>
                     <select class="form-control js-example-basic-single" style="width: 100%" required name="employee" id="employee">
                        <option value="" disabled selected>Select</option>
                        @foreach ($employees as $emp)
                        <option value="{{$emp->id}}">{{$emp->nik}} {{$emp->biodata->fullName()}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group form-group-default">
                     <label>Type</label>
                     <select class="form-control type" required name="type" id="type">
                        <option value="" disabled selected>Select</option>
                        <option value="1">Alpha</option>
                        <option value="2">Terlambat</option>
                        <option value="3">ATL</option>
                        <option value="4">Izin</option>
                        <option value="5">Cuti</option>
                        <option value="6">SPT</option>
                        <option value="7">Sakit</option>
                        <option value="8">Dinas Luar</option>
                        <option value="9">Off Kontrak</option>
                     </select>
                  </div>
               </div>
               <div class="col-md-8 type_spt">
                  <div class="form-group form-group-default">
                     <label>Jenis SPT</label>
                     <select class="form-control"  name="type_spt" id="type_spt">
                        <option value="" disabled selected>Select</option>
                        <option value="Tidak Absen Masuk">Tidak Absen Masuk</option>
                        <option value="Tidak Absen Pulang">Tidak Absen Pulang</option>
                        <option value="Tidak Absen Masuk & Pulang">Tidak Absen Masuk & Pulang</option>
                     </select>
                  </div>
               </div>

               <div class="col-md-8 type_izin">
                  <div class="form-group form-group-default">
                     <label>Jenis Izin</label>
                     <select class="form-control"  name="type_izin" id="type_izin">
                        <option value="" disabled selected>Select</option>
                        <option value="Setengah Hari">Setengah Hari</option>
                        <option value="Satu Hari">Satu Hari</option>
                     </select>
                  </div>
               </div>
               <div class="col-md-8 type_late">
                  <div class="form-group form-group-default">
                     <label>Keterlambatan</label>
                     {{-- <input type="number" class="form-control" id="minute" name="minute"> --}}
                     <select class="form-control"  name="minute" id="minute">
                        <option value="" disabled selected>Select</option>
                        <option value="T1">T1</option>
                        <option value="T2">T2</option>
                        <option value="T3">T3</option>
                        <option value="T4">T4</option>
                     </select>
                  </div>
               </div>

               
            </div>


            

            <div class="row">
               
               
               <div class="col">
                  <div class="form-group form-group-default">
                     <label>Document</label>
                     <input type="file" class="form-control" id="doc" name="doc">
                  </div>
               </div>
            </div>
            <div class="form-group form-group-default">
               <label>Desc</label>
               <textarea type="text" class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>



            <button class="btn  btn-primary" type="submit">Submit</button>
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