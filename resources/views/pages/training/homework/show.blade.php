@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('projlab/index') }}">Project Lab Activity</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="#">View </a></li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card"`>
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;"> Project Lab Activity</h4>

            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif

        <div class="form-group">
          <table id="dataTableExample" class="table" style="word-break: break-word;">
            @if(!empty($projLabAct))

                <tr>
                    <td>ID</td><td>:</td><td>{{$projLabAct->id}}</td>
                </tr>
                <tr>
                    <td>Title</td><td>:</td><td>{{$projLabAct->title}}</td>
                </tr>
                <tr>
                    <td>Activity Description</td><td>:</td>
                    <td style="width:80%; word-wrap: break-word; white-space: pre-wrap;">
                        {{$projLabAct->describe_activity}}
                    </td>
                </tr>
                <tr>
                    <td>Class</td><td>:</td><td>{{$projLabAct->class_id}}</td>
                </tr>
                <tr>
                    <td>Assigned To</td><td>:</td><td>{{$projLabAct->assign_to}}</td>
                </tr>
                <tr>
                    <td>Attachment</td><td>:</td>
                    <td>
                        @php($showimg = "storage/project_activity/class_".$projLabAct->class_id."/".$projLabAct->attachment)
                        <img src="{{ url($showimg) }}" style="border-radius:0%; width:300px;height:150px;"/>
                    </td>
                </tr>
            @endif
          </table>

          <!-- <form action="{{ url('projlab/projlabfinish') }}" method="post" enctype="multipart/form-data">
                @csrf

            <input type="hidden" name="proj_id" value="{{$projLabAct->id}}">
            <input type="hidden" name="class_id" value="{{$projLabAct->class_id}}">

            <div class="form-group">
                <label for="title">Upload Finished Activity File : </label>
                <input type="file" name="image_projlab_finish" class="form-control" accept=".mp4,.mp3,.jpeg,.ppt,.pptx,.jpg,.png,.bmp..mkv,.mov,.mpeg-2">
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Comments & Remarks</label>
                <textarea class="form-control" name="remarks" id="exampleFormControlTextarea1" rows="5"></textarea>
            </div>

            <div class="form-group">
                <label` for="exampleFormControlSelect1">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="0" selected>Not Started</option>
                    <option value="1">In Progress</option>
                    <option value="2">Pending</option>
                    <option value="3">On Hold</option>
                    <option value="4">Finished</option>
                    <option value="5">Withhold</option>
                    <option value="6">Others</option>
                </select>
            </div>

        </div> -->

       </div>
       <br>
                <!-- <button type="submit" class="btn btn-primary">Submit Project/Lab Activity</button> -->
           <!-- </form> -->
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
