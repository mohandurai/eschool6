@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('asset/index') }}">Assets</a></li>
    <li class="breadcrumb-item active" aria-current="page">Assts Management</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">Create New Asset</h4>

        <div class="table-responsive">
        <form action="{{ url('asset/store') }}" method="post">
            @csrf
            
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="title">Add Asset Name</label>
                <input type="text" class="form-control" id="asset_name" name="asset_name" required>
            </div>

            <div class="form-group">
                <label for="title">Description</label>
                <input type="text" class="form-control" id="description" name="description" required>
            </div>

            <div class="form-group">
                <label for="title">Model Info.</label>
                <input type="text" class="form-control" id="model_info" name="model_info" required>
            </div>

            <div class="form-group">
            <label for="title">Department</label>
                <select class="form-control" id="department" name="department">
                    <option value="0" selected>Select Class</option>
                    <option value="Accounts">Accounts</option>
                    <option value="Office">Office</option>
                    <option value="HR">HR</option>
                    <option value="Sports">Sports</option>
                    <option value="Admission">Admission</option>
                </select>
            </div>

            <div class="form-group">
                <label for="title">Asset Value (in Rs.)</label>
                <input type="number" class="form-control" id="value" name="value" required>
            </div>

            <div class="form-group">
                <label for="title">Purchase Date</label>
                <input type="date" class="form-control" id="purchase_date" name="purchase_date" placeholder="Start Date..." required>
            </div>

            <div class="form-group">
            <label for="title">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="Active" selected>Active</option>
                    <option value="InActive">InActive</option>
                </select>
            </div>

        </div>
    </div>
        <button type="submit" class="btn btn-primary">Create Asset</button>
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

@push('custom-scripts')
<script>
$('#class_id').change(function() {
        // alert("UUUUUUUUUUU"); return false;
        $('#title').html('');

        var clsid = $(this).val();

        $.ajax({
            type: 'GET',
            url: "{{ url('/getchapters') }}/"+clsid,
            // complete: function() {
            //     $('#psdatasourcSpinner').hide();
            // },
            success: function(data2) {
                // console.log(data2);
                $('#title').append(data2);
                // $(".table-responsive").html(data);
            }
        });

    });
</script>
@endpush
