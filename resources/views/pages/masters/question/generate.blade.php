@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
<style type="text/css">
    .mgn10px {
        margin-left: 10px;
        }
    .note-editable {
        padding: 1px;
        border: solid 1px #5c8593;
        font-size: 10pt;
        color:#42484d;
        background-color:#FFFFFF !important;
    }
</style>
@endpush

@php
    //echo "<pre>";
    //print_r($qns);
    //print_r($ans);
    //echo "</pre>";
    //exit;
@endphp

@section('content')

@php($alpha = array(0=>"A",1=>"B",2=>"C",3=>"D",4=>"E",5=>"F",6=>"G",7=>"H",8=>"I",9=>"J",10=>"K",11=>"L",12=>"M",13=>"N",14=>"N"))

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('question/index') }}">Masters</a></li>
    <li class="breadcrumb-item active" aria-current="page">Generate Questions</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
    <h4>Fill up the Questions with Answer Key</h4>

    @php($count=0)

    @foreach($qhead as $kk => $qh)
      <div class="card-body">

      <form name="form2" action="{{ url('question/storeqns') }}" method="post" enctype="multipart/form-data">
        @csrf

          <div class="form-group">

          <input type="hidden" name="qn_temp_id" value="{{ request('id') }}">

          @php($count++)

          <label style="color:yellow;"><h5>{{$romlet[$count]}}. {{$qh}}</h5></label>


          @for($qq=1; $qq <= $qncnt[$kk]; $qq++)

          @if($kk == 3)
            <input type="hidden" class="form-control" name="que_{{$kk}}_X" value="">
                <div class="form-group">

                    <table width="80%" cellspacing="5" cellpadding="5" border="1">
                        <tr align="center" style="background-color:yellow;color:black;">
                            <td width="50%">Column A</td>
                            <td width="80%">Column B</td>
                        </tr>
                        <tr>
                            <td width="30%">
                                <table cellspacing="10" cellpadding="10" border="1" width="100%">
                                    @for($match3=0; $match3 < $qn3matchfollow; $match3++)
                                        <tr>
                                            <td>{{ $match3 }})</td>
                                            <td>
                                                <input type="text" class="form-control" name="A_{{$kk}}_{{$match3}}" id="A_{{$kk}}_{{$match3}}" value="{{ $qns['3_0']['A'][$match3] }}" placeholder="Enter Matching No. {{$match3}}">
                                            </td>
                                        </tr>
                                    @endfor
                                </table>

                            </td>
                            <td width="70%">
                                <table id="table2" cellspacing="10" cellpadding="10" border="1" width="100%">
                                    @for($match3=0; $match3 < $qn3matchfollow; $match3++)
                                    <tr><td width="10%">{{ $alpha[$match3] }}</td>
                                        <td>
                                            <input type="text" class="form-control" name="B_{{$kk}}_{{$match3}}" id="B_{{$kk}}_{{$match3}}" value="{{ $qns['3_0']['B'][$match3] }}" placeholder="Enter Matching No. {{$match3}}">
                                        </td>
                                    </tr>
                                    @endfor
                                </table>
                            </td>
                        </tr>
                    </table>

                    <br>
                    <div class="form-text form-check-inline">Answer Key : <input type="text" name="3_1" style="background-color:#silver;" class="form-control" id="3_1" placeholder="Type Answer for Matching columns - Ex. 1-A, 2-B ..... etc">
                    <br>
                    </div>

                </div>

            @elseif($kk == 4)

              <div class="form-group">
              {{ $qq }}) &nbsp;&nbsp;&nbsp;
              @php($aaa = $kk . "_" . $qq)
              @if(isset($qns[$aaa]))
              <input type="text" class="form-control" value="{{ $qns[$aaa] }}" name="que_{{$kk}}_{{$qq}}" id="que_{{$kk}}_{{$qq}}" value="" placeholder="Enter Question No. {{$qq}}">
              @else
              <input type="text" class="form-control" name="que_{{$kk}}_{{$qq}}" id="que_{{$kk}}_{{$qq}}" value="" placeholder="Enter Question No. {{$qq}}">
              @endif
              </div>
              <div class="form-group">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="{{$kk}}_{{$qq}}" id="{{$kk}}_{{$qq}}" value="true">
                            True
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="{{$kk}}_{{$qq}}" id="{{$kk}}_{{$qq}}" value="false">
                            False
                        </label>
                    </div>
              </div>

            @elseif($kk == 5)

                <div class="form-group">
                <label> {{ $qq }}) &nbsp;&nbsp;&nbsp; </label>
                @php($aaa = $kk . "_" . $qq)
                @if(isset($qns[$aaa]))
                    <textarea id="summernote5{{$qq}}" name="que_{{$kk}}_{{$qq}}">{{ $qns[$aaa] }}</textarea>
                @else
                    <textarea id="summernote5{{$qq}}" value="" name="que_{{$kk}}_{{$qq}}"><br></textarea>
                @endif
                <input type="text" name="{{$kk}}_{{$qq}}"  class="form-control" id="{{$kk}}_{{$qq}}" value="" placeholder="Type Answer for Qn. {{$qq}}">
                </div>


            @elseif($kk == 6)

              <div class="form-group">

                @php($aaa = $kk . "_" . $qq)
                @if(isset($qns[$aaa]))
                    <input type="text" class="form-control" name="que_6_1" id="que_{{$kk}}_{{$qq}}" value="{{ $qns[$aaa] }}" placeholder="Enter Question No. {{$qq}}"><br>
                @else
                    <input type="text" class="form-control" name="que_6_1" id="que_{{$kk}}_{{$qq}}" value="" placeholder="Enter Question No. {{$qq}}"><br>
                @endif

                <div id="row" class="form-check">
                </div>

                <div id="newinput"></div>
                <button id="rowAdder" type="button" class="btn btn-dark">
                    <span class="bi bi-plus-square-dotted">
                    </span>ADD
                </button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" id="apply-rows" value="Apply Rows">

                <br><br>

                <input type="hidden" id="key6-1" name="ReOrd_6-1">
                <input type="hidden" id="key6-2" name="ReOrd_6-2">
                <input type="hidden" id="key6-3" name="ReOrd_6-3">
                <input type="hidden" id="key6-4" name="ReOrd_6-4">
                <input type="hidden" id="key6-5" name="ReOrd_6-5">
                <input type="hidden" id="key6-6" name="ReOrd_6-6">
                <input type="hidden" id="key6-7" name="ReOrd_6-7">
                <input type="hidden" id="key6-8" name="ReOrd_6-8">
                <input type="hidden" id="key6-9" name="ReOrd_6-9">
                <input type="hidden" id="key6-10" name="ReOrd_6-10">
                <input type="hidden" id="key6-11" name="ReOrd_6-11">
                <input type="hidden" id="key6-12" name="ReOrd_6-12">
                <input type="hidden" id="key6-13" name="ReOrd_6-13">
                <input type="hidden" id="key6-14" name="ReOrd_6-14">
                <input type="hidden" id="key6-15" name="ReOrd_6-15">

                <div class="form-text form-check-inline">Answer Key :
                    @if(isset($ans['6_1']))
                        <input type="text" placeholder="Answer by 1, 2, 3 " value="{{ $ans['6_1'] }}" class="form-control" name="{{$kk}}_{{$qq}}" id="{{$kk}}_{{$qq}}">
                    @else
                        <input type="text" placeholder="Answer by 1, 2, 3 " value="" class="form-control" name="{{$kk}}_{{$qq}}" id="{{$kk}}_{{$qq}}">
                    @endif
                </div>

            </div>


            @elseif($kk == 7)

              <br>{{ $qq }}) &nbsp;&nbsp;&nbsp;

              @php($aaa = $kk . "_" . $qq)
              @if(isset($qns[$aaa]))
              @php($optns = explode("~~~~~", $qns[$aaa]))
                <textarea class="form-control" id="summernote7{{$qq}}" name="que_{{$kk}}_{{$qq}}">{{$optns[0]}}</textarea>
              @else
                <textarea class="form-control" id="summernote7{{$qq}}" name="que_{{$kk}}_{{$qq}}"><br></textarea>
              @endif

              <input type="file" name="mcqimg7_{{$qq}}[0]" placeholder="Attach Image if need...." class="form-control" accept=".gif,.jpg,.png,.ppt,.pptx,.jpeg,.bmp,.tiff">
              <div class="form-group">
                    <div class="form-text form-check-inline">
                        @if(isset($optns[1]))
                            <input type="text" placeholder="Type Choice 1" class="form-control" name="ops_{{$kk}}_{{$qq}}a" id="{{$kk}}_{{$qq}}_a" value="{{ $optns[1] }}">
                        @else
                            <input type="text" placeholder="Type Choice 1" class="form-control" name="ops_{{$kk}}_{{$qq}}a" id="{{$kk}}_{{$qq}}_a" value=" ">
                        @endif
                        <input type="file" name="mcqimg7_{{$qq}}[1]" placeholder="Attach Image if need...." class="form-control" accept=".gif,.jpg,.png,.ppt,.pptx,.jpeg,.bmp,.tiff">
                    </div>

                    <div class="form-text form-check-inline">
                        @if(isset($optns[2]))
                            <input type="text" placeholder="Type Choice 2" class="form-control" name="ops_{{$kk}}_{{$qq}}b" id="{{$kk}}_{{$qq}}_b" value="{{ $optns[2] }}">
                        @else
                            <input type="text" placeholder="Type Choice 2" class="form-control" name="ops_{{$kk}}_{{$qq}}b" id="{{$kk}}_{{$qq}}_b" value="">
                        @endif
                        <input type="file" name="mcqimg7_{{$qq}}[2]" placeholder="Attach Image if need...." class="form-control" accept=".gif,.jpg,.png,.ppt,.pptx,.jpeg,.bmp,.tiff">
                    </div>
                    <div class="form-text form-check-inline">
                        @if(isset($optns[3]))
                            <input type="text" placeholder="Type Choice 3" class="form-control" name="ops_{{$kk}}_{{$qq}}c" id="{{$kk}}_{{$qq}}_c" value="{{ $optns[3] }}">
                        @else
                            <input type="text" placeholder="Type Choice 3" class="form-control" name="ops_{{$kk}}_{{$qq}}c" id="{{$kk}}_{{$qq}}_c" value=" ">
                        @endif
                        <input type="file" name="mcqimg7_{{$qq}}[3]" placeholder="Attach Image if need...." class="form-control" accept=".gif,.jpg,.png,.ppt,.pptx,.jpeg,.bmp,.tiff">
                    </div>
                    <div class="form-text form-check-inline">
                        @if(isset($optns[4]))
                            <input type="text" placeholder="Type Choice 4" class="form-control" name="ops_{{$kk}}_{{$qq}}d" id="{{$kk}}_{{$qq}}_d" value="{{ $optns[4] }}">
                        @else
                            <input type="text" placeholder="Type Choice 4" class="form-control" name="ops_{{$kk}}_{{$qq}}d" id="{{$kk}}_{{$qq}}_d" value=" ">
                        @endif
                        <input type="file" name="mcqimg7_{{$qq}}[4]" placeholder="Attach Image if need...." class="form-control" accept=".gif,.jpg,.png,.ppt,.pptx,.jpeg,.bmp,.tiff">
                    </div>
                    <div class="form-text form-check-inline">
                        @if(isset($optns[5]))
                            <input type="text" placeholder="Type Choice 5" class="form-control" name="ops_{{$kk}}_{{$qq}}e" id="{{$kk}}_{{$qq}}_e" value="{{ $optns[5] }}">
                        @else
                            <input type="text" placeholder="Type Choice 5" class="form-control" name="ops_{{$kk}}_{{$qq}}e" id="{{$kk}}_{{$qq}}_e" value=" ">
                        @endif
                        <input type="file" name="mcqimg7_{{$qq}}[5]" placeholder="Attach Image if need...." class="form-control" accept=".gif,.jpg,.png,.ppt,.pptx,.jpeg,.bmp,.tiff">
                    </div>
                    <div class="form-text form-check-inline">
                        @if(isset($optns[6]))
                            <input type="text" placeholder="Type Choice 6" class="form-control" name="ops_{{$kk}}_{{$qq}}f" id="{{$kk}}_{{$qq}}_f" value="{{ $optns[6] }}">
                        @else
                            <input type="text" placeholder="Type Choice 6" class="form-control" name="ops_{{$kk}}_{{$qq}}f" id="{{$kk}}_{{$qq}}_f" value=" ">
                        @endif
                        <input type="file" name="mcqimg7_{{$qq}}[6]" placeholder="Attach Image if need...." class="form-control" accept=".gif,.jpg,.png,.ppt,.pptx,.jpeg,.bmp,.tiff">
                    </div> <br><br>
                    <div class="form-text form-check-inline">Answer Key :
                        @if(isset($ans[$aaa]))
                            <input type="text" placeholder="Type Answer key by 1,2,3... ?"  class="form-control" name="{{$kk}}_{{$qq}}" id="{{$kk}}_{{$qq}}" value="{{ $ans[$aaa] }}">
                        @else
                            <input type="text" placeholder="Type Answer key by 1,2,3... ?"  class="form-control" name="{{$kk}}_{{$qq}}" id="{{$kk}}_{{$qq}}" value=" ">
                        @endif
                    </div>
              </div>

              @elseif($kk == 8)

                <div class="form-group">
                <br>{{ $qq }}) &nbsp;&nbsp;&nbsp;

                    <div class="form-textarea form-check-inline" style="white-space: nowrap;">
                        <label for="exampleFormControlTextarea1">Add Jumbled Word</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        @php($aaa = $kk . "_" . $qq . "-left")
                        @php($bbb = $kk . "_" . $qq)
                        @if(isset($qns[$aaa]))
                            <input class="form-control" value="{{ $qns[$aaa] }}" name="que_{{$kk}}_{{$qq}}-left" id="que_{{$kk}}_{{$qq}}-left"></input>
                        @else
                            <input class="form-control" value=" " name="que_{{$kk}}_{{$qq}}-left" id="que_{{$kk}}_{{$qq}}-left"></input>
                        @endif
                    </div>

                    <div class="form-text form-check-inline" style="margin-left:30px; white-space: nowrap;">
                        <label class="form-check-label">Add Answer Key Word</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            @if(isset($ans[$bbb]))
                                <input class="form-control" value="{{ $ans[$bbb] }}" name="{{$kk}}_{{$qq}}" id="{{$kk}}_{{$qq}}"></input>
                            @else
                                <input class="form-control" name="{{$kk}}_{{$qq}}" id="{{$kk}}_{{$qq}}"></input>
                            @endif
                        </label>
                    </div>

                </div>

              @elseif($kk == 10)

                <div class="form-group">
                {{ $qq }} &nbsp;&nbsp;&nbsp;

                <div class="form-textarea form-check-inline">
                    <label for="exampleFormControlTextarea1">Add LHS Words</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        @if(isset($qns["10_0"]["Qleft_10"][$qq]))
                            <input type="text" class="form-control" name="que_{{$kk}}_{{$qq}}-left" id="que_{{$kk}}_{{$qq}}-left" value="{{ $qns['10_0']['Qleft_10'][$qq] }}" placeholder="Enter Question of LHS">
                        @else
                            <input type="text" class="form-control" name="que_{{$kk}}_{{$qq}}-left" id="que_{{$kk}}_{{$qq}}-left" value="" placeholder="Enter Question of LHS">
                        @endif
                    </label>
                </div>

                <div class="form-textarea form-check-inline">
                    <label for="exampleFormControlTextarea1">Add RHS Words</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @if(isset($qns["10_0"]["Qright_10"][$qq]))
                        <input type="text" class="form-control" name="que_{{$kk}}_{{$qq}}-right" id="que_{{$kk}}_{{$qq}}-right" value="{{ $qns['10_0']['Qright_10'][$qq] }}" placeholder="Enter Question of RHS">
                    @else
                        <input type="text" class="form-control" name="que_{{$kk}}_{{$qq}}-right" id="que_{{$kk}}_{{$qq}}-right" value="" placeholder="Enter Question of RHS">
                    @endif
                </div>

                @php($aaa = $kk . "_" . $qq . "-left")
                @php($bbb = $kk . "_" . $qq . "-right")

                <div class="form-text form-check-inline" style="margin-left:30px;">
                    <label class="form-check-label">Answer for LHS Words</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @if(isset($ans[$aaa]))
                        <textarea class="form-control" name="{{$kk}}_{{$qq}}-left" id="{{$kk}}_{{$qq}}-left" rows="5" cols="30">{{ $ans[$aaa] }}</textarea>
                    @else
                        <textarea class="form-control" name="{{$kk}}_{{$qq}}-left" id="{{$kk}}_{{$qq}}-left" rows="5" cols="30"></textarea>
                    @endif
                    </label>
                </div>

                <div class="form-text form-check-inline" style="margin-left:30px;">
                    <label class="form-check-label">Answer for RHS Words</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @if(isset($ans[$bbb]))
                        <textarea class="form-control" name="{{$kk}}_{{$qq}}-right" id="{{$kk}}_{{$qq}}-right" rows="5" cols="30">{{ $ans[$bbb] }}</textarea>
                    @else
                        <textarea class="form-control" name="{{$kk}}_{{$qq}}-right" id="{{$kk}}_{{$qq}}-right" rows="5" cols="30"></textarea>
                    @endif
                    </label>
                </div>

                </div>


            @else
              <div class="form-group">
                  <label> {{ $qq }}) &nbsp;&nbsp;&nbsp; </label>
                  @php($aaa = $kk . "_" . $qq)
                  @if(isset($qns[$aaa]))
                  <input type="text" class="form-control" name="que_{{$kk}}_{{$qq}}" id="que_{{$kk}}_{{$qq}}" value="{{$qns[$aaa]}}" placeholder="Enter Question No. {{$qq}}">
                  @else
                  <input type="text" class="form-control" name="que_{{$kk}}_{{$qq}}" id="que_{{$kk}}_{{$qq}}" value="" placeholder="Enter Question No. {{$qq}}">
                  @endif
                  <br>
                  @php($aaa = $kk . "_" . $qq)
                  @if(isset($ans[$aaa]))
                    <input type="text" name="{{$kk}}_{{$qq}}"  class="form-control" id="{{$kk}}_{{$qq}}" value="{{$ans[$aaa]}}" placeholder="Type Answer for Qn. {{$qq}}">
                  @else
                    <input type="text" name="{{$kk}}_{{$qq}}"  class="form-control" id="{{$kk}}_{{$qq}}" value="" placeholder="Type Answer for Qn. {{$qq}}">
                  @endif
               </div>
            @endif

           @endfor

          </div>

      </div>

    @endforeach

        <input style="margin-bottom:20px;" type=button value="Back" onClick="javascript:history.go(-1);">
      <br>
            <button type="submit" class="btn btn-primary">Save All Questions</button>
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

