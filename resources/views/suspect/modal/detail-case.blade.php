@if(!empty($suspect->cases) && is_iterable($suspect->cases))
    @foreach($suspect->cases as $case)
        <div class="modal fade" id="caseDetailModal{{ $case->id }}" tabindex="-1" role="dialog" aria-labelledby="caseDetailLabel{{ $case->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="caseDetailLabel{{ $case->id }}"><i class="fas fa-gavel"></i>&nbsp;Case: {{ $case->number ?? '-' }}</h5>
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
                            <dd class="col-8">{{ $case->datetime ? \Carbon\Carbon::parse($case->datetime)->format('d M Y') : ($case->date ?? ($case->created_at ?? '-')) }}</dd>

                            <dt class="col-4">Decision</dt>
                            <dd class="col-8">{{ $case->decision ?? '-' }}</dd>

                            <dt class="col-4">Division</dt>
                            <dd class="col-8">{{ $case->division ?? '-' }}</dd>

                            <dt class="col-4">Description</dt>
                            <dd class="col-8">{!! nl2br(e($case->description ?? '-')) !!}</dd>

                            <dt class="col-4">Created at</dt>
                            <dd class="col-8">{{ $case->created_at ? \Carbon\Carbon::parse($case->created_at)->format('d M Y H:i') : ($case->created_at ?? ('-')) }}</dd>

                            <dt class="col-4">Updated at</dt>
                            <dd class="col-8">{{ $case->updated_at ? \Carbon\Carbon::parse($case->updated_at)->format('d M Y H:i') : ($case->updated_at ?? ('-')) }}</dd>

                            <dt class="col-4">Updated by</dt>
                            <dd class="col-8">{{ $case->user->name ?? '-' }}</dd>

                            <dt class="col-4">Evidence</dt>
                            <dd class="col-8">{!! nl2br(e($case->evidence ?? '-')) !!}</dd>

                        </dl>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
