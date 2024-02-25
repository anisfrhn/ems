<?PHP
session_start();
include("database.php");
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
  background-image: url(images/bannerx.jpg);
}

.w3-bar .w3-button {
  padding: 16px;
}

.w3-biru {background-color:#f6f9ff;}
</style>

<body class="w3-biru">

<?PHP include("menu.php"); ?>


<div class="bgimg-1" >

<div class="w3-padding-48"></div>

<!-- 1st Grid -->
<div class="w3-row-padding w3-padding-16 w3-container">
	<div class="w3-content" style="max-width:1200px">	
	
<!--- SLIDE -->
<style>
.mySlides {display:none}
.w3-left, .w3-right, .w3-badge {cursor:pointer}
.w3-badge {height:13px;width:13px;padding:0}
</style>

<div class="w3-display-container" 
  <img class="mySlides" src="https://www.w3schools.com/w3css/img_nature_wide.jpg" style="width:100%">
  <img class="mySlides" src="https://www.w3schools.com/w3css/img_snow_wide.jpg" style="width:100%">
  <img class="mySlides" src="https://www.w3schools.com/w3css/img_mountains_wide.jpg" style="width:100%">
  <div class="w3-center w3-container w3-section w3-large w3-text-white w3-display-bottommiddle" style="width:100%">
    <div class="w3-left w3-hover-text-khaki" onclick="plusDivs(-1)">&#10094;</div>
    <div class="w3-right w3-hover-text-khaki" onclick="plusDivs(1)">&#10095;</div>
    <span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(1)"></span>
    <span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(2)"></span>
    <span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(3)"></span>
  </div>
</div>





<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function currentDiv(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" w3-white", "");
  }
  x[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " w3-white";
}
</script>

<!-- slide -->

	</div>
</div>
<!-- End Grid -->


<!-- Start Grid -->
<div class="w3-row-padding w3-padding-16 w3-container">
  <div class="w3-content" style="max-width:1200px">	
	<div class="w3-xlarge"><b>Latest Event</b></div>
	
	<?PHP
	$sql_search = "";
	
	if($search){
		$sql_search = "WHERE eventName LIKE '%$search%' ";
	}
	$SQL_list = "SELECT * FROM `event` $sql_search";
	$result = mysqli_query($con, $SQL_list) ;
	while ( $data	= mysqli_fetch_array($result) )
	{
		$eventCapacity = $data["eventCapacity"];
		$tot_join = 0;
		
		$tot_join = numRows($con, "SELECT * FROM `bookspot` WHERE `eventId` = " . $data['eventId']);	
	?>	
	
	<div class="w3-row w3-white ">
	<div class="w3-half w3-center">
    <div class="w3-margin-right w3-padding-16 w3-padding"><img src="photo/<?PHP echo $data["photo"]; ?>" class="w3-image"></div>
    </div>

    <div class="w3-half ">
	
	<div class="w3-margin-left ">
      
	  <div class="w3-xlarge"><b><?PHP echo $data["eventName"]; ?></b>&nbsp;&nbsp;
	  <?PHP if($tot_join >= $eventCapacity) { ?>
	  <span class="w3-small w3-tag w3-red w3-round">No Tickets Available</span>
	  <?PHP } ?>
	  </div>
	  
    <p><i class="fa fa-fw fa-calendar"></i> 
	  <?PHP echo $data["startDate"]; ?><?PHP if($data["endDate"] <> $data["startDate"]) echo " - " . $data["endDate"]; ?><br>
	  <i class="fa fa-fw fa-clock-o"></i> <?PHP echo $data["startTime"]; ?> - <?PHP echo $data["endTime"]; ?><br>
	  <i class="fa fa-fw fa-map-marker"></i> <?PHP echo $data["eventLocation"]; ?></p>
	  
	  <a href="detail.php?eventId=<?PHP echo $data["eventId"];?>" class="w3-button w3-round-xxlarge w3-blue"><b>View Details</b></a>
	</div>
	
    </div>
	
	
	</div>
	
	<div class="w3-padding-16"></div>
	<?PHP } ?>

	
  </div>
</div>
<!-- End Grid -->



<div class="w3-padding-48"></div>

	
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
