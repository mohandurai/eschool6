@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<style type="text/css">
    .form-control {
        background-color: white;
    }
.table2 {
    cellspacing: 10px;
    cellpadding: 10px;
    color: yellow;
    font-size: 18px;
    align: center;
}
</style>
@endpush

@section('content')

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">

        <div class="card-body">

                <h3 class="page-title">Home Work Report</h3><br>

                <form action="{{ url('homework/printreport') }}" method="post">
                @csrf

                <div class="table-responsive">

                    <div class="form-group">
                        <label for="title">Select Class</label>
                        <select class="form-control" id="class_id" name="class_id">
                            <option value="0" selected>Select Class</option>
                            @foreach($classlist as $kk => $clist)
                                <option value="{{$kk}}">{{$clist}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="title">Select Section</label>
                        <select class="form-control" id="sec_id" name="sec_id">
                            <option value="0" selected>Select Section</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                            <option value="J">J</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="title">Select Home Work Title</label>
                        <select class="form-control" id="hw_id" name="hw_id">
                            <option value="0" selected>Select Activity</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Select Report Type</label>
                        <select class="form-control" id="report_type" name="report_type">
                            <option value="0" selected>Select Type</option>
                            <option value="1">Individual</option>
                            <option value="2">Consolidated</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Select Student</label>
                        <select class="form-control" id="student_id" name="student_id">
                            <option value="0" selected>Select Student</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Select Output Method</label>
                        <select class="form-control" id="output_method" name="output_method">
                            <option value="0">Select Method</option>
                            <option value="1">Screen</option>
                            <option value="2">PDF</option>
                            <option value="3">HTML</option>
                            <option value="4">Send to Parent</option>
                        </select>
                    </div>

                </div>

                <table>
                    <tr>
                        <td width="50%" align="center">
                            <input type="button" value="Back" onClick="javascript:history.go(-1);">
                        </td>
                        <td width="50%" align="center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </td>
                    </tr>
                </table>

            </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/prismjs/prism.js') }}"></script>
  <script src="{{ asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>

<script>

$(document).ready(function() {
    $("#class_id option[value=0]").prop('selected', true);
    $("#sec_id option[value=0]").prop('selected', true);
    $("#student_id option[value=0]").prop('selected', true);
});

$('#report_type').change(function() {

    $('#student_id').empty();
    $("#student_id option[value=0]").prop('selected', true);

    var reptype = $(this).val();

    if(reptype == 1){
        clsid = $('#class_id').val();
        secid = $('#sec_id').val();



        // alert("Rep Type .... Class & Sec "+clsid + " ==== " + secid);
        if(clsid == "0" || secid == "0" ) {
            alert("Select Both Class & Section ...");
            return false;
        } else {
            $.ajax({
                type: 'GET',
                url: "{{ url('getStudents3') }}/"+clsid+"~~~~~"+secid,
                // complete: function() {
                //     $('#psdatasourcSpinner').hide();
                // },
                success: function(data2) {
                    console.log(data2);
                    $('#student_id').append(data2);
                    // $(".table-responsive").html(data);
                }
            });
        }

    } else if(reptype == 2){
        $("#student_id").attr("disabled", "disabled");
    } else {

    }
    return false;
});

$('#class_id').change(function() {

        var clsid = $(this).val();
        var secid = $('#sec_id').val();
        // alert("UUUUUUUUUUU "+clsid);
        // return false;

        $.ajax({
            type: 'GET',
            url: "{{ url('getAllHw') }}/"+clsid,
            // complete: function() {
            //     $('#psdatasourcSpinner').hide();
            // },
            success: function(data3) {
                // console.log(data3);
                $('#hw_id').append(data3);
                // $(".table-responsive").html(data);
            }
        });

});

$('#sec_id').change(function() {
    clsid = $('#class_id').val();
    secid = $('#sec_id').val();
    // alert("Class & Sec "+clsid + " ==== " + secid);
    // return false;
    $("#student_id option[value=0]").prop('selected', true);

    $.ajax({
            type: 'GET',
            url: "{{ url('getStudents3') }}/"+clsid+"~~~~~"+secid,
            // complete: function() {
            //     $('#psdatasourcSpinner').hide();
            // },
            success: function(data2) {
                // console.log(data2);
                $('#student_id').append(data2);
                // $(".table-responsive").html(data);
            }
        });
});

</script>

@endpush
