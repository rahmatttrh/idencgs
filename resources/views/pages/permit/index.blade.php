@extends('layouts.app')
   @section('title')
      Izin Resmi
   @endsection
@section('content')
   
   <div class="page-inner">
      <nav aria-label="breadcrumb ">
         <ol class="breadcrumb  ">
            <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item " aria-current="page">Master Data</li>
            <li class="breadcrumb-item active" aria-current="page">Izin Resmi</li>
         </ol>
      </nav>
      
      <div class="row">
         <div class="col-md-4">
            <div class="card shadow-none border">
               <div class="card-header d-flex"> 
                  <div class="d-flex  align-items-center">
                     <div class="card-title">Form Add Izin Resmi</div> 
                  </div>
                  
               </div> 
               <div class="card-body">
                  <form action="{{route('permit.store')}}" method="POST">
                     @csrf
                     <div class="form-group form-group-default">
                        <label>Nama Izin Resmi *</label>
                        <input id="name" name="name" type="text" class="form-control" placeholder="Fill Name">
                     </div>
                     <div class="form-group form-group-default">
                        <label>Deskripsi (Optional)</label>
                        <input id="desc" name="desc" type="text" class="form-control" >
                     </div>
                     <div class="form-group form-group-default">
                        <label>Jumlah Maksimal Hari</label>
                        <input id="qty" name="qty" type="number" class="form-control" >
                     </div>
                     <button type="submit" class="btn btn-block btn-primary">Add New Izin Resmi</button>

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
                  <small>Izin Resmi</small>
               </div>
               <div class="card-body p-0">
                  <table class="display  table-sm table-bordered   ">
                     <thead>
                        
                        <tr>
                           {{-- <th scope="col" class="text-center">ID</th> --}}
                           <th scope="col">Izin</th>
                           {{-- <th>Desc</th> --}}
                           <th>Jumlah Maksimal Hari</th>
                           <th scope="col" class="text-right">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if (count($permits) > 0)
                              @foreach ($permits as $pro)
                              <tr>
                                 {{-- <td class="text-center">{{$unit->id}}</td> --}}
                                 <td>
                                    @if (auth()->user()->hasRole('Administrator'))
                                        {{$pro->id}}
                                    @endif
                                    {{$pro->name}}
                                    @if ($pro->desc != null)
                                        ({{$pro->desc}})
                                    @endif
                                 </td>
                                 {{-- <td> </td> --}}
                                 <td>{{$pro->qty}} Hari</td>

                              <td class="text-right">
                                    <a href="" data-toggle="modal" data-target="#modal-edit-permit-{{$pro->id}}">Edit</a> |
                                    <a href="#" class="text-muted">Delete</a>
                                 </td>
                              </tr>
                              <div class="modal fade" id="modal-edit-permit-{{$pro->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                 <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Form Edit Project</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <form action="{{route('permit.update')}}" method="POST" >
                                          <div class="modal-body">
                                             @csrf
                                             @method('PUT')
                                                {{-- <input type="number" name="employee" id="employee" value="{{$employee->id}}" hidden> --}}
                                                <input type="number" name="permit" id="permit" value="{{$pro->id}}" hidden>
                                                <div class="form-group form-group-default">
                                                   <label>Nama Izin Resmi *</label>
                                                   <input type="text" class="form-control"  name="name" id="name" value="{{$pro->name}}"  >
                                                </div>
                                                <div class="form-group form-group-default">
                                                   <label>Deskripsi (Optional)</label>
                                                   <input type="text" class="form-control"  name="desc" id="desc" value="{{$pro->desc}}"  >
                                                </div>
                                                <div class="form-group form-group-default">
                                                   <label>Jumlah Maksimal Hari</label>
                                                   <input type="number" class="form-control"  name="qty" id="qty" value="{{$pro->qty}}"  >
                                                </div>
                                                
                                          </div>
                                          <div class="modal-footer">
                                             <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                                             <button type="submit" class="btn btn-dark ">Update</button>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                              
                              
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