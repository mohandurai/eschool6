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
    <li class="breadcrumb-item"><a href="#">Masters</a></li>
    <li class="breadcrumb-item active" aria-current="page">Allocate Test</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4>
            Allocate Test &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="{{ url('alloctest/create') }}" role="button">Create Test Allocation</a>
        </h4>

        <div class="table-responsive">
        <table id="tracker_datatable" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Test Title</th>
                    <th>Que. Template ID</th>
                    <th>Subject</th>
                    <th>Class</th>
                    <th>Assign To</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if(!empty($roles))
            @foreach($roles as $slist)
                <tr>
                    <td>{{$slist->id}}</td>
                    <td>{{$slist->test_title}}</td>
                    <td>{{$slist->qn_master_templ_id}}</td>
                    <td>{{$slist->subject}}</td>
                    <td>{{$slist->class_id}}</td>
                    <td>{{$slist->assign_to}}</td>
                    <td></td>
                </tr>
            @endforeach
            @endif
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
            // order: [[ 5, 'desc' ], [ 1, 'asc' ]],
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
           ajax: "{{ url('alloctestlist') }}",
        //    pageLength: 5,
           lengthMenu: [ [7, 10, 25, 50, -1], [7, 10, 25, 50, 'All'] ],
           columns: [
                    { data: 'id', name: 'id' },
                    { data: 'test_title', name: 'test_title'},
                    { data: 'qn_master_templ_id', name: 'qn_master_templ_id' },
                    { data: 'subject', name: 'subject' },
                    { data: 'class_id', name: 'class_id' },
                    { data: 'assign_to', name: 'assign_to' },
                    { data: 'action', name : 'action', orderable : true, searchable: true}
                 ],
                 initComplete: function () {
                    this.api()
                        .columns()
                        .every(function () {
                            var column = this;
                            var select = $('<select><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                });

                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function (d) {
                                    select.append('<option value="' + d + '">' + d + '</option>');
                                });
                        });
                },

        });
    });

</script>
@endpush
