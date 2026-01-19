@extends('layouts.master')

@section('title', 'Create Meta Tag')

@section('content')
<!-- the #js-page-content id is needed for some plugins to initialize -->
<main id="js-page-content" role="main" class="page-content">

    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-chart-area'></i> Create Meta Tag <span class='fw-300'></span>
        </h1>

        <div class="row" style="margin-left:auto; margin-right:auto; gap: 12px">
            <a href=" {{ route('meta-tag.create') }}">
            <button type="button" class="btn btn-lg btn-primary">
                <span class="mr-1 fal fa-plus"></span>
                Add New
            </button>
            </a>
            <a href=" {{ route('meta-tag.index') }}">
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
                        Create <span class="fw-300"><i>Meta Tag</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">

                        <form action="{{ route('meta-tag.store') }}" enctype="multipart/form-data" method="post" id="meta-tag-form" class="smart-form row" autocomplete="off" data-parsley-validate>
                            @csrf

                            <div class="mb-3 col-6">
                                <div class="form-group">
                                    <label class="form-label" for="page_name">Page Name <span style="color: red">*</span></label>
                                    <input type="text" id="page_name" name="page_name" class="form-control" value="{{ old('page_name') }}" required>
                                    <div class="invalid-feedback">Page Name is required, you missed this one.</div>
                                    @error('page_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-6">
                                <div class="form-group">
                                    <label class="form-label" for="page_title">Page Title <span style="color: red">*</span></label>
                                    <input type="text" id="page_title" name="page_title" class="form-control" value="{{ old('page_title') }}" required>
                                    <div class="invalid-feedback">Page Title is required, you missed this one.</div>
                                    @error('page_title')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="description">Description <span style="color: red">*</span></label>
                                    <textarea id="description" rows="2" name="description" class="form-control" required>{{ old('description') }}</textarea>
                                    <div class="invalid-feedback">Description is required, you missed this one.</div>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="keywords">Keywords <span style="color: red">*</span></label>
                                    <textarea id="keywords" rows="2" name="keywords" class="form-control" required>{{ old('keywords') }}</textarea>
                                    <div class="invalid-feedback">Keywords is required, you missed this one.</div>
                                    @error('keywords')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-6">
                                <div class="form-group">
                                    <label class="form-label" for="og_title">OG Title <span style="color: red">*</span></label>
                                    <input type="text" id="og_title" name="og_title" class="form-control" value="{{ old('og_title') }}" required>
                                    <div class="invalid-feedback">OG Title is required, you missed this one.</div>
                                    @error('og_title')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="og_description">OG Description <span style="color: red">*</span></label>
                                    <textarea id="og_description" rows="2" name="og_description" class="form-control" required>{{ old('og_description') }}</textarea>
                                    <div class="invalid-feedback">OG Description is required, you missed this one.</div>
                                    @error('og_description')
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
                var form = $("#meta-tag-form")

                if (form[0].checkValidity() === false) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.addClass('was-validated');
                // Perform ajax submit here...
            });
    </script>
@stop
