<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Admin Management | Đăng nhập</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/admin/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/assets/admin/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/admin/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/assets/admin/plugins/iCheck/square/blue.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="/assets/admin/dist/css/my-css.css">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
        .login-page {
            background-image: url('/assets/admin/dist/img/login.jpg');
            background-size: contain;
        }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <b style="color: white">Admin Management</b>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Đăng nhập</p>
        <form method="POST" action="{{ route('admin.login') }}" id="login-form">
            @csrf
            <div class="form-group has-feedback">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <input type="text" name="email"  value="{{ old('email') }}" class="form-control" placeholder="Email">
            </div>
            <div class="form-group has-feedback">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <input type="password" value="{{ old('password') }}" name="password" class="form-control" placeholder="Mật khẩu">
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember_me" {{ old('remember_me') ? 'checked' : ''}}> Nhớ tôi
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="/assets/admin/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/assets/admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/assets/admin/dist/js/jquery.validate.min.js"></script>
<!-- iCheck -->
<script src="/assets/admin/plugins/iCheck/icheck.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });

    $(document).ready(function() {
        if ("{{ session()->has('success_message') }}") {
            toastr.success("{{ session()->get('success_message') }}", 'Thành công')
        }

        if ("{{ session()->has('error_message') }}") {
            toastr.error("{{ session()->get('error_message') }}", 'Lỗi')
        }
    });


    $(function() {
        $("#login-form").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    maxlength: 255,
                },
                password: {
                    required: true,
                    maxlength: 20,
                    minlength: 6,
                }
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            messages: {
                email: {
                    required: "Email không được rỗng.",
                    email: "Phải là một email.",
                    maxlength: "Email không được lớn hơn 255 ký tự",
                },
                password: {
                    required: "Mật khẩu không được rỗng.",
                    minlength: "Mật khẩu không được nhỏ hơn 6 ký tự.",
                    maxlength: "Mật khẩu không được lớn hơn 20 ký tự.",
                }
            }
        });
    });
</script>
</body>
</html>
