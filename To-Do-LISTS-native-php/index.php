<?php
session_start();
include("Database/db.php");
include("includes/header.php");

$state = $connect->prepare("SELECT * FROM task");
$state->execute();
$rowCount = $state->rowCount();
$resuolt = $state->fetchAll();

$page = "All";
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
//-------------------------Show ALL TASK ------------------------------------
if ($page == "All") {
?>
    <div class="container mt-2 mb-5 pt-5 pb-5 ">
        <div class="row m-auto">
            <?php
            if (isset($_SESSION['message'])) {
            ?>
                <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php
                unset($_SESSION['message']);
            }
            ?>
            <h3 class="text-center">To Do List <span class="btn btn-primary"><?php echo  $rowCount; ?></span> <a href="index.php?page=create" class="btn btn-success">Create A New Task</a></h3>
            <table class="table table-dark table-active table-striped table-responsive text-center table-sm table-bordered">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Operations</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($resuolt as $row) {
                    ?>
                        <tr>
                            <td><?php echo $row['task_id'] ?></td>
                            <td><?php echo $row['task_name'] ?></td>
                            <td>
                                <a href="index.php?page=show&task_id=<?php echo $row['task_id'] ?>" class="btn btn-success"><i class="fa-solid fa-eye"></i></a>
                                <a href="index.php?page=edit&task_id=<?php echo $row['task_id'] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="index.php?page=delete&task_id=<?php echo $row['task_id'] ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
}
//-------------------------Show one TASK ------------------------------------
else if ($page === "show") {
    if (isset($_GET['task_id'])) {
        $task_id = $_GET['task_id'];
    }
    $state = $connect->prepare("SELECT * FROM task WHERE task_id=?");
    $state->execute([$task_id]);
    $result = $state->fetch();
?>
    <div class="container mt-5 mb-5 pt-5 pb-5 ">
        <div class="row m-auto">
            <h3 class="text-center text-capitalize">Details of one task</h3>
            <table class="table table-dark table-active table-striped table-responsive text-center table-sm table-bordered">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Status</td>
                        <td>Created At</td>
                        <td>Updated At</td>
                        <td>Operations</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $result['task_id'] ?></td>
                        <td><?php echo $result['task_name'] ?></td>
                        <td><?php echo $result['status'] ?></td>
                        <td><?php echo $result['created_at'] ?></td>
                        <td><?php echo $result['updated_at'] ?></td>
                        <td>
                            <a href="index.php" class="btn btn-success"><i class="fa-solid fa-eye"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php
}
//-------------------------DELTE ONE TASK ------------------------------------
else if ($page === "delete") {
    if (isset($_GET['task_id'])) {
        $task_id = $_GET['task_id'];
    }
    $state = $connect->prepare("DELETE FROM task WHERE task_id=?");
    $state->execute([$task_id]);
    $_SESSION['message'] = "Deleted Successfully!";
    header("location:index.php");
}
//-------------------------CREATE A NEW TASK --------------------------------
else if ($page === "create") {
    $idErr = $nameERr = "";
    $id = $name = "";
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $id = $_POST['task_id'];
        $name = $_POST['task_name'];
        $status = $_POST['status'];
        if (empty($id)) {
            $idErr = "Enter a ID";
        }
        if (empty($name)) {
            $nameERr = "Enter a Name";
        }
        if (empty($idErr) && empty($nameERr)) {
            $_SESSION['task_id']   = $id;
            $_SESSION['task_name'] = $name;
            $_SESSION['status']    = $status;
            header("Location:index.php?page=save");
            exit();
        }
    }
?>
    <div class="container mt-5 mb-5 pt-5 pb-5">
        <div class="row m-auto">
            <div class="col-md-10 m-auto">
                <?php
                if (isset($_SESSION['message_err'])) {
                ?>
                    <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['message_err'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php
                    unset($_SESSION['message_err']);
                }
                ?>
                <form action="index.php?page=create" method="POST">
                    <input type="text" placeholder="Task ID " class="form-control mb-5" name="task_id">
                    <h5 class="text-center text-danger"><?php echo $idErr ?></h5>
                    <input type="text" placeholder="Task Name " class="form-control mb-5" name="task_name">
                    <h5 class="text-center text-danger"><?php echo $nameERr ?></h5>
                    <select name="status" class="form-control mb-5">
                        <option value="0">Not Complete</option>
                        <option value="1">Complete</option>
                    </select>
                    <input type="submit" value="Create A New Task" class="form-control mb-5 btn btn-success">
                </form>
            </div>
        </div>
    </div>
<?php
}
//-------------------------SAVE A NEW TASK --------------------------------
else if ($page === "save") {
    if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_SESSION['task_id'])) {
        $id = $_SESSION['task_id'];
        $name = $_SESSION['task_name'];
        $status =  $_SESSION['status'];
        try {
            $state = $connect->prepare("INSERT INTO task (task_id, task_name,status,created_at)
            VALUES
            (?,?,?,NOW())
            ");
            $state->execute([$id, $name, $status]);
            $_SESSION['message'] = "Created Successfully!";
            unset($_SESSION['task_id'], $_SESSION['task_name'], $_SESSION['status']);
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['message_err'] = "Duplicate ID!";
            header("Location: index.php?page=create");
        }
    }
}
//------------------------ EDIT A SPACIFIC TASK --------------------------------
else if ($page === "edit") {
    if (isset($_GET['task_id'])) {
        $task_id = $_GET['task_id'];
    }
    $state = $connect->prepare("SELECT * FROM task WHERE task_id = ?");
    $state->execute([$task_id]);
    $result = $state->fetch();
    $idErr = $nameERr = "";
    $old_id = "";
    $id = $name = "";
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $id = $_POST['task_id'];
        $old_id = $_POST['old_id'];
        $name = $_POST['task_name'];
        $status = $_POST['status'];
        if (empty($id)) {
            $idErr = "Enter a ID";
        }
        if (empty($name)) {
            $nameERr = "Enter a Name";
        }
        if (empty($idErr) && empty($nameERr)) {
            $_SESSION['old_id']    = $old_id;
            $_SESSION['task_id']   = $id;
            $_SESSION['task_name'] = $name;
            $_SESSION['status']    = $status;
            header("Location:index.php?page=saveEDit");
            exit();
        }
    }
