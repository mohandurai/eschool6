@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Masters</a></li>
    <li class="breadcrumb-item active" aria-current="page">Role Master</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">Create New Role</h4>

        <div class="table-responsive">
        <form action="{{ url('role/store') }}" method="post">
            @csrf
            <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="role_title" name="role_title" required>
            </div>
            <div class="form-group">
            <label for="body">Description about this Role</label>
            <textarea class="form-control" id="role_description" name="role_description" rows="3" required></textarea>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Create Role</button>
        </form>
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
