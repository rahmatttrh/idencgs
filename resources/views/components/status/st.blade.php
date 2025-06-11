@if ($st->status == 0)
    <span class="">Draft</span>
    @elseif($st->status == 1)
    <span class="">Published</span> 
    @elseif($st->status == 2)
    <span class="">Confirmed</span>
    
@endif