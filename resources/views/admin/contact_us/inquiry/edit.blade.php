@extends('layouts.master')

@section('title', 'View Contact Us Inquiry ')

@section('content')
    <!-- the #js-page-content id is needed for some plugins to initialize -->
    <main id="js-page-content" role="main" class="page-content">

        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-chart-area'></i> View Contact us Inquiry <span class='fw-300'></span>
            </h1>

            <div class="row" style="margin-left:auto; margin-right:auto; gap: 12px">
                <a href=" {{ route('contact-us-inquiry.index') }}">
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
                            {{-- View <span class="fw-300"><i>Contact Us Inquiry</i></span> --}}
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

                            <form id="user-form" class="smart-form row" autocomplete="off" data-parsley-validate>
                                @csrf
                                @method('put')

                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="first_name">First Name </label>
                                        <input type="text" id="first_name" name="first_name" class="form-control"
                                            @if (isset($contactInquiry->first_name)) value="{{ $contactInquiry->first_name }}" @endif
                                            readonly>
                                        @error('first_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="last_name">Last Name </label>
                                        <input type="text" id="last_name" name="last_name" class="form-control"
                                            @if (isset($contactInquiry->last_name)) value="{{ $contactInquiry->last_name }}" @endif
                                            readonly>
                                        @error('last_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="phone_number">Contact No </label>
                                        <input type="text" id="phone_number" name="phone_number" class="form-control"
                                            @if (isset($contactInquiry->phone_number)) value="{{ $contactInquiry->phone_number }}" @endif
                                            readonly>
                                        @error('phone_number')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email_address">Email Address </label>
                                        <input type="text" id="email_address" name="email_address" class="form-control"
                                            @if (isset($contactInquiry->email_address)) value="{{ $contactInquiry->email_address }}" @endif
                                            readonly>
                                        @error('email_address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="subject">Subject </label>
                                        <input type="text" id="subject" name="subject" class="form-control"
                                            @if (isset($contactInquiry->subject)) value="{{ $contactInquiry->subject }}" @endif
                                            readonly>
                                        @error('subject')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="message">Message </label>
                                        <textarea id="message" rows="3" name="message" class="form-control" readonly>@if (isset($contactInquiry->message)){{ $contactInquiry->message }}@endif</textarea>
                                        @error('message')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
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
        $("#js-submit-btn").click(function(event) {

            // Fetch form to apply custom Bootstrap validation
            var form = $("#user-form")

            if (form[0].checkValidity() === false) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.addClass('was-validated');
            // Perform ajax submit here...
        });
    </script>
@stop
