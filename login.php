<?php // Connects to your Database 
 mysql_connect("localhost", "root", "root") or die(mysql_error());
 mysql_select_db("jef5ez_winer") or die(mysql_error()); 

//Checks if there is a login cookie 
if(isset($_COOKIE['ID_my_site'])){ 	
//if there is, it logs you in and directes you to the members page 
  $username = $_COOKIE['ID_my_site']; 	
  $pass = $_COOKIE['Key_my_site']; 	 	
  $check = mysql_query("SELECT * FROM users WHERE username = '$username'")or die(mysql_error()); 	
  $login = false;
  while($info = mysql_fetch_array( $check )) 	 		{ 		
    if ($pass != $info['password']) 			{
    } 		
    else{ 
      $login=true;      
      header("Location: profile.php"); 			
    } 		
  } 
} 

?>

<head>
    <link rel="stylesheet" type="text/css" href="stylesheets/winer.css" />
    <meta charset="utf-8" />
    <title>Winer: Are you a Winer?</title>

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
<?php
if($login){?>
           <li><a href="profile.php">profile</a></li>
           <li><a href="logout.php">logout</a></li>
<?php  }
else{?>
          <li><a href="sign_up.php">sign up</a></li>
          <li><a href="login.php">login</a></li>
<?php  }    ?>
          <li><a href="contact.php">contact</a></li> 
        </ul>
      </nav>  
    </header>
    <div id="container" class = "body">
      <section id="content" class="body">  

<?php
//if the login form is submitted 

 if (isset($_POST['submit'])) { 

// if form has been submitted
// makes sure they filled it in
 	if(!$_POST['username'] | !$_POST['pass']) {
 		die('You did not fill in a required field.');
 	}
 	// checks it against the database
 
  $user= mysql_real_escape_string($_POST['username']);
 	$check = mysql_query("SELECT * FROM users WHERE username = '".$user."'")or die(mysql_error());
 
 //Gives error if user dosen't exist
 $check2 = mysql_num_rows($check);
 if ($check2 == 0) {
 		die('That user does not exist in our database. <a href=sign_up.php>Click Here to Register</a>');
 				}
 while($info = mysql_fetch_array( $check )) 	
 {
   $_POST['pass'] = stripslashes($_POST['pass']);
 	 $info['password'] = stripslashes($info['password']);
 	 //$_POST['pass'] = md5($_POST['pass']);
   $salt = stripslashes($info['salt']);
   $hash= $salt . sha1($salt.$_POST['pass']);


 //gives error if the password is wrong
 	if ($hash != $info['password']) {
 		die('Incorrect password, please try again.');
 	}
  
  else { // if login is ok then we add a cookie 	 
    $_POST['username'] = stripslashes($_POST['username']); 	 
    $hour = time() + 3600; 
    setcookie(ID_my_site, $_POST['username'], $hour); 
    setcookie(Key_my_site, $hash, $hour);	 
    setcookie(user_id_my_site, $info['ID'], $hour);	 
    //then redirect them to the members area 
    header("Location: profile.php"); } } } 
else {	 // if they are not logged in 
?> 
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
<table border="0"> 
  <tr>
    <td colspan=2><h1>Login</h1></td>
  </tr> 
  <tr>
    <td>Username:</td>
    <td> 
      <input type="text" name="username" maxlength="40"> </td>
  </tr> 
  <tr>
    <td>Password:</td>
    <td> 
      <input type="password" name="pass" maxlength="50"> 
    </td>
  </tr> 
  <tr>
    <td colspan="2" align="right"> 
      <input type="submit" name="submit" value="Login"> 
    </td>
  </tr> 
</table> 
</form> 
<?php } ?>  
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
