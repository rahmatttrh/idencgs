<div>
    <!-- resources/views/components/tab-absence.blade.php -->

    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <a class="nav-link{{ $activeTab === 'overtime.team' ? ' active' : '' }}" href="{{ route('overtime.team') }}">SPKL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ $activeTab === 'absence.team' ? ' active' : '' }}" href="{{ route('absence.team') }}">Absence</a>
      </li>
        
        
    </ul>

</div>