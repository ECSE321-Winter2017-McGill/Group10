package ca.mcgill.ecse321.group10.view;

import java.awt.Dimension;

import javax.swing.BoxLayout;
import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.WindowConstants;

import ca.mcgill.ecse321.group10.TAMAS.model.ApplicationManager;
import ca.mcgill.ecse321.group10.TAMAS.model.CourseManager;
import ca.mcgill.ecse321.group10.TAMAS.model.ProfileManager;

public class MenuView extends JFrame{
	
	private static final int X_SIZE = 300;
	private static final int Y_SIZE = 300;

	private JLabel greeting;
	private JLabel error;
	private JButton applicationButton;
	private JButton publishButton;
	private JButton profileButton;
	private JButton courseButton;
	
	private ApplicationManager am;
	private ProfileManager pm;
	private CourseManager cm;
	
	public MenuView(ApplicationManager am, ProfileManager pm, CourseManager cm) {
		this.am = am;
		this.pm = pm;
		this.cm = cm;
		initComponents();
	}
	
	private void initComponents() {
		greeting = new JLabel();
		error = new JLabel();
		applicationButton = new JButton();
		publishButton = new JButton();
		profileButton = new JButton();
		courseButton = new JButton();
		
		setDefaultCloseOperation(WindowConstants.EXIT_ON_CLOSE);
		setTitle("Main Control Center");
		
		greeting.setText("Welcome to TAMAS. Power is in your hands.");
		applicationButton.setText("Create Job Application");
		publishButton.setText("Publish Job Posting");
		profileButton.setText("Register Profile");
		courseButton.setText("Create Course");
		
		profileButton.addActionListener(new java.awt.event.ActionListener(){
			public void actionPerformed(java.awt.event.ActionEvent e) {
				profilePressed();
			}
		});
		
		courseButton.addActionListener(new java.awt.event.ActionListener(){
			public void actionPerformed(java.awt.event.ActionEvent e) {
				coursePressed();
			}
		});
		
		publishButton.addActionListener(new java.awt.event.ActionListener(){
			public void actionPerformed(java.awt.event.ActionEvent e) {
				if(cm.getCourses().size() > 0) {
					new PublishJobView(am,pm,cm).setVisible(true);
					error.setText("");
				}
				else error.setText("No courses are available. Please create a course.");
				pack();
			}
		});
		
		applicationButton.addActionListener(new java.awt.event.ActionListener(){
			public void actionPerformed(java.awt.event.ActionEvent e) {
				if(am.getJobs().size() > 0) {
					new ApplicationView(am,pm).setVisible(true);
					error.setText("");
				}
				else error.setText("No jobs available.");
				pack();
			}
		});
		
		JPanel panel = new JPanel();
		panel.setLayout(new BoxLayout(panel,BoxLayout.Y_AXIS));
		
		panel.add(greeting);
		panel.add(error);
		panel.add(profileButton);
		panel.add(courseButton);
		panel.add(publishButton);
		panel.add(applicationButton);
		
		this.add(panel);
		this.setSize(new Dimension(X_SIZE,Y_SIZE));
		pack();
	}
	
	private void profilePressed() {
		new RegistrationView(pm).setVisible(true);
		error.setText("");
		pack();
	}
	
	private void coursePressed() {
		if(pm.getInstructors().size() > 0) {
			new CreateCourseView(cm,pm).setVisible(true);
			error.setText("");
		}
		else error.setText("No instructors available. Please register an instructor profile.");
		pack();
	}
	
}
