{{-- Modal for updating order status --}}
@foreach($partnerships as $data)
    <div class="modal fade" id="updateStatusModal{{ $data->id }}" tabindex="-1" aria-labelledby="updateStatusLabel{{ $data->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('admin.partnerships.update') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="id" value="{{$data->id}}">
                    <div class="modal-header" style="background: linear-gradient(90deg, #4e54c8 0%, #8f94fb 100%);">
                        <h5 class="modal-title text-white" id="updateStatusLabel{{ $data->id }}">
                            Update Status for proposal {{ $data->name }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-light">
                        <div class="mb-3">
                            <label for="statusSelect{{ $data->id }}" class="form-label">Status</label>
                            <select class="form-select" id="statusSelect{{ $data->id }}" name="status" required>
                                <option value="pending" {{ $data->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $data->status == 'approved' ? 'selected' : '' }}>Approve</option>
                                <option value="rejected" {{ $data->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
