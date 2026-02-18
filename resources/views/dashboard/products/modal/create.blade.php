{{-- start create modal --}}
<div class="modal fade" tabindex="-1" role="dialog" id="createModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('admin.products.create')}}" enctype="multipart/form-data" class="needs-validation" novalidate="">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            <div class="invalid-feedback">Please fill this form</div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="summernote-simple" name="description">{{ old('description') }}</textarea>
                            <div class="invalid-feedback">Please fill this form</div>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a category</div>
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label>Price</label>--}}
{{--                            <input type="number" name="price" class="form-control" value="{{ old('price') }}" min="0" required>--}}
{{--                            <div class="invalid-feedback">Please fill this form</div>--}}
{{--                        </div>--}}
                        <div class="form-group">
                            <label>Image 1</label>
                            <input type="file" name="image_1" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Image 2</label>
                            <input type="file" name="image_2" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Image 3</label>
                            <input type="file" name="image_3" class="form-control">
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
                                <tbody id="sizes-stock-body">
                                <tr>
                                    <td>
                                        <input type="text" name="sizes[]" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="number" name="price[]" class="form-control" min="0" required>
                                    </td>
                                    <td>
                                        <input type="number" name="stocks[]" class="form-control" min="0" required>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-sm btn-primary" onclick="addSizeStockRow()">Add Size</button>
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
</div>
<script>
    function addSizeStockRow() {
        const tbody = document.getElementById('sizes-stock-body');
        const row = document.createElement('tr');
        row.innerHTML = `
    <td><input type="text" name="sizes[]" class="form-control" required></td>
    <td><input type="number" name="stocks[]" class="form-control" min="0" required></td>
  `;
        tbody.appendChild(row);
    }
</script>
