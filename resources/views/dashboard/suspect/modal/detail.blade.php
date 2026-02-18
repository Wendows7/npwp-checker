<!-- Suspect detail modal -->
<div class="modal fade" id="detailModal{{ $suspect->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $suspect->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel{{ $suspect->id }}">Suspect: {{ $suspect->name ?? '-' }} ({{ $suspect->nik ?? '-' }})</h5>
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

                            <dt class="col-4">Name</dt>
                            <dd class="col-8">{{ $suspect->name ?? '-' }}</dd>

                            <dt class="col-4">Alias</dt>
                            <dd class="col-8">{{ $suspect->alias ?? '-' }}</dd>

                            <dt class="col-4">Gender</dt>
                            <dd class="col-8">{{ $suspect->gender ?? '-' }}</dd>

                            <dt class="col-4">Age</dt>
                            <dd class="col-8">{{ $suspect->age ?? '-' }}</dd>

                            <dt class="col-4">Place of Birth</dt>
                            <dd class="col-8">{{ $suspect->place_of_birth ?? '-' }}</dd>

                            <dt class="col-4">Date of Birth</dt>
                            <dd class="col-8">{{ $suspect->date_of_birth ?? '-' }}</dd>

                            <dt class="col-4">Address</dt>
                            <dd class="col-8">{{ $suspect->address ?? '-' }}</dd>

                            <dt class="col-4">Religion</dt>
                            <dd class="col-8">{{ $suspect->religion ?? '-' }}</dd>

                            <dt class="col-4">Education</dt>
                            <dd class="col-8">{{ $suspect->education ?? '-' }}</dd>

                            <dt class="col-4">Occupation</dt>
                            <dd class="col-8">{{ $suspect->occupation ?? '-' }}</dd>

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
                                <span class="text-muted">No image available</span>
                            </div>
                        @endif
                    </div>
                </div>

{{--                --}}{{-- Cases inside modal --}}
{{--                @if(!empty($suspect->cases) && is_iterable($suspect->cases) && count($suspect->cases))--}}
{{--                    <hr>--}}
{{--                    <h6>Cases</h6>--}}
{{--                    <div class="table-responsive">--}}
{{--                        <table class="table table-sm mb-0">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>#</th>--}}
{{--                                <th>No Kasus</th>--}}
{{--                                <th>Nama</th>--}}
{{--                                <th>Pasal</th>--}}
{{--                                <th>Tempat</th>--}}
{{--                                <th>Tanggal</th>--}}
{{--                                <th class="text-center">Action</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @foreach($suspect->cases as $case)--}}
{{--                                <tr>--}}
{{--                                    <td>{{ $loop->iteration }}</td>--}}
{{--                                    <td>{{ $case->number ?? '-' }}</td>--}}
{{--                                    <td>{{ $case->name ?? '-' }}</td>--}}
{{--                                    <td>{{ $case->chapter ?? '-' }}</td>--}}
{{--                                    <td>{{ $case->place ?? '-' }}</td>--}}
{{--                                    <td>{{ $case->date ?? ($case->created_at ?? '-') }}</td>--}}
{{--                                    <td class="text-center">--}}
{{--                                        <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-dismiss="modal" data-target="#caseDetailModal{{ $case->id }}" >View</button>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                @endif--}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Case detail modal(s) -->
@foreach($suspect->cases ?? [] as $case)
    <div class="modal fade" id="caseDetailModal{{ $case->id }}" tabindex="-1" role="dialog" aria-labelledby="caseDetailLabel{{ $case->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="caseDetailLabel{{ $case->id }}">Case: {{ $case->number ?? '-' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <dl class="row mb-0">
                        <dt class="col-4">Case Number</dt>
                        <dd class="col-8">{{ $case->number ?? '-' }}</dd>

                        <dt class="col-4">Name</dt>
                        <dd class="col-8">{{ $case->name ?? '-' }}</dd>

                        <dt class="col-4">Chapter / Pasal</dt>
                        <dd class="col-8">{{ $case->chapter ?? '-' }}</dd>

                        <dt class="col-4">Place</dt>
                        <dd class="col-8">{{ $case->place ?? '-' }}</dd>

                        <dt class="col-4">Date</dt>
                        <dd class="col-8">{{ $case->datetime ?? '-' }}</dd>

                        <dt class="col-4">Decision</dt>
                        <dd class="col-8">{{ $case->decision ?? '-' }}</dd>

                        <dt class="col-4">Division</dt>
                        <dd class="col-8">{{ $case->division ?? '-' }}</dd>

                        <dt class="col-4">Description</dt>
                        <dd class="col-8">{!! nl2br(e($case->description ?? '-')) !!}</dd>
                    </dl>

                    {{-- case attachments/images if any --}}
                    @if(!empty($case->attachments) && is_iterable($case->attachments) && count($case->attachments))
                        <hr>
                        <div class="row">
                            @foreach($case->attachments as $att)
                                <div class="col-6 mb-2">
                                    <img src="{{ asset('storage/' . ($att->path ?? $att)) }}" class="img-fluid rounded" style="height:150px; width:100%; object-fit:cover;" alt="att-{{ $case->id }}">
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
