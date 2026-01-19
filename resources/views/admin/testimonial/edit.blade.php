@extends('layouts.master')

@section('title', 'Update Testimonial ')

@section('content')
<!-- the #js-page-content id is needed for some plugins to initialize -->
<main id="js-page-content" role="main" class="page-content">

    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-chart-area'></i> Update Testimonial  <span class='fw-300'></span>
        </h1>

        <div class="row" style="margin-left:auto; margin-right:auto; gap: 12px">
            <a href=" {{ route('testimonial.create') }}">
            <button type="button" class="btn btn-lg btn-primary">
                <span class="mr-1 fal fa-plus"></span>
                Add New
            </button>
            </a>
            <a href=" {{ route('testimonial.index') }}">
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
                        {{-- Update <span class="fw-300"><i>Testimonial</i></span> --}}
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">

                        <form action="{{ route('testimonial.update',$Testimonial->id) }}" enctype="multipart/form-data" method="post" id="user-form" class="smart-form row" autocomplete="off" data-parsley-validate>
                            @csrf
                            @method('put')

                            <div class="mb-3 col-6">
                                <div class="form-group">
                                    <label class="form-label" for="example-email-2">Name <span style="color: red">*</span></label>
                                    <input type="text" id="name" name="name" class="form-control" @if(isset($Testimonial->name)) value="{{$Testimonial->name}}" @endif required>
                                    <div class="invalid-feedback">Name is required, you missed this one.</div>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-6">
                                <div class="form-group">
                                    <label class="form-label" for="icon">Image <span style="color: red">*</span>:<span
                                        class="text-muted fw-normal small">Recommended Size:
                                        <strong>500 * 500 px</strong></span></label>
                                    <input type="file" id="icon" name="icon" class="form-control" accept="image/*" @if(isset($Testimonial->icon)) value="{{$Testimonial->icon}}" @endif  >
                                    <div class="invalid-feedback">Image is required, you missed this one.</div>
                                    @error('icon')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-6">
                            </div>
                            <div class="mb-3 col-6">
                                <div class="form-group">
                                    @if(!empty($Testimonial->icon))
                                        <img id="preview-image-before-upload"
                                            src="{{ asset('storage/app/public/testimonials/' . $Testimonial->icon) }}"
                                            alt="preview image"
                                            style="max-height: 100px;">
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="message">Caption <span style="color: red">*</span></label>
                                    <textarea id="message" rows="3" name="message" class="form-control" required>@if(isset($Testimonial->message)) {{$Testimonial->message}} @endif </textarea>
                                    <div class="invalid-feedback">Message is required, you missed this one.</div>
                                    @error('message')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

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
