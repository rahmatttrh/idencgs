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
            <a class="nav-link  text-left pl-3" id="v-pills-basic-tab" href="{{route('payroll.overtime')}}" aria-controls="v-pills-basic" aria-selected="true">
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
          <h4>Form Filter</h4>
               <hr>
               <form action="{{route('payroll.overtime.filter.employee')}}" method="POST">
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
                     {{-- @if (auth()->user()->hasRole('Administrator|HRD-Payroll'))
                     <div class="col-md-2">
                        <div class="form-group form-group-default">
                           <label>Lokasi</label>
                           
                           <select name="loc" id="loc" required class="form-control">
                              <option selected value="" disabled>Choose </option>
                             
                                  <option {{$loc == 'KJ45' ? 'selected' : ''}} value="KJ45">KJ 4-5</option>
                              
                           </select>
                        </div>
                     </div>
                     @endif --}}
                     
                     
                     
                     {{-- <div class="col text-right">
                        
                     </div> --}}
      
                     {{-- @if (auth()->user()->hasRole('Administrator|HRD-Payroll'))
                     <div class="col">
                        @if ($export == true)
                           <a href="{{route('payroll.overtime.export', [$from, $to, $loc] )}}" target="_blank" class="btn btn-block btn-dark"><i class="fa fa-file-excel"></i> Export</a>
                           @endif
                           <a href="{{route('payroll.overtime.index.delete')}}">Delete multiple data? click here</a>
                        <hr>
                     </div>
                     @endif --}}
                     
                  </div>
                  <button class="btn btn-primary btn-block" type="submit" >Filter</button> 
               </form> 
        
      </div>
      <div class="col-md-9">
         <div class="table-responsive">
            <table id="data" class="display basic-datatables table-sm">
               <thead>
                  <tr>
                     <th>NIK</th>
                     <th>Name</th>
                     {{-- <th>Location</th> --}}
                     <th>Unit</th>
                     <th class="text-center">Lembur</th>
                     <th class="text-center">Piket</th>
                     @if (auth()->user()->hasRole('HRD-Payroll|Administrator'))
                     <th class="text-right">Rate</th>
                     @endif
                  </tr>
               </thead>
               
               <tbody>
                  @foreach ($employees as $emp)
                      <tr>
                        <td class="text-truncate">{{$emp->nik}} </td>
                        <td class="text-truncate" style="max-width: 140px"> 
                           <a href="{{route('payroll.overtime.employee.detail', [enkripRambo($emp->id), $from, $to])}}">{{$emp->biodata->fullName()}}</a>
                        </td>
                        {{-- <td>{{$emp->location->name ?? '-'}}</td> --}}
                        <td class="text-truncate" style="max-width: 100px">{{$emp->unit->name}}</td>
                        {{-- <td>{{$emp->department->name}}</td> --}}
                        <td class="text-center">
                           @if ($emp->unit->hour_type == 1)
                           {{$emp->getOvertimes($from, $to)->where('type', 1)->sum('hours')}}
                              @elseif ($emp->unit->hour_type == 2)
                              {{$emp->getOvertimes($from, $to)->where('type', 1)->sum('hours_final')}}
                           @endif
                           {{-- {{$emp->getOvertimes($from, $to)->where('type', 1)->sum('hours_final')}} --}}
                        </td>
                        <td class="text-center">{{$emp->getOvertimes($from, $to)->where('type', 2)->sum('hours_final')}}</td>
                        @if (auth()->user()->hasRole('HRD-Payroll|Administrator'))
                        <td class="text-right">{{formatRupiahB($emp->getOvertimes($from, $to)->sum('rate'))}}</td>
                        @endif
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