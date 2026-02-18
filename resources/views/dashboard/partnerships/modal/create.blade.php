{{-- start create modal --}}
<div class="modal fade" tabindex="-1" role="dialog" id="createModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('admin.partnerships.sending.update')}}" enctype="multipart/form-data" class="needs-validation" novalidate="" id="partnership-form">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Company Name</label>
                            <select name="partnership_id" id="product_select" class="form-control" required>
                                <option value="">-- Select Company --</option>
                                @foreach($partner as $value)
                                    <option value="{{ $value->id }}" {{ old('product_id') == $value->id ? 'selected' : '' }}>
                                        {{ $value->company_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please fill this form</div>
                        </div>

                        <!-- Container for product stock info (initially hidden) -->
                        <div id="product_stock_container" class="form-group" style="display: none;">
                            <label>Batch Number</label>
                            <select name="batch_number" id="stock_select" class="form-control" required>
                                <option value="">-- Select batch number --</option>
                            </select>
                            <div class="invalid-feedback">Please select batch number</div>
                        </div>
                        <input type="hidden" name="status" value="sending">
{{--                        <div class="form-group">--}}
{{--                            <label>Quantity</label>--}}
{{--                            <input type="number" name="quantity" id="quantity_input" class="form-control" min="1" required>--}}
{{--                            <div class="invalid-feedback" id="quantity-error-message">Please fill this form</div>--}}
{{--                            <small id="stock-availability-info" class="text-muted"></small>--}}
{{--                        </div>--}}
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit-button" class="btn btn-primary">Send</button>
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

    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.getElementById('product_select');
        const stockContainer = document.getElementById('product_stock_container');
        const stockSelect = document.getElementById('stock_select');
        const submitButton = document.getElementById('submit-button');
        const form = document.getElementById('partnership-form');

        // Create a container for batch details
        let detailsContainer = document.getElementById('batch-details-container');
        if (!detailsContainer) {
            detailsContainer = document.createElement('div');
            detailsContainer.id = 'batch-details-container';
            detailsContainer.className = 'mt-3';
            stockContainer.appendChild(detailsContainer);
        }

        // Handle product selection and fetch stock information
        productSelect.addEventListener('change', function() {
            const partnershipId = this.value;

            // Hide details container when product changes
            detailsContainer.style.display = 'none';
            detailsContainer.innerHTML = '';

            if (partnershipId) {
                // Show loading indicator
                stockContainer.style.display = 'block';
                stockSelect.innerHTML = '<option>Loading batch data...</option>';
                stockSelect.disabled = true;

                // Fetch batch data for the selected partnership
                fetch(`/partnership/sendHistory/${partnershipId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Clear and re-enable the stock dropdown
                        stockSelect.innerHTML = '<option value="">-- Select batch number --</option>';
                        stockSelect.disabled = false;

                        // Group data by batch number
                        const batchGroups = {};

                        data.forEach(item => {
                            const batchNum = item.batch_number;
                            if (!batchGroups[batchNum]) {
                                batchGroups[batchNum] = [];
                            }
                            batchGroups[batchNum].push(item);
                        });

                        // Add unique batch options
                        Object.keys(batchGroups).forEach(batchNum => {
                            const option = document.createElement('option');
                            option.value = batchNum;
                            option.textContent = `Batch #${batchNum}`;
                            stockSelect.appendChild(option);
                        });

                        // Store grouped batch data
                        stockSelect.batchGroups = batchGroups;
                    })
                    .catch(error => {
                        console.error('Error fetching batch data:', error);
                        stockSelect.innerHTML = '<option value="">Error loading batch data</option>';
                    });
            } else {
                // Hide stock selection if no partnership is selected
                stockContainer.style.display = 'none';
            }
        });

        // Display batch details when a batch is selected
        stockSelect.addEventListener('change', function() {
            detailsContainer.innerHTML = '';

            if (this.value && this.batchGroups && this.batchGroups[this.value]) {
                const batchProducts = this.batchGroups[this.value];

                // Create details card
                const card = document.createElement('div');
                card.className = 'card';

                // Create header
                const header = document.createElement('div');
                header.className = 'card-header';
                header.innerHTML = `<h6 class="mb-0">Batch #${this.value} Details</h6>`;
                card.appendChild(header);

                // Create card body
                const cardBody = document.createElement('div');
                cardBody.className = 'card-body';

                // Add each product in this batch
                batchProducts.forEach((product, index) => {
                    const productCard = document.createElement('div');
                    productCard.className = index > 0 ? 'border-top pt-3 mt-3' : '';

                    productCard.innerHTML = `
                    <h6>Product #${index + 1}</h6>
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" class="form-control" value="${product.product.name}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Size</label>
                        <input type="text" class="form-control" value="${product.size} ML" readonly>
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="text" class="form-control" value="${product.quantity}" readonly>
                    </div>
                `;

                    cardBody.appendChild(productCard);
                });

                card.appendChild(cardBody);
                detailsContainer.appendChild(card);
                detailsContainer.style.display = 'block';
            } else {
                detailsContainer.style.display = 'none';
            }
        });

        // Form submission validation
        form.addEventListener('submit', function(event) {
            if (!stockSelect.value) {
                stockSelect.classList.add('is-invalid');
                event.preventDefault();
                event.stopPropagation();
            } else {
                stockSelect.classList.add('is-valid');
            }
        });

        // Check if product is pre-selected
        if (productSelect.value) {
            productSelect.dispatchEvent(new Event('change'));
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
</style>
