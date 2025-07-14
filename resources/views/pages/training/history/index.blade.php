@extends('layouts.app')
@section('title')
History Training
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">History Training</li>
      </ol>
   </nav>


   <div class="card">
      <div class="card-body">
         <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
            <li class="nav-item">
               <a class="nav-link active" id="pills-home-tab"  href="{{route('training.history')}}">Training History</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" id="pills-profile-tab" href="{{route('training.history.create')}}">Input Training History</a>
            </li>
           
           
         </ul>
         <div class="table-responsive p-0 mt-2">
            <table id="data" class="display basic-datatables table-sm p-0">
               <thead>
                  <tr>
                    {{-- <th>No</th> --}}
                    <th>Perusahaan</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Dept</th>
                    <th>Jabatan</th>
                    <th>Lokasi</th>
                    <th>Pelatihan</th>
                    <th>Periode</th>
                    <th>Sertifikat</th>
                    <th>Vendor</th>
                    <th>Berlaku</th>
                    {{-- <th></th> --}}
                  </tr>
               </thead>
      
               <tbody>
                  @foreach ($trainingHistories as $his)
                      <tr>
                        <td class="text-truncate">{{$his->employee->unit->name}}</td>
                        <td class="text-truncate"><a href="{{route('training.history.edit', enkripRambo($his->id))}}">{{$his->employee->nik}}</a></td>
                        <td class="text-truncate" style="max-width: 160px"><a href="{{route('training.history.edit', enkripRambo($his->id))}}">{{$his->employee->biodata->fullName()}}</a></td>
                        <td class="text-truncate">{{$his->employee->department->name}}</td>
                        <td class="text-truncate">{{$his->employee->position->name}}</td>
                        <td class="text-truncate">{{$his->employee->location->name}}</td>
                        <td class="text-truncate">{{$his->training->title ?? 'Empty'}}</td>
                        <td class="text-truncate">{{$his->periode}}</td>
                        <td class="text-truncate">{{$his->type_sertificate}}</td>
                        <td class="text-truncate">{{$his->vendor}}</td>
                        <td>
                           @if ($his->expired != null)
                           {{formatDate($his->expired)}}
                           @else
                           -
                           @endif
                           
                        </td>
                        {{-- <td class="text-truncate">
                           <a href="#" data-target="#modal-sertifikat-training-history-{{$his->id}}" data-toggle="modal">Sertifikat</a> |
                           <a href="{{route('training.history.edit', enkripRambo($his->id))}}">Edit</a> | 
                           <a href="#" data-target="#modal-delete-training-history-{{$his->id}}" data-toggle="modal">Delete</a>
                        </td> --}}
                      </tr>

                     {{-- <div class="modal fade" id="modal-delete-training-history-{{$his->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                           <div class="modal-content text-dark">
                              <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLabel">Delete Training History?</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body ">
                                
                                {{$his->employee->nik}} {{$his->employee->biodata->fullName()}} : 
                              
                                {{$his->training->title ?? 'Empty'}}
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                                 <button type="button" class="btn btn-danger ">
                                    <a class="text-light" href="{{route('training.history.delete', enkripRambo($his->id))}}">Delete</a>
                                 </button>
                              </div>
                           </div>
                        </div>
                     </div> --}}

                     {{-- <div class="modal fade" id="modal-sertifikat-training-history-{{$his->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLabel">Sertifikat Pelatihan</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body">
                                    
                     
                                       <iframe height="550px" width="100%" src="{{asset('storage/' . $his->doc)}}" frameborder="0"></iframe>
                                       
                                       
                     
                                       
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                                </div>
                             
                           </div>
                        </div>
                     </div> --}}
                     
                     
                  @endforeach
               </tbody>
      
            </table>
         </div>
      </div>
   </div>
   


</div>




@endsection