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
            <table id="data" class="display datatables-11 table-sm p-0">
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
                    <th style="display: none">Last Update</th>
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
                        <td style="display: none" class="text-truncate">{{$his->updated_at}}</td>
                        {{-- <td class="text-truncate">
                           <a href="#" data-target="#modal-sertifikat-training-history-{{$his->id}}" data-toggle="modal">Sertifikat</a> |
                           <a href="{{route('training.history.edit', enkripRambo($his->id))}}">Edit</a> | 
                           <a href="#" data-target="#modal-delete-training-history-{{$his->id}}" data-toggle="modal">Delete</a>
                        </td> --}}
                      </tr>

                     
                     
                     
                  @endforeach
               </tbody>
      
            </table>
         </div>
      </div>
   </div>
   


</div>




@endsection