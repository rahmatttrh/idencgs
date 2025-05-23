@extends('layouts.app')
@section('title')
Import SPKL
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item active" aria-current="page">Import SPKL</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         <div class="btn btl-light btn-block text-left mb-3 border">
            <b><i>SPKL KARYAWAN</i></b>
         </div>
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link  text-left pl-3" id="v-pills-basic-tab" href="{{route('payroll.overtime')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Summary SPKL
            </a>
            <a class="nav-link  text-left pl-3" id="v-pills-contract-tab" href="{{route('payroll.overtime.draft')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Draft SPKL
            </a>
            <a class="nav-link  text-left pl-3" id="v-pills-contract-tab" href="{{route('payroll.overtime.create')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Form SPKL
            </a>
            
            <a class="nav-link active text-left pl-3" id="v-pills-personal-tab" href="{{route('payroll.overtime.import')}}" aria-controls="v-pills-personal" aria-selected="true">
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
         <img src="{{asset('img/xls-file.png')}}" class="img mb-4" height="110" alt="">
               <form action="{{route('overtime.import.store')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group ">
                     <label>File Excel</label>
                     <input id="excel" name="excel" type="file" class="form-control-file">
                     @error('excel')
                     <small class="text-danger"><i>{{ $message }}</i></small>
                     @enderror
                  </div>
                  <hr>
                  <div class="form-group">
                     <button type="submit" class="btn btn-primary">Import</button>
                  </div>

               </form>
               <hr>
               <div class="card card-light border shadow-none">
                  <div class="card-body ">
                     {{-- <div class="card-opening">Import Excel</div> --}}
                     
                     <div class="card-detail">
                        <a href="/documents/template-spkl-rev.xlsx" class="btn btn-success btn-rounded">Download Template</a>
                     </div>
                     {{-- <div class="card-desc text-left">
                        Kolom Business Unit, Department, Sub Department, Position diisi dengan angka ID yang bisa dilihat di Master Data
                     </div> --}}
                  </div>
                  <div class="card-footer">
                     <b>Panduan Pengisian Template Excel SPKL</b>
                     <hr>
                        - Kolom Type hanya bisa di isi ' <b>Lembur atau Piket</b> '<br>
                        - Kolom Tipe Libur hanya bisa di isi ' <b>Masuk, Libur, Libur Nasional, Idhul Fitri</b> ' <br>
                     
                        
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