?>
    <div class="container mt-5 mb-5 pt-5 pb-5">
        <div class="row m-auto">
            <div class="col-md-10 m-auto">
                <?php
                if (isset($_SESSION['message_err'])) {
                ?>
                    <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['message_err'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php
                    unset($_SESSION['message_err']);
                }
                ?>
                <form action="" method="POST">
                    <input type="hidden" placeholder="old_id" class="form-control mb-5" name="old_id" value="<?php echo $result['task_id']  ?>">
                    <input type="text" placeholder="Task ID " class="form-control mb-5" name="task_id" value="<?php echo $result['task_id']  ?>">
                    <h5 class="text-center text-danger"><?php echo $idErr ?></h5>
                    <input type="text" placeholder="Task Name " class="form-control mb-5" name="task_name" value="<?php echo $result['task_name']  ?>">
                    <h5 class="text-center text-danger"><?php echo $nameERr ?></h5>
                    <select name="status" class="form-control mb-5">
                        <option value="0" <?php if ($result['status'] == "0") echo 'selected'; ?>>Not Complete</option>
                        <option value="1" <?php if ($result['status'] == "1") echo 'selected'; ?>> Complete</option>
                    </select>
                    <input type="submit" value="Edit a  Task" class="form-control mb-5 btn btn-success">
                </form>
            </div>
        </div>
    </div>
<?php
}
//------------------------ UPDATE A SPACIFIC TASK --------------------------------
else if ($page === "saveEDit") {
    if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_SESSION['task_id'])) {
        $id = $_SESSION['task_id'];
        $old_id = $_SESSION['old_id'];
        $name = $_SESSION['task_name'];
        $status =  $_SESSION['status'];
        try {
            $state = $connect->prepare("UPDATE task set
            task_id=?, task_name=?, status=? , updated_at = NOW()  WHERE task_id=?
            ");
            $state->execute([$id, $name, $status, $old_id]);
            $_SESSION['message'] = "Created Successfully!";
            unset($_SESSION['old_id'], $_SESSION['task_id'], $_SESSION['task_name'], $_SESSION['status']);
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['message_err'] = "Duplicate ID!";
            header("Location: index.php?page=create");
        }
    }
}
?>
<?php
include("includes/footer.php");
?>