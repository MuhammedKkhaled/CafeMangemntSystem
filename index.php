<?php
session_start();


if (isset($_SESSION['username'])) {
  header("Location: UserDashboard.php");
  exit();
}

/// required functions 
require_once "DB/db_config.php";
require_once "Functions/clearInput.php";


// Begin Script 
$nameError = $passwordError = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  if (empty($_POST['username'])) {
    $nameError = "برجاء كتابة اسم المستخدم ";
  }

  if (empty($_POST['password'])) {
    $passwordError = "برجاء كتابة الرقم السري ";
  }

  if (!empty($_POST['username']) && !empty($_POST["password"])) {

    $username = $_POST['username'];

    $password = hash("md5", $_POST['password']);

    /// Get Data From 
    $query = "SELECT * FROM `users` WHERE `username` = '$username' AND `is_active` = 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
      /// check if user exist 
      if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashedPasswordFromDB = $row['password'];

        /// If Passwords matches , user is authenticated 
        if ($hashedPasswordFromDB != $password) {
          $loginErorr = "مبندخلش كدا والله ياصحبي ";
        } else {
          /// If User Is admin so $_SESSION['Is_admin'] -> 1 otherwise = 0
          $_SESSION['is_admin'] = $row['is_admin'];
          $_SESSION['username'] = $row['username'];
          $_SESSION['user_id'] = $row['id'];
          header("Location: UserDashboard.php");
          exit();
        }
      } else {
        $loginErorr = "هذا المستخدم غير موجود ";
      }
      mysqli_free_result($result);
    } else {
      die("Query failed: " . mysqli_error($conn));
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title> تسجيل الدخول </title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

  <!-- Custom styles for this template-->
  <!-- <link href="css/sb-admin-2.min.css" rel="stylesheet" /> -->
  <link href="css/rtl.css" rel="stylesheet" />
</head>

<body class="bg-gradient-primary">
  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image">
                <img src="img/istockphoto-1174818077-612x612.jpg" width="450px" height="650px" />
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">
                      Masr Solutions Company
                    </h1>
                  </div>
                  <form class="user" method="post" action="<?= trim(htmlspecialchars($_SERVER["PHP_SELF"])) ?>">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="اسم المستخدم " name="username" autocomplete="off" />
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="الرقم السري" name="password" />
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block" id="loginclick"> تسجيل الدخول </button>
                  </form>
                  <hr />
                  <?php if (!empty($loginErorr)) : ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <strong>هولي شيت </strong> <span class="alert-message"><?= $loginError ?></span>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <?php

  if (isset($loginErorr)) {
    echo '<script>
            $(document).ready(function() {
                $(".alert").show();
                $(".alert-message").html("' . $loginErorr . '");
            });
        </script>';
  }

  ?>

  <script>
    $('#loginclick').click(function() {
      alert('اهلا بك يابن عمي خش هتجيبك ');
    });
  </script>

</body>

</html>