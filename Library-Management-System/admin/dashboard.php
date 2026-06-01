<?php
session_start();
if (isset($_SESSION['admin'])) {
    include("../DB/db.php");
    include("includes/navbar.php");
    include("includes/header.php");

    $users = $connect->prepare("SELECT * FROM users");
    $users->execute();
    $userCount = $users->rowCount();

    $books = $connect->prepare("SELECT * FROM books");
    $books->execute();
    $bookCount = $books->rowCount();

?>


    <div class="container mt-5 mb-5 pt-5 pb-5"></div>
    <div class="row m-auto justify-content-center align-items-center">
        <div class="col-md-4 ">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa-solid fa-users fa-2xl mt-2 "></i>
                    <h3 class="mt-2">USERS</h3>
                    <h5 class="mt-2"><?php echo $userCount ?></h5>
                    <a href="users.php" class="btn btn-success"><i class="fa-solid fa-eye"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 ">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa-solid fa-book-bookmark fa-2xl mt-2 "></i>
                    <h3 class="mt-2">BOOKS</h3>
                    <h5 class="mt-2"><?php echo $bookCount ?></h5>
                    <a href="books.php" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
                </div>
            </div>
        </div>
    </div>
    </div>


<?php
    include("includes/footer.php");
} else {
    $_SESSION['login_err'] = "Login first ya حرامي يابن الاحبه!";
    header("Location:../auth/login.php");
    exit();
}
?>