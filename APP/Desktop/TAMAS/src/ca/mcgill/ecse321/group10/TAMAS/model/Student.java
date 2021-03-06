/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.24.0-dab6b48 modeling language!*/

package ca.mcgill.ecse321.group10.TAMAS.model;
import java.util.*;

// line 41 "../../../../../../alternatemodel.ump"
// line 120 "../../../../../../alternatemodel.ump"
public class Student extends Profile
{

  //------------------------
  // MEMBER VARIABLES
  //------------------------

  //Student Attributes
  private float hoursLeft;
  private String experience;

  //Student State Machines
  public enum Degree { UNDERGRAD, GRADUATE }
  private Degree degree;

  //Student Associations
  private List<Job> jobs;
  private List<Application> applications;

  //------------------------
  // CONSTRUCTOR
  //------------------------

  public Student(String aUsername, String aPassword, String aFirstName, String aLastName, String aExperience)
  {
    super(aUsername, aPassword, aFirstName, aLastName);
    hoursLeft = 0.0f;
    experience = aExperience;
    jobs = new ArrayList<Job>();
    applications = new ArrayList<Application>();
    setDegree(Degree.UNDERGRAD);
  }

  //------------------------
  // INTERFACE
  //------------------------

  public boolean setHoursLeft(float aHoursLeft)
  {
    boolean wasSet = false;
    hoursLeft = aHoursLeft;
    wasSet = true;
    return wasSet;
  }

  public boolean setExperience(String aExperience)
  {
    boolean wasSet = false;
    experience = aExperience;
    wasSet = true;
    return wasSet;
  }

  public float getHoursLeft()
  {
    return hoursLeft;
  }

  public String getExperience()
  {
    return experience;
  }

  public String getDegreeFullName()
  {
    String answer = degree.toString();
    return answer;
  }

  public Degree getDegree()
  {
    return degree;
  }

  public boolean setDegree(Degree aDegree)
  {
    degree = aDegree;
    return true;
  }

  public Job getJob(int index)
  {
    Job aJob = jobs.get(index);
    return aJob;
  }

  public List<Job> getJobs()
  {
    List<Job> newJobs = Collections.unmodifiableList(jobs);
    return newJobs;
  }

  public int numberOfJobs()
  {
    int number = jobs.size();
    return number;
  }

  public boolean hasJobs()
  {
    boolean has = jobs.size() > 0;
    return has;
  }

  public int indexOfJob(Job aJob)
  {
    int index = jobs.indexOf(aJob);
    return index;
  }

  public Application getApplication(int index)
  {
    Application aApplication = applications.get(index);
    return aApplication;
  }

  public List<Application> getApplications()
  {
    List<Application> newApplications = Collections.unmodifiableList(applications);
    return newApplications;
  }

  public int numberOfApplications()
  {
    int number = applications.size();
    return number;
  }

  public boolean hasApplications()
  {
    boolean has = applications.size() > 0;
    return has;
  }

  public int indexOfApplication(Application aApplication)
  {
    int index = applications.indexOf(aApplication);
    return index;
  }

  public static int minimumNumberOfJobs()
  {
    return 0;
  }

  public boolean addJob(Job aJob)
  {
    boolean wasAdded = false;
    if (jobs.contains(aJob)) { return false; }
    jobs.add(aJob);
    wasAdded = true;
    return wasAdded;
  }

  public boolean removeJob(Job aJob)
  {
    boolean wasRemoved = false;
    if (jobs.contains(aJob))
    {
      jobs.remove(aJob);
      wasRemoved = true;
    }
    return wasRemoved;
  }

  public boolean addJobAt(Job aJob, int index)
  {  
    boolean wasAdded = false;
    if(addJob(aJob))
    {
      if(index < 0 ) { index = 0; }
      if(index > numberOfJobs()) { index = numberOfJobs() - 1; }
      jobs.remove(aJob);
      jobs.add(index, aJob);
      wasAdded = true;
    }
    return wasAdded;
  }

  public boolean addOrMoveJobAt(Job aJob, int index)
  {
    boolean wasAdded = false;
    if(jobs.contains(aJob))
    {
      if(index < 0 ) { index = 0; }
      if(index > numberOfJobs()) { index = numberOfJobs() - 1; }
      jobs.remove(aJob);
      jobs.add(index, aJob);
      wasAdded = true;
    } 
    else 
    {
      wasAdded = addJobAt(aJob, index);
    }
    return wasAdded;
  }

  public static int minimumNumberOfApplications()
  {
    return 0;
  }

  public Application addApplication(Job aJobs)
  {
    return new Application(this, aJobs);
  }

  public boolean addApplication(Application aApplication)
  {
    boolean wasAdded = false;
    if (applications.contains(aApplication)) { return false; }
    Student existingStudent = aApplication.getStudent();
    boolean isNewStudent = existingStudent != null && !this.equals(existingStudent);
    if (isNewStudent)
    {
      aApplication.setStudent(this);
    }
    else
    {
      applications.add(aApplication);
    }
    wasAdded = true;
    return wasAdded;
  }

  public boolean removeApplication(Application aApplication)
  {
    boolean wasRemoved = false;
    //Unable to remove aApplication, as it must always have a student
    if (!this.equals(aApplication.getStudent()))
    {
      applications.remove(aApplication);
      wasRemoved = true;
    }
    return wasRemoved;
  }

  public boolean addApplicationAt(Application aApplication, int index)
  {  
    boolean wasAdded = false;
    if(addApplication(aApplication))
    {
      if(index < 0 ) { index = 0; }
      if(index > numberOfApplications()) { index = numberOfApplications() - 1; }
      applications.remove(aApplication);
      applications.add(index, aApplication);
      wasAdded = true;
    }
    return wasAdded;
  }

  public boolean addOrMoveApplicationAt(Application aApplication, int index)
  {
    boolean wasAdded = false;
    if(applications.contains(aApplication))
    {
      if(index < 0 ) { index = 0; }
      if(index > numberOfApplications()) { index = numberOfApplications() - 1; }
      applications.remove(aApplication);
      applications.add(index, aApplication);
      wasAdded = true;
    } 
    else 
    {
      wasAdded = addApplicationAt(aApplication, index);
    }
    return wasAdded;
  }

  public void delete()
  {
    jobs.clear();
    while (applications.size() > 0)
    {
      Application aApplication = applications.get(applications.size() - 1);
      aApplication.delete();
      applications.remove(aApplication);
    }
    
    super.delete();
  }


  public String toString()
  {
    String outputString = "";
    return super.toString() + "["+
            "hoursLeft" + ":" + getHoursLeft()+ "," +
            "experience" + ":" + getExperience()+ "]"
     + outputString;
  }
}