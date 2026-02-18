
{{-- start detail modal --}}
@foreach ($products as $product => $value)
    <div class="modal fade" tabindex="-1" role="dialog" id="detailModal{{ $value->id }}">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <p class="form-control-plaintext">{{ $value->name }}</p>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <p class="form-control-plaintext">{!! $value->description !!}</p>
                        </div>
                        <div class="form-group">
                            <label>Image</label><br>
                            @if ($value->image === null)
                                <img src="{{ asset('user_assets/assets/img/blank-image.jpg') }}" width="100" alt="">
                            @else
                                <img src="{{ asset($value->image) }}" width="100" alt="image_1">
                                <img src="{{ asset($value->image_2) }}" width="100" alt="image_2">
                                <img src="{{ asset($value->image_3) }}" width="100" alt="image_3">
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Sizes Price & Stock</label>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Size</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($value->stockProduct as $stock)
                                    <tr>
                                        <td>{{ $stock->size }} ML</td>
                                        <td>{{ number_format($stock->price) }}</td>
                                        <td>{{ $stock->stock }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
