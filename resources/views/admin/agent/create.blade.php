@extends('layouts.master')

@section('title', 'Create Agent')

@section('content')
    <!-- the #js-page-content id is needed for some plugins to initialize -->
    <main id="js-page-content" role="main" class="page-content">

        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-chart-area'></i> Create Agent <span class='fw-300'></span>
            </h1>

            <div class="row" style="margin-left:auto; margin-right:auto; gap: 12px">
                <a href=" {{ route('agent.create') }}">
                    <button type="button" class="btn btn-lg btn-primary">
                        <span class="mr-1 fal fa-plus"></span>
                        Add New
                    </button>
                </a>
                <a href=" {{ route('agent.index') }}">
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
                            {{-- Create <span class="fw-300"><i>agent</i></span> --}}
                        </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Fullscreen"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form action="{{ route('agent.store') }}" enctype="multipart/form-data" method="post"
                                id="user-form" class="smart-form row" autocomplete="off">
                                @csrf

                                <!-- Country Id -->
                                <div class="mb-3 col-6">
                                    <label class="form-label" for="country_id">Country <span style="color: red">*</span></label>
                                    <select class="form-control select2"  id="country_id" name="country_id" required>
                                        <option value="" disabled {{ old('country_id') ? '' : 'selected' }}>Select</option>
                                        @if(isset($countries) && count($countries) > 0)
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                    {{ $country->country_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="invalid-feedback">Country is required, you missed this one.</div>
                                    @error('country_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- agent -->
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Agent Name<span
                                                style="color: red">*</span></label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            value="{{ old('name') }}">
                                        <div class="invalid-feedback">agent Name is required, you missed this one.</div>
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- NIC -->
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="nic">Agent NIC<span
                                                style="color: red">*</span></label>
                                        <input type="text" id="nic" name="nic" class="form-control"
                                            value="{{ old('nic') }}">
                                        <div class="invalid-feedback">agent NIC is required, you missed this one.</div>
                                        @error('nic')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- phone -->
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="phone">Phone </label>
                                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                            class="form-control">
                                        @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- email -->
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email">Email </label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            class="form-control">
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- commission_percentage -->
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="commission_percentage">Commission Percentage </label>
                                        <input type="number" id="commission_percentage" name="commission_percentage" value="{{ old('commission_percentage') }}"
                                            class="form-control">
                                        @error('commission_percentage')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div
                                        class="flex-row panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex">
                                        <button id="js-submit-btn" class="ml-auto btn btn-primary" type="submit">Submit
                                            form</button>
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

            setupErrorClearingOnInput($('#image'));
            setupErrorClearingOnInput($('#title'));

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

                const imageInput = $('#image');
                const imageError = imageInput.closest('.form-group').find('.text-danger');
                if (!imageError.is(':visible')) {
                    if (!imageInput[0].files || !imageInput[0].files.length) {
                        event.preventDefault();
                        isValid = false;
                        imageInput.addClass('is-invalid');
                        imageError.text('Image is required.').show();
                    } else {
                        imageInput.removeClass('is-invalid');
                        imageError.hide();
                    }
                }

                const titleInput = $('#title');
                const titleError = titleInput.closest('.form-group').find('.text-danger');
                if (!titleError.is(':visible')) {
                    if (!titleInput.val().trim()) {
                        event.preventDefault();
                        isValid = false;
                        titleInput.addClass('is-invalid');
                        // titleError.text('Title is required.').show();
                    } else {
                        titleInput.removeClass('is-invalid');
                        titleError.hide();
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
@stop
