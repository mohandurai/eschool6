@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@php
//echo "<pre>";
//print_r($assets);
//echo "</pre>";
//exit;
@endphp

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('asset/index') }}">Assets</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="#">Assets Master</a></li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card"`>
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">
            Edit Assets Master
        </h4>

        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
        @endif

        <div class="table-responsive">
        <form action="{{ url('asset') }}/update" method="post">
        @csrf
        <table id="dataTableExample" class="table">
            @if(!empty($assets))
                <tr>
                    <td>ID</td><td>:</td>
                    <td>
                    <input type="hidden" class="form-control" name="id" value="{{$assets->id}}">
                         {{$assets->id}}
                    </td>
                </tr>
                <tr>
                    <td>Asset Title</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="asset_name" name="asset_name" value="{{$assets->asset_name}}" required>
                    </td>
                </tr>
                <tr>
                    <td>Description</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="description" name="description" value="{{$assets->description}}">
                    </td>
                </tr>
                <tr>
                    <td>Model Info.</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="model_info" name="model_info" value="{{$assets->model_info}}" required>
                    </td>
                </tr>
                <tr>
                    <td>Department</td><td>:</td>
                    <td>
                    <select class="form-control" id="department" name="department">
                        <option value="0" {{ $assets->department == 0 ? 'selected' : '' }}>Select Class</option>
                        <option value="Accounts" {{ $assets->department == 'Accounts' ? 'selected' : '' }}>Accounts</option>
                        <option value="Office" {{ $assets->department == 'Office' ? 'selected' : '' }}>Office</option>
                        <option value="HR" {{ $assets->department == 'HR' ? 'selected' : '' }}>HR</option>
                        <option value="Sports" {{ $assets->department == 'Sports' ? 'selected' : '' }}>Sports</option>
                        <option value="Admission" {{ $assets->department == 'Admission' ? 'selected' : '' }}>Admission</option>
                    </select>
                    </td>
                </tr>

                <tr>
                    <td>Model Info.</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="model_info" name="model_info" value="{{$assets->model_info}}">
                    </td>
                </tr>

                <tr>
                    <td>Asset Value (in Rs.)</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="value" name="value" value="{{$assets->value}}">
                    </td>
                </tr>

                <tr>
                    <td>Purchase Date</td><td>:</td>
                    <td>
                        <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{$assets->purchase_date}}">
                    </td>
                </tr>

                <tr>
                    <td>Status</td><td>:</td>
                    <td>
                    <select class="form-control" id="status" name="status">
                        <option value="Active" {{ $assets->status == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="InActive" {{ $assets->status == 'InActive' ? 'selected' : '' }}>InActive</option>
                    </select>
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
