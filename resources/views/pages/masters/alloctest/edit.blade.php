@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@php
    echo "<pre>";
    print_r($allocte);
    echo "</pre>";
    exit;
@endphp

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Masters</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('alloctest/index') }}">Allocate Test</a></li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card"`>
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">
            Edit Test Allocation
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif
        </h4>

        <div class="table-responsive">
        <form action="{{ url('allocate') }}/update" method="post">
        @csrf
        <table id="dataTableExample" class="table">
            @if(!empty($allocte))
                <tr>
                    <td>ID</td><td>:</td>
                    <td>
                    <input type="hidden" class="form-control" name="id"
                    value="{{$allocte->id}}">
                         {{$allocte->id}}
                    </td>
                </tr>
                <tr>
                    <td>Class ID</td><td>:</td>
                    <td>
                        <select class="form-control" name="class_id">
                            <option value="0">Select Class</option>
                            @foreach($clslst as $kk => $clist)
                                <option value="{{$kk}}" {{ $allocte->class_id == $kk ? 'selected' : '' }}>{{$clist}}</option>
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
                                <option value="{{$kk2}}" {{ $allocte->subject_id == $kk2 ? 'selected' : '' }}>{{$sub}}</option>
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
                                <option value="{{$kk3}}" {{ $allocte->chapter_id == $kk3 ? 'selected' : '' }}>{{$chap}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Title</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="test_title" name="test_title" value="{{$allocte->test_title}}" required>
                    </td>
                </tr>

                <tr>
                    <td>Question Master ID</td><td>:</td>
                    <td>
                         <input type="text" class="form-control" id="qn_master_templ_id" name="qn_master_templ_id" value="{{$allocte->qn_master_templ_id}}" required>
                    </td>
                </tr>


                <tr>
                    <td>Type</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="type" name="type" value="{{$allocte->type}}" required>
                    </td>
                </tr>
                <tr>
                    <td>File Path</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="file_path" name="file_path"
                    value="{{$allocte->file_path}}" required>
                    </td>
                </tr>
                <tr>
                    <td>School ID</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="school_id" name="school_id"
                    value="{{$allocte->school_id}}" required>
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
