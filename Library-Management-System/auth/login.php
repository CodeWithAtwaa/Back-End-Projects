<?php
session_start();
include("../DB/db.php");
include("../includes/header.php");
$emailERR = $passErr = "";
$email = $password = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($email)) {
        $emailERR = "Enter Email";
    }
    if (empty($password)) {
        $passErr = "Enter password";
    }
    if (empty($emailERR) && empty($passErr)) {
        $statement = $connect->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
        $statement->execute([$email]);
        $result = $statement->fetch();
        if ($result) {
            if (password_verify($password, $result['password'])) {
                if ($result['role'] === 'admin') {
                    $_SESSION['admin'] = $email;
                    header("Location:../admin/dashboard.php");
                    exit();
                } else if ($result['role'] === 'user') {
                    header("Location:../index.php");
                    exit();
                }
            } else {
                $_SESSION['login_err'] = "Incorrect password";
                header("Location:login.php");
                exit();
            }
        } else {
            $_SESSION['login_err'] = "No user found with this email";
            header("Location:login.php");
            exit();
        }
    }
}
?>
<div class="container mt-5 pt-5 mb-5 pb-5">
    <div class="row m-auto">
        <div class="m-auto col-md-10">
            <h3 class="text-center mb-5">Login Page</h3>
            <?php
            if (isset($_SESSION['login_err'])) {
            ?>
                <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['login_err'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
                unset($_SESSION['login_err']);
            }
            ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="text" name="email" placeholder="Email" class="form-control mb-5" value="<?php echo htmlspecialchars($email); ?>">
                <h5 class="text-center text-danger"><?php echo htmlspecialchars($emailERR); ?></h5>
                <input type="password" name="password" placeholder="Password" class="form-control mb-5">
                <h5 class="text-center text-danger"><?php echo htmlspecialchars($passErr); ?></h5>
                <input type="submit" value="Login" class="form-control mb-5 btn btn-success">
            </form>
        </div>
    </div>
</div>
<?php
include("../includes/footer.php");
?>