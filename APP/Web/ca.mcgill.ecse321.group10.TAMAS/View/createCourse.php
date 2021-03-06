<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<title> Create Course </title>
		<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
	    <link href="../style.css" rel="stylesheet">
	    <script
		  src="https://code.jquery.com/jquery-3.2.1.min.js"
		  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
		  crossorigin="anonymous"></script>
		<script type="text/javascript" src="../main.js"></script>
	</head>
	<?php
	$timezone = date_default_timezone_set('America/New_York');
		
	session_start();
	
	?>
	<body 
	<?php if(isset($_SESSION['dark'])) {
		if($_SESSION['dark']=="true") echo "class=\"dark\"";
	}
	?>>
		<header>
			<label class="switch">
			  <input type="checkbox" id="checkTheme">
			  <div class="slider round" id="theme"></div>
			</label>
		</header>
		<main class="course">
			<span class="intro">
				<h3>TAMAS</h3>
				<h4>Course Form</h4>
				<br>
				<p class="error">
					<?php
					if(isset($_SESSION['errorCourse']) && !empty($_SESSION['errorCourse'])){
						echo $_SESSION["errorCourse"];
					}
					?>
				</p>
				<br>
				<p class="success">
					<?php
					if(isset($_SESSION['successCourse']) && !empty($_SESSION['successCourse'])){
						echo $_SESSION["successCourse"];
					}
					?>
				</p>
			</span>
			<div class="actions">
				<form action='../Controller/validateCourse.php' method='post'>
					Course Name<input type ="text" name="courseName" required autofocus /><br><br>
					CDN<input type ="text" name="courseCDN" required/><br><br>
					Tutorial Semester Time Budget<input type ="text" name="courseTutBudget" required/><br><br>
					Lab Semester Time Budget<input type ="text" name="courseLabBudget" required/><br><br>
					Grader Semester Time Budget<input type="text" name="courseGraderBudget" required/><br><br>
					<input type= "submit" class="btn 
					<?php 
						if(isset($_SESSION['dark'])) {
							if($_SESSION['dark']=="true") echo "dark";
						}
					?>" value="Create Course"/>
				</form>
				<form action="home.php">
				    <input type="submit" class="btn 
			    	<?php 
						if(isset($_SESSION['dark'])) {
							if($_SESSION['dark']=="true") echo "dark";
						}
					?>" value="Back" />
				</form>
			</div>
		</main>
	</body>
</html>