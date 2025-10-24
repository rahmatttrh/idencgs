

<li class="nav-section">
   <span class="sidebar-mini-icon">
      <i class="fa fa-ellipsis-h"></i>
   </span>
   <h4 class="text-section">HRD</h4>
</li>
<li class="nav-item">
   <a data-toggle="collapse" href="#vessel">
      <i class="fas fa-server"></i>
      <p>Master Data</p>
      <span class="caret"></span>
   </a>
   <div class="collapse" id="vessel">
      <ul class="nav nav-collapse">
         <li>
            <a href="{{route('unit')}}">
               <span class="sub-item">Bisnis Unit</span>
            </a>
         </li>
         {{-- <li>
            <a href="{{route('department')}}">
               <span class="sub-item">Department</span>
            </a>
         </li> --}}
         <li>
            <a href="{{route('designation')}}">
               <span class="sub-item">Level</span>
            </a>
         </li>
         <li>
            <a href="{{route('cuti')}}">
               <span class="sub-item">Cuti Karyawan</span>
            </a>
         </li>
         <li>
            <a href="{{route('project')}}">
               <span class="sub-item">Project</span>
            </a>
         </li>
         <li>
            <a href="{{route('permit')}}">
               <span class="sub-item">Izin Resmi</span>
            </a>
         </li>
         {{-- <li>
            <a href="{{route('position')}}">
               <span class="sub-item">Jabatan</span>
            </a>
         </li> --}}
         {{-- <li>
            <a href="{{route('so')}}">
               <span class="sub-item">Struktur Organisasi</span>
            </a>
         </li> --}}
      </ul>
   </div>
</li>
<li class="nav-item">
   <a data-toggle="collapse" href="#qpe">
      <!-- <a  href="{{route('qpe')}}"> -->
      <i class="fas fa-star"></i>
      <p>PE</p>
      <span class="caret"></span>
   </a>
   <div class="collapse" id="qpe">
      <ul class="nav nav-collapse">
         
         
         <li>
            <a href="{{route('discipline')}}">
               <span class="sub-item">Discipline</span>
            </a>
         </li>
         
         
      </ul>
   </div>
</li>
<li class="nav-item">
   <a data-toggle="collapse" href="#employee">
      <i class="fas fa-users"></i>
      <p>Employee</p>
      <span class="caret"></span>
   </a>
   <div class="collapse" id="employee">
      <ul class="nav nav-collapse">
         <li>
            <a href="{{route('employee', enkripRambo('active'))}}">
               <span class="sub-item">Active</span>
            </a>
         </li>
         <li>
            <a href="{{route('employee.nonactive')}}">
               <span class="sub-item">Non Active</span>
            </a>
         </li>
         

         <li>
            <a href="{{route('employee.draft')}}">
               <span class="sub-item">Draft</span>
            </a>
         </li>
         <li>
            <a href="{{route('employee.create')}}">
               <span class="sub-item">Create</span>
            </a>
         </li>
         <li>
            <a href="{{route('employee.import')}}">
               <span class="sub-item">Import by Excel</span>
            </a>
         </li>

      </ul>
   </div>
</li>

<li class="nav-item">
   <a data-toggle="collapse" href="#payroll">
      <i class="fas fa-coins"></i>
      <p>Payroll</p>
      <span class="caret"></span>
   </a>
   <div class="collapse" id="payroll">
      <ul class="nav nav-collapse">
         <li>
            <a href="{{route('payroll.transaction')}}">
               <span class="sub-item">Transaction</span>
            </a>
         </li>
         <li>
            <a href="{{route('payroll.overtime')}}">
               <span class="sub-item">SPKL</span>
            </a>
         </li>

         <li>
            <a href="{{route('payroll.absence')}}">
               <span class="sub-item">Absence</span>
            </a>
         </li>

         <li>
            <a href="{{route('payroll.additional')}}">
               <span class="sub-item">Others</span>
            </a>
         </li>
      </ul>
   </div>
</li>

<li class="nav-item {{ (request()->is('payroll/setup/*')) ? 'active' : '' }}">
   <a data-toggle="collapse" href="#setpayroll">
      <i class="fas fa-cog"></i>
      <p>Setup Payroll</p>
      <span class="caret"></span>
   </a>
   <div class="collapse" id="setpayroll">
      <ul class="nav nav-collapse">
         {{-- <li>
            <a href="{{route('payroll.transaction')}}">
               <span class="sub-item">Transaction</span>
            </a>
         </li> --}}
         {{-- <li>
            <a href="{{route('payroll.overtime')}}">
               <span class="sub-item">SPKL</span>
            </a>
         </li> --}}
         {{-- <li>
            <a href="{{route('holiday')}}">
               <span class="sub-item">Libur Nasional</span>
            </a>
         </li> --}}
         {{-- <li>
            <a href="{{route('payroll.setup')}}">
               <span class="sub-item">Setup</span>
            </a>
         </li> --}}
         <li>
            <a href="{{route('payroll')}}">
               <span class="sub-item">Gaji Karyawan</span>
            </a>
         </li>
         <li>
            <a href="{{route('payroll.unit')}}">
               <span class="sub-item">Potongan Unit</span>
            </a>
         </li>
         
         

      </ul>
   </div>
</li>

{{-- <li class="nav-item {{ (request()->is('cuti/*')) ? 'active' : '' }}">
   <a href="{{route('cuti')}}">
      <i class="fas fa-calendar"></i>
      <p>Cuti</p>
   </a>
</li> --}}
{{-- <li class="nav-item {{ (request()->is('payroll/perdin/*')) ? 'active' : '' }}">
   <a href="{{route('perdin')}}">
      <i class="fas fa-calendar"></i>
      <p>Perdin</p>
   </a>
</li> --}}

