/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.24.0-dab6b48 modeling language!*/

package ca.mcgill.ecse321.group10.TAMAS.model;
import java.util.*;

// line 3 "../../../../../../alternatemodel.ump"
// line 91 "../../../../../../alternatemodel.ump"
public class Course
{

  //------------------------
  // MEMBER VARIABLES
  //------------------------

  //Course Attributes
  private String className;
  private int cdn;
  private float graderBudget;
  private float tutorialBudget;
  private float labBudget;

  //Course Associations
  private List<Job> jobs;

  //------------------------
  // CONSTRUCTOR
  //------------------------

  public Course(String aClassName, int aCdn, float aGraderBudget, float aTutorialBudget, float aLabBudget)
  {
    className = aClassName;
    cdn = aCdn;
    graderBudget = aGraderBudget;
    tutorialBudget = aTutorialBudget;
    labBudget = aLabBudget;
    jobs = new ArrayList<Job>();
  }

  //------------------------
  // INTERFACE
  //------------------------

  public boolean setClassName(String aClassName)
  {
    boolean wasSet = false;
    className = aClassName;
    wasSet = true;
    return wasSet;
  }

  public boolean setGraderBudget(float aGraderBudget)
  {
    boolean wasSet = false;
    graderBudget = aGraderBudget;
    wasSet = true;
    return wasSet;
  }

  public boolean setTutorialBudget(float aTutorialBudget)
  {
    boolean wasSet = false;
    tutorialBudget = aTutorialBudget;
    wasSet = true;
    return wasSet;
  }

  public boolean setLabBudget(float aLabBudget)
  {
    boolean wasSet = false;
    labBudget = aLabBudget;
    wasSet = true;
    return wasSet;
  }

  public String getClassName()
  {
    return className;
  }

  public int getCdn()
  {
    return cdn;
  }

  public float getGraderBudget()
  {
    return graderBudget;
  }

  public float getTutorialBudget()
  {
    return tutorialBudget;
  }

  public float getLabBudget()
  {
    return labBudget;
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

  public static int minimumNumberOfJobs()
  {
    return 0;
  }

  public Job addJob(float aHours, String aDay, double aSalary, String aRequirements, Instructor aInstructor)
  {
    return new Job(aHours, aDay, aSalary, aRequirements, this, aInstructor);
  }

  public boolean addJob(Job aJob)
  {
    boolean wasAdded = false;
    if (jobs.contains(aJob)) { return false; }
    Course existingCourse = aJob.getCourse();
    boolean isNewCourse = existingCourse != null && !this.equals(existingCourse);
    if (isNewCourse)
    {
      aJob.setCourse(this);
    }
    else
    {
      jobs.add(aJob);
    }
    wasAdded = true;
    return wasAdded;
  }

  public boolean removeJob(Job aJob)
  {
    boolean wasRemoved = false;
    //Unable to remove aJob, as it must always have a course
    if (!this.equals(aJob.getCourse()))
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

  public void delete()
  {
    while (jobs.size() > 0)
    {
      Job aJob = jobs.get(jobs.size() - 1);
      aJob.delete();
      jobs.remove(aJob);
    }
    
  }


  public String toString()
  {
    String outputString = "";
    return super.toString() + "["+
            "className" + ":" + getClassName()+ "," +
            "cdn" + ":" + getCdn()+ "," +
            "graderBudget" + ":" + getGraderBudget()+ "," +
            "tutorialBudget" + ":" + getTutorialBudget()+ "," +
            "labBudget" + ":" + getLabBudget()+ "]"
     + outputString;
  }
}