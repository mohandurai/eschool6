@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/prismjs/prism.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4>
            Student Master &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="{{ url('student/create') }}" role="button">Create New Student</a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="#" role="button">Bulk Import Students</a>
        </h4>

        <br>

        @if(Session::has('message'))
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
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Contact Info</th>
                    <th>Class</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('plugin-scripts')
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

        var table6 = $('#tracker_datatable').DataTable({
            language: {
               "processing" : "<img src={{ asset('/assets/images/loading-14.gif') }}>"
            },
            buttons : [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            stateSave: true,
            processing: true,
            serverSide : true,
            responsive: true,
           ajax: "{{ url('studentlist') }}",
           lengthMenu: [ [7, 10, 25, 50, -1], [7, 10, 25, 50, 'All'] ],
           columns: [
                    { data: 'user_id', name: 'user_id' },
                    { data: 'first_name', name: 'first_name'},
                    { data: 'last_name', name: 'last_name' },
                    { data: 'email', name: 'email' },
                    { data: 'mobile', name: 'mobile' },
                    { data: 'class_id', name: 'class_id' },
                    { data: 'action', name : 'action', orderable : false, searchable: false}
                 ]

        });
    });

</script>
@endpush
