@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('student/index') }}">Students Master</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="#">Students Record</a></li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card"`>
    <div class="card">
      <div class="card-body">
        <h4 style="margin-bottom:10px;">
            Edit Students Record
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif
        </h4>

        <div class="table-responsive">
        <form action="{{ url('student/update') }}" method="post">
        @csrf
        <table id="dataTableExample" class="table">
            @if(!empty($studinfo))
                <tr>
                    <td>ID</td><td>:</td>
                    <td>
                    <input type="text" class="form-control" name="id" value="{{$studinfo->id}}" readonly>
                    </td>
                </tr>
                <tr>
                    <td>User ID</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" name="user_id" value="{{$studinfo->user_id}}" readonly>
                    </td>
                </tr>
                <tr>
                    <td>First Name</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" name="first_name" value="{{$studinfo->first_name}}" required>
                    </td>
                </tr>
                <tr>
                    <td>Last Name</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" name="last_name" value="{{$studinfo->last_name}}">
                    </td>
                </tr>

                <tr>
                    <td>Email ID</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" name="email" value="{{$studinfo->email}}" readonly>
                    </td>
                </tr>

                <tr>
                    <td>Contact Info</td><td>:</td>
                    <td>
                        <input type="number" class="form-control" name="mobile" value="{{$studinfo->mobile}}">
                    </td>
                </tr>

                <tr>
                    <td>Class ID</td><td>:</td>
                    <td>
                        <select class="form-control" name="class_id">
                            <option value="0">Select Class</option>
                        @foreach($classlist as $kk => $clist)
                            <option value="{{$kk}}" {{ $studinfo->class_id == $kk ? 'selected' : '' }}>{{$clist}}</option>
                        @endforeach
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Gender</td><td>:</td>
                    <td>
                        <select class="form-control" name="gender">
                            <option value="0">Select Gender</option>
                            <option value="1" {{ $studinfo->gender == 1 ? 'selected' : '' }}>Male</option>
                            <option value="2" {{ $studinfo->gender == 2 ? 'selected' : '' }}>FeMale</option>
                            <option value="3" {{ $studinfo->gender == 3 ? 'selected' : '' }}>TransGender</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Date of Birth</td><td>:</td>
                    <td>
                        <input type="date" class="form-control" name="dob" value="{{$studinfo->dob}}">
                    </td>
                </tr>

                <tr>
                    <td>Marks History</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" name="marks_history" value="{{$studinfo->marks_history}}">
                    </td>
                </tr>

                <tr>
                    <td>Fees Paid Info.</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" name="fees_paid_history" value="{{$studinfo->fees_paid_history}}">
                    </td>
                </tr>

                <tr>
                    <td>Uploaded Image Info.</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" name="upload_pps_image_info" value="{{$studinfo->upload_pps_image_info}}">
                    </td>
                </tr>

                <tr>
                    <td>Login Required</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" name="require_login" value="{{$studinfo->require_login}}">
                    </td>
                </tr>

                <tr>
                    <td>Modified Date</td><td>:</td>
                    <td>
                        <input type="text" class="form-control" name="need_login" value="{{$studinfo->updated_date}}">
                    </td>
                </tr>
          </table>
        </div>
        </div>
            <button type="submit" class="btn btn-primary">Update Record</button>
            <input style="margin-top:20px;" type="button" value="Back" onClick="javascript:history.go(-1);">

            @endif
            </form>

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
