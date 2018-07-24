<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Applicator - Admin Dashboard Template</title>

        <!-- Favicon -->
        <link rel="apple-touch-icon" href="assets/images/logo/apple-touch-icon.html">
        <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}">

        <!-- core dependcies css -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/dist/css/bootstrap.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/PACE/themes/blue/pace-theme-minimal.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/perfect-scrollbar/css/perfect-scrollbar.min.css') }}" />

        <!-- page css -->

        <!-- core css -->
        <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/themify-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/materialdesignicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    </head>

    <body>
        <div class="app">
            <div class="layout bg-gradient-info">
                <div class="container">
                    <div class="row full-height align-items-center">
                        <div class="col-md-5 mx-auto">
                            <div id="msg"></div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="p-15">
                                        <div class="m-b-30">
                                            <img class="img-responsive inline-block" src="{{ asset('assets/images/logo/logo.png') }}" alt="">
                                            <h2 class="inline-block pull-right m-v-0 p-t-15">Login</h2>
                                        </div>
                                        <p class="m-t-15 font-size-13">Please enter your user name and password to login</p>
                                        <form id="loginAction">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="User name">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                            </div>
                                            <div class="checkbox font-size-13 d-inline-block p-v-0 m-v-0">
                                                <input id="agreement" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                                       <label for="agreement">Keep Me Signed In</label>
                                            </div>
                                            <div class="pull-right">
                                                <a href="{{ route('password.request') }}">Forgot Password?</a>
                                            </div>
                                            <div class="m-t-20 text-right">
                                                <button class="btn btn-gradient-success" style="width: 110px; line-height: 21px">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/js/vendor.js') }}"></script>
        <script src="{{ asset('assets/js/app.min.js') }}"></script>

        <script>

$(document).on("submit", "#loginAction", function (e) {
    $(".btn-gradient-success").attr("disabled", true);
    $(".btn-gradient-success").html('<i class="fa fa-spinner fa-spin" style="font-size: 18px"></i>');
    $.ajax({
        type: "POST",
        url: '/loginAction',
        data: $("#loginAction").serialize(),
        dataType: "json",
        success: function (response) {
            if (response.status == 'success') {
                $('#msg').html('<div class="alert alert-success alert-dismissible"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + response.msg + '</div>');
                setTimeout(function () {
                    $(".btn-gradient-success").html('Login');
                    window.location.href = response.url;
                }, 1500);
            } else {
                $(".btn-gradient-success").attr("disabled", false);
                $(".btn-gradient-success").html('Login');
                $('#msg').html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + response.msg + '</div>');
            }
        }
    });
    e.preventDefault();
});
        </script>

    </body>
</html>