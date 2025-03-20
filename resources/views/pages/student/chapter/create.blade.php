@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('chapter/index') }}">Student</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chapters</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">Create New Chapter</h4>

        <div class="table-responsive">
        <form action="{{ url('chapter/store') }}" method="post">
            @csrf
            <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label` for="exampleFormControlSelect1">Class</label>
                <select class="form-control" id="class_id" name="class_id">
                    <option selected="selected" value="0">Select Class</option>
                    @foreach($classlist as $clist)
                        <option value="{{$clist->id}}">{{$clist->class}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label` for="exampleFormControlSelect1">Subject</label>
                <select class="form-control" id="subject_id" name="subject_id">
                    <option selected disabled>Select Subject</option>
                </select>
            </div>

            <div class="form-group">
            <label for="title">School ID</label>
            <input type="text" class="form-control" value="1" readonly name="school_id" required>
            </div>

            <br>
            <button type="submit" class="btn btn-primary">Create Chapter</button>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush

@push('custom-scripts')
<script>

$(document).ready(function() {
    $("#subject_id option[value=0]").prop('selected', true);
});

$('#class_id').change(function() {

        $('#subject_id').html('');

        var clsid = $(this).val();
        //alert("UUUUUUUUUUU "+clsid);
        //return false;

        $.ajax({
            type: 'GET',
            url: "{{ url('getsubjects') }}/"+clsid,
            // complete: function() {
            //     $('#psdatasourcSpinner').hide();
            // },
            success: function(data2) {
                // console.log(data2);
                $('#subject_id').append(data2);
                // $(".table-responsive").html(data);
            }
        });

});
</script>
@endpush

