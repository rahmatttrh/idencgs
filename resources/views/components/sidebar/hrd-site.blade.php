
<li class="nav-section">
   <span class="sidebar-mini-icon">
      <i class="fa fa-ellipsis-h"></i>
   </span>
   <h4 class="text-section">HRD</h4>
</li>

@if (auth()->user()->hasRole('HRD-JGC'))
    @else
    <li class="nav-item {{ (request()->is('payroll/overtime/*')) ? 'active' : '' }}">
      <a href="{{route('payroll.overtime')}}">
         <i class="fas fa-calendar-plus"></i>
         <p>SPKL Karyawan</p>
      </a>
   </li>
@endif

<li class="nav-item {{ (request()->is('payroll/absence/*')) ? 'active' : '' }}">
   <a href="{{route('payroll.absence')}}">
      <i class="fas fa-calendar-plus"></i>
      <p>Absensi Karyawan</p>
   </a>
</li>
{{-- <li class="nav-item {{ (request()->is('sp/*')) ? 'active' : '' }}">
   <a href="{{route('sp')}}">
      <i class="fas fa-file-code"></i>
      <p>SP Karyawan</p>
   </a>
</li> --}}
{{-- <li class="nav-item {{ (request()->is('payroll/absence/*')) ? 'active' : '' }}">
   <a href="{{route('payroll.absence')}}">
      <span class="sub-item">Absence</span>
   </a>
</li> --}}


<li class="nav-section">
   <span class="sidebar-mini-icon">
      <i class="fa fa-ellipsis-h"></i>
   </span>
   <h4 class="text-section">Personal</h4>
</li>

<li class="nav-item {{ (request()->is('qpe')) ? 'active' : '' }}">
   <a href="{{route('qpe')}}">
      <i class="fas fa-star"></i>
      <p>PE</p>
   </a>
</li>
<li class="nav-item {{ (request()->is('task/*')) ? 'active' : '' }}">
   <a href="{{route('task')}}">
      <i class="fas fa-calendar"></i>
      <p>Task</p>
   </a>
</li>

{{-- <li class="nav-item {{ (request()->is('employee/spkl/*')) ? 'active' : '' }}">
   <a href="{{route('employee.spkl')}}">
      <i class="fas fa-clock"></i>
      <p>SPKL</p>
   </a>
</li> --}}
<li class="nav-item {{ (request()->is('employee/absence/*')) ? 'active' : '' }}">
   <a href="{{route('employee.absence')}}">
      <i class="fas fa-calendar-check"></i>
      <p>Absensi</p>
   </a>
</li>
<li class="nav-item {{ (request()->is('employee/cuti/*')) ? 'active' : '' }}">
   <a href="{{route('employee.cuti')}}">
      <i class="fas fa-briefcase"></i>
      <p>Info Cuti </p>
   </a>
</li>
<li class="nav-item {{ (request()->is('employee/payroll/*')) ? 'active' : '' }}">
   <a href="#" data-placement="top" title="Fitur Payslip masih dalam tahap pengembangan">
      <i class="fas fa-coins"></i>
      <p>Payslip</p>
   </a>
</li>
<li class="nav-item {{ (request()->is('employee/sp/*')) ? 'active' : '' }}">
   <a href="{{route('sp.employee')}}">
      <i class="fas fa-bolt"></i>
      <p>Surat Peringatan</p>
   </a>
</li>
{{-- <li class="nav-item {{ (request()->is('employee/sp/*')) ? 'active' : '' }}">
   <a href="#">
      <i class="fas fa-file"></i>
      <p>SP</p>
   </a>
</li> --}}
<hr>
<li class="nav-item {{ (request()->is('pass/reset')) ? 'active' : '' }}">
   <a href="{{ route('pass.reset') }}">
      <i class="fas fa-lock"></i>
      <p>Reset Password</p>
   </a>
</li>


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