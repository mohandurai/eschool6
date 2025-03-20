@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Chapter Master</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('chapter/index') }}">Chapters</a></li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card"`>
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">
            Edit Chapter
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif
        </h4>

        <div class="table-responsive">
        <form action="{{ url('chapter') }}/update" method="post">
        @csrf
        <table id="dataTableExample" class="table">
            @if(!empty($chapter))
                <tr>
                    <td>ID</td><td>:</td>
                    <td>
                    <input type="hidden" class="form-control" name="id"
                    value="{{$chapter->id}}">
                         {{$chapter->id}}
                    </td>
                </tr>
                <tr>
                    <td>Title</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="title" name="title" value="{{$chapter->title}}" required>
                    </td>
                </tr>
                <tr>
                    <td>Class ID</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="class_id" name="class_id" value="{{$chapter->class_id}}" required>
                    </td>
                </tr>
                <tr>
                    <td>School ID</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="school_id" name="school_id"
                    value="{{$chapter->school_id}}" required>
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
