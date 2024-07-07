<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>KabKota Login</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css" />
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css" />
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <!--/login-logo -->
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
          <a href="index.php" class="h1"><b>KabKota</b>App</a>
        </div>
        <div class="card-body">
          <p class="login-box-msg">Silahkan login untuk mengelola data</p>
          <form id="loginForm" action="../../proses/user/proses_login.php" method="post">
            <div class="input-group mb-3">
              <input type="email" class="form-control" placeholder="Email" id="email" name="email" required />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fa fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="Password" id="password" name="password" required minlength="6" />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fa fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember" name="remember" />
                  <label for="remember">Ingatkan saya</label>
                </div>
              </div>
              <!--/.col -->
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Masuk</button>
              </div>
              <!--/.col -->
            </div>
          </form>
        </div>
        <!--/.card-body-->
      </div>
      <!--/.card -->
    </div>
    <!--/.login-box -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- jQuery Validation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!--AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>

    <script>
      $(document).ready(function () {
        $("#loginForm").validate({
          rules: {
            email: {
              required: true,
              email: true
            },
            password: {
              required: true,
              minlength: 6
            }
          },
          messages: {
            email: {
              required: "Harap masukkan email",
              email: "Harap masukkan email yang valid"
            },
            password: {
              required: "Harap masukkan password",
              minlength: "Password harus terdiri dari minimal 6 karakter"
            }
          },
          errorElement: "div",
          errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            if (element.prop("type") === "checkbox") {
              error.insertAfter(element.next("label"));
            } else {
              error.insertAfter(element);
            }
          },
          highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
          },
          unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
          }
        });

        // Check if the user is remembered
        if (getCookie("rememberMe") === "true") {
          window.location.href = "mainPage.php"; // Redirect to the main page
        }

        $("#loginForm").on("submit", function (e) {
          e.preventDefault();
          if ($("#loginForm").valid()) {
            var rememberMe = $("#remember").is(":checked");
            if (rememberMe) {
              setCookie("rememberMe", "true", 1); // Set cookie for 1 hour
            } else {
              setCookie("rememberMe", "false", 1); // Set cookie for 1 hour
            }
            // Perform login
            this.submit();
          }
        });

        function setCookie(name, value, hours) {
          var date = new Date();
          date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
          var expires = "expires=" + date.toUTCString();
          document.cookie = name + "=" + value + ";" + expires + ";path=/";
        }

        function getCookie(name) {
          var nameEQ = name + "=";
          var ca = document.cookie.split(';');
          for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
          }
          return null;
        }
      });
    </script>
  </body>
</html>
