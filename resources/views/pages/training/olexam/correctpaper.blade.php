@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
<style type="text/css">
    .form-control {
        background-color: white;
    }
    .note-editable {
        padding: 1px;
        border: solid 1px #5c8593;
        font-size: 10pt;
        color:#42484d;
        background-color:#FFFFFF !important;
    }
    .popover-content,
    .note-children-container {
        display:none;
    }
    .note-icon-question {
        display:none;
    }
</style>
@endpush

@php
    //echo "<pre>";
    //print_r($qns);
    //echo " ======================================= <br>";
    //print_r($stud_ans);
    //echo " ======================================= <br>";
    //print_r($act_ans);
    //echo "</pre>";
    //exit;
@endphp

@php($alpha = array(1=>"A",2=>"B",3=>"C",4=>"D",5=>"E",6=>"F",7=>"G",8=>"H",9=>"I",10=>"J",11=>"K",12=>"L",13=>"M",14=>"N",15=>"N"))
@php($numbr = array("A"=>0,"B"=>1,"C"=>2,"D"=>3,"E"=>4))
@php($temp = 0)
@php($temp2 = 0)

@section('content')

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <h4>{{$examtitle2}}</h4>
            @if(Session::has('message'))
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

                <form action="{{ url('olexam/savecorrected') }}" method="post">
                    @csrf

                    <input type="hidden" name="allocTestId" value="{{ $allocTestId }}">
                    <input type="hidden" name="student_id" value="{{ $stud_id }}">
                    <input type="hidden" name="qn_template_id" value="{{ $qn_template_id }}">

                    <div class="form-group">

                        @php($count++)

                        <label>
                            <h5>{{$romlet[$count]}}. {{$qh}}</h5>
                        </label>

                        @foreach($qns[$kk] as $qq => $question)
                        <br>

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
                                                @foreach($question['A'] as $aa => $cols)
                                                    <tr><td>{{ $aa+1 }})</td> <td>{{ $cols }}</td></tr>
                                                @endforeach
                                            </table>

                                        </td>
                                        <td width="70%">
                                            <table id="table2" cellspacing="10" cellpadding="10" border="1" width="100%">

                                                @php($ans3_1 = explode(",",$stud_ans["3_1"]))
                                                @php( array_slice($ans3_1, 0, -1) )
                                                @foreach($ans3_1 as $ii => $rrr)
                                                <tr>
                                                <td>
                                                    {{ $question['B'][$numbr[$rrr]] }}
                                                </td>
                                                </tr>
                                                @endforeach

                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <br>

                                <div style="background-color:green; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;

                                    @if($stud_ans["3_1"] == $act_ans["3_1"])
                                        @php($markval = $eachmark[3])
                                    @else
                                        @php($markval = 0)
                                    @endif
                                    <label class="form-check-label">Correct Marks by Teacher :
                                        <input type="number" name="mark_{{$kk}}_{{$qq}}" id="mark_{{$kk}}_{{$qq}}" placeholder="Add Marks ..." value="{{$markval}}">
                                    </label>
                                </div>

                        </div>

                        @elseif($kk == 4)
                        Q. No-{{$qq}}. &nbsp;&nbsp; <label class="form-check-label"> {{$question}} </label>
                        <br>

                        <div class="form-group">

                            <div style="background-color:grey; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                @php($arr2 = $kk . "_" . $qq)
                                <label class="form-check-label">
                                    Student Answer : {{$stud_ans[$arr2]}}
                                </label>
                            </div>

                            <div style="background-color:blue; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                @php($arr2 = $kk . "_" . $qq)
                                <label class="form-check-label">
                                    Actual Answer : {{$act_ans[$arr2]}}
                                </label>
                            </div>

                            <div style="background-color:green; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                @if($stud_ans[$arr2] == $act_ans[$arr2])
                                @php($markval = $eachmark[4])
                                @else
                                @php($markval = 0)
                                @endif
                                <label class="form-check-label">Correct Marks by Teacher :
                                    <input type="number" name="mark_{{$kk}}_{{$qq}}" id="mark_{{$kk}}_{{$qq}}" placeholder="Add Marks ..." value="{{$markval}}">
                                </label>

                            </div>

                        </div>

                        @elseif($kk == 5)

                        <div class="form-group">
                            Q. No-{{$qq}}. <textarea class="text_box_note">{{$question}}</textarea>
                            <br>
                            <div style="background-color:grey; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                @php($arr2 = $kk . "_" . $qq)
                                <label class="form-check-label">
                                    Student Answer : {{$stud_ans[$arr2]}}
                                </label>
                            </div>

                            <div style="background-color:blue; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                @php($arr2 = $kk . "_" . $qq)
                                <label class="form-check-label">
                                    Actual Answer : {{$act_ans[$arr2]}}
                                </label>
                            </div>

                            <div style="background-color:green; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                @if($stud_ans[$arr2] == $act_ans[$arr2])
                                @php($markval = $eachmark[4])
                                @else
                                @php($markval = 0)
                                @endif
                                <label class="form-check-label">Correct Marks by Teacher :
                                    <input type="number" name="mark_{{$kk}}_{{$qq}}" id="mark_{{$kk}}_{{$qq}}" placeholder="Add Marks ..." value="{{$markval}}">
                                </label>

                            </div>
                        </div>

                        @elseif($kk == 6)

                         <div class="form-group">

                            @if($qq == 'qns')
                                <div class="form-text form-check-inline" style="margin-left:30px;">
                                    {{$question}}
                                </div>
                            @else
                                <div class="form-text form-check-inline" style="margin-left:30px;">
                                    <table id="table2" cellspacing="10" cellpadding="10" border="1" width="50%">
                                        @foreach($qns[6]['ReOrds'] as $sss)
                                        <tr>
                                        <td>
                                            {{ $sss }}
                                        </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <br><br>
                                <div style="background-color:grey; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="form-check-label">
                                        Student Answer : {{$stud_ans["6_1"]}}
                                    </label>
                                </div>

                                <div style="background-color:blue; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                    @php($arr2 = $kk . "_" . $qq)
                                    <label class="form-check-label">
                                        Actual Answer : {{$act_ans["6_1"]}}
                                    </label>
                                </div>

                                <div style="background-color:green; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                    @if($stud_ans["6_1"] == $act_ans["6_1"])
                                    @php($markval = $eachmark[4])
                                    @else
                                    @php($markval = 0)
                                    @endif
                                    <label class="form-check-label">Correct Marks by Teacher :
                                        <input type="number" name="mark_{{$kk}}_{{$qq}}" id="mark_{{$kk}}_{{$qq}}" placeholder="Add Marks ..." value="{{$markval}}">
                                    </label>

                                </div>

                            @endif

                         </div>

                        @elseif($kk == 7)
                        <br>
                        <div class="form-group">

                            Q. No-{{$qq}}. <textarea class="text_box_note">{{$question[0]}}</textarea>

                            <div class="table-responsive">
                                <table width="100%">
                                    <tr>
                                        <td width="25%">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    (1) &nbsp;&nbsp;&nbsp; {{$question[1]}}
                                                </label>
                                            </div>
                                        </td>

                                        @if(isset($question[2]) && $question[2] != "")
                                        <td width="25%">

                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    (2) &nbsp;&nbsp;&nbsp; {{$question[2]}}
                                                </label>
                                            </div>

                                        </td>
                                        @endif

                                        @if(isset($question[3]) && $question[3] != "")
                                        <td width="25%">

                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    (3) &nbsp;&nbsp;&nbsp; {{$question[3]}}
                                                </label>
                                            </div>

                                        </td>
                                        @endif

                                        @if(isset($question[4]) && $question[4] != "")
                                        <td width="25%">

                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    (4) &nbsp;&nbsp;&nbsp; {{$question[4]}}
                                                </label>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        @if(isset($question[5]) && $question[5] != "")
                                        <td width="25%">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    (5) &nbsp;&nbsp;&nbsp; {{$question[5]}}
                                                </label>
                                            </div>
                                        </td>
                                        @endif

                                        @if(isset($question[6]) && $question[6] != "")
                                        <td width="25%">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    (6) &nbsp;&nbsp;&nbsp; {{$question[6]}}
                                                </label>
                                            </div>
                                        </td>
                                        @endif

                                        @if(isset($question[7]) && $question[7] != "")
                                        <td width="25%">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    (7) &nbsp;&nbsp;&nbsp; {{$question[7]}}
                                                </label>
                                            </div>
                                        </td>
                                        <td width="25%">

                                        </td>
                                        @endif
                                    </tr>
                                </table>

                                <div style="background-color:grey; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                    @php($arr2 = $kk . "_" . $qq)
                                    <label class="form-check-label">
                                        Student Answer : {{$stud_ans[$arr2]}}
                                    </label>
                                </div>


                                <div style="background-color:blue; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                    @php($arr2 = $kk . "_" . $qq)
                                    <label class="form-check-label">
                                        Actual Answer : {{$act_ans[$arr2]}}
                                    </label>
                                </div>

                                <div style="background-color:green; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                    @if($stud_ans[$arr2] == $act_ans[$arr2])
                                    @php($markval = $eachmark[7])
                                    @else
                                    @php($markval = 0)
                                    @endif
                                    <label class="form-check-label">Correct Marks by Teacher :
                                        <input type="number" name="mark_{{$kk}}_{{$qq}}" id="mark_{{$kk}}_{{$qq}}" placeholder="Add Marks ..." value="{{$markval}}">
                                    </label>
                                </div>

                            </div>

                        </div>

                        @elseif($kk == 8)
                        @php($temp++ )
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
                                    </tr>
                                @else
                                @endif
                            </table>

                            <br>

                            <div class="form-textarea form-check-inline" style="width:70%; background-color:grey; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                <label class="form-check-label">
                                    @php($arr2 = $kk . "_" . $temp)
                                    Student Answer : {{$stud_ans[$arr2]}}
                                </label>
                            </div>

                            <div style="width:70%; background-color:blue; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                <label class="form-check-label">
                                    @php($arr2 = $kk . "_" . $temp)
                                    Actual Answer : {{$act_ans[$arr2]}}
                                </label>
                            </div>

                            <div style="width:70%; background-color:green; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                @php($arr2 = $kk . "_" . $temp)
                                @if($stud_ans[$arr2] == $act_ans[$arr2])
                                    @php($markval = $eachmark[$kk])
                                @else
                                    @php($markval = 0)
                                @endif
                                <label class="form-check-label">Correct Marks by Teacher :
                                    <input type="number" name="mark_{{$kk}}_{{$qq}}" id="mark_{{$kk}}_{{$qq}}" placeholder="Add Marks ..." value="{{$markval}}">
                                </label>
                            </div>

                        </div>

                        @elseif($kk == 10)

                        <div class="form-group">

                            <table id="table10" cellspacing="5" cellpadding="5" border="1" width="90%">
                                @foreach($question as $qqq => $q10hd)
                                    @php($q10Head = explode("~~~~~",$q10hd))
                                    <tr>
                                        <td width="12%" align="center">
                                        Q. No - {{ $qqq }})
                                        </td>
                                        <td align="center">
                                            <label class="form-check-label"> {{$q10Head[0]}} </label>
                                        </td>
                                        <td align="center">
                                            <label class="form-check-label"> {{$q10Head[1]}} </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <div style="background-color:grey; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                                <label class="form-check-label">
                                                    @php($arr3 = $kk . "_" . $qqq . "-left")
                                                    Student Answer : {{$stud_ans[$arr3]}}
                                                </label>
                                            </div>

                                            <div style="background-color:blue; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                                <label class="form-check-label">
                                                    @php($arr3 = $kk . "_" . $qqq . "-left")
                                                    Actual Answer : {{$act_ans[$arr3]}}
                                                </label>
                                            </div>

                                            <div style="background-color:green; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                                @php($arr3 = $kk . "_" . $qqq . "-left")
                                                @if($stud_ans[$arr3] == $act_ans[$arr3])
                                                    @php($markval = $eachmark[$kk])
                                                @else
                                                    @php($markval = 0)
                                                @endif
                                                <label class="form-check-label">Correct Marks by Teacher :
                                                    <input type="number" name="mark_{{$arr3}}" id="mark_{{$arr3}}" placeholder="Add Marks ..." value="{{$markval}}">
                                                </label>
                                            </div>
                                        </td>

                                        <td>
                                            <div style="background-color:grey; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                                <label class="form-check-label">
                                                    @php($arr3 = $kk . "_" . $qqq . "-right")
                                                    Student Answer : {{$stud_ans[$arr3]}}
                                                </label>
                                            </div>

                                            <div style="background-color:blue; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                                <label class="form-check-label">
                                                    @php($arr3 = $kk . "_" . $qqq . "-right")
                                                    Actual Answer : {{$act_ans[$arr3]}}
                                                </label>
                                            </div>

                                            <div style="background-color:green; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                                @php($arr3 = $kk . "_" . $qqq . "-right")
                                                @if($stud_ans[$arr3] == $act_ans[$arr3])
                                                    @php($markval = $eachmark[$kk])
                                                @else
                                                    @php($markval = 0)
                                                @endif
                                                <label class="form-check-label">Correct Marks by Teacher :
                                                    <input type="number" name="mark_{{$arr3}}" id="mark_{{$arr3}}" placeholder="Add Marks ..." value="{{$markval}}">
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>

                            <br>



                        </div>



                        @else
                        <br>
                        Q. No-{{$qq}}. &nbsp;&nbsp; <label class="form-check-label"> {{$question}} </label>
                        <br>
                        <div style="background-color:grey; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                            <label class="form-check-label">
                                @php($arr2 = $kk . "_" . $qq)
                                Student Answer : {{$stud_ans[$arr2]}}
                            </label>
                        </div>

                        <div style="background-color:blue; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                            <label class="form-check-label">
                                @php($arr2 = $kk . "_" . $qq)
                                Actual Answer : {{$act_ans[$arr2]}}
                            </label>
                        </div>

                        <div style="background-color:green; margin-left:15px;">&nbsp;&nbsp;&nbsp;&nbsp;
                            @if($stud_ans[$arr2] == $act_ans[$arr2])
                                @php($markval = $eachmark[$kk])
                            @else
                                @php($markval = 0)
                            @endif
                            <label class="form-check-label">Correct Marks by Teacher :
                                <input type="number" name="mark_{{$kk}}_{{$qq}}" id="mark_{{$kk}}_{{$qq}}" placeholder="Add Marks ..." value="{{$markval}}">
                            </label>
                        </div>


                        @endif

                        @endforeach
                    </div>

            </div>

            @endforeach

            <button type="submit" class="btn btn-primary">Submit Answers</button>

        <div class="form-group" style="margin-top:30px;text-align:center;">
            <input type="button" value="Back" onClick="javascript:history.go(-1);">
        </div>

        </div>

        </form>

    </div>
</div>

@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
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
</script>
@endpush
