@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Masters</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('role/index') }}">Role Master</a></li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card"`>
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">
            Role Master &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="{{ url('/role')}}/{{$role->id}}/edit" role="button">Edit Role</a>
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif
        </h4>

        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            @if(!empty($role))
                <tr>
                    <td>ID</td><td>:</td><td>{{$role->id}}</td>
                </tr>
                <tr>
                    <td>Role Title</td><td>:</td><td>{{$role->role_title}}</td>
                </tr>
                <tr>
                    <td>Description</td><td>:</td><td>{{$role->role_description}}</td>
                </tr>
                <tr>
                    <td>Status</td><td>:</td><td>{{$role->status}}</td>
                </tr>
                <tr>
                    <td>Created at</td><td>:</td><td>{{$role->created_at}}</td>
                </tr>
                <tr>
                    <td>Updated at</td><td>:</td><td>{{$role->updated_at}}</td>
                </tr>
            @endif
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
