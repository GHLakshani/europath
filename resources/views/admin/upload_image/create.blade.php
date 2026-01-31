@extends('layouts.master')

@section('title', 'Upload Image')

@section('content')
<main id="js-page-content" role="main" class="page-content">

    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-image'></i> Upload Image
        </h1>

        <div class="row" style="margin-left:auto; margin-right:auto; gap: 12px">
            <a href="{{ route('upload-image.create') }}">
                <button type="button" class="btn btn-lg btn-primary">
                    <span class="mr-1 fal fa-plus"></span>
                    Add New
                </button>
            </a>
            <a href="{{ route('upload-image.index') }}">
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
                    <h2>Upload Image</h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">

                        <form action="{{ route('upload-image.store') }}" enctype="multipart/form-data" method="post" id="image-upload-form" class="smart-form row" autocomplete="off">
                            @csrf

                            <!-- Category -->
                            <div class="mb-3 col-4">
                                <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="category_id" name="category_id" required>
                                    <option value="" disabled selected>Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Subcategory -->
                            <div class="mb-3 col-4">
                                <label for="subcategory_id" class="form-label">Subcategory <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="subcategory_id" name="subcategory_id" >
                                    <option value="" disabled selected>Select Subcategory</option>
                                    @foreach($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}" {{ old('subcategory_id') == $subcategory->id ? 'selected' : '' }}>
                                            {{ $subcategory->sub_category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subcategory_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-4">
                                <label for="category_id" class="form-label">Photographer <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="photographer_id" name="photographer_id" required>
                                    <option value="" disabled selected>Select Photographer  </option>
                                    @foreach($photographers as $photographer)
                                        <option value="{{ $photographer->id }}" {{ old('photographer_id') == $photographer->id ? 'selected' : '' }}>
                                            {{ $photographer->photographer_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('photographer_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-4">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div class="mb-3 col-4">
                                <label for="price" class="form-label">Price (Optional)</label>
                                <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ old('price') }}">
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Image File -->
                            <div class="mb-3 col-4">
                                <label for="image" class="form-label">Image File <span class="text-danger">*</span></label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit -->
                            <div class="mt-3 col-12">
                                <button type="submit" class="ml-auto btn btn-primary">Upload Image</button>
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
            $('#category_id').change(function() {
                var categoryId = $(this).val();
                var subcategorySelect = $('#subcategory_id');

                if(categoryId) {
                    $.ajax({
                        url: '{{ url("hanara-cms/upload-image/subcategories") }}/' + categoryId,
                        type: 'GET',
                        success: function(data) {
                            subcategorySelect.empty();
                            subcategorySelect.append('<option value="" disabled selected>Select Subcategory</option>');
                            $.each(data, function(key, subcategory) {
                                subcategorySelect.append('<option value="'+subcategory.id+'">'+subcategory.sub_category_name+'</option>');
                            });
                        },
                        error: function() {
                            subcategorySelect.html('<option value="" disabled>Error loading subcategories</option>');
                        }
                    });

                }
            });

        });
    </script>

@stop
