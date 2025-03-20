@extends('layout.master')

<meta name="csrf-token" content="{{ csrf_token() }}">

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<style type="text/css">
.buttons-pdf, .buttons-excel, .buttons-copy, .buttons-csv, .buttons-print {
  float: right;
}
table{
  margin: 0 auto;
  width: 100%;
  clear: both;
  border-collapse: collapse;
  table-layout: fixed;
  word-wrap:break-word;
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
    <li class="breadcrumb-item active" aria-current="page">Content Master</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4>
        Content Master &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="{{ url('content/create') }}" role="button">Create New Content</a>
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
                    <th>Title</th>
                    <th>Video Name</th>
                    <th>Type</th>
                    <th>Class ID</th>
                    <th>Subject</th>
                    <th>Status</th>
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
    function confirmation()
    {
            if(confirm('Are you sure to delete this record.....?'))
            {
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
               "processing" : "<img src={{ asset('/assets/images/loading-14.gif') }}>"
            },
            // dom: '<"top"<"left-col"B><"center-col"l><"right-col"f>>rtip',
            // dom : "Bflrtip",
            // dom: '<"top"i>flrtp<"clear">',
            dom: '<"top"f><"bottom"rtlp><"clear">',
            // dom: '<"title"<"filter"f>>ltip',
            buttons : [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            stateSave: true,
            processing: true,
            serverSide : true,
            responsive: true,
           ajax: "{{ url('contentlist') }}",
        //    pageLength: 5,
           lengthMenu: [ [7, 10, 25, 50, -1], [7, 10, 25, 50, 'All'] ],
           createdRow: function (row, data, rowIndex) {
                // Per-cell function to do whatever needed with cells
                $.each($('td', row), function (colIndex) {
                    // alert(colIndex);
                    // For example, adding data-* attributes to the cell
                    if(colIndex == 1) {
                        $(this).attr('title', data.cm_title);
                    } else if(colIndex == 2) {
                        $(this).attr('title', data.filename);
                    }

                });
            },
           columns: [
                    { data: 'cm_id', name: 'cm_id', width: '15px' },
                    { data: 'cm_title', render: function(data, type, row, meta) {
                        if (type === 'display') {
                            data = typeof data === 'string' && data.length > 20 ? data.substring(0, 20) + ' ...' : data;
                        }
                            return data;
                        }, width: '220px' },
                    { data: 'filename', render: function(data, type, row, meta) {
                        if (type === 'display') {
                            data = typeof data === 'string' && data.length > 20 ? data.substring(0, 20) + ' ...' : data;
                        }
                            return data;
                        }, width: '280px' },
                    { data: 'vm_type', name: 'vm_type' },
                    { data: 'cm_clid', name: 'cm_clid' },
                    { data: 'subject', name: 'subject' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name : 'action', orderable : false, searchable: true, width: '190px'}
                 ],
            fixedColumns: true,
        });
    });

</script>
@endpush
