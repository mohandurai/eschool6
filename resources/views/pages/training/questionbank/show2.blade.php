@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<style type="text/css">
.mgn10px {
    margin-left: 10px;
    }
</style>
@endpush

@section('content')

@php
    //echo $qtmpid;
    //exit;
@endphp

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('questionbank/index') }}">Masters</a></li>
    <li class="breadcrumb-item active" aria-current="page">View Question Bank</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
    <h4>Title - {{$qntemptitle}}</h4>

    @php($count=0)
    @foreach($qntit as $kk => $qh)
      <div class="card-body">

      <form action="{{ url('questionbank/genpdf') }}" method="post" enctype="multipart/form-data">

          <div class="form-group">

           @php($count++)

          <label><h5>{{$romlet[$count]}}. {{$qh}}</h5></label></br>

          @foreach($qns[$kk] as $qq => $question)

            @if($kk == 4)

              Q. No-{{$qq}}. &nbsp;&nbsp; <label class="form-check-label"> {{$question}} </label>
                <br>
              <div class="form-group"  style="margin-left:20px;">
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

                    <br>
                    <div class="form-text form-check-inline" style="margin-left:40px;">
                        @php($nn = $kk."_".$qq)
                        Correct Answer &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp; {{ $Ans[$nn] }}
                    </div>
              </div>

            @elseif($kk == 7)

              @php($tt = "mcqimg7_".$qq)

              <div class="form-group">
                Q. No-{{$qq}}. &nbsp;&nbsp;

                <label class="form-check-label"> {{$question[0]}} </label><br>

                @if(isset($imgQuens[$tt][0]))
                <br><img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][0]) }}" height="150em" width="200em" alt="" title="" /><br>
                @endif

                <div class="form-check form-check-inline">
                    @if($question[1] != null)
                        <label class="form-check-label"> (1) &nbsp;&nbsp;&nbsp; {{$question[1]}} </label>
                    @endif
                    @if(isset($imgQuens[$tt][1]))
                    <br>(1) &nbsp;&nbsp;&nbsp; <img src="{{ url('storage\\images\\'. $tt .'\\'. $imgQuens[$tt][1]) }}" height="100em" width="150em" alt="" title="" /><br>
                    @endif
                </div>

                <div class="form-check form-check-inline">
                    @if($question[2] != null)
                        <label class="form-check-label"> (2) &nbsp;&nbsp;&nbsp; {{$question[2]}} </label>
                    @endif
                    @if(isset($imgQuens[$tt][2]))
                    <br>(2) &nbsp;&nbsp;&nbsp; <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][2]) }}" height="100em" width="150em" alt="" title="" /><br>
                    @endif
                </div>

                <div class="form-check form-check-inline">
                    @if($question[3] != null)
                        <label class="form-check-label"> (3) &nbsp;&nbsp;&nbsp; {{$question[3]}} </label>
                    @endif
                    @if(isset($imgQuens[$tt][3]))
                    <br>(3) &nbsp;&nbsp;&nbsp; <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][3]) }}" height="100em" width="150em" alt="" title="" /><br>
                    @endif
                </div>

                <div class="form-check form-check-inline">
                    @if($question[4] != null)
                        <label class="form-check-label"> (4) &nbsp;&nbsp;&nbsp; {{$question[4]}} </label>
                    @endif
                    @if(isset($imgQuens[$tt][4]))
                    <br>(4) &nbsp;&nbsp;&nbsp; <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][4]) }}" height="100em" width="150em" alt="" title="" /><br>
                    @endif
                </div>

                <div class="form-check form-check-inline">
                    @if($question[5] != null)
                        <label class="form-check-label"> (5) &nbsp;&nbsp;&nbsp; {{$question[5]}} </label>
                    @endif
                    @if(isset($imgQuens[$tt][5]))
                    <br>(5) &nbsp;&nbsp;&nbsp; <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][5]) }}" height="100em" width="150em" alt="" title="" /><br>
                    @endif
                </div>

                <div class="form-check form-check-inline">
                    @if($question[6] != null)
                        <label class="form-check-label"> (6) &nbsp;&nbsp;&nbsp; {{$question[6]}} </label>
                    @endif
                    @if(isset($imgQuens[$tt][6]))
                    <br>(6) &nbsp;&nbsp;&nbsp; <img src="{{ url('storage/images/'.$tt .'/'. $imgQuens[$tt][6]) }}" height="100em" width="150em" alt="" title="" /><br>
                    @endif
                </div>

                <br>
                <div class="form-text form-check-inline" style="margin-left:60px;">
                    @php($nn = $kk."_".$qq)
                    Correct Answer &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp; {{ $Ans[$nn] }}
                </div>
                <br>

            </div>

            @else

                Q. No-{{$qq}}. &nbsp;&nbsp; <label class="form-check-label"> {{$question}} </label>
                <br>
                <div class="form-text form-check-inline" style="margin-left:30px;">
                    @php($nn = $kk."_".$qq)
                    Correct Answer &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp; {{ $Ans[$nn] }}
                </div>
                <br><br>
            @endif

            @endforeach
          </div>

      </div>

      @endforeach

      <br>

            @php($url2 = "questionbank/" . $qtmpid . "/genpdf?qtplid=".$qtmpid."&qtpltitle=" . $qntemptitle)

            <a href="{{ url($url2) }}" class="btn btn-primary">Download as PDF</a>

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

