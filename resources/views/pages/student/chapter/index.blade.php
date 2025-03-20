@extends('layout.master')

<meta name="csrf-token" content="{{ csrf_token() }}">

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<style type="text/css">
.buttons-pdf, .buttons-excel, .buttons-copy, .buttons-csv, .buttons-print {
  float: right;
}
.below-margin {
    margin-bottom : 10px;
}
</style>
@endpush


@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')

@php
	//echo "<pre>";
	//print_r($clssArr);
	//echo "</pre>";
@endphp

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Students</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chapters</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4>
        Chapters &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="{{ url('chapter/create') }}" role="button">Create New Chapter</a>
        </h4>

        @if(Session::has('message'))
        </br>
        <div class="alert alert-warning alert-dismissible fade show below-margin" role="alert">
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
                    <td></td>
                    <td>
                        <input type="text" class="form-control filter-input" placeholder="Find..." data-column="2" />
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <a title="Clear filter selection" id="clear-filter" class="btn btn-info" href="#"><i class="fas fa-eraser"></i></a>
                    </td>
                </tr> -->
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if(!empty($chaps))
            @foreach($chaps as $slist)
                <tr>
                    <td>{{$slist->id}}</td>
                    <td>{{$slist->title}}</td>
                    <td>{{$slist->class_id}}</td>
                    <td>{{$slist->subject}}</td>
                    <td>{{$slist->created_date}}</td>
                    <td>{{$slist->updated_date}}</td>
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
            order: [[ 5, 'desc' ], [ 1, 'asc' ]],
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
           ajax: "{{ url('chapterlist') }}",
        //    pageLength: 5,
           lengthMenu: [ [7, 10, 25, 50, -1], [7, 10, 25, 50, 'All'] ],
           columns: [
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title'},
                    { data: 'class_id', name: 'class_id' },
                    { data: 'subject', name: 'subject' },
                    { data: 'created_date', name: 'created_date' },
                    { data: 'updated_date', name: 'updated_date' },
                    { data: 'action', name : 'action', orderable : true, searchable: true}
                 ]

        });

        // table6.columns().every(function() {
        //     var column = this;

        //     var select = $('<select><option value="2">Grade 1</option><option value="4">Grade 2</option><option value="5">Grade 3</option></select>')
        //     .appendTo($("thead tr:eq(1) td").eq(this.index()))
        //     .on('change', function() {
        //         var val = $.fn.dataTable.util.escapeRegex(
        //             $(this).val()
        //         );

        //         column
        //         .search(val ? '^' + val + '$' : '', true, false)
        //         .draw();
        //     });

        //     column.data().unique().sort().each(function(d, j) {
        //         select.append('<option value="' + d + '">' + d + '</option>')
        //     });

        // });

        $('#clear-filter').click(function() {
            table6.search('').columns().search('').draw();
            $('.filter-input-integer').val('');
            $('.filter-input').val('');
        });


        $('.filter-input').keypress(function (e) {
            var key = e.which;
            if(key == 13)  // the enter key code
            {
                alert($(this).val());
                //var svalue = $(this).val();
                table6.column( $(this).data('column') ).search( $(this).val() ).draw();
            }

        });


        // $('.filter-input-integer').keypress(function (e) {

        //     var key = e.which;
        //     if(key == 13)  // the enter key code
        //     {
        //         // alert("Yessssssssss");
        //         var svalue = parseInt($(this).val());
        //         // alert(svalue);
        //         table6.column( $(this).data('column') ).search("^" + svalue + "$", true, false, true).draw();

        //     }

        // });


    });

</script>
@endpush
