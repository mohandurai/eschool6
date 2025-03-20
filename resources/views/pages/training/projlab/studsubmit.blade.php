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
                        @php($showimg = "storage/project_activity/class_".$projLabAct->class_id."/".$projLabAct->attachment)
                        <img src="{{ url($showimg) }}" style="border-radius:0%; width:300px;height:150px;"/>
                    </td>
                </tr>
            @endif

          <tr>
            <td>

          <form action="{{ url('projlab/projlabfinish') }}" method="post" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="proj_id" value="{{$projLabAct->id}}">
            <input type="hidden" name="class_id" value="{{$projLabAct->class_id}}">
            <input type="hidden" name="assign_to" value="{{$projLabAct->assign_to}}">
            <input type="hidden" name="student_id" value="{{$studid}}">

                <label for="title">Upload Finished Activity File : </label>
            </td>
            <td>:</td>
            <td>
                    @php($showimg2 = "storage/project_activity/class_".$projLabAct->class_id."/".$projLabAct->student_submit_attach)
                    <img src="{{ url($showimg2) }}" style="border-radius:0%; width:300px;height:150px;"/>
                    <input type="file" name="image_projlab_finish" class="form-control" accept=".mp4,.mp3,.jpeg,.ppt,.pptx,.jpg,.png,.bmp..mkv,.mov,.mpeg-2">

            </td>
        </tr>
        <tr>
            <td>
                <label for="exampleFormControlTextarea1">Comments & Remarks</label>
            </td>
            <td>:</td>
            <td>
                <textarea class="form-control" name="student_remarks" id="exampleFormControlTextarea1" rows="5"> {{ $projLabAct->student_remarks }} </textarea>
            </td>
        </tr>

        <tr>
            <td>
                <label for="exampleFormControlTextarea1">Status</label>
            </td>
            <td>:</td>
            <td>
                <label` for="exampleFormControlSelect1"></label>
                <select class="form-control" id="status" name="status">
                    <option value="Not Started" {{ ( $projLabAct->status == "Not Started") ? 'selected' : '' }}> Not Started </option>
                    <option value="In Progress" {{ ( $projLabAct->status == "In Progress") ? 'selected' : '' }}> In Progress</option>
                    <option value="Pending" {{ ( $projLabAct->status == "Pending") ? 'selected' : '' }}> Pending</option>
                    <option value="On Hold" {{ ( $projLabAct->status == "On Hold") ? 'selected' : '' }}> On Hold</option>
                    <option value="Finished" {{ ( $projLabAct->status == "Finished") ? 'selected' : '' }}> Finished</option>
                    <option value="Others" {{ ( $projLabAct->status == "Others") ? 'selected' : '' }}> Others</option>
                </select>
            </td>
        </tr>

    </table>

       </div>
    </div>

                <button type="submit" class="btn btn-primary">Submit Project/Lab Activity</button>

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
