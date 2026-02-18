 {{-- start create modal --}}
 <div class="modal fade" tabindex="-1" role="dialog" id="createModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('admin.users.create')}}" class="needs-validation" novalidate="">
          @csrf
          <div class="card-body">
              <div class="form-group ">
                  <label>Name</label>
                  <input type="text" name="name" class="form-control"  value="{{ old('name') }}" required="">
                  <div class="invalid-feedback">
                    Please fill this form
                  </div>
                </div>
                <div class="form-group">
                  <label>Role</label>
                  <select class="form-control selectric" name="level" value="{{ old('level') }}" required="">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                  </select>
                </div>
                <div class="form-group ">
                  <label>Email</label>
                  <input type="email"  name="email" class="form-control"  value="{{ old('email') }}" required="">
                  <div class="invalid-feedback">
                    Please fill this form
                  </div>
                </div>
                <div class="form-group ">
                  <label>Password</label>
                  <input type="password" name="password" class="form-control" required="" >
                </div>
              </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>
