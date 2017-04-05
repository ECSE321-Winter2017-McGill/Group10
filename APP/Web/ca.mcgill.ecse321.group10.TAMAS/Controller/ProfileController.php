<?php
require_once __DIR__.'\..\Controller\InputValidator.php';
require_once __DIR__.'\..\Persistence\PersistenceTAMAS.php';
require_once __DIR__.'\..\Model\ProfileManager.php';
require_once __DIR__.'\..\Model\Profile.php';
require_once __DIR__.'\..\Model\Instructor.php';
require_once __DIR__.'\..\Model\CourseManager.php';
require_once __DIR__.'\..\Model\Course.php';


class ProfileController{
	private $pt;
	private $pm;
	private $cm;
	
	public function __construct(){
		$this->pt = new PersistenceTAMAS();
		$this->pm = $this->pt->loadProfileManagerFromStore(); 
		$this->cm = $this->pt->loadCourseManagerFromStore();
	}
	
	public function createInstructor($aUsername, $aPassword, $aFirstName, $aLastName, $cdns) {
		// Validate input
		$error = "";
		$uName = InputValidator::validate_input($aUsername);
		$pass = InputValidator::validate_input($aPassword);
		$fName = InputValidator::validate_input($aFirstName);
		$lName = InputValidator::validate_input($aLastName);

		if($uName==null || strlen($uName) == 0){
			$error .= ("Username name cannot be empty!<br><br>");
		} 
		$Instructors = $this->pm->getInstructors();
		foreach($Instructors as $i) {
			if($i->getUsername() == $aUsername) {
				$error .= ("Username must be unique!<br><br>");
				break;
			}
		}
		if($pass==null || strlen($pass) == 0){
			$error .= ("Password name cannot be empty!<br><br>");
		} 
		if($fName==null || strlen($fName) == 0){
			$error .= ("First name name cannot be empty!<br><br>");
		} 
		if($lName==null || strlen($lName) == 0){
			$error .= ("Last name name cannot be empty!<br><br>");
		} 
		
		if(strlen($error) > 0) {
			throw new Exception($error);
		} else {
			// Add the new profile
			$instructor = new Instructor($uName, $pass, $fName, $lName);
			
			if(!empty($cdns)){
				$courses = $this->cm->getCourses();
				foreach($courses as $c){
					if(in_array($c->getCdn(), $cdns)) $instructor->addCourse($c);
				}	
			}
			
			$this->pm->addInstructor($instructor);			

			// Write all the data
			$this->pt->writeProfileDataToStore($this->pm);
		}
	}
	
	public function validate($aUsername, $aPassword) {
		// Validate input
		$error = "";
		$uName = InputValidator::validate_input($aUsername);
		$pass = InputValidator::validate_input($aPassword);
		
		if($uName==null || strlen($uName) == 0){
			$error = ("Username name cannot be empty!<br><br>");
		}
		if($pass==null || strlen($pass) == 0){
			$error = ("Password name cannot be empty!<br><br>");
		}
		
		if($uName == "admin" && $pass == "admin") {
			// Do nothing for admin
		} else {		
			$Instructors = $this->pm->getInstructors();
			$found = FALSE;
			foreach($Instructors as $i) {
				if($i->getUsername() == $aUsername && $i->getPassword() == $pass) {
					$found = TRUE;
					break;
				}
			}
			if(!$found) $error = ("Couldn't find username/password!<br><br>");
			if(strlen($error) > 0) {
				throw new Exception($error);
			}
		}
	}
	
	public function updateProfile($aUsername,$aFirstName,
			$aLastName, $anOldPassword, $aNewPassword) {
		
		// Validate input
		$error = "";
		$uName = InputValidator::validate_input($aUsername);
		$fName = InputValidator::validate_input($aFirstName);
		$lName = InputValidator::validate_input($aLastName);
		$oldPass = InputValidator::validate_input($anOldPassword);
		$newPass = InputValidator::validate_input($aNewPassword);
		
// 		if((strcmp($fName,"XXX") != 0) && $fName==null || strlen($fName) == 0){
// 			$error .= ("First name name cannot be empty!<br><br>");
// 		}
// 		if($lName != "XXX" && $lName==null || strlen($lName) == 0){
// 			$error .= ("Last name name cannot be empty!<br><br>");
// 		}
// 		if($oldPass != "XXX" && $oldPass==null || strlen($oldPass) == 0){
// 			$error .= ("Old Password name cannot be empty!<br><br>");
// 		}
// 		if($newPass1 != "XXX" && $newPass1==null || strlen($newPass1) == 0){
// 			$error .= ("First New Password name cannot be empty!<br><br>");
// 		}
// 		if($newPass2 != "XXX" && $newPass2==null || strlen($newPass2) == 0){
// 			$error .= ("Password name cannot be empty!<br><br>");
// 		}
// 		if($newPass1 != $newPass2){
// 			$error .= ("New Passwords don't match!<br><br>");
// 		}
		
		if($uName == "admin" && $pass == "admin") {
			// Do nothing for admin
		} else {
			$Instructors = $this->pm->getInstructors();
			$profile = null;
			foreach($Instructors as $i) {
				if($i->getUsername() == $aUsername) {
					$profile = $i;
					break;
				}
			}
			if($profile==null) $error .= ("Invalid password!<br><br>");
			if(strlen($error) > 0) {
				throw new Exception($error);
			} else {
				if($fName != "XXX") $profile->setFirstName($fName);
				if($lName != "XXX") $profile->setLastName($lName);
				if($newPass != "XXX") $profile->setPassword($newPass);
				

				// Write all the data
				$this->pt->writeProfileDataToStore($this->pm);
			}
		}
	}
}
?>