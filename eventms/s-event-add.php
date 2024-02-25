<?PHP
session_start();

include("database.php");
if( !verifyStaff($con) ) 
{
	header( "Location: index.php" );
	return false;
}
?>
<?PHP
$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	

$eventName 		= (isset($_POST['eventName'])) ? trim($_POST['eventName']) : '';	
$eventDetails 	= (isset($_POST['eventDetails'])) ? trim($_POST['eventDetails']) : '';
$eventCategory 	= (isset($_POST['eventCategory'])) ? trim($_POST['eventCategory']) : '';
$startDate 		= (isset($_POST['startDate'])) ? trim($_POST['startDate']) : '';
$endDate 		= (isset($_POST['endDate'])) ? trim($_POST['endDate']) : '';
$startTime 		= (isset($_POST['startTime'])) ? trim($_POST['startTime']) : '';
$endTime 		= (isset($_POST['endTime'])) ? trim($_POST['endTime']) : '';
$pic 			= (isset($_POST['pic'])) ? trim($_POST['pic']) : '';
$eventLocation 	= (isset($_POST['eventLocation'])) ? trim($_POST['eventLocation']) : '';
$eventCapacity 	= (isset($_POST['eventCapacity'])) ? trim($_POST['eventCapacity']) : '';
$eventDept 		= (isset($_POST['eventDept'])) ? trim($_POST['eventDept']) : '';

if($act == "add")
{	
	$SQL_insert = " 
	INSERT INTO `event`(`eventName`, `eventDetails`, `eventCategory`, `startDate`, `endDate`, `startTime`, `endTime`, `pic`, `eventLocation`, `eventCapacity`, `eventDept`) VALUES ('$eventName', '$eventDetails', '$eventCategory', '$startDate', '$endDate', '$startTime', '$endTime', '$pic', '$eventLocation', '$eventCapacity', '$eventDept')";
	
	$result = mysqli_query($con, $SQL_insert);
	
	$eventId = mysqli_insert_id($con);
	
	// -------- Photo -----------------
	if(isset($_FILES['photo'])){
		 
		  $file_name = "event-" . $_FILES['photo']['name'];
		  $file_size = $_FILES['photo']['size'];
		  $file_tmp = $_FILES['photo']['tmp_name'];
		  $file_type = $_FILES['photo']['type'];
		  
		  $fileNameCmps = explode(".", $file_name);
		  $file_ext = strtolower(end($fileNameCmps));
		  
		  if(empty($errors)==true) {
			 move_uploaded_file($file_tmp,"photo/".$file_name);
			 
			$query = "UPDATE `event` SET `photo`='$file_name' WHERE `eventId` = '$eventId'";			
			$result = mysqli_query($con, $query) or die("Error in query: ".$query."<br />".mysqli_error($con));
		  }else{
			 print_r($errors);
		  }  
	}
	// -------- End Photo -----------------
	
	$success = "Successfully Registered";
	print "<script>self.location='s-event.php';</script>";
}


