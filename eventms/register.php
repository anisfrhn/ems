<?PHP
session_start();
include("database.php");
?>
<?PHP
$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	

$firstName 	= (isset($_POST['firstName'])) ? trim($_POST['firstName']) : '';
$lastName 	= (isset($_POST['lastName'])) ? trim($_POST['lastName']) : '';
$email		= (isset($_POST['email'])) ? trim($_POST['email']) : '';
$password 	= (isset($_POST['password'])) ? trim($_POST['password']) : '';
$gender 	= (isset($_POST['gender'])) ? trim($_POST['gender']) : '';
$phone 		= (isset($_POST['phone'])) ? trim($_POST['phone']) : '';

$firstName	=	mysqli_real_escape_string($con, $firstName);
$lastName	=	mysqli_real_escape_string($con, $lastName);	

$error = "";
$success = false;

if($act == "add")
{	
	$SQL_insert = " 
	INSERT INTO `user`(`firstName`, `lastName`, `email`, `password`, `gender`, `phone`) 
	VALUES ('$firstName', '$lastName', '$email', '$password', '$gender', '$phone')";
										
	$result = mysqli_query($con, $SQL_insert);
	
	$userId = mysqli_insert_id($con);
	
		// -------- Photo -----------------
		if($_FILES["image"]["error"] == 4) {
				//means there is no file uploaded
		} else {
		  $file_name = "user-" . $_FILES['image']['name'];
		  $file_size = $_FILES['image']['size'];
		  $file_tmp = $_FILES['image']['tmp_name'];
		  $file_type = $_FILES['image']['type'];
		  
		  $fileNameCmps = explode(".", $file_name);
		  $file_ext = strtolower(end($fileNameCmps));
		  
		  if(empty($errors)==true) {
			 move_uploaded_file($file_tmp,"photo/".$file_name);
			 
			$query = "UPDATE `user` SET `image`='$file_name' WHERE `userId` = '$userId'";			
			$result = mysqli_query($con, $query) or die("Error in query: ".$query."<br />".mysqli_error($con));
		  }else{
			 print_r($errors);
		  }  
	}
	// -------- End Photo -----------------
	
	$success = true;
	
	//print "<script>self.location='a-main.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<title>EMS</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Telex">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
a {text-decoration:none;}
body,h1,h2,h3,h4,h5,h6 {font-family: "Telex", sans-serif}

body, html {
  height: 100%;
  line-height: 1.8;
}

/* Full height image header */
.bgimg-1 {
  background-position: top;
  background-size: cover;
  min-height: 100%;
}

.w3-bar .w3-button {
  padding: 16px;
}

.w3-biru {background-color:#f6f9ff;}
</style>

<body class="w3-biru">

<?PHP include("menu.php"); ?>


<div class="bgimg-1" >

	<div class="w3-padding-64"></div>
		


<div class="w3-container " id="contact">
    <div class="w3-content w3-container w3-white w3-round w3-card-4 w3-border w3-border-black w3-padding" style="max-width:500px">
		<div class="w3-padding">
			<form action="" method="post" enctype="multipart/form-data" >
			<div class="w3-padding"></div>
			<b class="w3-large">Create an Account</b><BR>
			Enter your personal details to create account
			<hr>
			  
<?PHP if($success) { ?>
<div class="w3-panel w3-indigo w3-display-container w3-animate-zoom">
  <span onclick="this.parentElement.style.display='none'"
  class="w3-button w3-large w3-display-topright">&times;</span>
  <h3>Success!</h3>
  <p>Your registration was successful! You may now <a href="login.php" class="w3-xlarge">Login.</a> </p>
</div>
<?PHP  } ?>

<?PHP if(!$success) { ?>	

			  <div class="w3-section" >
				<div class="custom-file">
					<input type="file" class="custom-file-input w3-input w3-border w3-round" name="image" id="image" accept=".jpeg, .jpg,.png,.gif">
					<small>  only JPEG, JPG, PNG or GIF allowed </small>
				</div>
			  </div>
				
			  <div class="w3-section " >
				<input class="w3-input w3-border w3-round" type="text" name="firstName" value="" placeholder="First Name" required>
			  </div>
			  
			  
			  <div class="w3-section " >
				<input class="w3-input w3-border w3-round" type="text" name="lastName" value="" placeholder="Last Name" required>
			  </div>
			  
			  <div class="w3-section " >
				<input class="w3-input w3-border w3-round" type="email" name="email" value="" placeholder="Email" required>
			  </div>
			  
			  <div class="w3-section " >
				<input class="w3-input w3-border w3-round" type="password" name="password" value="" placeholder="Password" required>
			  </div>
			  
			  <div class="w3-section " >
				<select class="w3-select w3-border w3-round" name="gender" value="" required>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
			  </div>
			  
			  <div class="w3-section " >
				<input class="w3-input w3-border w3-round" type="text" name="phone" value="" placeholder="Contact No" required>
			  </div>
			  
			  <hr class="w3-clear">
			  
			  <div class="w3-section" >
				<input name="act" type="hidden" value="add">
				<button type="submit" class="w3-button w3-blue w3-text-white w3-margin-bottom w3-round-xxlarge">REGISTER</button>
			  </div>
<?PHP } ?>			  
			</div>  
		</form> 

		</div>
    </div>
</div>


<div class="w3-padding-32"></div>
	
</div>


 
<script>

// Toggle between showing and hiding the sidebar when clicking the menu icon
var mySidebar = document.getElementById("mySidebar");

function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
  } else {
    mySidebar.style.display = 'block';
  }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
}
</script>

</body>
</html>
