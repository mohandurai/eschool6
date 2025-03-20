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
    right: 50px;
    font-size: 30px;
    color:blue;
}
</style>
@endpush

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
      <p class="fixed-element" id="timer"></p>
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


          <div class="form-group">

           @php($count++)

          <label><h5>{{$romlet[$count]}}. {{$qh}}</h5></label></br>

          @foreach($qns[$kk] as $qq => $question)

            @if($kk == 4)

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

            @elseif($kk == 7)

              <div class="form-group">
                Q. No-{{$qq}}. &nbsp;&nbsp;

                <label class="form-check-label"> {{$question[0]}} </label>

                <div class="form-check form-check-inline">
                    @if($question[1] != null)
                        <label class="form-check-label"> (1) &nbsp;&nbsp;&nbsp; {{$question[1]}} </label>
                    @endif
                </div>

                <div class="form-check form-check-inline">
                    @if($question[2] != null)
                        <label class="form-check-label"> (2) &nbsp;&nbsp;&nbsp; {{$question[2]}} </label>
                    @endif
                </div>

                <div class="form-check form-check-inline">
                    @if($question[3] != null)
                        <label class="form-check-label"> (3) &nbsp;&nbsp;&nbsp; {{$question[3]}} </label>
                    @endif
                </div>

                <div class="form-check form-check-inline">
                    @if($question[4] != null)
                        <label class="form-check-label"> (4) &nbsp;&nbsp;&nbsp; {{$question[4]}} </label>
                    @endif
                </div>

                <div class="form-check form-check-inline">
                    @if($question[5] != null)
                        <label class="form-check-label"> (5) &nbsp;&nbsp;&nbsp; {{$question[5]}} </label>
                    @endif
                </div>

                <div class="form-check form-check-inline">
                    @if($question[6] != null)
                        <label class="form-check-label"> (6) &nbsp;&nbsp;&nbsp; {{$question[6]}} </label>
                    @endif
                </div>

                <br>

                <div class="form-text form-check-inline">
                    <input type="text" placeholder="Type correct choice by 1,2,3..." class="form-control" name="{{$kk}}_{{$qq}}" id="{{$kk}}_{{$qq}}" value="">
                </div>

            </div>

            @elseif($kk == 9)

              @php($tt = "mcqimg9_".$qq)

                    <div class="form-group">
                        Q. No-{{$qq}}. &nbsp;&nbsp;

                        @if(isset($imgQuens[$tt][0]))
                            <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][0]) }}" height="150em" width="200em" alt="" title="" />
                            <br>
                        @endif

                        <div class="form-check form-check-inline">
                            @if(isset($imgQuens[$tt][1]))
                            (1) &nbsp;&nbsp;&nbsp; <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][1]) }}" height="100em" width="150em" alt="" title="" />
                            @endif
                        </div>

                        <div class="form-check form-check-inline">
                            @if(isset($imgQuens[$tt][2]))
                            (2) &nbsp;&nbsp;&nbsp; <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][2]) }}" height="100em" width="150em" alt="" title="" />
                            @endif
                        </div>

                        <div class="form-check form-check-inline">
                            @if(isset($imgQuens[$tt][3]))
                            (3) &nbsp;&nbsp;&nbsp; <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][3]) }}" height="100em" width="150em" alt="" title="" />
                            @endif
                        </div>

                        <div class="form-check form-check-inline">
                            @if(isset($imgQuens[$tt][4]))
                            (4) &nbsp;&nbsp;&nbsp; <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][4]) }}" height="100em" width="150em" alt="" title="" />
                            @endif
                        </div>

                        <div class="form-check form-check-inline">
                            @if(isset($imgQuens[$tt][5]))
                            (5) &nbsp;&nbsp;&nbsp; <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][5]) }}" height="100em" width="150em" alt="" title="" />
                            @endif
                        </div>

                        <div class="form-check form-check-inline">
                            @if(isset($imgQuens[$tt][6]))
                            (6) &nbsp;&nbsp;&nbsp; <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][6]) }}" height="100em" width="150em" alt="" title="" />
                            @endif
                        </div>

                        <br>

                        <div class="form-text form-check-inline">
                            <input type="text" placeholder="Type correct choice by 1,2,3..." class="form-control" name="{{$kk}}_{{$qq}}" id="{{$kk}}_{{$qq}}" value="">
                        </div>

                    </div>


            @else

                Q. No-{{$qq}}. &nbsp;&nbsp; <label class="form-check-label"> {{$question}} </label>
                <br>
                <input type="text" name="{{$kk}}_{{$qq}}" style="background-color:#silver;" class="form-control" id="{{$kk}}_{{$qq}}" value="" placeholder="Type Answer for Qn. {{$qq}}">
                <br><br>
            @endif

            @endforeach
          </div>

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
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
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

$(document).ready(function() {
    $("#class_id option[value=0]").prop('selected', true);
    $("#subject_id option[value=0]").prop('selected', true);
    $("#chapter_id option[value=0]").prop('selected', true);
    $("#mode_test option[value=0]").prop('selected', true);
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
                // console.log(data2);
                $('#chapter_id').append(data2);
                // $(".table-responsive").html(data);
            }
        });

    });

</script>
@endpush

