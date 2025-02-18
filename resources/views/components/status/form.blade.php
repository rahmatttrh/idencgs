@if ($form->status == 0)
    Draft
    @elseif($form->status == 1)
    Approval Pengganti
    @elseif($form->status == 2)
    Approval Atasan
    @elseif($form->status == 3)
    Validasi HRD
    @elseif($form->status == 5)
    Published
@endif