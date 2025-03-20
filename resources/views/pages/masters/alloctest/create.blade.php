@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<style type="text/css">
.mgn10px {
    margin-left: 10px;
    }
</style>
@endpush

@section('content')

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('alloctest/index') }}">Masters</a></li>
    <li class="breadcrumb-item active" aria-current="page">Allocate Test from Question Master</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">Create Test Allocation</h4>

        <div class="table-responsive">
        <form action="{{ url('alloctest/store') }}" method="post">
            @csrf

            <input type="hidden" name="assign_to" value="0">
            <input type="hidden" id="test_title" name="test_title" value="">

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
                <label for="exampleFormControlSelect1">Select Class</label>
                <select class="form-control" id="class_id" name="class_id">
                    <option value="0" selected>Select Class</option>
                    @foreach($classes as $kk => $clist)
                        <option value="{{$kk}}">{{$clist}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="title">Select Section</label>
                <select class="form-control" id="sec_id" name="sec_id">
                    <option value="0" selected>Select Section</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                    <option value="F">F</option>
                    <option value="G">G</option>
                    <option value="H">H</option>
                    <option value="I">I</option>
                    <option value="J">J</option>
                </select>
            </div>

            <div class="form-group">
                <label` for="exampleFormControlSelect1">Subject</label>
                <select class="form-control" id="subject_id" name="subject_id">
                    <option value="0" selected>Select Subject</option>
                </select>
            </div>

            <div class="form-group">
                <label for="title">Select Question Master</label>
                <select class="form-control" id="qn_master_templ_id" name="qn_master_templ_id">
                    <option value="0" selected disabled>Select Title</option>
                    @foreach($qntemptitle as $clist)
                        <option value="{{$clist->id}}">{{$clist->title}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="title">Duration in Minutes</label>
                <input type="number" class="form-control" id="duration" name="duration" placeholder="No. of Minutes..." required>
            </div>

            <div class="form-group">
                <label for="title">Year</label>
                <input type="number" class="form-control" id="year" name="year" placeholder="Year ..." required>
            </div>

            <div class="form-group">
                <label for="title">Term</label>
                <input type="text" class="form-control" id="term" name="term" placeholder="Term ..." required>
            </div>

            <div class="form-group">
                <label for="title">Start Date</label>
                <input type="date" class="form-control" id="datestart" name="datestart" placeholder="Start Date..." required>
            </div>

            <div class="form-group">
                <label for="title">End Date</label>
                <input type="date" class="form-control" id="endstart" name="endstart" placeholder="End Date..." required>
            </div>



            <div class="form-group">
                <label` for="exampleFormControlSelect1">Test Status</label>
                    <select class="form-control" id="mode_test" name="mode_test">
                        <option value="0" selected>Select Test Mode</option>
                        <option value="1">Active</option>
                        <option value="2">InActive</option>
                    </select>
            </div>

        </div>
      </div>

            <button type="submit" class="btn btn-primary">Allocate Test</button>
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
    $("#qn_master_templ_id option[value=0]").prop('selected', true);
});

$('#qn_master_templ_id').change(function() {
    // var qidTtile = $(this).find(":selected").text();
    // alert(qidTtile);
    // return false;
    $('#test_title').val($(this).find(":selected").text());
});

$('#class_id').change(function() {
        // alert("ZZZZZZZZZZZZZ"); return false;
        $('#subject_id').html('');
        $("#subject_id option[value=0]").prop('selected', true);

        var clsid = $(this).val();

        $.ajax({
            type: 'GET',
            url: "{{ url('/getcontentsubject') }}/"+clsid,
            // complete: function() {
            //     $('#psdatasourcSpinner').hide();
            // },
            success: function(data2) {
                console.log(data2);
                $('#subject_id').append(data2);
                // $(".table-responsive").html(data);
            }
        });

    });

</script>
@endpush

