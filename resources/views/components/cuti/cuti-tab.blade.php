<div>
    <!-- resources/views/components/tab-absence.blade.php -->

    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <a class="nav-link{{ $activeTab === 'cuti' ? ' active' : '' }}" href="{{ route('cuti') }}">List Cuti</a>
        </li>
        <li class="nav-item">
               <a class="nav-link{{ $activeTab === 'cuti.import' ? ' active' : '' }}" href="{{ route('cuti.import') }}">Import</a>
         </li>
        {{-- <li class="nav-item">
            <a class="nav-link{{ $activeTab === 'payroll.overtime.create' ? ' active' : '' }}" href="{{ route('payroll.overtime.create') }}">Create</a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ $activeTab === 'payroll.overtime.import' ? ' active' : '' }}" href="{{ route('payroll.overtime.import') }}">Import</a>
        </li> --}}
        
    </ul>

</div>