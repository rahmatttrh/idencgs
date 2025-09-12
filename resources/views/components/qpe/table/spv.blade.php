<div class="table-responsive">
   <table id="" class="display datatables-8 table-sm table-striped ">
       <thead>
           <tr>
               {{-- <th class="text-white text-center">No </th> --}}
               @if (auth()->user()->hasRole('Administrator'))
               <th>ID</th>
               @endif
               <th class="text-white">Employee</th>
               <th class="text-white">Semester</th>
               <th class="text-white text-center">Discipline</th>
               <th class="text-white text-center">KPI</th>
               <th class="text-white text-center">Behavior</th>
               <th class="text-white">Achievement</th>
               <th class="text-white">Status</th>
               <th class="text-right text-white">Action</th>
               <th class="" >Updated</th>
           </tr>
       </thead>
       <tbody>
        @if (auth()->user()->hasRole('HRD|HRD-Recruitment|HRD-Payroll'))
            @foreach ($allpes as $pe)
            <tr>
                {{-- <td class="text-center">{{++$i}} </td> --}}
                <td class="text-truncate">
                   @if($pe->status == '0' || $pe->status == '101')
                   <a href="/qpe/edit/{{enkripRambo($pe->kpa->id)}}">{{$pe->employe->nik}} {{$pe->employe->biodata->fullName()}} </a>
                   @elseif($pe->status == '1' || $pe->status == '202' )
                   <a href="/qpe/approval/{{enkripRambo($pe->kpa->id)}}">{{$pe->employe->nik}} {{$pe->employe->biodata->fullName()}} </a>
                   @else
                   <a href="/qpe/show/{{enkripRambo($pe->kpa->id)}}">{{$pe->employe->nik}} {{$pe->employe->biodata->fullName()}} </a>
                   @endif
                </td>
                <td>{{$pe->semester}} / {{$pe->tahun}} </td>
                <td class="text-center">
                    <span class="">{{$pe->discipline}}</span>
                 </td>
                 <td class="text-center">
                    <span class="">{{$pe->kpi}}</span>
                 </td>
                 <td class="text-center">
                    <span class="">{{$pe->behavior}}</span>
                 </td>
                <td><span class="badge badge-primary badge-lg"><b>{{$pe->achievement}}</b></span></td>
                @if($pe->status == 0)
                <td><span class="badge badge-dark badge-lg"><b>Draft</b></span></td>
                @elseif($pe->status == '1')
                <td>
                   @if (auth()->user()->hasRole('Manager'))
                   <span class="badge badge-warning badge-lg"><b>Perlu Diverifikasi</b></span>
                   @else
                   <span class="badge badge-warning badge-lg"><b>Verifikasi Manager</b></span>
                   @endif
                </td>
                @elseif($pe->status == '2')
                <td><span class="badge badge-success badge-lg"><b>Done</b></span></td>
                @elseif($pe->status == '3')
                <td><span class="badge badge-primary badge-lg"><b>Validasi HRD</b></span></td>
                @elseif($pe->status == '101')
                <td><span class="badge badge-danger badge-lg"><b>Di Reject Manager</b></span></td>
                @elseif($pe->status == '202')
                <td><span class="badge badge-warning badge-lg"><b>Need Discuss</b></span></td>
                @endif
                <td class="text-right">
                   @if($pe->status == 0)
                   <!-- <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete-{{$pe->id}}"><i class="fas fa-trash"></i> Delete</button> -->
                   @elseif(($pe->status == '1' || $pe->status == '2' || $pe->status == '101' || $pe->status == '202') && $pe->behavior > 0)
                   <a href="{{ route('export.qpe', $pe->id) }}" target="_blank">PDF</a>
                   @elseif(($pe->status == 0 || $pe->status == 101 || $pe->status == 202) && auth()->user()->hasRole('Leader'))
                   <!-- <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-submit-{{$pe->id}}"><i class="fas fa-rocket"></i> Submit</button> -->
                   @endif
                </td>
                <td >{{$pe->updated_at}}</td>
            </tr>
            @endforeach    

            @else

           @foreach ($allpes as $pe)
           @if ($pe->employe_id == $employee->id)
           <tr>
              {{-- <td class="text-center">{{++$i}} </td> --}}
              <td>
                 @if($pe->status == '0' || $pe->status == '101')
                 <a href="/qpe/edit/{{enkripRambo($pe->kpa->id)}}">{{$pe->employe->nik}} {{$pe->employe->biodata->fullName()}} </a>
                 @elseif($pe->status == '1' || $pe->status == '202' )
                 <a href="/qpe/approval/{{enkripRambo($pe->kpa->id)}}">{{$pe->employe->nik}} {{$pe->employe->biodata->fullName()}} </a>
                 @else
                 <a href="/qpe/show/{{enkripRambo($pe->kpa->id)}}">{{$pe->employe->nik}} {{$pe->employe->biodata->fullName()}} </a>
                 @endif
              </td>
              <td>{{$pe->semester}} / {{$pe->tahun}} </td>
              <td class="text-center">
              <span class="">{{$pe->discipline}}</span>
              </td>
              <td class="text-center">
                 <span class="">{{$pe->kpi}}</span>
              </td>
              <td class="text-center">
                 <span class="">{{$pe->behavior}}</span>
              </td>
              <td><span class="badge badge-primary badge-lg"><b>{{$pe->achievement}}</b></span></td>
              @if($pe->status == 0)
              <td><span class="badge badge-dark badge-lg"><b>Draft</b></span></td>
              @elseif($pe->status == '1')
              <td>
                 @if (auth()->user()->hasRole('Manager'))
                 <span class="badge badge-warning badge-lg"><b>Perlu Diverifikasi</b></span>
                 @else
                 <span class="badge badge-warning badge-lg"><b>Verifikasi Manager</b></span>
                 @endif
              </td>
              @elseif($pe->status == '2')
              <td><span class="badge badge-success badge-lg"><b>Done</b></span></td>
              @elseif($pe->status == '3')
              <td><span class="badge badge-primary badge-lg"><b>Validasi HRD</b></span></td>
              @elseif($pe->status == '101')
              <td><span class="badge badge-danger badge-lg"><b>Di Reject Manager</b></span></td>
              @elseif($pe->status == '202')
              <td><span class="badge badge-warning badge-lg"><b>Need Discuss</b></span></td>
              @endif
              <td class="text-right">
                 @if($pe->status == 0)
                 <!-- <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete-{{$pe->id}}"><i class="fas fa-trash"></i> Delete</button> -->
                 @elseif(($pe->status == '1' || $pe->status == '2' || $pe->status == '101' || $pe->status == '202') && $pe->behavior > 0)
                 <a href="{{ route('export.qpe', $pe->id) }}" target="_blank"> PDF</a>
                 @elseif(($pe->status == 0 || $pe->status == 101 || $pe->status == 202) && auth()->user()->hasRole('Leader'))
                 <!-- <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-submit-{{$pe->id}}"><i class="fas fa-rocket"></i> Submit</button> -->
                 @endif
              </td>
              <td>{{$pe->updated_at}}</td>
           </tr>
           @endif
           @endforeach

            @foreach ($myteams as $team)
               @foreach ($allpes as $pe)
                 
                   @if ($pe->employe_id == $team->id)
                   <tr>
                       {{-- <td class="text-center">{{++$i}} </td> --}}
                       <td>
                          @if($pe->status == '0' || $pe->status == '101')
                          <a href="/qpe/edit/{{enkripRambo($pe->kpa->id)}}">{{$pe->employe->nik}} {{$pe->employe->biodata->fullName()}} </a>
                          @elseif($pe->status == '1' || $pe->status == '202' )
                          <a href="/qpe/approval/{{enkripRambo($pe->kpa->id)}}">{{$pe->employe->nik}} {{$pe->employe->biodata->fullName()}} </a>
                          @else
                          <a href="/qpe/show/{{enkripRambo($pe->kpa->id)}}">{{$pe->employe->nik}} {{$pe->employe->biodata->fullName()}} </a>
                          @endif
                       </td>
                       <td>{{$pe->semester}} / {{$pe->tahun}} </td>
                       <td class="text-center">
                        <span class="">{{$pe->discipline}}</span>
                     </td>
                     <td class="text-center">
                        <span class="">{{$pe->kpi}}</span>
                     </td>
                     <td class="text-center">
                        <span class="">{{$pe->behavior}}</span>
                     </td>
                       <td><span class="badge badge-primary badge-lg"><b>{{$pe->achievement}}</b></span></td>
                       @if($pe->status == 0)
                       <td><span class="badge badge-dark badge-lg"><b>Draft</b></span></td>
                       @elseif($pe->status == '1')
                       <td>
                          @if (auth()->user()->hasRole('Manager'))
                          <span class="badge badge-warning badge-lg"><b>Perlu Diverifikasi</b></span>
                          @else
                          <span class="badge badge-warning badge-lg"><b>Verifikasi Manager</b></span>
                          @endif
                       </td>
                       @elseif($pe->status == '2')
                       <td><span class="badge badge-success badge-lg"><b>Done</b></span></td>
                       @elseif($pe->status == '3')
                       <td><span class="badge badge-primary badge-lg"><b>Validasi HRD</b></span></td>
                       @elseif($pe->status == '101')
                       <td><span class="badge badge-danger badge-lg"><b>Di Reject Manager</b></span></td>
                       @elseif($pe->status == '202')
                       <td><span class="badge badge-warning badge-lg"><b>Need Discuss</b></span></td>
                       @endif
                       <td class="text-right">
                          @if($pe->status == 0)
                          <a href="#" data-toggle="modal" data-target="#modalDeleteQpe-{{$pe->id}}">Delete</a>
                           {{-- <button class="" data-toggle="modal" data-target="#modal-delete-{{$pe->id}}"><i class="fas fa-trash"></i> Delete</button> --}}
                          @elseif(($pe->status == '1' || $pe->status == '2' || $pe->status == '101' || $pe->status == '202') && $pe->behavior > 0)
                          <a href="{{ route('export.qpe', $pe->id) }}" target="_blank"> PDF</a>
                          @elseif(($pe->status == 0 || $pe->status == 101 || $pe->status == 202) && auth()->user()->hasRole('Leader'))
                          <!-- <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-submit-{{$pe->id}}"><i class="fas fa-rocket"></i> Submit</button> -->
                          @endif
                       </td>
                       <td>{{$pe->updated_at}}</td>
                   </tr>
                   <div class="modal fade" id="modalDeleteQpe-{{$pe->id}}" data-bs-backdrop="static">
                     <div class="modal-dialog modal-sm">
                         <div class="modal-content">
                  
                             <!-- Bagian header modal -->
                             <div class="modal-header">
                                 <h3 class="modal-title">Delete Confirmation</h3>
                                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                             </div>
                             <form method="POST" action="{{route('qpe.delete') }}" enctype="multipart/form-data">
                                 @csrf
                  
                                 <input type="hidden" name="pe" id="pe" value="{{$pe->id}}">
                  
                                 <!-- Bagian konten modal -->
                                 <div class="modal-body">
                  
                                     Delete QPE <br>
                                      {{$pe->employe->biodata->fullName()}} Semester {{$pe->semester}} / {{$pe->tahun}}
                                 </div>
                  
                                 <!-- Bagian footer modal -->
                                 <div class="modal-footer">
                                     {{-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> --}}
                                     <button type="submit" class="btn btn-danger">Delete</button>
                                 </div>
                             </form>
                  
                         </div>
                     </div>
                  </div>
                   {{-- <x-modal.delete :id="$pe->id" :body="'KPI ' . $pe->employe->nik . ' ' . $pe->employe->biodata->fullName() . ' bulan '. date('F Y', strtotime($pe->date))   " url="qpe/delete/{{enkripRambo($pe->id)}}" /> --}}
                   @endif

                @endforeach
            @endforeach
        @endif
            
       </tbody>
   </table>
</div>