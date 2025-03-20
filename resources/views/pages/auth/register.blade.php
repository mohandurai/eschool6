@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">
      <div class="card">
        <div class="row">
          <div class="col-md-4 pr-md-0">

            <div class="auth-left-wrapper" style="text-align:center;"><img  src="{{URL::asset('assets/images/image3.png')}}" title="New User Registration" width="220" height="650">

            </div>


          </div>
          <div class="col-md-8 pl-md-0">

            <div class="auth-form-wrapper px-4 py-5">
            <div style="text-align:center;"><img  src="{{URL::asset('assets/images/register.png')}}" title="New User Registration" width="260" height="70"></div></br>
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
            @endif
            <a href="#" class="noble-ui-logo logo-light d-block mb-2"><h2>e-School</h2></span></a>
            <h5 class="text-muted font-weight-normal mb-4">Knowledge is Wealth.</h5>
              <form class="forms-sample" method="POST" action="{{ url('/user/register') }}">
              @csrf
                <div class="form-group">
                  <label for="exampleInputUsername1">Username</label>
                  <input type="text" name="name" class="form-control" id="exampleInputUsername1" autocomplete="Username" placeholder="Username">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" name="password" class="form-control" id="exampleInputPassword1" autocomplete="current-password" placeholder="Password">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Confirm Password</label>
                  <input type="password" name="password2" class="form-control" id="exampleInputPassword1" autocomplete="current-password" placeholder="Password">
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
                            Register
                        </button>
                    </div>
                    <!-- </br>
                  <button type="button" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="twitter"></i>
                    Sign up with twitter
                  </button> -->
                </div>
                <a href="{{ url('/auth/login') }}" class="d-block mt-3 text-muted">Already a user? Sign in</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
