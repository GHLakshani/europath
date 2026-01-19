@extends('layouts.master')

@section('title', 'Update Meta Tag ')

@section('content')
<!-- the #js-page-content id is needed for some plugins to initialize -->
<main id="js-page-content" role="main" class="page-content">

    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-chart-area'></i> Update Meta Tag  <span class='fw-300'></span>
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
                        <span class="fw-300">{{ ucfirst(str_replace('_', ' ', $metaTag->page_name)) }}</span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">

                        <form action="{{ route('meta-tag.update',$metaTag->id) }}" enctype="multipart/form-data" method="post" id="user-form" class="smart-form row" autocomplete="off" data-parsley-validate>
                            @csrf
                            @method('put')

                            <div class="mb-3 col-6">
                                <div class="form-group">
                                    <label class="form-label" for="page_title">Page Title <span style="color: red">*</span></label>
                                    <input type="text" id="page_title" name="page_title" class="form-control" @if(isset($metaTag->page_title)) value="{{$metaTag->page_title}}" @endif required>
                                    <div class="invalid-feedback">Page Title is required, you missed this one.</div>
                                    @error('page_title')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="description">Description <span style="color: red">*</span></label>
                                    <textarea id="description" rows="2" name="description" class="form-control" required>@if(isset($metaTag->description)){{$metaTag->description}} @endif</textarea>
                                    <div class="invalid-feedback">Description is required, you missed this one.</div>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="keywords">Keywords <span style="color: red">*</span></label>
                                    <textarea id="keywords" rows="2" name="keywords" class="form-control" required>@if(isset($metaTag->keywords)){{$metaTag->keywords}} @endif</textarea>
                                    <div class="invalid-feedback">Keywords is required, you missed this one.</div>
                                    @error('keywords')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-6">
                                <div class="form-group">
                                    <label class="form-label" for="og_title">OG Title <span style="color: red">*</span></label>
                                    <input type="text" id="og_title" name="og_title" class="form-control" @if(isset($metaTag->og_title)) value="{{$metaTag->og_title}}" @endif required>
                                    <div class="invalid-feedback">OG Title is required, you missed this one.</div>
                                    @error('og_title')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-3">
                                <div class="form-group">
                                    <label class="form-label" for="og_image">OG Image <span style="color: red">*</span></label>
                                    <input type="file" id="og_image" name="og_image" class="form-control" accept="image/*" @if(isset($metaTag->og_image)) value="{{$metaTag->og_image}}" @endif>
                                    <div class="invalid-feedback">OG Image is required, you missed this one.</div>
                                    @error('og_image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-3">
                                <div class="form-group">
                                    @if(!empty($metaTag->og_image))
                                        <img id="preview-image-before-upload"
                                            src="{{ asset('storage/app/public/meta_tags/' . $metaTag->og_image) }}"
                                            alt="preview image"
                                            style="max-height: 100px;">
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="og_description">OG Description <span style="color: red">*</span></label>
                                    <textarea id="og_description" rows="2" name="og_description" class="form-control" required>@if(isset($metaTag->og_description)){{$metaTag->og_description}} @endif</textarea>
                                    <div class="invalid-feedback">OG Description is required, you missed this one.</div>
                                    @error('og_description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <input type="hidden" id="page_name" name="page_name" class="form-control" @if(isset($metaTag->page_name)) value="{{$metaTag->page_name}}" @endif required>
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

            $(document).ready(function() {

                var count = 1; // Initialize count

                $(".add").click(function() {
                    // Append the new form set (copy_p) after the dynamic field
                    var html = $(".copy_p").html();
                    var newSection = $(html); // Convert to jQuery object

                    // Update IDs to include count for uniqueness
                    newSection.find("#image").attr("id", "image_" + count).attr("name", "image[" + count + "]");
                    newSection.find("#order_id").attr("id", "order_id_" + count).attr("name", "order_id[" + count + "]");
                    // newSection.find("#remove_attachbtn_copy").attr("id", "remove_attachbtn_copy_" + count);

                    // Append the updated section
                    $(".after-dynamic-field").after(newSection);

                    count++; // Increment count
                });

                $("#remove_attachbtn").click(function() {
                    $("input[name='image']").val('');
                    //$("#blah").hide();
                });

                $("body").on("click", ".btn_remove", function() {
                    $(this).parents(".control-group-dynamic-field").remove();
                });
            });

            function check_english_requirment() {
                var ticker_req = $("input[name='english_con_req']:checked").val();
                //alert (ticker_req);
                if (ticker_req == 'Y') {
                    $("#display_image_add_div").show();
                    //$('#vTickerMsg').val("");
                } else {
                    $("#display_image_add_div").hide();
                    //$('#vTickerMsg').val("");
                }
            }
    </script>
@stop
