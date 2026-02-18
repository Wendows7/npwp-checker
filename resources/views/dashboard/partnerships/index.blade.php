@extends('dashboard.layouts.main')

@section('body')

@include('dashboard/partnerships/modal/edit')
@include('dashboard.partnerships.modal.add-batch')
{{--@include('dashboard/products/modal/create')--}}
{{--@include('dashboard/products/modal/detail')--}}
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
        <h1>Data Partnership</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="/dashboard">Dashboard</a></div>
          <div class="breadcrumb-item">Partnership</div>
        </div>
      </div>

      <div class="section-body">
        <h2 class="section-title">Data Partnership</h2>
        <p class="section-lead">
          Change information about partnership
        </p>

        <div class="row">
          <div class="col-12">
{{--           <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#createModal"><i class="far fa-user"></i>Add Product</button>--}}
            <div class="card mt-3">
              <div class="card-header">
                <h4>Table All Product</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="table-1">
                    <thead>
                      <tr>
                        <th class="text-center">
                          No
                        </th>
                        <th>Code</th>
                        <th>Company Name</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>File</th>
                        <th>Reply File</th>
                        <th>Payment Proof</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($partnerships as $data)
                      <tr>
                        <td>
                          {{ $loop->iteration }}
                        </td>
                        <td>{{ $data->code }}</td>
                        <td>{{ $data->company_name }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->email }}</td>
                          <td>{{$data->phone}}</td>
{{--                          show file pdf--}}
                        <td>
                          @if ($data->file)
                            <a href="{{ asset($data->file) }}" target="_blank" class="btn btn-icon icon-left btn-info"><i class="fas fa-file-pdf"></i> View File</a>
                          @else
                            No File Uploaded
                          @endif
                          </td>
                          <td>
                          @if ($data->reply_file)
                            <a href="{{ asset($data->reply_file) }}" target="_blank" class="btn btn-icon icon-left btn-primary"><i class="fas fa-file-pdf"></i> View File</a>
                          @else
                            No File Uploaded
                          @endif
                          </td>
                          <td>
                          @if ($data->payment_proof)
                            <a href="{{ asset($data->payment_proof) }}" target="_blank" class="btn btn-icon icon-left btn-success"><i class="fas fa-file-pdf"></i> View File</a>
                          @else
                            No File Uploaded
                          @endif
                          </td>
                          <td>
                              @php
                                  $status = strtolower($data->status ?? 'other');
                                  $badgeClass = match($status) {
                                      'pending' => 'pending',
                                       'approved' => 'approved',
                                        'rejected' => 'rejected',
                                      default => 'other'
                                  };
                              @endphp
                              <span class="badge badge-status {{ $badgeClass }}">
                            {{ ucfirst($data->status ?? '-') }}
                        </span>
                      </td>
                        <td>
                            <button class="btn btn-icon editbtn icon-left btn-warning border-0 mb-1"  data-toggle="modal" data-target="#updateStatusModal{{ $data->id }}"><i class="fas fa-exclamation-triangle"></i>Update Status</button>
                            <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#addBatch{{ $data->id }}"><i class="fas fa-arrow-alt-circle-right"></i>Add Sending Batch</button>
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

          <style>
              .badge-status.pending { background: #ffe082; color: #856404; }
              .badge-status.approved { background: #c8e6c9; color: #256029; }
              .badge-status.rejected { background: #ffcdd2; color: #b71c1c; }
              .badge-status.other { background: #e3e3e3; color: #333; }
              .bg-primary-subtle { background: #e7e9fd !important; }
              @media (max-width: 576px) {
                  .modal-lg { max-width: 98vw; }
                  .modal-body .row > [class^="col-"] { flex: 0 0 100%; max-width: 100%; }
              }
          </style>

 @endsection





