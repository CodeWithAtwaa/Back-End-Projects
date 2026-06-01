CREATE DATABASE IF NOT EXISTS hogwarts_db;
USE hogwarts_db;

-- 1. House
CREATE TABLE House (
    house_id    INT AUTO_INCREMENT PRIMARY KEY,
    house_name  VARCHAR(50)  NOT NULL UNIQUE,
    total_points INT          NOT NULL DEFAULT 0
);

-- 2. User
CREATE TABLE User (
    user_id     INT AUTO_INCREMENT PRIMARY KEY,
    user_name   VARCHAR(100) NOT NULL,
    email       VARCHAR(150) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    role        ENUM('Student', 'Professor', 'Dumbledore') NOT NULL
);

-- 3. Student
CREATE TABLE Student (
    student_id  INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT            NOT NULL UNIQUE,
    house_id    INT            NOT NULL,
    balance     DECIMAL(10,2)  NOT NULL DEFAULT 1000.00,
    status      ENUM('Active', 'Inactive') NOT NULL DEFAULT 'Active',
    CONSTRAINT fk_student_user
        FOREIGN KEY (user_id)  REFERENCES User(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_student_house
        FOREIGN KEY (house_id) REFERENCES House(house_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);


-- 4. Professor
CREATE TABLE Professor (
    professor_id    INT AUTO_INCREMENT PRIMARY KEY,
    user_id         INT          NOT NULL UNIQUE,
    professor_name  VARCHAR(100) NOT NULL,
    CONSTRAINT fk_professor_user
        FOREIGN KEY (user_id) REFERENCES User(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);


-- 5. Wand
CREATE TABLE Wand (
    wand_id     INT AUTO_INCREMENT PRIMARY KEY,
    student_id  INT NOT NULL UNIQUE,
    wood_type   ENUM('Holly','Yew','Elder','Willow','Hawthorn','Oak') NOT NULL,
    core_type   ENUM('Phoenix Feather','Dragon Heartstring',
                     'Unicorn Hair','Thestral Tail Hair') NOT NULL,
    CONSTRAINT fk_wand_student
        FOREIGN KEY (student_id) REFERENCES Student(student_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);


-- 6. Course
CREATE TABLE Course (
    course_id       INT AUTO_INCREMENT PRIMARY KEY,
    course_name     VARCHAR(150) NOT NULL,
    professor_id    INT          NOT NULL,
    CONSTRAINT fk_course_professor
        FOREIGN KEY (professor_id) REFERENCES Professor(professor_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);


-- 7. Enrollment
CREATE TABLE Enrollment (
    enroll_id       INT AUTO_INCREMENT PRIMARY KEY,
    student_id      INT NOT NULL,
    course_id       INT NOT NULL,
    enrolled_at     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status          ENUM('Enrolled', 'Dropped') NOT NULL DEFAULT 'Enrolled',
    CONSTRAINT uq_enrollment UNIQUE (student_id, course_id),
    CONSTRAINT fk_enrollment_student
        FOREIGN KEY (student_id) REFERENCES Student(student_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_enrollment_course
        FOREIGN KEY (course_id)  REFERENCES Course(course_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);


-- 8. Assignment
CREATE TABLE Assignment (
    assignment_id   INT AUTO_INCREMENT PRIMARY KEY,
    course_id       INT          NOT NULL,
    assignment_type ENUM('Quiz', 'Assignment') NOT NULL,
    title           VARCHAR(200) NOT NULL,
    max_points      INT          NOT NULL DEFAULT 100,
    created_at      TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deadline        TIMESTAMP    NOT NULL,
    CONSTRAINT fk_assignment_course
        FOREIGN KEY (course_id) REFERENCES Course(course_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);


-- 9. Submission
CREATE TABLE Submission (
    submission_id   INT AUTO_INCREMENT PRIMARY KEY,
    assign_id       INT NOT NULL,
    student_id      INT NOT NULL,
    score           INT NOT NULL DEFAULT 0,
    submitted_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT uq_submission UNIQUE (assign_id, student_id),
    CONSTRAINT chk_score
        CHECK (score >= 0),
    CONSTRAINT fk_submission_assignment
        FOREIGN KEY (assign_id)  REFERENCES Assignment(assignment_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_submission_student
        FOREIGN KEY (student_id) REFERENCES Student(student_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);


-- 10. HousePoints
CREATE TABLE HousePoints (
    points_id       INT AUTO_INCREMENT PRIMARY KEY,
    house_id        INT NOT NULL,
    student_id      INT NOT NULL,
    submission_id   INT NOT NULL UNIQUE,
    points          INT NOT NULL DEFAULT 0,
    added_at        TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_housepoints_house
        FOREIGN KEY (house_id)      REFERENCES House(house_id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_housepoints_student
        FOREIGN KEY (student_id)    REFERENCES Student(student_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_housepoints_submission
        FOREIGN KEY (submission_id) REFERENCES Submission(submission_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);


-- 11. DiagonAlleyShop
CREATE TABLE DiagonAlleyShop (
    item_id     INT AUTO_INCREMENT PRIMARY KEY,
    item_name   VARCHAR(150)  NOT NULL,
    item_type   ENUM('Broom', 'Potion Ingredient', 'Spell Book') NOT NULL,
    item_price  DECIMAL(10,2) NOT NULL
);


-- 12. Inventory
CREATE TABLE Inventory (
    inventory_id    INT AUTO_INCREMENT PRIMARY KEY,
    student_id      INT NOT NULL,
    item_id         INT NOT NULL,
    quantity        INT NOT NULL DEFAULT 1,
    purchased_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_inventory_student
        FOREIGN KEY (student_id) REFERENCES Student(student_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_inventory_item
        FOREIGN KEY (item_id)    REFERENCES DiagonAlleyShop(item_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);


-- 13. Message
CREATE TABLE Message (
    message_id      INT AUTO_INCREMENT PRIMARY KEY,
    sender_id       INT     NOT NULL,
    receiver_id     INT     NOT NULL,
    message_body    TEXT    NOT NULL,
    sent_at         TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    is_read         BOOLEAN   NOT NULL DEFAULT FALSE,
    CONSTRAINT fk_message_sender
        FOREIGN KEY (sender_id)   REFERENCES User(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_message_receiver
        FOREIGN KEY (receiver_id) REFERENCES User(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- Indexes
CREATE INDEX idx_student_house     ON Student(house_id);
CREATE INDEX idx_course_professor  ON Course(professor_id);
CREATE INDEX idx_enrollment_course ON Enrollment(course_id);
CREATE INDEX idx_assignment_course ON Assignment(course_id);
CREATE INDEX idx_submission_assign ON Submission(assign_id);
CREATE INDEX idx_housepoints_house ON HousePoints(house_id);
CREATE INDEX idx_inventory_item    ON Inventory(item_id);
CREATE INDEX idx_message_sender    ON Message(sender_id);
CREATE INDEX idx_message_receiver  ON Message(receiver_id);

-- TRIGGER: auto-update House.total_points
-- when a new HousePoints row is inserted
DELIMITER $$

CREATE TRIGGER trg_update_house_points
AFTER INSERT ON HousePoints
FOR EACH ROW
BEGIN
    UPDATE House
    SET total_points = total_points + NEW.points
    WHERE house_id = NEW.house_id;
END$$

-- TRIGGER: auto-update House.total_points
-- when a HousePoints row is deleted
CREATE TRIGGER trg_rollback_house_points
AFTER DELETE ON HousePoints
FOR EACH ROW
BEGIN
    UPDATE House
    SET total_points = total_points - OLD.points
    WHERE house_id = OLD.house_id;
END$$

DELIMITER ;

-- SEED DATA: Houses
INSERT INTO House (house_name, total_points) VALUES
    ('Gryffindor', 0),
    ('Slytherin',  0),
    ('Ravenclaw',  0),
    ('Hufflepuff', 0);


-- SEED DATA: Shop Items
INSERT INTO DiagonAlleyShop (item_name, item_type, item_price) VALUES
    ('Nimbus 2000',                 'Broom',              500.00),
    ('Firebolt',                    'Broom',              1200.00),
    ('Polyjuice Potion Ingredient', 'Potion Ingredient',  80.00),
    ('No Sleep Potion',             'Potion Ingredient',  60.00),
    ('Basic Spell Book',            'Spell Book',         120.00),
    ('Dark Magic (PHP)',            'Spell Book',         999.00);



-- Insert data for Leaderboard

-- Users
INSERT INTO User (user_name, email, password, role) VALUES
('Harry James Potter', 'harry@gryffindor.edu', '123456', 'Student'),
('Hermione Jean Granger', 'hermione@gryffindor.edu', '123456', 'Student'),
('Draco Lucius Malfoy', 'draco@slytherin.edu', '123456', 'Student'),
('Luna Lovegood', 'luna@ravenclaw.edu', '123456', 'Student'),
('Neville Longbottom', 'neville@gryffindor.edu', '123456', 'Student');

-- Students
INSERT INTO Student (user_id, house_id, balance, status) VALUES
(1, 1, 1000, 'Active'),
(2, 1, 1000, 'Active'),
(3, 2, 1000, 'Active'),
(4, 3, 1000, 'Active'),
(5, 1, 1000, 'Active');

-- Wands
INSERT INTO Wand (student_id, wood_type, core_type) VALUES
(1, 'Holly', 'Phoenix Feather'),
(2, 'Willow', 'Dragon Heartstring'),
(3, 'Hawthorn', 'Unicorn Hair'),
(4, 'Oak', 'Unicorn Hair'),
(5, 'Oak', 'Dragon Heartstring');

-- Professor User
INSERT INTO User (user_name, email, password, role) VALUES
('Severus Snape', 'snape@hogwarts.edu', '123456', 'Professor');

-- Professor
INSERT INTO Professor (user_id, professor_name) VALUES
(6, 'Prof. Severus Snape');

-- Dumbledore Super Admin
INSERT INTO User (user_name, email, password, role) VALUES
('Albus Percival Wulfric Brian Dumbledore', 'dumbledore@hogwarts.edu', '$2y$10$C4mDW1y.tOD4kiZsJibVMe9/KKY0DtSqvFtAAB/mmn4xSGhpRzPs2', 'Dumbledore');

-- Course
INSERT INTO Course (course_name, professor_id) VALUES
('Defense Against the Dark Arts', 1),
('Transfiguration', 1),
('Potions', 1);

-- Assignments
INSERT INTO Assignment (course_id, assignment_type, title, max_points, deadline) VALUES
(1, 'Quiz', 'Basic Defense Spells', 100, '2025-06-01 23:59:00'),
(2, 'Quiz', 'Transfiguration Theory', 100, '2025-06-05 23:59:00'),
(3, 'Quiz', 'Potions Basics', 100, '2025-06-10 23:59:00');

-- Submissions
INSERT INTO Submission (assign_id, student_id, score) VALUES
(1, 1, 95),
(1, 2, 98),
(1, 3, 92),
(1, 4, 88),
(1, 5, 85),
(2, 1, 90),
(2, 2, 99),
(2, 3, 88),
(3, 1, 95),
(3, 2, 97);

-- HousePoints
INSERT INTO HousePoints (house_id, student_id, submission_id, points) VALUES
(1, 1, 1, 95),
(1, 2, 2, 98),
(2, 3, 3, 92),
(3, 4, 4, 88),
(1, 5, 5, 85),
(1, 1, 6, 90),
(1, 2, 7, 99),
(2, 3, 8, 88),
(1, 1, 9, 95),
(1, 2, 10, 97);
