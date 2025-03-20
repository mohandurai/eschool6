@extends('layout.master2')

@section('content')

@php
    $agent = new \Jenssegers\Agent\Agent();
@endphp

<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">
      <div class="card">
        <div class="row">
          <div class="col-md-4 pr-md-0">
            @if($agent->isMobile())
                <div class="auth-left-wrapper" style="text-align:center;"><img  src="{{URL::asset('assets/images/image3_horizon.png')}}" title="New User Registration" width="100%" height="80%">
            @else
                <div class="auth-left-wrapper" style="text-align:center;"><img  src="{{URL::asset('assets/images/image3.png')}}" title="New User Registration" width="220" height="600">
            @endif
            </div>
          </div>
          <div class="col-md-8 pl-md-0">
        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
        @endif
            <div class="auth-form-wrapper px-4 py-5">
              @if($agent->isMobile())
              <a href="#" class="noble-ui-logo logo-light d-block mb-2"><h2>e-School</h2></span></a>
              @else
              <br><br><br>
              <a href="#" class="noble-ui-logo logo-light d-block mb-2"><h2>e-School</h2></span></a>
              @endif
              <h5 class="text-muted font-weight-normal mb-4">Knowledge is Wealth.</h5>

              <form class="form-sample" method="POST" action="{{ url('logincheck') }}">
                {{ csrf_field() }}
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" name="password" class="form-control" id="exampleInputPassword1" autocomplete="current-password" placeholder="Password">
                </div>
                <div class="form-check form-check-flat form-check-primary">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input">
                    Remember me
                  </label>
                </div>
                <div class="mt-3">

                  <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>
                    </div>
                    </br>
                  <!-- <button type="button" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="twitter"></i>
                    Login with twitter
                  </button> -->
                </div>
                <a href="{{ url('/auth/register') }}" class="d-block mt-3 text-muted">Not a user? Sign up</a>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
