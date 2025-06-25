@if ($absenceemp->type == 5)  
   <div class="table-responsive">
      <table>
         <tbody>
            <tr>
               <td class="text-center" colspan="2" rowspan="2">
                  <img src="{{asset('img/logo/enc1.png')}}" alt="" width="100">
               </td>
               <td class="text-center" colspan="4">
                  <h4>FORMULIR</h4>
               </td>
               <td class="text-center" colspan="2" rowspan="2">
                  <img src="{{asset('img/logo/ekanuri.png')}}" alt="" width="100"><br>
                  <span>PT Ekanuri</span>
               </td>
            </tr>
            <tr class="text-center">
               <td colspan="4"><h4>PERMOHONAN CUTI KARYAWAN</h4></td>
            </tr>
            <tr class="text-center">
               <td colspan="2">No. Dok : FM.PS.HRD.32</td>
               <td colspan="4">Rev: 00/22</td>
               <td colspan="2">Hal : 1 dari 1</td>
            </tr>
            

            <tr>
               <td colspan="">Periode Hak Cuti</td>
               <td colspan="7">{{formatYear($cuti->start)}} / {{formatYear($cuti->end)}}</td>
            </tr>
            <tr>
               <td colspan="">Perusahaan</td>
               <td colspan="7">{{$cuti->employee->unit->name}}</td>
            </tr>
            <tr>
               <td colspan="">Nama</td>
               <td colspan="7">{{$cuti->employee->biodata->fullName() ?? ''}}</td>
            </tr>
            <tr>
               <td colspan="">NIK</td>
               <td colspan="7">{{$employee->nik}}</td>
            </tr>
            <tr>
               <td colspan="">Jabatan/Dept</td>
               <td colspan="7">{{$employee->position->name}}/{{$employee->department->name}}</td>
            </tr>
            <tr>
               <td colspan="">Tanggal Masuk Kerja</td>
               <td colspan="7">{{formatDate($employee->join)}}</td>
            </tr>


            <tr class="text-center">
               <td>Jumlah Cuti yang sudah diambil</td>
               <td>Lama Cuti yang akan diambil</td>
               <td>Tanggal Mulai Cuti</td>
               <td>sampai dengan</td>
               <td>Sisa Cuti</td>
               <td>Keperluan</td>
               <td>Nama Karyawan Pengganti</td>
               <td>Alamat/No. Telp 
                  yang dapat dihubungi</td>
            </tr>

            <tr class="text-center">
               <td style="height: 40px">{{$cuti->used}}</td>
               <td>
                  @if ($absdetails && count($absdetails) > 0)
                  {{$absenceemp->cuti_qty}}
                  @else
                  0
                  @endif
               </td>
               <td>
                  {{-- {{$absenceemp->cuti_start}} --}}
                  
                  @if ($absdetails && count($absdetails) > 0)
                  {{formatDate($absenceemp->cuti_start)}}
                  @else
                  -
                  @endif
                  
               </td>
               <td>
                  @if ($absdetails && count($absdetails) > 0)
                  {{formatDate($absenceemp->cuti_end)}}
                  @else
                  -
                  @endif
                  
               </td>
               <td>{{$cuti->sisa}}</td>
               <td>{{$absenceemp->desc}}</td>
               <td>
                  @if ($absenceemp->cuti_backup != null)
                  {{$absenceemp->cuti_backup->biodata->fullName() ?? ''}}
                  @endif
                  
               </td>
               <td>
                  @if ($absenceemp->cuti_backup != null)
                  {{$absenceemp->cuti_backup->biodata->phone ?? ''}}
                  @endif
               </td>
            </tr>

            <tr>
               <td class="bg-dark text-light text-truncate">Diajukan Oleh :</td>
               <td class="bg-dark text-light text-truncate">Disetujui Oleh :</td>
               <td class="bg-dark text-light text-truncate">Disetujui Oleh :</td>
               <td class="bg-dark text-light text-truncate">Diketahui Oleh :</td>
               <td colspan="4" >Masuk Kembali
                  
               </td>
            </tr>
            <tr>
               <td class="text-center" style="height: 70px">
                  @if ($absenceemp->status == 1 || $absenceemp->status == 2 || $absenceemp->status == 3 || $absenceemp->status == 5)
                     <span class="text-success"><i>CREATED</i></span> <br>
                     {{-- <small>{{formatDateTime($absenceemp->release_date)}}</small> --}}
                  @endif
               </td>
               <td class="text-center">
                  @if ($absenceemp->status == 2 || $absenceemp->status == 3 || $absenceemp->status == 5 )
                     <span class="text-success"><i>APPROVED</i></span> <br>
                     {{-- <small>{{formatDateTime($absenceemp->app_backup_date)}}</small> --}}
                  @endif
               </td>
               <td class="text-center">
                  @if ($absenceemp->status == 3 || $absenceemp->status == 5)
                     <span class="text-success"><i>APPROVED</i></span><br>
                     {{-- <small>{{formatDateTime($absenceemp->app_leader_date)}}</small> --}}
                  @endif
               </td>
               <td class="text-center">
                  @if ($absenceemp->status == 5)
                     <span class="text-success"><i>VALIDATED</i></span>
                  @endif
               </td>
               <td colspan="4" rowspan="2">Catatan :</td>
            </tr>
            <tr>
               <td>{{$absenceemp->employee->biodata->fullName() ?? ''}}</td>
               {{-- <td>
                  @if ($absenceemp->cuti_backup != null)
                  {{$absenceemp->cuti_backup->biodata->fullName() ?? ''}}
                  @endif
               </td> --}}
               <td>
                  @if ($absenceemp->leader_id != null)
                  {{$absenceemp->leader->biodata->fullName() ?? ''}}
                  @endif
               </td>
               <td>
                  @if ($absenceemp->manager_id != null)
                  {{$absenceemp->manager->biodata->fullName() ?? ''}}
                  @endif
               </td>
               <td>HRD</td>
               {{-- <td colspan="4"></td> --}}
            </tr>
            <tr>
               <td class="text-truncate">
                  @if ($absenceemp->status == 1 || $absenceemp->status == 2 || $absenceemp->status == 3 || $absenceemp->status == 5)
                     <small>{{formatDateTime($absenceemp->release_date)}}</small>
                  @endif
               </td>
               <td class="text-truncate">
                  @if ($absenceemp->status == 2 || $absenceemp->status == 3 || $absenceemp->status == 5)
                     <small>{{formatDateTime($absenceemp->app_backup_date)}}</small>
                  @endif
               </td>
               <td class="text-truncate">
                  @if ($absenceemp->status == 3 || $absenceemp->status == 5)
                     <small>{{formatDateTime($absenceemp->app_leader_date)}}</small>
                  @endif
               </td>
               <td class="text-truncate">
                  @if ($absenceemp->status == 5)
                  <small>{{formatDateTime($absenceemp->app_hrd_date)}}</small>
                  @endif
               </td>
               <td colspan="4" class="text-end"></td>
            </tr>
            

            
         </tbody>
      </table>
   </div>
   <hr>
  
  
