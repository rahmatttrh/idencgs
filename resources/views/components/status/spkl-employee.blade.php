@if ($empspkl->status == 0)
Draft
@elseif($empspkl->status == 1)
Approval Atasan
@elseif($empspkl->status == 2)
Approval Manager
@elseif($empspkl->status == 3)
Verifikasi HRD
@elseif($empspkl->status == 4)
Published

@elseif($empspkl->status == 201)
Reject Atasan
@elseif($empspkl->status == 301)
Reject Manager
@elseif($empspkl->status == 401)
Cancel HRD
@endif