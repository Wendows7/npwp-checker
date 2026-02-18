@extends('dashboard.layouts.main')

@section('body')

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
                <h1>Check Data</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item">Check Data</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Search & Import</h2>
                <p class="section-lead">
                    Cari dan cek data tersangka atau import data dari Excel
                </p>

                <div class="row mb-3">
                    <div class="col-md-8">
                        <form class="form-inline" method="GET" action="{{ route('suspect.search') }}">
                            <div class="input-group w-100">
                                <input type="text" name="slug" class="form-control" placeholder="Search by NIK" value="{{ request('nik') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i>&nbsp;Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4 text-right">
                        <button class="btn btn-success" data-toggle="modal" data-target="#importModal"><i class="fas fa-file-upload"></i>&nbsp;Import Excel</button>
                    </div>
                </div>

                @if(isset($suspects) && $suspects->count())

                    <div class="row">
                        @foreach ($suspects as $suspect)
                            @include('dashboard/suspect/modal/detail')

                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Left card: string data -->
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <div class="card h-100">
                                                    <div class="card-header">
                                                        <h5 class="mb-0">Details</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <p><strong>NIK:</strong> {{ $suspect->nik ?? '-' }}</p>
                                                        <p><strong>Name:</strong> {{ $suspect->name ?? '-' }}</p>
                                                        <p><strong>Alias:</strong> {{ $suspect->alias ?? '-' }}</p>
                                                        <p><strong>Gender:</strong> {{ $suspect->gender ?? '-' }}</p>
                                                        <p><strong>Place of Birth:</strong> {{ $suspect->place_of_birth ?? '-' }}</p>
                                                        <p><strong>Date of Birth:</strong> {{ $suspect->date_of_birth ?? '-' }}</p>
                                                        <p><strong>Age:</strong> {{ $suspect->age ?? '-' }}</p>
                                                        <p><strong>Religion:</strong> {{ $suspect->religion ?? '-' }}</p>
                                                        <p><strong>Education:</strong> {{ $suspect->education ?? '-' }}</p>
                                                        <p><strong>Occupation:</strong> {{ $suspect->occupation ?? '-' }}</p>
                                                        <p><strong>Address:</strong> {{ $suspect->address ?? '-' }}</p>
                                                        <p><strong>Finger Code:</strong> {{ $suspect->finger_code ?? '-' }}</p>
                                                        <div class="mt-3">
                                                            <button class="btn btn-icon icon-left btn-primary equal-btn btn-sm mb-1" data-toggle="modal" data-target="#detailModal{{ $suspect->id }}"><i class="fas fa-eye"></i>&nbsp;Detail</button>
                                                            <button class="btn btn-icon editbtn icon-left btn-warning equal-btn btn-sm border-0 mb-1" data-toggle="modal" data-target="#editModal{{ $suspect->id }}"><i class="fas fa-exclamation-triangle"></i>&nbsp;Edit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Right card: photos / images -->
                                            <div class="col-md-6">
                                                <div class="card h-100">
                                                    <div class="card-header">
                                                        <h5 class="mb-0">Photos</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            {{-- Single photo field --}}
                                                            @if(!empty($suspect->photo))
                                                                <div class="col-12 text-center">
                                                                    <img src="{{ asset('storage/' . $suspect->photo) }}" alt="photo-{{ $suspect->id }}" class="img-fluid rounded" style="max-height: 300px; object-fit: contain;">
                                                                </div>

                                                                {{-- Multiple images relation/array, e.g. $suspect->images --}}
                                                            @elseif(!empty($suspect->images) && is_iterable($suspect->images) && count($suspect->images))
                                                                @foreach($suspect->images as $img)
                                                                    <div class="col-6 mb-2">
                                                                        <img src="{{ asset('storage/' . ($img->path ?? $img)) }}" alt="img-{{ $suspect->id }}" class="img-fluid rounded" style="max-height: 150px; object-fit: cover; width:100%;">
                                                                    </div>
                                                                @endforeach

                                                                {{-- Fallback placeholder --}}
                                                            @else
                                                                <div class="col-12 text-center">
                                                                    <div class="border rounded d-flex align-items-center justify-content-center" style="height:200px;">
                                                                        <span class="text-muted">No image available</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> {{-- end inner row --}}

                                        {{-- Cases table: place this inside each suspect card (e.g. after the Details block) --}}
                                        @if(!empty($suspect->cases) && is_iterable($suspect->cases) && count($suspect->cases))
                                            <div class="card mt-3">
                                                <div class="card-header">
                                                    <h6 class="mb-0">Cases</h6>
                                                </div>
                                                <div class="card-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th class="text-center">#</th>
                                                                <th>No Kasus</th>
                                                                <th>Nama</th>
                                                                <th>Pasal</th>
                                                                <th>Tempat</th>
                                                                <th>Tanggal</th>
                                                                <th>Keputusan</th>
                                                                <th>Divisi</th>
                                                                <th class="text-center">Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($suspect->cases as $case)
                                                                <tr>
                                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                                    <td>{{ $case->number ?? '-' }}</td>
                                                                    <td>{{ $case->name ?? '-' }}</td>
                                                                    <td>{{ $case->chapter ?? '-' }}</td>
                                                                    <td>{{ $case->place ?? '-' }}</td>
                                                                    <td>{{ $case->date ?? ($case->created_at ?? '-') }}</td>
                                                                    <td>{{ $case->decision ?? '-' }}</td>
                                                                    <td>{{ $case->division ?? '-' }}</td>
{{--                                                                    <td class="text-truncate" style="max-width:200px;">{{ $case->description ?? '-' }}</td>--}}
                                                                    <td class="text-center">
                                                                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#caseDetailModal{{ $case->id }}">View</button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">No suspects found.</div>
                @endif

            </div>
        </section>
    </div>
    <script>
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
            const fileName = e.target.files[0]?.name || 'Pilih file...';
            document.querySelector('.custom-file-label').textContent = fileName;
        });
    </script>

@endsection
