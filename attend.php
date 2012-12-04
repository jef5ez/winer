 <?php 
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
if($login){
  $offering_id= mysql_real_escape_string($_GET['offering_id']);

  $check = mysql_query("SELECT * FROM attendees WHERE offering_id = '$offering_id' AND user_id = '$user_id'") 
   or die(mysql_error());
  $check2 = mysql_num_rows($check);

  if ($check2 != 0) {
   die('You are already attending.');
  } 
 
  $insert = "INSERT INTO attendees (offering_id, `user_id`) VALUES ('".$offering_id."', '".$user_id."')";
  $add_member = mysql_query($insert) or die(mysql_error()); 

 header("Location:".$_SERVER['HTTP_REFERER']); 
}
    else{ 
      header("Location: login.php"); 
    } 		
 ?> 
