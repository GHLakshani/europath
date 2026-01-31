@extends('layouts.master')

@section('Name', 'Update Candidate ')

@section('content')
<!-- the #js-page-content id is needed for some plugins to initialize -->
<main id="js-page-content" role="main" class="page-content">

    <div class="subheader">
        <h1 class="subheader-Name">
            <i class='subheader-icon fal fa-chart-area'></i> Update Candidate  <span class='fw-300'></span>
        </h1>

        <div class="row" style="margin-left:auto; margin-right:auto; gap: 12px">
            <a href=" {{ route('candidate.create') }}">
            <button type="button" class="btn btn-lg btn-primary">
                <span class="mr-1 fal fa-plus"></span>
                Add New
            </button>
            </a>
            <a href=" {{ route('candidate.index') }}">
            <button type="button" class="btn btn-lg btn-primary">
                <span class="mr-1 fal fa-list"></span>
                View All
            </button>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        {{-- Update <span class="fw-300"><i>candidate</i></span> --}}
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-Name="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-Name="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">

                        <form action="{{ route('candidate.update',$candidate->id) }}" enctype="multipart/form-data" method="post" id="user-form" class="smart-form row" autocomplete="off" >
                            @csrf
                            @method('put')

                            {{-- PHOTO --}}
                            <h5 class="mt-4 mb-3 col-12">Candidate Photo</h5>

                            <div class="mb-3 col-6">
                                <input type="file" name="photo" class="form-control">
                            </div>
                            <div class="mb-3 col-6">
                                @if($candidate->photo)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/app/public/'.$candidate->photo) }}"
                                            alt="Candidate Photo"
                                            width="80"
                                            class="img-thumbnail">
                                    </div>
                                @endif
                            </div>

                                <hr>

                            {{-- BASIC DETAILS --}}
                            <h5 class="mt-4 mb-3 col-12">Basic Details</h5>
                            <div class="col-md-6">
                                <label>Registration No *</label>
                                <input type="text" name="registration_no" class="form-control" value="{{ old('registration_no', $candidate->registration_no) }}">
                            </div>

                            <div class="col-md-6">
                                <label>Reference No</label>
                                <input type="text" name="reference_no" class="form-control" value="{{ old('reference_no', $candidate->reference_no) }}">
                            </div>

                            <div class="col-md-12">
                                <label>Full Name *</label>
                                <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $candidate->full_name) }}">
                            </div>

                            <hr>

                            {{-- IDENTITY --}}
                            <h5 class="mt-4 mb-3 col-12">Identity</h5>
                            <div class="col-md-4">
                                <label>NIC *</label>
                                <input type="text" name="nic" class="form-control" value="{{ old('nic', $candidate->nic) }}">
                            </div>

                            <div class="col-md-4">
                                <label>Passport No</label>
                                <input type="text" name="passport_no" class="form-control" value="{{ old('passport_no', $candidate->passport_no) }}">
                            </div>

                            <div class="col-md-4">
                                <label>Passport Expiry</label>
                                <input type="date" name="passport_expiry" class="form-control" value="{{ old('passport_expiry', optional($candidate->passport_expiry)->format('Y-m-d')) }}">
                            </div>

                            <hr>

                            {{-- PERSONAL --}}
                            <h5 class="mt-4 mb-3 col-12">Personal</h5>
                            <div class="col-md-4">
                                <label>DOB</label>
                                <input type="date" name="dob" class="form-control" value="{{ old('dob', optional($candidate->dob)->format('Y-m-d')) }}">
                            </div>

                            <div class="col-md-4">
                                <label>Age</label>
                                <input type="number" name="age" class="form-control" value="{{ old('age', $candidate->age) }}">
                            </div>

                            <div class="col-md-4">
                                <label>Place of Birth</label>
                                <input type="text" name="place_of_birth" class="form-control" value="{{ old('place_of_birth', $candidate->place_of_birth) }}">
                            </div>

                            <div class="col-md-12">
                                <label>Address</label>
                                <textarea name="address" class="form-control">{{ old('address', $candidate->address) }}</textarea>
                            </div>

                            <hr>

                            {{-- CONTACT --}}
                            <h5 class="mt-4 mb-3 col-12">Contact</h5>
                            <div class="col-md-6">
                                <label>Contact No 1 *</label>
                                <input type="text" name="contact_number_1" class="form-control" value="{{ old('contact_number_1', $candidate->contact_number_1) }}">
                            </div>

                            <div class="col-md-6">
                                <label>Contact No 2</label>
                                <input type="text" name="contact_number_2" class="form-control" value="{{ old('contact_number_2', $candidate->contact_number_2) }}">
                            </div>

                            <div class="col-md-6">
                                <label>Nationality</label>
                                <input type="text" name="nationality" class="form-control" value="{{ old('nationality', $candidate->nationality) }}">
                            </div>

                            <div class="col-md-6">
                                <label>Religion</label>
                                <input type="text" name="religion" class="form-control" value="{{ old('religion', $candidate->religion) }}">
                            </div>

                            <hr>

                            {{-- FAMILY --}}
                            <h5 class="mt-4 mb-3 col-12">Family</h5>
                            <div class="col-md-6">
                                <label>Father Name</label>
                                <input type="text" name="father_name" class="form-control" value="{{ old('father_name', $candidate->father_name) }}">
                            </div>

                            <div class="col-md-6">
                                <label>Mother Name</label>
                                <input type="text" name="mother_name" class="form-control" value="{{ old('mother_name', $candidate->mother_name) }}">
                            </div>

                            <div class="col-md-6">
                                <label>Civil Status</label>
                                <select name="civil_status" class="form-control">
                                    <option value="">-- Select --</option>
                                    <option {{ $candidate->civil_status == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option {{ $candidate->civil_status == 'Married' ? 'selected' : '' }}>Married</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>No of Children</label>
                                <input type="number" name="no_of_children" class="form-control" value="{{ old('no_of_children', $candidate->no_of_children) }}">
                            </div>

                            <hr>

                            {{-- PHYSICAL --}}
                            <h5 class="mt-4 mb-3 col-12">Physical</h5>
                            <div class="col-md-6">
                                <label>Height (cm)</label>
                                <input type="number" name="height_cm" class="form-control" value="{{ old('height_cm', $candidate->height_cm) }}">
                            </div>

                            <div class="col-md-6">
                                <label>Weight (kg)</label>
                                <input type="number" name="weight_kg" class="form-control" value="{{ old('weight_kg', $candidate->weight_kg) }}">
                            </div>

                            <hr>

                            {{-- EDUCATION / EXPERIENCE / LANGUAGE --}}
                            <h5 class="mt-4 col-12">Educational Qualifications</h5>

                            <div id="education-wrapper">
                                @foreach($candidate->educations as $i => $edu)
                                    <div class="mb-2 row education-row">
                                        <input type="hidden" name="educations[{{ $i }}][id]" value="{{ $edu->id }}">

                                        <div class="col-4">
                                            <input type="text" name="educations[{{ $i }}][institute_name]"
                                                class="form-control" value="{{ $edu->institute_name }}">
                                        </div>

                                        <div class="col-4">
                                            <input type="text" name="educations[{{ $i }}][course]"
                                                class="form-control" value="{{ $edu->course }}">
                                        </div>

                                        <div class="col-2">
                                            <input type="text" name="educations[{{ $i }}][duration]"
                                                class="form-control" value="{{ $edu->duration }}">
                                        </div>

                                        <div class="col-1">
                                            <button type="button" class="btn btn-danger remove-education">×</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="btn btn-sm btn-primary" onclick="addEducationRow()">
                                + Add Education
                            </button>

                            <h5 class="mt-4 col-12">Professional Experience</h5>

                            <div id="experience-wrapper">
                                @foreach($candidate->experiences as $i => $exp)
                                    <div class="mb-2 row experience-row">
                                        <input type="hidden" name="experiences[{{ $i }}][id]" value="{{ $exp->id }}">

                                        <div class="col-md-4">
                                            <input type="text" name="experiences[{{ $i }}][employer_name]"
                                                class="form-control" value="{{ $exp->employer_name }}">
                                        </div>

                                        <div class="col-md-3">
                                            <input type="text" name="experiences[{{ $i }}][position]"
                                                class="form-control" value="{{ $exp->position }}">
                                        </div>

                                        <div class="col-md-3">
                                            <input type="text" name="experiences[{{ $i }}][duration]"
                                                class="form-control" value="{{ $exp->duration }}">
                                        </div>

                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger remove-experience">×</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="btn btn-sm btn-primary" onclick="addExperienceRow()">
                                + Add Experience
                            </button>

                            <h5 class="mt-4 col-12">Languages</h5>

                            <div id="language-wrapper">
                                @foreach($candidate->languages as $i => $lang)
                                    <div class="mb-2 row language-row">
                                        <input type="hidden" name="languages[{{ $i }}][id]" value="{{ $lang->id }}">

                                        <div class="col-md-3">
                                            <input type="text"
                                                name="languages[{{ $i }}][language]"
                                                class="form-control"
                                                value="{{ $lang->language }}">
                                        </div>

                                        <div class="col-md-2">
                                            <input type="text"
                                                name="languages[{{ $i }}][understanding]"
                                                class="form-control"
                                                value="{{ $lang->understanding }}">
                                        </div>

                                        <div class="col-md-2">
                                            <input type="text"
                                                name="languages[{{ $i }}][speaking]"
                                                class="form-control"
                                                value="{{ $lang->speaking }}">
                                        </div>

                                        <div class="col-md-2">
                                            <input type="text"
                                                name="languages[{{ $i }}][writing]"
                                                class="form-control"
                                                value="{{ $lang->writing }}">
                                        </div>

                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger remove-language">×</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="btn btn-sm btn-primary" onclick="addLanguageRow()">
                                + Add Language
                            </button>



                            <hr>

                            {{-- JOB & AGENT --}}
                            <h5 class="mt-4 mb-3 col-12">Job & Agent</h5>

                            <div class="mb-3 col-6">
                                <label class="form-label">Country *</label>
                                <select name="country_id" class="form-control">
                                    <option value="">-- Select --</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country_id', $candidate->country_id ?? '') == $country->id ? 'selected' : '' }}>
                                            {{ $country->country_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 col-6">
                                <label class="form-label">Job *</label>
                                <select name="job_id" class="form-control">
                                    <option value="">-- Select --</option>
                                    @foreach($jobs as $job)
                                        <option value="{{ $job->id }}" {{ old('job_id', $candidate->job_id ?? '') == $job->id ? 'selected' : '' }}>
                                            {{ $job->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 col-6">
                                <label class="form-label">Agent</label>
                                <select name="agent_id" class="form-control">
                                    <option value="">-- Select --</option>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}" {{ old('agent_id', $candidate->agent_id ?? '') == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 col-6">
                                <label class="form-label">Sub Dealer</label>
                                <select name="sub_dealer_id" class="form-control">
                                    <option value="">-- Select --</option>
                                    @foreach($subDealers as $dealers)
                                        <option value="{{ $dealers->id }}" {{ old('sub_dealer_id', $candidate->sub_dealer_id ?? '') == $dealers->id ? 'selected' : '' }}>{{ $dealers->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- DOCUMENT CHECKLIST --}}
                            <h5 class="mt-4 mb-3 col-12">Document Checklist</h5>

                            @foreach($documentTypes as $doc)
                                @php
                                    $submitted = $candidate->documents
                                        ->where('document_type_id', $doc->id)
                                        ->first()?->is_submitted;
                                @endphp

                                <div class="mb-2 col-4">
                                    <div class="form-check">
                                        <input type="hidden" name="documents[{{ $doc->id }}]" value="0">

                                        <input type="checkbox"
                                            name="documents[{{ $doc->id }}]"
                                            value="1"
                                            class="form-check-input"
                                            {{ $submitted ? 'checked' : '' }}
                                            {{ $doc->is_mandatory ? 'checked disabled' : '' }}>

                                        <label class="form-check-label">
                                            {{ $doc->name }}
                                            @if($doc->is_mandatory)
                                                <span class="badge bg-danger ms-2">Mandatory</span>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                            {{-- SUBMIT --}}

                            <div class="col-12">
                                <div class="flex-row panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex">
                                    <button id="js-submit-btn" class="ml-auto btn btn-primary" type="submit">Submit form</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@stop
@section('footerScript')
    <script>
       $(document).ready(function() {
            $('.select2').select2();

            const validationRules = {
                url: /^(https?:\/\/)?([\w\d-]+\.)+[\w]{2,}(\/.*)?$/
            };

            function validateField(input, regex, options = {}) {
                const {
                    emptyMessage = 'This field is required.',
                        formatMessage = 'Invalid format.',
                        minLength = null,
                        maxLength = null
                } = options;

                const value = input.val().trim();
                const errorContainer = input.closest('.form-group').find('.invalid-feedback');

                // Reset validation state
                input.removeClass('is-invalid is-valid');
                errorContainer.hide();

                // Check if field is required and empty
                if (input.prop('required') && value === '') {
                    errorContainer.text(emptyMessage).show();
                    input.addClass('is-invalid');
                    return false;
                }

                // Skip further validation if optional and empty
                if (!input.prop('required') && value === '') {
                    return true;
                }

                // Length validation
                if (minLength && value.length < minLength) {
                    errorContainer.text(`Minimum length is ${minLength} characters.`).show();
                    input.addClass('is-invalid');
                    return false;
                }

                if (maxLength && value.length > maxLength) {
                    errorContainer.text(`Maximum length is ${maxLength} characters.`).show();
                    input.addClass('is-invalid');
                    return false;
                }

                if (regex && !regex.test(value)) {
                    errorContainer.text(formatMessage).show();
                    input.addClass('is-invalid');
                    return false;
                }

                input.addClass('is-valid');
                return true;
            }

            const fieldValidations = [];

            fieldValidations.forEach(config => {
                $(config.selector).on('input blur', function() {
                    const input = $(this);
                    const hasBackendError = input.closest('.form-group').find('.text-danger').is(
                        ':visible');

                    if (!hasBackendError) {
                        validateField(input, config.regex, config.options);
                    }
                });
            });

            function setupErrorClearingOnInput(inputElement) {
                inputElement.on('input change', function() {
                    const errorElement = $(this).closest('.form-group').find('.text-danger');
                    $(this).removeClass('is-invalid');
                    errorElement.hide();
                });
            }


            setupErrorClearingOnInput($('#Name'));

            $('#js-submit-btn').click(function(event) {
                let isValid = true;

                const form = $('#user-form');

                fieldValidations.forEach(config => {
                    const inputEl = $(config.selector);
                    const hasBackendError = inputEl.closest('.form-group').find('.text-danger').is(
                        ':visible');

                    if (!hasBackendError) {
                        const isFieldValid = validateField(inputEl, config.regex, config.options);
                        isValid = isValid && isFieldValid;
                    }
                });



                const NameInput = $('#title');
                const NameError = NameInput.closest('.form-group').find('.text-danger');
                if (!NameError.is(':visible')) {
                    if (!NameInput.val().trim()) {
                        event.preventDefault();
                        isValid = false;
                        NameInput.addClass('is-invalid');
                        // NameError.text('Name is required.').show();
                    } else {
                        NameInput.removeClass('is-invalid');
                        NameError.hide();
                    }
                }

                const hasBackendError = form.find('.text-danger:visible').length > 0;

                if (!isValid && !hasBackendError) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                return isValid;
            });
        });
    </script>
    <script>
        let educationIndex = {{ $candidate->educations->count() }};
        let experienceIndex = {{ $candidate->experiences->count() }};
        let languageIndex = {{ $candidate->languages->count() }};
    </script>
    <script>
        function addEducationRow() {
            const wrapper = document.getElementById('education-wrapper');

            const row = document.createElement('div');
            row.classList.add('row', 'mb-2', 'education-row');

            row.innerHTML = `
                <div class="col-md-4">
                    <input type="text" name="educations[${educationIndex}][institute_name]" class="form-control" placeholder="Institute">
                </div>
                <div class="col-md-4">
                    <input type="text" name="educations[${educationIndex}][course]" class="form-control" placeholder="Course">
                </div>
                <div class="col-md-3">
                    <input type="text" name="educations[${educationIndex}][duration]" class="form-control" placeholder="Duration">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger remove-education">×</button>
                </div>
            `;

            wrapper.appendChild(row);
            educationIndex++;
        }

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-education')) {
                e.target.closest('.education-row').remove();
            }
        });
    </script>
    <script>
        function addExperienceRow() {
            const wrapper = document.getElementById('experience-wrapper');

            const row = document.createElement('div');
            row.classList.add('row', 'mb-2', 'experience-row');

            row.innerHTML = `
                <div class="col-md-4">
                    <input type="text" name="experiences[${experienceIndex}][employer_name]" class="form-control" placeholder="Employer">
                </div>
                <div class="col-md-3">
                    <input type="text" name="experiences[${experienceIndex}][position]" class="form-control" placeholder="Position">
                </div>
                <div class="col-md-3">
                    <input type="text" name="experiences[${experienceIndex}][duration]" class="form-control" placeholder="Duration">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger remove-experience">×</button>
                </div>
            `;

            wrapper.appendChild(row);
            experienceIndex++;
        }

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-experience')) {
                e.target.closest('.experience-row').remove();
            }
        });
    </script>
    <script>
        function addLanguageRow() {
            const wrapper = document.getElementById('language-wrapper');

            const row = document.createElement('div');
            row.classList.add('row', 'mb-2', 'language-row');

            row.innerHTML = `
                <div class="col-md-3">
                    <input type="text" name="languages[${languageIndex}][language]" class="form-control" placeholder="Language">
                </div>

                <div class="col-md-2">
                    <input type="text" name="languages[${languageIndex}][understanding]" class="form-control" placeholder="Understanding">
                </div>

                <div class="col-md-2">
                    <input type="text" name="languages[${languageIndex}][speaking]" class="form-control" placeholder="Speaking">
                </div>

                <div class="col-md-2">
                    <input type="text" name="languages[${languageIndex}][writing]" class="form-control" placeholder="Writing">
                </div>

                <div class="col-md-1">
                    <button type="button" class="btn btn-danger remove-language">×</button>
                </div>
            `;

            wrapper.appendChild(row);
            languageIndex++;
        }

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-language')) {
                e.target.closest('.language-row').remove();
            }
        });
    </script>

@stop
