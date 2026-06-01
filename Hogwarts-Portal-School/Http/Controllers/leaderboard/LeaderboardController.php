<?php

use Core\App;

$db = App::resolve('Core\Database');

// Rank houses from submitted scores. This keeps the leaderboard correct even
// when the cached House.total_points / HousePoints rows are not populated.
$houses = $db->query('SELECT
        House.house_id,
        House.house_name,
        COALESCE(scores.total_points, 0) AS total_points,
        COUNT(DISTINCT Student.student_id) AS students_count,
        COALESCE(scores.scored_submissions, 0) AS scored_submissions
        FROM House
        LEFT JOIN Student ON House.house_id = Student.house_id
        LEFT JOIN (
            SELECT
                Student.house_id,
                SUM(Submission.score) AS total_points,
                COUNT(DISTINCT Submission.submission_id) AS scored_submissions
            FROM Submission
            JOIN Student ON Submission.student_id = Student.student_id
            GROUP BY Student.house_id
        ) scores ON scores.house_id = House.house_id
        GROUP BY House.house_id, House.house_name, scores.total_points, scores.scored_submissions
        ORDER BY total_points DESC, scored_submissions DESC, House.house_name
    ')->get();

// Rank students from submissions; one row per student avoids multiplying scores.
$students = $db->query('SELECT
        Student.student_id,
        User.user_name AS name,
        House.house_name AS house,
        COALESCE(work.work_completed, 0) AS work_completed,
        COALESCE(work.quizzes_completed, 0) AS quizzes_completed,
        COALESCE(work.assignments_completed, 0) AS assignments_completed,
        COALESCE(work.total_points, 0) AS total_points,
        COALESCE(work.avg_score, 0) AS avg_score
        FROM Student
        JOIN User ON User.user_id = Student.user_id
        JOIN House ON House.house_id = Student.house_id
        LEFT JOIN (
            SELECT
                Submission.student_id,
                COUNT(DISTINCT Submission.submission_id) AS work_completed,
                COUNT(DISTINCT CASE WHEN Assignment.assignment_type = "Quiz" THEN Submission.submission_id END) AS quizzes_completed,
                COUNT(DISTINCT CASE WHEN Assignment.assignment_type = "Assignment" THEN Submission.submission_id END) AS assignments_completed,
                SUM(Submission.score) AS total_points,
                ROUND(AVG(Submission.score), 0) AS avg_score
            FROM Submission
            JOIN Assignment ON Assignment.assignment_id = Submission.assign_id
            GROUP BY Submission.student_id
        ) work ON work.student_id = Student.student_id
        ORDER BY total_points DESC, avg_score DESC, work_completed DESC, User.user_name
        LIMIT 10
    ')->get();

view('leaderboard', [
    'houses'   => $houses,
    'students' => $students,
]);
