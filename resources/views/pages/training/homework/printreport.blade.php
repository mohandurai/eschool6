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

@php
    //echo "<pre>";
    //print_r($stud_data);
    //echo "</pre>";
    //exit;
@endphp

@section('content')

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">

        <table class="table2">
                <tr>
                    <td align="center">
                        <img src="{{ asset('assets/images/image3_horizon.png') }}" height="150em" width="200em" alt="" title="" />
                    <br><br>
                    </td>
                    <td>
                        <h3>Cannosa English Medium School</h3>
                        No. XXXX, Stree Name detailed, District Name - 600017
                        <br>Contact Details : 98406 12345
                        <br>Website  : www.eschool.com
                        <br>email - admin@eschool.com
                    </td>
                </tr>
        </table>

        <table width="90%" class="table2" cellspacing="10" cellpadding="10">
            <tr>
            <td style="color:white; font-size:20; margin-left: 50;"> HOME WORK ACTIVITY &nbsp;&nbsp;</td>
            <td style="text-align: right;"> Class & Sec. : &nbsp;&nbsp;</td>
                <td>
                @if(isset($stud_data[0][4]) || isset($stud_data[0][5]))
                    {{$stud_data[0][4]}} - {{ $stud_data[0][5] }}
                @else
                    <p>Info. not available !!!</p>
                @endif
                </td>
            <td style="text-align: right;">Home Work Name : &nbsp;&nbsp;</td>
                <td style="text-align: left;">{{$examtitle}}</td>
            </tr>
        </table>

            <table style="margin-top: 20px;" border="1" cellspacing="10" cellpadding="10">
                <tr align="center">
                    <th align="center">S-No.</th>
                    <th align="center">Roll No.</th>
                    <th align="center">Name</th>
                    <th align="center">Marks Scored</th>
                    <th align="center">Total Marks</th>
                    <th align="center">Percentage (%)</th>
                </tr>
                @php($mm=1)
                @foreach($stud_data as $kk => $stinfo)
                    @php($kk++)
                    <tr>
                        <td>{{$kk}}</td>
                        <td>{{$stinfo[0]}}</td>
                        <td>{{$stinfo[1]}}</td>
                        <td>{{$stinfo[2]}}</td>
                        <td>{{$stinfo[3]}}</td>
                        <td>
                            @php($percen = $stinfo[2]/$stinfo[3] * 100)
                            {{ str_replace(".00", "", number_format($percen, 2)) }}
                        </td>
                    </tr>
                @endforeach
            </table>


            <table border="0" cellspacing="30" cellpadding="30">
                <tr>
                    <td width="30%" align="center">
                        <input type="button" value="Back" onClick="javascript:history.go(-1);">
                    </td>
                    <td width="30%" align="center">
                        <button type="submit" class="btn btn-primary">Export PDF</button>
                    </td>
                    <td width="30%" align="center">
                        <button type="submit" class="btn btn-primary">Report Send Parent</button>
                    </td>
                </tr>
            </table>

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

</script>
@endpush
