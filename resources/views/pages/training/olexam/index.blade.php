@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/prismjs/prism.css') }}" rel="stylesheet" />
@endpush

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

<!-- Before start Exam Student Fill necessary info  -->
    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelHeading">Before Start Exam - Fill up below Details:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:white;">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                  <form id="exam-register-form">
                  @csrf
                    <input type="hidden" name="exam_id" id="exam_id">

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Roll :</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="rollno" name="rollno" placeholder="Enter Roll No." value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name :</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="stud_name" name="stud_name" placeholder="Enter Name ...." value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Class :</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="class_id" name="class_id" placeholder="Enter Class ...." value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Section :</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="Section" name="Section" placeholder="Enter Section ... " value="NA" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Term :</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="term" name="term" placeholder="Term Name ..." value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Subject</label>
                            <div class="col-sm-12">
                                <textarea id="subject_id" name="subject_id" required="" placeholder="Enter Subject Name ....." class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="submitbtn" value="create">Begin Exam</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- Ends Before start Exam Student Fill necessary info  -->

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
      <h4> Student Online Exam </h4>

        <div class="table-responsive">
        <table id="tracker_datatable" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Exam Title</th>
                    <th>Qn.Master ID</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Duration Minutes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if(!empty($chaps))
            @foreach($chaps as $slist)
                <tr>
                    <td>{{$slist->id}}</td>
                    <td>{{$slist->test_title}}</td>
                    <td>{{$slist->qn_master_templ_id}}</td>
                    <td>{{$slist->start_date}}</td>
                    <td>{{$slist->end_date}}</td>
                    <td>{{$slist->duration}}</td>
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

$(document).on('click', '#mediumButton2', function(e) {
    var alloc_id = $(this).attr("alt");
    $("#exam_id").val(alloc_id);
});

// Submit button
$(document).on('click', '#submitbtn', function(e) {
    e.preventDefault();
    var form6 = $('#exam-register-form').serializeArray();
    $.each(form6, function(i, field){

        if(field.name === "exam_id") {
            // alert("ZZZZZZZZZZZZZZZZ");
            // return false;
            window.location= "{{ url('olexam/')}}/"+field.value+"/attendexam";
        }
    });

});


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
           ajax: "{{ url('examslist') }}",
        //    pageLength: 5,
           lengthMenu: [ [7, 10, 25, 50, -1], [7, 10, 25, 50, 'All'] ],
           columns: [
                    { data: 'id', name: 'id' },
                    { data: 'test_title', name: 'test_title'},
                    { data: 'qn_master_templ_id', name: 'qn_master_templ_id' },
                    { data: 'start_date', name: 'start_date' },
                    { data: 'end_date', name: 'end_date' },
                    { data: 'duration', name: 'duration' },
                    { data: 'action', name : 'action', orderable : true, searchable: true}
                 ]

        });


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

     });

</script>
@endpush
