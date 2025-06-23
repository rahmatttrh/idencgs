@extends('layouts.app')
@section('title')
Employee
@endsection
@section('content')

<div class="page-inner">
   <nav aria-label="breadcrumb ">
      <ol class="breadcrumb  ">
         <li class="breadcrumb-item " aria-current="page"><a href="/">Dashboard</a></li>
         <li class="breadcrumb-item active" aria-current="page">Active Employee</li>
      </ol>
   </nav>
  
   <div class="card">
      {{-- <div class="card-header">
         <h4 class="card-title">Nav Pills (Horizontal Tabs)</h4>
      </div> --}}
      <div class="card-body">
         <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
            <li class="nav-item">
               <a class="nav-link " id="pills-home-tab"  href="{{route('employee', enkripRambo('active'))}}" >Daftar Karyawan</a>
            </li>
            <li class="nav-item">
               <a class="nav-link active" id="pills-profile-tab" href="{{route('employee.contract')}}">Riwayat Kontrak</a>
            </li>
         </ul>
         <hr>
         <div class="tab-content mt-2 mb-3" id="pills-tabContent">
            <div class="tab-pane fade show active px-0" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
               <div class="table-responsive">
                  <table id="data" class="display basic-datatables table-sm">
                     <thead>
                        <tr>
                           
                           
                           <th>NIK</th>
                           <th>Name</th>
                           <th>Level</th>
                           <th>Type</th>
                           
                           <th>Active Contract</th>
                        </tr>
                     </thead>
                    
                     <tbody>
                        @foreach ($employees as $employee)
                        <tr>
                          
                           
                           <td class="text-truncate">{{$employee->nik}}</td>
                           {{-- <td><a href="{{route('employee.detail', enkripRambo($employee->id))}}">{{$employee->name}}</a> </td> --}}
                           <td class="text-truncate" style="max-width: 220px">
                              <div>
                                 <a href="{{route('employee.detail', [enkripRambo($employee->id), enkripRambo('basic')])}}">{{$employee->biodata->first_name ?? ''}} {{$employee->biodata->last_name ?? ''}}</a> 
                                 {{-- <small class="text-muted">{{$employee->biodata->email}}</small> --}}
                              </div>
                             
                           </td>
                          
                           <td class="text-truncate">{{$employee->position->name ?? ''}}</td>
                           <td>{{$employee->contract->type}}</td>
                          
                           <td>
                              @if ($employee->contract->type == 'Kontrak')
                              {{formatDate($employee->contract->start)}} - {{formatDate($employee->contract->end)}}
                                  @elseif($employee->contract->type == 'Tetap')
                                    @if ($employee->contract->determination != null)
                                    {{formatDate($employee->contract->determination)}}
                                    @else
                                    <small>TanggalPenetapan Kosong</small>
                                    @endif
                              @endif
                              
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                     
                  </table>
               </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
               <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
               <p>The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen. She packed her seven versalia, put her initial into the belt and made herself on the way.
               </p>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
               <p>Pityful a rethoric question ran over her cheek, then she continued her way. On her way she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word "and" and the Little Blind Text should turn around and return to its own, safe country.</p>

               <p> But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their</p>
            </div>
         </div>
      </div>
   </div>

   
   
</div>

<div class="modal fade" id="modal-export" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Export Excel</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         
         <div class="modal-body">

           
            
         </div>
         <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">SIMPLE DATA</button> --}}
            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
            <a  href="{{route('employee.export.simple')}}" class="btn btn-info">SIMPLE DATA</a>
            <a  href="{{route('employee.export')}}" class="btn btn-primary">FULL DATA</a>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>
   

   $(document).ready(function() {
      $('.tanggal').datepicker({
         format: "yyyy-mm-dd",
         autoclose: true
      });
   });

   var total = document.getElementById("total");

   $(function() {

      $("#selectall").change(function() {
         if (this.checked) {
            $(".case").each(function() {
               this.checked = true;
            });
            var jumlahCheck = $(".case").length;
         } else {
            $(".case").each(function() {
               this.checked = false;
            });
            var jumlahCheck = 0;
         }

         // menampilkan output ke elemen hasil
         total.innerHTML = jumlahCheck;
         // console.log(jumlahCheck);
      });

      $(".case").click(function() {
         if ($(this).is(":checked")) {
            var isAllChecked = 0;
            var jumlahCheck = $('input:checkbox:checked').length;

            $(".case").each(function() {
               if (!this.checked)
                  isAllChecked = 1;
            });

            if (isAllChecked == 0) {
               $("#selectall").prop("checked", true);

               jumlahCheck = $(".case").length;
            }


         } else {
            $("#selectall").prop("checked", false);

            jumlahCheck = $('input:checkbox:checked').length;
         }
         total.innerHTML = jumlahCheck;
         console.log(jumlahCheck);

      });


   });
</script>
@endsection