<li class="nav-item">
   <a data-toggle="collapse" href="#sp">
      <i class="fas fa-bolt"></i>
      <p>Surat Peringatan</p>
      <span class="caret"></span>
   </a>
   <div class="collapse" id="sp">
      <ul class="nav nav-collapse">
         <li>
            <a href="{{route('sp')}}">
               <span class="sub-item">SP</span>
            </a>
         </li>
         <li>
            <a href="{{route('st')}}">
               <span class="sub-item">Teguran</span>
            </a>
         </li>

         {{-- <li>
            <a href="{{route('payroll.absence')}}">
               <span class="sub-item">Absence</span>
            </a>
         </li>

         <li>
            <a href="{{route('payroll.additional')}}">
               <span class="sub-item">Others</span>
            </a>
         </li> --}}
      </ul>
   </div>
</li>

{{-- <li class="nav-item {{ (request()->is('sp/*')) ? 'active' : '' }}">
   <a href="{{route('sp')}}">
      <i class="fas fa-bolt"></i>
      <p>Surat Peringatan</p>
   </a>
</li> --}}



{{-- <li class="nav-section">
   <span class="sidebar-mini-icon">
      <i class="fa fa-ellipsis-h"></i>
   </span>
   <h4 class="text-section">Employee</h4>
</li>
<li class="nav-item {{ (request()->is('employee/tab/*')) ? 'active' : '' }}">
   <a href="{{route('employee', enkripRambo('active'))}}">
      <i class="fas fa-users"></i>
      <p>Active</p>
   </a>
</li>
<li class="nav-item {{ (request()->is('employee/nonactive')) ? 'active' : '' }}">
   <a href="{{route('employee.nonactive')}}">
      <i class="fas fa-users"></i>
      <p>Non Active</p>
   </a>
</li>
<li class="nav-item {{ (request()->is('employee/draft')) ? 'active' : '' }}">
   <a href="{{route('employee.draft')}}">
      <i class="fas fa-users"></i>
      <p>Draft</p>
   </a>
</li>
<li class="nav-item {{ (request()->is('employee/import')) ? 'active' : '' }}">
   <a href="{{route('employee.import')}}">
      <i class="fas fa-download"></i>
      <p>Import</p>
   </a>
</li> --}}
{{-- Employee --}}
{{-- <li class="nav-item">
   <a data-toggle="collapse" href="#employee">
      <i class="fas fa-users"></i>
      <p>Employee</p>
      <span class="caret"></span>
   </a>
   <div class="collapse" id="employee">
      <ul class="nav nav-collapse">
         <li>
            <a href="{{route('employee', enkripRambo('active'))}}">
               <span class="sub-item">Active</span>
            </a>
         </li>
         <li>
            <a href="{{route('employee.nonactive')}}">
               <span class="sub-item">Non Active</span>
            </a>
         </li>
         <li>
            <a href="{{route('employee.draft')}}">
               <span class="sub-item">Import</span>
            </a>
         </li>

      </ul>
   </div>
</li> --}}
<hr>
<li class="nav-section">
   <span class="sidebar-mini-icon">
      <i class="fa fa-ellipsis-h"></i>
   </span>
   <h4 class="text-section">Personal</h4>
</li>
<li class="nav-item {{ (request()->is('employee/absence/*')) ? 'active' : '' }}">
   <a href="{{route('employee.absence')}}">
      <i class="fas fa-calendar-check"></i>
      <p>Absensi </p>
   </a>
</li>
<li class="nav-item {{ (request()->is('employee/spkl/*')) ? 'active' : '' }}">
   <a href="{{route('employee.spkl')}}">
      <i class="fas fa-clock"></i>
      <p>SPKL & Piket</p>
   </a>
</li>
<li class="nav-item {{ (request()->is('task/*')) ? 'active' : '' }}">
   <a href="{{route('task')}}">
      <i class="fas fa-calendar"></i>
      <p>Task List</p>
   </a>
</li>
<li class="nav-item {{ (request()->is('employee/cuti/*')) ? 'active' : '' }}">
   <a href="{{route('employee.cuti')}}">
      <i class="fas fa-briefcase"></i>
      <p>Info Cuti</p>
   </a>
</li>

{{-- <li class="nav-item {{ (request()->is('employee/payroll/*')) ? 'active' : '' }}">
   <a href="{{route('payroll.transaction.employee')}}" data-toggle="tooltip" data-placement="top" title="Fitur Payslip masih dalam tahap pengembangan">
      <i class="fas fa-coins"></i>
      <p>Payslip</p>
   </a>
</li> --}}

@if ($employee->pin != null)
<li class="nav-item {{ (request()->is('employee/payroll/*')) ? 'active' : '' }}">
   <a href="#" data-target="#modal-pin-payslip" data-toggle="modal">
      <i class="fas fa-coins"></i>
      <p>Payslip</p>
   </a>
</li>
    @else
    <li class="nav-item {{ (request()->is('employee/payroll/*')) ? 'active' : '' }}">
      <a href="#" data-target="#modal-create-pin-payslip" data-toggle="modal">
         <i class="fas fa-coins"></i>
         <p>Payslip</p>
      </a>
   </li>
@endif

<li class="nav-item {{ (request()->is('employee/sp/*')) ? 'active' : '' }}">
   <a href="{{route('sp.employee')}}">
      <i class="fas fa-bolt"></i>
      <p>Surat Peringatan</p>
   </a>
</li>
{{-- <li class="nav-item {{ (request()->is('employee/sp/*')) ? 'active' : '' }}">
   <a href="{{route('sp')}}">
      <i class="fas fa-file"></i>
      <p>SP</p>
   </a>
</li> --}}