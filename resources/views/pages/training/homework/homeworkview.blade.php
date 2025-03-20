@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('projlab/studprojindex') }}">Student Project Lab Activity</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="#">Project Lab Activity Submit</a></li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card"`>
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">Students Project Lab Activity Submit</h4>

            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif

        <div class="form-group">
          <table id="dataTableExample" class="table">
            @if(!empty($projLabAct))

                <tr>
                    <td>ID</td><td>:</td><td>{{$projLabAct->id}}</td>
                </tr>
                <tr>
                    <td>Title</td><td>:</td><td>{{$projLabAct->title}}</td>
                </tr>
                <tr>
                    <td>Activity Description</td><td>:</td>
                    <td>
                        {{$projLabAct->describe_activity}}
                    </td>
                </tr>

                <tr>
                    <td>Class</td><td>:</td><td>{{$projLabAct->class_id}}</td>
                </tr>
                <tr>
                    <td>Attachment</td><td>:</td>
                    <td>
                        @php($showimg = "storage/homework/class_".$projLabAct->class_id."/".$projLabAct->attachment)
                        <img src="{{ url($showimg) }}" style="border-radius:0%; width:300px;height:150px;"/>
                    </td>
                </tr>
                <tr>
                    <td>Upload Finished Activity File</td><td>:</td>
                    <td>
                        @php($showimg2 = "storage/homework/class_".$projLabAct->class_id."/".$projLabAct->student_submit_attach)
                        <img src="{{ url($showimg2) }}" style="border-radius:0%; width:300px;height:150px;"/>
                    </td>
                </tr>
                <tr>
                    <td>Comments & Remarks</td><td>:</td>
                    <td>
                        {{ $projLabAct->student_remarks }}
                    </td>
                </tr>
                <tr>
                    <td>Status</td><td>:</td>
                    <td>
                        {{ $projLabAct->status }}
                    </td>
                </tr>

            @endif
          </table>

        </div>

       </div>
       <input type="button" value="Back" onClick="javascript:history.go(-1);">
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
