@extends('layouts.app')
@section('title')
Form Perubahan Absence
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">Form Perubahan Absence</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         <h4><b>ABSENSI</b></h4>
         <hr>
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link text-left pl-3" id="v-pills-basic-tab" href="{{route('employee.absence')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               List Absensi
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('employee.absence.pending')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Progress
            </a>
            
            <a class="nav-link  text-left pl-3" id="v-pills-personal-tab" href="{{route('employee.absence.draft')}}" aria-controls="v-pills-personal" aria-selected="true">
               <i class="fas fa-user mr-1"></i>
               Draft
            </a>
           

            <a class="nav-link text-left pl-3" id="v-pills-document-tab" href="{{route('employee.absence.create')}}" aria-controls="v-pills-document" aria-selected="false">
               <i class="fas fa-file mr-1"></i>
               Form Absensi
            </a>
            
         </div>
         <hr>
         <table>
            <thead>
               <tr>
                  <th colspan="2">Perubahan Absence</th>
               </tr>
            </thead>
            <tbody>
               {{-- <tr>
                  <t colspan="2">Perubahan Absence</td>
               </tr> --}}
               <tr>
                  <td></td>
                  <td> {{formatDate($absence->date)}}</td>
               </tr>
               <tr>
                  <td></td>
                  <td><x-status.absence-type :absence="$absence"/> </td>
               </tr>
               <tr>
                  <td></td>
                  <td>{{$absence->desc}} </td>
               </tr>
            </tbody>
         </table>
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
         <form action="{{route('employee.absence.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group form-group-default">
                     <label>Date</label>
                     <input type="date" required class="form-control" id="date" name="date" value="{{$absence->date}}">
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group form-group-default">
                     <label>Type</label>
                     <select class="form-control type" required name="type" id="type">
                        <option value="" disabled selected>Select</option>
                        
                        <option  value="4">Izin</option>
                        <option value="5">Cuti</option>
                        <option  value="6">SPT</option>
                        <option value="7">Sakit</option>
                     </select>
                  </div>
               </div>
               
               

               <div class="col-md-6 type_izin">
                  <div class="form-group form-group-default">
                     <label>Jenis Izin</label>
                     <select class="form-control"  name="type_izin" id="type_izin">
                        <option value="" disabled selected>Select</option>
                        <option value="Setengah Hari">Setengah Hari</option>
                        <option value="Satu Hari">Satu Hari</option>
                     </select>
                  </div>
               </div>
               <div class="col-md-6 type_izin">
                  <div class="form-group form-group-default">
                     <label>Awal/Akhir</label>
                     <select class="form-control"  name="type_izin" id="type_izin">
                        <option value="" disabled selected>Select</option>
                        <option value="Tidak Absen Masuk">Tidak Absen Masuk</option>
                        <option value="Tidak Absen Pulang">Tidak Absen Pulang</option>
                     </select>
                  </div>
               </div>
            </div>

            
            <span class="type_cuti">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group form-group-default ">
                        <label>Persetujuan</label>
                        <select class="form-control "  name="persetujuan" id="persetujuan">
                           <option value="" disabled selected>Select</option>
                           @foreach ($employeeLeaders as $lead)
                              <option  value="{{$lead->leader_id}}">{{$lead->leader->biodata->fullName()}}</option>
                           @endforeach
                           {{-- <option  value="4">Izin</option>
                           <option value="5">Cuti</option>
                           <option  value="6">SPT</option>
                           <option value="7">Sakit</option> --}}
                        </select>
                     </div>
                  </div>
                  {{-- <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label>Jumlah cuti yang sudah diambil</label>
                        <input type="text" class="form-control" id="cuti_taken" name="cuti_taken">
                     </div>
                  </div> --}}
                  <div class="col-md-4">
                     <div class="form-group form-group-default">
                        <label>Lama Cuti </label>
                        <input type="text" class="form-control" id="cuti_qty" name="cuti_qty">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group form-group-default">
                        <label>Mulai Cuti</label>
                        <input type="date" class="form-control" id="cuti_start" name="cuti_start">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group form-group-default">
                        <label>Sampai dengan</label>
                        <input type="date" class="form-control" id="cuti_end" name="cuti_end">
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group form-group-default">
                        <label>Keperluan</label>
                        <input type="text" class="form-control" id="keperluan" name="keperluan">
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group form-group-default">
                        <label>Karyawan Pengganti</label>
                        <select class="form-control"  name="cuti_backup" id="cuti_backup">
                           <option value="" disabled selected>Select</option>
                           @foreach ($employees as $emp)
                           <option value="{{$emp->id}}">{{$emp->biodata->fullName()}}</option>
                           @endforeach
                           
                          
                        </select>
                     </div>
                  </div>
               </div>
            </span>

            <span class="type_spt">
               <div class="form-group form-group-default  type_spt">
                  <label>Pemberi Perintah</label>
                  <select class="form-control "  name="leader" id="leader">
                     <option value="" disabled selected>Select</option>
                     @foreach ($employeeLeaders as $lead)
                        <option  value="{{$lead->leader_id}}">{{$lead->leader->biodata->fullName()}}</option>
                     @endforeach
                     {{-- <option  value="4">Izin</option>
                     <option value="5">Cuti</option>
                     <option  value="6">SPT</option>
                     <option value="7">Sakit</option> --}}
                  </select>
               </div>
               
               <div class="form-group form-group-default type_spt">
                  <label>Maksud Perintah Tugas</label>
                  <textarea  class="form-control" id="desc" name="desc" rows="2"></textarea>
               </div>

               <div class="row type_spt">
                  <div class="col-md-6 ">
                     <div class="form-group form-group-default">
                        <label>Jenis SPT</label>
                        <select class="form-control"  name="type_desc" id="type_desc">
                           <option value="" disabled selected>Select</option>
                           <option value="Tidak Absen Masuk">Tidak Absen Masuk</option>
                           <option value="Tidak Absen Pulang">Tidak Absen Pulang</option>
                           <option value="Tidak Absen Masuk & Pulang">Tidak Absen Masuk & Pulang</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group form-group-default">
                        <label>Alat Transportasi</label>
                        <select class="form-control"  name="transport" id="transport">
                           <option value="" disabled selected>Select</option>
                           <option value="Pesawat">Pesawat</option>
                           <option value="Mobil">Mobil</option>
                           <option value="Kereta">Kereta</option>
                           <option value="Motor">Motor</option>
                           <option value="Bus">Bus</option>
                           <option value="Taxi">Taxi</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group form-group-default">
                        <label>Tujuan</label>
                        <input type="text" class="form-control" id="destination" name="destination">
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group form-group-default">
                        <label>Berangkat Dari</label>
                        <input type="text" class="form-control" id="from" name="from">
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group form-group-default">
                        <label>Tempat Transit</label>
                        <input type="text" class="form-control" id="transit" name="transit">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label>Lama Tugas</label>
                        <input type="text" class="form-control" id="duration" name="duration">
                     </div>
                  </div>
               </div>

               <div class="row type_spt">
                  <div class="col-6 ">
                     <div class="form-group form-group-default">
                        <label>Tanggal/Jam Berangkat {{$absence->date}}</label>
                        <input type="datetime-local" class="form-control" value="{{$date}}" id="departure" name="departure">
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group form-group-default">
                        <label>Tanggal/Jam Kembali</label>
                        <input type="datetime-local" class="form-control" value="{{$date}}" id="return" name="return">
                     </div>
                  </div>
               </div>

               
            </span>

            
            <div class="form-group form-group-default">
               <label>Document</label>
               <input type="file" class="form-control" id="doc" name="doc">
            </div>
            <div class="form-group form-group-default">
               <label>Descriptionn</label>
               <textarea type="text" class="form-control" id="remark" name="remark" rows="3"></textarea>
            </div>
            
            <hr>
            <button class="btn  btn-primary" type="submit">Request Perubahan</button>

            


            

            
            



            
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
         $('.type_cuti').hide();
         // $('.spt').hide();

         $('.type').change(function() {
            // console.log('okeee');
            var type = $(this).val();
            if (type == 6) {
            //   $('#foto').show();
              $('.type_spt').show();
              $('.type_izin').hide();
              $('.type_late').hide();
              $('.type_cuti').hide();
            } else if(type == 5) {
               //   $('#foto').show();
               $('.type_izin').hide();
               $('.type_spt').hide();
               $('.type_late').hide();
               $('.type_cuti').show();
            } else if(type == 4) {
               //   $('#foto').show();
               $('.type_izin').show();
               $('.type_spt').hide();
               $('.type_late').hide();
               $('.type_cuti').hide();
            } else  {
               //   $('#foto').show();
               $('.type_izin').hide();
               $('.type_spt').hide();
               $('.type_late').hide();
               $('.type_cuti').hide();
            } 
         })

         
      })
   </script>
@endpush




@endsection