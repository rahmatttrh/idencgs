@extends('layouts.app')
@section('title')
SummaryAbsence
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item active" aria-current="page">Summary Absence</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{route('employee.absence')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Summary Absence
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('employee.absence.pending')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Form Add
            </a>
            
            <a class="nav-link  text-left pl-3" id="v-pills-personal-tab" href="{{route('employee.absence.draft')}}" aria-controls="v-pills-personal" aria-selected="true">
               <i class="fas fa-user mr-1"></i>
               Form Import
            </a>
           

            
            
         </div>
         <hr>
         <a class="btn btn-light border btn-block" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
            Form Filter
          </a>
         {{-- <span class="badge badge-info mb-1 badge-block">Filter</span>
         <form action="{{route('payroll.absence.filter.employee')}}" method="POST">
            @csrf
            <div class="row">
               
               <div class="col-md-12">
                  <div class="form-group form-group-default">
                     <label>From</label>
                     <input type="date" name="from" id="from" value="{{$from}}" class="form-control">
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group form-group-default">
                     <label>To</label>
                     <input type="date" name="to" id="to" value="{{$to}}" class="form-control">
                  </div>
               </div>
              
               
            </div>
            <div class="form-group form-group-default">
               <label>Unit</label>
               <select name="unit" id="unit" class="form-control">
                  <option value="all" selected>All</option>
                  @foreach ($units as $unit)
                      <option value="{{$unit->id}}">{{$unit->name}}</option>
                  @endforeach
               </select>
            </div>
            <div class="form-group form-group-default">
               <label>Location</label>
               <select name="unit" id="unit" class="form-control">
                  <option value="all" selected>All</option>
                  @foreach ($locations as $loc)
                      <option value="{{$loc->id}}">{{$loc->code}}</option>
                  @endforeach
               </select>
            </div>
            <button class="btn btn-light border btn-block" type="submit" ><i class="fa fa-search"></i> Filter</button> 
         </form>  --}}
         {{-- <form action="">
            <select name="" id="" class="form-control">
               <option value="">Januari</option>
               <option value="">Februari</option>
            </select>
         </form> --}}
         {{-- <a href="" class="btn btn-light border btn-block">Absensi</a> --}}
      </div>
      <div class="col-md-9">
         
          
          <div class="collapse" id="collapseExample">
            <form action="{{route('payroll.absence.filter.employee')}}" method="POST">
               @csrf
               <div class="row">
                  <div class="col-md-8">
                     <div class="row">
                  
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>From</label>
                              <input type="date" name="from" id="from" value="{{$from}}" class="form-control">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>To</label>
                              <input type="date" name="to" id="to" value="{{$to}}" class="form-control">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Unit</label>
                              <select name="unit" id="unit" class="form-control">
                                 <option value="all" selected>All</option>
                                 @foreach ($units as $unit)
                                     <option value="{{$unit->id}}">{{$unit->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Location</label>
                              <select name="unit" id="unit" class="form-control">
                                 <option value="all" selected>All</option>
                                 @foreach ($locations as $loc)
                                     <option value="{{$loc->id}}">{{$loc->code}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                       
                        
                     </div>
                  </div>
                  <div class="col-md-4">
                     <button class="btn btn-light border btn-block" type="submit" ><i class="fa fa-search"></i> Filter</button> 
                  </div>
               </div>
              
               
               
               
            </form>  
          </div>
         <div class="table-responsive p-0">
            <table id="data" class="display  table-sm p-0">
               <thead>
                  <tr>
                     <th>Unit</th>
                     <th>Location</th>
                     <th class="text-center">Alpha</th>
                     <th class="text-center">Terlambat</th>
                     <th class="text-center">ATL</th>
                     <th class="text-center">Izin</th>
                     <th class="text-center">Cuti</th>
                     <th class="text-center">Sakit</th>
                  </tr>
               </thead>

               <tbody>
                  @foreach ($units as $unit)
                      <tr>
                        <td colspan="8">{{$unit->name}}</td>
                        
                      </tr>
                      @foreach($locations as $loc)
                        @if ($loc->totalEmployee($unit->id))
                        <tr>
                           <td></td>
                           <td>{{$loc->code}}</td>
                           <td class="text-center">{{$loc->totalAbsence($unit->id,$from,$to)}}</td>
                           <td class="text-center">{{$loc->totalLate($unit->id,$from,$to)}}</td>
                           <td class="text-center">{{$loc->totalAtl($unit->id,$from,$to)}}</td>
                           <td class="text-center">{{$loc->totalIzin($unit->id,$from,$to)}}</td>
                           <td class="text-center">{{$loc->totalCuti($unit->id,$from,$to)}}</td>
                           <td class="text-center">{{$loc->totalSakit($unit->id,$from,$to)}}</td>
                        </tr>
                        @endif
                     
                      @endforeach
                  @endforeach
               </tbody>

            </table>
         </div>
      </div>
   </div>
   
   <!-- End Row -->


</div>




@endsection