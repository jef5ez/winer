<head>
    <link rel="stylesheet" type="text/css" href="stylesheets/winer.css" />
    <meta charset="utf-8" />
    <title>Winer: Are you a Winer?-sign up</title>

    <!--[if IE]> 
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]--> 
    <!--[if lte IE 7]> 
      <script src="js/IE8.js" type="text/javascript"></script>
    <![endif]--> 
    <!--[if lt IE 7]>  
      <link rel="stylesheet" type="text/css" media="all" href="css/ie6.css"/>
    <![endif]-->
</head>
<body>
  <header id="banner" class="body"> 
      <h1>
        <a href="#">Winer: <strong>Are you a Winer?</strong></a>
      </h1>  
      <nav>
        <ul> 
          <li><a href="index.php">home</a></li> 
          <li><a href="offerings.php">offerings</a></li>  
          <li><a href="blog.php">blog</a></li> 
          <li><a href="sign_up.php">sign up</a></li>
          <li><a href="login.php">login</a></li>
          <li><a href="contact.php">contact</a></li> 
        </ul>
      </nav>  
    </header>
    <div id="container" class = "body">
      <section id="content" class="body">  

  <?php
//connects to the database

mysql_connect("localhost", "root", "root") or die(mysql_error()); 


mysql_select_db("jef5ez_winer") or die(mysql_error()); 

 //This code runs if the form has been submitted

if (isset($_POST['submit'])) { 
  
  //  //This makes sure they did not leave any fields blank
  if (!$_POST['username'] | !$_POST['pass'] | !$_POST['pass2'] | !$_POST['name'] | !$_POST['email']) {
    die('You did not complete all of the     required fields');
  }
   // checks if the username is in use
  $name= mysql_real_escape_string($_POST['name']);
  $email= mysql_real_escape_string($_POST['email']);
  $user= mysql_real_escape_string($_POST['username']);
  $check = mysql_query("SELECT username FROM users WHERE username = '$user'") 
   or die(mysql_error());
  $check2 = mysql_num_rows($check);

   //if the name exists it gives an error

  if ($check2 != 0) {
   die('Sorry, the username '.$user.' is already in use.');
  } 
   //                 this makes sure both passwords entered match
   //
  if ($_POST['pass'] != $_POST['pass2']) {
    die('Your passwords did not match. ');

  }
  // here we encrypt they password and add slashes if needed
  define('SALT_LENGTH', 9);

  $salt = substr(sha1(uniqid(rand(), true)), 0, SALT_LENGTH);

  //$_POST['salt'] = $salt
  
  //  $_POST['pass'] 
  $hash= $salt . sha1($salt.$_POST['pass']);


   // now we insert it into the database

  $insert = "INSERT INTO users (username, name, email, salt, password) VALUES ('".$user."', '".$name."', '".$email."', '".$salt."', '".$hash."')";
  $add_member = mysql_query($insert);
?>



<h1>Registered</h1>

<p>Thank you <?php echo $user; ?>, you have registered - you may now <a href='login.php'>login</a>.</p>

<?php 
}
else{
  ?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

  <table border="0">
    <tr><td>Username:</td>
      <td>
        <input type="text" name="username" maxlength="60">
      </td>
    </tr>
   
    <tr><td> Name:</td>
      <td>
        <input type="text" name="name" maxlength="60">
      </td>
    </tr>

    <tr><td>Email:</td>
      <td>
        <input type="email" name="email" maxlength="60">
      </td>
    </tr>

    <tr><td>Password:</td><td>
      <input type="password" name="pass" maxlength="10">
    </td></tr>

    <tr><td>Confirm Password:</td><td>
      <input type="password" name="pass2" maxlength="10">
    </td></tr>

    <tr><th colspan=2>
      <input type="submit" name="submit" value="Register">
    </th></tr> 
  </table>

</form>

<?php

   }
?>    
    </section>

    <footer id="contentinfo" class="body"> 
      <address id="about" class="vcard body"> 
        <span class="primary"> 
          <strong><a href="#" class="fn url">Winer: a winer company</a></strong>  
          <span class="role">FWBW</span> 
        </span><!-- /.primary -->  
        <img src="images/avatar.png" alt="Winer Logo" class="photo" /> 
        <span class="bio">
          Winer is a website and blog that offers resources and
          advice to wine enthusiasts and makers. It was founded by Joseph Featherston.
        </span>  
      </address><!-- /#about -->
      <p>
        2012 <a href="#">Winer</a>.
      </p> 

    </footer>
  </div>


</body>
