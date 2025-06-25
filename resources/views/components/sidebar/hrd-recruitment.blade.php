


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
            <a href="{{route('qpe.create')}}">
               <span class="sub-item">Create PE</span>
            </a>
         </li>
         <li>
            <a href="{{route('qpe')}}">
               <span class="sub-item">Daftar PE</span>
            </a>
         </li>
         <li>
            <a href="{{route('qpe.report')}}">
               <span class="sub-item">Monitoring</span>
            </a>
         </li>
         <hr>
         {{-- @if (auth()->user()->hasRole('Administrator|HRD')) --}}
         <li>
            <a href="{{route('pe.component')}}">
               <span class="sub-item">Component</span>
            </a>
         </li>
         <li>
            <a href="{{route('discipline')}}">
               <span class="sub-item">Discipline</span>
            </a>
         </li>
         {{-- @endif --}}
         <li>
            <a href="{{route('kpi')}}">
               <span class="sub-item">KPI</span>
            </a>
         </li>
         
      </ul>
   </div>
</li>
{{-- Employee --}}
<li class="nav-item">
   <a data-toggle="collapse" href="#employee">
      <i class="fas fa-users"></i>
      <p>Data Karyawan</p>
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
            <a href="{{route('employee.import')}}">
               <span class="sub-item">Import</span>
            </a>
         </li>

      </ul>
   </div>
</li>

<li class="nav-item {{ (request()->is('payroll/absence/*')) ? 'active' : '' }}">
   <a href="{{route('payroll.absence')}}">
      <i class="fas fa-calendar-minus"></i>
      <p>Absensi Karyawan</p>
   </a>
</li>
<li class="nav-item {{ (request()->is('payroll/spkl/*')) ? 'active' : '' }}">
   <a href="{{route('payroll.overtime')}}">
      <i class="fas fa-calendar-plus"></i>
      <p>SPKL Karyawan</p>
   </a>
</li>
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
<li class="nav-item {{ (request()->is('announcement/*')) ? 'active' : '' }}">
   <a href="{{route('announcement')}}">
      <i class="fas fa-bell"></i>
      <p>Anouncement</p>
   </a>
</li> 

@if (auth()->user()->hasRole('Leader'))
<li class="nav-section">
   <span class="sidebar-mini-icon">
      <i class="fa fa-ellipsis-h"></i>
   </span>
   <h4 class="text-section">Team</h4>
</li>
{{-- <li class="nav-item {{ (request()->is('task/*')) ? 'active' : '' }}">
   <a href="{{route('task')}}">
      <i class="fas fa-calendar"></i>
      <p>Task List</p>
   </a>
</li> --}}


<li class="nav-item {{ (request()->is('overtime/team')) ? 'active' : '' }}">
   <a href="{{route('overtime.team')}}">
      <i class="fas fa-file-code"></i>
      <p>Summary</p>
   </a>
</li>
@endif


<li class="nav-section">
   <span class="sidebar-mini-icon">
      <i class="fa fa-ellipsis-h"></i>
   </span>
   <h4 class="text-section">Personal</h4>
</li>






{{-- <li class="nav-item {{ (request()->is('qpe')) ? 'active' : '' }}">
   <a href="{{route('qpe')}}">
      <i class="fas fa-file"></i>
      <p>KPI Saya</p>
   </a>
</li> --}}
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
<li class="nav-item {{ (request()->is('employee/payroll/*')) ? 'active' : '' }}">
   <a href="#">
      {{-- <a href="{{route('payroll.transaction.employee')}}"> --}}
      <i class="fas fa-coins"></i>
      <p>Payslip </p>
   </a>
</li>
<li class="nav-item {{ (request()->is('employee/sp/*')) ? 'active' : '' }}">
   <a href="{{route('sp.employee')}}">
      <i class="fas fa-bolt"></i>
      <p>Surat Peringatan</p>
   </a>
</li>



