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
    <li class="breadcrumb-item"><a href="#">Question Bank</a></li>
    <li class="breadcrumb-item active" aria-current="page">Index</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4> Question Bank Generation</h4>

        @if(Session::has('message'))
        </br>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{ Session::get('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @endif

        <br>
        <form action="{{ url('questionbank/store2') }}" method="post">
                @csrf

            <div class="form-group">
                <label for="exampleFormControlSelect1">Class</label>
                <select class="form-control" id="class_id" name="class_id">
                    <option value="0" selected>Select Class</option>
                    @foreach($classlist as $clist)
                        <option value="{{$clist->id}}">{{$clist->class}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1">Select Question Master</label>
                <select class="form-control" id="qnmastemp" name="qnmastemp">
                    <option value="0" selected>Select Que. Master Template</option>
                </select>
            </div>

      </div>
            <input type="hidden" name="qntemp_title" id="qntemp_title" value="">
            <button type="submit" class="btn btn-primary">View Question Bank</button>
      </form>
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

$(document).ready(function() {
    $("#class_id option[value=0]").prop('selected', true);
});

    $('#qnmastemp').change(function() {
        var selectedQnTitle = $('#qnmastemp option:selected').text();
        // alert(selectedQnTitle);
        $('#qntemp_title').val(selectedQnTitle);
    });


    $('#class_id').change(function() {

        var clsid = $(this).val();
        $('#qnmastemp').html('');
        // alert("XXXXXXXXXXXX  "+clsid); return false;

        $.ajax({
            url: "{{ url('/getqnmasters') }}/"+clsid,
            type: 'GET',
            // complete: function() {
            //     $('#psdatasourcSpinner').hide();
            // },
            success: function(data2) {
                // console.log(data2);
                $('#qnmastemp').append(data2);
                // $(".table-responsive").html(data);
            }
        });

    });


</script>
@endpush
