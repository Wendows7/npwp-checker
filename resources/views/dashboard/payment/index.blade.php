@extends('dashboard.layouts.main')

@section('body')
@include('dashboard.payment.modal.edit')
@include('dashboard.payment.modal.create')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
        <h1>Data Payment Method</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{route('admin.index')}}">Dashboard</a></div>
          <div class="breadcrumb-item">Payments</div>
        </div>
      </div>

      <div class="section-body">
        <h2 class="section-title">Data Payments</h2>
        <p class="section-lead">
          Change information about payments method, like create, edit and delete
        </p>

        <div class="row">
            <div class="col-12">
{{--            <form action="/user/import" method="POST" enctype="multipart/form-data" >--}}
{{--                @csrf--}}
{{--                    <div class="form-group">--}}
{{--                        <b>Import Data From Excel</b><br>--}}
{{--                        <input type="file" name="file" placeholder="Choose file">--}}
{{--                    </div>--}}
{{--                    <button class="btn btn-icon icon-left btn-success" ><i class="fas fa-file"></i>Import</button>--}}
{{--                    </form>--}}
{{--                    <br>--}}
                    <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#createModal"><i class="far fa-user"></i>Add Payment</button>
{{--                    <form action="/user/deleteAll" method="POST" id="delete-all">--}}
{{--                        @csrf--}}
{{--                        <button class="btn btn-icon icon-left btn-danger show_confirm mt-1" ><i class="fas fa-times"></i>Delete All</button>--}}
{{--                    </form>--}}
                    <div class="card mt-3">

              <div class="card-header">
                <h4>Table All Payment</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="table-1">
                    <thead>
                      <tr>
                        <th class="text-center">
                          No
                        </th>
                        <th>Name</th>
                        <th>Number</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $value)
                      <tr>
                        <td>
                          {{ $loop->iteration }}
                        </td>
                        <td>{{ $value->name }}</td>
                        <td >
                        {{ $value->number }}
                        </td>
                        <td>
                            <button class="btn btn-icon editbtn icon-left btn-warning border-0"  data-toggle="modal" data-target="#editModal{{ $value->id }}"><i class="fas fa-exclamation-triangle"></i>Edit</button>
                          <form action="{{route('admin.payments.delete', ['payment' => $value->id]) }} " method="POST" >
                            @method('delete')
                            @csrf
                            <button  class="btn btn-icon icon-left btn-danger show_confirm mt-1 " ><i class="fas fa-times"></i>Delete</button>
                          </form>

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





