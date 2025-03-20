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
    //print_r($qTitle);
    //print_r($question);
    //print_r($quetmp);
    //echo "</pre>";
    //exit;
@endphp

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('question/index') }}">Question Master</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="#">Edit Question Master</a></li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card"`>
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">
            Question Master Template Edit
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif
        </h4>

        <div class="table-responsive">

        <form action="{{ url('question/update') }}" method="post">
        @csrf

        <table id="dataTableExample" class="table">

        @if(!empty($question))
                <tr>
                    <td>ID</td><td>:</td>
                        <td>
                            {{$question->id}}
                            <input type="hidden" value="{{$question->id}}" name="id">
                        </td>
                </tr>
                <tr>
                    <td>Class</td><td>:</td>
                    <td>
                        <select class="form-control" name="class_id" id="class_id">
                            <option value="0">Select Class</option>
                            @foreach($clslst as $mm => $clist)
                                <option value="{{$mm}}" {{ $question->class_id == $mm ? 'selected' : '' }}>{{$clist}}</option>
                            @endforeach
                        </select>
                </tr>
                <tr>
                    <td>Subject</td><td>:</td>
                    <td>
                        <select class="form-control" name="subject_id" id="subject_id">
                            <option value="0">Select Subject</option>
                            @foreach($subjects as $kk => $subjt)
                                <option value="{{$kk}}" {{ $question->subject_id == $kk ? 'selected' : '' }}>{{$subjt}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Chapter Name</td><td>:</td>
                    <td>
                        <select class="form-control" name="chapter_id" id="chapter_id">
                            <option value="0">Select Chapter</option>
                            @foreach($chapts as $nn => $chapt)
                                <option value="{{$nn}}" {{ $question->chapter_id == $nn ? 'selected' : '' }}>{{$chapt}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Title</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" name="title" value="{{$question->title}}">
                    </td>
                </tr>

                <tr>
                    <td>Mode of Test</td><td>:</td>
                    <td>
                        <select class="form-control" id="mode_test" name="mode_test">
                            <option value="0" {{ $question->mode_test == 0 ? 'selected' : '' }}>Select Test Mode</option>
                            <option value="1" {{ $question->mode_test == 1 ? 'selected' : '' }}>Online</option>
                            <option value="2" {{ $question->mode_test == 2 ? 'selected' : '' }}>Practical</option>
                        </select>
                    </td>
                </tr>

            </table>


                <br><br>
        @endif

        @foreach($qTitle as $id3 => $qlist)

            <div class="form-group row">
                <div class="col">
                    @php(array_key_exists($id3, $quetmp) ? $checked = 'checked' : $checked = '')
                    <input type="checkbox" value="{{$id3}}" class="qntemplate" {{$checked}}>
                    <label class="mgn10px" for="question-template">{{$qlist}}</label><br>
                </div>
                <div class="col-md-6">
                    <div class="form-group row pt-0">
                        <div class="col">
                            <label>Order</label>
                            @php(array_key_exists($id3, $quetmp) ? $ord6 = $id3 : $ord6 = '')
                            <div id="qnorder">
                                <input class="typeahead" type="number" value="{{$ord6}}" name="order[{{$id3}}]" id="qntemplate{{$id3}}order" placeholder="Order No.">
                            </div>
                        </div>
                        <div class="col">
                            <label>No. of Questions</label>
                            <div id="noqns">
                                @php(array_key_exists($id3, $quetmp) ? $noque = $quetmp[$id3][0] : $noque = '')
                                @if($id3 == 6)
                                    <input class="typeahead" readonly value="1" type="number" name="noqns[{{$id3}}]" id="qntemplate{{$id3}}noqns" placeholder="No. Qns.">
                                @else
                                    <input class="typeahead" type="number" value="{{$noque}}" name="noqns[{{$id3}}]" id="qntemplate{{$id3}}noqns" placeholder="No. Qns.">
                                @endif
                            </div>
                        </div>
                        <div class="col">
                            <label>Marks for each</label>
                            @php(array_key_exists($id3, $quetmp) ? $mrkeach = $quetmp[$id3][1] : $mrkeach = '')
                            <div id="marks">
                                <input class="typeahead" type="number" value="{{$mrkeach}}" name="markque[{{$id3}}]" id="qntemplate{{$id3}}markque" placeholder="Mark each Qn.">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach

      </div>

      <hr>

    </div>

            <button type="submit" style="margin-bottom:30px;" class="btn btn-primary">Update Question Master Template</button>

    </form>

            <input style="margin-bottom:20px;" type=button value="Back" onClick="javascript:history.go(-1);">

    </div>

</div>

</div>

@endsection

@push('plugin-scripts')
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush


@push('custom-scripts')
<script src="{{ asset('assets/js/data-table.js') }}"></script>

<script>
    $(document).ready(function() {
        // $("#class_id option[value=0]").prop('selected', true);
        // $("#subject_id option[value=0]").prop('selected', true);
        // $("#chapter_id option[value=0]").prop('selected', true);
        // $("#mode_test option[value=0]").prop('selected', true);
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
                // console.log(data2);
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
                // console.log(data2);
                $('#chapter_id').append(data2);
                // $(".table-responsive").html(data);
            }
        });

    });
</script>
@endpush

