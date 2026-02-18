

{{-- start edit modal --}}
@foreach ($data as $key => $value)

<div class="modal fade" tabindex="-1" role="dialog" id="editModal{{ $value->id }}">
  <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title">Edit User</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body">
       <form method="post" action="{{ route('admin.payments.update')}}" class="needs-validation" novalidate="">
         @method('put')
         @csrf
           <input type="hidden" name="id" value="{{$value->id}}">
         <div class="card-body">
             <div class="form-group ">
                 <label>Name</label>
                 <input type="text" name="name" class="form-control"  value="{{ old('name', $value->name) }}" required="">
                 <div class="invalid-feedback">
                   Please fill this form
                 </div>
               </div>
             <div class="form-group ">
                 <label>Number</label>
                 <input type="number" name="number" class="form-control"  value="{{ old('number', $value->number) }}" required="">
                 <div class="invalid-feedback">
                   Please fill this form
                 </div>
               </div>
         </div>
       </div>
       <div class="modal-footer bg-whitesmoke br">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <button type="submit" class="btn btn-primary">Update</button>
       </div>
     </form>
   </div>
 </div>
</div>
@endforeach
