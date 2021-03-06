<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<title> Post Job Offer </title>
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
	
	require_once __DIR__. DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR .'Persistence'. DIRECTORY_SEPARATOR .'PersistenceTAMAS.php';
	require_once __DIR__. DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR .'Model'. DIRECTORY_SEPARATOR .'ProfileManager.php';
	require_once __DIR__. DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR .'Model'. DIRECTORY_SEPARATOR .'Profile.php';
	require_once __DIR__. DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR .'Model'. DIRECTORY_SEPARATOR .'Instructor.php';
	require_once __DIR__. DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR .'Model'. DIRECTORY_SEPARATOR .'CourseManager.php';
	require_once __DIR__. DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR .'Model'. DIRECTORY_SEPARATOR .'Course.php';
	
	session_start();
	
	//Retrieve the data from the model
	$pt = new PersistenceTAMAS();
	$pm = $pt->loadProfileManagerFromStore();
	
	$profile = null;
	$profiles = $pm->getInstructors();
	foreach ($profiles as $p){
		if($p->getUsername() == $_SESSION['username']) {
			$profile = $p;
			break;
		}
	}
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
		<main class="job">
			<span class="intro">
				<h3>TAMAS</h3>
				<h4>Job Form</h4>
				<br><br>
				TA:<br>
				<p id="tutHours"></p>
				<br>
				<p id="labHours"></p>
				<br><br>
				<p id="Graderhours"> </p>
				<br><br>
				<hr>
				<p id="ApplicationInfo"> </p><br><br>
				<p class="error">
					<?php
					if(isset($_SESSION['errorJob']) && !empty($_SESSION['errorJob'])){
						echo $_SESSION["errorJob"];
					}
					?>
				</p>
				<br>
				<p class="success">
					<?php
					if(isset($_SESSION['successJob']) && !empty($_SESSION['successJob'])){
						echo $_SESSION["successJob"];
					}
					?>
				</p>
			</span>
			<div class="actions">
				<form action='../Controller/validateJob.php' id="form" method='post'>
					Course CDN<br><select name='jobCourseCDN' id="courseCDN">
						<?php foreach ($profile->getCourses() as $course){?>
							<option value="<?php echo $course->getCdn(); ?>"><?php echo $course->getClassName(); ?></option>
						<?php }?>
					</select><br><br>		
					<div id="info">
						Position<br>
						<label id="tut"><input type="radio" name="jobPosition" value="PositionTUTORIAL" >Tutorial (TA)</label><br>
						<label id="lab"><input type="radio" name="jobPosition" value="PositionLABORATORY" >Laboratoire (TA)</label><br>
						<label id="grader"><input type="radio" name="jobPosition" value="PositionGRADER" >Grader</label><br><br>
						Requirements
						<textarea class="text" cols="20" rows ="5" name="jobRequirements" maxlength="100" reqired></textarea><br><br>	
						Hourly Salary<input type ="text" name="jobSalary" required/><br><br>
						Available Day<select name="jobDay">
							<option value="monday">Monday</option>
							<option value="tuesday">Tuesday</option>
							<option value="wednesday">Wednesday</option>
							<option value="thursday">Thursday</option>
							<option value="friday">Friday</option>
						</select><br><br>
						Hours/Semester<input type ="text" name="jobTime"/><br><br><br>
						<input type= "submit" class="btn 
						<?php 
							if(isset($_SESSION['dark'])) {
								if($_SESSION['dark']=="true") echo "dark";
							}
						?>" name="submit" value="Publish"/>
					</form>
				</div>
				<form action="home.php">
						<input type="submit" class="btn 
						<?php 
							if(isset($_SESSION['dark'])) {
								if($_SESSION['dark']) echo "dark";
							}
						?>" value="Back" />
				</form>
			</div>
		</main>
	</body>
</html>
