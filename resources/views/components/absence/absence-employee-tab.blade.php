<div>
    <!-- resources/views/components/tab-absence.blade.php -->

    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <a class="nav-link{{ $activeTab === 'payroll.absence' ? ' active' : '' }}  {{ $activeTab === 'payroll.absence.filter.team' ? ' active' : '' }}" href="{{ route('payroll.absence') }}">Absence</a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ $activeTab === 'payroll.absence.create' ? ' active' : '' }}" href="{{ route('payroll.absence.create') }}">Pending</a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ $activeTab === 'payroll.absence.import' ? ' active' : '' }}" href="{{ route('payroll.absence.import') }}">Create</a>
        </li>
        
    </ul>

</div>