<?php
session_start();
if (isset($_SESSION['admin'])) {
    include("../DB/db.php");
    include("includes/navbar.php");
    include("includes/header.php");

    $page = "all";
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }

    // --------------SHOW ALL USERS ------------------
    if ($page == "all") {
        $users = $connect->prepare("SELECT * FROM users");
        $users->execute();
        $userCount = $users->rowCount();
        $result  = $users->fetchAll();
?>
        <div class="container mt-3 mb-5 pt-3 pb-5">
            <div class="row m-auto">
                <div class="col-md-10 m-auto">
                    <?php
                    if (isset($_SESSION['message'])) {
                    ?>
                        <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['message'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                        unset($_SESSION['message']);
                    }
                    ?>
                    <div class="d-flex justify-content-center align-items-center">
                        <div>
                            <h3 class="text-center"> Details of Users <span class="btn btn-primary text-center"><?php echo $userCount; ?></span></h3>
                        </div>
                        <div>
                            <a href="users.php?page=create" class="btn btn-success ms-1 mb-2 ">Create a New User</a>
                        </div>
                    </div>
                    <table class="table  table-bordered text-center table-sm mt-2 table-striped table-dark table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($result as $item) {
                            ?>
                                <tr>
                                    <td><?php echo $item['id']; ?></td>
                                    <td><?php echo $item['name']; ?></td>
                                    <td><?php echo $item['email']; ?></td>
                                    <td>
                                        <a href="users.php?page=show&id=<?php echo $item['id'] ?>" class="btn btn-success"><i class="fa-solid fa-eye"></i></a>
                                        <a href="users.php?page=edit&id=<?php echo $item['id'] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="users.php?page=delete&id=<?php echo $item['id'] ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
    }
    // --------------SHOW ONE USER ------------------
    else if ($page == "show") {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }

        $statement = $connect->prepare("SELECT * FROM users WHERE id=?");
        $statement->execute([$id]);
        $result = $statement->fetch();

    ?>
        <div class="container mt-3 mb-5 pt-3 pb-5">
            <div class="row m-auto">
                <div class="col-md-10 m-auto">
                    <h3 class="text-center"> Details of One User </h3>
                    <table class="table  table-bordered text-center table-sm mt-2 table-striped table-dark table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Role</th>
                                <th>Created_At</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $result['id']; ?></td>
                                <td><?php echo $result['name']; ?></td>
                                <td><?php echo $result['email']; ?></td>
                                <td><?php echo $result['password']; ?></td>
                                <td><?php echo $result['role']; ?></td>
                                <td><?php echo $result['created_at']; ?></td>
                                <td>
                                    <a href="users.php" class="btn btn-success"><i class="fa-solid fa-eye"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
    }
    // --------------DELETE ONE USER ------------------
    else if ($page == "delete") {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }

        $statementRole = $connect->prepare("SELECT role FROM users WHERE id = ?");
        $statementRole->execute([$id]);
        $resultRole = $statementRole->fetch();
        if ($resultRole && trim($resultRole['role']) === "user") {
            $statement1 = $connect->prepare("DELETE FROM users WHERE id=?");
            $statement1->execute([$id]);
            $_SESSION['message'] = "Deleted Successfully!";
            header("Location: users.php");
            exit();
        } else {
            $_SESSION['message'] = "You don't have permission to delete this user";
            header("Location: users.php");
        }
    }
    // --------------CREATE NEW USER ------------------
    else if ($page == "create") {
        $idErr = $emailErr = $nameErr = $passErr = "";
        $id = $name = $email = $password  = "";
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role  = $_POST['role'];

            if (empty($id)) {
                $idErr = "Enter ID";
            }
            if (empty($name)) {
                $nameErr = "Enter Name";
            }
            if (empty($password)) {
                $passErr = "Enter Password";
            }
            if (empty($email)) {
                $emailErr = "Enter email";
            }

            if (empty($idErr)  && empty($nameErr) && empty($emailErr) && empty($passErr)) {
                $_SESSION['id']  = $id;
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                $_SESSION['role'] = $role;
                header("Location:users.php?page=save");
                exit();
            }
        }
    ?>
        <div class="container mt-5 mb-3 pt-3 pb-3">
            <div class="row m-auto">
                <div class="col-md-10 m-auto">
                    <?php
                    if (isset($_SESSION['message_err'])) {
                    ?>
                        <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['message_err'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                        unset($_SESSION['message_err']);
                    }
                    ?>
                    <form action="users.php?page=create" method="POST">
                        <input type="text" placeholder="ID" name="id" class="form-control mb-5" value="<?php echo $id ?>">
                        <h5 class="text-center"><?php echo $idErr ?></h5>
                        <input type="name" placeholder="Name" name="name" class="form-control mb-5" value="<?php echo $name ?>">
                        <h5 class="text-center"><?php echo $nameErr ?></h5>
                        <input type="email" placeholder="Email" name="email" class="form-control mb-5" value="<?php echo $email ?>">
                        <h5 class="text-center"><?php echo $emailErr ?></h5>
                        <input type="password" placeholder="Password" name="password" class="form-control mb-5" value="<?php echo $password ?>">
                        <h5 class="text-center"><?php echo $passErr ?></h5>
                        <select name="role" class="form-control mb-5">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                        <input type="submit" value="Create a New User" class="btn btn-success form-control">
                    </form>
                </div>
            </div>
        </div>
    <?php
    }
    // --------------SAVE A NEW USER ------------------
    else if ($page == "save") {
        if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_SESSION['id'])) {
            $id =  $_SESSION['id'];
            $name = $_SESSION['name'];
            $email = $_SESSION['email'];
            $password = $_SESSION['password'];
            $role = $_SESSION['role'];
        }

        try {

            $statement1 = $connect->prepare(
                "INSERT INTO users (id, name, email, password, role, created_at)
                     VALUES (?, ?, ?, ?, ?, NOW())"
            );
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $statement1->execute([$id, $name, $email, $hashedPassword, $role]);
            $_SESSION['message'] = "Created Successfully!";
            unset($_SESSION['id'], $_SESSION['name'], $_SESSION['email'], $_SESSION['password'], $_SESSION['role']);
            header("Location: users.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['message_err'] = "Duplicate ID!";
            header("Location: users.php?page=create");
        }
    }
    // --------------EDIT  USER ------------------
    elseif ($page == "edit") {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        $statement = $connect->prepare("SELECT * FROM users WHERE id=?");
        $statement->execute([$id]);
        $result = $statement->fetch();
        $idErr = $emailErr = $nameErr = $passErr = "";
        $id = $name = $email = $password = $old_id = "";
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $id = $_POST['id'];
            $old_id = $_POST['old_id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            if (empty($id)) {
                $idErr = "Enter ID";
            }
            if (empty($name)) {
                $nameErr = "Enter Name";
            }
            if (empty($password)) {
                $passErr = "Enter Password";
            }
            if (empty($email)) {
                $emailErr = "Enter email";
            }
            if (empty($idErr) && empty($nameErr) && empty($emailErr) && empty($passErr)) {
                $_SESSION['id'] = $id;
                $_SESSION['old_id'] = $old_id;
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                $_SESSION['role'] = $role;
                header("Location: users.php?page=saveEdit");
                exit();
            }
        }
    ?>
        <div class="container mt-5 mb-3 pt-3 pb-3">
            <div class="row m-auto">
                <div class="col-md-10 m-auto">
                    <?php
                    if (isset($_SESSION['message_err'])) {
                    ?>
                        <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['message_err'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                        unset($_SESSION['message_err']);
                    }
                    ?>
                    <form action="" method="POST">
                        <input type="hidden" name="old_id" value="<?php echo $result['id'] ?>">
                        <input type="text" placeholder="ID" name="id" class="form-control mb-5" value="<?php echo $result['id'] ?>">
                        <h5 class="text-center"><?php echo $idErr ?></h5>
                        <input type="text" placeholder="Name" name="name" class="form-control mb-5" value="<?php echo $result['name'] ?>">
                        <h5 class="text-center"><?php echo $nameErr ?></h5>
                        <input type="email" placeholder="Email" name="email" class="form-control mb-5" value="<?php echo $result['email'] ?>">
                        <h5 class="text-center"><?php echo $emailErr ?></h5>
                        <input type="password" placeholder="Password" name="password" class="form-control mb-5" >
                        <h5 class="text-center"><?php echo $passErr ?></h5>
                        <select name="role" class="form-control mb-5">
                            <option value="user" <?php if ($result['role'] == "user") echo 'selected'; ?>>User</option>
                            <option value="admin" <?php if ($result['role'] == "admin") echo 'selected'; ?>>Admin</option>
                        </select>
                        <input type="submit" value="Edit" class="btn btn-success form-control">
                    </form>
                </div>
            </div>
        </div>
<?php
    }
    // --------------SAVE UPDATE USER ------------------
    else if ($page == "saveEdit") {
        if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
            $old_id = $_SESSION['old_id'];
            $name = $_SESSION['name'];
            $email = $_SESSION['email'];
            $password = $_SESSION['password'];
            $role = $_SESSION['role'];
            try {
                $statement1 = $connect->prepare(
                    "UPDATE users SET 
                     id = ?, 
                     name = ?, 
                     email = ?, 
                     password = ?, 
                     role = ? 
                     WHERE id = ?"
                );
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $statement1->execute([
                    $id,
                    $name,
                    $email,
                    $hashedPassword,
                    $role,
                    $old_id,
                ]);
                $_SESSION['message'] = "Updated Successfully!";
                header("Location: users.php");
                exit();
            } catch (PDOException $e) {
                $_SESSION['message_err'] = "Duplicate ID!";
                header("Location: users.php?page=edit&id=" . $old_id);
            }
        }
    }
    include("includes/footer.php");
} else {
    $_SESSION['login_err'] = "Login first ya حرامي يابن الاحبه!";
    header("Location:../auth/login.php");
}
?>