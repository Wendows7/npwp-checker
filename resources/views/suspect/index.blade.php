@extends('layouts.main')

@section('body')
@include('suspect.modal.create')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Tersangka</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item">Data Tersangka</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Data Tersangka</h2>
                <p class="section-lead">
                    Kelola informasi tentang tersangka, seperti membuat, mengedit dan menghapus
                </p>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#createModal"><i class="far fa-edit"></i>&nbsp;Add Suspect</button>
                    </div>
{{--                    <div class="col-md-6 text-right">--}}
{{--                        <button class="btn btn-success" data-toggle="modal" data-target="#importModal"><i class="fas fa-file-upload"></i>&nbsp;Import Excel</button>--}}
{{--                    </div>--}}
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Table All Suspect</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>NIK</th>
                                            <th>Name</th>
                                            <th>Alias</th>
                                            <th>Gender</th>
                                            <th>Age</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($suspects as $suspect)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $suspect->nik ?? '-' }}</td>
                                                <td>{{ $suspect->name ?? '-' }}</td>
                                                <td>{{ $suspect->alias ?? '-' }}</td>
                                                <td>
                                                    @if($suspect->gender == 'Male')
                                                        <div class="badge badge-primary">Male</div>
                                                    @elseif($suspect->gender == 'Female')
                                                        <div class="badge badge-danger">Female</div>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $suspect->age ?? '-' }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-primary btn-action mr-1" data-toggle="modal" data-target="#detailModal{{ $suspect->id }}" title="Detail"><i class="fas fa-eye"></i></button>
                                                    <button class="btn btn-warning btn-action mr-1" data-toggle="modal" data-target="#editModal{{ $suspect->id }}" title="Edit"><i class="fas fa-edit"></i></button>
                                                    <form action="{{route('suspect.delete',['suspect' => $suspect->id])}}" method="POST" style="display:inline;">
                                                        @method('delete')
                                                        @csrf
                                                        <button class="btn btn-danger btn-action show_confirm" type="submit" title="Delete"><i class="fas fa-trash"></i></button>
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

                {{-- Modals Section - Outside Table --}}
                @foreach ($suspects as $suspect)
                    @include('suspect.modal.detail')
                    @include('suspect.modal.edit')
                @endforeach

            </div>
        </section>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel"><i class="fas fa-file-upload"></i>&nbsp;Import Data Suspect</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('suspect.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="excel_file">Pilih File Excel</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="excel_file" name="excel_file" accept=".xlsx,.xls,.csv" required>
                                <label class="custom-file-label" for="excel_file">Pilih file...</label>
                            </div>
                            <small class="form-text text-muted">Format yang diterima: .xlsx, .xls, .csv</small>
                            @error('excel_file')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="alert alert-info" role="alert">
                            <strong>Format File:</strong> Pastikan file Excel memiliki kolom-kolom berikut:
                            <ul class="mb-0">
                                <li>nik</li>
                                <li>name</li>
                                <li>alias (optional)</li>
                                <li>gender</li>
                                <li>place_of_birth</li>
                                <li>date_of_birth</li>
                                <li>age</li>
                                <li>religion</li>
                                <li>education</li>
                                <li>occupation</li>
                                <li>address</li>
                                <li>finger_code (optional)</li>
                                <li>photo (optional)</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i>&nbsp;Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Update file label when file is selected
        document.getElementById('excel_file').addEventListener('change', function(e) {
            document.querySelector('.custom-file-label').textContent = e.target.files[0]?.name || 'Pilih file...';
        });

        // Put modals as direct children of <body> to avoid stacking-context/z-index issues
        document.addEventListener('DOMContentLoaded', function () {
            // jQuery used by Bootstrap; if not available adapt to vanilla DOM
            if (window.jQuery) {
                $('.modal').each(function () { $(this).appendTo('body'); });

                // Remove duplicate/leftover backdrops and keep ordering correct
                $(document).on('shown.bs.modal', '.modal', function () {
                    $('.modal-backdrop').slice(1).remove();
                });

                // If all modals closed, remove any leftover backdrop
                $(document).on('hidden.bs.modal', '.modal', function () {
                    if ($('.modal.show').length === 0) {
                        $('.modal-backdrop').remove();
                    }
                });
            } else {
                // Fallback: move modals using vanilla JS
                document.querySelectorAll('.modal').forEach(function (m) {
                    document.body.appendChild(m);
                });
            }
        });
    </script>

@endsection
