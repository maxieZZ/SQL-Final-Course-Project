# Implementation of a Hospital Management Database
Max Grice
CIS 451 Final Project

<details>

<summary>Project Summary</summary>

In this project, I will be modeling data existing in a typical hospital setting. This would include things like patient appointment records and associated information, in addition to records kept on associated staff members like doctors and nurses. Organizing this kind of data into a logical database structure will allow users to search for specific patient information and look for trends in diagnostic data and treatments. Users will also be able to search for doctors by their associated department and view room occupation records.

When deciding how to organize this data, I first decided on the four main hospital features that I would focus my queries on (these are listed and explained in further detail below).

1) Employees
2) Patients
3) Treatments
4) Rooms

Logically, I could use ISA relationships via foreign keys to split the Employee table into two major types: Nurse and Doctor. From the doctor table, I could split this even further into resident, visiting and attending doctor subtypes. This type of hierarchical organization through ISA relationships was important because it would provide the potential to search for various employee subtypes and also to see the relationships among these subtypes (for example which attending doctors are supervising which residents). While the employees share basic attributes like an employee id, salary, age, and sex, splitting them into subtypes also allowed me to add unique attributes based on the subtype (eg attending doctors have a speciality while visiting have an origin of residence.

Patients are another vital category and table in my hospital database because they provide the data needed to analyze treatment success and search for room occupancy history. Patients are identified by a unique id and have an age, sex, name, doctor, and room number.

Treatments were also important because it allowed me to use patient information in order to analyze the success rate of the hospital in terms of patient care. This data would be valuable to any hospital seeking to identify its most effective treatment methods because it would allow them to not only advertise this to patients but also to improve upon treatments that may not have been as successful as expected.  

The final main area of focus, rooms, is important in a hospital database because it allows personnel to not only search for where certain patients are currently residing, but also to determine which rooms are available versus occupied. This feature would be valuable in any busy hospital settings where patients are admitted and discharged at all times throughout the day, making it easy to loose track of where they are or which rooms are still open for admission. 

</details>

<details>

<summary>Logical Design</summary>

Before writing the code to create my relational databases in MySQL Workbench, I drafted a rough ER diagram using Chen Notation. The diagram allowed me to detail the most important aspects of a hospital that I wanted to represent (based on the applications that were explained in the project summary). It also allowed me to describe how each entity might be related to other entities and the specific attributes contained as shown below:

<img src="images/im1.png?raw=true"/>

To summarize the features present in this table (and based on the goals identified in the project summary), I have listed the main features of my database and above diagram in bullet point format below:

* A hospital consists of patients, each recorded with a unique patient id, as well as an age, sex, first name, and last name.
* Some patients will be billed for one or many treatments concerning their diagnosis. 
treatments must have a type (therapy, prescription, or surgery), description, duration (in days), cost, and a satisfaction rating (consisting of a number out of 10 with 10/10 being the highest satisfaction)
* Each patient is assigned to one room (though multiple patients may reside in a given room) and a room has a unique room number, a date of patient admission and release (if discharged), and a room type.
* Hospital employees must have a unique employee id, a first and last name, age, sex and salary
* Each room must be managed by one or more nurses who are a type of hospital employee and have a title that describes their level of competency (eg RN, OR, ect) and a room they are managing
* doctors are a type of hospital employee but will also have an affiliated department (eg ER, surgery, cardiology, ect) and can be identified as either residents, visiting, or attending staff members. 
* resident doctors have a status (ie intern, junior, or senior status) and must be supervised by one of the attending doctors who will have a specialty
* visiting doctors come from other hospitals and their hospital of origin and duration of stay are recorded as additional attributes.

</details>

<details>

<summary>Physical Design</summary>

After finalizing the logical design, it was fairly simple to translate features into a concrete physical design to be compiled into MySQL Workbench. To ensure my logical design was correctly translated, I created a table for each entity from the ER diagram and added the corresponding attributes from each. Using examples from the databases on the course website, I created a database file that detailed all relations included in my hospital database. After reviewing the document to make sure that all tables were included, I then proceeded to add arbitrary data entries, making up names and ids for doctors, nurses, patients, treatments, and rooms and typing these values manually into the database document. Once all values were entered and checked, I copied and pasted the database code into workbench in order to create my finalized hospital database (named “hospital”). For more details on the table model, see the relational table model that I constructed below for additional consistency guidance when finalizing my database.

<img src="images/im2.png?raw=true"/>

</details>

<details>

<summary>List of Applications</summary>

As I touched on in the project summary, there were five main applications that I was aiming to achieve based on my database structure. More detailed descriptions of these applications in addition to the associated queries are listed below.

1) List Doctors by Department: Given the name of a department, this application will list all doctors currently working in this department:

