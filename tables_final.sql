DROP TABLE IF EXISTS fcourselist;
DROP TABLE IF EXISTS scourselist;
DROP TABLE IF EXISTS tcourselist;
DROP TABLE IF EXISTS reservation;
DROP TABLE IF EXISTS problemset;
DROP TABLE IF EXISTS course;
DROP TABLE IF EXISTS sessions;
DROP TABLE IF EXISTS student;
DROP TABLE IF EXISTS tutor;
DROP TABLE IF EXISTS account;

--Account Table
-- for all the columns/varibles that will ve eventually sent to the web app, use exactly the same words --
--hashed pass is  null for now, must figure out when adding students, admin/prof doesn't have password or?
CREATE TABLE account(
    hawkid VARCHAR(10) NOT NULL,
    name VARCHAR(120) NOT NULL,
    hashedpass VARCHAR(120) NULL,
    student BOOLEAN NOT NULL,
    tutor BOOLEAN NOT NULL,
    administrator BOOLEAN NOT NULL,
    faculty BOOLEAN NOT NULL,
    PRIMARY KEY(hawkid)
                  );
--Tutor table
-- for all the columns/varibles that will ve eventually sent to the web app, use exactly the same words --
CREATE TABLE tutor (
    tutorid VARCHAR(10) NOT NULL,
    name VARCHAR(120) NOT NULL,
    budget VARCHAR(120) NOT NULL,
    PRIMARY KEY(tutorid),
    FOREIGN KEY(tutorid) REFERENCES account(hawkid)
                  );

--Student table
-- for all the columns/varibles that will ve eventually sent to the web app, use exactly the same words --
CREATE TABLE student (
    studentid VARCHAR(10) NOT NULL,
    name VARCHAR(120) NOT NULL,
    budget VARCHAR(120) NOT NULL,
    PRIMARY KEY(studentid),
    FOREIGN KEY(studentid) REFERENCES account(hawkid)
                  );
--Session Table
-- for all the columns/varibles that will ve eventually sent to the web app, use exactly the same words --
CREATE TABLE sessions (
    sessionid INT AUTO_INCREMENT,
    -- look at sql time/date data types. timestamp, datetime, etc
    timeofsession VARCHAR(120) NOT NULL,
    dateofsession VARCHAR(255) NOT NULL,
    placeofsession VARCHAR(255) NOT NULL,
    tutorid VARCHAR(10) NOT NULL,
    PRIMARY KEY(sessionid)
    
                  );
--Course table
CREATE TABLE course(
    courseid INT NOT NULL,
    coursename VARCHAR(120) NOT NULL,
    PRIMARY KEY (courseid)
);

--Problem table
CREATE TABLE problemset (
    problemid INT AUTO_INCREMENT,
    problemnotes VARCHAR(3000),
	courseid INT NOT NULL,
    PRIMARY KEY (problemid),
    FOREIGN KEY(courseid) REFERENCES course(courseid)
);

 
--Reservation Table
-- for all the columns/varibles that will eventually sent to the web app, use exactly the same words --
CREATE TABLE reservation(
    reservationid INT NOT NULL AUTO_INCREMENT,
    notes VARCHAR(3000),
    cancel BOOLEAN NOT NULL,
    sessionid INT NOT NULL,
    problemid INT,
    studentid VARCHAR(10) NOT NULL,
    PRIMARY KEY(reservationid),
    FOREIGN KEY(sessionid) REFERENCES sessions(sessionID),
    FOREIGN KEY(problemid) REFERENCES problemset(ProblemID)    
                  );



CREATE TABLE scourselist(
    hawkid VARCHAR(20) NOT NULL,
    courseid VARCHAR(20) NOT NULL,
    budget INT NOT NULL
);
CREATE TABLE tcourselist(
    hawkid VARCHAR(20) NOT NULL,
    courseid VARCHAR(20) NOT NULL,
    budget INT NOT NULL
);
CREATE TABLE fcourselist(
    hawkid VARCHAR(20) NOT NULL,
    courseid VARCHAR(20) NOT NULL
);


-- test cases for each data type
INSERT INTO account VALUES('studenttutor','StudentTutor','$2a$12$f5t5UQZToCPUKNEF/KmtQek/B8M3u4GMe9kvnOxRALl4GNtDC3lSS',True,True,False,False);
INSERT INTO account VALUES('student','Student','$2a$12$f5t5UQZToCPUKNEF/KmtQek/B8M3u4GMe9kvnOxRALl4GNtDC3lSS',True,False,False,False);
INSERT INTO account VALUES('tutor','Tutor','$2a$12$f5t5UQZToCPUKNEF/KmtQek/B8M3u4GMe9kvnOxRALl4GNtDC3lSS',False,True,False,False);
INSERT INTO account VALUES('admin','Admin','$2a$12$f5t5UQZToCPUKNEF/KmtQek/B8M3u4GMe9kvnOxRALl4GNtDC3lSS',False,False,True,False);
INSERT INTO account VALUES('faculty','Faculty','$2a$12$f5t5UQZToCPUKNEF/KmtQek/B8M3u4GMe9kvnOxRALl4GNtDC3lSS',False,False,False,True);
INSERT INTO account VALUES('facultyadmin','FacultyAdmin','$2a$12$f5t5UQZToCPUKNEF/KmtQek/B8M3u4GMe9kvnOxRALl4GNtDC3lSS',False,False,True,True);
INSERT INTO account VALUES('arangl','Andres','$2a$12$NFWuIEO2J8sS/5tJz7.sEe895Do9IZ9I7RzcCeILTUlHHdO8Vhi2O',False,False,True,False);



