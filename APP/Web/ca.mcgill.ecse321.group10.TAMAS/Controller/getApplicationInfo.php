<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'ApplicationController.php';

// getter script for application information

$ac = new ApplicationController();

if(isset($_POST['cdn'])){
	// retrieve applications of input course
	echo $ac->getApplications($_POST['cdn']);
} else if (isset($_POST['id'])) {
	// retrieve information of input application
	echo $ac->getApplicationInfo($_POST['id']); 
}
?>