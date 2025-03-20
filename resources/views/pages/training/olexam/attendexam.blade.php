@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<style type="text/css">
    .form-control {
        background-color: white;
    }

    .fixed-element {
        position: fixed;
        top: 100px;
        right: 60px;
        font-size: 20px;
        color: white;
    }
    .popover-content,
    .note-children-container {
        display:none;
    }

</style>
@endpush

@php
    //echo "<pre>";
    //print_r($qns);
    //echo "</pre>";
    //exit;
@endphp

@php($alpha = array(1=>"A",2=>"B",3=>"C",4=>"D",5=>"E",6=>"F",7=>"G",8=>"H",9=>"I",10=>"J",11=>"K",12=>"L",13=>"M",14=>"N",15=>"N"))

@section('content')

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">

            <div class="fixed-element">
                <p id="timer"></p>
                <button class="btn btn-primary" type="button" id="re-direct">Exit</button>
            </div>


            <h4>{{$examtitle}}</h4>
            @if(Session::has('message'))
            </br>
            <div class="alert alert-warning alert-dismissible fade show below-margin" role="alert">
                <strong>{{ Session::get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            @endif

            @php($count=0)
            @foreach($qntit as $kk => $qh)
            <div class="card-body">

                <form id="theForm" action="{{ url('olexam/saveexam') }}" method="post">
                    @csrf

                    <input type="hidden" name="test_id" value="{{ $test_id }}">
                    <input type="hidden" name="student_id" value="{{ $stud_id }}">
                    <input type="hidden" name="qnstempid" value="{{ $qnstempid }}">


                       @php($count++)

                        <label style="color:yellow;"><h5>{{$romlet[$count]}}. {{$qh}}</h5></label>

                        @foreach($qns[$kk] as $qq => $question)

                        @if($kk == 3)
                        <div class="form-group">

                            <table width="80%" cellspacing="5" cellpadding="5" border="1">
                                <tr align="center" style="background-color:yellow;color:black;">
                                    <td width="50%">Column A</td>
                                    <td width="80%">Column B</td>
                                </tr>
                                <tr>
                                    <td width="30%">
                                        <table cellspacing="10" cellpadding="10" border="1" width="100%">
                                            @foreach($question[0]['A'] as $aa => $cols)
                                                <tr><td>{{ $aa+1 }})</td> <td>{{ $cols }}</td></tr>
                                            @endforeach
                                        </table>

                                    </td>
                                    <td width="70%">
                                        <table id="table2" cellspacing="5" cellpadding="5" border="1" width="100%">
                                            @foreach($question[0]['B'] as $bb => $cols)
                                            <tr><td width="10%">{{ $alpha[$bb+1] }}</td><td>{{ $cols }}</td>
                                                <td><button class="btn up">▲</button></td>
                                                <td><button class="btn down">▼</button></td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <button type="submit" id="match-apply" class="btn btn-primary">Apply Matching</button>
                            <br><br>
                            <input type="text" name="3_1" style="background-color:#silver;" class="form-control" id="ans-qns3" readonly>
                            <br>

                        </div>

                        @elseif($kk == 4)
                        <br>
                        Q. No-{{$qq}}. &nbsp;&nbsp; <label class="form-check-label"> {{$question}} </label>
                        <br>
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="{{$kk}}_{{$qq}}" id="ans_{{$kk}}_{{$qq}}" value="true">
                                    True
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="{{$kk}}_{{$qq}}" id="ans_{{$kk}}_{{$qq}}" value="false">
                                    False
                                </label>
                            </div>
                        </div>

                        @elseif($kk == 5)

                        <div class="form-group">
                        Q. No-{{$qq}}. <textarea class="text_box_note">{{$question}}</textarea>
                            <input type="text" name="{{$kk}}_{{$qq}}" style="background-color:#silver;" class="form-control" id="{{$kk}}_{{$qq}}" value="" placeholder="Type Answer for Qn. {{$qq}}">
                            <br><br>
                        </div>


                        @elseif($kk == 6)
                        <div class="form-group">

                                <table id="table3" cellspacing="5" cellpadding="5" border="1" width="50%">
                                    @foreach($question as $ss1 => $ss2)
                                    <tr><td width="10%">{{ $ss1 }}</td><td>{{ $ss2 }}</td>
                                        <td><button class="btn up">▲</button></td>
                                        <td><button class="btn down">▼</button></td>
                                    </tr>
                                    @endforeach
                                </table>

                               <br>
                               <button type="submit" id="ReOrd-apply" class="btn btn-primary">Apply Re-Ordering</button>
                                <br><br>
                                <input type="text" name="6_1" style="background-color:#silver;" class="form-control" id="ans-qns6" readonly>

                        </div>


                        @elseif($kk == 7)

                        @php($tt = "mcqimg7_".$qq)

                        <div class="form-group">

                            Q. No-{{$qq}}. &nbsp;&nbsp;

                            <textarea class="multipl_choice">{{$question[0]}}</textarea>
                            @if(isset($imgQuens[$tt][0]))
                            <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][0]) }}" height="150em" width="200em" alt="" title="" />
                            @endif

                            <div class="form-check form-check-inline">
                                @if($question[1] != null)
                                <label class="form-check-label"> (1) &nbsp;&nbsp;&nbsp; {{$question[1]}} </label>
                                @endif
                                @if(isset($imgQuens[$tt][1]))
                                (1) &nbsp;&nbsp;&nbsp; <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][1]) }}" height="100em" width="150em" alt="" title="" />
                                @endif
                            </div>

                            <div class="form-check form-check-inline">
                                @if($question[2] != null)
                                <label class="form-check-label"> (2) &nbsp;&nbsp;&nbsp; {{$question[2]}} </label>
                                @endif
                                @if(isset($imgQuens[$tt][2]))
                                (2) &nbsp;&nbsp;&nbsp; <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][2]) }}" height="100em" width="150em" alt="" title="" />
                                @endif
                            </div>

                            <div class="form-check form-check-inline">
                                @if($question[3] != null)
                                <label class="form-check-label"> (3) &nbsp;&nbsp;&nbsp; {{$question[3]}} </label>
                                @endif
                                @if(isset($imgQuens[$tt][3]))
                                (3) &nbsp;&nbsp;&nbsp; <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][3]) }}" height="100em" width="150em" alt="" title="" />
                                @endif
                            </div>

                            <div class="form-check form-check-inline">
                                @if($question[4] != null)
                                <label class="form-check-label"> (4) &nbsp;&nbsp;&nbsp; {{$question[4]}} </label>
                                @endif
                                @if(isset($imgQuens[$tt][4]))
                                (4) &nbsp;&nbsp;&nbsp; <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][4]) }}" height="100em" width="150em" alt="" title="" />
                                @endif
                            </div>

                            <div class="form-check form-check-inline">
                                @if($question[5] != null)
                                <label class="form-check-label"> (5) &nbsp;&nbsp;&nbsp; {{$question[5]}} </label>
                                @endif
                                @if(isset($imgQuens[$tt][5]))
                                (5) &nbsp;&nbsp;&nbsp; <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][5]) }}" height="100em" width="150em" alt="" title="" />
                                @endif
                            </div>

                            <div class="form-check form-check-inline">
                                @if($question[6] != null)
                                <label class="form-check-label"> (6) &nbsp;&nbsp;&nbsp; {{$question[6]}} </label>
                                @endif
                                @if(isset($imgQuens[$tt][6]))
                                (6) &nbsp;&nbsp;&nbsp; <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][6]) }}" height="100em" width="150em" alt="" title="" />
                                @endif
                            </div>

                            <br>

                            <div class="form-text form-check-inline">
                                <input type="text" placeholder="Type correct choice by 1,2,3..." class="form-control" name="{{$kk}}_{{$qq}}" id="{{$kk}}_{{$qq}}" value="">
                            </div>

                        </div>

                        @elseif($kk == 8)

                        <div class="form-group">

                        <table id="table8" cellspacing="5" cellpadding="5" border="1" width="90%">
                            @if(str_contains($qq, "-left"))
                                @php($q8ord = explode("-",$qq))
                                <tr>
                                    <td width="12%">
                                    Q. No - {{ $q8ord[0] }})
                                    </td>
                                    <td width="25%">
                                        <label class="form-check-label"> {{$question}} </label>
                                    </td>
                                    <td width="70%">
                                        <div class="form-text form-check-inline" style="margin-left:30px;">
                                        <label class="form-check-label">Add Answer Word</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input class="form-control" name="{{$kk}}_{{$q8ord[0]}}" id="{{$kk}}_{{$q8ord[0]}}">
                                        </label>
                                    </td>
                                </tr>
                            @else
                            @endif
                            </table>

                        </div>

                        @elseif($kk == 10)
                        <div class="form-group">
                            @php($q10Heads = explode("~~~~~",$question))
                            <table id="table10" cellspacing="10" cellpadding="10" border="1" width="90%">

                                    <tr>
                                        <td width="12%">
                                         Q. No. - {{ $qq }})
                                        </td>
                                        <td>
                                            {{ $q10Heads[0] }}
                                        </td>
                                        <td>
                                            {{ $q10Heads[1] }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                    <td>
                                            <textarea class="form-control" name="{{$kk}}_{{$qq}}-left" placeholder="Type Answer for Qn. {{$qq}}" rows="5" cols="20"></textarea>
                                        </td>
                                        <td>
                                            <textarea class="form-control" name="{{$kk}}_{{$qq}}-right" placeholder="Type Answer for Qn. {{$qq}}" rows="5" cols="20"></textarea>
                                        </td>
                                    </tr>
                                </table>
                        </div>


                        @else
                        <div class="form-group">

                            Q. No-{{$qq}}. &nbsp;&nbsp; <label class="form-check-label"> {{$question}} </label>
                            <input type="text" name="{{$kk}}_{{$qq}}" style="background-color:#silver;" class="form-control" id="{{$kk}}_{{$qq}}" value="" placeholder="Type Answer for Qn. {{$qq}}">
                            <br><br>

                        </div>
                        @endif

                        @endforeach
                    </div>

            @endforeach

            <br>
            <button type="submit" class="btn btn-primary">Submit Answers</button>
        </div>

        </form>

    </div>
</div>

@endsection

@push('plugin-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/TableDnD/0.9.1/jquery.tablednd.js" integrity="sha256-d3rtug+Hg1GZPB7Y/yTcRixO/wlI78+2m08tosoRn7A=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
@endpush


@push('custom-scripts')
<script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush

@push('custom-scripts')
<script>

    let endTime = new Date("{{ $endTime->format('Y-m-d H:i:s') }}").getTime();

    function startCountdown() {
        let interval = setInterval(() => {
            // Get the current time
            let now = new Date().getTime();

            // Calculate the remaining time
            let distance = endTime - now;

            // Time calculations for minutes and seconds
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="timer"
            document.getElementById("timer").innerHTML = minutes + " Min " + seconds + " Sec ";

            // If the countdown is over, stop the timer and redirect
            if (distance < 0) {
                clearInterval(interval);
                document.getElementById("timer").innerHTML = "EXAM OVER";
                alert(" Sorry your alloted Exam Duration Finished !!!");
                // Redirect to submit page or show an alert
                // window.location.href = "";
                // document.getElementById('theForm').submit();
                var form = document.getElementById('theForm');
                // Trigger the form submission
                form.submit();
            }
        }, 1000); // Update every second
    }

    window.onload = startCountdown;

    // $(document).on(function() {
    //     $('#summernote51').html(escape($('#summernote51a').summernote('code', $('#summernote51a').html())));
    // });

    $(document).ready(function() {

    $('#summernote51').summernote();
    $('#summernote52').summernote();
    $('#summernote53').summernote();
    $('#summernote54').summernote();
    $('#summernote55').summernote();
    $('#summernote56').summernote();
    $('#summernote57').summernote();
    $('#summernote58').summernote();
    $('#summernote59').summernote();
    $('#summernote510').summernote();

    $('#summernote71').summernote();
    $('#summernote72').summernote();
    $('#summernote73').summernote();
    $('#summernote74').summernote();
    $('#summernote75').summernote();
    $('#summernote76').summernote();
    $('#summernote77').summernote();
    $('#summernote78').summernote();
    $('#summernote79').summernote();
    $('#summernote710').summernote();

        $('.text_box_note').summernote({
            height: 30,
            toolbar: [
                ['help', ['help']]
            ],
        });

        $(".note-codable").hide();
        $('.text_box_note').next().find(".note-editable").attr("contenteditable", false);

        $('.multipl_choice').summernote({
            height: 30,
            toolbar: [
                ['help', ['help']]
            ],
        });
        $(".note-codable").hide();
        $('.multipl_choice').next().find(".note-editable").attr("contenteditable", false);




        $('#ReOrd-apply').click(function(){
            // alert("UUUUUUUUUUUUUU");
            var ans4 = "";
            $("#table3 tr").each(function(i) {
                // find the first td in the row
                var value = $(this).find("td:first").text();
                // display the value in console
                ans4 = ans4 + ',' + value;
            });
            // alert(ans4.substring(1));
            $('#ans-qns6').val(ans4.substring(1));
            return false;
        });


        $('#match-apply').click(function(){
            // alert("UUUUUUUUUUUUUU");
            var ans3 = "";
            $("#table2 tr").each(function(i) {
                // find the first td in the row
                var value = $(this).find("td:first").text();
                // display the value in console
                ans3 = ans3 + ',' + value;
            });
            // alert(ans3.substring(1));
            $('#ans-qns3').val(ans3.substring(1));
            return false;
        });

        $('.up').click(function(){
            var row = $(this).closest('tr');
            row.insertBefore(row.prev());
            return false;
        });

        $('.down').click(function(){
            var row = $(this).closest('tr');
            row.insertAfter(row.next());
            return false;
        });

        $("#class_id option[value=0]").prop('selected', true);
        $("#subject_id option[value=0]").prop('selected', true);
        $("#chapter_id option[value=0]").prop('selected', true);
        $("#mode_test option[value=0]").prop('selected', true);

        $("#re-direct").click(function() {
            var url = "{{ url('olexam/index') }}";
            window.location.href = url;
        });
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

    $('#class_id').change(function() {
        // alert("UUUUUUUUUUU"); return false;
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
        $('#chapter_id').html('');
        $("#chapter_id option[value=0]").prop('selected', true);

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
