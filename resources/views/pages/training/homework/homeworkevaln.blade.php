@extends('layout.master')

<meta name="csrf-token" content="{{ csrf_token() }}">

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<style type="text/css">
.buttons-pdf, .buttons-excel, .buttons-copy, .buttons-csv, .buttons-print {
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
    <li class="breadcrumb-item"><a href="#">Homework Evaluation</a></li>
    <li class="breadcrumb-item active" aria-current="page">Index</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4>
        Home Work Evaluation &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="{{ url('homework/create') }}" role="button">Create Home Work Activity</a>
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
                <!-- <tr>
                    <td></td>
                    <td><input type="text" class="form-control filter-input" placeholder="Find ..." data-column="2" /></td>
                    <td><input type="text" class="form-control filter-input" placeholder="Find  ..." data-column="3" /></td>
                </tr> -->
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Class</th>
                    <th>Assign To</th>
                    <th>Student ID</th>
                    <th>Evaluator Status</th>
                    <th>Marks Scored</th>
                    <th>Evaluator Comments</th>
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

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

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
           ajax: "{{ url('homeworkevalnlist') }}",
        //    pageLength: 5,
           lengthMenu: [ [7, 10, 25, 50, -1], [7, 10, 25, 50, 'All'] ],
           columns: [
                { data: 'id', name: 'id' },
                { data: 'title', name: 'title'},
                { data: 'class_id', name: 'class_id' },
                { data: 'assign_to', render: function(data, type, row, meta) {
                        if(row.assign_to == 0) {
                            return "All";
                        } else {
                            return row.assign_to;
                        }
                    }
                },
                { data: 'student_id', name: 'student_id' },
                { data: 'evaluator_status', name: 'evaluator_status' },
                { data: 'mark_scored', name: 'mark_scored' },
                { data: 'evaluator_comments', name: 'evaluator_comments'},
                { data: 'action', name : 'action', orderable : true, searchable: true}
            ]

        });
    });

</script>
@endpush
