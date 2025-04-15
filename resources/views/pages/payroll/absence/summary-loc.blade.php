@extends('layouts.app')
@section('title')
Summary Absence
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
               <tr><th colspan="2">Absence/Unit/Location</th></tr>
            </thead>
            <tbody>
               <tr>
                  <td colspan="2">
                     <a  data-toggle="collapse" href="#collapseExample">Show Form Filter</a>
                  </td>
               </tr>
               <tr>
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
               </tr>
               <tr>
                  <td colspan="2">Unit</td>
               </tr>
               <tr>
                  <td></td>
                  <td>
                    {{$unit->name}}
                     
                  </td>
               </tr>
               <tr>
                  <td colspan="2">Location</td>
               </tr>
               <tr>
                  <td></td>
                  <td>
                    {{$location->name}}
                    
                     
                  </td>
               </tr>

             
               
            </tbody>
          </table>
        
      </div>
      <div class="col-md-9">
         <div class="collapse" id="collapseExample">
            <form action="{{route('payroll.absence.filter.summary')}}" method="POST">
               @csrf
               <div class="row">
                  
                  <div class="col-md-3">
                     <div class="form-group form-group-default">
                        <label>From</label>
                        <input type="date" name="from" id="from" required value="{{$from}}" class="form-control">
                     </div>
                     <div class="form-group form-group-default">
                        <label>To</label>
                        <input type="date" name="to" id="to" required value="{{$to}}" class="form-control">
                     </div>
                  </div>
                  <div class="col-md-9">
                     <div class="form-group form-group-default">
                        <label>Unit</label>
                        <select  id="unit" style="width: 100%" required  class="form-control js-example-basic-multiple" name="units[]" multiple="multiple">
                           <option value="all" >All</option>
                           @foreach ($allUnits as $unit)
                               <option value="{{$unit->id}}">{{$unit->name}}</option>
                           @endforeach
                        </select>
                     </div>
                     <div class="form-group form-group-default">
                        <label>Location</label>
                        <select  id="location" style="width: 100%" required  class="form-control js-example-basic-multiple" name="locations[]" multiple="multiple">
                           <option value="all">All</option>
                           @foreach ($allLocations as $loc)
                               <option value="{{$loc->id}}">{{$loc->code}}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  
                 
                  
               </div>
               <button class="btn btn-primary mb-4" type="submit" ><i class="fa fa-search"></i> Filter</button> 
               
              
               
               
               
            </form>  
          </div>
         <div class="table-responsive">
            <table id="data" class="display basic-datatables table-sm">
               <thead>
                  <tr>
                     <th>NIK</th>
                     <th>Name</th>
                     {{-- <th>Location</th> --}}
                     {{-- <th>Loc</th> --}}
                     <th class="text-center">Alpha</th>
                     <th class="text-center">Terlambat</th>
                     <th class="text-center">ATL</th>
                     <th class="text-center">Izin</th>
                     <th class="text-center">Cuti</th>
                     <th class="text-center">Sakit</th>
                     {{-- <th class="text-right">Rate</th> --}}
                  </tr>
               </thead>
               
               <tbody>
                  @foreach ($employees as $emp)
                      <tr>
                        <td class="text-truncate">{{$emp->nik}}</td>
                        <td class="text-truncate" style="max-width: 140px"> 
                           <a href="{{route('payroll.absence.employee.detail', [enkripRambo($emp->id), $from, $to])}}">{{$emp->biodata->fullName()}}</a>
                        </td>
                        {{-- <td>{{$emp->location->name ?? '-'}}</td> --}}
                        {{-- <td class="text-truncate" style="max-width: 100px">{{$emp->location->code ?? ''}} </td> --}}
                        {{-- <td>{{$emp->department->name}}</td> --}}
                        <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 1))}}</td>
                        <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 2))}}</td>
                        <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 3))}}</td>
                        <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 4))}}</td>
                        <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 5))}}</td>
                        <td class="text-center">{{count($emp->getAbsences($from, $to)->where('type', 7))}}</td>
                        {{-- <td class="text-right">{{formatRupiahB($emp->getOvertimes($from, $to)->sum('rate'))}}</td> --}}
                      </tr>
                  @endforeach
               </tbody>
               
            </table>
         </div>
      </div>
   </div>
   
   <!-- End Row -->


</div>




@endsection