@endif

@if ($absenceemp->type == 6)
<div class="table-responsive">
<table>
   <tbody>
      <tr>
         <td class="text-center" colspan="2" rowspan="2">
            <img src="{{asset('img/logo/enc1.png')}}" alt="" width="100">
         </td>
         <td class="text-center" colspan="2">
            <h4>FORMULIR</h4>
         </td>
         <td class="text-center" colspan="2" rowspan="2">
            <img src="{{asset('img/logo/ekanuri.png')}}" alt="" width="100"><br>
            <span>PT Ekanuri</span>
         </td>
      </tr>
      <tr class="text-center">
         <td><h4>SURAT PERINTAH TUGAS</h4></td>
      </tr>
      <tr class="text-center">
         <td colspan="2">No. Dok : FM.PS.HRD.19</td>
         <td colspan="2">Rev: 01/22</td>
         <td colspan="2">Hal : 1 dari 1</td>
      </tr>
      <tr class="text-center">
         <td colspan="6">Nomor : {{$absenceemp->code}}</td>
      </tr>



      {{-- Body --}}
      <tr>
         <td colspan="6"><b>1. Pemberi Perintah</b></td>
      </tr>
      <tr>
         <td style="width: 20px"></td>
         <td colspan="1">Nama</td>
         <td colspan="4" class="">{{$absenceemp->leader->biodata->fullName() ?? ''}}</td>
      </tr>
      <tr>
         <td style="width: 20px"></td>
         <td colspan="1">Jabatan</td>
         <td colspan="4" class="">{{$absenceemp->leader->position->name}}</td>
      </tr>
      

      <tr>
         <td colspan="6"><b>2. Karyawan yang diperintahkan</b></td>
      </tr>
      <tr>
         <td style="width: 20px"></td>
         <td colspan="1" style="width: 250px">Nama</td>
         <td colspan="4" class="">{{$absenceemp->employee->biodata->fullName() ?? ''}}</td>
      </tr>
      <tr>
         <td style="width: 20px"></td>
         <td colspan="1">NIK</td>
         <td colspan="4" class="">{{$absenceemp->employee->nik}}</td>
      </tr>
      <tr>
         <td style="width: 20px"></td>
         <td colspan="1">Departemen</td>
         <td colspan="4" class="">{{$absenceemp->employee->department->name}}</td>
      </tr>
      <tr>
         <td style="width: 20px"></td>
         <td colspan="1">Jabatan</td>
         <td colspan="4" class="">{{$absenceemp->employee->position->name}}</td>
      </tr>
      
      <tr>
         <td colspan="2"><b>3. Maksud Perintah Tugas</b></td>
         <td colspan="4" class="">
            <textarea  name="" id="" style="width: 100%" rows="3" readonly>{{$absenceemp->desc}}</textarea>
            
         </td>
      </tr>
      <tr>
         <td colspan="2"><b>4. Alat angkutan yang di pergunakan</b></td>
         <td colspan="4" class="">
            <span>{{$absenceemp->transport}}</span>
            {{-- <textarea  name="" id="" style="width: 100%" rows="3" readonly>{{$absenceemp->desc}}</textarea> --}}
            
         </td>
      </tr>
      
      <tr>
         <td colspan="2"><b>4. Tempat Tujuan</b></td>
         <td colspan="4" class="">
            <span>{{$absenceemp->destination}}</span>
            {{-- <textarea  name="" id="" style="width: 100%" rows="3" readonly>{{$absenceemp->desc}}</textarea> --}}
            
         </td>
      </tr>
      <tr>
         <td style="width: 20px"></td>
         <td colspan="1">Berangkat dari</td>
         <td colspan="4" class="">{{$absenceemp->from}}</td>
      </tr>
      <tr>
         <td style="width: 20px"></td>
         <td colspan="1">Tempat transit</td>
         <td colspan="4" class="">{{$absenceemp->transit}}</td>
      </tr>
      <tr>
         <td style="width: 20px"></td>
         <td colspan="1">Lama tugas</td>
         <td colspan="4" class="">{{$absenceemp->duration}}</td>
      </tr>
      <tr>
         <td style="width: 20px"></td>
         <td colspan="1">Tanggal/Jam Berangkat</td>
         <td colspan="4" class="">{{formatDateTime($absenceemp->departure)}}</td>
      </tr>
      <tr>
         <td style="width: 20px"></td>
         <td colspan="1">Tanggal/Jam Kembali</td>
         <td colspan="4" class="">{{formatDateTime($absenceemp->return)}}</td>
      </tr>
      <tr>
         <td colspan="2"><b>5. Keterangan</b></td>
         <td colspan="4" class="">
            <textarea  name="" id="" style="width: 100%" rows="3" readonly>{{$absenceemp->remark}}</textarea>
            
         </td>
      </tr>
      <tr>
         <td colspan="6" class="text-center text-dark" style="background-color: rgb(167, 164, 164)" ><h4>Surat Perintah Tugas ini berlaku selama yang bersangkutan menjadi karyawan  PT. EKA NURI.</h4></td>
      </tr>



      <tr>
         <td colspan="6">Jakarta, {{formatDate($absenceemp->date)}}</td>
      </tr>
      <tr>
         <td colspan="2">
            <table>
               <tbody>
                  <tr class="bg-dark text-light">
                     <td>Pemberi Perintah</td>
                  </tr>
                  <tr>
                     <td style="height: 100px" class="text-center">

                        @if ($absenceemp->status >= 3)
                              <small class="text-success"><i>APPROVED</i></small> <br>
                              <small class="text-muted">{{formatDateTime($absenceemp->app_leader_date)}}</small>
                        @endif
                     </td>
                  </tr>
                  <tr>
                     <td>
                     Nama : {{$absenceemp->leader->biodata->fullName() ?? ''}}
                  </td>
                  </tr>

               </tbody>
            </table>
            {{-- <div class="card">
               <div class="card-header bg-dark text-light"></div>
               <div class="card-body" style="height: 100px">

               </div>
               <div class="card-footer">
                  Nama : {{$absenceemp->leader->biodata->fullName()}}
               </div>
            </div> --}}
         </td>
      </tr>
      <tr>
         <td colspan="6">Tembusan : <br>
         - <br>
         -
         </td>
      </tr>
      

      
   </tbody>
