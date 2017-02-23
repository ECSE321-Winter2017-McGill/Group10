package ca.mcgill.ecse321.group10.controller;

import ca.mcgill.ecse321.group10.TAMAS.model.Admin;
import ca.mcgill.ecse321.group10.TAMAS.model.Instructor;
import ca.mcgill.ecse321.group10.TAMAS.model.ProfileManager;
import ca.mcgill.ecse321.group10.persistence.PersistenceXStream;

public class ProfileController {
	
	private ProfileManager pm;
	
	public ProfileController(ProfileManager pm) {
		this.pm = pm;
	}
	
	public void addInstructorToSystem(String aId, String aUsername, String aPassword, String aFirstName, String aLastName){
		Instructor instructor = new Instructor(aId,aUsername,aPassword,aFirstName,aLastName);
		pm.addProfile(instructor);
		PersistenceXStream.saveToXMLwithXStream(pm);
	}
	
	public void addAdminToSystem(String aId, String aUsername, String aPassword, String aFirstName, String aLastName) {
		Admin admin = new Admin(aId,aUsername,aPassword,aFirstName,aLastName);
		pm.addProfile(admin);
		PersistenceXStream.saveToXMLwithXStream(pm);
	}
}
