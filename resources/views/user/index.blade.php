@extends('layouts.main')

@section('body')
@include('user.modal.edit')
@include('user.modal.create')
<style>
    .equal-btn {
        min-width: 120px;            /* same minimum width for both buttons */
        height: 38px;                /* fixed height to match btn-sm visual */
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;                 /* space between icon and text */
        font-size: 0.9rem;           /* consistent text size */
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
</style>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
        <h1>Data Pengguna</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{route('suspect')}}">Dashboard</a></div>
          <div class="breadcrumb-item">Pengguna</div>
        </div>
      </div>

      <div class="section-body">
        <h2 class="section-title">Data Pengguna</h2>
        <p class="section-lead">
          Ubah informasi tentang pengguna, seperti membuat, mengedit dan menghapus
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
                    <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#createModal"><i class="far fa-user"></i>Tambah Pengguna</button>
{{--                    <form action="/user/deleteAll" method="POST" id="delete-all">--}}
{{--                        @csrf--}}
{{--                        <button class="btn btn-icon icon-left btn-danger show_confirm mt-1" ><i class="fas fa-times"></i>Delete All</button>--}}
{{--                    </form>--}}
                    <div class="card mt-3">

              <div class="card-header">
                <h4>Tabel Semua Pengguna</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="table-1">
                    <thead>
                      <tr>
                        <th class="text-center">
                          No
                        </th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Peran</th>
                        <th>Aktif</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($users as $user)
                      <tr>
                        <td>
                          {{ $loop->iteration }}
                        </td>
                        <td>{{ $user->name }}</td>
                        <td >
                        {{ $user->email }}
                        </td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->is_active == 1 ? "Aktif" : "Tidak Aktif" }}</td>
                        <td>
                            <button class="btn btn-icon btn-warning btn-sm mb-1"  data-toggle="modal" data-target="#editModal{{ $user->id }}"><i class="fas fa-exclamation-triangle"></i>Edit</button>
                              @if($user->role !== 'super_admin')
                          <form action="{{route('users.delete')}} " method="POST" >
                            @method('delete')
                            @csrf
                            <button  class="btn btn-icon btn-danger btn-sm show_confirm" ><i class="fas fa-times"></i>Hapus</button>
                              <input type="hidden" name="id" value="{{ $user->id }}">
                          </form>
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





