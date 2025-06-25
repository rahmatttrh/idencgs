<div class="modal fade" id="modal-doc-mutation-{{$mutation->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">SK Mutasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         {{-- <form action="{{route('mutation.update')}}" method="POST"  enctype="multipart/form-data"> --}}
            <div class="modal-body">
               
                  {{-- <h1>FILE</h1> --}}

                  <iframe height="550px" width="100%" src="{{asset('storage/' . $mutation->doc)}}" frameborder="0"></iframe>
                  
                  

                  
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               {{-- <button type="submit" class="btn btn-dark ">Update</button> --}}
            </div>
         {{-- </form> --}}
      </div>
   </div>
</div>

