<?php
class PersistenceTAMAS {
	// persistent filenames of managers
	private $filenameAM;
	private $filenamePM;
	private $filenameCM;
	
	function __construct($filenameAM = '../output/applications.txt',
						$filenamePM = '../output/profiles.txt',
						$filenameCM = '../output/courses.txt') {
		$this->filenameAM = $filenameAM;
		$this->filenamePM = $filenamePM;
		$this->filenameCM = $filenameCM;
	}

	function loadApplicationManagerFromStore(){
		if (file_exists ($this->filenameAM)){
			$str = file_get_contents($this->filenameAM);
			$am = unserialize($str);
		} else {
			$am = new ApplicationManager();
		}
		return $am;
	}
	
	function loadProfileManagerFromStore(){
		if (file_exists ($this->filenamePM)){
			$str = file_get_contents($this->filenamePM);
			$pm = unserialize($str);
		} else {
			$pm = new ProfileManager();
		}
		return $pm;
	}
	
	function loadCourseManagerFromStore(){
		if (file_exists ($this->filenameCM)){
			$str = file_get_contents($this->filenameCM);
			$cm = unserialize($str);
		} else {
			$cm = new CourseManager();
		}
		return $cm;
	}
	

	function writeApplicationDataToStore($am) {
		$str = serialize($am);
		file_put_contents($this->filenameAM, $str);
	}
	
	function writeProfileDataToStore($pm) {
		$str = serialize($pm);
		file_put_contents($this->filenamePM, $str);
	}
	
	function writeCourseDataToStore($cm) {
		$str = serialize($cm);
		file_put_contents($this->filenameCM, $str);
	}
}
?>