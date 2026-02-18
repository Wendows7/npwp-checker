{{-- start edit modal --}}
<div class="modal fade" tabindex="-1" role="dialog" id="editModal{{ $suspect->id }}">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit"></i>&nbsp;Edit Suspect</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('suspect.update', $suspect->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate="">
                <div class="modal-body">
                    @csrf
                    @method('PUT')

                    <h6 class="mb-3 text-primary"><i class="fas fa-user"></i>&nbsp;Suspect Information</h6>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nik_{{ $suspect->id }}">NIK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik_{{ $suspect->id }}" name="nik" value="{{ old('nik', $suspect->nik) }}" required>
                            @error('nik')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name_{{ $suspect->id }}">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name_{{ $suspect->id }}" name="name" value="{{ old('name', $suspect->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="alias_{{ $suspect->id }}">Alias</label>
                            <input type="text" class="form-control" id="alias_{{ $suspect->id }}" name="alias" value="{{ old('alias', $suspect->alias) }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="gender_{{ $suspect->id }}">Gender <span class="text-danger">*</span></label>
                            <select class="form-control @error('gender') is-invalid @enderror" id="gender_{{ $suspect->id }}" name="gender" required>
                                <option value="">-- Select Gender --</option>
                                <option value="Male" {{ old('gender', $suspect->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $suspect->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="place_of_birth_{{ $suspect->id }}">Place of Birth</label>
                            <input type="text" class="form-control" id="place_of_birth_{{ $suspect->id }}" name="place_of_birth" value="{{ old('place_of_birth', $suspect->place_of_birth) }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date_of_birth_{{ $suspect->id }}">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth_{{ $suspect->id }}" name="date_of_birth" value="{{ old('date_of_birth', $suspect->date_of_birth) }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="age_{{ $suspect->id }}">Age</label>
                            <input type="number" class="form-control" id="age_{{ $suspect->id }}" name="age" value="{{ old('age', $suspect->age) }}" min="0">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="religion_{{ $suspect->id }}">Religion</label>
                            <input type="text" class="form-control" id="religion_{{ $suspect->id }}" name="religion" value="{{ old('religion', $suspect->religion) }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="education_{{ $suspect->id }}">Education</label>
                            <input type="text" class="form-control" id="education_{{ $suspect->id }}" name="education" value="{{ old('education', $suspect->education) }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="occupation_{{ $suspect->id }}">Occupation</label>
                            <input type="text" class="form-control" id="occupation_{{ $suspect->id }}" name="occupation" value="{{ old('occupation', $suspect->occupation) }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="finger_code_{{ $suspect->id }}">Finger Code</label>
                            <input type="text" class="form-control" id="finger_code_{{ $suspect->id }}" name="finger_code" value="{{ old('finger_code', $suspect->finger_code) }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address_{{ $suspect->id }}">Address</label>
                        <textarea class="form-control" id="address_{{ $suspect->id }}" name="address" rows="3">{{ old('address', $suspect->address) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="photo_{{ $suspect->id }}">Photo</label>
                        @if(!empty($suspect->photo))
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $suspect->photo) }}" width="100" alt="photo" class="rounded">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo_{{ $suspect->id }}" name="photo" accept="image/*">
                        <small class="form-text text-muted">Maksimal 2MB (JPEG, PNG, JPG, GIF)</small>
                        @error('photo')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0 text-primary"><i class="fas fa-gavel"></i>&nbsp;Case Information (Optional)</h6>
                        <button type="button" class="btn btn-sm btn-success add-case-btn-edit" data-suspect-id="{{ $suspect->id }}">
                            <i class="fas fa-plus"></i> Add Case
                        </button>
                    </div>

                    <div id="casesContainerEdit{{ $suspect->id }}" class="cases-container-edit">
                        @if($suspect->cases && $suspect->cases->count() > 0)
                            @foreach($suspect->cases as $caseIndex => $case)
                                <div class="card case-card mb-3">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <span><strong>Case #{{ $caseIndex + 1 }}</strong></span>
                                        <button type="button" class="btn btn-sm btn-danger remove-case-btn-edit">
                                            <i class="fas fa-trash"></i> Remove
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" name="cases[{{ $caseIndex }}][id]" value="{{ $case->id }}">

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Case Number</label>
                                                <input type="text" class="form-control" name="cases[{{ $caseIndex }}][number]" value="{{ old('cases.'.$caseIndex.'.number', $case->number) }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Case Name</label>
                                                <input type="text" class="form-control" name="cases[{{ $caseIndex }}][name]" value="{{ old('cases.'.$caseIndex.'.name', $case->name) }}">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Chapter/Pasal</label>
                                                <input type="text" class="form-control" name="cases[{{ $caseIndex }}][chapter]" value="{{ old('cases.'.$caseIndex.'.chapter', $case->chapter) }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Place</label>
                                                <input type="text" class="form-control" name="cases[{{ $caseIndex }}][place]" value="{{ old('cases.'.$caseIndex.'.place', $case->place) }}">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Date & Time</label>
                                                <input type="datetime" class="form-control" name="cases[{{ $caseIndex }}][datetime]" value="{{ old('cases.'.$caseIndex.'.datetime', $case->datetime) }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Division</label>
                                                <input type="text" class="form-control" name="cases[{{ $caseIndex }}][division]" value="{{ old('cases.'.$caseIndex.'.division', $case->division) }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Decision</label>
                                            <input type="text" class="form-control" name="cases[{{ $caseIndex }}][decision]" value="{{ old('cases.'.$caseIndex.'.decision', $case->decision) }}">
                                        </div>

                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name="cases[{{ $caseIndex }}][description]" rows="2">{{ old('cases.'.$caseIndex.'.description', $case->description) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;Update Suspect</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const suspectId = {{ $suspect->id }};
    let caseIndexEdit{{ $suspect->id }} = {{ $suspect->cases ? $suspect->cases->count() : 0 }};

    const addCaseBtnEdit = document.querySelector('.add-case-btn-edit[data-suspect-id="{{ $suspect->id }}"]');
    const casesContainerEdit = document.getElementById('casesContainerEdit{{ $suspect->id }}');

    if (addCaseBtnEdit) {
        addCaseBtnEdit.addEventListener('click', function() {
            const caseCard = createCaseFormEdit(caseIndexEdit{{ $suspect->id }});
            casesContainerEdit.insertAdjacentHTML('beforeend', caseCard);
            caseIndexEdit{{ $suspect->id }}++;
        });
    }

    // Event delegation for remove buttons
    if (casesContainerEdit) {
        casesContainerEdit.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-case-btn-edit') || e.target.closest('.remove-case-btn-edit')) {
                const button = e.target.classList.contains('remove-case-btn-edit') ? e.target : e.target.closest('.remove-case-btn-edit');
                const caseCard = button.closest('.case-card');
                caseCard.remove();
            }
        });
    }

    function createCaseFormEdit(index) {
        return `
            <div class="card case-card mb-3">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <span><strong>Case #${index + 1}</strong></span>
                    <button type="button" class="btn btn-sm btn-danger remove-case-btn-edit">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Case Number</label>
                            <input type="text" class="form-control" name="cases[${index}][number]">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Case Name</label>
                            <input type="text" class="form-control" name="cases[${index}][name]">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Chapter/Pasal</label>
                            <input type="text" class="form-control" name="cases[${index}][chapter]">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Place</label>
                            <input type="text" class="form-control" name="cases[${index}][place]">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Date & Time</label>
                            <input type="datetime-local" class="form-control" name="cases[${index}][datetime]">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Division</label>
                            <input type="text" class="form-control" name="cases[${index}][division]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Decision</label>
                        <input type="text" class="form-control" name="cases[${index}][decision]">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="cases[${index}][description]" rows="2"></textarea>
                    </div>
                </div>
            </div>
        `;
    }
});
</script>
{{-- end edit modal --}}
