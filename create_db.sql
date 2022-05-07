-- Create the smart_scholarship_system database
DROP DATABASE IF EXISTS smart_scholarship_system;
CREATE DATABASE smart_scholarship_system;
USE smart_scholarship_system;

-- Create the tables
CREATE TABLE REGISTRAR_OFFICE (
  studentNumber    CHAR(8)         NOT NULL,
  firstName        VARCHAR(50),
  lastName         VARCHAR(50),
  phoneNumber      VARCHAR(20),
  email            VARCHAR(255),
  gender           ENUM('Male', 'Female'),
  dateOfBirth      DATE,
  status           ENUM('Freshman', 'Sophomore', 'Junior', 'Senior'),
  cumulativeGPA    DECIMAL(3,2),
  semesterGPA      DECIMAL(3,2),
  credits          INT,
  billAmount       DECIMAL(12,2),

  PRIMARY KEY (studentNumber),
  UNIQUE (email)
);

CREATE TABLE APPLICANTS (
  studentNumber    CHAR(8)         NOT NULL,
  firstName        VARCHAR(50),
  lastName         VARCHAR(50),
  phoneNumber      VARCHAR(20),
  email            VARCHAR(255),
  gender           ENUM('Male', 'Female'),
  dateOfBirth      DATE,
  status           ENUM('Freshman', 'Sophomore', 'Junior', 'Senior'),
  cumulativeGPA    DECIMAL(3,2),
  semesterGPA      DECIMAL(3,2),
  credits          INT,
  eligible         BOOLEAN,
  votes            INT            DEFAULT 0,

  PRIMARY KEY (studentNumber),
  FOREIGN KEY (studentNumber) REFERENCES REGISTRAR_OFFICE (studentNumber),
  UNIQUE (email)
);

CREATE TABLE AWARDED (
  studentNumber    CHAR(8)         NOT NULL,
  firstName        VARCHAR(50),
  lastName         VARCHAR(50),
  awardedAmount    DECIMAL(12,2),

  PRIMARY KEY (studentNumber),
  FOREIGN KEY (studentNumber) REFERENCES APPLICANTS (studentNumber)
);

CREATE TABLE MEMBERS (
  email             VARCHAR(255)   NOT NULL,
  password          VARCHAR(255)   NOT NULL,
  firstName         VARCHAR(50),
  lastName          VARCHAR(50),

  PRIMARY KEY (email)
);

CREATE TABLE ACCOUNTING_DEPARTMENT (
  transactionNumber     INT             NOT NULL     AUTO_INCREMENT,
  studentNumber         CHAR(8)         NOT NULL,
  reimbursement         DECIMAL(12,2),

  PRIMARY KEY (transactionNumber),
  FOREIGN KEY (studentNumber) REFERENCES AWARDED (studentNumber)
);

-- Insert data into the database
INSERT INTO REGISTRAR_OFFICE VALUES
('12345678', 'Alice', 'Paul', '313-562-7894', 'alice@bst.com', 'Female', '2000-12-31', 'Junior', '4.00', '4.00', '14', '7559.89'),
('23456789', 'Jennifer', 'Paul', '313-562-7894', 'jennifer@bst.com', 'Female', '2000-12-31', 'Junior', '4.00', '4.00', '14', '7559.89'),
('01234567', 'Evelyn', 'Jean', '423-562-8494', 'evelyn@bst.com', 'Female', '2000-12-31', 'Junior', '4.00', '4.00', '14', '7779.89'),
('34567890', 'Bob', 'Ross', '734-562-8989', 'bob@bst.com', 'Male', '1995-12-10', 'Senior', '3.00', '3.55', '11', '6339.25'),
('45678901', 'Indiana', 'Jones', '464-562-7845', 'indiana@bst.com', 'Male', '2001-05-05', 'Sophomore', '3.10', '3.00', '9', '5002.35'),
('56789012', 'Emma', 'Watson', '958-623-8417', 'emma@bst.com', 'Female', '2002-01-07', 'Freshman', '3.97', '4.00', '11', '6339.25'),
('67890123', 'William', 'Matthews', '213-456-8564', 'william@bst.com', 'Male', '2002-02-20', 'Freshman', '4.00', '3.97', '14', '7589.89'),
('78901234', 'Macy', 'Lin', '456-784-1245', 'macy@bst.com', 'Female', '2001-06-09', 'Sophomore', '4.00', '4.00', '13', '6550.79'),
('89012345', 'Marvin', 'Lee', '649-856-2345', 'marvin@bst.com', 'Male', '2000-11-21', 'Junior', '4.00', '4.00', '13', '6559.99'),
('90123456', 'Paula', 'Jones', '180-316-5555', 'paula@bst.com', 'Female', '2000-10-31', 'Junior', '4.00', '4.00', '17', '8539.79');

INSERT INTO APPLICANTS (studentNumber, firstName, lastName, phoneNumber, email, gender, dateOfBirth, status, cumulativeGPA, semesterGPA, credits, eligible) VALUES
('12345678', 'Alice', 'Paul', '313-562-7894', 'alice@bst.com', 'Female', '2000-12-31', 'Junior', '4.00', '4.00', '14', TRUE),
('23456789', 'Jennifer', 'Paul', '313-562-7894', 'jennifer@bst.com', 'Female', '2000-12-31', 'Junior', '4.00', '4.00', '14', TRUE),
('01234567', 'Evelyn', 'Jean', '423-562-8494', 'evelyn@bst.com', 'Female', '2000-12-31', 'Junior', '4.00', '4.00', '14', TRUE),
('34567890', 'Bob', 'Ross', '734-562-8989', 'bob@bst.com', 'Male', '1995-12-10', 'Senior', '3.00', '3.55', '11', FALSE),
('45678901', 'Indiana', 'Jones', '464-562-7845', 'indiana@bst.com', 'Male', '2001-05-05', 'Sophomore', '3.10', '3.00', '9', FALSE),
('56789012', 'Emma', 'Watson', '958-623-8417', 'emma@bst.com', 'Female', '2002-01-07', 'Freshman', '3.97', '4.00', '11', FALSE),
('67890123', 'William', 'Matthews', '213-456-8564', 'william@bst.com', 'Male', '2002-02-20', 'Freshman', '4.00', '3.97', '14', TRUE),
('78901234', 'Macy', 'Lin', '456-784-1245', 'macy@bst.com', 'Female', '2001-06-09', 'Sophomore', '4.00', '4.00', '13', TRUE),
('89012345', 'Marvin', 'Lee', '649-856-2345', 'marvin@bst.com', 'Male', '2000-11-21', 'Junior', '4.00', '4.00', '13', TRUE),
('90123456', 'Paula', 'Jones', '180-316-5555', 'paula@bst.com', 'Female', '2000-10-31', 'Junior', '4.00', '4.00', '17', TRUE);

INSERT INTO MEMBERS VALUES
('al@bst.com', '6a718fbd768c2378b511f8249b54897f940e9022', 'Al', 'Jones'),
('gale@bst.com', '971e95957d3b74d70d79c20c94e9cd91b85f7aae', 'Gale', 'Martin'),
('smith@bst.com', '3f2975c819cefc686282456aeae3a137bf896ee8', 'Smith', 'John');

-- Create the user and grant priveleges
GRANT SELECT, INSERT, DELETE, UPDATE
ON smart_scholarship_system.*
TO guest_user@localhost
IDENTIFIED BY 'pa$$word';
