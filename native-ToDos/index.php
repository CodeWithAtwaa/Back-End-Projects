<?php
// start seesion
session_start();

// connect With Database
include("./DB/db.php");
include("./temp/header.php");


$page = "all";
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

//----------------  to Show ALl Todos  ---------------------
if ($page === "all") {
    $statement = $connect->prepare("SELECT * FROM task");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
    <!-- start show All ToDos -->
    <div class="container mt-3 mb-3 pt-3 pb-3">
        <div class="row">
            <div class="col-md-10 col-sm-11 col-lg-12 m-auto">
                <div class="d-flex">
                    <div class="w-75">
                        <h1 class="m-auto text-center pending ssd">show all ToDos</h1>
                    </div>
                    <div class="w-25  d-flex justify-content-center align-items-center">
                        <a href="index.php?page=create" class="btn btn-success text-center">Create New</a>
                    </div>
                </div>

                <?php

                if (isset($_SESSION['msg'])) {
                ?>
                    <div class="alert alert-success alert-dismissible fade show mt-1 bt-1" role="alert">
                        <h3 class="text-center"><?php echo $_SESSION['msg'] ?></h3>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                    unset($_SESSION['msg']);
                }


                ?>
                <div class="table-responsive mt-1">
                    <table class="table table-striped table-hover table-active table-border table-dark text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Operations</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($result as $task) {
                            ?>
                                <tr>
                                    <td>
                                        <?= $task['id'] ?>
                                    </td>
                                    <td>
                                        <?= $task['name'] ?>
                                    </td>
                                    <td>
                                        <a href="index.php?page=show&id=<?= $task['id'] ?>" class="btn btn-primary">show</a>
                                        <a href="index.php?page=edit&id=<?= $task['id'] ?>" class="btn btn-warning">edit</a>
                                        <a href="index.php?page=delete&id=<?= $task['id'] ?>" class="btn btn-danger">delete</a>
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
    </div>
    <!-- end show All ToDos -->

<?php

}
//  --------------------- DELETE SPECIFIC TODOS ------------------------------------
else if ($page === "show") {
    if (isset($_GET['id'])) {
        $task_id = $_GET['id']; // 1
    }

    $statement = $connect->prepare("SELECT * FROM task WHERE id=?");
    $statement->execute([$task_id]);
    $task = $statement->fetch();
?>
    <!-- start show one ToDos -->
    <div class="container mt-3 mb-3 pt-3 pb-3">
        <div class="row">
            <div class="col-md-10 col-sm-12 col-lg-12 m-auto">
                <h1 class="m-auto text-center pending ssd">show specific ToDos</h1>
                <div class="table-responsive mt-1">
                    <table class="table table-striped table-hover table-active table-border table-dark text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Due Date</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            ?>
                            <tr>
                                <td><?= $task['id'] ?></td>
                                <td><?= $task['name'] ?></td>

                                <!-- check if the take is complete or not -->
                                <?php
                                $isComplete = (int) $task['is_complete'] === 1;
                                $status = $isComplete ? "Completed" : "Pending";
                                ?>

                                <td><?= $status ?></td>

                                <td>
                                    <span class="badge bg-<?= $isComplete ? 'success' : 'warning' ?>">
                                        <?= htmlspecialchars($task['due_date']) ?>
                                    </span>
                                </td>
                                <!-- end check -->
                                <td><?= $task['created_at'] ?></td>
                                <td><?= $task['updated_at'] ?></td>
                                <td>
                                    <a href="index.php" class="btn btn-success">Home</a>
                                </td>
                            </tr>
                            <?php
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- end show one ToDos -->

<?php
} else if ($page === "delete") {
    if (isset($_GET['id'])) {
        $task_id = $_GET['id']; // 1
    }
    $statement = $connect->prepare("DELETE FROM task WHERE id=?");
    $statement->execute([$task_id]);
    $_SESSION['msg'] = "Deleted Successfully!..";
    header("Location:index.php");
    exit();
}
//  --------------------- EDIT SPECIFIC TODOS ------------------------------------
else if ($page === "edit") {
    if (isset($_GET['id'])) {
        $task_id = $_GET['id'];
    }

    $statement = $connect->prepare("SELECT * FROM task WHERE id=?");
    $statement->execute([$task_id]);
    $result = $statement->fetch();


    $nameErr = $is_completeErr = $due_dateErr = "";
    $name = $is_complete = $due_date = "";


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name        = $_POST['name'] ?? '';
        $is_complete = $_POST['flexRadioDefault'] ?? '';
        $due_date    = $_POST['date'] ?? '';

        // validation
        if (empty($name)) {
            $nameErr = "Please Enter Task Name";
        }

        if ($is_complete === '') {
            $is_completeErr = "Please choose status";
        }

        if (empty($due_date)) {
            $due_dateErr = "Please Enter Task date";
        }



        // if valid → update directly
        if (!$nameErr && !$is_completeErr && !$due_dateErr) {

            $statement = $connect->prepare("
                UPDATE task
                SET name=?, is_complete=?, due_date=?, updated_at=NOW()
                WHERE id=?
            ");

            $statement->execute([
                $name,
                $is_complete,
                $due_date,
                $task_id
            ]);

            $_SESSION['msg'] = "Updated Successfully!";
            header("Location: index.php");
            exit();
        }
    }
?>
    <!-- ==============START EDIT FORM ================== -->
    <div class="container mt-3 mb-3 pt-3 pb-3">
        <div class="row">
            <div class="col-md-10 m-auto">
                <h1 class="text-center pending ssd">Edit specific ToDos</h1>

                <div class="form mt-5 shadow p-3 bg-body rounded">

                    <form method="post">

                        <!-- name -->
                        <input type="text"
                            name="name"
                            value="<?= htmlspecialchars($result['name']) ?>"
                            class="form-control mt-3">
                        <div class="text-danger"><?= $nameErr ?></div>

                        <!-- radio status -->
                        <div class="d-flex mt-3">

                            <div class="form-check">
                                <input class="form-check-input"
                                    type="radio"
                                    name="flexRadioDefault"
                                    value="1"
                                    <?= $result['is_complete'] ? 'checked' : '' ?>>
                                <label>complete</label>
                            </div>

                            <div class="form-check ms-3">
                                <input class="form-check-input"
                                    type="radio"
                                    name="flexRadioDefault"
                                    value="0"
                                    <?= !$result['is_complete'] ? 'checked' : '' ?>>
                                <label>pending</label>
                            </div>

                        </div>
                        <div class="text-danger"><?= $is_completeErr ?></div>

                        <!-- due date -->
                        <input type="datetime-local"
                            name="date"
                            value="<?= date('Y-m-d\TH:i', strtotime($result['due_date'])) ?>"
                            class="form-control mt-3">
                        <div class="text-danger"><?= $due_dateErr ?></div>

                        <!-- submit -->
                        <button class="btn pending mt-3 w-100">
                            Save Update
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- ================END EDIT FORM ================== -->
<?php
}
//  --------------------- CREATE NEW TODOS ------------------------------------
else if ($page === "create") {

    $nameErr = $is_completeErr = $due_dateErr = "";
    $name = $is_complete = $due_date = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $name        = $_POST['name'] ?? '';
        $is_complete = $_POST['flexRadioDefault'] ?? '';
        $due_date    = $_POST['date'] ?? '';

        // validation
        if (empty($name)) {
            $nameErr = "Please Enter Task Name";
        }

        if ($is_complete === '') {
            $is_completeErr = "Please choose status";
        }

        if (empty($due_date)) {
            $due_dateErr = "Please Enter Task date";
        }

        // if valid → insert
        if (!$nameErr && !$is_completeErr && !$due_dateErr) {

            $statement = $connect->prepare("
                INSERT INTO task (name, is_complete, due_date, created_at, updated_at)
                VALUES (?, ?, ?, NOW(), NOW())
            ");

            $statement->execute([
                $name,
                $is_complete,
                $due_date
            ]);

            $_SESSION['msg'] = "Task Created Successfully!";
            header("Location: index.php");
            exit();
        }
    }
?>
    <!-- ==============START CREATE FORM ================== -->
    <div class="container mt-3 mb-3 pt-3 pb-3">
        <div class="row">
            <div class="col-md-10 m-auto">
                <h1 class="text-center pending ssd">Create New ToDo</h1>

                <div class="form mt-5 shadow p-3 bg-body rounded">

                    <form method="post">

                        <!-- name -->
                        <input type="text"
                            name="name"
                            value="<?= htmlspecialchars($name) ?>"
                            class="form-control mt-3"
                            placeholder="Task Name">
                        <div class="text-danger"><?= $nameErr ?></div>

                        <!-- status -->
                        <div class="d-flex mt-3">

                            <div class="form-check">
                                <input class="form-check-input"
                                    type="radio"
                                    name="flexRadioDefault"
                                    value="1"
                                    <?= $is_complete === '1' ? 'checked' : '' ?>>
                                <label>complete</label>
                            </div>

                            <div class="form-check ms-3">
                                <input class="form-check-input"
                                    type="radio"
                                    name="flexRadioDefault"
                                    value="0"
                                    <?= $is_complete === '0' ? 'checked' : '' ?>>
                                <label>pending</label>
                            </div>

                        </div>
                        <div class="text-danger"><?= $is_completeErr ?></div>

                        <!-- due date -->
                        <input type="datetime-local"
                            name="date"
                            value="<?= htmlspecialchars($due_date) ?>"
                            class="form-control mt-3">
                        <div class="text-danger"><?= $due_dateErr ?></div>

                        <!-- submit -->
                        <button class="btn pending mt-3 w-100">
                            Create Task
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- ================END CREATE FORM ================== -->
<?php
}
include("./temp/footer.php");
?>