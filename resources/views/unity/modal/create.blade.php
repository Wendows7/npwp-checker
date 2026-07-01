 {{-- start create modal --}}
 <div class="modal fade" tabindex="-1" role="dialog" id="createModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Kesatuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('unities.create')}}" class="needs-validation" novalidate="">
          @csrf
          <div class="card-body">
              <div class="form-group ">
                  <label>Nama</label>
                  <input type="text" name="name" class="form-control"  value="{{ old('name') }}" required="">
                  <div class="invalid-feedback">
                    Harap isi form ini
                  </div>
                </div>
              </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>
