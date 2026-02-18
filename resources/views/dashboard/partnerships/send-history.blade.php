@extends('dashboard.layouts.main')

@section('body')
    @include('dashboard.partnerships.modal.create')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Send Product Partnership</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item">Partnership Sending</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Send Product Partnership</h2>
                <p class="section-lead">
                    Send product to partnership company
                </p>

                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#createModal"><i class="far fa-user"></i>Send Product</button>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h4>Table Sending History</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Batch Number</th>
                                            <th>Company Name</th>
                                            <th>Date Created</th>
                                            <th>Products</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($dataShow as $index => $batch)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>#{{ $batch['batch_number'] }}</td>
                                                <td>{{ $batch['company_name'] }}</td>
                                                <td>{{ $batch['created_at'] }}</td>
                                                <td>{{ $batch['products']->count() }} items</td>
                                                <td>
                                                    <button class="btn btn-icon icon-left btn-info btn-sm toggle-products"
                                                            data-batch="{{ $index }}">
                                                        <i class="fas fa-eye"></i> View Products
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr class="product-details" id="products-{{ $index }}" style="display: none;">
                                                <td colspan="6">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Product Name</th>
                                                                <th>Size</th>
                                                                <th>Quantity</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach ($batch['products'] as $productIndex => $product)
                                                                <tr>
                                                                    <td>{{ $productIndex + 1 }}</td>
                                                                    <td>{{ $product['product_name'] }}</td>
                                                                    <td>{{ $product['size'] }} ML</td>
                                                                    <td>{{ $product['quantity'] }}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Create modal HTML if it doesn't exist
            if (!document.getElementById('productDetailsModal')) {
                const modalHTML = `
            <div class="modal fade" id="productDetailsModal" tabindex="-1" role="dialog" aria-labelledby="productDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productDetailsModalLabel">Product Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="modalProductTable">
                                    <tbody id="modalProductTableBody">
                                        <!-- Products will be inserted here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
                document.body.insertAdjacentHTML('beforeend', modalHTML);
            }

            // Set up click handlers for view buttons
            document.querySelectorAll('.toggle-products').forEach(button => {
                button.addEventListener('click', function() {
                    const batchIndex = this.dataset.batch;
                    const productRow = document.getElementById(`products-${batchIndex}`);

                    // Get all product data from the hidden row
                    const productRows = productRow.querySelectorAll('tbody tr');
                    const modalTableBody = document.getElementById('modalProductTableBody');

                    // Clear previous modal content
                    modalTableBody.innerHTML = '';

                    // Set modal title based on batch info
                    const batchNumber = document.querySelector(`tr:nth-child(${parseInt(batchIndex) * 2 + 1}) td:nth-child(2)`).textContent;
                    const companyName = document.querySelector(`tr:nth-child(${parseInt(batchIndex) * 2 + 1}) td:nth-child(3)`).textContent;
                    document.getElementById('productDetailsModalLabel').textContent = `${batchNumber} - ${companyName}`;

                    // Clone product data into modal
                    productRows.forEach(row => {
                        modalTableBody.appendChild(row.cloneNode(true));
                    });

                    // Show the modal
                    $('#productDetailsModal').modal('show');
                });
            });
        });
    </script>
@endsection

