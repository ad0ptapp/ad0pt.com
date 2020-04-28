<?php
    require_once("../inc/account.php");
    require_once("class/Profile.php");
    if(!is_logged_in())
    {
        header("Location: login.html");
        echo "You must be logged in to create a profile. Redirecting you to <a href=\"login.html\">the login page</a>.";
        exit;
    }
    $prof = new Profile($_SESSION['user_id']);
    if(isset($_POST['submit'])) {
        if($prof->setCity($_POST['city']));
        $prof->setCountry("US");
        $prof->setFullName($_POST['full_name']);
        $prof->setPhoneNumber($_POST['phone_number']);
        $prof->setPostCode($_POST['post_code']);
        $prof->setState($_POST['state']);
        $prof->save();
    }
?>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <title>ad0pt - Pet Adoptions Made Friendlier</title>
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
    <form id="profile_form" class="profile_form" method="POST" action="" enctype="multipart/form-data">
      <div class="profile-container">
        <!-- USE PHP to insert link to user profile -->
        <div class="field">
          <label for="full_name">Full Name:</label>
            <?php if(isset($_POST['full_name']) && !$prof->setFullName($_POST['full_name'])) echo "<small>Invalid Full Name</small>"; ?>
          <input
            type="text"
            name="full_name"
            id="full_name"
            placeholder="Full Name"
            value="<?php echo $prof->getFullName(); ?>"
          />
        </div>
        <div class="field">
          <?php if(isset($_POST['state']) && !$prof->setState($_POST['state'])) echo "<small>Invalid State</small>";?>
          <label for="state">State:</label>
          <select name="state" id="state_dropdown">
            <option value="" disabled selected>Choose Your State</option>
            <option value="AL">Alabama</option>
            <option value="AK">Alaska</option>
            <option value="AZ">Arizona</option>
            <option value="AR">Arkansas</option>
            <option value="CA">California</option>
            <option value="CO">Colorado</option>
            <option value="CT">Connecticut</option>
            <option value="DE">Delaware</option>
            <option value="DC">District Of Columbia</option>
            <option value="FL">Florida</option>
            <option value="GA">Georgia</option>
            <option value="HI">Hawaii</option>
            <option value="ID">Idaho</option>
            <option value="IL">Illinois</option>
            <option value="IN">Indiana</option>
            <option value="IA">Iowa</option>
            <option value="KS">Kansas</option>
            <option value="KY">Kentucky</option>
            <option value="LA">Louisiana</option>
            <option value="ME">Maine</option>
            <option value="MD">Maryland</option>
            <option value="MA">Massachusetts</option>
            <option value="MI">Michigan</option>
            <option value="MN">Minnesota</option>
            <option value="MS">Mississippi</option>
            <option value="MO">Missouri</option>
            <option value="MT">Montana</option>
            <option value="NE">Nebraska</option>
            <option value="NV">Nevada</option>
            <option value="NH">New Hampshire</option>
            <option value="NJ">New Jersey</option>
            <option value="NM">New Mexico</option>
            <option value="NY">New York</option>
            <option value="NC">North Carolina</option>
            <option value="ND">North Dakota</option>
            <option value="OH">Ohio</option>
            <option value="OK">Oklahoma</option>
            <option value="OR">Oregon</option>
            <option value="PA">Pennsylvania</option>
            <option value="RI">Rhode Island</option>
            <option value="SC">South Carolina</option>
            <option value="SD">South Dakota</option>
            <option value="TN">Tennessee</option>
            <option value="TX">Texas</option>
            <option value="UT">Utah</option>
            <option value="VT">Vermont</option>
            <option value="VA">Virginia</option>
            <option value="WA">Washington</option>
            <option value="WV">West Virginia</option>
            <option value="WI">Wisconsin</option>
            <option value="WY">Wyoming</option>
          </select>

            <?php
                $state = $prof->getState();
                if(strlen($state) == 2) {
                    echo "<script>document.getElementById(\"state_dropdown\").value = \"$state\"</script>";
                }
            ?>
        </div>
        <div class="field">
            <?php if(isset($_POST['city']) && !$prof->setCity($_POST['city'])) echo "<small>Invalid City</small>";?>
            <label for="city">City:</label>
            <input
                type="text"
                name="city"
                id="city"
                placeholder="Enter Your City"
                value="<?php echo $prof->getCity();?>"
            />
        </div>
        <div class="field">
          <?php if(isset($_POST['post_code']) && !$prof->setPostCode($_POST['post_code'])) echo "<small>Invalid Postal/Zip Code</small>"; ?>
          <label for="zipcode">Postal/Zip Code:</label>
          <input
            type="text"
            name="post_code"
            id="zipcode"
            placeholder="Enter Your Zip Code"
            value="<?php echo $prof->getPostCode();?>"
          />
        </div>
          <?php if(isset($_POST['phone_number']) && !$prof->setPhoneNumber($_POST['phone_number'])) echo "<small>Invalid Phone Number</small>"; ?>
          <div class="field">
              <label for="phone_number">Phone Number:</label>
              <input
                  type="text"
                  name="phone_number"
                  id="phonenumber"
                  placeholder="Enter Your Phone Number"
                  value="<?php echo $prof->getPhoneNumber();?>"
              />
          </div>
          <?php
          if(isset($_POST['submit']) && !$prof->save()){
            echo "<small>Error saving your profile information: $prof->errno</small>";
          }
          ?>
        <button name="submit" type="submit">Create Profile</button>
      </form>
    </div>
    <div class="nav">
      <ul class="navl">
        <li><a href="create_profile.php">PROFILE</a></li>
        <li><a href="featured.html">FEATURED</a></li>
        <li><a href="about.html">ABOUT</a></li>
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
    <script src="js/plugins.js"></script>
    <script src="js/profile.js"></script>
    <script src="js/branding.js" defer></script>
  </body>
</html>