$SQL_view 	= " SELECT * FROM `staff` WHERE `staffEmail` =  '". $_SESSION["email"] ."'";
$result 	= mysqli_query($con, $SQL_view);
$data		= mysqli_fetch_array($result);
$staffName	= $data["staffName"];
$staffPhone	= $data["staffPhone"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>EMS</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link href='https://fonts.googleapis.com/css?family=RobotoDraft' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- include summernote css-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- include summernote js-->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<style>
a {
  text-decoration: none;
}
html,body,h1,h2,h3,h4,h5 {font-family: "RobotoDraft", "Roboto", sans-serif}
.w3-bar-block .w3-bar-item {padding: 16px}.w3-biru {background-color:#f6f9ff;}
</style>
</head>
<body class="w3-biru">

<!-- Side Navigation -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-white w3-card" style="z-index:3;width:250px;" id="mySidebar">
  <a href="s-main.php" class="w3-bar-item w3-large"><img src="images/logo.png" class="w3-padding" style="width:100%;"></a>
  <a href="javascript:void(0)" onclick="w3_close()" title="Close Sidemenu" 
  class="w3-bar-item w3-button w3-hide-large w3-large">Close <i class="fa fa-remove"></i></a>
  
  <a href="s-main.php" class="w3-bar-item w3-button w3-text-indigo">
  <i class="fa fa-fw fa-tachometer w3-margin-right"></i> DASHBOARD</a>
  
  <a href="s-event.php" class="w3-bar-item w3-button w3-biru  w3-text-indigo">
  <i class="fa fa-fw fa-calendar w3-margin-right"></i> MANAGE EVENT</a>
  
  <a href="s-report.php" class="w3-bar-item w3-button  w3-text-indigo">
  <i class="fa fa-fw fa-file w3-margin-right"></i> GENERATE REPORT</a>

</nav>



<!-- Overlay effect when opening the side navigation on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="Close Sidemenu" id="myOverlay"></div>

<!-- Page content -->
<div class="w3-main" style="margin-left:250px;">


<div class="w3-white w3-bar w3-card ">


	<span class="w3-left"><i class="fa fa-bars w3-buttonx w3-white w3-hide-large w3-xlarge w3-margin-left w3-margin-top" onclick="w3_open()"></i></span>

	<div class="w3-bar-item w3-xlarge w3-margin-left w3-text-indigo"> Create Event</div>

	
	<div class="w3-large w3-buttonx w3-bar-item w3-right w3-white w3-dropdown-hover">
      <button class="w3-button"><i class="fa fa-fw fa-user-circle-o"></i> <?PHP echo $_SESSION["staffName"];?> <i class="fa fa-fw fa-chevron-down w3-small"></i></button>
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
        <a href="s-profile.php" class="w3-bar-item w3-button"><i class="fa fa-fw fa-user-circle "></i> Profile</a>
        <a href="logout.php" class="w3-bar-item w3-button"><i class="fa fa-fw fa-sign-out "></i> Signout</a>
      </div>
    </div>

</div>

<div class="w3-padding-16"></div>

	
<div class="w3-padding-16"></div>
	
<div class="w3-container">

	<!-- Page Container -->
	<div class="w3-container w3-white w3-content w3-card w3-padding-16" style="max-width:600px;">    
	  <!-- The Grid -->
	  <div class="w3-row w3-padding">
	  
		<form action="" method="post" enctype="multipart/form-data" >
			<div class="w3-padding">
			<b class="w3-large">Event Detail</b>
			<hr>

			  
			  <div class="w3-section " >
				<label>Event Name *</label>
				<input class="w3-input w3-border w3-round" type="text" name="eventName" value="" required>
			  </div>
			  
			  <div class="w3-section " >
				<label>Start Date *</label>
				<input class="w3-input w3-border w3-round" type="date" name="startDate" value="" required>
			  </div>
			  
			  <div class="w3-section " >
				<label>End Date *</label>
				<input class="w3-input w3-border w3-round" type="date" name="endDate" value="" required>
			  </div>
			  
			  <div class="w3-section " >
				<label>Start Time *</label>
				<input class="w3-input w3-border w3-round" type="time" name="startTime" value="" required>
			  </div>
			  
			  <div class="w3-section " >
				<label>End Time *</label>
				<input class="w3-input w3-border w3-round" type="time" name="endTime" value="" required>
			  </div>
			  
			  <div class="w3-section " >
				<label>Location *</label>
				<select class="w3-select w3-border w3-round" name="eventLocation" required>
					<option value="Auditorium">Auditorium</option>
					<option value="Bilik Seminar">Bilik Seminar</option>
					<option value="Bilik Aktiviti Kanak-Kanak">Bilik Aktiviti Kanak-Kanak</option>
					<option value="Bilik Latihan">Bilik Latihan</option>
					<option value="Bilik Mesyuarat">Bilik Mesyuarat</option>
				</select>
			  </div>
			  
			  <div class="w3-section " >
				<label>Category *</label>
				<input class="w3-input w3-border w3-round" type="text" name="eventCategory" value="" required>
			  </div>
			  
			  <div class="w3-section " >
				<label>Capacity *</label>
				<input class="w3-input w3-border w3-round" type="text" name="eventCapacity" value="" required>
			  </div>
			  
			  
			  
			  <div class="w3-section " >
				<label>Person in Charge *</label>
				<input class="w3-input w3-border w3-round" type="text" name="pic" value="<?PHP echo $staffPhone . " " . $staffName;?>" disabled>
				<input type="hidden" name="pic" value="<?PHP echo $staffPhone . "<br>" .$staffName;?>">
			  </div>
			  
			  <div class="w3-section " >
				<label>Department *</label>
				<select class="w3-select w3-border w3-round" name="eventDept" required>
					<option value="Pengurusan Atasan">Pengurusan Atasan</option>
					<option value="Bahagian Pengurusan & Pentadbiran">Bahagian Pengurusan & Pentadbiran</option>
					<option value="Unit Pembangunan Sumber Manusia">Unit Pembangunan Sumber Manusia</option>
					<option value="Unit Kewangan">Unit Kewangan</option>
					<option value="Bahagian Perancangan Dan Pembangunan">Bahagian Perancangan Dan Pembangunan</option>
					<option value="Unit Korporat">Unit Korporat</option>
					<option value="Unit Kualiti">Unit Kualiti</option>
					<option value="Bahagian Rangkaian Perpustakaan">Bahagian Rangkaian Perpustakaan</option>
					<option value="Bahagian Pendokumentasian">Bahagian Pendokumentasian</option>
				</select>
			  </div>
			  
			  <div class="w3-section" >
				<label>Event Poster *</label>
				<div class="custom-file">
					<input type="file" class="custom-file-input w3-input w3-border w3-round" name="photo" id="photo" accept=".jpeg, .jpg,.png,.gif">
					<label class="custom-file-label" for="customFile">Upload Photo</label>
					<small>  only JPEG, JPG, PNG or GIF allowed </small>
				</div>
			  </div>
			  
			  <div class="w3-section " >
				<label>Description *</label>
				<textarea id='makeMeSummernote' class="w3-input w3-border w3-round" name="eventDetails" required></textarea>
			  </div>
			  
			  <hr class="w3-clear">
			  
			  <div class="w3-section" >
				<input name="act" type="hidden" value="add">
				<button type="submit" class="w3-button w3-blue w3-text-white w3-margin-bottom w3-round-xxlarge">CREATE EVENT</button>
			  </div>
			</div>  
		</form>
	  
		

		
	  <!-- End Grid -->
	  </div>
	  
	<!-- End Page Container -->
	</div>
	
	
	

</div>
<!-- container end -->


<div class="w3-padding-24"></div>

     
</div>

<script type="text/javascript">
	$('#makeMeSummernote').summernote({
		height:200,
	});
</script>
	
<script>
var openInbox = document.getElementById("myBtn");
openInbox.click();

function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}

function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}

function myFunc(id) {
  var x = document.getElementById(id);
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show"; 
    x.previousElementSibling.className += " w3-pale-red";
  } else { 
    x.className = x.className.replace(" w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace(" w3-red", "");
  }
}

</script>

</body>
</html> 
