@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('video/index') }}">Masters</a></li>
    <li class="breadcrumb-item active" aria-current="page">Content Master</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">Create New Content</h4>

        <div class="table-responsive">
        <form action="{{ url('content/store') }}" method="post">
            @csrf
            <div class="form-group">

            <label for="SchoolID">School ID</label>
            <input type="text" class="form-control" value="1" readonly name="school_id" required>
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1">Class</label>
                <select class="form-control" id="class_id" name="class_id">
                    <option value="0" selected>Select Class</option>
                    @foreach($classlist as $clist)
                        <option value="{{$clist->id}}">{{$clist->class}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label` for="exampleFormControlSelect1">Subject</label>
                <select class="form-control" id="subject_id" name="subject_id">
                    <option value="0" selected>Select Subject</option>
                </select>
            </div>

            <div class="form-group">
                <label` for="exampleFormControlSelect1">Chapter</label>
                <select class="form-control" id="chapter_id" name="chapter_id">
                    <option value="0" selected>Select Chapter/Multiple</option>
                </select>
            </div>

            <div class="form-group">
                <label` for="exampleFormControlSelect1">Video Mode</label>
                <select class="form-control" id="video_type_id" name="video_type_id">
                    <option value="0" selected>Select Mode</option>
                    <option value="1">CLT</option>
                    <option value="2">TTK</option>
                    <option value="3">Others</option>
                </select>
            </div>

            <div class="form-group">
                <label` for="exampleFormControlSelect1">Video Name</label>
                <select class="form-control" id="video_id" name="video_id">
                    <option value="0" selected>Select Video</option>
                </select>
            </div>

            <div class="form-group">
                <label for="Description">Content Description/Title</label>
                <input type="text" class="form-control" id="content" name="content">
            </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Create Content Master</button>
      </form>
      <input style="margin-top:20px;" type="button" value="Back" onClick="javascript:history.go(-1);">
    </div>
  </div>
</div>
@endsection

@push('plugin-scripts')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
@endpush

@push('custom-scripts')
<script>

$(document).ready(function() {
    $("#class_id option[value=0]").prop('selected', true);
    $("#subject_id option[value=0]").prop('selected', true);
    $("#video_id option[value=0]").prop('selected', true);
    $("#chapter_id option[value=0]").prop('selected', true);
    $("#video_type_id option[value=0]").prop('selected', true);
});

    function confirmation()
    {
            if(confirm('Are you sure to delete this record.....?'))
            {
                return true;
            } else {
                return false;
            }
    }

    $('#video_type_id').change(function() {

        $('#video_id').html('');

        var vtid = $(this).val();
        var chapid = $("#title").val();
        var clsid = $("#class_id").val();
        // alert(vtid+" UUUUUUUUUUU "+clsid); return false;
        $.ajax({
            type: 'GET',
            // data: {vid: vtid, cid:clsid },
            url: "{{ url('/getvideos') }}/"+chapid+"~~~"+vtid+"~~~"+clsid,
            // complete: function() {
            //     $('#psdatasourcSpinner').hide();
            // },
            success: function(data) {
                console.log(data);
                $('#video_id').append(data);
                // $(".table-responsive").html(data);
            }
        });

    });

    $('#chapter_id').change(function() {
        var chapter_title = $('#chapter_id').find(":selected").text();
        // alert(chapter_title); return false;
        $("#chaptitle").attr('value', chapter_title);
    });

    $('#class_id').change(function() {
        // alert("UUUUUUUUUUU"); return false;
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
        $("#chapter_id option[value=0]").prop('selected', true);

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
                $('#chapter_id').append(data2);
                // $(".table-responsive").html(data);
            }
        });

    });

</script>
@endpush