“SELECT department, fname, lname, age, salary FROM doctor JOIN employee USING(essn) WHERE department=___”;

2) List Treatments by Type: Given a choice between three main treatment types (Surgery, Therapy or Description), will list all instances of patients using this treatment, along with a satisfaction rating, duration and overall cost:

“SELECT type, description, satisfaction, duration, cost, diagnosis FROM treatment JOIN patient USING(ssn) WHERE type=___”;

3) Search Patients by Last Name: Displays a list of patients along with their diagnosis and room number present in the database with a last name similar to the one entered by the user:

“SELECT fname, lname, age, diagnosis, rnum FROM patient WHERE lname LIKE___%”;

4) Find Employee with Largest Salary: After choosing which type of employee to find the largest salary from (either doctors or nurses), this application will use one of the two subqueries below to calculate the employee from the given subgroup of employee with the highest paid salary:

“SELECT fname, lname, salary FROM employee LEFT JOIN doctor USING(essn) JOIN nurse USING(essn) WHERE salary=(SELECT MAX(salary) FROM employee LEFT JOIN doctor USING(essn) JOIN nurse USING(essn))”;

“SELECT fname, lname, salary FROM employee LEFT JOIN nurse USING(essn) JOIN doctor USING(essn) WHERE salary=(SELECT MAX(salary) FROM employee LEFT JOIN nurse USING(essn) JOIN doctor USING(essn))”;

5) List Room Records by Date: Lists all instances of occupied rooms along with the patient residing in that room and the dates admitted and discharged (organized by the earliest date of admission):

“SELECT rnum, type, fname, lname, admitted, discharged FROM room JOIN patient USING(rnum) ORDER BY admitted”;

</details>

<details>

<summary>User Guide</summary>

After accessing the main page via the URL on the title page, there are a variety of actions that the user can take based on the application they would like to view. Each application is listed on the main page in big bold blue letters with a description of the application below. Specifics on each application is described in further detail below:

## Application 1:  List Doctors By Department

* From the drop down menu below the heading “List Doctors By Department” the user may select their department of choice from the drop down menu options
* After hitting the “Submit” button beside the drop down menu, the user will be redirected to the php page which will display a list of all doctors working in the selected department name
* To return back to the main menu, the user can click the “Main” link

<img src="images/im3.png?raw=true"/>

## Application 2:  List Treatments By Type

* From the drop down menu below the heading “List Treatments By Type” the user may select which type of treatment they would like to list, either Surgery, Therapy, or Prescriptions
* After selecting and hitting the “Submit” button located next to the drop down menu, the user will be redirected to the php page which will display all cases in which treatments of this type were administered to patients in the database
* These treatment results will be organized by patient satisfaction (a rating out of 10) with the highest (ie the most successful) ratings at the top
* A more specific description of the treatment, along with its duration (in days), cost, and corresponding patient diagnosis will also be listed alongside each treatment (so that each line represents a different patient’s treatment plan)
* To return back to the main menu, the user may choose to click the “Main” link

<img src="images/im4.png?raw=true"/>

## Application 3:  Search Patients by Last Name

* In the text entry box below the header “Search Patients,” enter the desired last name or the beginning of the patients last name
* After clicking the “search” button, the query will find all patient records with a last name identical to or similar to the last name entered in the field
* The results of this search will be displayed in a new page that the user is redirected to along with the patient’s full name, age, diagnosis, and room number
* To return back to the main menu, the user can click the “Main” link

