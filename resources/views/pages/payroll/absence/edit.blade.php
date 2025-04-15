@extends('layouts.app')
@section('title')
Edit Absence
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item active" aria-current="page">Edit Absence</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link text-left pl-3" id="v-pills-basic-tab" href="{{route('payroll.absence')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Summary Absence
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('payroll.absence.create')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Form Absence
            </a>
            
            <a class="nav-link  text-left pl-3" id="v-pills-personal-tab" href="{{route('payroll.absence.import')}}" aria-controls="v-pills-personal" aria-selected="true">
               <i class="fas fa-user mr-1"></i>
               Import by Excel
            </a>
           

            
            
         </div>
         {{-- <hr> --}}
         {{-- <a class="btn btn-light border btn-block" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
            Show Form Filter
          </a> --}}
          <hr>
          <table>
            <thead>
               <tr><th colspan="2">Absence Update</th></tr>
            </thead>
            <tbody>
               
               {{-- <tr>
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
               </tr> --}}
               <tr>
                  <td colspan="2">Employee</td>
               </tr>
               <tr>
                  <td></td>
                  <td>
                    {{$absence->employee->nik}}
                     
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td>
                    {{$absence->employee->biodata->fullName()}}
                     
                  </td>
               </tr>
               

             
               
            </tbody>
          </table>
          <hr>
          <table>
            <tbody>
               <tr>
                  <td>Progres Perubahan</td>
               </tr>
               <tr>
                  <td>
                     @if ($absence->getRequest() != null )
                        <a href="{{route('employee.absence.detail', enkripRambo($absence->getRequest()->id))}}" >
                           <x-absence.type :absence="$absence->getRequest()" />
                           :
                           <x-status.form :form="$absence->getRequest()" />
                          
                         </a>
                         @endif
                  </td>
               </tr>
            </tbody>
          </table>
        
      </div>
      <div class="col-md-9">
         <form action="{{route('payroll.absence.update')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <input type="number" name="absenceId" id="absenceId" value="{{$absence->id}}" hidden>
            <div class="form-group form-group-default">
               <label>Employee</label>
               <select class="form-control js-example-basic-single" style="width: 100%" required name="employee" id="employee">
                  <option value="" disabled selected>Select</option>
                  @foreach ($employees as $emp)
                  <option {{$absence->employee_id == $emp->id ? 'selected' : ''}} value="{{$emp->id}}">{{$emp->nik}} {{$emp->biodata->fullName()}}</option>
                  @endforeach
               </select>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group form-group-default">
                     <label>Date</label>
                     <input type="date" required class="form-control" id="date" value="{{$absence->date}}" name="date">
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group form-group-default">
                     <label>Type</label>
                     <select class="form-control type" required name="type" id="type">
                        <option value="" disabled selected>Select</option>
                        <option {{$absence->type == 1 ? 'selected' : ''}} value="1">Alpha</option>
                        <option {{$absence->type == 2 ? 'selected' : ''}} value="2">Terlambat</option>
                        <option {{$absence->type == 3 ? 'selected' : ''}} value="3">ATL</option>
                        <option {{$absence->type == 4 ? 'selected' : ''}} value="4">Izin</option>
                        <option {{$absence->type == 5 ? 'selected' : ''}} value="5">Cuti</option>
                        <option {{$absence->type == 6 ? 'selected' : ''}} value="6">SPT</option>
                     </select>
                  </div>
               </div>
               @if ($absence->type == 6)
               <div class="col-md-6 type_spt">
                  <div class="form-group form-group-default">
                     <label>Jenis SPT</label>
                     <select class="form-control"  name="type_spt" id="type_spt">
                        <option value="" disabled selected>Select</option>
                        <option {{$absence->type_spt == 'Tidak Absen Masuk' ? 'selected' : ''}} value="Tidak Absen Masuk">Tidak Absen Masuk</option>
                        <option {{$absence->type_spt == 'Tidak Absen Pulang' ? 'selected' : ''}} value="Tidak Absen Pulang">Tidak Absen Pulang</option>
                        <option {{$absence->type_spt == 'Tidak Absen Masuk & Pulang' ? 'selected' : ''}} value="Tidak Absen Masuk & Pulang">Tidak Absen Masuk & Pulang</option>
                     </select>
                  </div>
               </div>
               @endif

               @if ($absence->type == 6)
               <div class="col-md-6 type_izin">
                  <div class="form-group form-group-default">
                     <label>Jenis Izin</label>
                     <select class="form-control"  name="type_izin" id="type_izin">
                        <option value="" disabled selected>Select</option>
                        <option {{$absence->type_izin == 'Setengah Hari' ? 'selected' : ''}} value="Setengah Hari">Setengah Hari</option>
                        <option {{$absence->type_izin == 'Satu Hari' ? 'selected' : ''}} value="Satu Hari">Satu Hari</option>
                     </select>
                  </div>
               </div>
               @endif
               

               
            </div>


            

            <div class="row">
               @if ($absence->type == 2)
               <div class="col-md-4">
                  <div class="form-group form-group-default">
                     <label>Menit</label>
                     <select class="form-control"  name="minute" id="minute">
                        <option value="" disabled selected>Select</option>
                        <option  {{$absence->minute == '30' ? 'selected' : ''}} value="T1">T1</option>
                        <option {{$absence->minute == '60' ? 'selected' : ''}} value="T2">T2</option>
                        <option {{$absence->minute == '90' ? 'selected' : ''}} value="T3">T3</option>
                        <option {{$absence->minute == '120' ? 'selected' : ''}} value="T4">T4</option>
                     </select>
                  </div>
               </div>
               @endif
               
               <div class="col">
                  <div class="form-group form-group-default">
                     <label>Document</label>
                     <input type="file" class="form-control" id="doc" name="doc">
                  </div>
               </div>
            </div>
            <div class="form-group form-group-default">
               <label>Desc</label>
               <textarea type="text" class="form-control" id="desc"  name="desc" rows="3">{{$absence->desc}}</textarea>
            </div>



            <button class="btn  btn-primary" type="submit">Update</button>
         </form>
      </div>
   </div>
   
   <!-- End Row -->


</div>




@endsection