@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('qnbank/index') }}">Question Bank</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('qnbank/index') }}">Question Bank</a></li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card"`>
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">
            Question Bank &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="{{ url('/qnbank')}}/{{$qnbank->id}}/edit" role="button">Edit Question Bank</a>
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif
        </h4>

        <div class="table-responsive" style="height: 400px; overflow-y: auto;">
          <table id="dataTableExample" class="table">
            @if(!empty($qnbank))
                <tr>
                    <td>ID</td><td>:</td><td>{{$qnbank->id}}</td>
                </tr>
                <tr>
                    <td>Title</td><td>:</td><td>{{$qnbank->title}}</td>
                </tr>
                <tr>
                    <td>School ID</td><td>:</td><td>{{$qnbank->class_id}}</td>
                </tr>
                <tr>
                    <td>Term</td><td>:</td><td>{{$qnbank->term}}</td>
                </tr>
                <tr>
                    <td>File Path</td><td>:</td><td>{{$qnbank->file_path}}</td>
                </tr>
            @endif
          </table>

          <iframe width="100%" height="300%"  src="{{ url('/view-pdf', ['filename' => $qnbank->file_path]) }}">Your browser isn't compatible</iframe>

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
