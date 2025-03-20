@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@php
//echo "<pre>";
//print_r($qnstemp);
//echo "</pre>";
//exit;
@endphp

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('subject/index') }}">Masters</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="#">Subject Master</a></li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card"`>
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">
            Edit Subject Master
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif
        </h4>

        <div class="table-responsive">
        <form action="{{ url('subject') }}/update" method="post">
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
                    <td>Title</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="title" name="title" value="{{$video->title}}" required>
                    </td>
                </tr>
                <tr>
                    <td>Class ID</td><td>:</td>
                    <td>
                        <div class="form-group">
                            <select class="form-control" id="class_id" name="class_id">
                                <option value="0">Select Class</option>
                                @foreach($clsid as $kk => $clist)
                                    <option value="{{$kk}}" {{ $kk == $video->class_id ? 'selected' : ''}}>{{$clist}}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Remraks</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="remarks" name="remarks" value="{{$video->remarks}}" required>
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
