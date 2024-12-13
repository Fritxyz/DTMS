<html lang="en"
    class="wf-publicsans-n3-active wf-publicsans-n4-active wf-publicsans-n5-active wf-publicsans-n6-active wf-publicsans-n7-active wf-fontawesome5solid-n4-active wf-fontawesome5regular-n4-active wf-fontawesome5brands-n4-active wf-simplelineicons-n4-active wf-active">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Register</title>
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




    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/plugins.min.css">
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css">
</head>

<body class="login bg-primary">
    <div class="wrapper wrapper-login">

        <div class="container container-login animated fadeIn" style="display: block;">
            <?= session()->getFlashdata('message') ?>
            <?= session()->getFlashdata('error') ?>
            <?= validation_list_errors() ?>
            <form method="POST" action="/authenticate/register">
                <?= csrf_field() ?>

                <div class="form-floating form-floating-custom mb-3">
                    <input id="first_name" name="first_name" type="text" class="form-control" placeholder="first_name"
                        required>
                    <label for="first_name">First Name</label>
                </div>

                <div class="form-floating form-floating-custom mb-3">
                    <input id="last_name" name="last_name" type="text" class="form-control" placeholder="last_name"
                        required>
                    <label for="last_name">Last Name</label>
                </div>

                <div class="form-floating form-floating-custom mb-3">
                    <input id="username" name="username" type="text" class="form-control" placeholder="lastname"
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

                <select class="form-control input-square" id="role" name="role">
                    <option>Admin</option>
                    <option>Researcher</option>
                </select>

                <div class="text-center mt-3">
                    <p>Already have an account? <a href="/" class="text-primary">Login here</a></p>
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



</body>

</html>