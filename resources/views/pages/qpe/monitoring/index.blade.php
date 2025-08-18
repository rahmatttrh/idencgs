@extends('layouts.app')
@section('title')
QPE Report
@endsection
@section('content')

<div class="page-inner">
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb  ">
            <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="{{route('qpe.report')}}">QPE Monitoring</a></li>
            {{-- <li class="breadcrumb-item active" aria-current="page">{{$unit->name}}</li> --}}
        </ol>
    </nav>
    <div class="row">
      <div class="col-md-2">
         {{-- <h4>Filter Report</h4>
         <hr> --}}
         <form action="{{route('qpe.report.filter.manager')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
               <div class="col-12">
                  <div class="form-group form-group-default">
                     <label>Semester</label>
                     <select class="form-control " required name="semester" id="semester">
                        <option value="" disabled selected>Select</option>
                        <option {{$semester == 1 ? 'selected' : ''}} value="1">I</option>
                        <option {{$semester == 2 ? 'selected' : ''}} value="2">II</option>
                     </select>
                  </div>
               </div>
               <div class="col">
                  <div class="form-group form-group-default">
                     <label>Tahun</label>
                     <select class="form-control " required name="year" id="year">
                        <option value="" disabled selected>Select</option>
                        <option {{$year == 2024 ? 'selected' : ''}} value="2024">2024</option>
                        <option {{$year == 2025 ? 'selected' : ''}} value="2025">2025</option>
                        {{-- <option {{$year == 2026 ? 'selected' : ''}} value="2026">2025</option> --}}
                     </select>
                  </div>  
               </div>
            </div>
            

                
            
            <button class="btn btn-block btn-primary" type="submit">Filter</button>
         </form>
      </div>

        <div class="col-md-10">
            <div class="card shadow-none border">
               {{-- <div class="card-header">
                  <h2>{{$unit->name}}</h2>
               </div> --}}
                <div class="card-body p-0">
                  <div class="table-responsive">
                     <table>
                        <thead>
                          
                           <tr>
                              <th colspan="7" class="text-uppercase">Semester 
                                 @if ($semester == 1)
                                     I
                                     @else
                                     II
                                 @endif
                                 {{$year}}</th>
                           </tr>
                           <tr>
                              <th rowspan="2">Unit</th>
                              <th rowspan="2">Department</th>
                              <th rowspan="2" class="text-center">Total Karyawan</th>
                              <th colspan="4" class="text-center">QPE</th>
                              
                           </tr>
                           <tr>
                              
                              <th class="text-center">Draft</th>
                              <th class="text-center">Verifikasi</th>
                              <th class="text-center">Done</th>
                              <th class="text-center">Empty</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($departments as $depart)
                               <tr>
                                 <td><a href="{{route('qpe.report.department', [enkripRambo($depart->id),enkripRambo($semester),enkripRambo($year)])}}">{{$depart->unit->name}} </a></td>
                                 <td><a href="{{route('qpe.report.department', [enkripRambo($depart->id),enkripRambo($semester),enkripRambo($year)])}}">{{$depart->name}}</a></td>
                                 <td class="text-center">{{count($depart->getEmployeeQpe($semester, $year, 0))}}</td>
                                 <td class="text-center">{{$depart->getQpe($semester, $year, 0)}}</td>
                                 <td class="text-center">{{$depart->getQpe($semester, $year, 1)}}</td>
                                 <td class="text-center">{{$depart->getQpe($semester, $year, 2)}}</td>
                                 <td class="text-center"> {{$depart->getEmptyQpe($semester, $year)}}</td>
                               </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
