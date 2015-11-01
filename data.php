<?php
	require_once("functions.php");
	//data.php
	// siia p��seb ligi sisseloginud kasutaja
	//kui kasutaja ei ole sisseloginud,
	//siis suuunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	//kasutaja tahab v�lja logida
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame k�ik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	
	$boot_brand = $model = "";
	$boot_brand_error = $model_error = "";
	
	// keegi vajutas nuppu mudeli lisamiseks
	if(isset($_POST["add_model"])){
		
		//echo $_SESSION["logged_in_user_id"];
		
		// valideerite v�ljad
		if ( empty($_POST["boot_brand"]) ) {
			$boot_brand_error = "See v�li on kohustuslik";
		}else{
			$boot_brand = cleanInput($_POST["boot_brand"]);
		}
		
		if ( empty($_POST["model"]) ) {
			$model_error = "See v�li on kohustuslik";
		}else{
			$model = cleanInput($_POST["model"]);
		}
		
		// m�lemad on kohustuslikud
		if($model_error == "" && $boot_brand_error == ""){
			//salvestate ab'i fn kaudu addCarPlate
			$message = addBoot($boot_brand, $model);
			
			if ($message != ""){
				$boot_brand = "";
				$model = "";
				
				echo $message;
				
				
			}
			
		}
		
	}
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
?>
<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?> 
	<a href="?logout=1"> Logi v�lja <a> 
</p>


<h2>Lisa putsa</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="boot_brand" >Putsa firma</label><br>
	<input id="boot_brand" name="boot_brand" type="text" value="<?php echo $boot_brand; ?>"> <?php echo $boot_brand_error; ?><br><br>
	<label for="model">Mudel</label><br>
	<input id="model" name="model" type="text" value="<?php echo $model; ?>"> <?php echo $boot_brand_error; ?><br><br>
	<input type="submit" name="add_boot" value="Salvesta">
</form>