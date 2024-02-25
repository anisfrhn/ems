<?PHP
session_start();
include("database.php");

$act = (isset($_POST['act'])) ? trim($_POST['act']) : '';

$error = "";

if($act == "login") 
{
	$email 		= (isset($_POST['email'])) ? trim($_POST['email']) : '';
	$password 	= (isset($_POST['password'])) ? trim($_POST['password']) : '';

	$SQL_login = " SELECT * FROM `user` WHERE `email` = '$email' AND `password` = '$password'  ";


	$result = mysqli_query($con, $SQL_login);
	$data	= mysqli_fetch_array($result);

	$valid = mysqli_num_rows($result);

	if($valid > 0)
	{
		$_SESSION["password"] = $password;
		$_SESSION["email"] 	= $email;
		$_SESSION["firstName"] 	= $data["firstName"];
		$_SESSION["userId"] 	= $data["userId"];
		
		header("Location:index.php");
			
		
	}else{
		$error = "Invalid";
		header( "refresh:1;url=login.php" );
		//print "<script>alert('Login tidak sah!'); self.location='index.php';</script>";
	}
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
    <div class="w3-content w3-container w3-white w3-round w3-card-4 w3-border w3-border-black w3-padding-16" style="max-width:500px">
		<div class="w3-padding">
			<form action="" method="post">
			<h3>Login</h3>
			  <div class="w3-section" >
				<label>Email</label>
				<input class="w3-input w3-border w3-round" type="text" name="email"  required>
			  </div>
			  <div class="w3-section">
				<label>Password</label>
				<input class="w3-input w3-border w3-round" type="password" name="password" required>
			  </div>
			  
			  <input name="act" type="hidden" value="login">
			  <button type="submit" class="w3-block w3-button w3-blue w3-round-xxlarge w3-large">Login</button>
			</form>
			<div class="w3-padding-16"></div>
			<div class="w3-center"><a href="admin.php">Admin</a></div>
		</div>
    </div>
</div>



	
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
