@extends('layouts.master')

@section('title', 'Create Contact Us')

@section('content')
    <!-- the #js-page-content id is needed for some plugins to initialize -->
    <main id="js-page-content" role="main" class="page-content">

        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-chart-area'></i> Create Contact us <span class='fw-300'></span>
            </h1>


        </div>

        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            {{-- Create <span class="fw-300"><i>Contact Us</i></span> --}}
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

                            <form action="{{ route('contact-us.update', $contactUs->id) }}" enctype="multipart/form-data"
                                method="post" id="contact-us" class="smart-form row" autocomplete="off"
                                data-parsley-validate>
                                @csrf

                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="heading">Heading <span
                                                style="color: red">*</span></label>
                                        <input type="text" id="heading" name="heading"
                                            class="form-control"
                                            @if (isset($contactUs->heading)) value="{{ $contactUs->heading }}" @endif
                                            required>
                                        <div class="invalid-feedback">Heading is required, you missed this one.</div>
                                        @error('heading')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="content">Content </label>
                                        <textarea id="content" rows="5" name="content" class="form-control" required>@if (isset($contactUs->content)){{ $contactUs->content }}@endif</textarea>
                                        <div class="invalid-feedback">Content is required, you missed this one.</div>
                                        @error('content')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="Moblie Number">Mobile Number <span
                                                style="color: red">*</span></label>
                                        <input type="text" id="mobile" name="mobile" class="form-control"
                                            @if (isset($contactUs->mobile)) value="{{ $contactUs->mobile }}" @endif
                                            required>
                                        <div class="invalid-feedback">Mobile Number is required, you missed this one.</div>
                                        @error('mobile')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email">Email <span
                                                style="color: red">*</span></label>
                                        <input type="email" id="email" name="email" maxlength="52"
                                            class="form-control"
                                            @if (isset($contactUs->email)) value="{{ $contactUs->email }}" @endif
                                            required>
                                        <div class="invalid-feedback">Email is required, you missed this one.</div>
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address">Address <span
                                                style="color: red">*</span></label>
                                        <textarea rows="3" id="address" name="address" class="form-control" required>@if (isset($contactUs->address)){{ $contactUs->address }}@endif</textarea>
                                        <div class="invalid-feedback">Address is required, you missed this one.</div>
                                        @error('address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="whatsapp">WhatsApp Number <span
                                                style="color: red">*</span></label>
                                        <input type="text" id="whatsapp" name="whatsapp" class="form-control"
                                            @if (isset($contactUs->whatsapp)) value="{{ $contactUs->whatsapp }}" @endif required>
                                        <div class="invalid-feedback">Whatsapp is required, you missed this one.</div>
                                        @error('whatsapp')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="fax">Fax</label>
                                        <input type="text" id="fax" name="fax" class="form-control"
                                            @if (isset($contactUs->fax)) value="{{ $contactUs->fax }}" @endif required>
                                        @error('fax')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="Facebook Link">Facebook Link</label>
                                        <input type="text" id="facebook_link" name="facebook_link"
                                            class="form-control"
                                            @if (isset($contactUs->facebook_link)) value="{{ $contactUs->facebook_link }}" @endif>
                                        <div class="invalid-feedback">Facebook Link is required, you missed this one.</div>
                                        @error('facebook_link')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="Youtube Link">Youtube Link</label>
                                        <input type="text" id="youtube_link" name="youtube_link" class="form-control"
                                            @if (isset($contactUs->youtube_link)) value="{{ $contactUs->youtube_link }}" @endif>
                                        <div class="invalid-feedback">Youtube Link is required, you missed this one.</div>
                                        @error('youtube_link')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="tiktok_link">Tiktok Link</label>
                                        <input type="text" id="tiktok_link" name="tiktok_link" class="form-control"
                                            @if (isset($contactUs->tiktok_link)) value="{{ $contactUs->tiktok_link }}" @endif>
                                        <div class="invalid-feedback">Tiktok Link is required, you missed this one.</div>
                                        @error('tiktok_link')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="Instagram Link">Instagram Link</label>
                                        <input type="text" id="instagram_link" name="instagram_link"
                                            class="form-control"
                                            @if (isset($contactUs->instagram_link)) value="{{ $contactUs->instagram_link }}" @endif>
                                        <div class="invalid-feedback">Instagram Link is required, you missed this one.
                                        </div>
                                        @error('instagram_link')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="footer_content">Footer Content </label>
                                        <textarea id="footer_content" rows="5" name="footer_content" class="form-control" required>@if (isset($contactUs->footer_content)){{ $contactUs->footer_content }}@endif</textarea>
                                        <div class="invalid-feedback">Footer Content is required, you missed this one.</div>
                                        @error('footer_content')
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
            // Regex patterns
            var contactNoRegex = /^[\d\s\-\+\(\)]{10,15}$/;
            var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            var urlPattern = /^(https?:\/\/)?([\w\d-]+\.)+[\w]{2,}(\/.*)?$/;
            var facebookRegex = /^(https?:\/\/)?([\w\d-]+\.)+[\w]{2,}(\/.*)?$/;
            var youtubeRegex = /^(https?:\/\/)?(www\.)?(youtube\.com\/(@[\w-]+|(watch\?v=|channel\/|c\/|user\/)[\w-]+)|youtu\.be\/[\w-]+)$/;
            var instagramRegex = /^(https?:\/\/)?([\w\d-]+\.)+[\w]{2,}(\/.*)?$/;
            var xLinkRegex = /^(https?:\/\/)?([\w\d-]+\.)+[\w]{2,}(\/.*)?$/;
            var linkedinRegex = /^(https?:\/\/)?([\w\d-]+\.)+[\w]{2,}(\/.*)?$/;

            // Event listeners
            $("#mobile").on('input', function() {
                validateField($(this), contactNoRegex, "Contact number is required.",
                    "Contact number must be 10-15 digits.");
            });

            $("#whatsapp").on('input', function() {
                validateField($(this), contactNoRegex, "", "Contact number must be 10-15 digits.");
            });

            $("#email").on('input', function() {
                validateField($(this), emailRegex, "Email is required.",
                "Email must be in a valid format.");
            });

            $("#facebook_link").on('input', function() {
                validateField($(this), facebookRegex, "", "Facebook link must be valid format.");
            });
            $("#youtube_link").on('input', function() {
                validateField($(this), youtubeRegex, "", "Youtube link must be valid format.");
            });
            $("#linkedin_link").on('input', function() {
                validateField($(this), linkedinRegex, "", "LinkedIn link must be valid format.");
            });
            $("#tiktok_link").on('input', function() {
                validateField($(this), xLinkRegex, "", "X-link must be valid format.");
            });
            $("#instagram_link").on('input', function() {
                validateField($(this), instagramRegex, "", "Instergram link must be valid format.");
            });

            function validateField(field, regex, emptyMessage, formatMessage) {
                var value = field.val().trim();
                var errorDiv = field.siblings(".invalid-feedback");


                if (!errorDiv.length) {
                    field.after('<div class="invalid-feedback"></div>');
                    errorDiv = field.siblings(".invalid-feedback");
                }


                if (emptyMessage && value === "") {
                    errorDiv.text(emptyMessage).show();
                    field.addClass("is-invalid").removeClass("is-valid");
                    return false;
                }

                if (!emptyMessage && value === "") {
                    errorDiv.hide();
                    field.removeClass("is-invalid").removeClass("is-valid");
                    return true;
                }


                if (!regex.test(value)) {
                    errorDiv.text(formatMessage).show();
                    field.addClass("is-invalid").removeClass("is-valid");
                    return false;
                } else {
                    errorDiv.hide();
                    field.removeClass("is-invalid").addClass("is-valid");
                    return true;
                }
            }


            $("#js-submit-btn").click(function(event) {
                var form = $("#contact-us");
                var isValid = true;

                isValid &= validateField($("#mobile"), contactNoRegex, "Contact number is required.",
                    "Contact number must be 10-15 digits.");
                isValid &= validateField($("#whatsapp"), contactNoRegex, "",
                    "Contact number must be 10-15 digits.");
                if ($("#email").val().trim() !== "") {
                    isValid &= validateField($("#email"), emailRegex, "Email is required.",
                        "Email must be in a valid format.");
                }
                isValid &= validateField($("#facebook_link"), facebookRegex, "",
                "Facebook link must be valid format.");
                isValid &= validateField($("#youtube_link"), youtubeRegex, "",
                "Youtube link must be valid format.");
                isValid &= validateField($("#linkedin_link"), linkedinRegex, "",
                "LinkedIn link must be valid format.");
                isValid &= validateField($("#tiktok_link"), xLinkRegex, "",
                "X-link must be valid format.");
                isValid &= validateField($("#instagram_link"), instagram_link, "",
                "Instergram link must be valid format.");


                if (!isValid || form[0].checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.addClass('was-validated');
                // Perform AJAX submit if needed
            });
        });
    </script>


@stop
