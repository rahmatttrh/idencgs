@extends('layouts.app')
@section('title')
Form Absensi
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         
         <li class="breadcrumb-item active" aria-current="page">Form Absensi</li>
      </ol>
   </nav>


   <div class="card">
      <div class="card-body px-0">
         <ul class="nav nav-tabs px-3">
            <li class="nav-item">
              <a class="nav-link active" href="{{ route('leader.absence') }}">Approval Absensi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="{{ route('leader.absence.history') }}">Riwayat</a>
            </li>



            
           
         </ul>


         <form action="{{route('absence.approve.multiple')}}" method="post" >
            @csrf
            @method('POST')

            @if (auth()->user()->hasRole('Manager|Asst. Manager'))
                
            
            <button  class="btn btn-primary m-3" data-toggle="tooltip" data-placement="top" title="Click to approve multiple Form Absence"  type="submit"><i class="fas fa-check"></i> Approve Multiple Form Absensi</button>
            @endif



            <div class="table-responsive  px-0">
               <table id="data" class="datatables-4">
                  <thead>
                     <tr>
                        @if (auth()->user()->hasRole('Manager|Asst. Manager'))
                        <th><input type="checkbox" name="" id="checkboxAll"></th>
                        @endif
                        <th>ID</th>
                        <th>Type</th>
                        <th>NIK</th>
                        <th>Name</th>
                        {{-- <th>Loc</th> --}}
                        
                        {{-- <th>Day</th> --}}
                        <th>Date</th>
                        {{-- <th>Desc</th> --}}
                        <th>Status</th>
                        {{-- <th></th> --}}
                     </tr>
                  </thead>

                  <tbody>

                     

                     @foreach ($reqForms as $absence)
                           
                     <tr>
                        <td>
                           <input  type="checkbox" name="checkAbsence[]" value="{{$absence->id}}" id="checkSpkl-{{$absence->id}}"> 
                        </td>
                        <td>
                           <a href="{{route('employee.absence.detail', [enkripRambo($absence->id), enkripRambo('approval')])}}">
                              {{$absence->code}}
                           </a>
                           
                        </td>
                        <td class="text-truncate">
                           <a href="{{route('employee.absence.detail', [enkripRambo($absence->id), enkripRambo('approval')])}}">
                              <x-status.absence :absence="$absence" />
                        </a>
                           
                        </td>
                        <td class="text-truncate"><a href="{{route('employee.absence.detail', [enkripRambo($absence->id), enkripRambo('approval')])}}"> {{$absence->employee->nik}}</a></td>
                        <td class="text-truncate"> {{$absence->employee->biodata->fullName()}}</td>
                        {{-- <td>{{$absence->employee->location->name}}</td> --}}
                        
                        {{-- <td>{{formatDayName($absence->date)}}</td> --}}
                        <td class="text-truncate">
                           <x-absence.date :absence="$absence" />
                        </td>
                        {{-- <td>{{$absence->desc}}</td> --}}
                        <td class="text-truncate">
                           <x-status.form :form="$absence" />
                           
                        </td>
                        {{-- <td>
                           {{$absence->release_date}}
                        </td> --}}
                     
                     </tr>
                           
                        @endforeach


                     
                     

                     
                  </tbody>

               </table>
            </div>

         </form>
      </div>
   </div>


   

   


</div>



@push('js_footer')
<script>
    $(document).ready(function() {
        // $('#button-group').hide();

        // Ketika checkboxAll dicentang, ceklis semua checkbox dengan name=check
        $("#checkboxAll").change(function() {
            $("input[name='checkAbsence[]']").prop('checked', $(this).prop('checked'));
            console.log('ok')
        });

        // Ketika salah satu checkbox dengan name=check dicentang atau dicentang ulang
        $("input[name='checkAbsence[]']").change(function() {
            // Periksa apakah semua checkbox dengan name=check tercentang
            var allChecked = ($("input[name='checkAbsence[]']:checked").length === $("input[name='checkAbsence[]']").length);

            // Terapkan status checked pada checkboxAll sesuai hasil pengecekan di atas
            $("#checkboxAll").prop('checked', allChecked);
        });

        // Saat tombol Terapkan atau Delete ditekan
        
    })
</script>
@endpush




@endsection