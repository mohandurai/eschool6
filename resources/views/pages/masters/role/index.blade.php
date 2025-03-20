@extends('layout.master')

<meta name="csrf-token" content="{{ csrf_token() }}">

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<style type="text/css">
.buttons-pdf, .buttons-excel, .buttons-copy, .buttons-csv, .buttons-print {
  float: right;
}
</style>
@endpush

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
        <h4>
            Role Master &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="{{ url('role/create') }}" role="button">Create New Role</a>
        </h4>

        @if(Session::has('message'))
        </br>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{ Session::get('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @endif

        <div class="table-responsive">
        <table id="tracker_datatable" class="table">
            <thead>
                <!-- <tr>
                    <td></td>
                    <td><input type="text" class="form-control filter-input" placeholder="Find Role ..." data-column="2" /></td>
                    <td><input type="text" class="form-control filter-input" placeholder="Find Description ..." data-column="3" /></td>
                </tr> -->
                <tr>
                    <th>ID</th>
                    <th>Role Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if(!empty($roles))
            @foreach($roles as $slist)
                <tr>
                    <td>{{$slist->id}}</td>
                    <td>{{$slist->role_title}}</td>
                    <td>{{$slist->role_description}}</td>
                    <td>{{$slist->status}}</td>
                    <td>{{$slist->created_at}}</td>
                    <td>{{$slist->updated_at}}</td>
                    <td></td>
                </tr>
            @endforeach
            @endif
            </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('plugin-scripts')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    function confirmation()
    {
            if(confirm('Are you sure to delete this record.....?'))
            {
                return true;
            } else {
                return false;
            }
    }

    $(document).ready(function() {
        // alert("Settings page was loaded");
        // return false;
        var table6 = $('#tracker_datatable').DataTable({
            language: {
               "processing" : "<img src={{ asset('/assets/images/loading-14.gif') }}>"
            },
            dom : "Bflrtip",
            buttons : [
                'copy', 'csv', 'excel', 'pdf', 'print'
                //'excel', 'pdf'
            ],
            stateSave: true,
            processing: true,
            serverSide : true,
            responsive: true,
           ajax: "{{ url('rolelist') }}",
        //    pageLength: 5,
           lengthMenu: [ [7, 10, 25, 50, -1], [7, 10, 25, 50, 'All'] ],
           columns: [
                    { data: 'id', name: 'id' },
                    { data: 'role_title', name: 'role_title'},
                    { data: 'role_description', name: 'role_description' },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name : 'action', orderable : false, searchable: true}
                 ]

        });
    });

</script>
@endpush
