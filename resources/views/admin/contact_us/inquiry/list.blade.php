@extends('layouts.master')

@section('title', 'Contact Us Inquiry')

@section('content')
<main id="js-page-content" role="main" class="page-content">

    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-chart-area'></i> Contact us Inquiry <span class='fw-300'></span>
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
                        {{-- Contact Us Inquiry <span class="fw-300"><i>list</i></span> --}}
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <!-- datatable start -->
                        <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <th width="5%">#</th>
                                <th width="30%">Subject</th>
                                <th width="30%">Name</th>
                                <th width="15%">Contact No</th>
                                <th width="15%">Email No</th>
                                <th width="5%">View</th>
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
                url: "{{ route('contact-us-inquiry.get-contact-us-inquiry') }}",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id',
                    className: 'text-center'
                },
                {
                    data: 'subject',
                    name: 'subject',
                    className: 'text-center',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'first_name',
                    name: 'first_name',
                    className: 'text-center',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'phone_number',
                    name: 'phone_number',
                    className: 'text-center',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'email_address',
                    name: 'email_address',
                    className: 'text-center',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'edit',
                    name: 'edit',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                },
            ],
                scrollX: true,
                scrollCollapse: true,
                autoWidth: false
        });
    });

</script>
@stop


