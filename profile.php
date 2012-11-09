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
else{			 
 //if the cookie does not exist, they are taken to the login screen 
 header("Location: login.php"); 
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
    if ($login){ 
      echo "<h2>$name's Profile</h2>";
      echo "Email: $email <br>";
      if($power){
        echo "<h2>Latest Blogs</h2>";
        echo '<ol id="posts-list" class="feed">';
        $blogs= mysql_query("SELECT * FROM blogs order by ID desc limit 5")or die(mysql_error()); 	
        while($info = mysql_fetch_array( $blogs)) 	 		{ 		
          echo  '<li>';
          echo    '<article class="blog">';
          echo    "<h3><a href='show_blog.php?id=".$info['ID']."'>".$info['title']."</a></h3> ";
          echo    substr($info["story"], 0, 150)."...";
          echo    "<p> ".$info['likes']." <a href='like.php?id=".$info['ID']."'>like</a> </p>" ;
          echo        "<a href='delete.php?type=blogs&id=".$info['ID']."'>Delete</a>";
          echo  '</article>';
          echo  '</li>';
      }}

      echo '<ol id="posts-list" class="feed">';
      $offerings = mysql_query("SELECT * FROM offerings WHERE user_id = '$user_id'")or die(mysql_error()); 	
      while($info = mysql_fetch_array( $offerings)) 	 		{ 		
        echo '<li>';
        echo   '<article class="entry">';
        echo     '<h2 class="entry-title">';
        echo       "<a href='show_offering.php?id=".$info["ID"]."' rel='bookmark'>".$info["name"]."</a>";
        echo        '</h2>';
        echo        '<footer class="post-info">';
        echo          "<address class='vcard author'>  By <a class='url fn' href='profile.php'>You</a> </address>" ;
        echo        '</footer> ' ;
        echo        "<a href='delete.php?type=offerings&id=".$info['ID']."'>Delete</a>";
        echo      '</article>
            </li>';     }
    } 
   ?> </ol>
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
