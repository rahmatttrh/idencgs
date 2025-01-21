@extends('layouts.app')
@section('title')
SPKL
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item" aria-current="page">Payroll</li>
         <li class="breadcrumb-item" aria-current="page">SPKL</li>
         <li class="breadcrumb-item active" aria-current="page">Employee List</li>
      </ol>
   </nav>

   <div class="card shadow-none border col-md-12">
      <div class=" card-header">
         <x-overtime.overtime-tab :activeTab="request()->route()->getName()" />
      </div>

      <div class="card-body px-0">

         <div class="table-responsive">
            <table id="data" class="display basic-datatables table-sm">
               <thead>
                  <tr>
                     <th>NIK</th>
                     <th>Name</th>
                     <th>Location</th>
                     <th>Unit</th>
                     <th>Department</th>
                     
                  </tr>
               </thead>
               
               <tbody>
                  @foreach ($employees as $emp)
                      <tr>
                        <td>{{$emp->nik}}</td>
                        <td> 
                           <a href="{{route('payroll.overtime.employee.detail', enkripRambo($emp->id))}}">{{$emp->biodata->fullName()}}</a>
                           </td>
                        <td>{{$emp->location->name}}</td>
                        <td>{{$emp->unit->name}}</td>
                        <td>{{$emp->department->name}}</td>
                        
                      </tr>
                  @endforeach
               </tbody>
               
            </table>
         </div>


      </div>
      <div class="card-footer">
         <a href="{{route('overtime.refresh')}}">Refresh</a>
      </div>


   </div>
   <!-- End Row -->


</div>




@endsection