<html lang="en"
    class="wf-publicsans-n3-active wf-publicsans-n4-active wf-publicsans-n5-active wf-publicsans-n6-active wf-publicsans-n7-active wf-fontawesome5solid-n4-active wf-fontawesome5regular-n4-active wf-fontawesome5brands-n4-active wf-simplelineicons-n4-active wf-active">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport">
    <link rel="icon" href="assets/img/kaiadmin/favicon.ico" type="image/x-icon">

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Public+Sans:300,400,500,600,700" media="all">
    <link rel="stylesheet" href="assets/css/fonts.min.css" media="all">
    <script>
    WebFont.load({
        google: {
            "families": ["Public Sans:300,400,500,600,700"]
        },
        custom: {
            "families": ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                "simple-line-icons"
            ],
            urls: ['assets/css/fonts.min.css']
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/plugins.min.css">
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css">
</head>

<body class="login bg-primary">
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn" style="display: block;">
            <form method="POST" action="/authenticate/login">
                <?= csrf_field() ?>
                <div class="form-floating form-floating-custom mb-3">
                    <input id="username" name="username" type="text" class="form-control" placeholder="username"
                        required>
                    <label for="username">Username</label>
                </div>

                <div class="form-floating form-floating-custom mb-3">
                    <input id="password" name="password" type="password" class="form-control" placeholder="password"
                        required>
                    <label for="password">Password</label>
                    <div class="show-password">
                        <i class="icon-eye"></i>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="/register" class="text-primary">Register here</a></p>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 btn-login">Sign In</button>
            </form>

            
        </div>
    </div>
    </div>
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>

    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/kaiadmin.min.js"></script>


    <script>
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                title: 'Success!',
                text: '<?= session()->getFlashdata('success') ?>',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            Swal.fire({
                title: 'Error!',
                text: '<?= session()->getFlashdata('error') ?>',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>
    </script>
</body>

</html>