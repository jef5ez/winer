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
    <script type="text/javascript">
      <!--
      function popup(){
        pop = window.open('newPost.html', 'newPost', 'location=1');
      }
      //-->
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
<?php
if(isset($_GET['id'])){
$offerings= mysql_query("SELECT offerings.ID as id, offerings.type, offerings.var, offerings.desc, offerings.name as off, users.name as author FROM 
  offerings join users on user_id=users.ID where offerings.ID=".$_GET['id']." limit 1")or die(mysql_error()); 	
    while($info = mysql_fetch_array( $offerings)) 	 		{ 		
      echo   '<article class="entry">';
      echo     '<h2 class="entry-title">';
      echo       "<a href='show_offering.php?id=".$info["id"]."' rel='bookmark'>".$info["off"]."</a>";
      echo        '</h2>';
      echo        "<h4>".$info['type'].": ".$info['var']."</h4>";
      echo        "<p>".$info['desc']."</p>";
      echo        '<footer class="post-info">';
      echo          "<address class='vcard author'>  By <a class='url fn' href='profile.php'>".$info["author"]."</a> </address>" ;
      echo        '</footer>        
        </article>';
      if($info['type']=='Event' && $login){
        $attendees = mysql_query("SELECT users.name as attendee FROM attendees join users on user_id=users.ID 
          where offering_id=".$_GET['id'] )or die(mysql_error()); 	
        echo "Attending: ";
       $check = mysql_num_rows($attendees);
        if($check==0){
          echo "No attendees yet";
        }else{
          while($ppl = mysql_fetch_array($attendees)){

            echo $ppl['attendee']." ";
          }
        }
      }
    }
}
else{
  echo "No offering specified";
}

if($login){ 
?>  
  <br>  
  <a href="attend.php?offering_id=<?php echo $_GET['id']; ?>">Attend</a>
   <br>
   Add a Comment
  <form id="contactForm" action="comment.php" method="post">
    <input type="hidden" name="offering_id" value="<?php echo $_GET['id'] ?>" >
    <textarea name="comment" cols=50 rows=3></textarea><br>
    <input type="submit" name="submit">
  </form>
<?php }?>

<h2> Latest Comments</h2>
        <ol id="posts-list" class="feed">
<?php
    $comments= mysql_query("SELECT comment, users.name as author FROM 
  comments join users on user_id=users.ID where offering_id=".$_GET['id']." order by comments.ID desc limit 5")or die(mysql_error()); 	
    $check = mysql_num_rows($comments);
    if($check==0){
      echo "No comments yet";
    }else{
      while($info = mysql_fetch_array( $comments)) 	 		{ 		
        echo '<li>';
        echo   '<article class="entry">';
        echo     '<p class="post-info">';
        echo       "<a rel='nofollow'>".$info["comment"]."</a>";
        echo        '</p>';
        echo        '<footer class="post-info">';
        echo          "<address class='vcard author'>  By <a class='url fn' href='profile.php'>".$info["author"]."</a> </address>" ;
        echo        '</footer>        
              </article>
            </li>';
      }
    }
?>           
        </ol>

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
