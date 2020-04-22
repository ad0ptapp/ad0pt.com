<?php
    require_once("../inc/account.php");
    
    if(is_logged_in()) {
        header("Location: index.php");
        echo 'Redirecting you to the dashboard, click <a href="index.php">here</a> if you are not automatically redirected.';
        exit;
    }

    if(isset($_POST['email']) && isset($_POST['password'])) {
        $msg = try_register($_POST['email'], $_POST['password']);
        if(is_null($msg)) {
          header("Location: index.php");
          echo 'Successfully Registered, redirecting you to your dashboard. Click <a href="index.php">here</a> if you are not automatically redirected.';
          exit;
		}
    }
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <title>ad0pt - Create an Account</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSS -->
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    />

    <!-- Favicon -->

    <!-- Fonts -->
    <link
      href="https://fonts.googleapis.com/css?family=Titillium+Web&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <div class="container">
      <img src="images/logo_red_circle.png" alt="ad0pt Logo" class="logo" />
      <form id="form" class="form" action="" method="post">
        <h2>Register With ad0pt</h2>
        <?php if(isset($msg)) echo "<div style='color:#f00;width:100%;text-align:center;'>$msg</div>";?>
        <div class="form-control">
          <label for="email">Email</label>
          <input id="email" name="email" type="text" placeholder="Enter email" />
          <small>Error message</small>
        </div>
        <div class="form-control">
          <label for="password">Password</label>
          <input id="password" name="password" type="password" placeholder="Enter password" />
          <small>Error message</small>
        </div>
        <div class="form-control">
          <label for="password2">Confirm Password</label>
          <input
            id="password2"
            type="password"
            placeholder="Enter password again"
          />
          <small>Error message</small>
        </div>
        <button id="submitbtn" type="submit">Submit</button>
      </form>
    </div>
    <div class="nav">
      <ul class="navl">
        <li><a href="account_creation.php">PROFILE</a></li>
        <li><a href="index.php">FEATURED</a></li>
        <li><a href="">ABOUT</a></li>
      </ul>
    </div>
    <!--[if IE]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->
    <script src="js/vendor/modernizr-3.8.0.min.js"></script>
    <script
      src="https://code.jquery.com/jquery-3.4.1.min.js"
      integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
      crossorigin="anonymous"
    ></script>
    <script>
      window.jQuery ||
        document.write(
          '<script src="js/vendor/jquery-3.4.1.min.js"><\/script>'
        );
    </script>
    <script src="js/plugins.js" ></script>
    <script src="js/account_creation.js"></script>

  </body>
</html>
