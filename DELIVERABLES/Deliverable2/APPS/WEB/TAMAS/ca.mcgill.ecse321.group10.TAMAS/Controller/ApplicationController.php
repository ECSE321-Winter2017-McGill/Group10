<?php
require_once __DIR__.'\.\InputValidator.php';
require_once __DIR__.'\..\Persistence\PersistenceTAMAS.php';
require_once __DIR__.'\..\Model\ApplicationManager.php';
require_once __DIR__.'\..\Model\Application.php';
require_once __DIR__.'\..\Model\Job.php';
require_once __DIR__.'\..\Model\ProfileManager.php';
require_once __DIR__.'\..\Model\Profile.php';
require_once __DIR__.'\..\Model\Instructor.php';
require_once __DIR__.'\..\Model\CourseManager.php';
require_once __DIR__.'\..\Model\Course.php';

class ApplicationController{
	private $pt;
	private $am;
	private $pm;
	private $cm;
	
	public function __construct(){
		$this->pt = new PersistenceTAMAS();
		$this->am = $this->pt->loadApplicationManagerFromStore();
		$this->pm = $this->pt->loadProfileManagerFromStore();
		$this->cm = $this->pt->loadCourseManagerFromStore();
	}
	
	public function createJob($startTime, $endTime, $aDay, $aPosition, $aSalary, 
							$aRequirements, $aCourse, $anInstructor) {
		//Validate primitive var input
		$error = "";
		$requirements = InputValidator::validate_input($aRequirements);

		if($requirements==null || strlen($requirements) == 0){
			$error .= ("Requirements cannot be empty!<br>");
		} 
		if(!is_numeric($aSalary)) {
			$error .= ("Salary must be a non null Integer!<br>");
		}
		
		if(strlen($error) > 0) {
			throw new Exception($error);
		} else {
			// validate reference var input
			$myInstructor = NULL;
			foreach ($this->pm->getInstructors() as $instructor){
				if(strcmp($instructor->getUsername(), $anInstructor)==0){
					$myInstructor = $instructor;
					break;
				}
			}
			// Find the event
			$myCourse = NULL;
			foreach ($this->cm->getCourses() as $course){
				if(strcmp($course->getCdn(), $aCourse) ==0){
					$myCourse = $course;
					break;
				}
			}
			
			// Register for the event
			if ($myInstructor != NULL && $myCourse != NULL){
				// TODO here is where the fatal error on line 101 of applicationmanager originates.
				// it implies that myJob wasnt correctly instanciated as a new Job.
				// but no exception is catched from the constuctor of Job
				try {
					$myJob = new Job($startTime, $endTime, $aDay, 
							$aSalary, $requirements, $myCourse, $myInstructor);
					$myJob->setPosition($aPosition);
					$this->am->addJob($myJob);
				} catch (Exception $e){
					echo $e->getMessage();
				}
				
				
				
				// Write all the data
				$this->pt->writeApplicationDataToStore($this->am);
			} else {
				if($myInstructor == NULL){
					$error .= "Instructor not found!<br>";
				}
				if ($myCourse == NULL){
					$error .= "Course not found!<br>";
				}
				throw new Exception(trim($error));
			}
		}
	}

// KEPT FOR FUTURE DELIVERABLES
// 	public function deleteJob($jobID) {
// 		$error = "";
		
// 		$myJob = NULL;
// 		foreach ($this->am->getJobs() as $job){
// 			if(strcmp($job->getId(), $jobID) ==0){
// 				$myjob = $job;
// 				break;
// 			}
// 		}
			
// 		if ($myjob != NULL){
// 			// Delete posting
// 			$this->am->removeJob($myjob);
		
// 			// Write all the data
// 			$this->pt->writeApplicationDataToStore($this->am);
// 		} else {
// 			$error .= "Job Application not found!<br>";
// 			throw new Exception(trim($error));
// 		}
// 	}
	
// 	public function publishJob($jobID) {
// 		$error = "";
		
// 		$myJob = NULL;
// 		foreach ($this->am->getJobs() as $job){
// 			if(strcmp($job->getId(), $jobID) ==0){
// 				$myjob = $job;
// 				break;
// 			}
// 		}
			
// 		if ($myjob != NULL){
// 			// Delete posting
// 			$this->am->publishJob($myjob);  //TODO MUST IMPLEMENT A FLAG TO PUBLISH
		
// 			// Write all the data
// 			$this->pt->writeApplicationDataToStore($this->am);
// 		} else {
// 			$error .= "Job Application not found!<br>";
// 			throw new Exception(trim($error));
// 		}
// 	}
}
?>