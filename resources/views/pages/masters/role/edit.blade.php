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
            Edit Role Master
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif
        </h4>

        <div class="table-responsive">
        <form action="{{ url('role') }}/update" method="post">
        @csrf
        <table id="dataTableExample" class="table">
            @if(!empty($role))
                <tr>
                    <td>ID</td><td>:</td>
                    <td>
                    <input type="hidden" class="form-control" id="role_title" name="id"
                    value="{{$role->id}}">
                         {{$role->id}}
                    </td>
                </tr>
                <tr>
                    <td>Role Title</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="role_title" name="role_title" value="{{$role->role_title}}" required>
                    </td>
                </tr>
                <tr>
                    <td>Description</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="role_description" name="role_description" value="{{$role->role_description}}" required>
                    </td>
                </tr>
                <tr>
                    <td>Status</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" id="status" name="status"
                    value="{{$role->status}}" required>
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
