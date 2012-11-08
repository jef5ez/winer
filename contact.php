<?php // Connects to your Database 
 mysql_connect("localhost", "root", "root") or die(mysql_error());
 mysql_select_db("jef5ez_winer") or die(mysql_error()); 

//Checks if there is a login cookie 
if(isset($_COOKIE['ID_my_site'])){ 	
//if there is, it logs you in and directes you to the members page 
  $pass = $_COOKIE['Key_my_site']; 	 	
  $username = $_COOKIE['ID_my_site']; 	
  $user_id = $_COOKIE['user_id_my_site']; 	
  $check = mysql_query("SELECT * FROM users WHERE ID = '$user_id'")or die(mysql_error()); 	
  $login = false; 
  while($info = mysql_fetch_array( $check )) 	 		{ 		
    if ($pass == $info['password']) 			{
      $login=true;
      $power=$info['poweruser'];
      $name =$info['name'];
      $email = $info['email'];
    } 		
    else{ 
      header("Location: login.php"); 
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
    <script src="gen_validatorv4.js" type="text/javascript"></script>
    <script type="text/javascript">
      <!--// hide from non JavaScript Browsers

      Rollimage = new Array();

      Rollimage[0]= new Image();
      Rollimage[0].src = "images/wine.jpg";

      Rollimage[1] = new Image();
      Rollimage[1].src = "images/wine2.jpg";

      function SwapOut(){
        document.getElementById("wine").src = Rollimage[1].src;
        document.getElementById("rolloverText").innerHTML= "<p>What new features would you like to see?</p>";
        return true;
      }

      function SwapBack(){
        document.getElementById("wine").src = Rollimage[0].src; 
        document.getElementById("rolloverText").innerHTML= "";
        return true;
      }

      // - stop hiding          --> 
    </script>


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
        <aside id="featured" class="body">
          <figure>
            <a href="#" onmouseover="SwapOut()" onmouseout="SwapBack()">
                <img src="images/wine.jpg" id="wine" width=300 height=200 alt="How are we doing?">
            </a>
          </figure>
          <h2>Contact Us</h2>
          <p>Tell us how we are doing! </p>
          <div id="rolloverText">

          </div>
        </aside>

        <form id="contactForm">
          Name: <input type="text" name="name"><br>
          Email: <input type="email" name="email"><br>

          Message:<br>
          <textarea name="message" cols=50 rows=5></textarea><br>
          <input type="submit">
        </form>
        <script  type="text/javascript">
          <!--//GO AWAY SCRIPTS
          var frmvalidator = new Validator("contactForm");
          frmvalidator.addValidation("name","req","Please enter your First Name");
          frmvalidator.addValidation("name","maxlen=50", "Max length for Name is 20");
         
          frmvalidator.addValidation("email","maxlen=50");
          frmvalidator.addValidation("email","email");
          frmvalidator.addValidation("email","req", "Please enter your email.");
          
          frmvalidator.addValidation("message","req", "Please enter your message.");
          //-->
        </script>



<?php 

 //if the cookie has the wrong password, they are taken to the login page 
    if ($login){ 
      
      $offerings = mysql_query("SELECT * FROM offerings WHERE user_id = '$user_id'")or die(mysql_error()); 	
      while($info = mysql_fetch_array( $offerings)) 	 		{ 		
      }
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
