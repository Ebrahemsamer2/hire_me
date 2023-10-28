# Hire Me
#### Video Demo:  https://youtu.be/NPlfYw3JrwE
#### Description: 

Searching for a job? Hire Me helps you to find your dream job and it will help employers around the world to find talents.

Hire Me is an online website helps employees and employers to find their needs.

Hire Me provides a simple way to apply for a job and interact with companies in case your application viewed.

You can sign up as employee and start applying for jobs, or you can sign up as employer and posting jobs through a simple form and 

start searching for talents to hire.

Hire me provides simple way for employers to view applications and download applicants resumes.

As Employee you will know that your resume has been downloaded from the company account and no one else can access your resume.

In job listing page you will see a simple sidebar to filter your jobs by category, location, job nature and years of experience.

you will have a list of category in categories page so you can view all jobs in a specific category.

The project structure is as following:

- assets folder: responsible for resources like css, js, bootstrap css files, avatars and resume uploaded by users.
- includes folder: files that included at every page in the website like footer and headers and vew scripts.
- Models: core of application that have all classes and DB Managers

    - Models\DB: ( mysql database ) Connection and DB Manager.
    - User, Category, Job, JobUser, Session: All these classes represents DB tables and relation between tables and each other.

- process: folder that responsible for process ajax calls from javascript files.

Other files in the root:

- register: used for displaying form to register as employee or employer and used assets/js/models/user.js to save information using ajax and other process files.

- init.php: this file including the main classes and essentials files needed to run the project.

- 404.php: displaying static page for errors and non existing pages or error in data provided.

- index.php: Display the main project/website page.

- about.php: static page displaying some static information about the company.

- contact.php: display a form for user to send a message for website.

- contact_process.php: Saing contact information and send email for the user.

- db_setup.sql: DB tables queries in case other github user wanted to contribute and run aplication faster on his machine.

- login.php: used for displaying form to login and used assets/js/models/user.js to save information using ajax and other process files.

- profile.php: update user information and/or uploading resume or avatar for that user.

- new_job.php: creating a new job and allawed only for companies to access this file.

- myjobs.php: displaying current company posted jobs or displaying current employee jobs that applied for.

- job_listing.php: list latest 10 jobs in the website and loading other 10 while scolling and it has sidebar to filter jobs by category, locations, job nature and years of experience.

- job_details.php: display a single job by using its slug to identify it and in this page you can read all info about the job and apply for the job.

- job_categories.php: display all categories with count of jobs inside each.

- job_applicants.php: displaying single job applicants who applied for that job. 