</table>
</div>
<hr>
@endif

@if ($absenceemp->type == 4)
<div class="table-responsive">
    <table>
      <tbody>
         <tr>
            <td class="text-center" colspan="2" rowspan="2">
               <img src="{{asset('img/logo/enc1.png')}}" alt="" width="100">
            </td>
            <td class="text-center" colspan="2">
               <h4>FORMULIR</h4>
            </td>
            <td class="text-center" colspan="2" rowspan="2">
               <img src="{{asset('img/logo/ekanuri.png')}}" alt="" width="100"><br>
               <span>PT Ekanuri</span>
            </td>
         </tr>
         <tr class="text-center">
            <td colspan="2"><h4>SURAT IZIN</h4></td>
         </tr>
         <tr>
            <td style="width: 20px"></td>
            <td colspan="1" style="width: 250px">Nama</td>
            <td colspan="4" class="">{{$absenceemp->employee->biodata->fullName() ?? ''}}</td>
         </tr>
         <tr>
            <td style="width: 20px"></td>
            <td colspan="1">NIK</td>
            <td colspan="4" class="">{{$absenceemp->employee->nik}}</td>
         </tr>
         {{-- <tr>
            <td style="width: 20px"></td>
            <td colspan="1">Departemen</td>
            <td colspan="4" class="">{{$absenceemp->employee->department->name}}</td>
         </tr> --}}
         <tr>
            <td style="width: 20px"></td>
            <td colspan="1">Jabatan</td>
            <td colspan="4" class="">{{$absenceemp->employee->position->name}}</td>
         </tr>
         <tr>
            <td colspan="6"></td>
         </tr>
         <tr>
            <td style="width: 20px"></td>
            <td colspan="1">Tanggal</td>
            <td colspan="4" class="">{{formatDate($absenceemp->date)}}</td>
         </tr>
         <tr>
            <td style="width: 20px"></td>
            <td colspan="1">Izin</td>
            <td colspan="4" class="">{{$absenceemp->type_desc}} ({{$absenceemp->remark}})</td>
         </tr>
         <tr>
            <td style="width: 20px"></td>
            <td colspan="1">Deskripsi</td>
            <td colspan="4" class="">{{$absenceemp->desc}} </td>
         </tr>
         
         <tr>
            <td colspan="2" class="bg-dark text-light text-truncate">Diajukan Oleh :</td>
            <td class="bg-dark text-light text-truncate">Disetujui Oleh :</td>
            <td class="bg-dark text-light text-truncate">Disetujui Oleh :</td>
            
            
         </tr>
         <tr>
            <td colspan="2" class="text-center" style="height: 70px">
               @if ($absenceemp->status == 1 || $absenceemp->status == 2 || $absenceemp->status == 3 || $absenceemp->status == 5)
                  <span class="text-success"><i>CREATED</i></span> <br>
                  {{-- <small>{{formatDateTime($absenceemp->release_date)}}</small> --}}
               @endif
            </td>
            <td class="text-center">
               @if ($absenceemp->status == 2 || $absenceemp->status == 3 || $absenceemp->status == 5 )
                  <span class="text-success"><i>APPROVED</i></span> <br>
                  {{-- <small>{{formatDateTime($absenceemp->app_backup_date)}}</small> --}}
               @endif
            </td>
            <td class="text-center">
               @if ($absenceemp->status == 3 || $absenceemp->status == 5)
                  <span class="text-success"><i>APPROVED</i></span><br>
                  {{-- <small>{{formatDateTime($absenceemp->app_leader_date)}}</small> --}}
               @endif
            </td>
            
            
         </tr>
         <tr>
            <td colspan="2">{{$absenceemp->employee->biodata->fullName() ?? ''}}</td>
            {{-- <td>
               @if ($absenceemp->cuti_backup != null)
               {{$absenceemp->cuti_backup->biodata->fullName() ?? ''}}
               @endif
            </td> --}}
            <td>
               @if ($absenceemp->leader_id != null)
               {{$absenceemp->leader->biodata->fullName() ?? ''}}
               @endif
            </td>
            <td>
               @if ($absenceemp->manager_id != null)
               {{$absenceemp->manager->biodata->fullName() ?? ''}}
               @endif
            </td>
            
         </tr>
         <tr>
            <td colspan="2" class="text-truncate">
               @if ($absenceemp->status == 1 || $absenceemp->status == 2 || $absenceemp->status == 3 || $absenceemp->status == 5)
                  <small>{{formatDateTime($absenceemp->release_date)}}</small>
               @endif
            </td>
            <td class="text-truncate">
               @if ($absenceemp->status == 2 || $absenceemp->status == 3 || $absenceemp->status == 5)
                  <small>{{formatDateTime($absenceemp->app_backup_date)}}</small>
               @endif
            </td>
            <td class="text-truncate">
               @if ($absenceemp->status == 3 || $absenceemp->status == 5)
                  <small>{{formatDateTime($absenceemp->app_leader_date)}}</small>
               @endif
            </td>
            
            
         </tr>
      </tbody>
    </table>
