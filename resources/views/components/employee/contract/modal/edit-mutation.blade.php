<div class="modal fade" id="modal-edit-mutation-{{$mutation->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog " role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Edit Mutation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{route('mutation.update')}}" method="POST"  enctype="multipart/form-data">
            <div class="modal-body">
               @csrf
               @method('PUT')
                <input type="text" name="mutation" id="mutation" value="{{$mutation->id}}" hidden>
                <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label>Type</label>
                        <select class="form-control" id="type"  name="type" required>
                           <option {{$mutation->type == null ? 'selected' : ''}} value="" disabled >Select</option>
                           <option {{$mutation->type == 'Promosi' ? 'selected' : ''}} value="Promosi">Promosi</option>
                           <option {{$mutation->type == 'Rotasi' ? 'selected' : ''}} value="Rotasi">Rotasi</option>
                           <option {{$mutation->type == 'Demosi' ? 'selected' : ''}} value="Demosi">Demosi</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label>Date</label>
                        <input type="date" required class="form-control" name="date" id="date" value="{{$mutation->date}}" >
   
                     </div>
                  </div>
                  
                  
                  {{-- <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label>Salary</label>
                        <input type="text" class="form-control"  name="salary" id="salary" value="{{$employee->contract->salary}}">
                     </div>
                  </div> --}}
                  
               </div>

               <div class="form-group form-group-default">
                  <label>SK</label>
                  <input type="file" class="form-control"  name="sk" id="sk" value="">
               </div>
               <div class="form-group form-group-default">
                  <label>Reason</label>
                  <textarea class="form-control" name="reason" id="reason"  >{{$mutation->desc}}</textarea>

               </div>
                  
                  
                  

                  
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-dark ">Update</button>
            </div>
         </form>
      </div>
   </div>
</div>

