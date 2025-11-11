@extends('layouts.app')
@section('title')
Summary Absence
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
         <li class="breadcrumb-item active" aria-current="page">Summary Absence<ee/li>
      </ol>
   </nav>

   <div class="row">
      <div class="col-md-3">
         
         <div class="nav flex-column justify-content-start nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link  text-left pl-3" id="v-pills-basic-tab" href="{{route('payroll.absence')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-address-book mr-1"></i>
               Summary Absence
            </a>
            <a class="nav-link active text-left pl-3" id="v-pills-basic-tab" href="{{route('payroll.absence.recent')}}" aria-controls="v-pills-basic" aria-selected="true">
               <i class="fas fa-clock mr-1"></i>
               Recent 
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
          
         
      </div>
      <div class="col-md-9">
         
          
          
         <div class="table-responsive p-0">
            <table id="data" class="display basic-datatables table-sm p-0">
               <thead>
                  <tr>
                     <th>NIK</th>
                      <th>Name</th>
                      <th>Loc</th>
                     <th>Type</th>
                     <th>Date</th>
                     <th></th>
                  </tr>
               </thead>

               <tbody>
                  @foreach ($absences as $absence)
                  <tr>
                     <td class="text-truncate">{{$absence->employee->nik}}

                        @if (auth()->user()->hasRole('Administrator'))
                            ID:{{$absence->id}}
                        @endif
                     </td>
                      <td class="text-truncate" style="max-width: 170px" data-toggle="tooltip" data-placement="top" title="{{$absence->employee->biodata->fullName()}}"> {{$absence->employee->biodata->fullName()}}</td>
                      <td class="text-truncate" >{{$absence->employee->location->name}}</td>
                     <td class="text-truncate">
                        <x-status.absence :absence="$absence" />
                        
                     </td>
                     <td>{{formatDate($absence->date)}}</td>
                     
                     <td class="text-truncate">
                      <a href="{{route('payroll.absence.edit', enkripRambo($absence->id))}}" class="">Update</a> |
                        <a href="#" data-target="#modal-delete-absence-{{$absence->id}}" data-toggle="modal">Delete</a>
                     </td>
                  </tr>

                  <div class="modal fade" id="modal-delete-absence-{{$absence->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content text-dark">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           <div class="modal-body ">
                              Delete data
                              @if ($absence->type == 1)
                              Alpha
                              @elseif($absence->type == 2)
                              Terlambat ({{$absence->minute}})
                              @elseif($absence->type == 3)
                              ATL
                              @endif
                              {{$absence->employee->nik}} {{$absence->employee->biodata->fullName()}}
                              tanggal {{formatDate($absence->date)}}
                              ?
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-danger ">
                                 <a class="text-light" href="{{route('payroll.absence.delete', enkripRambo($absence->id))}}">Delete</a>
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
                  @endforeach
               </tbody>

            </table>
         </div>
      </div>
   </div>
   
   <!-- End Row -->


</div>




@endsection