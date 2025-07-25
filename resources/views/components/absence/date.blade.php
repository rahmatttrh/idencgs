@if ($absence->type == 5 || $absence->type == 10)
      @if (count($absence->details) > 0)
            @if (count($absence->details) > 1)
                  {{-- {{count($absence->details)}} Hari --}}
                  {{-- @foreach ($absence->details->first()->date  as $item)
                  {{$item->date}} ,
                  @endforeach --}}
                  {{$absence->details->first()->date}}
                  @else
                  @foreach ($absence->details  as $item)
                  {{-- {{$item->date}}  --}}
                  {{$absence->details->first()->date}}
                  @endforeach
            @endif
            
         @else
         {{-- Tanggal belum dipilih --}}
      @endif
   {{-- {{count($absence->details)}} Hari --}}
      @else
      {{$absence->date}}
@endif