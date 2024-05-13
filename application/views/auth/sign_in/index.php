<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E - Perpus - Kabayan</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url('./assets/plugins/fontawesome-free/css/all.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('./assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('./assets/dist/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('./assets/plugins/toastr/toastr.min.css'); ?>">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <span>E - Perpus - <b>Kabayan</b></span> 
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form action="<?= base_url('auth/sign_in') ?>" method="post" class="signInForm">
                    <div class="input-group mb-3">
                        <input type="email" name="username" class="form-control" placeholder="Username" value="petugas.e-perpus@kabayan.id">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" value="perpus2024">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block btn-sign-in">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?= base_url('./assets/plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('./assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('./assets/plugins/sweetalert2/sweetalert2.min.js'); ?>"></script>
    <script src="<?= base_url('./assets/plugins/toastr/toastr.min.js'); ?>"></script>
    <script src="<?= base_url('./assets/dist/js/adminlte.min.js');?>"></script>

    <script>
    $(document).ready(function() {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $('.signInForm').submit(function(e) {
            e.preventDefault();
            var form = this;
            $('.btn-sign-in').attr('disabled', true);
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                dataType: 'JSON',
                success: function(response) {
                    if (response.code == 200) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Wait, you will be redirected to the dashboard page'
                        });
                        setTimeout(function() { 
                            $('.btn-sign-in').attr('disabled', false);
                            window.location = "<?= base_url('Dashboard') ?>";
                        }, 3000);
                    } else {
                        $('.btn-sign-in').attr('disabled', false);
                        Toast.fire({
                            icon: 'warning',
                            title: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    $('.btn-sign-in').attr('disabled', false);
                    Toast.fire({
                        icon: 'error',
                        title: error
                    });
                }      
            });
        });
    });
    </script>
</body>
</html>
