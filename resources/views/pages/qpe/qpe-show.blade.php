@extends('layouts.app')
@section('title')
PE
@endsection
@section('content')

<div class="page-inner">
    <!-- Breadcrumb navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('qpe') }}">PE</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail {{$pe->id}}</li>
        </ol>
    </nav>

    <div class="row mr-6">

    </div>

    <!-- Section for creating and detailing performance appraisal -->
    <div class="row" id="boxCreate">
        <div class="col-md-3">
            <!-- Performance appraisal component -->
            <!-- 
                File view ada di : 
                resources/views/components/qpe/file.blade.php
                File Controller nya ada di : 
                app/View/Components/File.php
            -->
            <x-qpe.performance-appraisal :kpa="$kpa" />
            <div class="card card-primary">
                <div class="card-body text-center">
                 <h4><i class="fa fa-star"></i>  {{$pe->achievement}}</h4>
                </div>
            </div>
            {{-- <x-discipline :pd="$pd" /> --}}
            <span>Created by :</span> <br>
                  <span>{{$pe->getCreatedBy()->nik}} {{$pe->getCreatedBy()->biodata->fullName()}}</span> <br>
                  {{formatDateTime($pe->created_at)}}
            <hr>
            @if (auth()->user()->hasRole('Administrator|HRD|HRD-Payroll|HRD-Recruitment'))
                <div class="text-right mb-1">
                
                <div class="btn-group">
                    <a href="#" data-target="#modalDeleteQpe" data-toggle="modal" class=" btn btn-danger btn-sm" >Delete</a>
                </div>
                </div>
                <div class="modal fade" id="modalDeleteQpe" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-sm" role="document">
                     <form action="{{route('qpe.delete')}}" method="POST">
                        @csrf
                        <input type="number" name="pe" id="pe" value="{{$pe->id}}" hidden >
                        <div class="modal-content text-dark">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           <div class="modal-body ">
                              Delete QPE {{$pe->employe->biodata->fullName()}} {{$pe->semester}} / {{$pe->tahun}} ?
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-danger ">
                                 Delete
                              </button>
                           </div>
                        </div>
                     </form>
                  </div>
                </div>
            @endif
        </div>
        <div class="col-md-9">
            @if (auth()->user()->hasRole('Karyawan'))
            <!-- Awal Action Karyawan -->

            <!-- Hanya karyawan tersebut yang bisa komplen -->
            <div class="text-right">
                @if(auth()->user()->employee->id == $pe->employe_id && ($kpa->pe->status == '2'|| $kpa->pe->status == '101' || $kpa->pe->status == '202') && $pe->complained == '0' )

                <div class="btn-group ml-auto mb-2">
                    <button data-target="#modalKomplain" data-toggle="modal" class="btn btn-md btn-warning "><i class="fa fa-comments"></i> Komentar</button>
                </div>

                <!-- Modal Komplain  -->
                <div class="modal fade" id="modalKomplain" data-bs-backdrop="static">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <!-- Bagian header modal -->
                            <div class="modal-header">
                                <h3 class="modal-title"> </h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <form method="POST" action="{{route('qpe.complain.patch', $pe->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="id" value="{{$pe->id}}">

                                <!-- Bagian konten modal -->
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card shadow-none border">
                                                <div class="card-header d-flex">
                                                    <div class="d-flex  align-items-center">
                                                        <div class="card-title">Konfirmasi </div>
                                                    </div>

                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="" class="label-control">Komentar <span class="text-danger">*</span></label>
                                                                <textarea name="complain_alasan" class="form-control" id="" rows="5" placeholder="isi komentar" required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian footer modal -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> Submit</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <!-- End Modal Komplain  -->
                @endif

                <!-- Tombol Komplain karyawan  -->
                @if(auth()->user()->employee->id == $pe->employe_id && $pe->complained == '1' )
                <div class="btn-group ml-auto">
                    <button data-target="#closeKomplain" data-toggle="modal" class="btn btn-xs btn-success "><i class="fa fa-flag"></i> Close Komplain</button>
                </div>

                <div class="modal fade" id="closeKomplain" data-bs-backdrop="static">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <!-- Bagian header modal -->
                            <div class="modal-header">
                                <h3 class="modal-title"> </h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <form method="POST" action="{{route('qpe.closecomplain.patch', $pe->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="id" value="{{$pe->id}}">

                                <!-- Bagian konten modal -->
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card shadow-none border">
                                                <div class="card-header d-flex">
                                                    <div class="d-flex  align-items-center">
                                                        <div class="card-title">Konfirmasi </div>
                                                    </div>

                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h3>Apakah Anda yakin ingin menutup komplain tersebut?</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian footer modal -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> Ya, Saya Yakin</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                @endif
            </div>
            <!-- Akhir Action Karyawan  -->
            @endif

            
            <!-- KPI table component -->
            <div class="card" style="border-radius: 15px">
                        {{-- <div class="card-header d-flex justify-content-between p-2 bg-primary text-white">
                           <small> <i class="fas fa-file-contract"></i> KPI</small>
                          
                        </div> --}}
                        <input type="hidden" id="kpi_id" name="kpi_id">
                        <input type="hidden" id="employee_id" name="employe_id">
                        <input type="hidden" id="date" name="date">
                        <div class="card-body p-0">
                              <div class="table-responsive rounded-3" style="border-radius: 10px;">
                                 <table id="tableCreate" class="displays table-sm rounded">
                                    <thead>
                                       <tr>
                                          <th colspan="8" class="bg-primary py-2"><small> <i class="fas fa-file-contract"></i> DISCIPLINE</small></th>
                                       </tr>
                                       <tr>
                                          <th class="text-center">No</th>
                                          <th class="text-center" colspan="">Alpha</th>
                                          <th class="text-center" colspan="">Izin</th>
                                          <th class="text-center" colspan="">Terlambat</th>
                                          <th class="text-center">Weight</th>
                                          <th class="text-center">Target</th>
                                          <th class="text-center">Value</th>
                                          <th>Achievement</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td class="text-center">1</td>
                                          <td class="text-center">{{ $pd ? $pd->alpa : 0 }}</td>
                                          <td class="text-center">{{ $pd ? $pd->ijin : 0 }}</td>
                                          <td class="text-center">{{ $pd ? $pd->terlambat : 0 }}</td>
                                          
                                          <td class="text-center">{{ $pd ? $pd->weight : 0 }}</td>
                                          <td class="text-center">4</td>
                                          <td class="text-center">{{ $pd ? $pd->achievement : 0 }}</td>
                                          <td class="text-center">{{ $pd ? $pd->contribute_to_pe : 0 }}</td>
                                       </tr>
                                       <tr>
                                          <th colspan="7" class="text-right">Achievement Final
                                             
                                          </th>
                                          <th class="text-center" id="totalAchievement">{{ $pd ? $pd->contribute_to_pe : 0 }}</th>
                                       </tr>
                                    </tbody>
                                    

                                    



                                    {{-- KPI --}}
                                    <thead>
                                          <tr>
                                             <th colspan="8" class="bg-primary py-2"><small> <i class="fas fa-file-contract"></i> KPI</small></th>
                                          </tr>
                                          <tr>
                                             <th class="text-center">No</th>
                                             <th colspan="3">Objective</th>
                                             <th class="text-center">Weight</th>
                                             <th class="text-center">Target</th>
                                             <th class="text-center">Value</th>
                                             <th>Achievement</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          @php
                                          $totalAcv = 0;
                                          @endphp
                                          @foreach ($datas as $data)

                                          @php
                                          $urlPdf = Storage::url($data->evidence) ;
                                          @endphp
                                          <tr>
                                             <td class="text-center">{{++$i}}</td>
                                             <td colspan="3"><a href="#" data-target="#myModal-{{$data->id}}" data-toggle="modal"> {{$data->kpidetail->objective}} </a></td>
                                             <td class="text-center"> {{$data->kpidetail->weight}}</td>
                                             <td class="text-center"> {{$data->kpidetail->target}}</td>
                                             <td class="text-center"> {{$data->value}}</td>
                                             <td class="text-center"> <b>{{$data->achievement}}</b></td>
                                          </tr>


                                          <div class="modal fade" id="myModal-{{$data->id}}" data-bs-backdrop="static">
                                             <div class="modal-dialog" style="max-width: 80%;">
                                                <div class="modal-content">

                                                      <!-- Bagian header modal -->
                                                      <div class="modal-header bg-primary">
                                                         <h3 class="modal-title">{{$data->kpidetail->objective}} </h3>
                                                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                      </div>
                                                      <!-- Bagian konten modal -->
                                                      <div class="modal-body">

                                                         <div class="row">
                                                            <div class="col-md-4">
                                                                  <div class="card shadow-none border">
                                                                     <form method="POST" action="{{route('kpa.update',$kpa->id) }}" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')

                                                                        <input type="hidden" name="id" value="{{$data->id}}">
                                                                        <input type="hidden" name="kpa_id" value="{{$kpa->id}}">
                                                                        <div class="card-header d-flex">
                                                                              <div class="d-flex  align-items-center">
                                                                                 <div class="card-title">Form Edit</div>
                                                                              </div>
                                                                        </div>
                                                                        <div class="card-body">
                                                                              <div class="form-group">
                                                                                 <label for="objective">Objective:</label>
                                                                                 <input type="text" class="form-control" id="objective" name="objective" value="{{ $data->kpidetail->objective }}" readonly>
                                                                              </div>

                                                                              <div class="form-group">
                                                                                 <label for="weight">Weight:</label>
                                                                                 <input type="text" class="form-control" id="weight" name="weight" value="{{ $data->kpidetail->weight }}" readonly>
                                                                              </div>

                                                                              <div class="form-group">
                                                                                 <label for="target">Target:</label>
                                                                                 <input type="text" class="form-control" id="target" name="target" value="{{ $data->kpidetail->target }}" readonly>
                                                                              </div>

                                                                              <div class="form-group">
                                                                                 <label for="value">Value:</label>
                                                                                 <input type="text" class="form-control value" {{ in_array($kpa->status, ['1', '2', '3', '4']) ? 'readonly' : '' }} id="value" name="value" data-key="{{ $data->id }}" data-target="{{ $data->kpidetail->target }}" data-weight="{{ $data->kpidetail->weight }}" value="{{ old('value', $data->value) }}" autocomplete="off">
                                                                              </div>

                                                                              <div class="form-group">
                                                                                 <label for="achievement">Achievement:</label>
                                                                                 <input type="text" class="form-control" id="achievement-{{$data->id}}" name="achievement" value="{{ $data->achievement }}" readonly>
                                                                              </div>
                                                                        </div>

                                                                     </form>
                                                                  </div>

                                                            </div>
                                                            <div class="col-md-8">
                                                                  <div class="card shadow-none border">
                                                                     <div class="card-header d-flex">
                                                                        <div class="d-flex  align-items-center">
                                                                              <div class="card-title">Evidence</div>
                                                                        </div>

                                                                     </div>
                                                                     <div class="card-body">
                                                                        @if ($data->evidence)
                                                                        <iframe src="{{ asset('storage/'. $data->evidence) }}" id="pdfPreview-{{$data->id}}" width=" 100%" height="575px"></iframe>
                                                                        @else
                                                                        <p>No attachment available.</p>
                                                                        @endif

                                                                     </div>
                                                                  </div>
                                                            </div>
                                                         </div>



                                                      </div>

                                                      <!-- Bagian footer modal -->
                                                      <div class="modal-footer">
                                                         <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                                      </div>

                                                </div>
                                             </div>
                                          </div>
                                          @php
                                          $totalAcv += $data->achievement;
                                          @endphp

                                          @endforeach
                                    </tbody>
                                    <tbody>
                                       @if($addtional)
                                       <tr>
                                          <td class="text-right" colspan="5">Achievement</td>
                                          <td class="text-right"><b>{{$totalAcv}}</b></td>
                                       </tr>
                                       <tr>
                                          <td>Addtional </td>
                                          <td><b><a href="#" data-target="#modalEditAddtional" data-toggle="modal">{{$addtional->addtional_objective}}</a></b></td>
                                          <td>{{$addtional->addtional_weight}}</td>
                                          <td>{{$addtional->addtional_target}}</td>
                                          <td>{{$addtional->value}}</td>
                                          <td class="text-right"><b>{{$addtional->achievement}}</b></td>
                                          {{-- @if($kpa->status == '2' || $kpa->status == '202')
                                          <td>
                                             @if($addtional->status == '0')
                                             <span class="badge badge-default">Open</span>
                                             @elseif($addtional->status == '1')
                                             <span class="badge badge-success">Valid</span>
                                             @elseif($addtional->status == '202')
                                             <span class="badge badge-danger">Invalid</span>
                                             @endif
                                          </td>
                                          <td>
                                             <br>{{$addtional->reason_rejection}}
                                          </td>
                                          @endif --}}
                                       </tr>

                                       <div class="modal fade" id="modalEditAddtional" data-bs-backdrop="static">
                                          <div class="modal-dialog" style="max-width: 80%;">
                                             <div class="modal-content">

                                                   <!-- Bagian header modal -->
                                                   <div class="modal-header bg-success">
                                                      <h3 class="modal-title">{{$addtional->addtional_objective}} </h3>
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                   </div>

                                                   <!-- Bagian konten modal -->
                                                   <div class="modal-body">

                                                      <div class="row">
                                                         <div class="col-md-4">
                                                               <form method="POST" action="{{route('kpa.addtional.update',$kpa->id) }}" enctype="multipart/form-data">
                                                                  @csrf
                                                                  @method('PUT')

                                                                  <input type="hidden" name="id" value="{{$addtional->id}}">
                                                                  <input type="hidden" name="kpa_id" value="{{$addtional->kpa_id}}">

                                                                  <div class="card shadow-none border">
                                                                     <div class="card-header d-flex">
                                                                           <div class="d-flex  align-items-center">
                                                                              <div class="card-title">Form Edit</div>
                                                                           </div>

                                                                     </div>
                                                                     <div class="card-body">
                                                                           <div class="form-group">
                                                                              <label for="objective">Objective:</label>
                                                                              <input type="text" class="form-control" id="objective" name="objective" value="{{ $addtional->addtional_objective }}">
                                                                           </div>

                                                                           <div class="form-group">
                                                                              <label for="weight">Weight:</label>
                                                                              <input type="number" class="form-control" id="weight-edit" name="weight" min="1" max="20" value="{{ $addtional->addtional_weight }}">
                                                                           </div>

                                                                           <div class="form-group">
                                                                              <label for="target">Target:</label>
                                                                              <input type="text" class="form-control" id="target-edit" name="target" value="{{ $addtional->addtional_target }}" readonly>
                                                                           </div>

                                                                           <div class="form-group">
                                                                              <label for="value">Value:</label>
                                                                              <input type="text" class="form-control" {{$kpa->status > 0 ? 'readonly' : '' }} id="value-edit" name="value" data-key="{{ $addtional->id }}" data-target="{{ $addtional->addtional_target }}" data-weight="{{ $addtional->addtional_weight }}" value="{{ old('value', $addtional->value) }}" autocomplete="off">
                                                                           </div>

                                                                           <div class="form-group">
                                                                              <label for="achievement">Achievement:</label>
                                                                              <input type="text" class="form-control" id="achievement-edit" name="achievement" value="{{ $addtional->achievement }}" readonly>
                                                                           </div>
                                                                           @if($kpa->status == '0' || $kpa->status == '101' || $kpa->status == '202')
                                                                           <div class="form-group">
                                                                              <label for="attachment">Evidence</label>
                                                                              <input type="file" class="form-control-file attachment" id="attachment" data-key="{{ $addtional->id }}" name="attachment" accept=".pdf">
                                                                              <label for="attachment">*opsional jika evidence ingin di rubah</label>
                                                                           </div>
                                                                           @endif
                                                                     </div>
                                                                  </div>
                                                                  @if($kpa->status == '0' || $kpa->status == '101' || $kpa->status == '202')
                                                                  <a href="/kpa/addtional-delete/{{enkripRambo($addtional->id)}}" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')"><button type="button" class="btn btn-danger"> <i class="fa fa-trash "></i> Delete</button></a>
                                                                  <button type="submit" class="btn btn-warning">Update</button>
                                                                  @endif
                                                               </form>


                                                               @if($kpa->status == 2)
                                                               @if (auth()->user()->hasRole('Administrator|HRD'))
                                                               <!-- Form Validasi HRD -->
                                                               <div class="card shadow-none border">
                                                                  <form method="POST" action="{{route('kpa.item.validasi',$kpa->id)}}">
                                                                     @csrf
                                                                     @method('patch')
                                                                     <input type="hidden" name="id" value="{{$addtional->id}}">
                                                                     <input type="hidden" name="act" class="act" value="valid">
                                                                     <div class="card-header d-flex">
                                                                           <div class="d-flex  align-items-center">
                                                                              <div class="card-title">Validasi</div>
                                                                           </div>
                                                                     </div>
                                                                     <div class="card-body boxPerbaikan">
                                                                           <label for="form-control">Alasan Penolakan </label>
                                                                           <textarea name="alasan_penolakan" id="alasan_penolakan" class="form-control alasan_penolakan" rows="4" placeholder="Tuliskan alasan penolakan disini!"></textarea>
                                                                     </div>
                                                                     <!-- Disini KHusus HRD  -->

                                                                     <div class="card-footer ">
                                                                           <div class="float-right">
                                                                              <button class="btn btn-success validBtn"><i class="fa fa-check"></i> Valid</button>
                                                                              <button type="button" class="btn btn-danger invalidBtn" id="invalidBtn"><i class="fa fa-window-close"></i> Invalid</button>
                                                                              <button class="btn btn-danger confirmBtn"><i class="fa fa-check"></i> Confirm</button>
                                                                              <button type="button" class="btn btn-default cancelBtn"><i class="fa fa-window-close"></i> Cancel</button>
                                                                           </div>
                                                                     </div>

                                                                  </form>
                                                               </div>
                                                               @endif
                                                               <!-- End Form Validasi HRD -->
                                                               @endif

                                                         </div>

                                                         <div class="col-md-8">
                                                               <div class="card shadow-none border">
                                                                  <div class="card-header d-flex">
                                                                     <div class="d-flex  align-items-center">
                                                                           <div class="card-title">Evidence</div>
                                                                     </div>

                                                                  </div>
                                                                  <div class="card-body">
                                                                     @if ($addtional->evidence)
                                                                     <iframe src="{{ Storage::url($addtional->evidence) }}" id="pdfPreview-{{$addtional->id}}" width=" 100%" height="575px"></iframe>
                                                                     @else
                                                                     <p>No attachment available.</p>
                                                                     @endif

                                                                  </div>
                                                               </div>
                                                         </div>
                                                      </div>



                                                   </div>

                                                   <!-- Bagian footer modal -->
                                                   <div class="modal-footer">
                                                      <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                   </div>
                                             </div>
                                          </div>
                                       </div>
                                       @endif
                                       <tr>
                                          <th colspan="6" class="text-right">Achievement KPI </th>
                                          <th class="text-center">{{$valueAvg}}</th>
                                          <th class="text-center" id="totalAchievement">{{$kpa->achievement}}</th>
                                       </tr>
                                       <tr>
                                          <th colspan="7" class="text-right">Poin KPI
                                             <br><small>Achievement KPI * ( {{$kpa->weight}} / 100)</small>
                                          </th>
                                          <th class="text-center" id="totalAchievement">{{$kpa->contribute_to_pe}}</th>
                                       </tr>
                                    </tbody>

                                    {{-- BEHAV --}}
                                    @if($pba == null)
                                       <form action="{{ route('qpe.behavior.store') }}" name="formBehavior" method="POST" enctype="multipart/form-data" accept=".jpg, .jpeg, .png, .pdf">
                                          @endif
                                          @csrf
                                          <input type="hidden" name="employe_id" value="{{ $kpa->employe_id }}">
                                          <input type="hidden" name="kpa_id" value="{{ $kpa->id }}">
                                          <input type="hidden" name="pe_id" value="{{ $kpa->pe_id }}">
                                          
                                                {{-- <div class="table-responsive">
                                                   <table class="displays table-sm"> --}}
                                                      <thead>
                                                         <tr>
                                                            <th colspan="8" class="bg-primary py-2"><small> <i class="fas fa-file-contract"></i> BEHAVIOUR</small></th>
                                                         </tr>
                                                            <tr>
                                                               <th>No</th>
                                                               <th>Objective</th>
                                                               <th colspan="2">Description</th>
                                                               <th class="text-center">Weight</th>
                                                               <th class="text-center">Target</th>
                                                               <th class="text-center">Value</th>
                                                               <th class="text-center">Achievement</th>
                                                            </tr>
                                                      </thead>
                                                      <tbody>
                                                            @if($pba == null)
                                                            @foreach($behaviors as $key => $behavior)
                                                            <tr>
                                                               <td>{{ ++$key }}</td>
                                                               <td class="text-center">{{++$i}}</td>
                                                               <td>{{ $behavior->objective }}</td>
                                                               <td colspan="2">{{ $behavior->description }}</td>
                                                               <td class="text-center">{{ $behavior->bobot }}</td>
                                                               <td class="text-center">4</td>
                                                               <td class="text-center">
                                                                  <input type="text" name="valBehavior[{{ $behavior->id }}]" value="0" min="0.01" max="4" step="0.01">
                                                                  <br><span><small>*Max 4 point</small></span>
                                                               </td>
                                                               <td class="text-center">
                                                                  <input type="text" name="acvBehavior[{{ $behavior->id }}]" readonly>
                                                                  <br><span>-</span>
                                                               </td>
                                                            </tr>
                                                            @endforeach
                                                            @else
                                                            @foreach($pbads as $key => $pbda)
                                                            <tr>
                                                               <td>{{ ++$key }}</td>
                                                               {{-- <td class="text-center">{{++$i}}</td> --}}
                                                               <td>
                                                                  <a href="#" data-target="#modalBehavior-{{ $pbda->id }}" data-toggle="modal">{{ $pbda->behavior->objective }}</a>
                                                               </td>
                                                               <td colspan="2">{{ $pbda->behavior->description }}</td>
                                                               <td class="text-center">{{ $pbda->behavior->bobot }}</td>
                                                               <td class="text-center">4</td>
                                                               <td class="text-center">{{ $pbda->value }}</td>
                                                               <td class="text-center">{{ $pbda->achievement }}</td>
                                                            </tr>
                                                            <div class="modal fade" id="modalBehavior-{{ $pbda->id }}" data-bs-backdrop="static">
                                                               <div class="modal-dialog" style="max-width: 50%;">
                                                                  <div class="modal-content">
                                                                        <form method="POST" action="{{ route('qpe.behavior.update', $pbda->id) }}" enctype="multipart/form-data">
                                                                           @csrf
                                                                           @method('patch')
                                                                           <input type="hidden" name="id" value="{{ $pbda->id }}">
                                                                           <input type="hidden" name="kpa_id" value="{{ $kpa->id }}">
                                                                           <input type="hidden" name="pba_id" value="{{ $pbda->pba_id }}">
                                                                           <div class="modal-header bg-primary">
                                                                              <h3 class="modal-title text-white">{{ $pbda->behavior->objective }}</h3>
                                                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                           </div>
                                                                           <div class="modal-body">
                                                                              <div class="card-body">
                                                                                    <div class="form-group">
                                                                                       <label for="objective">Objective :</label>
                                                                                       <input type="text" class="form-control" id="objective" name="objective" value="{{ $pbda->behavior->objective }}" readonly>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                       <label for="description">Description :</label>
                                                                                       <textarea type="text" rows="5" class="form-control" id="description" name="description" readonly>{{ $pbda->behavior->description }}</textarea>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                       <label for="weight">Weight :</label>
                                                                                       <input type="text" class="form-control" id="weight" name="weight" value="{{ $pbda->behavior->bobot }}" readonly>
                                                                                    </div>
                                                                                    @if($pba->status == '0' || $pba->status == '1')
                                                                                    <div class="form-group">
                                                                                       <label for="value">Value :</label>
                                                                                       <input type="text" class="form-control value" id="value" name="valBv" data-key="{{ $pbda->id }}" data-target="{{ $pbda->behavior->target }}" data-weight="{{ $pbda->behavior->weight }}" value="{{ old('value', $pbda->value) }}" autocomplete="off">
                                                                                    </div>
                                                                                    @endif
                                                                                    <div class="form-group">
                                                                                       <label for="achievement">Achievement :</label>
                                                                                       <input type="text" class="form-control" id="achievementBv-{{ $pbda->id }}" name="achievement" value="{{ $pbda->achievement }}" readonly>
                                                                                    </div>
                                                                              </div>
                                                                           </div>
                                                                           <div class="modal-footer">
                                                                              @if($pba->status == '0' || $pba->status == '1')
                                                                              <button type="submit" class="btn btn-warning">Update</button>
                                                                              <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                                                              @endif
                                                                           </div>
                                                                        </form>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                            @endforeach
                                                            @endif
                                                      </tbody>
                                                      <tfoot>
                                                            <tr>
                                                               <th colspan="7" class="text-right">Poin Behaviour</th>
                                                               @if(isset($pba))
                                                               <th class="text-center"><span id="totalAcvBehavior" name="totalAcvBehavior">{{ $pba->achievement }}</span></th>
                                                               @else
                                                               <th class="text-center"><span id="totalAcvBehavior" name="totalAcvBehavior">-</span></th>
                                                               @endif
                                                            </tr>
                                                      </tfoot>
                                                   {{-- </table>
                                                </div> --}}
                                          
                                          @if($pba == null)
                                       </form>
                                    @endif
                                 </table>
                              </div>
                              
                        </div>
                     </div>
            {{-- <x-qpe.kpi-table :kpa="$kpa" :valueAvg="$valueAvg" :datas="$datas" :addtional="$addtional" :i="$i" />
            <x-behavior-form :kpa="$kpa" :pba="$pba" :behaviors="$behaviors" :pbads="$pbads" /> --}}
        </div>
    </div>

    {{-- <div class="row" id="boxDetail">
        <div class="col-md-3">
            <!-- Discipline component -->
            
        </div>
        <div class="col-md-9">
            <!-- Behavior form component -->
            
        </div>
    </div> --}}


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form method="POST" action="{{route('qpe.komentar.patch', $pe->id)}}">
                    @csrf
                    @method('patch')
                    <div class="card-header bg-primary text-white">
                        Komentar Evaluator
                    </div>
                    <div class=" card-body">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="form-control">Komentar <span class="text-danger">*</span> : </label>
                                    <textarea name="komentar" id="komentar" readonly class="form-control komentar" rows="4" required placeholder="Tuliskan komentar anda disini disini!">{{$pe->komentar ?? ''}}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="form-control">Development & Training : </label>
                                    <textarea name="pengembangan" id="pengembangan" readonly class="form-control pengembangan" rows="4" placeholder="Tuliskan alasan penolakan disini!">{{$pe->pengembangan ?? ''}}</textarea>
                                </div>
                                @if($pe->evidence)
                                <div class="col-md-6 mt-3">
                                    <div class="form-group ">
                                        <b>File Bukti Persetujuan Karyawan <span class="text-danger">*</span> </b><br />
                                    </div>

                                    <!-- Button -->
                                    <a href="#" data-target="#modalEvidence" data-toggle="modal"><span class="fa fa-file"></span> Lihat File</a>

                                    <!-- Modal -->
                                    <div class="modal fade" id="modalEvidence" data-bs-backdrop="static">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">

                                                <!-- Bagian header modal -->
                                                <div class="modal-header">
                                                    <h3 class="modal-title"> </h3>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Bagian konten modal -->
                                                <div class="modal-body">

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="card shadow-none border">
                                                                <div class="card-header d-flex">
                                                                    <div class="d-flex  align-items-center">
                                                                        <div class="card-title">File Evidence</div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        @if ($pe->evidence)
                                                                        <iframe src="{{asset('storage/'. $pe->evidence)}}" id="pdfPreview-{{$pe->id}}" width=" 100%" height="575px"></iframe>
                                                                        @else
                                                                        <p>No attachment available.</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Bagian footer modal -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal -->
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @php
    // Calculate achievements for discipline and behavior
    $pdAchievement = $pd ? $pd->contribute_to_pe : 0;
    $pbaAchievement = $pba ? $pba->achievement : 0;
    @endphp

    <!-- Summary appraisal section -->
    <div class="row">
        <div class="col-md-12">
            <!-- Summary appraisal component -->
            <x-qpe.summary-appraisal :pd-achievement="$pdAchievement" :pd="$pd" :datas="$datas" :kpa="$kpa" :behaviors="$behaviors" :pba="$pba" :pe="$pe" />
        </div>
    </div>
