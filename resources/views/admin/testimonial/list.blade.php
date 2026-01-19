@extends('layouts.master')

@section('title', 'Testimonial')

@section('content')
<main id="js-page-content" role="main" class="page-content">

    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-chart-area'></i> Testimonial <span class='fw-300'></span>
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
                        {{-- Testimonial <span class="fw-300"><i>list</i></span> --}}
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <!-- datatable start -->
                        <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <th style="width: 5%;">#</th>
                                <th style="width: 15%;">Name</th>
                                <th style="width: 10%;">Rating</th>
                                <th style="width: 10%;">Edit</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 10%;">Delete</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!-- datatable end -->
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
        var table = $('#dt-basic-example').dataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            searching: true,
            ajax: {
                url: "{{ route('testimonial.get-testimonial') }}",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id',
                    className: 'text-center',
                    width: '5%'
                },
                {
                    data: 'name',
                    name: 'name',
                    className: 'text-center',
                    orderable: false,
                    searchable: true,
                    width: '15%'
                },
                {
                    data: 'rating',
                    name: 'rating',
                    className: 'text-center',
                    orderable: false,
                    searchable: true,
                    width: '10%'
                },
                {
                    data: 'edit',
                    name: 'edit',
                    className: 'text-center',
                    orderable: false,
                    searchable: false,
                    width: '10%'
                },
                {
                    data: 'activation',
                    name: 'activation',
                    className: 'text-center',
                    orderable: false,
                    searchable: false,
                    width: '10%'
                },
                {
                    data: 'delete',
                    name: 'delete',
                    className: 'text-center',
                    orderable: false,
                    searchable: false,
                    width: '10%'
                },
            ],
            scrollX: true,
             scrollCollapse: true,
            autoWidth: false
        });
    });

    function submitDeleteForm(form) {
            new Swal({
            title: "Are you sure?",
            text: "do you want to delete this?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes Delete",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
        })
            .then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        return false;
    }

    function confirmStatusChange(form) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to change the status?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn-success',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });

        return false;
    }

</script>
@stop


