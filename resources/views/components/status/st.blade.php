@if ($st->status == 0)
    <span class="">Draft</span>
    @elseif($st->status == 1)
    <span class="">Verifikasi HRD</span> 
    @elseif($st->status == 2)
    <span class="">Konfirmasi User</span>
    @elseif($st->status == 3)
    <span class="">Approval Manager</span>
    @elseif($st->status == 4)
    <span class="">Published</span>
    @elseif($st->status == 5)
    <span class="">Confirmed</span>
    @elseif($st->status == 606)
    <span class="">Reject Manager</span>
    @elseif($st->status == 505)
    <span class="">Reject HRD</span>
    @elseif($st->status == 404)
    <span class="">Reject User</span>

    @elseif($st->status == 101)
    <span class="">Discussion Proccess</span>
    @elseif($st->status == 202)
    <span class="">Complain Proccess</span>
@endif