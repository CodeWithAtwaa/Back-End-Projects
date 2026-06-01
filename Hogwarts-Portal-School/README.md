# Hogwarts Portal

A PHP/MySQL school portal inspired by Hogwarts. Students can register, enroll in courses, view quizzes, tasks, and assignments, submit work before deadlines, earn house points, shop in Diagon Alley, and track the House Cup leaderboard. Professors and Dumbledore can manage students, courses, class work, scores, and academic dashboards.

## Features

- Student registration and login with role-based access.
- Student panel for courses, pending work, quizzes, tasks, assignments, balances, wand data, and submission status.
- On-time submission workflow that awards full points to the student submission and the student's house.
- Professor dashboard for managing students, courses, quizzes, tasks, assignments, and scores.
- House leaderboard backed by `HousePoints` and `House.total_points`.
- Diagon Alley shop and student inventory.
- Animated home page with quick links for students, staff, and guests.

## Tech Stack

- PHP
- MySQL
- Bootstrap 5
- Font Awesome
- Plain CSS and JavaScript

## Setup

1. Clone the repository.

```bash
git clone https://github.com/w0lfsh4d0w/Hogwarts-Portal.git
cd Hogwarts-Portal
```

2. Create and seed the database.

```bash
mysql -u root -p < Core/DB/schema.sql
```

3. Update database credentials in `Core/Database.php` or your local config if needed.

4. Start the local PHP server.

```bash
php -S localhost:8888 -t public
```

5. Open the app in your browser.

```text
http://localhost:8888
```

## Default Demo Users

- Student examples: `a@gmail.com`, password: `123456789`
- Professor: `m@gmail.com`, password: `000000000`
- Dumbledore: `dumbledore@hogwarts.edu` , password: `elderwand123`


## Submission Points

Students submit from the Student Panel. If the deadline has not passed, the portal creates a `Submission`, awards the assignment's full `max_points`, and inserts a `HousePoints` record. The database triggers update each house total automatically when points are inserted or removed.

## Useful Paths

- `/` home
- `/register` student registration
- `/login` login
- `/student-panel` student workspace
- `/dashboard` staff dashboard
- `/leaderboard` house rankings
- `/shop` Diagon Alley shop
- `/inventory` student inventory