</div>
    <hr>
@endif

@if ($absenceemp->type == 10)
<div class="table-responsive">
    <table>
      <tbody>
         <tr>
            <td class="text-center" colspan="2" rowspan="2">
               <img src="{{asset('img/logo/enc1.png')}}" alt="" width="100">
            </td>
            <td class="text-center" colspan="2">
               <h4>FORMULIR</h4>
            </td>
            <td class="text-center" colspan="2" rowspan="2">
               <img src="{{asset('img/logo/ekanuri.png')}}" alt="" width="100"><br>
               <span>PT Ekanuri</span>
            </td>
         </tr>
         <tr class="text-center">
            <td colspan="2"><h4>SURAT IZIN RESMI</h4></td>
         </tr>
         <tr>
            <td style="width: 20px"></td>
            <td colspan="1" style="width: 250px">Nama</td>
            <td colspan="4" class="">{{$absenceemp->employee->biodata->fullName() ?? ''}}</td>
         </tr>
         <tr>
            <td style="width: 20px"></td>
            <td colspan="1">NIK</td>
            <td colspan="4" class="">{{$absenceemp->employee->nik}}</td>
         </tr>
         {{-- <tr>
            <td style="width: 20px"></td>
            <td colspan="1">Departemen</td>
            <td colspan="4" class="">{{$absenceemp->employee->department->name}}</td>
         </tr> --}}
         <tr>
            <td style="width: 20px"></td>
            <td colspan="1">Jabatan</td>
            <td colspan="4" class="">{{$absenceemp->employee->position->name}}</td>
         </tr>
         <tr>
            <td colspan="6"></td>
         </tr>
         <tr>
            <td style="width: 20px"></td>
            <td colspan="1">Izin</td>
            <td colspan="4" class="">{{$absenceemp->permit->name}}</td>
         </tr>
         <tr>
            <td style="width: 20px"></td>
            <td colspan="5">Tanggal</td>
            {{-- <td colspan="4" class="">
               @if (count($absdetails) > 0)
               @foreach ($absdetails as $detail)
                  {{formatDate($detail->date)}}
               @endforeach
               
               @else
               Tanggal belum dipilih
               @endif
            </td> --}}
         </tr>
         @foreach ($absdetails as $item)
         <tr>
            <td style="width: 20px"></td>
            <td></td>
            <td colspan="4">{{formatDate($item->date)}}</td>
         </tr>
             
         @endforeach
         <tr>
            <td colspan="6"></td>
         </tr>

         <tr>
            <td colspan="6">Jakarta, {{formatDate($absenceemp->date)}}</td>
         </tr>
         <tr>
            <td colspan="2" class="bg-dark text-light text-truncate">Diajukan Oleh :</td>
            <td class="bg-dark text-light text-truncate">Disetujui Oleh :</td>
            <td class="bg-dark text-light text-truncate">Disetujui Oleh :</td>
            
            
         </tr>
         <tr>
            <td colspan="2" class="text-center" style="height: 70px">
               @if ($absenceemp->status == 1 || $absenceemp->status == 2 || $absenceemp->status == 3 || $absenceemp->status == 5)
                  <span class="text-success"><i>CREATED</i></span> <br>
                  {{-- <small>{{formatDateTime($absenceemp->release_date)}}</small> --}}
               @endif
            </td>
            <td class="text-center">
               @if ($absenceemp->status == 2 || $absenceemp->status == 3 || $absenceemp->status == 5 )
                  <span class="text-success"><i>APPROVED</i></span> <br>
                  {{-- <small>{{formatDateTime($absenceemp->app_backup_date)}}</small> --}}
               @endif
            </td>
            <td class="text-center">
               @if ($absenceemp->status == 3 || $absenceemp->status == 5)
                  <span class="text-success"><i>APPROVED</i></span><br>
                  {{-- <small>{{formatDateTime($absenceemp->app_leader_date)}}</small> --}}
               @endif
            </td>
            
            
         </tr>
         <tr>
            <td colspan="2">{{$absenceemp->employee->biodata->fullName() ?? ''}}</td>
            {{-- <td>
               @if ($absenceemp->cuti_backup != null)
               {{$absenceemp->cuti_backup->biodata->fullName() ?? ''}}
               @endif
            </td> --}}
            <td>
               @if ($absenceemp->leader_id != null)
               {{$absenceemp->leader->biodata->fullName() ?? ''}}
               @endif
            </td>
            <td>
               @if ($absenceemp->manager_id != null)
               {{$absenceemp->manager->biodata->fullName() ?? ''}}
               @endif
            </td>
            
         </tr>
         <tr>
            <td colspan="2" class="text-truncate">
               @if ($absenceemp->status == 1 || $absenceemp->status == 2 || $absenceemp->status == 3 || $absenceemp->status == 5)
                  <small>{{formatDateTime($absenceemp->release_date)}}</small>
               @endif
            </td>
            <td class="text-truncate">
               @if ($absenceemp->status == 2 || $absenceemp->status == 3 || $absenceemp->status == 5)
                  <small>{{formatDateTime($absenceemp->app_backup_date)}}</small>
               @endif
            </td>
            <td class="text-truncate">
               @if ($absenceemp->status == 3 || $absenceemp->status == 5)
                  <small>{{formatDateTime($absenceemp->app_leader_date)}}</small>
               @endif
            </td>
            
            
         </tr>
         {{-- <tr>
            <td colspan="2">
               <table>
                  <tbody>
                     <tr class="bg-dark text-light">
                        <td>Karyawan</td>
                     </tr>
                     <tr>
                        <td style="height: 100px" class="text-center">
   
                           @if ($absenceemp->status >= 3)
                                 <small class="text-success"><i>CREATED</i></small> <br>
                                 <small class="text-muted">{{formatDateTime($absenceemp->app_leader_date)}}</small>
                           @endif
                        </td>
                     </tr>
                     <tr>
                        <td>
                        Nama : {{$absenceemp->employee->biodata->fullName()}}
                     </td>
                     </tr>
   
                  </tbody>
               </table>
              
            </td>
         </tr> --}}
      </tbody>
    </table>
</div>
    <hr>
@endif


         
         {{-- {{$absenceemp->doc}} --}}
         @if ($absenceemp->doc != null)
            <iframe width="100%" src="/storage/{{$absenceemp->doc}}" style="width:100%; height:570px;" frameborder="0"></iframe>
         @endif
         

        