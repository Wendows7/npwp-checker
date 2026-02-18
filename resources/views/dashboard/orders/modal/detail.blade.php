@foreach($orders as $order)
    <div class="modal fade" id="detailModal{{ $order['order_code'] }}" tabindex="-1" aria-labelledby="orderViewModalLabel{{ $order['order_code'] }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header py-4" style="background: linear-gradient(90deg, #4e54c8 0%, #8f94fb 100%);">
                    <div class="d-flex align-items-center w-100">
                        <div class="me-3">
                            <i class="bi bi-receipt text-primary fs-3"></i>
                            </span>
                        </div>
                        <div>
                            <h5 class="modal-title text-white mb-0" id="orderViewModalLabel{{ $order['order_code'] }}">
                                Order #{{ $order['order_code'] }}
                            </h5>
                            <small class="text-white-50">Placed on {{ $order['created_at'] ? $order['created_at']->format('d M Y H:i') : '-' }}</small>
                        </div>
                    </div>
                    <button type="button"
                            class="btn-close btn-close-white"
                            data-dismiss="modal"
                            aria-label="Close"
                            style="margin-left: auto; margin-right: 10px;">
                    </button>
                </div>
                <div class="modal-body bg-light">
                    <div class="row g-3 mb-3">
                        <div class="col-6 col-md-4">
                            <div class="bg-white rounded-3 p-3 h-100 shadow-sm">
                                <div class="text-muted small">Status</div>
                                @php
                                    $status = strtolower($order['status'] ?? 'other');
                                    $badgeClass = match($status) {
                                        'pending' => 'pending',
                                        'success', 'settlement', 'paid' => 'success',
                                        'cancel', 'failed', 'deny' => 'cancel',
                                        default => 'other'
                                    };
                                @endphp
                                <span class="badge badge-status {{ $badgeClass }} mt-1">
                                {{ ucfirst($order['status'] ?? '-') }}
                            </span>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="bg-white rounded-3 p-3 h-100 shadow-sm">
                                <div class="text-muted small">Total</div>
                                <div class="fw-bold mt-1">Rp {{ number_format($order['total_price'] ?? 0, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="bg-white rounded-3 p-3 h-100 shadow-sm">
                                <div class="text-muted small">Customer Info</div>
                                <div class="mt-1">{{ $order['user']->name ?? '-' }}</div>
                                <div class="small text-muted">{{ $order['user']->email ?? '' }}</div>
                            </div>
                        </div>
                    </div>
                    <!-- Add this after the customer info div and before the order items section -->
                    <div class="bg-white rounded-3 p-3 shadow-sm mb-3">
                        <div class="mb-2 fw-semibold">Bukti Pembayaran</div>
                        <div class="text-center">
                            @if(isset($order['payment']) && $order['payment_proof'])
                                <img src="{{ asset($order['payment_proof']) }}"
                                     class="img-fluid rounded"
                                     style="max-height: 200px; cursor: pointer;"
                                     onclick="window.open(this.src, '_blank')"
                                     alt="Bukti Pembayaran">
                            @else
                                <div class="alert alert-secondary mb-0">
                                    <i class="bi bi-exclamation-circle me-2"></i>Bukti pembayaran belum diunggah.
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="bg-white rounded-3 p-3 shadow-sm">
                        <div class="mb-2 fw-semibold">Order Items</div>
                        <div style="max-height:220px;overflow-y:auto;">
                            <ul class="list-group list-group-flush">
                                @forelse($order['transactions'] ?? [] as $item)
                                    <li class="list-group-item px-0">
                                        <div class="row align-items-center text-center">
                                            {{-- Kolom Nama & Jumlah --}}
                                            <div class="col-md-4 text-md-start">
                                                <div class="fw-semibold">{{ $item->product->name ?? '-' }}</div>
                                                <div>
                                                    <span class="badge bg-info text-dark"
                                                          data-toggle="tooltip"
                                                          data-placement="top"
                                                          title="Selected shoe size for this item">
                                                        Size {{ $item->size ?? '-' }} ML
                                                    </span>
                                                </div>
                                                <div class="small text-muted">x{{ $item->quantity }}</div>
                                            </div>

                                            {{-- Kolom Gambar --}}
                                            <div class="col-md-4">
                                                <img src="{{ asset($item->product->image) }}"
                                                     style="width: 150px; height: 150px; object-fit: cover;"
                                                     class="rounded">
                                            </div>

                                            {{-- Kolom Harga --}}
                                            <div class="col-md-4">
                                            <span class="badge bg-primary-subtle text-primary rounded-pill">
                                                Rp {{ number_format($item->total_price ?? 0, 0, ',', '.') }}
                                            </span>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted px-0">No items found.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

<style>
    .badge-status.pending { background: #ffe082; color: #856404; }
    .badge-status.success { background: #c8e6c9; color: #256029; }
    .badge-status.cancel { background: #ffcdd2; color: #b71c1c; }
    .badge-status.packaged { background: #0da8ee; color: #0a568c; }
    .badge-status.sending { background: #00bb00; color: #0a001f; }
    .badge-status.done { background: #9fcdff; color: #0f253c; }
    .badge-status.other { background: #e3e3e3; color: #333; }
    .bg-primary-subtle { background: #e7e9fd !important; }
    @media (max-width: 576px) {
        .modal-lg { max-width: 98vw; }
        .modal-body .row > [class^="col-"] { flex: 0 0 100%; max-width: 100%; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
