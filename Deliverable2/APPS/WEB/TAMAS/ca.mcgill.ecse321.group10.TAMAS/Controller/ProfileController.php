<?php
require_once __DIR__.'\..\Controller\InputValidator.php';
require_once __DIR__.'\..\Persistence\PersistenceTAMAS.php';
require_once __DIR__.'\..\Model\ProfileManager.php';
require_once __DIR__.'\..\Model\Profile.php';
require_once __DIR__.'\..\Model\Instructor.php';


class ProfileController{

	public function __construct(){
	}
	
	public function createInstructor($aUsername, $aPassword, $aFirstName, $aLastName) {
		//1. Validate input
		$uName = InputValidator::validate_input($aUsername);
		$pass = InputValidator::validate_input($aPassword);
		$fName = InputValidator::validate_input($aFirstName);
		$lName = InputValidator::validate_input($aLastName);

		if($uName==null || strlen($uName) == 0){
			throw new Exception("Username name cannot be empty!");
		} else if($pass==null || strlen($pass) == 0){
			throw new Exception("Password name cannot be empty!");
		} elseif($fName==null || strlen($fName) == 0){
			throw new Exception("First name name cannot be empty!");
		} elseif($lName==null || strlen($lName) == 0){
			throw new Exception("Last name name cannot be empty!");
		} else {
			//2. Load all of the data
			$pt = new PersistenceTAMAS();
			$pm = $pt->loadProfileManagerFromStore();

			//3. Add the new profile
			$instructor = new Instructor($uName, $pass, $fName, $lName);
			$pm->addInstructor($instructor);

			//4. Write all the data
			$pt->writeProfileDataToStore($pm);
		}
	}
}
?>