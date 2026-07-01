@extends('layouts.main')

@section('title', 'Data Kesatuan')

@section('body')
    {{-- Update folder modal ke folder kesatuan --}}
    @include('unity.modal.edit')
    @include('unity.modal.create')

    <style>
        .equal-btn {
            min-width: 120px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
    </style>

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Kesatuan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('suspect')}}">Dashboard</a></div>
                    <div class="breadcrumb-item">Kesatuan</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Manajemen Kesatuan</h2>
                <p class="section-lead">
                    Kelola informasi daftar kesatuan, seperti menambah, mengubah, dan menghapus data.
                </p>

                <div class="row">
                    <div class="col-12">
                        {{-- Tombol Tambah --}}
                        <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#createModal">
                            <i class="fas fa-plus"></i> Tambah Kesatuan
                        </button>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h4>Tabel Daftar Kesatuan</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                        <tr>
                                            <th class="text-center" width="10%">No</th>
                                            <th>Nama Kesatuan</th>
                                            <th>Tanggal Dibuat</th>
                                            <th width="20%">Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {{-- Pastikan variabel dari Controller diganti (misal: $kesatuans) --}}
                                        @foreach ($data as $kesatuan)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $kesatuan->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($kesatuan->created_at) }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        {{-- Tombol Edit --}}
                                                        <button class="btn btn-icon btn-warning btn-sm mr-2"
                                                                data-toggle="modal"
                                                                data-target="#editModal{{ $kesatuan->id }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>

                                                        {{-- Form Hapus (Hapus proteksi super_admin karena ini data kesatuan) --}}
                                                        <form action="{{route('unities.delete')}}" method="POST">
                                                            @method('delete')
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $kesatuan->id }}">
                                                            <button class="btn btn-icon btn-danger btn-sm show_confirm">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </form>
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
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            if ($("#table-1").length) {
                $("#table-1").DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                    }
                });
            }
        });
    </script>
@endpush