<script>



$(document).ready(function() {

    // $("#table-1").tableDnD();

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


    $('#match-apply').click(function(){
        // alert("UUUUUUUUUUUUUU");
        var ans3 = "";
        $("#table2 tr").each(function(i) {
            // find the first td in the row
            var value = $(this).find("td:first").text();
            // display the value in console
            ans3 = ans3 + ',' + value;
        });
        alert(ans3.substring(1));
        $('#ans-3qns').val(ans3.substring(1));
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
});


    var jj = 0;
    $(document).on("click", "#rowAdder", function () {
        jj++;
        newRowAdd = '<div id="row" class="form-check"><span class="form-check-inline"><input type="text" name="ReOrd-'+ jj +'" size="800" id="ReOrd-'+ jj + '" class="form-control" id="{{$kk}}_{{$qq}}" value="" placeholder="Enter Sentence ..."><a class="btn btn-danger" id="DeleteRow"><i class="fas fa-trash"></i></a></span></div>';

        $('#newinput').append(newRowAdd);
        // form2.appendChild(newRowAdd);

    })

    $("body").on("click", "#DeleteRow", function () {
        $(this).parents("#row").remove();
    })

    $("body").on("click", "#apply-rows", function () {

        var kk=0;
        var key6text = "";
        $('*[id*=ReOrd-]:visible').each(function() {
            kk++;
            key6text = ($(this).val());
            // alert(key6text);
            $("#key6-"+kk).val(key6text);
        });
        return false;
    })


    $("input[type='radio']#mcqtype9a").change(function() {
        var mcqtype = $("#mcqtype9a:checked").val();
        alert(mcqtype);
        if(mcqtype == 1) {
            $('.mcatype9text').show();
            $('.mcatype9img').hide();
        }
        else if(mcqtype == 2) {
            $('.mcatype9img').show();
            $('.mcatype9text').hide();
        }
    });


    $("input:checkbox.qntemplate").click(function() {
        var seltemp1 = "#qntemplate"+$(this).val()+"order";
        var seltemp2 = "#qntemplate"+$(this).val()+"noqns";
        var seltemp3 = "#qntemplate"+$(this).val()+"markque";
        // return false;
        if(!$(this).is(":checked")) {
            $(seltemp1).prop( "disabled", true );
            $(seltemp1).val('0');
            $(seltemp2).prop( "disabled", true );
            $(seltemp2).val('0');
            $(seltemp3).prop( "disabled", true );
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

    $('#subject_id').change(function() {
        // alert("TTTTTTTTTTTT"); return false;
        $('#chapter_id').html('');
        $("#chapter_id option[value=0]").prop('selected', true);

        var subid = $(this).val();
        var clsid = $("#class_id").val();

        $.ajax({
            type: 'GET',
            url: "{{ url('/getcontentchapt') }}/"+subid+"~~~"+clsid,
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

