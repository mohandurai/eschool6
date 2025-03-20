@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')

@php
    //echo "<pre>";
    //print_r($asset);
    //echo "</pre>";
    //exit;
@endphp

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('student/index') }}">Assets</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="#">Asset Master</a></li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card"`>
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">
        Subject Master &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="{{ url('/asset')}}/{{$asset->id}}/edit" role="button">Edit Asset Item {{$asset->id}} - {{$asset->asset_name}}</a>
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif
        </h4>

        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            @if(!empty($asset))
            @foreach($asset as $kk => $vals)
                <tr>
                    <td> {{ ucfirst(str_replace("_"," ",$kk)) }} </td><td>:</td><td>{{ $vals }}</td>
                </tr>
            @endforeach
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
