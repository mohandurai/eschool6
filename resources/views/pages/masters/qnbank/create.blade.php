@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('qnbank/index') }}">Question Bank</a></li>
    <li class="breadcrumb-item active" aria-current="page">Question Bank</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">Create New Question Bank</h4>

        <div class="table-responsive">
        <form action="{{ url('qnbank/store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="title">Question Bank Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Question Bank Title" required>
            </div>

            <div class="form-group">
            <label for="title">Class</label>
                <select class="form-control" id="term" name="term">
                    <option selected value="0">ALL</option>
                    <option value="1">Term 1</option>
                    <option value="2">Term 2</option>
                    <option value="3">Term 3</option>
                    <option value="4">Term 4</option>
                </select>
            </div>

            <div class="form-group">
            <label for="title">Class</label>
                <select class="form-control" id="class_id" name="class_id">
                    <option selected value="0">Select Class</option>
                    @foreach($classlist as $clist)
                        <option value="{{$clist->id}}">{{$clist->class}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="title">Attach Question Bank PDF File</label>
                <input type="file" name="file" class="form-control" accept=".pdf">
            </div>

            <div class="form-group">
                <label for="title">Select Year</label>
                <select class="form-control" id="year" name="year">
                    <option value="2025" selected >2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                </select>
            </div>

            <div class="form-group">
                <label` for="exampleFormControlSelect1">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="Active" selected>Active</option>
                        <option value="InActive">InActive</option>
                    </select>
            </div>

        </div>
      </div>
      <button type="submit" class="btn btn-primary">Create Question Bank</button>
      </form>
      <input style="margin-top:20px;" type="button" value="Back" onClick="javascript:history.go(-1);">
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
    $("#class_id option[value=0]").prop('selected', true);
    $("#subject_id option[value=0]").prop('selected', true);
    $("#type option[value=0]").prop('selected', true);
});

    $('#class_id').change(function() {
        // alert("XXXXXXXXXXXX"); return false;
        $('#title').html('');
        $("#subject_id option[value=0]").prop('selected', true);

        var clsid = $(this).val();

        $.ajax({
            type: 'GET',
            url: "{{ url('/getSubjects') }}/"+clsid,
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

    $('#subject_id').change(function() {
        $('#title').html('');
        $("#title option[value=0]").prop('selected', true);

        var clsid = $("#class_id").val();
        var subid = $(this).val();

        var clssub = clsid + "~~~~~" + subid;
        // alert(clsid + "  AAAAAAAAAAAA " + subid);

        $.ajax({
            type: 'GET',
            url: "{{ url('/getchapters') }}/" + clssub,
            // complete: function() {
            //     $('#psdatasourcSpinner').hide();
            // },
            success: function(data2) {
                console.log(data2);
                $('#title').append(data2);
                // $(".table-responsive").html(data);
            }
        });

    });


</script>
@endpush
