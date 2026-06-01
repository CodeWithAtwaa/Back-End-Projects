<?php

use Core\App;

$db = App::resolve('Core\Database');

$course_id = $_GET['id'] ?? null;

if (!$course_id) {
    abort(400);
}

$course = $db->query('SELECT 
        Course.course_id,
        Course.course_name,
        Professor.professor_id,
        Professor.professor_name,
        User.user_name AS prof_user_name,
        COUNT(DISTINCT Enrollment.student_id) AS enrolled_count,
        COUNT(DISTINCT Assignment.assignment_id) AS assignments_count
        FROM Course
        JOIN Professor ON Course.professor_id = Professor.professor_id
        JOIN User ON Professor.user_id = User.user_id
        LEFT JOIN Enrollment ON Course.course_id = Enrollment.course_id
        LEFT JOIN Assignment ON Course.course_id = Assignment.course_id
        WHERE Course.course_id = :id
        GROUP BY Course.course_id, Course.course_name, Professor.professor_id, 
                 Professor.professor_name, User.user_name
        ', ['id' => $course_id])->find();

if (!$course) {
    abort(404);
}

return view('Dashboard/show-course', [
    'course' => $course,
]);
