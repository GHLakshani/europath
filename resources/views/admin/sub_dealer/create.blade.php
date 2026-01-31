@extends('layouts.master')

@section('title', 'Create Sub Dealer')

@section('content')
    <!-- the #js-page-content id is needed for some plugins to initialize -->
    <main id="js-page-content" role="main" class="page-content">

        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-chart-area'></i> Create Sub Dealer <span class='fw-300'></span>
            </h1>

            <div class="row" style="margin-left:auto; margin-right:auto; gap: 12px">
                <a href=" {{ route('sub-dealer.create') }}">
                    <button type="button" class="btn btn-lg btn-primary">
                        <span class="mr-1 fal fa-plus"></span>
                        Add New
                    </button>
                </a>
                <a href=" {{ route('sub-dealer.index') }}">
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
                            {{-- Create <span class="fw-300"><i>sub-dealer</i></span> --}}
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

                            <form action="{{ route('sub-dealer.store') }}" enctype="multipart/form-data" method="post"
                                id="user-form" class="smart-form row" autocomplete="off">
                                @csrf

                                <!-- sub-dealer -->
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Sub Dealer Name<span
                                                style="color: red">*</span></label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            value="{{ old('name') }}">
                                        <div class="invalid-feedback">Sub Dealer Name is required, you missed this one.</div>
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- NIC -->
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="nic">Sub Dealer NIC<span
                                                style="color: red">*</span></label>
                                        <input type="text" id="nic" name="nic" class="form-control"
                                            value="{{ old('nic') }}">
                                        <div class="invalid-feedback">sub-dealer NIC is required, you missed this one.</div>
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

                const nameInput = $('#name');
                const nameError = nameInput.closest('.form-group').find('.text-danger');
                if (!nameError.is(':visible')) {
                    if (!nameInput.val().trim()) {
                        event.preventDefault();
                        isValid = false;
                        nameInput.addClass('is-invalid');
                        // nameError.text('name is required.').show();
                    } else {
                        nameInput.removeClass('is-invalid');
                        nameError.hide();
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
