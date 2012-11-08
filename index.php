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
    <script type="text/javascript" language="javascript">
     <!-- //scripty script
      var interval = 3000;
      var random_display = 0;
      var imageDir = "images/";

      var imageNum = 0;
      imageArray = new Array();
      imageArray[imageNum++] = new imageItem(imageDir + "fpo-1.jpg");
      imageArray[imageNum++] = new imageItem(imageDir + "fpo-2.jpg");
      imageArray[imageNum++] = new imageItem(imageDir + "fpo-4.jpg");
      imageArray[imageNum++] = new imageItem(imageDir + "pouring-wine.jpg");     
      imageArray[imageNum++] = new imageItem(imageDir + "tasting-room.jpg");
 
      var totalImages = imageArray.length;

      function imageItem(image_location) {
        this.image_item = new Image();
        this.image_item.src = image_location;
      }
      function get_ImageItemLocation(imageObj) {
        return(imageObj.image_item.src)
      }

      function getNextImage() {
        imageNum = (imageNum+1) % totalImages;
        var new_image = get_ImageItemLocation(imageArray[imageNum]);
        return(new_image);
      }
      function getPrevImage() {
        imageNum = (imageNum-1) % totalImages;
        var new_image = get_ImageItemLocation(imageArray[imageNum]);
        return(new_image);
      }

      function prevImage(place) {
        var new_image = getPrevImage();
        document.getElementById(place).src = new_image;
      }

      function switchImage(place) {
        var new_image = getNextImage();
        document.getElementById(place).src = new_image;
        var recur_call = "switchImage('"+place+"')";
        timerID = setTimeout(recur_call, interval);
      }
      var playing = true
      function startStop() {
        if(playing){
          playing = false
          clearTimeout(timerID)
        }
        else{
          playing = true
          switchImage('slideImg')
        }
      }
      // -->
    </script>
 
</head>
<body onLoad="switchImage('slideImg')">
  <header id="banner" class="body"> 
      <h1>
        <a href="#">Winer: <strong>Are you a Winer?</strong></a>
      </h1>  
      <nav>
        <ul> 
          <li class="active"><a href="index.php">home</a></li> 
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
       <aside id="featured" class="body">
        <figure> <a title="click to start/pause slideshow" href="#" onClick="startStop()">
            <img id="slideImg" src="images/fpo-1.jpg" alt="Slideshow: click to pause/play" width=500 height=300 >
          </a>
          </figure> 
          <hgroup>  
            <h2>Featured Article</h2> 
            <h3><a href="blog.html">Come check out our blog!</a></h3> 
            </hgroup> 
            <p>
              Welcome to Winer! The brand new site for all your wine related needs. Find friends, events, and new wines!
            </p> 
      </aside>
      <section id="content" class="body">  
        <h2> Latest Offerings </h2>
        <ol id="posts-list" class="feed">
          <li>
            <article class="entry">
              <h2 class="entry-title">
                <a href="offerings.html" rel="bookmark" title="Permalink to this POST TITLE">This Saturday: the Wine and Garlic Festival!</a>
              </h2>  
              <footer class="post-info"> 
                <address class="vcard author">  By <a class="url fn" href="profile.html">Robert Loblaw</a> </address> 
              </footer>        
            </article>
          </li>
          
          <li>
            <article class="entry"> 
              <h2 class="entry-title">
                <a href="#" rel="bookmark" title="Permalink to this POST TITLE">A case of wine: $5!!!</a>
              </h2>  
              <footer class="post-info"> 
                <address class="vcard author">  By <a class="url fn" href="#">Enrique Ramírez</a> </address> 
              </footer>
            </article>
          </li>
          
          <li>
            <article class="entry"> 
              <h2 class="entry-title">
                <a href="#" rel="bookmark" title="Permalink to this POST TITLE">This Wine tasted like Vinegar.</a>
              </h2>  
              <footer class="post-info"> 
                <address class="vcard author">  By <a class="url fn" href="#">Sean Connery</a> </address> 
              </footer>
            </article>
          </li>
        </ol>


<?php 

 //if the cookie has the wrong password, they are taken to the login page 
    if ($login){ 
      
      echo "<h2>$name's Profile</h2>";
      echo "Email: $email <br>";
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
