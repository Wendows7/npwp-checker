<!-- Suspect detail modal -->
<div class="modal fade" id="detailModal{{ $suspect->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $suspect->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel{{ $suspect->id }}">Tersangka: {{ $suspect->name ?? '-' }} ({{ $suspect->nik ?? '-' }})</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Left: string data -->
                    <div class="col-md-6">
                        <dl class="row mb-0">
                            <dt class="col-4">NIK</dt>
                            <dd class="col-8">{{ $suspect->nik ?? '-' }}</dd>

                            <dt class="col-4">Nama</dt>
                            <dd class="col-8">{{ $suspect->name ?? '-' }}</dd>

                            <dt class="col-4">Alias</dt>
                            <dd class="col-8">{{ $suspect->alias ?? '-' }}</dd>

                            <dt class="col-4">Jenis Kelamin</dt>
                            <dd class="col-8">{{ $suspect->gender == 'Male' ? 'Laki-laki' : ($suspect->gender == 'Female' ? 'Perempuan' : ($suspect->gender ?? '-')) }}</dd>

                            <dt class="col-4">Umur</dt>
                            <dd class="col-8">{{ $suspect->age ?? '-' }}</dd>

                            <dt class="col-4">Tempat Lahir</dt>
                            <dd class="col-8">{{ $suspect->place_of_birth ?? '-' }}</dd>

                            <dt class="col-4">Tanggal Lahir</dt>
                            <dd class="col-8">{{ $suspect->date_of_birth ?? '-' }}</dd>

                            <dt class="col-4">Alamat</dt>
                            <dd class="col-8">{{ $suspect->address ?? '-' }}</dd>

                            <dt class="col-4">Agama</dt>
                            <dd class="col-8">{{ $suspect->religion ?? '-' }}</dd>

                            <dt class="col-4">Pendidikan</dt>
                            <dd class="col-8">{{ $suspect->education ?? '-' }}</dd>

                            <dt class="col-4">Pekerjaan</dt>
                            <dd class="col-8">{{ $suspect->occupation ?? '-' }}</dd>

                            <dt class="col-4">Kode Sidik Jari</dt>
                            <dd class="col-8">{{ $suspect->finger_code ?? '-' }}</dd>

                        </dl>
                    </div>

                    <!-- Right: photos -->
                    <div class="col-md-6">
                        @if(!empty($suspect->photo))
                            <div class="mb-3 text-center">
                                <img src="{{ asset('storage/' . $suspect->photo) }}" alt="photo-{{ $suspect->id }}" class="img-fluid rounded" style="max-height:300px; object-fit:contain;">
                            </div>
                        @elseif(!empty($suspect->images) && is_iterable($suspect->images) && count($suspect->images))
                            <div class="row">
                                @foreach($suspect->images as $img)
                                    <div class="col-6 mb-2">
                                        <img src="{{ asset('storage/' . ($img->path ?? $img)) }}" alt="img-{{ $suspect->id }}" class="img-fluid rounded" style="height:120px; width:100%; object-fit:cover;">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="border rounded d-flex align-items-center justify-content-center" style="height:200px;">
                                <span class="text-muted">Tidak ada gambar</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Cases List --}}
                @if(!empty($suspect->cases) && is_iterable($suspect->cases) && count($suspect->cases))
                    <div class="card mt-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-gavel"></i>&nbsp;Kasus ({{ $suspect->cases->count() }})</h6>
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
                                        <th>TKP</th>
                                        <th>Tanggal</th>
{{--                                        <th>Keputusan</th>--}}
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
                                            <td>{{ $case->datetime ? \Carbon\Carbon::parse($case->datetime)->format('d M Y') : ($case->date ?? ($case->created_at ?? '-')) }}</td>
{{--                                            <td>{{ $case->decision ?? '-' }}</td>--}}
                                            <td>{{ $case->division ?? '-' }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#caseDetailModal{{ $case->id }}">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </button>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- Include Case Detail Modals --}}
@include('suspect.modal.detail-case')