</div>

@foreach ($datas as $data)
<div class="modal fade" id="myModal-{{$data->id}}" data-bs-backdrop="static">
    <div class="modal-dialog" style="max-width: 80%;">
        <div class="modal-content">

            <!-- Bagian header modal -->
            <div class="modal-header bg-primary">
                <h3 class="modal-title">{{$data->kpidetail->objective}} </h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Bagian konten modal -->
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="card shadow-none border">
                            <form method="POST" action="{{route('kpa.update',$kpa->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="id" value="{{$data->id}}">
                                <input type="hidden" name="kpa_id" value="{{$kpa->id}}">
                                <div class="card-header d-flex">
                                    <div class="d-flex  align-items-center">
                                        <div class="card-title">Form Edit</div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="objective">Objective:</label>
                                        <input type="text" class="form-control" id="objective" name="objective" value="{{ $data->kpidetail->objective }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="weight">Weight:</label>
                                        <input type="text" class="form-control" id="weight" name="weight" value="{{ $data->kpidetail->weight }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="target">Target:</label>
                                        <input type="text" class="form-control" id="target" name="target" value="{{ $data->kpidetail->target }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="value">Value:</label>
                                        <input type="text" class="form-control value" {{ in_array($kpa->status, ['1', '2', '3', '4']) ? 'readonly' : '' }} id="value" name="value" data-key="{{ $data->id }}" data-target="{{ $data->kpidetail->target }}" data-weight="{{ $data->kpidetail->weight }}" value="{{ old('value', $data->value) }}" autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label for="achievement">Achievement:</label>
                                        <input type="text" class="form-control" id="achievement-{{$data->id}}" name="achievement" value="{{ $data->achievement }}" readonly>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="card shadow-none border">
                            <div class="card-header d-flex">
                                <div class="d-flex  align-items-center">
                                    <div class="card-title">Evidence</div>
                                </div>

                            </div>
                            <div class="card-body">
                                @if ($data->evidence)
                                <iframe src="{{ asset('storage/'. $data->evidence) }}" id="pdfPreview-{{$data->id}}" width=" 100%" height="575px"></iframe>
                                @else
                                <p>No attachment available.</p>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>



            </div>

            <!-- Bagian footer modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>
    
