@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')

@php
    //echo "<pre>";
    //print_r($projLabEval);
    //echo "</pre>";
    //exit;
@endphp

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home Work Evaluation</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="#">Home Work Evaluation</a></li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card"`>
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;"> Home Work Evaluation</h4>

            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif

        <div class="form-group">
          <table id="dataTableExample" class="table">
            @if(!empty($projLabEval))

                <tr>
                    <td>ID</td><td>:</td><td>{{$projLabEval->id}}</td>
                </tr>
                <tr>
                    <td>Class</td><td>:</td><td>{{$projLabEval->class_id}}</td>
                </tr>
                <tr>
                    <td>Project/Lab Title</td><td>:</td><td>{{$projLabEval->title}}</td>
                </tr>
                <tr>
                    <td>Student ID</td><td>:</td><td>{{$projLabEval->student_id}}</td>
                </tr>
                <tr>
                    <td>Activity Image</td><td>:</td>
                    <td>
                        @php($activimg = "storage/homework/class_".$projLabEval->class_id."/".$projLabEval->attachment)
                        <img src="{{ url($activimg) }}" style="border-radius:0%; width:300px;height:150px;"/>
                    </td>
                </tr>
                <tr>
                    <td>Upload Finished Activity Image</td><td>:</td>
                    <td>
                        @php($showimg2 = "storage/homework/class_".$projLabEval->class_id."/".$projLabEval->student_submit_attach)
                        <img src="{{ url($showimg2) }}" style="border-radius:0%; width:300px;height:150px;"/>
                    </td>
                </tr>
                <tr>
                    <td>Comments & Remarks</td><td>:</td>
                    <td>
                        {{ $projLabEval->student_remarks }}
                    </td>
                </tr>
                <tr>
                    <td>Status</td><td>:</td>
                    <td>
                        {{ $projLabEval->status }}
                    </td>
                </tr>


          </table>

          <form action="{{ url('homework/evaluatefinish') }}" method="post">
                @csrf

            <input type="hidden" name="id" value="{{$projLabEval->id}}">

            <div class="form-group">
                <label` for="exampleFormControlSelect1">Marks Scored</label>
                <input type="number" class="form-control" name="mark_scored" value="{{ $projLabEval->mark_scored }}" required>
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Evaluator Comments & Remarks</label>
                <textarea class="form-control" name="evaluator_comments" id="evaluator_comments" rows="5">
                    {{$projLabEval->evaluator_comments}}
                </textarea>
            </div>

            <div class="form-group">
                <label` for="exampleFormControlSelect1">Evaluator Status</label>
                <select class="form-control" id="evaluator_status" name="evaluator_status">
                    <option value="Under-Progress" {{ ( $projLabEval->evaluator_status == "Under-Progress") ? 'selected' : '' }}>Under-Progress</option>
                    <option value="Pending" {{ ( $projLabEval->evaluator_status == "Pending") ? 'selected' : '' }}>Pending</option>
                    <option value="On-Hold" {{ ( $projLabEval->evaluator_status == "On-Hold") ? 'selected' : '' }}>On-Hold</option>
                    <option value="Finished" {{ ( $projLabEval->evaluator_status == "Finished") ? 'selected' : '' }}>Finished</option>
                </select>
            </div>

        </div>
        @endif

       </div>
       <br>
           <button type="submit" class="btn btn-primary">Submit Lab Project/Activity Evaluation</button>
           </form>
    </div>
    <br>
           <input style="margin-top:20px;" type="button" value="Back" onClick="javascript:history.go(-1);">
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
