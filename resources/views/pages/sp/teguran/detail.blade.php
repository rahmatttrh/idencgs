@extends('layouts.app')
@section('title')
SP Detail
@endsection
@section('content')

<style>
   html {
      -webkit-print-color-adjust: exact;
   }

   @media print {

      header,
      footer,
      nav,
      aside,
      .sidebar,
      .main-header,
      .hide, .master, .discuss {
         display: none;
      }

      .main-panel {
         width: 100%;
      }

      @page {
         size: auto;
         /* auto is the initial value */
         margin: 0mm;
         /* this affects the margin in the printer settings */
      }

   }
</style>

<div class="page-inner">
  
   <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-11">
         <div class="row hide align-items-center">
            <div class="col">

               
               


               <h5 class="page-title">{{$st->code}}</h5>

            </div>
            @if (auth()->user()->hasRole('HRD|HRD-Payroll|HRD-Recruitment'))
            <div class="col-auto">
               <a href="#" class="btn btn-danger mb-3" data-toggle="modal" data-target="#modal-delete-st">Delete</a>
            </div>
            @endif
            
            
         </div>

         
         
             
         
         <div class="row">
            <div class="col-md-12">
               
               <div class="card card-invoice">
                  <div class="card-header text-center">
                     <br>
                     <h2><b>SURAT TEGURAN</b></h2>
                           <b>{{$st->code}}</b>
                  </div>
                  <div class="card-body pt-4 px-4">
                     {{-- <div class="d-flex justify-content-between">
                        <div>
                           <img src="{{asset('img/logo/enc2.jpg')}}" alt="company logo"><br>
                        </div>
                        <div class="text-center">
                           <h3><b>SURAT PERINGATAN {{$sp->level}}</b></h3>
                           <b>{{$sp->code}}</b>
                        </div>
                     </div> --}}
                     
                     {{-- <hr> --}}
                     <br>
                     <p >Kepada Yth.</p>
               
                     <div class="row">
                        <div class="col-12">
                           <div class="row">
                              <div class="col-3">Nama</div>
                              <div class="col">: {{$st->employee->biodata->fullName()}}</div>
                           </div>
                           <div class="row">
                              <div class="col-3">NIK</div>
                              <div class="col">: {{$st->employee->nik}}</div>
                           </div>
                           <div class="row">
                              <div class="col-3">Jabatan</div>
                              <div class="col">: {{$st->employee->position->name}}</div>
                           </div>
                           <div class="row">
                              <div class="col-3">Departemen/Divisi</div>
                              <div class="col">: {{$st->employee->department->name}}</div>
                           </div>
                           <div class="row mt-4">
                              <div class="col-12">Sehubungan dengan pelanggaran yang {{$gen}} lakukan, yaitu :</div>
                           </div>
                           <br>
                           <div class="row mb-1 mt-1">
                              <div class="col">
                                 <b>{{$st->desc}}</b>
                              </div>
                           </div>
                        </div>
                     </div>
               
                     <br>
                     <p>Maka sesuai dengan peraturan yang berlaku ( <b>Peraturan Perusahaan {{$st->rule}}</b> ) kepada {{$gen}} diberikan sanksi berupa <b>SURAT TEGURAN</b>.</p>
               
                     <p>Setelah {{$gen}} menerima SURAT TEGURAN ini, diharapkan {{$gen}} dapat merubah sikap {{$gen}} dan kembali bekerja dengan baik. <br>Semoga dapat dimengerti dan dimaklumi. </p>
               
                     
               
                     <br><br>
                     <div class="page-divider"></div>
                     
                  </div>
                  <br><br>
                  <div class="card-footer">
                     
                  </div>
               </div>
            </div>
         </div>
      </div>
      
      
      
   </div>
</div>

<div class="modal fade" id="modal-delete-st" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content text-dark">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body ">
            Delete Surat Teguran {{$st->code}} ?
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger ">
               <a class="text-light" href="{{route('st.delete', enkripRambo($st->id))}}">Delete</a>
            </button>
         </div>
      </div>
   </div>
</div>










{{-- <x-sp.modal.submit :sp="$sp" /> --}}





@endsection