

{{-- @if (auth()->user()->hasRole('Supervisor|Leader'))

<div class="collapse" id="qpe">
   <ul class="nav nav-collapse">
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
   </ul>
</div>
    
@endif --}}



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