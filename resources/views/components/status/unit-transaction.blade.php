@if ($unittrans->status == 0)
    <span class="">Draft</span>
    @elseif($unittrans->status == 1)
    <span class="">Approval HRD Man.</span> 
    @elseif($unittrans->status == 2)
    <span class="">Approval Finance Man.</span>
    @elseif($unittrans->status == 3)
    <span class="">Approval GM</span>
    @elseif($unittrans->status == 4)
    <span class="">Approval Direksi</span>

    @elseif($unittrans->status == 5)
    <span class="">Complete</span>
    @elseif($unittrans->status == 6)
    <span class="">Published</span>

    @elseif($unittrans->status == 101 || $unittrans->status == 202 || $unittrans->status == 303 || $unittrans->status == 404)
    <span class="">Reject</span>
@endif