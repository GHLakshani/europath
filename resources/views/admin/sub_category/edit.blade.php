@extends('layouts.master')

@section('title', 'Update Sub Category ')

@section('content')
    <!-- the #js-page-content id is needed for some plugins to initialize -->
    <main id="js-page-content" role="main" class="page-content">

        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-chart-area'></i> Update Sub Category <span class='fw-300'></span>
            </h1>

            <div class="row" style="margin-left:auto; margin-right:auto; gap: 12px">
                <a href=" {{ route('sub-category.create') }}">
                    <button type="button" class="btn btn-lg btn-primary">
                        <span class="mr-1 fal fa-plus"></span>
                        Add New
                    </button>
                </a>
                <a href=" {{ route('sub-category.index') }}">
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
                            {{-- Update <span class="fw-300"><i>Sub Category</i></span> --}}
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

                            <form action="{{ route('sub-category.update', $subCategory->id) }}" enctype="multipart/form-data"
                                method="post" id="user-form" class="smart-form row" autocomplete="off"
                                data-parsley-validate>
                                @csrf
                                @method('put')

                                <!-- Sub Category Id -->
                                <div class="mb-3 col-6">
                                    <label class="form-label" for="category_id">Category <span
                                            style="color: red">*</span></label>
                                    <select class="form-control select2" id="category_id" name="category_id" required>
                                        <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Select</option>
                                        @if (isset($categories) && count($categories) > 0)
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $subCategory->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="invalid-feedback">Category is required, you missed this one.</div>
                                    @error('category_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="sub_category_name">Name <span
                                                style="color: red">*</span></label>
                                        <input type="text" id="category_name" name="sub_category_name" class="form-control"
                                            @if (isset($subCategory->sub_category_name)) value="{{ $subCategory->sub_category_name }}" @endif required>
                                        <div class="invalid-feedback">Name is required, you missed this one.</div>
                                        @error('sub_category_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- order -->
                                <div class="mb-3 col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="order">Order</label>
                                        <input type="number" id="order" name="order" class="form-control" value="{{ $subCategory->order }}">
                                        @error('order')
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
        $("#js-submit-btn").click(function(event) {

            // Fetch form to apply custom Bootstrap validation
            var form = $("#user-form")

            let hasBackendError = form.find('.text-danger').length > 0;

            if (!hasBackendError && form[0].checkValidity() === false) {
                event.preventDefault()
                event.stopPropagation()
                form.addClass('was-validated');
            }


            // Perform ajax submit here...
        });
    </script>
@stop
