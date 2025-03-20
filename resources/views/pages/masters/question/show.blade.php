@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
    <style type="text/css">
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
    .note-toolbar {
        display:none;
    }

</style>
@endpush

@php
    $arr = json_decode($question->question_template,true);
    ksort($arr);
    //echo "<pre>";
    //print_r($qnMasTitle);
    //print_r($qns2);
    //print_r($question);
    //print_r($qns2[10]);
    //echo "</pre>";
    //exit;
@endphp

@php($alpha = array(1=>"A",2=>"B",3=>"C",4=>"D",5=>"E",6=>"F",7=>"G",8=>"H",9=>"I",10=>"J",11=>"K",12=>"L",13=>"M",14=>"N",15=>"N"))
@php($temp=1)

@section('content')

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('question/index') }}">Question Master</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="#">View Question Master Template</a></li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card"`>
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">
            Question Master Template View
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif
        </h4>

        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            @if(!empty($question))

                <tr>
                    <td>ID</td><td>:</td><td>{{$question->id}}</td>
                </tr>
                <tr>
                    <td>Title</td><td>:</td><td>{{$question->title}}</td>
                </tr>
                <tr>
                    <td>Class</td><td>:</td><td>Grade-{{$question->class_id}}</td>
                </tr>
                <tr>
                    <td>Subject</td><td>:</td><td>{{$question->subject_id}}</td>
                </tr>
                <tr>
                    <td>Chapter Name</td><td>:</td><td>{{$question->chapter_id}}</td>
                </tr>
            </table>
                <br><br>
            <table cellpadding="10px" cellspacing="10px">
                <tr><td colspan="3" align="center">Question Template View :</td></tr>
                <tr><th>Question Type</th><th>No. of Questions</th><th>Each Marks</th><th>Total</th></tr>
                @php($aa=0)
                @php($totMark=0)
                @foreach($arr as $kk => $arr2)
                    <tr>
                        <td>
                            @php($aa++)
                            {{ $romLet[$aa] }}) &nbsp;&nbsp;  {{ $qnMasTitle[$kk] }}
                        </td>
                        <td>
                            {{ $arr2[0] }}
                        </td>
                        <td>
                            {{ $arr2[1] }}
                        </td>
                        <td>
                            @php($mark = $arr2[0] * $arr2[1])
                            {{ $mark }}
                            @php($totMark = $totMark + $mark)
                        </td>
                    </tr>
                @endforeach
                <tr><th></th><th></th><th>Total Marks</th><th>{{ $totMark }}</th></tr>
          </table>
          @endif
        </div>
      </div>



    @php($tt=0)

    @if(isset($qns2))

    @php($count=0)

    <div class="card-body">

    <div class="form-group">

    @foreach($qns2 as $kk => $quest)

        @php($count++)

        <br>
        <label style="color:yellow;"><h5>{{$romLet[$count]}}. {{$qnMasTitle[$kk]}}</h5></label>
        <br>

          @foreach($quest as $qq => $question)

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
                            <table id="table2" cellspacing="10" cellpadding="10" border="1" width="100%">
                                @foreach($question[0]['B'] as $bb => $cols)
                                <tr><td width="10%">{{ $alpha[$bb+1] }}</td><td>{{ $cols }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                </table>
                <br>

            </div>

            @elseif($kk == 4)

            Q. No-{{$qq}}. &nbsp;&nbsp; <label class="form-check-label"> {{$question}} </label>

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
                    Q. No-{{$qq}}. <textarea class="text_box_note" id="summernote5{{$qq}}">{{$question}}</textarea>
                    <br>
                </div>


            @elseif($kk == 6)

                @if($qq == "qns")
                    Que. &nbsp;&nbsp; <label class="form-check-label"> {{$quest['qns']}} </label>
                @endif

                @if($qq == "ReOrds")
                    @foreach($quest['ReOrds'] as $reord)

                    <div class="form-text form-check" style="margin-left:100px;">
                        <p style="white-space: pre-wrap">{{ $reord }}</p>
                    </div>

                    @endforeach
                @endif


              @elseif($kk == 7)

              @php($tt = "mcqimg7_".$qq)

              <div class="form-group">

              <label class="form-check-label"> Q. No-{{$qq}}. &nbsp;&nbsp; </label>
                <textarea class="text_box_note" id="summernote7{{$qq}}">{{$question[0]}}</textarea>
                <br>
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
            </div>


            @elseif($kk == 10)

                @if($temp == 1)

                    @php($temp++)

                    <div class="form-group">

                        <table id="table10" cellspacing="5" cellpadding="5" border="1" width="90%">
                            @foreach($qns2[10] as $qqq => $q10hd)
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
                            @endforeach
                        </table>

                    </div>

                    <br>

                @endif

            @else

            <div class="form-group">
                Q. No-{{$qq}}. &nbsp;&nbsp; <label class="form-check-label"> {{$question}} </label>
            </div>

            @endif

        @endforeach

    @endforeach

@endif

</div>

    </div>
        <input type=button value="Back" onClick="javascript:history.go(-1);">
    </div>

</div>

</div>

</div>

</div>

@endsection

@push('plugin-scripts')
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/data-table.js') }}"></script>

<script>

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

    });

</script>

@endpush
