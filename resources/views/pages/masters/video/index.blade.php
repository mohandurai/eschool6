@extends('layout.master')

<meta name="csrf-token" content="{{ csrf_token() }}">

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<style type="text/css">
    .buttons-pdf,
    .buttons-excel,
    .buttons-copy,
    .buttons-csv,
    .buttons-print {
        float: right;
    }
</style>
@endpush


@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Masters</a></li>
        <li class="breadcrumb-item active" aria-current="page">Video Master</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4>
                    Video Master &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="{{ url('video/create') }}" role="button">Create New Video</a>
                </h4>

                @if(Session::has('message'))
                </br>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>{{ Session::get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                @endif

                <div class="table-responsive">
                    <table id="tracker_datatable" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Chapter</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('plugin-scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    function confirmation() {
        if (confirm('Are you sure to delete this record.....?')) {
            return true;
        } else {
            return false;
        }
    }

    $(document).ready(function() {
        // alert("Settings page was loaded");
        // return false;
        var table6 = $('#tracker_datatable').DataTable({
            language: {
                "processing": "<img src={{ asset('/assets/images/loading-14.gif') }}>"
            },
            order: [
                [3, 'desc']
            ],
            dom: '<"top"f><"bottom"rtlp><"clear">',
            ajax: "{{ url('videolist') }}",
            lengthMenu: [
                [7, 10, 25, 50, -1],
                [7, 10, 25, 50, 'All']
            ],
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'class_id',
                    name: 'class_id'
                },
                {
                    data: 'subject',
                    name: 'subject'
                },
                {
                    data: 'video_type',
                    name: 'video_type'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                }
            ],

        });
    });
</script>
@endpush
