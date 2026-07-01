

{{-- start edit modal --}}
@foreach ($data as $unities => $unity)

<div class="modal fade" tabindex="-1" role="dialog" id="editModal{{ $unity->id }}">
  <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title">Edit Pengguna</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body">
       <form method="post" action="{{ route('unities.update', ['user' => $unity->id])  }}" class="needs-validation" novalidate="">
         @method('put')
         @csrf
           <input type="hidden" name="id" value="{{$unity->id}}">
         <div class="card-body">
             <div class="form-group ">
                 <label>Nama</label>
                 <input type="text" name="name" class="form-control"  value="{{ old('name', $unity->name) }}" required="">
                 <div class="invalid-feedback">
                   Harap isi form ini
                 </div>
               </div>
             </div>
         </div>
       <div class="modal-footer bg-whitesmoke br">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
         <button type="submit" class="btn btn-primary">Update</button>
       </div>
     </form>
   </div>
 </div>
</div>
@endforeach
