@if ($absence->type == 1)
Alpha
@elseif($absence->type == 2)
Terlambat ({{$absence->minute}} Menit)
@elseif($absence->type == 3)
ATL
@elseif($absence->type == 4)
Izin ({{$absence->type_izin}})
@elseif($absence->type == 5)
Cuti
@elseif($absence->type == 6)
SPT
@elseif($absence->type == 7)
Sakit 
@elseif($absence->type == 8)
Dinas Luar
@elseif($absence->type == 9)
Off Kontrak
@endif