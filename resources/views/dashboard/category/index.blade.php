@extends('dashboard.layouts.main')

@section('body')
@include('dashboard/category/modal/edit')
@include('dashboard/category/modal/create')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
        <h1>Data Category</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="/dashboard">Dashboard</a></div>
          <div class="breadcrumb-item">Categories</div>
        </div>
      </div>

      <div class="section-body">
        <h2 class="section-title">Data Category</h2>
        <p class="section-lead">
          Change information about category product, like create, edit and delete
        </p>

        <div class="row">
          <div class="col-12">
           <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#createModal"><i class="far fa-user"></i>Add Category</button>
            <div class="card mt-3">
              <div class="card-header">
                <h4>Table All Parameter</h4>
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
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($categories as $category)
                      <tr>
                        <td>
                          {{ $loop->iteration }}
                        </td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <button class="btn btn-icon editbtn icon-left btn-warning border-0"  data-toggle="modal" data-target="#editModal{{ $category->id }}"><i class="fas fa-exclamation-triangle"></i>Edit</button>
                          <form action="{{route('admin.category.delete')}}" method="POST">
                              @method('delete')
                            @csrf
                              <input type="hidden" name="id" value="{{$category->id}}">
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





