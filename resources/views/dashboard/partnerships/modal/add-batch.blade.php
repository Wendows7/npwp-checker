{{-- start create modal --}}
@foreach($partnerships as $data)
    <div class="modal fade" tabindex="-1" role="dialog" id="addBatch{{ $data->id }}">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Batch Sending</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('admin.partnerships.sending.add')}}" enctype="multipart/form-data" class="needs-validation" novalidate="" id="partnership-form-{{ $data->id }}">
                        @csrf
                        <input type="hidden" name="partnership_id" value="{{ $data->id }}">

                        <!-- Container for all batch forms -->
                        <div id="batch-forms-container-{{ $data->id }}">
                            <!-- First batch form (template) -->
                            <div class="batch-form" id="batch-form-{{ $data->id }}-0">
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                        <h6 class="mb-0 batch-title">Batch #1</h6>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-batch-btn" style="display: none;">
                                            <i class="fas fa-times"></i> Remove
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Batch Number</label>
                                            <input type="number" name="batch_number[]" class="form-control batch-number" min="1" required>
                                            <div class="invalid-feedback">Please fill this form</div>
                                        </div>
                                        <div class="form-group">
                                            <label>Company Name</label>
                                            <input type="text" class="form-control" value="{{ $data->company_name }}" readonly>
                                        </div>

                                        <!-- Container for products within this batch -->
                                        <div class="product-entries-container" id="product-entries-container-{{ $data->id }}-0">
                                            <!-- First product entry (template) -->
                                            <div class="product-entry" id="product-entry-{{ $data->id }}-0-0">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                                        <h6 class="mb-0">Product #1</h6>
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-product-btn" style="display: none;">
                                                            <i class="fas fa-times"></i> Remove
                                                        </button>
                                                    </div>
                                                    <div class="card-body">
                                                        <!-- Product selection, size, quantity fields -->
                                                        <div class="form-group">
                                                            <label>Product</label>
                                                            <select name="products[0][product_id][]" class="form-control product-select" required>
                                                                <option value="">-- Select Product --</option>
                                                                @foreach($product as $value)
                                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="invalid-feedback">Please select a product</div>
                                                        </div>
                                                        <div class="form-group stock-container" style="display: none;">
                                                            <label>Size & Available Stock</label>
                                                            <select name="products[0][size][]" class="form-control stock-select" required>
                                                                <option value="">-- Select Stock Size --</option>
                                                            </select>
                                                            <div class="invalid-feedback">Please select available stock</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Quantity</label>
                                                            <input type="number" name="products[0][quantity][]" class="form-control quantity-input" min="1" required>
                                                            <div class="invalid-feedback quantity-error-message">Please fill this form</div>
                                                            <small class="text-muted stock-availability-info"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Button to add more products to this batch -->
                                        <div class="text-center mb-3">
                                            <button type="button" class="btn btn-outline-secondary add-product-btn" data-partnership-id="{{ $data->id }}" data-batch-index="0">
                                                <i class="fas fa-plus"></i> Add Another Product
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Button to add more batches -->
                        <div class="text-center mb-4">
                            <button type="button" class="btn btn-outline-primary add-batch-btn" data-partnership-id="{{ $data->id }}">
                                <i class="fas fa-plus"></i> Add Another Batch
                            </button>
                        </div>

                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary submit-btn">Add Batches</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Object to track available stock for each product entry
        const productStockData = {};

        // Store original templates
        const originalBatchTemplates = {};
        const originalProductTemplates = {};

        // Declare variables once outside loops
        let batchTemplateId, productTemplateId;

        // Initialize the first batch form for each partnership and store templates
        @foreach($partnerships as $data)
            batchTemplateId = `batch-form-{{ $data->id }}-0`;
        productTemplateId = `product-entry-{{ $data->id }}-0-0`;

        originalBatchTemplates['{{ $data->id }}'] = document.getElementById(batchTemplateId).cloneNode(true);
        originalProductTemplates['{{ $data->id }}'] = document.getElementById(productTemplateId).cloneNode(true);

        initializeBatchForm('{{ $data->id }}', 0);
        initializeProductEntry('{{ $data->id }}', 0, 0);
        @endforeach

        // Add click handlers for "Add Another Batch" buttons
        document.querySelectorAll('.add-batch-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                console.log("Add batch button clicked");
                const partnershipId = this.dataset.partnershipId;

                // Check if partnership ID exists
                if (!partnershipId) {
                    console.error("Missing partnership ID on button");
                    return;
                }

                const container = document.getElementById(`batch-forms-container-${partnershipId}`);
                if (!container) {
                    console.error(`Container not found: batch-forms-container-${partnershipId}`);
                    return;
                }

                const batchForms = container.querySelectorAll('.batch-form');
                const newBatchIndex = batchForms.length;

                // Clone batch template and update IDs
                const newBatchForm = originalBatchTemplates[partnershipId].cloneNode(true);
                newBatchForm.id = `batch-form-${partnershipId}-${newBatchIndex}`;

                // Update batch title and show remove button
                const batchTitle = newBatchForm.querySelector('.batch-title');
                if (batchTitle) batchTitle.textContent = `Batch #${newBatchIndex + 1}`;

                const removeBatchBtn = newBatchForm.querySelector('.remove-batch-btn');
                if (removeBatchBtn) removeBatchBtn.style.display = 'block';

                // Update product container ID and add product button data attribute
                const productContainer = newBatchForm.querySelector('.product-entries-container');
                if (productContainer) productContainer.id = `product-entries-container-${partnershipId}-${newBatchIndex}`;

                const addProductBtn = newBatchForm.querySelector('.add-product-btn');
                if (addProductBtn) addProductBtn.dataset.batchIndex = newBatchIndex;

                // Reset form elements
                resetFormElements(newBatchForm, newBatchIndex);

                // Add to container
                container.appendChild(newBatchForm);

                // Initialize the new batch
                initializeBatchForm(partnershipId, newBatchIndex);

                // Important fix: We need to reinitialize the product entry in the new batch
                const productEntry = newBatchForm.querySelector('.product-entry');
                if (productEntry) {
                    productEntry.id = `product-entry-${partnershipId}-${newBatchIndex}-0`;
                    initializeProductEntry(partnershipId, newBatchIndex, 0);
                }
            });
        });

        // Add click handlers for "Add Another Product" buttons - using event delegation
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.add-product-btn')) return;

            e.preventDefault();
            e.stopPropagation();

            const btn = e.target.closest('.add-product-btn');
            const partnershipId = btn.dataset.partnershipId;
            const batchIndex = parseInt(btn.dataset.batchIndex);

            console.log(`Add product clicked for batch ${batchIndex}`);

            const container = document.getElementById(`product-entries-container-${partnershipId}-${batchIndex}`);
            if (!container) {
                console.error(`Product container not found: product-entries-container-${partnershipId}-${batchIndex}`);
                return;
            }

            const productEntries = container.querySelectorAll('.product-entry');
            const newProductIndex = productEntries.length;

            // Clone product template
            const newProductEntry = originalProductTemplates[partnershipId].cloneNode(true);
            newProductEntry.id = `product-entry-${partnershipId}-${batchIndex}-${newProductIndex}`;

            // Update product title and show remove button
            const productTitle = newProductEntry.querySelector('h6');
            if (productTitle) productTitle.textContent = `Product #${newProductIndex + 1}`;

            const removeProductBtn = newProductEntry.querySelector('.remove-product-btn');
            if (removeProductBtn) removeProductBtn.style.display = 'block';

            // Update name attributes for this product
            updateProductNameAttributes(newProductEntry, batchIndex);

            // Reset form controls
            resetProductFormElements(newProductEntry);

            // Add to container and initialize
            container.appendChild(newProductEntry);
            initializeProductEntry(partnershipId, batchIndex, newProductIndex);
        });

        // Helper functions for form handling
        function resetFormElements(batchForm, batchIndex) {
            // Clear inputs
            batchForm.querySelectorAll('input:not([readonly])').forEach(input => {
                input.value = '';
            });

            // Reset selects
            batchForm.querySelectorAll('select').forEach(select => {
                select.selectedIndex = 0;
                if (!select.classList.contains('product-select')) {
                    select.innerHTML = '<option value="">-- Select Stock Size --</option>';
                }
            });

            // Reset validation classes
            batchForm.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                el.classList.remove('is-valid', 'is-invalid');
            });

            // Update name attributes for all products in this batch
            batchForm.querySelectorAll('.product-entry').forEach(entry => {
                updateProductNameAttributes(entry, batchIndex);
            });

            // Hide stock containers
            batchForm.querySelectorAll('.stock-container').forEach(container => {
                container.style.display = 'none';
            });

            // Clear stock info
            batchForm.querySelectorAll('.stock-availability-info').forEach(info => {
                info.textContent = '';
            });
        }

        function resetProductFormElements(productEntry) {
            productEntry.querySelectorAll('input:not([readonly])').forEach(input => {
                input.value = '';
            });

            productEntry.querySelectorAll('select').forEach(select => {
                select.selectedIndex = 0;
                if (!select.classList.contains('product-select')) {
                    select.innerHTML = '<option value="">-- Select Stock Size --</option>';
                }
            });

            productEntry.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                el.classList.remove('is-valid', 'is-invalid');
            });

            const stockContainer = productEntry.querySelector('.stock-container');
            if (stockContainer) stockContainer.style.display = 'none';

            const stockInfo = productEntry.querySelector('.stock-availability-info');
            if (stockInfo) stockInfo.textContent = '';
        }

        function updateProductNameAttributes(productEntry, batchIndex) {
            const productSelect = productEntry.querySelector('.product-select');
            if (productSelect) productSelect.name = `products[${batchIndex}][product_id][]`;

            const sizeSelect = productEntry.querySelector('.stock-select');
            if (sizeSelect) sizeSelect.name = `products[${batchIndex}][size][]`;

            const quantityInput = productEntry.querySelector('.quantity-input');
            if (quantityInput) quantityInput.name = `products[${batchIndex}][quantity][]`;
        }

        function initializeBatchForm(partnershipId, batchIndex) {
            const batchForm = document.getElementById(`batch-form-${partnershipId}-${batchIndex}`);
            if (!batchForm) {
                console.error(`Form not found: batch-form-${partnershipId}-${batchIndex}`);
                return;
            }

            const removeBtn = batchForm.querySelector('.remove-batch-btn');
            if (removeBtn) {
                removeBtn.onclick = function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    batchForm.remove();

                    // Update batch numbers and name attributes
                    updateBatchNumbers(partnershipId);
                };
            }
        }

        function initializeProductEntry(partnershipId, batchIndex, productIndex) {
            const productEntry = document.getElementById(`product-entry-${partnershipId}-${batchIndex}-${productIndex}`);
            if (!productEntry) {
                console.error(`Product entry not found: product-entry-${partnershipId}-${batchIndex}-${productIndex}`);
                return;
            }

            const productEntryId = `${partnershipId}-${batchIndex}-${productIndex}`;
            productStockData[productEntryId] = { maxAvailableStock: 0 };

            setupRemoveProductButton(productEntry, partnershipId, batchIndex);
            setupProductSelection(productEntry, productEntryId);
        }

        function setupRemoveProductButton(productEntry, partnershipId, batchIndex) {
            const removeBtn = productEntry.querySelector('.remove-product-btn');
            if (removeBtn) {
                removeBtn.onclick = function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    productEntry.remove();

                    // Update product numbers in this batch
                    updateProductNumbers(partnershipId, batchIndex);
                };
            }
        }

        function setupProductSelection(productEntry, productEntryId) {
            // Use let for elements that will be updated
            let productSelect = productEntry.querySelector('.product-select');
            let stockContainer = productEntry.querySelector('.stock-container');
            let stockSelect = productEntry.querySelector('.stock-select');
            let quantityInput = productEntry.querySelector('.quantity-input');
            let stockInfo = productEntry.querySelector('.stock-availability-info');

            if (productSelect) {
                // Replace with fresh clone to remove any existing event listeners
                const newProductSelect = productSelect.cloneNode(true);
                productSelect.parentNode.replaceChild(newProductSelect, productSelect);
                productSelect = newProductSelect; // Update reference to point to new element

                productSelect.addEventListener('change', function() {
                    const productId = this.value;
                    console.log(`Product selected: ${productId} for entry ${productEntryId}`);

                    // Re-fetch elements to make sure we have current references
                    stockContainer = productEntry.querySelector('.stock-container');
                    stockSelect = productEntry.querySelector('.stock-select');
                    quantityInput = productEntry.querySelector('.quantity-input');
                    stockInfo = productEntry.querySelector('.stock-availability-info');

                    // Reset quantity and validation
                    if (quantityInput) {
                        quantityInput.value = '';
                        quantityInput.classList.remove('is-valid', 'is-invalid');
                    }

                    if (stockInfo) stockInfo.textContent = '';
                    productStockData[productEntryId].maxAvailableStock = 0;

                    if (productId) {
                        // Always ensure stock container is visible when product is selected
                        if (stockContainer) stockContainer.style.display = 'block';

                        if (stockSelect) {
                            // Show loading indicator
                            stockSelect.innerHTML = '<option>Loading stock data...</option>';
                            stockSelect.disabled = true;

                            // Fetch stock data
                            fetch(`/products/stocks/${productId}`)
                                .then(response => response.json())
                                .then(data => {
                                    console.log(`Stock data received for entry ${productEntryId}:`, data);

                                    // Re-fetch the select element to ensure we have the latest reference
                                    stockSelect = productEntry.querySelector('.stock-select');
                                    if (!stockSelect) return;

                                    // Clear and re-enable dropdown
                                    stockSelect.innerHTML = '<option value="">-- Select Stock Size --</option>';
                                    stockSelect.disabled = false;

                                    // Add stock options
                                    if (data && data.length > 0) {
                                        data.forEach(stock => {
                                            console.log(stock);
                                            const option = document.createElement('option');
                                            option.value = stock.size;
                                            option.textContent = `${stock.size} ML - ${stock.stock} items available`;
                                            option.dataset.stock = stock.stock;
                                            stockSelect.appendChild(option);
                                        });
                                        console.log(`Added ${data.length} stock options to select`);
                                    } else {
                                        stockSelect.innerHTML = '<option value="">No stock available</option>';
                                    }
                                })
                                .catch(error => {
                                    console.error(`Error fetching stock:`, error);
                                    stockSelect = productEntry.querySelector('.stock-select');
                                    if (stockSelect) {
                                        stockSelect.innerHTML = '<option value="">Error loading stock data</option>';
                                        stockSelect.disabled = false;
                                    }
                                });
                        }
                    } else if (stockContainer) {
                        stockContainer.style.display = 'none';
                    }
                });
            }

            if (stockSelect) {
                // Replace with fresh clone to remove any existing event listeners
                const newStockSelect = stockSelect.cloneNode(true);
                stockSelect.parentNode.replaceChild(newStockSelect, stockSelect);
                stockSelect = newStockSelect; // Update reference

                stockSelect.addEventListener('change', function() {
                    // Re-fetch quantity input and stock info
                    quantityInput = productEntry.querySelector('.quantity-input');
                    stockInfo = productEntry.querySelector('.stock-availability-info');

                    if (this.selectedIndex > 0 && quantityInput && stockInfo) {
                        const selectedOption = this.options[this.selectedIndex];
                        const stockAmount = parseInt(selectedOption.dataset.stock);

                        productStockData[productEntryId].maxAvailableStock = stockAmount;
                        quantityInput.max = stockAmount;
                        quantityInput.placeholder = `Maximum: ${stockAmount}`;
                        quantityInput.value = '';
                        quantityInput.classList.remove('is-valid', 'is-invalid');

                        stockInfo.textContent = `Available stock: ${stockAmount} items`;
                        stockInfo.className = 'text-muted mt-1';
                    }
                });
            }

            if (quantityInput) {
                // Replace with fresh clone to remove any existing event listeners
                const newQuantityInput = quantityInput.cloneNode(true);
                quantityInput.parentNode.replaceChild(newQuantityInput, quantityInput);
                quantityInput = newQuantityInput; // Update reference

                quantityInput.addEventListener('input', function() {
                    validateQuantity(this, productEntryId);
                });
            }
        }

        function updateBatchNumbers(partnershipId) {
            const container = document.getElementById(`batch-forms-container-${partnershipId}`);
            const remainingForms = container.querySelectorAll('.batch-form');

            remainingForms.forEach((form, i) => {
                // Update batch title
                const titleElem = form.querySelector('.batch-title');
                if (titleElem) titleElem.textContent = `Batch #${i + 1}`;

                // Update batch ID
                form.id = `batch-form-${partnershipId}-${i}`;

                // Update add product button data attribute
                const addProductBtn = form.querySelector('.add-product-btn');
                if (addProductBtn) addProductBtn.dataset.batchIndex = i;

                // Update product entries container ID
                const productContainer = form.querySelector('.product-entries-container');
                if (productContainer) productContainer.id = `product-entries-container-${partnershipId}-${i}`;

                // Update name attributes for all products in this batch
                form.querySelectorAll('.product-entry').forEach((entry, j) => {
                    entry.id = `product-entry-${partnershipId}-${i}-${j}`;
                    updateProductNameAttributes(entry, i);

                    // Reinitialize all product entries when batch index changes
                    initializeProductEntry(partnershipId, i, j);
                });

                // Show/hide remove button based on position
                const btnElem = form.querySelector('.remove-batch-btn');
                if (btnElem) btnElem.style.display = i > 0 ? 'block' : 'none';
            });
        }

        function updateProductNumbers(partnershipId, batchIndex) {
            const container = document.getElementById(`product-entries-container-${partnershipId}-${batchIndex}`);
            if (!container) return;

            const remainingProducts = container.querySelectorAll('.product-entry');
            remainingProducts.forEach((entry, i) => {
                // Update product title
                const titleElem = entry.querySelector('h6');
                if (titleElem) titleElem.textContent = `Product #${i + 1}`;

                // Update ID
                entry.id = `product-entry-${partnershipId}-${batchIndex}-${i}`;

                // Show/hide remove button based on position
                const btnElem = entry.querySelector('.remove-product-btn');
                if (btnElem) btnElem.style.display = i > 0 ? 'block' : 'none';
            });
        }

        function validateQuantity(input, productEntryId) {
            const maxStock = productStockData[productEntryId]?.maxAvailableStock || 0;
            const value = parseInt(input.value);

            if (!isNaN(value) && value > 0) {
                if (maxStock > 0 && value > maxStock) {
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');

                    // Update error message
                    const errorMsg = input.nextElementSibling;
                    if (errorMsg && errorMsg.classList.contains('invalid-feedback')) {
                        errorMsg.textContent = `Maximum available stock is ${maxStock}`;
                    }
                } else {
                    input.classList.add('is-valid');
                    input.classList.remove('is-invalid');
                }
            } else {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');

                // Reset to default error
                const errorMsg = input.nextElementSibling;
                if (errorMsg && errorMsg.classList.contains('invalid-feedback')) {
                    errorMsg.textContent = 'Please enter a valid quantity';
                }
            }
        }
    });
</script>

<style>
    /* Custom validation styling */
    .form-control.is-valid {
        border-color: #28a745;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23dc3545' viewBox='-2 -2 7 7'%3e%3cpath stroke='%23dc3545' d='M0 0l3 3m0-3L0 3'/%3e%3ccircle r='.5'/%3e%3ccircle cx='3' r='.5'/%3e%3ccircle cy='3' r='.5'/%3e%3ccircle cx='3' cy='3' r='.5'/%3e%3c/svg%3E");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    /* Batch form styling */
    .batch-form {
        position: relative;
    }

    .batch-form .card {
        border: 1px solid #e9ecef;
        transition: all 0.2s ease;
    }

    .batch-form .card:hover {
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .add-batch-btn, .add-product-btn {
        transition: all 0.2s ease;
    }

    .add-batch-btn:hover, .add-product-btn:hover {
        transform: translateY(-2px);
    }

    .remove-batch-btn, .remove-product-btn {
        transition: all 0.2s ease;
    }

    .remove-batch-btn:hover, .remove-product-btn:hover {
        background-color: #f8d7da;
    }

    .product-entry .card {
        border-color: #f0f0f0;
    }

    .product-entry .card-header {
        background-color: #f8f9fa;
    }
</style>