@endforeach


@endsection

@push('js_footer')
<script>
    $(document).ready(function() {

        $('.boxPerbaikan').hide();

        // $('#invalidBtn').click(function() {
        //     console.log('test');
        // });
        $('.confirmBtn').hide();
        $('.cancelBtn').hide();

        $('.invalidBtn').click(function() {
            // Tindakan yang akan dijalankan saat tombol diklik
            $('.boxPerbaikan').show();
            $('.validBtn').hide();
            $('.invalidBtn').hide();

            $('.confirmBtn').show();
            $('.cancelBtn').show();
            // Menambahkan atribut 'required' ke elemen input

            $('.alasan_penolakan').prop('required', true);

            $('.act').val('invalid');
        });

        $('.cancelBtn').click(function() {
            // Tindakan yang akan dijalankan saat tombol diklik
            $('.boxPerbaikan').hide();
            $('.validBtn').show();
            $('.invalidBtn').show();

            $('.confirmBtn').hide();
            $('.cancelBtn').hide();

            // Menghapus atribut 'required' dari elemen input
            $('.alasan_penolakan').removeAttr('required');

            $('.act').val('valid');
        });

        // Update Behavior Value
        // Event listener for input change
        $('input[name^="valBv"]').on('change', function() {
            var value = validateInputNew(this);
            // var inputName = $(this).attr('name');
            // var id = inputName.match(/\[([0-9]+)\]/)[1]; // Extract ID from name

            var acv = Math.round(((value / 4) * 5));

            var key = parseFloat($(this).data('key'));

            $('#achievementBv-' + key).val(acv);


            // $('input[name="acvBehavior[' + id + ']"]').val(acv);

        });

        // Baru Behavior
        // Function to validate the input value
        function validateInputNew(input) {
            var value = parseFloat($(input).val());
            var regex = /^\d+(\.\d{1,2})?$/;

            if (isNaN(value) || value < 0.01 || value > 4) {
                if (value > 4) {
                    value = 4;
                } else {
                    value = 1;
                }
                alert("Value must be between 0.01 and 4.");
            } else if (!regex.test(value.toFixed(2))) {
                alert("Value cannot have more than two decimal places.");
                value = value.toFixed(2);
            } else {
                value = value.toFixed(2);
            }

            $(input).val(value);

            return value;
        }

        // Function to update the total of acvBehavior values
        function updateTotalAcvBehavior() {
            var total = 0;
            $('input[name^="acvBehavior"]').each(function() {
                var value = parseFloat($(this).val());
                if (!isNaN(value)) {
                    total += value;
                }
            });
            $('#totalAcvBehavior').text(total.toFixed(2));
        }

        // Event listener for input change
        $('input[name^="valBehavior"]').on('change', function() {
            var value = validateInputNew(this);
            var inputName = $(this).attr('name');
            var id = inputName.match(/\[([0-9]+)\]/)[1]; // Extract ID from name

            var acv = Math.round(((value / 4) * 5));

            $('input[name="acvBehavior[' + id + ']"]').val(acv);

            // Update totalAcvBehavior whenever valBehavior changes
            updateTotalAcvBehavior();
        });

        // Optional: Add validation on form submit
        $('form[name="formBehavior"]').on('submit', function(event) {
            var isValid = true;
            $('input[name^="valBehavior"]').each(function() {
                var value = parseFloat($(this).val());
                if (isNaN(value) || value < 0.01 || value > 4) {
                    alert("Value must be between 0.01 and 4.");
                    $(this).val("0");
                    isValid = false;
                }
            });
            if (!isValid) {
                event.preventDefault();
            }
        });

        // end Baru


        $('.attachment').on('change', function() {
            var input = $(this)[0];

            var key = $(this).data('key');

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {

                    showPdf(e.target.result, key);

                };
                reader.readAsDataURL(input.files[0]);
            }
        });

        function showPdf(data, id) {
            $('#pdfPreview-' + id).attr('src', ''); // Mengosongkan atribut src
            $('#pdfPreview-' + id).attr('src', data); // Menetapkan atribut src dengan tampilan pratinjau baru
            $('#pdfPreview-' + id).show();
        }

        $('.value').on('input', function() {
            var inputValue = $(this).val();

            // Hapus angka 0 di depan jika ada
            inputValue = inputValue.replace(/^0+(?=\d)/, '');

            $(this).val(inputValue);

            var key = parseFloat($(this).data('key'));
            var targetValue = parseFloat($(this).data('target'));
            var weightValue = parseFloat($(this).data('weight'));



            validateInput($(this), targetValue);

            let achievementValue = Math.round(($(this).val() / targetValue) * weightValue);

            $('#achievement-' + key).val(achievementValue);

        });

        function calculateAchievement() {
            var value = parseFloat($('#value-addtional').val());
            var targetValue = parseFloat($('#target-addtional').val());
            var weightValue = parseFloat($('#weight-addtional').val());

            if (isNaN(value) || value <= 0.1) {
                value = 0;
                $('#value-addtional').val(value);
            }

            validateInput($('#value-addtional'), targetValue);

            let achievementValue = Math.round((value / targetValue) * weightValue);

            // Batasi nilai achievementValue menjadi rentang 1 hingga 20
            achievementValue = Math.min(Math.max(achievementValue, 1), 20);

            $('#achievement-addtional').val(achievementValue);
        }

        $('#value-addtional').on('input', function() {
            var inputValue = $(this).val().replace(/^0+(?=\d)/, '');
            $(this).val(inputValue);
            calculateAchievement();
        });

        $('#weight-addtional').on('input', function() {
            var weightValue = parseFloat($(this).val());

            // Jika weightValue kosong, set nilai menjadi 1
            if (isNaN(weightValue) || weightValue <= 0) {
                weightValue = 1;
                $('#weight-addtional').val(weightValue);
            }

            // Batasi nilai weightValue menjadi maksimal 20
            weightValue = Math.min(weightValue, 20);

            $('#weight-addtional').val(weightValue);

            calculateAchievement();
        });


        // Edit
        function calculateAchievementEdit() {
            var value = parseFloat($('#value-edit').val());
            var targetValue = parseFloat($('#target-edit').val());
            var weightValue = parseFloat($('#weight-edit').val());

            if (isNaN(value) || value <= 0.1) {
                value = 0;
                $('#value-edit').val(value);
            }

            validateInput($('#value-edit'), targetValue);

            let achievementValue = Math.round((value / targetValue) * weightValue);

            // Batasi nilai achievementValue menjadi rentang 1 hingga 20
            achievementValue = Math.min(Math.max(achievementValue, 1), 20);

            $('#achievement-edit').val(achievementValue);
        }

        $('#value-edit').on('input', function() {
            var inputValue = $(this).val().replace(/^0+(?=\d)/, '');
            $(this).val(inputValue);
            calculateAchievementEdit();
        });

        $('#weight-edit').on('input', function() {
            var weightValue = parseFloat($(this).val());

            // Jika weightValue kosong, set nilai menjadi 1
            if (isNaN(weightValue) || weightValue <= 0) {
                weightValue = 1;
                $('#weight-edit').val(weightValue);
            }

            // Batasi nilai weightValue menjadi maksimal 20
            weightValue = Math.min(weightValue, 20);

            $('#weight-edit').val(weightValue);

            calculateAchievementEdit();
        });

        $('.calculateAdd').on('input', function() {

            let weightAdd = $("#weight-addtional").val();
            let valueAdd = $("#value-addtional").val();

            console.log('test');

            let totalAdd = Math.round((valueAdd / 4) * weightAdd); // 4 DI AMBIL Dari nilai default target

            $('#achievement-addtional').val(totalAdd);
        });




        function validateInput(input, targetValue) {
            var inputValue = parseFloat(input.val());

            if (isNaN(inputValue) || inputValue < 0.1) {
                input.removeClass('is-valid');
                input.addClass('is-invalid');
            } else if (inputValue > targetValue) {
                input.val(targetValue);
                input.removeClass('is-invalid');
                input.addClass('is-valid');
            } else {
                input.removeClass('is-invalid');
                input.addClass('is-valid');
            }
        }

    })

    function hitungYuk() {
        return $('#value-addtional').val();
    }

    function doneValidasi(id, pesan = 'Konfirmasi') {
        swal({
                title: "Done",
                text: pesan + ",Yakin ingin menyelesaikan validasi ini ?",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $('#done-validasi').submit();
                }
            });
    }

    function doneVerifikasi(id, pesan = 'Konfirmasi') {
        swal({
                title: "Konfirmasi",
                text: " Anda yakin ingin menyelesaikan verifikasi ini ?",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $('#done-validasi').submit();
                }
            });
    }


    function rejectValidasi(id, pesan = 'Konfirmasi') {
        swal({
                title: "Reject",
                text: pesan + ",Anda Yakin ingin mereject data ini ?",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $('#reject-validasi').submit();
                }
            });
    }

    function resendingValidasi(id, pesan = 'Konfirmasi') {
        swal({
                title: "Konfirmasi",
                text: "Anda Yakin ingin mengirimkan kembali data ini?",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $('#resending-validasi').submit();
                }
            });
    }
</script>
@endpush