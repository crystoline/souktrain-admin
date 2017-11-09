
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from hencework.com/theme/philbert/full-width-light/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 06 Oct 2017 10:15:55 GMT -->
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title> {{ env('APP_NAME') }} :: Admin Login</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- vector map CSS -->
    <link href="{{ asset('admin/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Custom CSS -->
    <link href="{{ asset('admin/dist/css/style.css') }}" rel="stylesheet" type="text/css">
</head>
<body>{{--
<!--Preloader-->
<div class="preloader-it">
    <div class="la-anim-1"></div>
</div>
<!--/Preloader-->--}}

<div class="wrapper pa-0">

    <!-- Main Content -->
    <div class="page-wrapper pa-0 ma-0 auth-page">
        <div class="container-fluid">
            <!-- Row -->
            <div class="table-struct full-width full-height">
                <div class="table-cell vertical-align-middle auth-form-wrap">
                    <div class="auth-form  ml-auto mr-auto no-float">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="mb-30">
                                    <h3 class="text-center txt-dark mb-10">Sign in to {{ env('APP_NAME') }} Admin Login</h3>
                                    <h6 class="text-center nonecase-font txt-grey">Enter your details below</h6>
                                </div>
                                <div class="form-wrap">
                                    <form action="{{ route('admin.login.post') }}" method="post" autocomplete="off">
                                        {{ csrf_field() }}
                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label class="control-label mb-10" for="email">Email address</label>
                                            <input type="email" name="email" class="form-control" required id="email" placeholder="Enter email" value="{{ old('email') }}">
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label class="pull-left control-label mb-10" for="password">Password</label>
                                            <a class="capitalize-font txt-primary block mb-10 pull-right font-12" href="{{ route('password.request') }}">forgot password ?</a>
                                            <div class="clearfix"></div>
                                            <input type="password" class="form-control" name="password" required id="password" placeholder="Enter password">

                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <div class="checkbox checkbox-primary pr-10 pull-left">
                                                <input id="remember" name="remember" {{ old('remember') ? 'checked' : '' }} type="checkbox">
                                                <label for="remember"> Keep me logged in</label>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-info btn-success btn-rounded">Sign in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Row -->
        </div>

    </div>
    <!-- /Main Content -->

</div>
<!-- /#wrapper -->

<!-- JavaScript -->

<!-- jQuery -->
<script src="{{ asset('admin/vendors/bower_components/jquery/dist/jquery.min.js') }}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('admin/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js') }}"></script>

</body>

</html>
