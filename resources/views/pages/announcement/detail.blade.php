@extends('layouts.app')
   @section('title')
      Announcement Detail
   @endsection
@section('content')
   
   <div class="page-inner">
      <nav aria-label="breadcrumb ">
         <ol class="breadcrumb  ">
            <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item " aria-current="page">Announcement</li>
            <li class="breadcrumb-item active" aria-current="page">Detail</li>
         </ol>
      </nav>
      
      @if (auth()->user()->hasRole('Administrator|HRD|HRD-Recruitment'))
          @if ($announcement->status == 0)
            <a href="#" data-target="#activate-announcement" data-toggle="modal" class="btn btn-light border">Status : Deactivate</a>
            @elseif($announcement->status == 1)
            <a href="#" data-target="#deactivate-announcement" data-toggle="modal" class="btn btn-success">Status : Active</a>
          @endif
          <a href="#" data-target="#modal-delete" data-toggle="modal" class="btn btn-danger">Delete</a>
          <hr>

          
      @endif
      
      
      <div class="card shadow-none border">
         <div class="card-header">
            <h3>{{$announcement->title}}</h3>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-md-4">
                  <table>
                     <tbody>
                        <tr>
                           <td>From</td>
                           <td>HRD</td>
                        </tr>
                        <tr>
                           <td>To</td>
                           <td>
                              @if ($announcement->type == 1)
                                 Semua Karyawan
                                 @elseif($announcement->type == 2)
                                 {{$announcement->employee->nik}} {{$announcement->employee->biodata->fullName()}}
                                 @elseif($announcement->type == 3)
                                 Semua Karyawan {{$announcement->unit->name}}
                              @endif
                           </td>
                        </tr>
                        <tr>
                           <td>Created</td>
                           <td>{{formatDateTime($announcement->created_at)}}</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
            
            
            {{-- From : HRD <br>
            To : @if ($announcement->type == 1)
                All Karyawan
                @elseif($announcement->type == 2)
                {{$announcement->employee->nik}} {{$announcement->employee->biodata->fullName()}}
                @elseif($announcement->type == 3)
                Semua Karyawan {{$announcement->unit->name}}
            @endif <br>
            Created at {{formatDate($announcement->created_at)}} --}}
            <hr>
            {!! $announcement->body !!}
            
         </div>
         {{-- <div class="card-footer">
            Created at {{formatDate($announcement->created_at)}}
         </div> --}}
      </div>
      <hr>
      @if ($announcement->doc)
         <iframe style="width: 100%; height:600px" src="{{asset('storage/' .$announcement->doc)}}" frameborder="0"></iframe>
         @else
         <div class="card shadow-none border">
            <div class="card-body">
               <span>Tidak ada lampiran</span>
            </div>
         </div>
         
      @endif
            
   </div>

 <div class="modal fade" id="deactivate-announcement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
       <div class="modal-content text-dark">
          <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">Deactivate Announcement</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <div class="modal-body ">
             Deactivate {{$announcement->title}} ?
             <hr>
             <small class="text-muted">Announcement akan di hilangkan dari Dashboard Employee</small>
          </div>
          <div class="modal-footer">
             <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
             <button type="button" class="btn btn-danger ">
                <a class="text-light" href="{{route('announcement.deactivate', enkripRambo($announcement->id))}}">Deactivate</a>
             </button>
          </div>
       </div>
    </div>
 </div>

 <div class="modal fade" id="activate-announcement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
       <div class="modal-content text-dark">
          <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">Activate Announcement</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <div class="modal-body ">
             Activate {{$announcement->title}} ?
             <hr>
             <small class="text-muted">Announcement akan di munculkan di Dashboard Employee</small>
          </div>
          <div class="modal-footer">
             <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
             <button type="button" class="btn btn-primary ">
                <a class="text-light" href="{{route('announcement.activate', enkripRambo($announcement->id))}}">Activate</a>
             </button>
          </div>
       </div>
    </div>
 </div>


 <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
       <div class="modal-content text-dark">
          <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <div class="modal-body ">
             Delete {{$announcement->title}} ?
          </div>
          <div class="modal-footer">
             <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
             <button type="button" class="btn btn-danger ">
                <a class="text-light" href="{{route('announcement.delete', enkripRambo($announcement->id))}}">Delete</a>
             </button>
          </div>
       </div>
    </div>
 </div>


   <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
         <div class="modal-content text-dark">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body ">
               Delete {{$announcement->title}} ?
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-danger ">
                  <a class="text-light" href="{{route('announcement.delete', enkripRambo($announcement->id))}}">Delete</a>
               </button>
            </div>
         </div>
      </div>
   </div>

@endsection