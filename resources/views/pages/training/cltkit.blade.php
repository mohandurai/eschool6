@extends('layout.master')

<meta name="csrf-token" content="{{ csrf_token() }}">

@push('plugin-styles')
 <link href="{{ asset('assets/plugins/prismjs/prism.css') }}" rel="stylesheet" />
 <style type="text/css">
    .space-below {
      margin-bottom: 10;
    }
    .mb-1 {
        color: blue;
    }
    .bs-example{
    	margin: 20px;
    }
    .modal-dialog iframe{
        margin: 0 auto;
        display: block;
    }
    .nav {
        width: 100%;
        text-align: left;
    }
 </style>
@endpush

@section('content')
<div class="row">
    @php
        //echo "<pre>";
        //print_r($chapters);
        //echo "</pre>";
    @endphp
  <div class="col-xl-10 main-content pl-xl-4 pr-xl-5">
    <h3 class="page-title">Computer Lab Tutor</h3>
    <p class="lead space-below">List of Classes</p>


<div class="row">
  <div class="col-5 col-md-3">
    <div class="nav nav-tabs nav-tabs-vertical" id="v-tab" role="tablist" aria-orientation="vertical">
    @foreach($cltlist as $clist)
	@if ($loop->first)
        <a class="nav-link active" id="v-{{strtolower(str_replace(' ', '', $clist->class))}}-tab" data-toggle="pill" href="#v-{{strtolower(str_replace(' ', '', $clist->class))}}" role="tab" aria-controls="v-{{strtolower(str_replace(' ', '', $clist->class))}}" aria-selected="true">{{$clist->class}}</a>
    @else
        <a class="nav-link" id="v-{{strtolower(str_replace(' ', '', $clist->class))}}-tab" data-toggle="pill" href="#v-{{strtolower(str_replace(' ', '', $clist->class))}}" role="tab" aria-controls="v-{{strtolower(str_replace(' ', '', $clist->class))}}" aria-selected="false">{{$clist->class}}</a>
    @endif
	@endforeach
    </div>
  </div>
    <div class="col-7 col-md-9">
        <div class="tab-content tab-content-vertical border p-3" id="v-tabContent">
        @foreach($cltlist as $clist)
	    @if ($loop->first)
        <div class="tab-pane fade show active" id="v-{{strtolower(str_replace(' ', '', $clist->class))}}" role="tabpanel" aria-labelledby="v-{{strtolower(str_replace(' ', '', $clist->class))}}-tab">
            <h4 class="mb-1">{{$clist->class}} - Chapters List</h4>
            @foreach($chapters[$clist->id] as $chap)
                <!-- <ul class="list-group">
                    <li class="list-group-item">{{$chap->title}}</li>
                </ul> -->
                </br>
                    <a href="#myModal" alt="storage/videos/{{$chap->file_path}}" class="btn btn-primary geturl" data-toggle="modal">{{$chap->title}}</a>
                </br>
            @endforeach
        </div>
        @else
        <div class="tab-pane fade" id="v-{{strtolower(str_replace(' ', '', $clist->class))}}" role="tabpanel" aria-labelledby="v-{{strtolower(str_replace(' ', '', $clist->class))}}-tab">
            <h4 class="mb-1">{{$clist->class}} - Chapters List</h4>
            @foreach($chapters[$clist->id] as $chap)
            <!-- <ul class="list-group">
                <li class="list-group-item">{{$chap->title}}</li>
            </ul> -->
            </br>
                <a href="#myModal" alt="storage/videos/{{$chap->file_path}}" class="btn btn-primary geturl" data-toggle="modal">{{$chap->title}}</a>
            </br>
            @endforeach
        </div>
        @endif
        @endforeach
        </div>
    </div>
    </div>


<div class="bs-example">
    <!-- Button HTML (to Trigger Modal) -->
    <!-- <a href="#myModal" class="btn btn-primary btn-lg" data-toggle="modal">Launch Demo Modal</a> -->

    <!-- Modal HTML -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" style="color:white;">&times;</button>
                </div>
                <div class="modal-body">
                  <div class="embed-responsive embed-responsive-16by9">
                    <iframe id="cartoonVideo" class="embed-responsive-item" width="560" height="315"  allowfullscreen></iframe>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>


</div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/prismjs/prism.js') }}"></script>
  <script src="{{ asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(document).ready(function() {
        // alert("Settings page was loaded");
        // return false;
        $(".list-group-item").click(function() {
              var listItems = $(".list-group-item");
              for (let i = 0; i < listItems.length; i++) {
                  listItems[i].classList.remove("active");
              }
              this.classList.add("active");
        });

        $(".geturl").click(function()
        {
            var altvalue = $(this).attr("alt")
            // alert(altvalue);
            // return false;

                // var url = altvalue;

                $("#myModal").on('hide.bs.modal', function(){
                    $("#cartoonVideo").attr('src', '');
                });

                $("#myModal").on('show.bs.modal', function(){
                    $("#cartoonVideo").attr('src', altvalue);
                });
        });



    });

</script>
@endpush

