@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<style type="text/css">
    .form-control {
        background-color: white;
    }
.table2 {
    cellspacing: 10px;
    cellpadding: 10px;
    color: yellow;
    font-size: 16px;
    margin-top: 10px;
}
</style>
@endpush

@section('content')

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">

        <table class="table2">
                <tr>
                    <td align="center">
                        <img src="{{ asset('assets/images/image3_horizon.png') }}" height="150em" width="200em" alt="" title="" />
                    <br><br>
                    </td>
                    <td>
                        <h3>Cannosa English Medium School</h3>
                        No. XXXX, Stree Name detailed, District Name - 600017
                        <br>Contact Details : 98406 12345
                        <br>Website  : www.eschool.com - email - admin@eschool.com<br>
                    </td>
                </tr>
        </table>

        <table align="center" width="80%" class="table2">
            <tr>
                <td style="text-align: right;">Roll No. : &nbsp;&nbsp;</td>
                <td style="text-align: left;">
                    {{ $stud_id }}
                </td>
                <td style="text-align: right;"> Class & Sec. : &nbsp;&nbsp;</td>
                <td>
                    Class 3 - Sec. B
                </td>
                <td style="text-align: right;">Student Name : &nbsp;&nbsp;</td>
                <td>
                    {{ $stud_name }}
                </td>
            </tr>
        </table>

        <table align="center" width="60%" class="table2">
            <tr>
                <td>Exam Name : </td>
                <td><h4>{{$examtitle2}}</h4></td>
            </tr>
        </table>

            @php($count=0)
            @foreach($qntit as $kk => $qh)

            <div class="card-body">

            <br><br>

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
                        @if($kk == 4)
                        Q. No-{{$qq}}. &nbsp;&nbsp; <label class="form-check-label"> {{$question}} </label>
                        <br>

                        <div class="form-group">

                            <div >&nbsp;&nbsp;&nbsp;&nbsp;
                                @php($arr2 = $kk . "_" . $qq)
                                <label class="form-check-label">
                                    Student Answer : {{$stud_ans[$arr2]}}
                                </label>
                            </div>

                            <div >&nbsp;&nbsp;&nbsp;&nbsp;
                                @php($arr2 = $kk . "_" . $qq)
                                <label class="form-check-label">
                                    Actual Answer : {{$act_ans[$arr2]}}
                                </label>
                            </div>

                            <div >&nbsp;&nbsp;&nbsp;&nbsp;
                                @if($stud_ans[$arr2] == $act_ans[$arr2])
                                @php($markval = $eachmark[4])
                                @else
                                @php($markval = 0)
                                @endif
                                <label class="form-check-label">Corrected Marks by Teacher :
                                    {{$markval}}
                                </label>

                            </div>

                        </div>

                        @elseif($kk == 7)
                        <br>
                        <div class="form-group">
                            Q. No-{{$qq}}. &nbsp;&nbsp;
                            <label class="form-check-label"> {{$question[0]}} </label>

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

                                <div >&nbsp;&nbsp;&nbsp;&nbsp;
                                    @php($arr2 = $kk . "_" . $qq)
                                    <label class="form-check-label">
                                        Student Answer : {{$stud_ans[$arr2]}}
                                    </label>
                                </div>


                                <div >&nbsp;&nbsp;&nbsp;&nbsp;
                                    @php($arr2 = $kk . "_" . $qq)
                                    <label class="form-check-label">
                                        Actual Answer : {{$act_ans[$arr2]}}
                                    </label>
                                </div>

                                <div >&nbsp;&nbsp;&nbsp;&nbsp;
                                    @if($stud_ans[$arr2] == $act_ans[$arr2])
                                    @php($markval = $eachmark[7])
                                    @else
                                    @php($markval = 0)
                                    @endif
                                    <label class="form-check-label">Corrected Marks by Teacher :
                                        {{$markval}}
                                    </label>
                                </div>

                            </div>

                        </div>


                        @else
                        <br>
                        Q. No-{{$qq}}. &nbsp;&nbsp; <label class="form-check-label"> {{$question}} </label>
                        <br>
                        <div >&nbsp;&nbsp;&nbsp;&nbsp;
                            <label class="form-check-label">
                                @php($arr2 = $kk . "_" . $qq)
                                Student Answer : {{$stud_ans[$arr2]}}
                            </label>
                        </div>

                        <div >&nbsp;&nbsp;&nbsp;&nbsp;
                            <label class="form-check-label">
                                @php($arr2 = $kk . "_" . $qq)
                                Actual Answer : {{$act_ans[$arr2]}}
                            </label>
                        </div>

                        <div >&nbsp;&nbsp;&nbsp;&nbsp;
                            @if($stud_ans[$arr2] == $act_ans[$arr2])
                            @php($markval = $eachmark[$kk])
                            @else
                            @php($markval = 0)
                            @endif
                            <label class="form-check-label">Corrected Marks by Teacher :
                                {{$markval}}
                            </label>
                        </div>


                        @endif

                        @endforeach
                    </div>

            @endforeach

            </div>

            <table>
                <tr>
                    <td width="10%" align="center">
                        <input type="button" value="Back" onClick="javascript:history.go(-1);">
                    </td>
                    <td width="60%" align="center">
                        <button type="submit" class="btn btn-primary">Export PDF</button>
                    </td>
                    <td width="60%" align="center">
                        <button type="submit" class="btn btn-primary">Send to Parent</button>
                    </td>
                </tr>
            </table>

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
    // $(document).ready(function() {
    //     $("#class_id option[value=0]").prop('selected', true);
    //     $("#subject_id option[value=0]").prop('selected', true);
    //     $("#chapter_id option[value=0]").prop('selected', true);
    //     $("#mode_test option[value=0]").prop('selected', true);
    // });


    //     $("input:checkbox.qntemplate").click(function() {
    //         var seltemp1 = "#qntemplate"+$(this).val()+"order";
    //         var seltemp2 = "#qntemplate"+$(this).val()+"noqns";
    //         var seltemp3 = "#qntemplate"+$(this).val()+"markque";
    //         // return false;
    //         if(!$(this).is(":checked")) {
    //             $(seltemp1).prop( "disabled", true );
    //             $(seltemp1).val('0');
    //             $(seltemp2).prop( "disabled", true );
    //             $(seltemp2).val('0');
    //             $(seltemp3).prop( "disabled", true );
    //             $(seltemp3).val('0');
    //         } else {
    //             // alert('you are checked ... ' + $(this).val());
    //             $(seltemp1).removeAttr('disabled');
    //             $(seltemp2).removeAttr('disabled');
    //             $(seltemp3).removeAttr('disabled');
    //         }

    //     });

    //     $('#class_id').change(function() {
    //         // alert("UUUUUUUUUUU"); return false;
    //         $('#subject_id').html('');
    //         $("#subject_id option[value=0]").prop('selected', true);

    //         var clsid = $(this).val();

    //         $.ajax({
    //             type: 'GET',
    //             url: "{{ url('/getcontentsubject') }}/"+clsid,
    //             // complete: function() {
    //             //     $('#psdatasourcSpinner').hide();
    //             // },
    //             success: function(data2) {
    //                 console.log(data2);
    //                 $('#subject_id').append(data2);
    //                 // $(".table-responsive").html(data);
    //             }
    //         });

    //     });

    //     $('#subject_id').change(function() {
    //         // alert("TTTTTTTTTTTT"); return false;
    //         $('#chapter_id').html('');
    //         $("#chapter_id option[value=0]").prop('selected', true);

    //         var subid = $(this).val();
    //         var clsid = $("#class_id").val();

    //         $.ajax({
    //             type: 'GET',
    //             url: "{{ url('/getcontentchapt') }}/"+subid+"~~~"+clsid,
    //             // complete: function() {
    //             //     $('#psdatasourcSpinner').hide();
    //             // },
    //             success: function(data2) {
    //                 console.log(data2);
    //                 $('#chapter_id').append(data2);
    //                 // $(".table-responsive").html(data);
    //             }
    //         });

    //     });
</script>
@endpush
