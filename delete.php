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
  if (!$_GET['type']  | !$_GET['id']) {
    die('You did not complete all of the required fields');
  }
   // checks if the username is in use
  $type= mysql_real_escape_string($_GET['type']);
  $id= mysql_real_escape_string($_GET['id']);

  $delete = "DELETE FROM ".$type." WHERE ID =".$id." limit 1";
  $add_member = mysql_query($delete) or die(mysql_error()); 

 header("Location: profile.php"); 
}
 ?> 
