@extends('dashboard.layouts.main')

@section('body')

@include('dashboard/orders/modal/detail')
@include('dashboard/orders/modal/edit')
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
        <h1>Data Orders</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="/dashboard">Dashboard</a></div>
          <div class="breadcrumb-item">Orders</div>
        </div>
      </div>

      <div class="section-body">
        <h2 class="section-title">Data Orders</h2>
        <p class="section-lead">
          Change information order status
        </p>

        <div class="row">
          <div class="col-12">
            <div class="card mt-3">
              <div class="card-header">
                <h4>Table All Order</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="table-1">
                    <thead>
                      <tr>
                        <th class="text-center">
                          No
                        </th>
                        <th>Order Code</th>
                        <th>Date</th>
                        <th>Email</th>
                        <th>Total Price</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($orders as $order)
                      <tr>
                        <td>
                          {{ $loop->iteration }}
                        </td>
                        <td>{{ $order['order_code'] }}</td>
                        <td>{{ $order['created_at']->timezone('Asia/Jakarta')->format('d M Y H:i') }}</td>
                          <td>{{$order['user']->email }}</td>
                          <td>Rp {{number_format($order['total_price']) }}</td>
                          @if($order['payment'] == null)
                              <td>-</td>
                          @else
                              <td>{{$order['payment']}}</td>
                          @endif
                          <td>
                              @php
                                  $status = strtolower($order['status'] ?? 'other');
                                  $badgeClass = match($status) {
                                      'pending' => 'pending',
                                      'success', 'settlement', 'paid' => 'success',
                                      'cancel', 'failed', 'deny' => 'cancel',
                                      'packaged' => 'packaged',
                                      'sending' => 'sending',
                                      'done' => 'done',
                                      default => 'other'
                                  };
                              @endphp
                              <span class="badge badge-status {{ $badgeClass }}">
                            {{ ucfirst($order['status'] ?? '-') }}
                        </span>
                        <td>
                            <button class="btn btn-icon icon-left btn-primary mb-1" data-toggle="modal" data-target="#detailModal{{ $order['order_code'] }}"><i class="fas fa-eye"></i>Detail</button>
                              @if($order['status'] !== 'done')
                              <button class="btn btn-warning" data-toggle="modal" data-target="#updateStatusModal{{ $order['order_code'] }}">Update Status</button>
                              @endif
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

 @endsection





