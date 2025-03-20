@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('student/index') }}">Students Record</a></li>
    <li class="breadcrumb-item active" aria-current="page">Students Master</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">Create New Student</h4>

        <div class="table-responsive">
        <form id="submitForm3" action="{{ url('student/store') }}" method="post">
            @csrf
            <div class="form-group">
            <label for="title">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>

            <div class="form-group">
            <label for="title">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name">
            </div>

            <div class="form-group">
            <label for="title">Email ID</label>
            <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
            <label for="title">Mobile/Contact Info.</label>
            <input type="number" class="form-control" id="mobile" name="mobile">
            </div>

            <div class="form-group">
            <label for="title">Class</label>
                <select class="form-control" id="class_id" name="class_id" required>
                    <option selected value="0">Select Class</option>
                    @foreach($classlist as $clist)
                        <option value="{{$clist->id}}">{{$clist->class}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="title">Select Section</label>
                <select class="form-control" id="Section" name="Section" required>
                    <option value="0" selected>Select Section</option>
                    <option value="1">A</option>
                    <option value="2">B</option>
                    <option value="3">C</option>
                    <option value="4">D</option>
                    <option value="5">E</option>
                    <option value="6">F</option>
                    <option value="7">G</option>
                    <option value="8">H</option>
                    <option value="9">I</option>
                    <option value="10">J</option>
                </select>
            </div>

            <div class="form-group">
                <label` for="exampleFormControlSelect1">Select Gender</label>
                <select class="form-control" id="gender" name="gender" required>
                <option value="0" selected>Select Gender</option>
                <option value="1">Male</option>
                <option value="2">Female</option>
                <option value="3">TransGender</option>
                </select>
            </div>

            <div class="form-group">
            <label for="title">Date of Birth</label>
            <input type="date" class="form-control" id="dob" name="dob" required>
            </div>

            <div class="form-group">
            <label for="title">Attach PP Size Photo</label>
            <input type="file" name="photo_image" class="form-control" accept=".jpeg,.jpg,.png,.tiff,.bmp">
            </div>

            <div class="form-group">
                <label` for="exampleFormControlSelect1">Require Login</label>
                <select class="form-control" id="require_login" name="require_login">
                <option value="0" selected>No</option>
                <option value="1">Yes</option>
                </select>
            </div>

       </div>
      </div>
      <button type="submit" class="btn btn-primary">Create Student</button>
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
  <script>

    $('#submitForm3').submit(function() {
        if($('#gender').val() == 0) {
            alert("Select Gender .....");
            return false;
        }
        if($('#Section').val() == 0) {
            alert("Select Section .....");
            return false;
        }
        if($('#class_id').val() == 0) {
            alert("Select Class .....");
            return false;
        }
    });

  </script>
@endpush


