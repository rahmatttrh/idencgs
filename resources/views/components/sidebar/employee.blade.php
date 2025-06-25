{{-- <li class="nav-item">
   <a data-toggle="collapse" href="#qpe">
      <!-- <a  href="{{route('qpe')}}"> -->
      <i class="fas fa-file"></i>
      <p>Quick PE</p>
      <span class="caret"></span>
   </a>
   <div class="collapse" id="qpe">
      <ul class="nav nav-collapse">
         <li>
            <a href="{{route('qpe')}}">
               <span class="sub-item">PE</span>
            </a>
         </li>
      </ul>
   </div>
</li> --}}
{{-- <li class="nav-item {{ (request()->is('employee/detail/*')) ? 'active' : '' }}">
   <a href="{{route('employee.detail', [enkripRambo(auth()->user()->getEmployeeId()), enkripRambo('contract')])}}">
      <i class="fas fa-user"></i>
      <p>My Profile</p>
   </a>
</li>
<hr> --}}
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


<li class="nav-item {{ (request()->is('employee/absence/*')) ? 'active' : '' }}">
   <a href="{{route('employee.absence')}}">
      <i class="fas fa-calendar-check"></i>
      <p>Absensi</p>
   </a>
</li>
<li class="nav-item {{ (request()->is('employee/spkl/*')) ? 'active' : '' }}">
   <a href="{{route('employee.spkl')}}">
      <i class="fas fa-clock"></i>
      <p>SPKL & Piket</p>
   </a>
</li>
<li class="nav-item {{ (request()->is('employee/cuti/*')) ? 'active' : '' }}">
   <a href="{{route('employee.cuti')}}">
      <i class="fas fa-briefcase"></i>
      <p>Info Cuti</p>
   </a>
</li>
<li class="nav-item {{ (request()->is('task/*')) ? 'active' : '' }}">
   <a href="{{route('task')}}">
      <i class="fas fa-calendar"></i>
      <p>Task List</p>
   </a>
</li>
<li class="nav-item {{ (request()->is('employee/payroll/*')) ? 'active' : '' }}">
   <a href="#" data-toggle="tooltip" data-placement="top" title="Fitur Payslip masih dalam tahap pengembangan">
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
<hr>
<li class="nav-item {{ (request()->is('pass/reset')) ? 'active' : '' }}">
   <a href="{{ route('pass.reset') }}">
      <i class="fas fa-lock"></i>
      <p>Reset Password</p>
   </a>
</li>

{{-- <li class="nav-item {{ (request()->is('employee/spt/*')) ? 'active' : '' }}">
   <a href="{{route('employee.spt')}}">
      <i class="fas fa-briefcase"></i>
      <p>SPT</p>
   </a>
</li>

<li class="nav-item">
   <a href="{{route('employee.detail', [enkripRambo(auth()->user()->employee->id), enkripRambo('contract')])}}">
      <i class="fas fa-calendar"></i>
      <p>Cuti</p>
   </a>
</li>
<li class="nav-item">
   <a href="{{route('employee.detail', [enkripRambo(auth()->user()->employee->id), enkripRambo('contract')])}}">
      <i class="fas fa-hospital"></i>
      <p>Permit</p>
   </a>
</li> --}}

