@extends('layouts.app')
@section('title')
Payslip Employee
@endsection
@section('content')

<div class="page-inner">
  

   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item active" aria-current="page">Import Payslip</li>
      </ol>
   </nav>

   <div class="card shadow-none border">
      <div class="card-header d-flex">
         <div class="d-flex  align-items-center">
            <div class="card-title">Payslip Import by Excel</div>
         </div>

      </div>
      <div class="card-body">
         <div class="row">
            <div class="col-md-8">
               
               <form action="{{route('hrd.payslip.import.store')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group form-group-default">
                     <label>Bisnis Unit</label>
                     <select name="unit" id="unit" class="form-control">
                        @foreach ($units as $u)
                            <option value="{{$u->id}}">{{$u->name}}</option>
                        @endforeach
                     </select>
                     
                     @error('unit')
                     <small class="text-danger"><i>{{ $message }}</i></small>
                     @enderror
                  </div>

                  <div class="row">
                     <div class="col-6">
                        <div class="form-group form-group-default">
                           <label>Month</label>
                           <select name="month" id="month" required class="form-control">
                              <option value="January">January</option>
                              <option value="February">February</option>
                              <option value="March">March</option>
                              <option value="April">April</option>
                              <option value="May">May</option>
                              <option value="June">June</option>
                              <option value="July">July</option>
                              <option value="August">August</option>
                              <option value="September">September</option>
                              <option value="October">October</option>
                              <option value="November">November</option>
                              <option value="December">December</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="form-group form-group-default">
                           <label>Year</label>
                           <select name="year" id="year" required class="form-control">
                              
                              <option value="2025">2025</option>
                           </select>
                        </div>
                     </div>
                    
                  </div>

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Cut Off From</label>
                           <input type="date" class="form-control" required name="from" id="from">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>To</label>
                           <input type="date" class="form-control" required name="to" id="to">
                        </div>
                     </div>
                  </div>

                  <div class="form-group ">
                     <label>File Excel</label>
                     <input id="file" name="file" type="file" class="form-control-file">
                     @error('file')
                     <small class="text-danger"><i>{{ $message }}</i></small>
                     @enderror
                  </div>
                  <hr>
                  <div class="form-group">
                     <button type="submit" class="btn btn-primary">Import</button>
                  </div>

               </form>
            </div>
            <div class="col-md-4">
               <div class="card card-light card-annoucement card-round shadow-none border">
                  <div class="card-body text-center">
                     <img src="{{asset('img/xls-file.png')}}" class="img mb-4" height="110" alt="">
                    
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="card-footer">
         {{-- <small>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quo, autem laborum?</small> --}}
      </div>
   </div>
</div>

@endsection