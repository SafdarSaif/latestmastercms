<!DOCTYPE html>
<?php
include '../admin/includes/db-config.php';


$query = "SELECT  Name, Logo FROM theme_settings WHERE Status = 1"; 
$result = mysqli_query($conn, $query);

$logo_url = './assets/images/default-logo.png'; 
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $logo_url = $row['Logo'];
    $name = $row['Name'];

}
?>

<html lang="en" class="light-style layout-wide  customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="./assets/" data-template="vertical-menu-template" data-style="light">



<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Forgot Password  | <?= $name; ?></title>


  <meta name="description" content="<?= $name; ?>" />
  <meta name="keywords" content="<?= $name; ?>">
  <!-- Canonical SEO -->
  <link rel="canonical" href="https://1.envato.market/vuexy_admin">


  <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        '../../../../www.googletagmanager.com/gtm5445.html?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-5J3LMKC');
  </script>
  <!-- End Google Tag Manager -->

  <!-- Favicon -->
  <!-- <link rel="icon" type="image/x-icon" href="https://demos.pixinvent.com/vuexy-html-admin-template/assets/img/favicon/favicon.ico" /> -->
  <link rel="icon" type="image/x-icon" href="/admin/<?= $logo_url; ?>" />


  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;ampdisplay=swap" rel="stylesheet">

  <!-- Icons -->
  <link rel="stylesheet" href="./assets/vendor/fonts/fontawesome.css" />
  <link rel="stylesheet" href="./assets/vendor/fonts/tabler-icons.css" />
  <link rel="stylesheet" href="./assets/vendor/fonts/flag-icons.css" />

  <!-- Core CSS -->

  <link rel="stylesheet" href="./assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="./assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />

  <link rel="stylesheet" href="./assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="./assets/vendor/libs/node-waves/node-waves.css" />

  <link rel="stylesheet" href="./assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="./assets/vendor/libs/typeahead-js/typeahead.css" />
  <!-- Vendor -->
  <link rel="stylesheet" href="./assets/vendor/libs/%40form-validation/form-validation.css" />

  <!-- Page CSS -->
  <!-- Page -->
  <link rel="stylesheet" href="./assets/vendor/css/pages/page-auth.css">
  <link rel="stylesheet" href="./assets/vendor/libs/toastr/toastr.css" />


  <!-- Helpers -->
  <script src="./assets/vendor/js/helpers.js"></script>
  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

  <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
  <script src="./assets/vendor/js/template-customizer.js"></script>

  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="./assets/js/config.js"></script>

  <style>
    .spinner-border {
      width: 3rem;
      height: 3rem;
    }

    #loadingMessage {
      display: none;
      text-align: center;
      margin-top: 20px;
    }

    #loadingMessage p {
      margin-top: 10px;
    }
  </style>

</head>

<body>


  <!-- ?PROD Only: Google Tag Manager (noscript) (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5J3LMKC" height="0" width="0" style="display: none; visibility: hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <!-- Content -->

  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-6">
        <!-- Forgot Password -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center mb-6">
              <a href="" class="app-brand-link">
                <!-- <span class="app-brand-logo demo"> -->
                  <!-- <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="#7367F0" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z" fill="#7367F0" />
                  </svg> -->
                  <span class="">
                  <img src="/admin/<?= $logo_url; ?>" alt="Logo" class="app-brand-logo" style="max-height: 100px;">

                </span>
                <!-- <span class="app-brand-text demo text-heading fw-bold">Vuexy</span> -->
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-1">Forgot Password? 🔒</h4>
            <p class="mb-6">Enter your email and we'll send you instructions to reset your password</p>
            <form id="form-forgot-password" class="mb-6" action="app/login/forgot-password" method="POST">
              <div class="mb-6">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" autofocus>
              </div>
              <button type="submit" class="btn btn-primary d-grid w-100">Send Reset Link</button>
              <div id="loadingMessage">
                <div class="spinner-border text-primary" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
                <p>Sending email, please wait...</p>
              </div>
            </form>
            <div class="text-center">
              <a href="login" class="d-flex justify-content-center">
                <i class="ti ti-chevron-left scaleX-n1-rtl me-1_5"></i>
                Back to login
              </a>
            </div>
          </div>
        </div>
        <!-- /Forgot Password -->
      </div>
    </div>
  </div>

  <!-- / Content -->


  <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="successModalLabel">Password Reset Email Sent</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>A password reset email has been sent to your email address. Please check your inbox and follow the instructions to reset your password.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal" id="modalCloseButton">Password Reset</button>
        </div>
      </div>
    </div>
  </div>




  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->

  <script src="./assets/vendor/libs/jquery/jquery.js"></script>
  <script src="./assets/vendor/libs/popper/popper.js"></script>
  <script src="./assets/vendor/js/bootstrap.js"></script>
  <script src="./assets/vendor/libs/node-waves/node-waves.js"></script>
  <script src="./assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="./assets/vendor/libs/hammer/hammer.js"></script>
  <script src="./assets/vendor/libs/i18n/i18n.js"></script>
  <script src="./assets/vendor/libs/typeahead-js/typeahead.js"></script>
  <script src="./assets/vendor/js/menu.js"></script>

  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="./assets/vendor/libs/%40form-validation/popular.js"></script>
  <script src="./assets/vendor/libs/%40form-validation/bootstrap5.js"></script>
  <script src="./assets/vendor/libs/%40form-validation/auto-focus.js"></script>

  <!-- Main JS -->
  <script src="./assets/js/main.js"></script>


  <!-- Page JS -->
  <script src="./assets/js/pages-auth.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

  <script src="./assets/vendor/libs/toastr/toastr.js"></script>

  <script>
    $(document).ready(function() {
      $("#form-forgot-password").on("submit", function(e) {
        e.preventDefault();

        $("#loadingMessage").show();

        var formData = new FormData(this);

        $.ajax({
          url: this.action,
          type: 'post',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function(data) {
            $("#loadingMessage").hide();
            console.log(data);
            if (data.status == 200) {
              toastr.success(data.message);
              $('#successModal').modal('show');
              $('#form-forgot-password')[0].reset();
              $('#successModal').on('hidden.bs.modal', function() {
                window.location.href = data.url;
              });
            } else {
              toastr.error(data.message);
            }
          },
          error: function(xhr, status, error) {
            $("#loadingMessage").hide();
            toastr.error('An error occurred while processing your request. Please try again later.');
          }
        });
      });


      $('#modalCloseButton').on('click', function() {
        $('#successModal').modal('hide');
      });
    });
  </script>

</body>


<!-- Mirrored from demos.pixinvent.com/vuexy-html-admin-template/html/vertical-menu-template/auth-forgot-password-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 27 Aug 2024 07:19:03 GMT -->

</html>

<!-- beautify ignore:end -->