package ca.mcgill.ecse321.group10.tamas;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Spinner;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;

import ca.mcgill.ecse321.group10.TAMAS.model.Application;
import ca.mcgill.ecse321.group10.TAMAS.model.ApplicationManager;
import ca.mcgill.ecse321.group10.TAMAS.model.Job;
import ca.mcgill.ecse321.group10.TAMAS.model.ProfileManager;
import ca.mcgill.ecse321.group10.TAMAS.model.Student;
import ca.mcgill.ecse321.group10.controller.ApplicationController;
import ca.mcgill.ecse321.group10.controller.ProfileController;

public class BrowseEvals extends AppCompatActivity {


    private TextView evaluations;
    private Spinner evalSpinner;
    TextView errors;

    private ProfileManager pm;
    private ApplicationManager am;

    private ProfileController pc;
    private ApplicationController ac;


    ArrayList<Job> jobs = null;
    Student student = null;
    List<Application> applications = null;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_browse_evals);

        evalSpinner = (Spinner) findViewById(R.id.EvalSpinner);
        evaluations = (TextView) findViewById(R.id.Evaluations);
        errors = (TextView) findViewById(R.id.evalErrors);

        pm = ((TAMAS) getApplication()).getProfileManager();
        am = ((TAMAS) getApplication()).getApplicationManager();
        ac = ((TAMAS) getApplication()).getApplicationController();
        pc = ((TAMAS)getApplication()).getProfileController();

        jobs = new ArrayList<Job>();

        student = ((TAMAS) getApplication()).getStudent();


        if (student == null){
            TextView errors = (TextView) findViewById(R.id.evalErrors);
            errors.setText("Please Login first");
            return;
        }
        else{
            setupPage();
        }

        evalSpinner.setOnItemSelectedListener(
                //create item listener to allow user to acccept job offer by pressing enter
                new AdapterView.OnItemSelectedListener(){

                    @Override
                    public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                        Job selectedJob = jobs.get(position); //job index within jobs should be at the same index as jobNames from the adapter
                        setEvaluationDescription(selectedJob);
                    }

                    @Override
                    public void onNothingSelected(AdapterView<?> parent) {
                        //do nothing
                    }
                });
    }

    private void setEvaluationDescription(Job job){
        String eval = job.getApplication(0).getStudentEvaluation();
        if(eval.length() == 0 || eval == null){
            evaluations.setText("No Evaluation Exists for you");
        }
        else{
            String description = "Evaluation:\n\n" + eval;
            evaluations.setText(description);
        }


    }


    @Override
    public void onResume(){
        super.onResume();
        student = ((TAMAS)this.getApplication()).getStudent();

        if (student == null){
            errors.setText("Please Login first");
        }
        else{
            this.setupPage();
            errors.setText("");
        }
    }


    private void setupPage(){

        applications = am.getApplications();

        jobs.clear();

        for (Application application:applications){
            //type in the model - jobs is a single job
            //if the application has been offered and is the student's application, add it to jobs
            Log.d("evals","Application: " + application.toString() + "\n" + "accepted?: " + application.isOfferAccepted()
                    + "\nstudent: " + application.getStudent().getUsername() + "\n\n");
            String appStudent = application.getStudent().getUsername();
            String curStudent = student.getUsername();
            if(application.isOfferAccepted() && appStudent.equals(curStudent)){
                Job job = application.getJobs();
                jobs.add(job);
                Log.d("evals","job found: " + job.getPositionFullName().toString());
            }
        }

        //get string of job names
        Log.d("evals","#jobs: " + jobs.size());
        String [] jobNames = new String[jobs.size()];

        for(int c = 0; c < jobNames.length; c++) {
            jobNames[c] = jobs.get(c).getCourse().getClassName() + ": " + jobs.get(c).getPositionFullName();
        }
        final ArrayAdapter<String> jobAdapter = new ArrayAdapter<String>(this,
                android.R.layout.simple_spinner_item, jobNames);
        evalSpinner.setAdapter(jobAdapter);


    }
}
