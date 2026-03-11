@if(!empty($suspect->cases) && is_iterable($suspect->cases))
    @foreach($suspect->cases as $case)
        <div class="modal fade" id="caseDetailModal{{ $case->id }}" tabindex="-1" role="dialog" aria-labelledby="caseDetailLabel{{ $case->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="caseDetailLabel{{ $case->id }}"><i class="fas fa-gavel"></i>&nbsp;Kasus: {{ $case->number ?? '-' }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <dl class="row mb-0">
                            <dt class="col-4">Nomor Kasus</dt>
                            <dd class="col-8">{{ $case->number ?? '-' }}</dd>

                            <dt class="col-4">Nama</dt>
                            <dd class="col-8">{{ $case->name ?? '-' }}</dd>

                            <dt class="col-4">Pasal</dt>
                            <dd class="col-8">{{ $case->chapter ?? '-' }}</dd>

                            <dt class="col-4">TKP</dt>
                            <dd class="col-8">{{ $case->place ?? '-' }}</dd>

                            <dt class="col-4">Tanggal</dt>
                            <dd class="col-8">{{ $case->datetime ? \Carbon\Carbon::parse($case->datetime)->format('d M Y') : ($case->date ?? ($case->created_at ?? '-')) }}</dd>

{{--                            <dt class="col-4">Decision</dt>--}}
{{--                            <dd class="col-8">{{ $case->decision ?? '-' }}</dd>--}}

                            <dt class="col-4">Divisi</dt>
                            <dd class="col-8">{{ $case->division ?? '-' }}</dd>

                            <dt class="col-4">Deskripsi</dt>
                            <dd class="col-8">{!! nl2br(e($case->description ?? '-')) !!}</dd>

                            <dt class="col-4">Dibuat pada</dt>
                            <dd class="col-8">{{ $case->created_at ? \Carbon\Carbon::parse($case->created_at)->format('d M Y H:i') : ($case->created_at ?? ('-')) }}</dd>

                            <dt class="col-4">Diupdate pada</dt>
                            <dd class="col-8">{{ $case->updated_at ? \Carbon\Carbon::parse($case->updated_at)->format('d M Y H:i') : ($case->updated_at ?? ('-')) }}</dd>

                            <dt class="col-4">Diupdate oleh</dt>
                            <dd class="col-8">{{ $case->user->name ?? '-' }}</dd>

                            <dt class="col-4">Barang Bukti</dt>
                            <dd class="col-8">{!! nl2br(e($case->evidence ?? '-')) !!}</dd>

                            <dt class="col-4">Foto Barang Bukti</dt>
                            <dd class="col-8">
                                @if(!empty($case->photo_evidence))
                                    <img src="{{ asset('storage/' . $case->photo_evidence) }}" alt="evidence-{{ $case->id }}" class="img-fluid rounded" style="max-height:200px; object-fit:contain;">
                                @else
                                    -
                                @endif
                            </dd>

                        </dl>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
