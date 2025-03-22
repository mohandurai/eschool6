@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Masters</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('video/index') }}">Video Master</a></li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card"`>
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">
            Edit Video Master
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif
        </h4>

        <div class="table-responsive">
        <form action="{{ url('video') }}/update" method="post" enctype="multipart/form-data">
        @csrf
        <table id="dataTableExample" class="table">
            @if(!empty($video))
                <tr>
                    <td>ID</td><td>:</td>
                    <td>
                    <input type="hidden" class="form-control" name="id"
                    value="{{$video->id}}">
                         {{$video->id}}
                    </td>
                </tr>
                <tr>
                    <td>Class</td><td>:</td>
                    <td>
                        <select class="form-control" id="class_id" name="class_id" required>
                            <option selected value="0">Select Class</option>
                            @foreach($classlist as $key => $clist)
                                <option value="{{$key}}" @if( $video->class_id == $key) selected @endif>{{$clist}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Chapter Title</td><td>:</td>
                    <td>
                        <select class="form-control" id="title" name="title" required>
                            <option value="">Select Chapter</option>
                            @foreach($chapts as $key => $value)
                                <option value="{{$key}}" @if($video->title == $key) selected @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Type</td><td>:</td>
                    <td>
                        <select class="form-control" id="type" name="type">
                            <option selected value="0" @if($video->type == 0) selected @endif>Select Type</option>
                            <option value="1" @if($video->type == 1) selected @endif>TTK</option>
                            <option value="2" @if($video->type == 2) selected @endif>CLT</option>
                            <option value="3">Others</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>File Path</td><td>:</td>
                    <td>
                    <div class="form-group">
                        <label for="title">Attached Video File : {{ $video->file_path }}</label>
                        <input type="file" name="file_path" value="{{$video->file_path}}" class="form-control" accept=".mp4,.mp3,.mpeg,.ppt,.pptx,.mov,.avi,.wmv..mkv,.mov,.mpeg-2">
                    </div>
                    </td>
                </tr>



                <tr>
                    <td>School ID</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="school_id" name="school_id"
                    value="{{$video->school_id}}" required>
                    </td>
                </tr>
            @endif
          </table>
        </div>
      </div>
        <button type="submit" class="btn btn-primary">Update Record</button>
        </form>
        <input style="margin-top:20px;" type="button" value="Back" onClick="javascript:history.go(-1);">
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
