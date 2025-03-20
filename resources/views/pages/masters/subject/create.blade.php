@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('video/index') }}">Masters</a></li>
    <li class="breadcrumb-item active" aria-current="page">Subject Master</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">Create New Subject</h4>

        <div class="table-responsive">
        <form action="{{ url('subject/store') }}" method="post">
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
            <label for="title">Class</label>
                <select class="form-control" id="class_id" name="class_id">
                    <option selected disabled>Select Class</option>
                    @foreach($classlist as $clist)
                        <option value="{{$clist->id}}">{{$clist->class}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="title">Add Subject Name</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>


            <div class="form-group">
                <label for="remarks">Add Remarks</label>
                <input type="text" class="form-control" id="remarks" name="remarks">
            </div>


            <div class="form-group">
            <label for="title">School ID</label>
            <input type="text" class="form-control" value="1" readonly name="school_id" required>
            </div>

        </div>
    </div>
        <button type="submit" class="btn btn-primary">Create Subject</button>
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
$('#class_id').change(function() {
        // alert("UUUUUUUUUUU"); return false;
        $('#title').html('');

        var clsid = $(this).val();

        $.ajax({
            type: 'GET',
            url: "{{ url('/getchapters') }}/"+clsid,
            // complete: function() {
            //     $('#psdatasourcSpinner').hide();
            // },
            success: function(data2) {
                // console.log(data2);
                $('#title').append(data2);
                // $(".table-responsive").html(data);
            }
        });

    });
</script>
@endpush
