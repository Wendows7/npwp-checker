{{-- Modal for updating order status --}}
@foreach($orders as $order)
    <div class="modal fade" id="updateStatusModal{{ $order['order_code'] }}" tabindex="-1" aria-labelledby="updateStatusLabel{{ $order['order_code'] }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('admin.orders.update') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="order_code" value="{{$order['order_code']}}">
                    <div class="modal-header" style="background: linear-gradient(90deg, #4e54c8 0%, #8f94fb 100%);">
                        <h5 class="modal-title text-white" id="updateStatusLabel{{ $order['order_code'] }}">
                            Update Status for Order #{{ $order['order_code'] }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-light">
                        <div class="mb-3">
                            <label for="statusSelect{{ $order['order_code'] }}" class="form-label">Order Status</label>
                            <select class="form-select" id="statusSelect{{ $order['order_code'] }}" name="status" required>
                                <option value="cancel" {{ $order['status'] == 'cancel' ? 'selected' : '' }}>Cancel</option>
                                <option value="failed" {{ $order['status'] == 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="deny" {{ $order['status'] == 'deny' ? 'selected' : '' }}>Deny</option>
                                <option value="pending" {{ $order['status'] == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $order['status'] == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="packaged" {{ $order['status'] == 'packaged' ? 'selected' : '' }}>Packaged</option>
                                <option value="sending" {{ $order['status'] == 'sending' ? 'selected' : '' }}>Sending</option>
                                <option value="done" {{ $order['status'] == 'done' ? 'selected' : '' }}>Done</option>
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
