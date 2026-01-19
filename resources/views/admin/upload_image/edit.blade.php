@extends('layouts.master')

@section('title', 'Update Image')

@section('content')
<main id="js-page-content" role="main" class="page-content">

    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-image'></i> Update Image
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
                    <h2>Update Image</h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">

                        <form action="{{ route('upload-image.update', $image->id) }}"
                              enctype="multipart/form-data" method="post"
                              id="image-upload-form" class="smart-form row" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <!-- Category -->
                            <div class="mb-3 col-4">
                                <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="category_id" name="category_id" required>
                                    <option value="" disabled>Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $image->category_id == $category->id ? 'selected' : '' }}>
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
                                    <option value="" disabled>Select Subcategory</option>
                                    @foreach($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}" {{ $image->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                                            {{ $subcategory->sub_category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subcategory_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-4">
                                <label for="photographer_id" class="form-label">Photographer <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="photographer_id" name="photographer_id" required>
                                    <option value="" disabled selected>Select Photographer</option>
                                    @foreach($photographers as $photographer)
                                        <option value="{{ $photographer->id }}" {{ $image->photographer_id == $photographer->id ? 'selected' : '' }}>
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
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('price', $image->title) }}">
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div class="mb-3 col-4">
                                <label for="price" class="form-label">Price (Optional)</label>
                                <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ old('price', $image->price) }}">
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-4">
                            </div>


                            <!-- Image File -->
                            <div class="mb-3 col-4">
                                <label for="image" class="form-label">Image File</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            @if($image->path)
                                <div class="mb-3 col-4">
                                    <div class="form-group">
                                            <img id="preview-image-before-upload"
                                                src="{{ asset('storage/app/public/' . $image->path) }}"
                                                alt="preview image"
                                                style="max-height: 100px;">
                                    </div>
                                </div>
                            @endif

                            <!-- Submit -->
                            <div class="mt-3 col-12">
                                <button type="submit" class="ml-auto btn btn-primary">Update Image</button>
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
    $("#image-upload-form").on('submit', function(event) {
        var form = $(this);
        let hasBackendError = form.find('.text-danger').length > 0;

        if (!hasBackendError && form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('#category_id').change(function() {
            var categoryId = $(this).val();
            var subcategorySelect = $('#subcategory_id');

            if(categoryId) {
                $.ajax({
                    url: '/upload-image/subcategories/' + categoryId, // include the prefix
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
