<?php // Connects to your Database 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

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
else{			 
 //if the cookie does not exist, they are taken to the login screen 
 header("Location: login.php"); 
 } 

if (isset($_POST['submit'])) { 
  
  //  //This makes sure they did not leave any fields blank
  if (!$_POST['name']  | !$_POST['type'] | !$_POST['email'] | !$_POST['var'] | !$_POST['desc']) {
    die('You did not complete all of the required fields');
  }
   // checks if the username is in use
  $name= mysql_real_escape_string($_POST['name']);
  $email= mysql_real_escape_string($_POST['email']);
  $var= mysql_real_escape_string($_POST['var']);
  $desc= mysql_real_escape_string($_POST['desc']);
  $type= mysql_real_escape_string($_POST['type']);
  $insert = "INSERT INTO offerings (user_id, name, email, var, `type`,`desc`) VALUES ('".$user_id."', '".$name."', '".$email."', '".$var."', '".$type."', '".$desc."')";
  $add_member = mysql_query($insert) or die(mysql_error()); 


  header("Location: offerings.php");
} else{
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
    <script type='text/javascript' language='javascript'>
      <!-- //scriptsssss
      var e = document.getElementById("offeringType");
      
      function changeType(){
      e = document.getElementById("offeringType");
      var strType = e.options[e.selectedIndex].value;
        if(strType == 'Review'){
          change.innerHTML = 'Varietal/Year: <input type="text" name="var"><br>';
        }else if(strType=='Event'){
          change.innerHTML = 'Date: <input type="date" name="var"><br>';

        }else{
          change.innerHTML = 'Price: <input type="text" name="var"><br>';
        }

      }

      //-->
    </script>
 

</head>
<body>
    <div id="container" class = "body">
      <section id="content" class="body">  
        <h2> Submit an Offering</h2>
        <form id="offeringForm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
          Offering Name: <input type="text" name="name"> <br>
          Email: <input type="email" name="email"
<?php 
 if ($login){ 
  echo "value='$email'";
 } 
?>
> <br>
          Offering Type
          <select name='type' id="offeringType" onchange="changeType()">
            <option value="">Choose a Type</option>
            <option value="Review">Review</option>
            <option value="Event">Event</option>
            <option value="Sale">Sale</option>
          </select>
          <br>
          <div id="change"></div>
          Description: <br>
          <textarea id="description" name="desc" cols=50 rows=5></textarea>
          <br>
          <input type="submit" name="submit" >
        </form>
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
<?php } ?>

