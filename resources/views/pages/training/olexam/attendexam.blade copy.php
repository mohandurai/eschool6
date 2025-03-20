@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<style type="text/css">
.form-control {
    background-color: white;
}
</style>
@endpush

@section('content')

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
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

      <form action="{{ url('olexam/saveexam') }}" method="post">
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

              @php($tt = "mcqimg7_".$qq)

        <div class="form-group">

              Q. No-{{$qq}}. &nbsp;&nbsp;
                    <label class="form-check-label"> {{$question[0]}} </label>
                @if(isset($imgQuens))
                    <div>
                        <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][0]) }}" height="100em" width="150em" alt="" title="" />
                    </div>
                @endif

                <div class="form-check form-check-inline">
                    <label class="form-check-label"> (1) &nbsp;&nbsp;&nbsp; {{$question[1]}} </label>
                    @if(isset($imgQuens[$tt][1]))
                        <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][1]) }}" height="100em" width="150em" alt="" title="" />
                    @endif
                </div>


                <div class="form-check form-check-inline">
                    <label class="form-check-label"> (2) &nbsp;&nbsp;&nbsp; {{$question[2]}} </label>
                        @if(isset($imgQuens[$tt][2]))
                            <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][2]) }}" height="100em" width="150em" alt="" title="" />
                        @endif
                </div>

                <div class="form-check form-check-inline">
                    <label class="form-check-label"> (3) &nbsp;&nbsp;&nbsp; {{$question[3]}}</label>
                        @if(isset($imgQuens[$tt][3]))
                            <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][3]) }}" height="100em" width="150em" alt="" title="" />
                        @endif
                </div>

                <div class="form-check form-check-inline">
                    <label class="form-check-label"> (4) &nbsp;&nbsp;&nbsp; {{$question[4]}} </label>
                        @if(isset($imgQuens[$tt][4]))
                            <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][4]) }}" height="100em" width="150em" alt="" title="" />
                        @endif
                </div>

                <div class="form-check form-check-inline">
                    <label class="form-check-label"> (5) &nbsp;&nbsp;&nbsp; {{$question[5]}} </label>
                        @if(isset($imgQuens[$tt][5]))
                        <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][5]) }}" height="100em" width="150em" alt="" title="" />
                        @endif
                </div>

                <div class="form-check form-check-inline">
                    <label class="form-check-label"> (6) &nbsp;&nbsp;&nbsp; {{$question[6]}}</label>
                        @if(isset($imgQuens[$tt][6]))
                            <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][6]) }}" height="100em" width="150em" alt="" title="" />
                        @endif
                </div>

            <br><br>

                <div class="form-text form-check-inline">
                    <input type="text" placeholder="Type correct choice by 1,2,3..." class="form-control" name="{{$kk}}_{{$qq}}" id="{{$kk}}_{{$qq}}" value="">
                </div>

        </div>

                <br>
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
                console.log(data2);
                $('#chapter_id').append(data2);
                // $(".table-responsive").html(data);
            }
        });

    });

</script>
@endpush

