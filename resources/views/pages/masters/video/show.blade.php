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
            Role Master &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="{{ url('/video')}}/{{$video->id}}/edit" role="button">Edit Video Master</a>
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif
        </h4>

        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            @if(!empty($video))
                <tr>
                    <td>ID</td><td>:</td><td>{{$video->id}}</td>
                </tr>
                <tr>
                    <td>Title</td><td>:</td><td>{{$video->title}}</td>
                </tr>
                <tr>
                    <td>File Type</td><td>:</td><td>{{$video->type}}</td>
                </tr>
                <tr>
                    <td>File Path</td><td>:</td><td>{{$video->file_path}}</td>
                </tr>
                <tr>
                    <td>School ID</td><td>:</td><td>{{$video->school_id}}</td>
                </tr>
            @endif
          </table>
        </div>
      </div>
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
