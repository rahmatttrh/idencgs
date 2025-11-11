@if ($employee->user->hasRole('HRD-Manager'))
    HRD Manager
@endif

@if ($employee->user->hasRole('HRD'))
    HRD
@endif

@if ($employee->user->hasRole('HRD-Recruitment'))
    HRD Recruitment
@endif

@if ($employee->user->hasRole('HRD-Payroll'))
    HRD Payroll
@endif

@if ($employee->user->hasRole('HRD-Admin'))
    HRD Admin
@endif
@if ($employee->user->hasRole('HRD-Kpi'))
    HRD KPI
@endif
@if ($employee->user->hasRole('HRD-KJ45'))
    HRD KJ 4-5
@endif
@if ($employee->user->hasRole('HRD-KJ12'))
    HRD KJ 1-2
@endif

@if ($employee->user->hasRole('HRD-JGC'))
    HRD JGC
@endif