
<?php
	require_once("functions.php");
	
	if(isset($_SESSION["logged_in_user_id"])){
		header("Location: data.php");
	}

	//errorid
	$email_error_login = "";
	$password_error_login = "";
	$first_name_error = "";
	$last_name_error = "";
	$email_error_create ="";
	$password_error_create= "";
	
	//väärtused
	$email_login = "";
	$password_login = "";
	$first_name = "";
	$last_name = "";
	$email_create = "";
	$password_create= "";
	
	//*********************************************************************************
	
	//kontrollime, et keegi vajutas input nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST" ) {
		
		if(isset($_POST["login"])){
			
			if ( empty($_POST["email_login"]) ) {
				$email_error_login = "This field is obligatory, you cannot leave it empty";
			}else{
				$email_login = test_input($_POST["email_login"]);
			}
			//kontrollin, et parool ei ole tühi
		
			if (empty($_POST["password_login"]) ) {
				$password_error_login = "This field is obligatory, you cannot leave it empty";
			}else{
				$password_login = test_input($_POST["password_login"]);
			} 
		
			if($email_error_login == "" && $password_error_login == ""){
				echo "Ready to log in! Username is ".$email_login." and password is ".$password_login;
			
				$hash = hash("sha512", $password_login);
			
				loginUser($email_login, $hash);
			}	
		}
		
	 //***************************************************************************		
	    if(isset($_POST["create"])){		
			if (empty($_POST["email_create"])){
				$email_error_create = "This field is obligatory, you cannot leave it empty";
			}else{
				$email_create = test_input($_POST["email_create"]);
			}	
			
			if (empty($_POST["password_create"])){
				$password_error_create = "This field is obligatory, you cannot leave it empty";
			}else{
				if(strlen($_POST["password_create"]) <8) {
				$password_error_create = "Password is too short, it has to be at least 8 characters long!";
				}else{
				$password_create = test_input($_POST["password_create"]);
				}
			}
			
			if (empty ($_POST["first_name"])){
				$first_name_error = "This field is obligatory, you cannot leave it empty";
			}else{
				$first_name = test_input($_POST["first_name"]);
			}
			
			if (empty ($_POST["last_name"])){
				$last_name_error = "This field is obligatory, you cannot leave it empty";
			}else{
				$last_name = test_input($_POST["last_name"]);
			}
			
			if( $email_error_create== "" && $password_error_create=="" && $first_name_error=="" && $last_name_error==""){
					
				$hash = hash("sha512", $password_create);
				echo "Ready to create the user! The username is ".$email_create." and password is  ".$password_create." and hash is ".$hash;
			
				createUser($email_create, $hash, $first_name, $last_name);
			}
	}
}	
  function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
  }
	
	
	
	
	
?>

<?php	
	$page_title="Sisselogimine";
	$page_file_name="login.php";
?>
<?php require_once("../header.php"); ?>



	<h2>Log in</h2>
		
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
			<input name="email_login" type="email" placeholder="e-mail"> <?php echo $email_error_login; ?> <br><br>
			<input name="password_login" type="password" placeholder="password"> <?php echo $password_error_login; ?> <br><br>
			<input name="login" type="submit" value="Log in" >
		</form>
		
		
	<h2>Create user</h2>
		
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
			<input name="email_create" type="email" placeholder="e-mail" >*<?php echo $email_error_create; ?> <br><br>
			<input name="password_create" type="password" placeholder="password" >*<?php echo $password_error_create; ?> <br><br><br><br>
			<input name="first_name" type="text" placeholder="first name" >* <?php echo $first_name_error; ?> <br><br>
			<input name="last_name" type="text" placeholder="last name" >* <?php echo $last_name_error; ?> <br><br>
			<input name="create" type="submit" value="Create user" >
		</form>	
			
			
			
			
 	

<?php require_once("../footer.php"); ?>	