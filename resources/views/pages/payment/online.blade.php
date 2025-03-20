@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/prismjs/prism.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
  <div class="col-xl-10 main-content pl-xl-4 pr-xl-5">
    <h3 class="page-title">Welcome to Online Payment</h3>

    <div class="table-responsive">

    <form action="{{ url('chapter/store') }}" method="post">
        {{ csrf_field() }}

            <div class="form-group">
                <label for="title">Select Class</label>
                <select class="form-control" id="class_id" name="class_id">
                    <option selected="selected" value="0">Select Class</option>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1">Select Student ID/Roll No.</label>
                <select class="form-control" id="student_id" name="student_id">
                    <option selected="selected" value="0">Select ID</option>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1">Select Student Name</label>
                <select class="form-control" id="student_name" name="student_name">
                    <option value="0">Verify Student Name</option>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1">Select Payment Method</label>
                <select class="form-control" id="pay_method" name="pay_method">
                    <option value="0">Select Method</option>
                    <option value="1">Net Banking</option>
                    <option value="2">Credit/Debit Card</option>
                    <option value="3">UPI</option>
                    <option value="4">Cash (Only through School Cash Counter)</option>
                </select>
            </div>

    </div>

<div class="net-banking" style="display:none;">

 <h5 id="fill">Enter following details:</h5>

 <div class="example">

     <div class="form-group">
         <label for="exampleFormControlSelect1">Select Bank Name</label>
         <select class="form-control" id="subject_id" name="subject_id">
             <option value="0">Select Bank</option>
             <option value="1">ICICI</option>
             <option value="2">HDFC</option>
             <option value="3">City Union Bank</option>
             <option value="4">DBS</option>
             <option value="5">SBI</option>
         </select>
     </div>
 </div>
</div>


<div class="credit-debit-card" style="display:none;">

    <center>
        <br><br><img class="img-responsive pull-right" src="{{URL::asset('assets/images/master-visa-logo2.png')}}">
    </center>
</br>
    <p class="lead">Provide your Credit/Debit card details as follows below: </p>

    <div class="alert alert-danger" role="alert">
        <i data-feather="alert-circle"></i>
            Be cautious while entering confidential Information !
        </div>

    <h4 id="default"></h4>

    <h5 id="fill">Enter following details:</h5>

    <div class="example">

        <div class='form-row'>
            <div class='col-xs-12 form-group card required'>
            <label class='control-label'>Card Number</label>
            <input autocomplete='off' class='form-control card-number' size='20' type='text' name="card_no">
            </div>
        </div>
        <div class='form-row'>
            <div class='col-xs-4 form-group cvc required'>
                <labe class='control-label'>CVV</labe>
                <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text' name="cvvNumber">
            </div>
        </div>

        <div class='form-row'>
            <div class='col-xs-4 form-group'>
                <label class='control-label'>Expiration</label>
                <input class='form-control' placeholder='MM' size='4' type='text' name="ccExpiryMonth">
            </div>
            <div class='col-xs-4 form-group'>
                <label class='control-label'>Month & Year</label>
                <input class='form-control' placeholder='YYYY' size='4' type='text' name="ccExpiryYear">
            </div>
        </div>

        <div class='form-row'>
            <div>
                <label class='control-label'>Amount :</label>
                <input class='form-control' placeholder='Fill amount' size='10' type='text' name="amount" value="0">
            </div>
        </div>

        <div class='form-row'>
            <div class='col-md-12'>
                <label class='control-label'></label>
                <button class='form-control btn btn-success' type='submit'>Pay »</button>
            </div>
        </div>
</div>



<div class="upi-payment" style="display:none;">

   <p class="lead">UPI Payment</p>

    <h5 id="fill">Enter following details:</h5>

</div>


        </form>
    </div>
    </div>

    <hr>

</div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/prismjs/prism.js') }}"></script>
  <script src="{{ asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>

  <script>

$(document).ready(function() {
    $("#pay_method option[value=0]").prop('selected', true);
});

$('#pay_method').change(function() {

        var clsid = $(this).val();
        // alert("UUUUUUUUUUU "+clsid);
        // return false;

        if(clsid == 1) {
            $('.credit-debit-card').hide();
            $('.net-banking').show();
        }
        else if(clsid == 2) {
            $('.credit-debit-card').show();
            $('.net-banking').hide();
        }

});
</script>

@endpush
