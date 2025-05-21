@extends('layouts.app')
   @section('title')
      Project
   @endsection
@section('content')
   
   <div class="page-inner">
      <nav aria-label="breadcrumb ">
         <ol class="breadcrumb  ">
            <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item " aria-current="page">Master Data</li>
            <li class="breadcrumb-item active" aria-current="page">Project</li>
         </ol>
      </nav>
      
      <div class="row">
         <div class="col-md-4">
            <div class="card shadow-none border">
               <div class="card-header d-flex"> 
                  <div class="d-flex  align-items-center">
                     <div class="card-title">Form Add Project</div> 
                  </div>
                  {{-- <div class="btn-group btn-group-page-header ml-auto">
                     <button type="button" class="btn btn-light btn-round btn-page-header-dropdown dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <i class="fa fa-ellipsis-h"></i>
                     </button>
                     <div class="dropdown-menu">
                        
                        
                        <a  class="dropdown-item" style="text-decoration: none" href="{{route('employee.create')}}">Create</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" style="text-decoration: none" href="" target="_blank">Print Preview</a>
                     </div>
                  </div> --}}
               </div> 
               <div class="card-body">
                  <form action="{{route('project.store')}}" method="POST">
                     @csrf
                     <div class="form-group form-group-default">
                        <label>Project Name *</label>
                        <input id="name" name="name" type="text" class="form-control" placeholder="Fill Name">
                     </div>
                     <div class="form-group form-group-default">
                        <label>Code</label>
                        <input id="code" name="code" type="text" class="form-control" >
                     </div>
                     <button type="submit" class="btn btn-block btn-primary">Add New Project</button>

                  </form>
               </div>
               <div class="card-footer">
                  {{-- <small>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni at neque inventore vel.</small> --}}
               </div>
            </div>
         </div>
         <div class="col-md-8">
            <div class="card">
               <div class="card-header p-2 bg-primary text-white">
                  <small>Project</small>
               </div>
               <div class="card-body p-0">
                  <table class="display  table-sm table-bordered   ">
                     <thead>
                        
                        <tr>
                           {{-- <th scope="col" class="text-center">ID</th> --}}
                           <th scope="col">Project Name</th>
                           <th>Code</th>
                           
                           <th scope="col" class="text-right">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if (count($projects) > 0)
                              @foreach ($projects as $pro)
                              <tr>
                                 {{-- <td class="text-center">{{$unit->id}}</td> --}}
                                 <td>
                                    {{$pro->name}}
                                 </td>
                                 <td>{{$pro->code}} Department</td>

                              <td class="text-right">
                                    <a href="" data-toggle="modal" data-target="#modal-edit-unit-{{$pro->id}}">Edit</a> |
                                    {{-- <a href="#" data-toggle="modal" data-target="#modal-delete-{{$unit->id}}">Delete</a> --}}
                                 </td>
                              </tr>
                              {{-- <x-modal.edit-unit :id="$unit->id" :unit="$unit"  />
                              <x-modal.delete :id="$unit->id" :body="$unit->name" url="{{route('unit.delete', enkripRambo($unit->id))}}" /> --}}
                           @endforeach
                           @else
                           <tr>
                              <td colspan="5" class="text-center">Empty</td>
                           </tr>
                        @endif
                        
                        
                     </tbody>
                  </table>
               </div>
            </div>
           
         </div>
      </div>
   </div>

@endsection