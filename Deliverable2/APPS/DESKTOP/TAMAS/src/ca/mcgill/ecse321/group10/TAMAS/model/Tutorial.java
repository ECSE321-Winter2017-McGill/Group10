/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.24.0-dab6b48 modeling language!*/

package ca.mcgill.ecse321.group10.TAMAS.model;
import java.sql.Date;
import java.util.*;

// line 23 "../../../../../../alternatemodel.ump"
// line 98 "../../../../../../alternatemodel.ump"
public class Tutorial extends Job
{

  //------------------------
  // MEMBER VARIABLES
  //------------------------

  //------------------------
  // CONSTRUCTOR
  //------------------------

  public Tutorial(Date aStartTime, Date aEndTime, double aSalary, String aRequirements, Course aCourse, Instructor aInstructor)
  {
    super(aStartTime, aEndTime, aSalary, aRequirements, aCourse, aInstructor);
  }

  //------------------------
  // INTERFACE
  //------------------------

  public void delete()
  {
    super.delete();
  }

}