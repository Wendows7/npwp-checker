{{-- start edit modal --}}
@foreach ($products as $product => $value)
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal{{ $value->id }}">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('admin.products.update')}}" enctype="multipart/form-data" class="needs-validation" novalidate="">
                        @csrf
                        <input type="hidden" name="oldImage" value="{{ $value->image }}">
                        <input type="hidden" name="id" value="{{ $value->id }}">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $value->name) }}" required>
                                <div class="invalid-feedback">Please fill this form</div>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="summernote-simple" name="description">{{ old('description', $value->description) }}</textarea>
                                <div class="invalid-feedback">Please fill this form</div>
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $value->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a category</div>
                            </div>
                            <div class="form-group">
                                <label>Image 1</label>
                                <input type="hidden" name="oldImage_1" value="{{ $value->image }}">
                                <input type="file" name="image_1" class="form-control"><br>
                                @if ($value->image === null)
                                    <img src="{{ asset('user_assets/assets/img/blank-image.jpg') }}" width="100" alt="">
                                @else
                                    <img src="{{ asset($value->image) }}" width="100" alt="">
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Image 2</label>
                                <input type="hidden" name="oldImage_2" value="{{ $value->image_2 }}">
                                <input type="file" name="image_2" class="form-control"><br>
                                @if ($value->image_2 === null)
                                    <img src="{{ asset('user_assets/assets/img/blank-image.jpg') }}" width="100" alt="">
                                @else
                                    <img src="{{ asset($value->image_2) }}" width="100" alt="">
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Image 3</label>
                                <input type="hidden" name="oldImage_3" value="{{ $value->image_3 }}">
                                <input type="file" name="image_3" class="form-control"><br>
                                @if ($value->image_3 === null)
                                    <img src="{{ asset('user_assets/assets/img/blank-image.jpg') }}" width="100" alt="">
                                @else
                                    <img src="{{ asset($value->image_3) }}" width="100" alt="">
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Sizes, Price & Stock</label>
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
                                            <td>
                                                <input type="hidden" name="stock_ids[]" value="{{ $stock->id }}">
                                                <input type="text" name="sizes[]" class="form-control" value="{{ $stock->size }}" required>
                                            </td>
                                            <td>
                                                <input type="number" name="price[]" class="form-control" value="{{ $stock->price }}" min="0" required>
                                            </td>
                                            <td>
                                                <input type="number" name="stocks[]" class="form-control" value="{{ $stock->stock }}" min="0" required>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
    </div>
@endforeach
