<?php
require_once __DIR__.'\.\InputValidator.php';
require_once __DIR__.'\..\Persistence\PersistenceTAMAS.php';
require_once __DIR__.'\..\Model\ApplicationManager.php';
require_once __DIR__.'\..\Model\Application.php';
require_once __DIR__.'\..\Model\ProfileManager.php';
require_once __DIR__.'\..\Model\Profile.php';
require_once __DIR__.'\..\Model\CourseManager.php';
require_once __DIR__.'\..\Model\Course.php';

class ApplicationController{
	
	public function __construct(){
	}
	
	public function createJob($startTime, $endTime, $aSalary, 
							$aRequirements, $aCourse, $anInstructor) {
		//1. Validate primitive var input
		$error = "";
// 		$startTime = InputValidator::validate_date($startTime);			//TODO check with harley how he validated date
// 		$endTime = InputValidator::validate_date($endTime);
		$requirements = InputValidator::validate_input($requirements);

		
		if($requirements==null || strlen($requirements) == 0){
			$error .= ("Requirements cannot be empty!<br>");
		} 
		if(!is_numeric($aSalary)) {
			$error .= ("Salary must be a non null Integer!<br>");
		}
		
		if(strlen($error) > 0) {
			throw new Exception($error);
		} else {
			//2. Load all of the data
			$pt = new PersistenceTAMAS();
			$am = $pt->loadApplicationManagerFromStore();
			$pm = $pt->loadProfileManagerFromStore();
			$cm = $pt->loadCourseManagerFromStore();

			
			// validate reference var input
			$myIntstuctor = NULL;
			foreach ($pm->getInstructors() as $instructor){
				if(strcmp($instructor->getUsername(), $anInstructor)==0){
					$myIntstuctor = $instructor;
					break;
				}
			}
			//3. Find the event
			$myCourse = NULL;
			foreach ($cm->getCourses() as $course){
				if(strcmp($course->getCdn(), $aCourse) ==0){
					$myCourse = $course;
					break;
				}
			}
			
			//4. Register for the event
			if ($myIntstuctor != NULL && $myCourse != NULL){
				$myJob = new Job($startTime, $endTime, $aSalary, $requirements, $myCourse, $myInstructor);
				$am->addJob($job);
				
				//4. Write all the data
				$pt->writeApplicationDataToStore($am);
			} else {
				if($myIntstuctor == NULL){
					$error .= "Instructor not found!<br>";
				}
				if ($myCourse == NULL){
					$error .= "Course not found!<br>";
				}
				throw new Exception(trim($error));
			}
		}
	}
}
?>