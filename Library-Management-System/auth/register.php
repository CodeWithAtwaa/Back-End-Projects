<?php
session_start();
include("../DB/db.php");
include("../includes/header.php");
$emailERR = $passErr = $nameErr = "";
$email = $password = $name = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($name)) {
        $nameErr = "Enter Name";
    }
    if (empty($email)) {
        $emailERR = "Enter Email";
    }
    if (empty($password)) {
        $passErr = "Enter password";
    }
    if (empty($emailERR) && empty($passErr) && empty($nameErr)) {
        try {
            // Check if the email is already registered
            $statement = $connect->prepare("SELECT * FROM users WHERE email = ?");
            $statement->execute([$email]);
            $res = $statement->fetch();
            if ($res && strtolower($res['email']) === strtolower($email)) {
                $_SESSION['login_err'] = "This email is already registered.";
                header("Location: register.php");
                exit();
            } else {
                // Insert the new user into the database
                $statement1 = $connect->prepare("INSERT INTO users (`name`, email, password, `role`, created_at) VALUES (?, ?, ?, 'user', NOW())");
                // Hash the password before storing it
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $statement1->execute([$name, $email, $hashedPassword]);
                header("Location: login.php");
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['login_err'] = "A database error occurred. Please try again later.";
            header("Location: register.php");
            exit();
        }
    }
}
?>
<div class="container mt-5 pt-5 mb-5 pb-5">
    <div class="row m-auto">
        <div class="m-auto col-md-10">
            <h3 class="text-center mb-5">Register Page</h3> 
            <?php
            if (isset($_SESSION['login_err'])) {
            ?>
                <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_SESSION['login_err']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
                unset($_SESSION['login_err']);
            }
            ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Name" class="form-control mb-5" value="<?php echo htmlspecialchars($name); ?>">
                <h5 class="text-center text-danger"><?php echo htmlspecialchars($nameErr); ?></h5>
                <input type="text" name="email" placeholder="Email" class="form-control mb-5" value="<?php echo htmlspecialchars($email); ?>">
                <h5 class="text-center text-danger"><?php echo htmlspecialchars($emailERR); ?></h5>
                <input type="password" name="password" placeholder="Password" class="form-control mb-5">
                <h5 class="text-center text-danger"><?php echo htmlspecialchars($passErr); ?></h5>
                <input type="submit" value="Register" class="form-control mb-5 btn btn-success"> <!-- Changed to Register -->
            </form>
        </div>
    </div>
</div>
<?php
include("../includes/footer.php");
?>