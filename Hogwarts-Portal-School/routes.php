<?php
// Home
$router->get('/', 'HomeController.php');

// Registration
$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');

// Session
$router->get('/login', 'session/create.php')->only('guest');
$router->post('/login', 'session/store.php')->only('guest');
$router->get('/logout', 'session/destroy.php')->only('auth');
$router->delete('/logout', 'session/destroy.php')->only('auth');

// Student and professor panels
$router->get('/student-panel', 'StudentPanelController.php')->only('student');
$router->post('/submit-work', 'SubmissionController.php')->only('student');
$router->get('/professor-panel', 'ProfessorPanelController.php')->only('professor');

// Shop and inventory
$router->get('/shop', 'shop/index.php')->only('student');
$router->post('/shop/buy', 'shop/store.php')->only('student');
$router->get('/inventory', 'inventory/index.php')->only('student');
$router->post('/inventory/remove', 'inventory/store.php')->only('student');

// Leaderboard
$router->get('/leaderboard', 'leaderboard/LeaderboardController.php');

// ================== Dashboard Routes ==================
$router->get('/dashboard', 'Dashboard/DashboardController.php')->only('staff');
$router->get('/show-student', 'Dashboard/ShowStudentController.php')->only('staff');
$router->get('/edit-student', 'Dashboard/EditStudentController.php')->only('staff');
$router->post('/edit-student', 'Dashboard/EditStudentController.php')->only('staff');
$router->get('/deactivate-student', 'Dashboard/DeactivateStudentController.php')->only('staff');
$router->post('/deactivate-student', 'Dashboard/DeactivateStudentController.php')->only('staff');
$router->get('/delete-student', 'Dashboard/DeleteStudentController.php')->only('staff');
$router->post('/delete-student', 'Dashboard/DeleteStudentController.php')->only('staff');
$router->post('/store-student', 'Dashboard/StoreStudentController.php')->only('staff');
$router->post('/store-professor', 'Dashboard/StoreProfessorController.php')->only('dumbledore');
$router->post('/store-course', 'Dashboard/StoreCourseController.php')->only('staff');
$router->post('/store-assignment', 'Dashboard/StoreAssignmentController.php')->only('staff');
$router->post('/store-score', 'Dashboard/StoreScoreController.php')->only('staff');
$router->post('/delete-score', 'Dashboard/DeleteScoreController.php')->only('staff');

// Professors Routes
$router->get('/show-professor', 'Dashboard/ShowProfessorController.php')->only('staff');
$router->get('/edit-professor', 'Dashboard/EditProfessorController.php')->only('dumbledore');
$router->post('/edit-professor', 'Dashboard/EditProfessorController.php')->only('dumbledore');
$router->get('/delete-professor', 'Dashboard/DeleteProfessorController.php')->only('dumbledore');
$router->post('/delete-professor', 'Dashboard/DeleteProfessorController.php')->only('dumbledore');

// Courses Routes
$router->get('/show-course', 'Dashboard/ShowCourseController.php')->only('staff');
$router->get('/edit-course', 'Dashboard/EditCourseController.php')->only('staff');
$router->post('/edit-course', 'Dashboard/EditCourseController.php')->only('staff');
$router->get('/delete-course', 'Dashboard/DeleteCourseController.php')->only('staff');
$router->post('/delete-course', 'Dashboard/DeleteCourseController.php')->only('staff');

// Assignments Routes
$router->get('/show-assignment', 'Dashboard/ShowAssignmentController.php')->only('staff');
$router->get('/edit-assignment', 'Dashboard/EditAssignmentController.php')->only('staff');
$router->post('/edit-assignment', 'Dashboard/EditAssignmentController.php')->only('staff');
$router->get('/delete-assignment', 'Dashboard/DeleteAssignmentController.php')->only('staff');
$router->post('/delete-assignment', 'Dashboard/DeleteAssignmentController.php')->only('staff');

// ================== Classrooms Routes ==================

$router->get('/classrooms', 'classrooms.php')->only('auth');

// Classrooms & Quizzes (Students)
$router->get('/course-catalog', 'student/courseCatalog.php')->only('student');
$router->post('/enroll-course', 'student/enroll.php')->only('student');
$router->get('/my-classrooms', 'student/myClassrooms.php')->only('student');
$router->get('/take-quiz', 'student/startQuiz.php')->only('student');
$router->post('/submit-quiz', 'student/submitQuiz.php')->only('student');