<img src="images/im5.png?raw=true"/>

## Application 4:  Find Employee with Largest Salary

* From the drop down menu below the heading “Find Employee with Largest Salary” the user may choose to display the largest salary among doctors or nurses and should select this choice accordingly
* After hitting the “Submit” button beside the drop down menu, the user will be redirected to the php page which will display the name or names of all employees from this subgroup with the largest salary which will also be listed next to their full name
* To return back to the main menu, the user can click the “Main” link

<img src="images/im6.png?raw=true"/>

## Application 5:  List Room Records by Date

* Below the heading “List Room Use Records by Admission Date” the user may click on the link below in order to list all previous and currently occupied rooms (ordered by earliest date of admission)
* Clicking the link Room Records will redirect the user to the php page which, in addition to displaying the room number, lists the type of room along with the full name of the patent residing in the room, the date of admission, and the date discharged (if discharged)
* To return back to the main menu, the user can click the “Main” link

<img src="images/im7.png?raw=true"/>

The user may also choose to click on any of the links listed under the “Links to Code” header of the main page in order to view the code used to construct the given application:

<img src="images/im8.png?raw=true"/>

</details>

<details>

<summary>Table Contents</summary>

<img src="images/im9.png?raw=true"/>
<img src="images/im10.png?raw=true"/>
<img src="images/im11.png?raw=true"/>
<img src="images/im12.png?raw=true"/>

</details>

<details>

<summary>Implementation Code</summary>

To implement my applications, I choose to create one html page and then to list the five main applications on this page. This would allow the user to view all options before selecting the application of their choice. Once a desired application is selected (via the submit button), the corresponding php file is called and a form is submitted which allows the correct query to take place. This will take the user to a new page which will display the results of the desired query. Once the user executes an application, all results pages will contain a link that the user can click on to return to the main menu options. Specific files and the overall directory structure are listed below. For more detail on the contents of these files, please see the main html page where links to each document are provided and labeled.

### Main Program Files:

* main.html: html code to render main page with links to query applications
* dbconfig.txt: database configuration needed to query hospital database with php

### PHP Application Files:

* findDoctors.php: Search doctors by department name (in dropdown menu)
* listPatients.php: Search patients by last name
* treatmentTypes.php: Search treatments by type (dropdown menu) and order by success 
* salary.php: Search for either doctors or nurses (dropdown menu) with the highest paid salary
* rooms.php: List the occupancy history of all available rooms (ordered by date)

</details>

<details>

<summary>Conclusions</summary>

Overall, I was able to use what we have been taught this term about database structure and implementation in order to construct my own working version of a hospital management system. As described throughout this report, I was able to create five different applications which all manipulated a hospital management system database that I designed and implemented. These applications provided various useful functionalities such as searching for patients in the hospital, finding doctors affiliated with a specific department, looking at room occupancy history, viewing highest payed employees, and analyzing treatment efficacy based on type. As explained in my project summary, these applications are all valuable because they simplify functions that an employee might have to otherwise do manually in a hospital setting. 

Though I have only had time to implement five simple applications compared to the many multivariable applications needed to search all features of a working hospital database, I believe that my design and initial implementation is a solid introduction to what could later become a more robust system. One example of an additional application that could be added in the future would be the ability to search for subtypes of doctors such as residents or attending and to find out specific information on these subtypes. If given more time, I would have also inputed more patient data into my database system and included NULL values in the date of discharge of the room occupancy table. This would have allowed me to implement an application to search for rooms that were currently available versus occupied which would be beneficial for any hospital employee looking for a room to assign to a newly admitted patient. In addition, I would have added more graphics and statistics to the display of treatment data in order to better visualize the effects of treatment types on patients; for example, which treatment type (by rating) was the most successful in graphical form.

While there are many more applications that I could have added to a hospital database management system, I spent a lot of time and was very proud of the outcome and implementation described in this report. It was a great way to solidify the conceptual knowledge which I have been gaining throughout the term and has revealed the many useful applications that database system implementations have on a wide range of fields.

</details>
