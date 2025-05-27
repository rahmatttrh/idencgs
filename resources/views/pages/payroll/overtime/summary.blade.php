@extends('layouts.app')
@section('title')
Summary SPKL
@endsection
@section('content')
<style>
   .btn-rm {
    background: none;
    color: inherit;
    border: none;
    padding: 0;
    font: inherit;
    cursor: pointer;
    outline: inherit;
}
</style>

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item active" aria-current="page">Summary SPKL</li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         {{-- <div class="btn btl-light btn-block text-left mb-3 border">
            <b><i>SPKL KARYAWAN</i></b>
         </div> --}}
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{route('payroll.overtime')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Summary SPKL
            </a>
            <a class="nav-link  text-left pl-3" id="v-pills-basic-tab" href="{{route('payroll.overtime.recent')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-clock mr-1"></i>
               Recent SPKL
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('payroll.overtime.draft')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Draft SPKL
            </a>
            <a class="nav-link   text-left pl-3" id="v-pills-contract-tab" href="{{route('payroll.overtime.create')}}" aria-controls="v-pills-contract" aria-selected="false">
               <i class="fas fa-file-contract mr-1"></i>
               {{-- {{$panel == 'contract' ? 'active' : ''}} --}}
               Form SPKL
            </a>
            
            <a class="nav-link  text-left pl-3" id="v-pills-personal-tab" href="{{route('payroll.overtime.import')}}" aria-controls="v-pills-personal" aria-selected="true">
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
               <tr><th colspan="2">SPKL</th></tr>
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
                     @if ($unitAll == 1)
                         All
                         @else
                         @foreach ($units as $u)
                           {{$u->name}}, 
                        @endforeach
                     @endif
                     
                  </td>
               </tr>

               <tr>
                  <td colspan="2">Location</td>
               </tr>
               <tr>
                  <td></td>
                  <td>
                     @if ($locAll == 1)
                         All
                         @else
                         @foreach ($locations as $l)
                           {{$l->name}}, 
                        @endforeach
                     @endif
                     
                  </td>
               </tr>
               
            </tbody>
          </table>
        
      </div>
      <div class="col-md-9">
         
          
          <div class="collapse" id="collapseExample">
            <form action="{{route('payroll.overtime.filter.summary')}}" method="POST">
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
         <div class="table-responsive p-0">
            <table id="data" class="display  table-sm p-0">
               <thead>
                  <tr>
                     <th>Unit</th>
                     <th>Location</th>
                     <th class="text-center">Lembur</th>
                     <th class="text-center">Piket</th>
                     
                  </tr>
               </thead>

               <tbody>
                  @foreach ($units as $unit)
                      <tr>
                        <td colspan="8">
                           {{-- <a href="{{route('payroll.absence.unit', [enkripRambo($unit->id), enkripRambo($from), enkripRambo($to), ])}}">{{$unit->name}}</a> --}}
                           
                           <form action="{{route('payroll.overtime.unit')}}" method="POST">
                              @csrf
                              <input type="number" name="unit" id="unit" value="{{$unit->id}}" hidden>
                              <input type="number" name="locAll" id="locAll" value="{{$locAll}}" hidden>
                              <input type="date" name="from" id="from" value="{{$from}}" hidden>
                              <input type="date" name="to" id="to" value="{{$to}}" hidden>
                              <select  name="locations[]" id="locations" hidden class=" "  multiple="multiple">
                                 @foreach ($allLocations as $loc)
                                    @foreach ($locations as $l)
                                       @if ($l->id == $loc->id)
                                       <option value="{{$l->id}}" selected></option>
                                       @endif
                                    @endforeach
                                     
                                 @endforeach
                                 <option value=""></option>
                              </select>
                              <button type="submit" class="btn-rm text-primary">{{$unit->name}}</button>
                           </form>
                        </td>
                        
                      </tr>
                      @foreach($locations as $loc)
                        @if ($loc->totalEmployee($unit->id))
                        <tr>
                           <td></td>
                           <td>
                              <a href="{{route('payroll.overtime.loc', [enkripRambo($unit->id), enkripRambo($loc->id), $from, $to, $locAll])}}">{{$loc->code}}</a>
                              
                           </td>
                           <td class="text-center">{{$loc->getLembur($unit->id,$from,$to)}}</td>
                           <td class="text-center">{{$loc->getPiket($unit->id,$from,$to)}}</td>
                           
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