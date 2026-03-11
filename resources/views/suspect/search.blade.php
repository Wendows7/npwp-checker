@extends('layouts.main')

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
                <h1>Cek Data</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item">Cek Data</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Pencarian</h2>
                <p class="section-lead">
                    Cari data tersangka berdasarkan NIK, Nama, Nomor Kasus, atau Tanggal Kasus
                </p>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" action="{{ route('suspect.search') }}">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group mb-3 mb-md-0">
                                                <label for="keyword" class="font-weight-bold">Kata Kunci</label>
                                                <input type="text"
                                                       name="keyword"
                                                       id="keyword"
                                                       class="form-control form-control-lg"
                                                       placeholder="Cari berdasarkan NIK, Nama, atau Nomor Kasus"
                                                       value="{{ request('keyword') }}">
                                                <small class="form-text text-muted">
                                                    <i class="fas fa-info-circle"></i> Masukkan NIK, Nama Tersangka, atau Nomor LP
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3 mb-md-0">
                                                <label for="date" class="font-weight-bold">Tanggal Kasus</label>
                                                <input type="date"
                                                       name="date"
                                                       id="date"
                                                       class="form-control form-control-lg"
                                                       value="{{ request('date') }}">
                                                <small class="form-text text-muted">
                                                    <i class="fas fa-calendar"></i> Filter berdasarkan tanggal kasus
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <button class="btn btn-primary btn-lg" type="submit">
                                                <i class="fas fa-search"></i>&nbsp;Cari Data
                                            </button>
                                            <a href="{{ route('suspect') }}" class="btn btn-secondary btn-lg ml-2">
                                                <i class="fas fa-redo"></i>&nbsp;Reset
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($suspects) && $suspects !== null && $suspects->count())
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-check-circle"></i> Hasil Pencarian:</strong> Ditemukan <strong>{{ $suspects->count() }}</strong> data tersangka
                        @if(request('keyword'))
                            dengan kata kunci "<strong>{{ request('keyword') }}</strong>"
                        @endif
                        @if(request('date'))
                            pada tanggal "<strong>{{ \Carbon\Carbon::parse(request('date'))->format('d M Y') }}</strong>"
                        @endif
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(isset($suspects) && $suspects->count())

                    <div class="row">
                        @foreach ($suspects as $suspect)
                            @include('suspect.modal.detail')
                            @include('suspect.modal.detail-case')

                            {{-- Case detail modals --}}
{{--                            @if(!empty($suspect->cases) && is_iterable($suspect->cases))--}}
{{--                                @foreach($suspect->cases as $case)--}}
{{--                                    <div class="modal fade" id="caseDetailModal{{ $case->id }}" tabindex="-1" role="dialog" aria-labelledby="caseDetailLabel{{ $case->id }}" aria-hidden="true">--}}
{{--                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">--}}
{{--                                            <div class="modal-content">--}}
{{--                                                <div class="modal-header">--}}
{{--                                                    <h5 class="modal-title" id="caseDetailLabel{{ $case->id }}">Case: {{ $case->number ?? '-' }}</h5>--}}
{{--                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                                        <span aria-hidden="true">&times;</span>--}}
{{--                                                    </button>--}}
{{--                                                </div>--}}
{{--                                                <div class="modal-body">--}}
{{--                                                    <dl class="row mb-0">--}}
{{--                                                        <dt class="col-4">Case Number</dt>--}}
{{--                                                        <dd class="col-8">{{ $case->number ?? '-' }}</dd>--}}

{{--                                                        <dt class="col-4">Name</dt>--}}
{{--                                                        <dd class="col-8">{{ $case->name ?? '-' }}</dd>--}}

{{--                                                        <dt class="col-4">Chapter / Pasal</dt>--}}
{{--                                                        <dd class="col-8">{{ $case->chapter ?? '-' }}</dd>--}}

{{--                                                        <dt class="col-4">Place</dt>--}}
{{--                                                        <dd class="col-8">{{ $case->place ?? '-' }}</dd>--}}

{{--                                                        <dt class="col-4">Date</dt>--}}
{{--                                                        <dd class="col-8">{{ $case->date ?? $case->created_at ?? '-' }}</dd>--}}

{{--                                                        <dt class="col-4">Decision</dt>--}}
{{--                                                        <dd class="col-8">{{ $case->decision ?? '-' }}</dd>--}}

{{--                                                        <dt class="col-4">Division</dt>--}}
{{--                                                        <dd class="col-8">{{ $case->division ?? '-' }}</dd>--}}

{{--                                                        <dt class="col-4">Description</dt>--}}
{{--                                                        <dd class="col-8">{!! nl2br(e($case->description ?? '-')) !!}</dd>--}}
{{--                                                    </dl>--}}
{{--                                                </div>--}}
{{--                                                <div class="modal-footer">--}}
{{--                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}
{{--                            @endif--}}

                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Left card: string data -->
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <div class="card h-100">
                                                    <div class="card-header">
                                                        <h5 class="mb-0">Detail</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <p><strong>NIK:</strong> {{ $suspect->nik ?? '-' }}</p>
                                                        <p><strong>Nama:</strong> {{ $suspect->name ?? '-' }}</p>
                                                        <p><strong>Jenis Kelamin:</strong> {{ $suspect->gender == 'Male' ? 'Laki-laki' : ($suspect->gender == 'Female' ? 'Perempuan' : ($suspect->gender ?? '-')) }}</p>
                                                        @if(!empty($suspect->place_of_birth))
                                                            <p><strong>Tempat Lahir:</strong> {{ $suspect->place_of_birth }}</p>
                                                        @endif
                                                        @if(!empty($suspect->date_of_birth))
                                                            <p><strong>Tanggal Lahir:</strong> {{ $suspect->date_of_birth }}</p>
                                                        @endif
                                                        {{-- add other string fields as needed --}}
                                                        <div class="mt-3">
                                                            <button class="btn btn-icon icon-left btn-primary mb-1" data-toggle="modal" data-target="#detailModal{{ $suspect->id }}"><i class="fas fa-eye"></i>Detail</button>
{{--                                                            <button class="btn btn-icon editbtn icon-left btn-warning mb-1" data-toggle="modal" data-target="#editModal{{ $suspect->id }}"><i class="fas fa-exclamation-triangle"></i>Edit</button>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Right card: photos / images -->
                                            <div class="col-md-6">
                                                <div class="card h-100">
                                                    <div class="card-header">
                                                        <h5 class="mb-0">Foto</h5>
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
                                                                        <span class="text-muted">Tidak ada gambar</span>
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
                                                    <h6 class="mb-0">Kasus</h6>
                                                </div>
                                                <div class="card-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th class="text-center">#</th>
                                                                <th>No LP</th>
                                                                <th>Jenis Kasus</th>
                                                                <th>Pasal</th>
                                                                <th>Tempat</th>
                                                                <th>Tanggal</th>
{{--                                                                <th>Keputusan</th>--}}
                                                                <th>Divisi</th>
                                                                <th class="text-center">Aksi</th>
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
                                                                    <td>{{ $case->datetime ?? ($case->created_at ?? '-') }}</td>
{{--                                                                    <td>{{ $case->decision ?? '-' }}</td>--}}
                                                                    <td>{{ $case->division ?? '-' }}</td>
{{--                                                                    <td class="text-truncate" style="max-width:200px;">{{ $case->description ?? '-' }}</td>--}}
                                                                    <td class="text-center">
                                                                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#caseDetailModal{{ $case->id }}">Lihat</button>
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
                @elseif(isset($suspects) && $suspects->count() === 0)
                    <div class="alert alert-warning">
                        <h5><i class="fas fa-exclamation-triangle"></i> Tidak ada data ditemukan</h5>
                        <p class="mb-0">
                            Tidak ada data tersangka yang sesuai dengan kriteria pencarian
                            @if(request('keyword'))
                                "<strong>{{ request('keyword') }}</strong>"
                            @endif
                            @if(request('date'))
                                pada tanggal "<strong>{{ \Carbon\Carbon::parse(request('date'))->format('d M Y') }}</strong>"
                            @endif
                            . Silakan coba dengan kata kunci atau tanggal lain.
                        </p>
                    </div>
                @else
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle"></i> Silakan Lakukan Pencarian</h5>
                        <p class="mb-0">Gunakan form pencarian di atas untuk mencari data tersangka berdasarkan NIK, Nama, Nomor Kasus, atau Tanggal Kasus.</p>
                    </div>
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

@endsection
