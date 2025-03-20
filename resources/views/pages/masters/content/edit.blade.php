@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Content Master</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('content/index') }}">Content</a></li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card"`>
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">
            Edit Content
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif
        </h4>

        <div class="table-responsive">
        <form action="{{ url('content') }}/update" method="post">
        @csrf
        <table id="dataTableExample" class="table">
            @if(!empty($content))
                <tr>
                    <td>ID</td><td>:</td>
                    <td>
                    <input type="hidden" class="form-control" name="id"
                    value="{{$content->id}}">
                         {{$content->id}}
                    </td>
                </tr>
                <tr>
                    <td>Title</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="title" name="title" value="{{$content->title}}" required>
                    </td>
                </tr>
                <tr>
                    <td>Class ID</td><td>:</td>
                    <td>
                        <select class="form-control" name="class_id">
                            <option value="0">Select Class</option>
                            @foreach($clslst as $kk => $clist)
                                <option value="{{$kk}}" {{ $content->class_id == $kk ? 'selected' : '' }}>{{$clist}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Subject</td><td>:</td>
                    <td>
                        <select class="form-control" name="subject_id">
                            <option value="0">Select Subject</option>
                            @foreach($subjs as $kk2 => $sub)
                                <option value="{{$kk2}}" {{ $content->subject_id == $kk2 ? 'selected' : '' }}>{{$sub}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Chapter</td><td>:</td>
                    <td>
                        <select class="form-control" name="chapter_id">
                            <option value="0">Select Chapter</option>
                            @foreach($chapts as $kk3 => $chap)
                                <option value="{{$kk3}}" {{ $content->chapter_id == $kk3 ? 'selected' : '' }}>{{$chap}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Video Mode</td><td>:</td>
                    <td>
                        <select class="form-control" id="video_type_id" name="video_type_id">
                            <option value="0" selected>Select Mode</option>
                            <option value="1" {{ $content->video_type_id == 1 ? 'selected' : '' }}>TTK</option>
                            <option value="2" {{ $content->video_type_id == 2 ? 'selected' : '' }}>CLT</option>
                            <option value="3" {{ $content->video_type_id == 3 ? 'selected' : '' }}>Others</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Video File Name</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="video_id" name="video_id" value="{{$content->video_id}}" required>
                        <select class="form-control" name="chapter_id">
                            <option value="0">Select Video Path</option>
                            @foreach($videos as $kk4 => $vid)
                                <option value="{{$kk4}}" {{ $content->video_id == $kk4 ? 'selected' : '' }}>{{$vid}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>


                <tr>
                    <td colspan=3><button type="submit" class="btn btn-primary">Update Record</button>
                    </td>
                </tr>
            @endif
            </form>
          </table>
        </div>
      </div>
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
