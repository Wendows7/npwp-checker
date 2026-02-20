{{-- start create modal --}}
<div class="modal fade" tabindex="-1" role="dialog" id="createModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-plus"></i>&nbsp;Add Suspect</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('suspect.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate="">
                <div class="modal-body">
                    @csrf
                    <h6 class="mb-3 text-primary"><i class="fas fa-user"></i>&nbsp;Suspect Information</h6>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nik">NIK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}" required>
                            @error('nik')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="alias">Alias</label>
                            <input type="text" class="form-control" id="alias" name="alias" value="{{ old('alias') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="gender">Gender <span class="text-danger">*</span></label>
                            <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                <option value="">-- Select Gender --</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="place_of_birth">Place of Birth</label>
                            <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date_of_birth">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="age">Age</label>
                            <input type="number" class="form-control" id="age" name="age" value="{{ old('age') }}" min="0">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="religion">Religion</label>
                            <input type="text" class="form-control" id="religion" name="religion" value="{{ old('religion') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="education">Education</label>
                            <input type="text" class="form-control" id="education" name="education" value="{{ old('education') }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="occupation">Occupation</label>
                            <input type="text" class="form-control" id="occupation" name="occupation" value="{{ old('occupation') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="finger_code">Finger Code</label>
                            <input type="text" class="form-control" id="finger_code" name="finger_code" value="{{ old('finger_code') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                        <small class="form-text text-muted">Maksimal 2MB (JPEG, PNG, JPG, GIF)</small>
                        @error('photo')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0 text-primary"><i class="fas fa-gavel"></i>&nbsp;Case Information (Optional)</h6>
                        <button type="button" class="btn btn-sm btn-success" id="addCaseBtn">
                            <i class="fas fa-plus"></i> Add Case
                        </button>
                    </div>

                    <div id="casesContainer">
                        <!-- Case forms will be added here dynamically -->
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;Add Suspect</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let caseIndex = 0;

    const addCaseBtn = document.getElementById('addCaseBtn');
    const casesContainer = document.getElementById('casesContainer');

    if (addCaseBtn) {
        addCaseBtn.addEventListener('click', function() {
            const caseCard = createCaseForm(caseIndex);
            casesContainer.insertAdjacentHTML('beforeend', caseCard);
            caseIndex++;
        });
    }

    // Event delegation for remove buttons
    casesContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-case-btn') || e.target.closest('.remove-case-btn')) {
            const button = e.target.classList.contains('remove-case-btn') ? e.target : e.target.closest('.remove-case-btn');
            const caseCard = button.closest('.case-card');
            caseCard.remove();
        }
    });

    function createCaseForm(index) {
        return `
            <div class="card case-card mb-3">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <span><strong>Case #${index + 1}</strong></span>
                    <button type="button" class="btn btn-sm btn-danger remove-case-btn">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Case Number</label>
                            <input type="text" class="form-control" name="cases[${index}][number]" value="{{ old('cases.${index}.number') }}">
                            <input type="hidden" class="form-control" name="cases[${index}][updated_by]" value="{{ auth()->user()->id }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Case Name</label>
                            <input type="text" class="form-control" name="cases[${index}][name]" value="{{ old('cases.${index}.name') }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Chapter/Pasal</label>
                            <input type="text" class="form-control" name="cases[${index}][chapter]" value="{{ old('cases.${index}.chapter') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Place</label>
                            <input type="text" class="form-control" name="cases[${index}][place]" value="{{ old('cases.${index}.place') }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Date</label>
                            <input type="date" class="form-control" name="cases[${index}][datetime]" value="{{ old('cases.${index}.datetime') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Division</label>
                            <input type="text" class="form-control" name="cases[${index}][division]" value="{{ old('cases.${index}.division') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Decision</label>
                        <input type="text" class="form-control" name="cases[${index}][decision]" value="{{ old('cases.${index}.decision') }}">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="cases[${index}][description]" rows="2">{{ old('cases.${index}.description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Evidence</label>
                        <textarea class="form-control" name="cases[${index}][evidence]" rows="2">{{ old('cases.${index}.evidence') }}</textarea>
                    </div>
                </div>
            </div>
        `;
    }
});
</script>
{{-- end create modal --}}
