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

    iframe {
            margin: 0px;
            padding: 0px;
            height: 100%;
            border: none;
        }

    iframe {
        display: block;
        width: 100%;
        border: none;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .nav {
        width: 100%;
        text-align: left;
    }
 </style>
@endpush

@section('content')

@php
    //echo "<pre>";
    //print_r($classlist);
    //print_r($qnbanks);
    //echo "</pre>";
    //exit;
@endphp

<div class="row">
  <div class="col-xl-10 main-content pl-xl-4 pr-xl-5">
    <h3 class="page-title">Question Bank Viewer</h3>
    <p class="lead space-below">List of Classes</p>


<div class="row">
  <div class="col-5 col-md-3">
    <div class="nav nav-tabs nav-tabs-vertical" id="v-tab" role="tablist" aria-orientation="vertical">
    @foreach($classlist as $clist)
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
        @foreach($classlist as $clist)
	    @if ($loop->first)
        <div class="tab-pane fade show active" id="v-{{strtolower(str_replace(' ', '', $clist->class))}}" role="tabpanel" aria-labelledby="v-{{strtolower(str_replace(' ', '', $clist->class))}}-tab">
            <h4 class="mb-1">{{$clist->class}} - Class</h4>
            @foreach($qnbanks[$clist->id] as $chap)
                </br>
                    <a href="#myModal" alt="storage/quebank/{{$chap->file_path}}" class="btn btn-primary geturl" data-toggle="modal">{{$chap->title}}</a>
                </br>
            @endforeach
        </div>
        @else
        <div class="tab-pane fade" id="v-{{strtolower(str_replace(' ', '', $clist->class))}}" role="tabpanel" aria-labelledby="v-{{strtolower(str_replace(' ', '', $clist->class))}}-tab">
            <h4 class="mb-1">{{$clist->class}} - List of Question Banks</h4>
            @foreach($qnbanks[$clist->id] as $chap)
            </br>
                <a href="#myModal" alt="storage/quebank/{{$chap->file_path}}" id="get-heading" class="btn btn-primary geturl" data-toggle="modal">{{$chap->title}}</a>
            </br>
            @endforeach
        </div>
        @endif
        @endforeach
        </div>
    </div>
    </div>


<div class="bs-example">
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" style="color:white;">&times;</button>
                    <h6 id="video-title"></h6>
                </div>
                <div class="modal-body">
                  <div class="embed-responsive embed-responsive-16by9">
                    <iframe id="cartoonVideo" class="iframe2" width="100%" height="500" allowfullscreen webkitallowfullscreen frameborder="0"
            marginheight="0" marginwidth="0" width="100%" height="100%" scrolling="auto"></iframe>
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
            var altvalue = $(this).attr("alt");
            var a1_text = $(this).text();

                $("#myModal").on('hide.bs.modal', function(){
                    $("#cartoonVideo").attr('src', '');
                });

                $("#myModal").on('show.bs.modal', function(){
                    $("#video-title").text(a1_text);
                    $("#cartoonVideo").attr('src', altvalue);
                });
        });



    });

</script>
@endpush

