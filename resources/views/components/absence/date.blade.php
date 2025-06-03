@if ($absence->type == 5 || $absence->type == 10)
      @if (count($absence->details) > 0)
            @if (count($absence->details) > 1)
                  {{count($absence->details)}} Hari
                  @else
                  @foreach ($absence->details  as $item)
                  {{formatDate($item->date)}} 
                  @endforeach
            @endif
            
         @else
         Tanggal belum dipilih
      @endif
   {{-- {{count($absence->details)}} Hari --}}
      @else
      {{formatDate($absence->date)}}
@endif