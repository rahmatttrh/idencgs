@if ($form->status == 0)
    Draft
    @elseif($form->status == 1)
    Approval Atasan
    @elseif($form->status == 2)
    Approval Manager
    @elseif($form->status == 3)
    Validasi HRD
    @elseif($form->status == 5)
    Published

    @elseif($form->status == 101)
    Reject Atasan
    @elseif($form->status == 202)
    Reject Manager
@endif