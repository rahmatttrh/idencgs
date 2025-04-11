@if (auth()->user()->hasRole('HRD-Spv|HRD|HRD-Recruitment'))
<li class="nav-item {{ (request()->is('master/*')) ? 'active' : '' }}">
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

{{-- Performance --}}


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
            <a href="{{route('employee.draft')}}">
               <span class="sub-item">Import by Excel</span>
            </a>
         </li>

      </ul>
   </div>
</li>


<li class="nav-item">
   <a data-toggle="collapse" href="#kpi">
      <i class="fas fa-file-contract"></i>
      <p>Performance</p>
      <span class="caret"></span>
   </a>
   <div class="collapse" id="kpi">
      <ul class="nav nav-collapse">
         
         <li>
            <a href="{{route('discipline')}}">
               <span class="sub-item">Discipline</span>
            </a>
         </li>
         @if (auth()->user()->hasRole('Supervisor|Leader'))
         <li>
            <a href="{{route('kpi')}}">
               <span class="sub-item">KPI</span>
            </a>
         </li>
         @endif
      </ul>
   </div>
</li>
@endif

{{-- <li class="nav-item">
   <a data-toggle="collapse" href="#kpi">
      <i class="fas fa-file-contract"></i>
      <p>Performance</p>
      <span class="caret"></span>
   </a>
   <div class="collapse" id="kpi">
      <ul class="nav nav-collapse">
         @if (auth()->user()->hasRole('HRD-Spv|HRD|HRD-Recruitment'))
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
         @endif
         <li>
            <a href="{{route('kpi')}}">
               <span class="sub-item">KPI</span>
            </a>
         </li>
       
      </ul>
   </div>
</li> --}}
<li class="nav-item">
   <a data-toggle="collapse" href="#qpe">
    {{-- <a  href="{{route('qpe')}}"> --}}
      <i class="fas fa-file"></i>
      <p>Quick PE</p>
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
         @if (auth()->user()->hasRole('HRD-Spv|HRD|HRD-Recruitment'))
         <li>
            <a href="{{route('qpe.report')}}">
               <span class="sub-item">Monitoring</span>
            </a>
         </li>
         @endif
      </ul>
   </div>
</li>

@if (auth()->user()->hasRole('HRD-Spv|HRD|HRD-Recruitment'))
<li class="nav-item {{ (request()->is('payroll/absence/*')) ? 'active' : '' }}">
   <a href="{{route('payroll.absence')}}">
      <i class="fas fa-calendar-minus"></i>
      <p>Absence</p>
   </a>
</li>
<li class="nav-item {{ (request()->is('payroll/spkl/*')) ? 'active' : '' }}">
   <a href="{{route('payroll.overtime')}}">
      <i class="fas fa-calendar-plus"></i>
      <p>SPKL</p>
   </a>
</li>
<li class="nav-item {{ (request()->is('announcement/*')) ? 'active' : '' }}">
   <a href="{{route('announcement')}}">
      <i class="fas fa-money-bill"></i>
      <p>Anouncement</p>
   </a>
</li> 
<hr>

@else
<li class="nav-item {{ (request()->is('employee/cuti/*')) ? 'active' : '' }}">
   <a href="{{route('employee.cuti')}}">
      <i class="fas fa-clock"></i>
      <p>Cuti</p>
   </a>
</li>

<li class="nav-item {{ (request()->is('employee/absence/*')) ? 'active' : '' }}">
   <a href="{{route('employee.absence')}}">
      <i class="fas fa-calendar-check"></i>
      <p>Absensi</p>
   </a>
</li>
@endif
{{-- <li class="nav-item {{ (request()->is('employee/absence/*')) ? 'active' : '' }}">
   <a href="{{route('employee.absence')}}">
      <i class="fas fa-clock"></i>
      <p>Absensi</p>
   </a>
</li> --}}



<li class="nav-item {{ (request()->is('task/*')) ? 'active' : '' }}">
   <a href="{{route('task')}}">
      <i class="fas fa-calendar"></i>
      <p>Task</p>
   </a>
</li>

<li class="nav-item {{ (request()->is('sp/*')) ? 'active' : '' }}">
   <a href="{{route('sp')}}">
      <i class="fas fa-file-code"></i>
      <p>SP</p>
   </a>
</li>

<li class="nav-item {{ (request()->is('overtime/team')) ? 'active' : '' }}">
   <a href="{{route('overtime.team')}}">
      <i class="fas fa-file-code"></i>
      <p>Summary</p>
   </a>
</li>

{{-- <li class="nav-item {{ (request()->is('supervisor/spkl/*')) ? 'active' : '' }}">
   <a href="{{route('supervisor.spkl')}}">
      <i class="fas fa-clock"></i>
      <p>SPKL</p>
   </a>
</li>

<li class="nav-item {{ (request()->is('employee/spt/*')) ? 'active' : '' }}">
   <a href="{{route('employee.spt')}}">
      <i class="fas fa-briefcase"></i>
      <p>SPT</p>
   </a>
</li> --}}
{{-- <li class="nav-item {{ (request()->is('sp/*')) ? 'active' : '' }}">
<a href="{{route('sp')}}">
   <i class="fas fa-file-code"></i>
   <p>SP</p>
</a>
</li> --}}