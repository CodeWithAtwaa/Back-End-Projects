# 📝 Native ToDos — PHP CRUD Task Manager
.<br>

A simple Native PHP ToDo application that allows users to create, edit, update, and manage tasks with due dates and completion status.
Built using pure PHP + PDO + MySQL + Bootstrap (no frameworks).

This project is designed for learning CRUD operations and form handling using POST with validation.
.<br>
# 🚀 Features

✅ Create new tasks

✏️ Edit existing tasks

🔄 Update task status (Complete / Pending)

🗓️ Set due date & time

🗑️ Delete tasks

📋 View all tasks

🔐 PDO prepared statements (SQL injection safe)

🧪 Server-side validation

💬 Flash success messages

🎨 Bootstrap UI

🛠️ Tech Stack

.<br>
# PHP (Native)
- MySQL
- PDO
- HTML5
- Bootstrap
- Sessions

.<br>
# 📂 Project Structure
native-ToDos/
│
├── index.php          # Main router/controller
├── db.php             # Database connection
├── assets/            # CSS / JS / images
├── includes/          # Shared components
├── views/             # Forms and UI sections
└── README.md
.<br>

(Adjust if your folders differ)

# ⚙️ Installation
1️⃣ Clone the repository
git clone https://github.com/CodeWithAtwaa/native-ToDos.git

2️⃣ Move into your server folder

If using XAMPP:
htdocs/native-ToDos


If using Laragon:
www/native-ToDos

3️⃣ Create Database
Create a database in MySQL:
CREATE DATABASE todos;


Create table:
CREATE TABLE task (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    is_complete TINYINT(1) NOT NULL DEFAULT 0,
    due_date DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

4️⃣ Configure Database Connection
Edit your database file:
$connect = new PDO(
    "mysql:host=localhost;dbname=todos",
    "root",
    ""
);

5️⃣ Run the App
Open in browser:
http://localhost/native-ToDos

.<br>
# 🧩 CRUD Actions

- Action	Method	Description
- Create	POST	Add new task
- Read	GET	List all tasks
- Update	POST	Edit task
- Delete	GET/POST	Remove task

🧪 Validation Rules

- Task name required
- Status required
- Due date required
- Radio values handled correctly (0 is valid)
- Sanitized output with htmlspecialchars

📸 Screens (optional — add later)

You can add screenshots here:
/screenshots/create.png
/screenshots/edit.png
/screenshots/list.png
.<br>
# 🎯 Learning Goals

This project demonstrates:
 - Native PHP routing
 - PDO prepared statements
 - Form POST handling
 - Server-side validation
 - CRUD operations
 - Session flash messages
 - Clean separation of logic & view

   .<br>
🔒 Security Practices Used

- PDO prepared queries
- Output escaping
- POST instead of GET for data changes
- Validation before database writes
.<br>

# 👨‍💻 Author

CodeWithAtwaa
GitHub: https://github.com/CodeWithAtwaa
.<br>
# 📜 License

Free to use for learning and educational purposes.
If you want, next I can also generate:

✅ GitHub badges

✅ screenshots layout

✅ contribution guide

✅ issue templates

✅ API-style README

✅ portfolio-ready version


# By: Mohamed Tamer
