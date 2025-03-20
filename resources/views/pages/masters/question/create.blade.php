@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<style type="text/css">
    .mgn10px {
        margin-left: 10px;
    }
</style>
@endpush

@php
//echo "<pre>";
//print_r($qntemp);
//echo "</pre>";
//exit;
//@endphp

@section('content')

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('question/index') }}">Masters</a></li>
        <li class="breadcrumb-item active" aria-current="page">Question Master</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 style="margin-bottom:10px;">Create New Question Master</h4>

                <div class="table-responsive">
                    <form action="{{ url('question/store') }}" method="post">
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
                            <label for="class_id">Class</label>
                            <select class="form-control" id="class_id" name="class_id">
                                <option value="0" selected disabled>Select Class</option>
                                @foreach($classlist as $clist)
                                <option value="{{$clist->id}}">{{$clist->class}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <select class="form-control" id="subject_id" name="subject_id">
                                <option value="0" selected>Select Subject</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="chapter_id">Chapter Title</label>
                            <select class="form-control" id="chapter_id" name="chapter_id">
                                <option value="0" selected>Select Chapter/Multiple</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">Question Master Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Question Master Template Title" required>
                        </div>


                        <div class="form-group">
                            <label` for="exampleFormControlSelect1">Mode of Test</label>
                                <select class="form-control" id="mode_test" name="mode_test">
                                    <option value="0" selected disabled>Select Test Mode</option>
                                    <option value="1" selected>Online</option>
                                    <option value="2" selected>Practical</option>
                                </select>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <h5>Select Question Template:</h5>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>

                        @foreach($qntemp as $id3 => $qnlist)

                        <div class="form-group row">
                            <div class="col">
                                <input type="checkbox" value="{{$id3}}" name="qntemp[{{$id3}}]" class="qntemplate">
                                <label class="mgn10px" for="question-template">{{$qnlist}}</label><br>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row pt-0">
                                    <div class="col">
                                        <label>Order</label>
                                        <div id="qnorder">
                                            <input class="typeahead" disabled type="number" name="order[{{$id3}}]" id="qntemplate{{$id3}}order" placeholder="Order No.">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label>No. of Questions</label>
                                        <div id="noqns">
                                            @if($id3 == 6)
                                                <input class="typeahead" disabled readonly value="1" type="number" name="noqns[{{$id3}}]" id="qntemplate{{$id3}}noqns" placeholder="No. Qns.">
                                            @else
                                                <input class="typeahead" disabled type="number" name="noqns[{{$id3}}]" id="qntemplate{{$id3}}noqns" placeholder="No. Qns.">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label>Marks for each</label>
                                        <div id="marks">
                                            <input class="typeahead" disabled type="number" name="markque[{{$id3}}]" id="qntemplate{{$id3}}markque" placeholder="Mark each Qn.">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create Question</button>
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
        $("#chapter_id option[value=0]").prop('selected', true);
        $("#mode_test option[value=0]").prop('selected', true);
    });


    $("input:checkbox.qntemplate").click(function() {
        var seltemp1 = "#qntemplate" + $(this).val() + "order";
        var seltemp2 = "#qntemplate" + $(this).val() + "noqns";
        var seltemp3 = "#qntemplate" + $(this).val() + "markque";
        // return false;
        if (!$(this).is(":checked")) {
            $(seltemp1).prop("disabled", true);
            $(seltemp1).val('0');
            $(seltemp2).prop("disabled", true);
            $(seltemp2).val('0');
            $(seltemp3).prop("disabled", true);
            $(seltemp3).val('0');
        } else {
            // alert('you are checked ... ' + $(this).val());
            $(seltemp1).removeAttr('disabled');
            $(seltemp2).removeAttr('disabled');
            $(seltemp3).removeAttr('disabled');
        }

    });

    // $('#chapter_id').change(function() {
    //     // alert("ZZZZZZZZZZZZZZ"); return false;
    //     var title6 = $("#chapter_id option:selected").text();
    //     $("#chaptitle").val(title6);
    // });

    $('#class_id').change(function() {

        $('#subject_id').html('');
        $("#subject_id option[value=0]").prop('selected', true);

        var clsid = $(this).val();

        $.ajax({
            type: 'GET',
            url: "{{ url('/getcontentsubject') }}/" + clsid,
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

    $('#subject_id').change(function() {
        // alert("TTTTTTTTTTTT"); return false;
        // $('#chapter_id').html('');
        // $("#chapter_id option[value=0]").prop('selected', true);

        var subid = $(this).val();
        var clsid = $("#class_id").val();

        $.ajax({
            type: 'GET',
            url: "{{ url('/getcontentchapt') }}/" + subid + "~~~" + clsid,
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
