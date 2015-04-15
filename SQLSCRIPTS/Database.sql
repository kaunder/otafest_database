Drop database volunteerDatabase;
Create database volunteerDatabase;
Use volunteerDatabase;

Create table Volunteer
(
volunteer_id int,
firstName varChar(255),
lastName varChar(255),
nickname varChar(255),
phoneNumber varChar(13),
date_of_birth date,
primary key (volunteer_id)
);

Create table VolunteerComments 
(
volunteer_id int,
vol_comment varChar(255) default "",
primary key (volunteer_id, vol_comment),
foreign key (volunteer_id) references Volunteer (volunteer_id) on update cascade
);

Create table Supervises
(
supervisor_id int,
supervisee_id int,
convention_name varChar(255),
primary key (supervisor_id, supervisee_id, convention_name),
foreign key (supervisor_id) references Volunteer (volunteer_id) on update cascade,
foreign key (supervisee_id) references Volunteer (volunteer_id) on update cascade
);

Create table EmergencyContact
(
contact_name varChar(255),
volunteer_id int,
phone_num varChar(13),
relationship varChar(255),
primary key (contact_name, volunteer_id),
foreign key (volunteer_id) references Volunteer (volunteer_id) on update cascade
);

Create table Venue
(
venue_name varChar(255),
streetAddress varChar(255),
postalCode varChar(255),
contact_person_name varChar(255),
contact_person_number varChar(255),
coordinatingVolunteerId int,
primary key (venue_name, coordinatingVolunteerId),
foreign key (coordinatingVolunteerId) references Volunteer (volunteer_id) on update cascade
);

Create table Convention
(
convention_name varChar(255),
venue_name varChar(255),
start_date date,
end_date date,
primary key (convention_name, venue_name),
foreign key (venue_name) references Venue (venue_name) on update cascade
);

Create table Department
(
dept_name varChar(255),
manager_id int,
num_volunteers_req int,
convention_name varChar(255),
primary key (dept_name, convention_name, manager_id),
foreign key (manager_id) references Volunteer (volunteer_id) on update cascade,
foreign key (convention_name) references Convention (convention_name) on update cascade
);

Create table VolunteerAppliesFor
(
volunteer_id int,
dept_name varChar(255),
shift_start timestamp, /*Changed the name*/
shift_end timestamp,
convention_name varChar(255),
primary key (volunteer_id, dept_name, shift_start, shift_end, convention_name),
foreign key (volunteer_id) references Volunteer (volunteer_id) on update cascade,
foreign key (dept_name) references Department (dept_name) on update cascade,
foreign key (convention_name) references Department (convention_name) /*Referencing Department or Convention?*/
);

Create table VolunteerWorks /*Changed the name*/
(
volunteer_id int,
dept_name varChar(255),
shift_start timestamp, /*Changed the name*/
shift_end timestamp,
convention_name varChar(255),
primary key (volunteer_id, dept_name, shift_start, shift_end, convention_name),
foreign key (volunteer_id) references Volunteer (volunteer_id) on update cascade,
foreign key (dept_name) references Department (dept_name) on update cascade,
foreign key (convention_name) references Department (convention_name) /*Referencing Department or Convention?*/
);

Create table Panel
(
panel_name varChar(255),
category varChar(255),
presenter varChar(255),
presenter_phone_num varChar(13),
room_num varChar(255),
age_rating varChar(5),
start_time_date timestamp,
end_time_date timestamp,
dept_name varChar(255),
primary key (panel_name, dept_name, start_time_date),
foreign key (dept_name) references Department (dept_name) on update cascade
);

Create table Contest
(
contest_name varChar(255),
contest_type varChar(255),
convention_name varChar(255),
primary key (contest_name, convention_name),
foreign key (convention_name) references Convention (convention_name) on update cascade
);

Create table Scholarship
(
scholarship_name varChar(255),
convention_name varChar(255),
amount int,
scholarship_winner int,
primary key (scholarship_name, convention_name, scholarship_winner),
foreign key (convention_name) references Convention (convention_name) on update cascade,
foreign key (scholarship_winner) references Volunteer (volunteer_id) on update cascade
);

Create table ContestJudge
(
contest_name varChar(255),
convention_name varChar(255),
judge_id int,
primary key (contest_name, convention_name, judge_id),
foreign key (judge_id) references Volunteer (volunteer_id) on update cascade,
foreign key (convention_name) references Convention (convention_name) on update cascade,
foreign key (contest_name) references Contest (contest_name) on update cascade
);

Create table ScholarshipJudge
(
scholarship_name varChar(255),
convention_name varChar(255),
judge_id int,
primary key (scholarship_name, convention_name, judge_id),
foreign key (scholarship_name) references Scholarship (scholarship_name) on update cascade,
foreign key (convention_name) references Convention (convention_name) on update cascade,
foreign key (judge_id) references Volunteer (volunteer_id) on update cascade
);