<?php
session_start();
if (isset($_SESSION['admin'])) {
    include("../DB/db.php");
    include("includes/navbar.php");
    include("includes/header.php");
    $page  = "all";
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }
    // ---------- SHOW ALL  BOOKs --------------

    if ($page === "all") {
        $books = $connect->prepare("SELECT * FROM books");
        $books->execute();
        $bookCount = $books->rowCount();
        $result = $books->fetchAll();
?>
        <div class="container mt-3 mb-3 pt-3 pb-3">
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
                            <h3 class="text-center"> Details of Books <span class="btn btn-primary text-center"><?php echo $bookCount; ?></span></h3>
                        </div>
                        <div>
                            <a href="books.php?page=create" class="btn btn-success ms-1 mb-2">Create a New Books</a>
                        </div>
                    </div>
                    <table class="table  table-bordered text-center table-sm mt-2 table-striped table-dark table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Book</th>
                                <th>Download</th>
                                <th>Operations</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($result as $book) {
                            ?>
                                <tr>
                                    <td><?php echo $book['id'] ?></td>
                                    <td><?php echo $book['title'] ?></td>
                                    <td><?php echo $book['book'] ?></td>
                                    <td>
                                        <a href="uploads/<?php echo $book['book']; ?>" target="_blank" class="btn btn-success">Download</a>
                                    </td>
                                    <td>
                                        <a href="books.php?page=show&id=<?php echo $book['id'] ?>" class="btn btn-success"><i class="fa-solid fa-eye"></i></a>
                                        <a href="books.php?page=edit&id=<?php echo $book['id'] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="books.php?page=delete&id=<?php echo $book['id'] ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
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
    // ----------SHOW A SPECIFIC BOOK --------------
    else if ($page == "show") {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        $statement = $connect->prepare("SELECT * FROM books WHERE id=?");
        $statement->execute([$id]);
        $book = $statement->fetch();
    ?>
        <div class="container mt-3 mb-3 pt-3 pb-3">
            <div class="row m-auto">
                <div class="col-md-10 m-auto">
                    <h3 class="text-center"> Details of One Book </h3>
                    <table class="table  table-bordered text-center table-sm mt-2 table-striped table-dark table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Book</th>
                                <th>Download</th>
                                <th>Author</th>
                                <th>Year</th>
                                <th>Status</th>
                                <th>Created AT</th>
                                <th>Operations</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $book['id'] ?></td>
                                <td><?php echo $book['title'] ?></td>
                                <td><?php echo $book['book'] ?></td>
                                <td>
                                    <a href="uploads/<?php echo $book['book']; ?>" target="_blank" class="btn btn-success">Download</a>
                                </td>
                                <td><?php echo $book['author'] ?></td>
                                <td><?php echo $book['year'] ?></td>
                                <td><?php echo $book['status'] ?></td>
                                <td><?php echo $book['created_at'] ?></td>
                                <td>
                                    <a href="books.php" class="btn btn-success"><i class="fa-solid fa-eye"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
    }
    // ----------DELETE A SPECIFIC BOOK --------------
    else if ($page == "delete") {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        $statement = $connect->prepare("DELETE FROM books WHERE id=?");
        $statement->execute([$id]);
        $_SESSION['message'] = "Deleted Successfully!";
        header("Locaiton : books.php");
        exit();
    }
    // ---------- CREATE A NEW BOOK --------------
    else if ($page == "create") {
        $idErr = $titleErr = $authorErr = $yearErr = $bookErr = "";
        $id = $title = $author = $year = $book = "";
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $author = $_POST['author'];
            $year = $_POST['year'];
            $status = $_POST['status'];
            $book = $_POST['book'];
            if (empty($id)) {
                $idErr = "Enter ID";
            }
            if (empty($title)) {
                $titleErr = "Enter Title";
            }
            if (empty($author)) {
                $authorErr = "Enter Author";
            }
            if (empty($year)) {
                $yearErr = "Enter Year";
            }
            // Validate file  upload using $_FILES
            if (isset($_FILES['book']) && $_FILES['book']['error'] === 0) {
                $FileName = time() . "_" . basename($_FILES['book']['name']);
                $targetDir = "./uploads/";
                $targetFile = $targetDir . $FileName;
                if (move_uploaded_file($_FILES['book']['tmp_name'], $targetFile)) {
                    $book = $FileName; // Save only the filename in DB
                } else {
                    $bookErr = "Book upload failed";
                }
            } else {
                $bookErr = "Please select a book file";
            }
            if (empty($idErr) && empty($titleErr) && empty($authorErr) && empty($yearErr) && empty($bookErr)) {
                $_SESSION['id'] = $id;
                $_SESSION['title'] = $title;
                $_SESSION['author']  = $author;
                $_SESSION['year'] = $year;
                $_SESSION['status'] = $status;
                $_SESSION['book'] = $book;
                header("Location:books.php?page=save");
                exit();
            }
        }
    ?>
        <div class="container mt-3 mb-3 pt-3 pb-3">
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
                    <form action="books.php?page=create" method="POST" enctype="multipart/form-data">
                        <input type="text" placeholder="ID" name="id" class="form-control mb-5" value="<?php echo $id ?>">
                        <h5 class="text-center"><?php echo $idErr ?></h5>
                        <input type="title" placeholder="Title" name="title" class="form-control mb-5" value="<?php echo $title ?>">
                        <h5 class="text-center"><?php echo $titleErr ?></h5>
                        <input type="author" placeholder="Author" name="author" class="form-control mb-5" value="<?php echo $author ?>">
                        <h5 class="text-center"><?php echo $authorErr ?></h5>
                        <input type="year" placeholder="Year" name="year" class="form-control mb-5" value="<?php echo $year ?>">
                        <h5 class="text-center"><?php echo $yearErr ?></h5>
                        <select name="status" class="form-control mb-5">
                            <option value="avaliable">Available</option>
                            <option value="borrowed">Borrowed</option>
                        </select>
                        <input type="file" placeholder="Book" name="book" class="form-control mb-5" value="<?php echo $book ?>">
                        <h5 class="text-center"><?php echo $bookErr ?></h5>
                        <input type="submit" value="Create a New Book" class="btn btn-success form-control mb-5">
                    </form>
                </div>
            </div>
        <?php
    }
    // ---------- SAVE A NEW BOOK --------------
    else if ($page == "save") {
        if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_SESSION['id'])) {
            $id =  $_SESSION['id'];
            $title = $_SESSION['title'];
            $author = $_SESSION['author'];
            $year = $_SESSION['year'];
            $status = $_SESSION['status'];
            $book = $_SESSION['book'];
            try {
                $stmt = $connect->prepare("INSERT INTO books (id, title, author, year, status , created_at , book)
                                       VALUES (?, ?, ?, ?, ?, NOW() , ?)");
                $stmt->execute([$id, $title, $author, $year, $status,  $book]);
                // Clear session data used for creating a post.
                unset($_SESSION['id'], $_SESSION['title'], $_SESSION['author'], $_SESSION['year'], $_SESSION['status'],  $_SESSION['book']);
                $_SESSION['message'] = "Book created successfully!";
                header("Location: books.php");
                exit();
            } catch (PDOException $e) {
                $_SESSION['message_err'] = "Duplicate ID ";
                header("Location: books.php?page=create");
                exit();
            }
        }
    }
    // ---------- EDIT BOOK --------------
    else if ($page == "edit") {
        if (isset($_GET['id']))
            $id = $_GET['id'];

        $statement = $connect->prepare("SELECT * FROM books WHERE id=?");
        $statement->execute([$id]);
        $result = $statement->fetch();

        $idErr = $titleErr = $authorErr = $yearErr = $bookErr = "";
        $id = $title = $author = $year = $book = $old_id = "";

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $id = $_POST['id'];
            $old_id = $_POST['old_id'];
            $title = $_POST['title'];
            $author = $_POST['author'];
            $year = $_POST['year'];
            $status = $_POST['status'];
            $book = $_POST['book'];


            if (empty($id)) {
                $idErr = "Enter ID";
            }
            if (empty($title)) {
                $titleErr = "Enter Title";
            }
            if (empty($author)) {
                $authorErr = "Enter Author";
            }
            if (empty($year)) {
                $yearErr = "Enter Year";
            }
            // Validate file  upload using $_FILES
            if (isset($_FILES['book']) && $_FILES['book']['error'] === 0) {
                $FileName = time() . "_" . basename($_FILES['book']['name']);
                $targetDir = "./uploads/";
                $targetFile = $targetDir . $FileName;
                if (move_uploaded_file($_FILES['book']['tmp_name'], $targetFile)) {
                    $book = $FileName;
                }
            } else {
                $book = $result['book']; // keep old file if no new upload
            }

            if (empty($idErr) && empty($titleErr) && empty($authorErr) && empty($yearErr) && empty($bookErr)) {
                $_SESSION['id'] = $id;
                $_SESSION['old_id'] = $old_id;
                $_SESSION['title'] = $title;
                $_SESSION['author'] = $author;
                $_SESSION['year'] = $year;
                $_SESSION['status'] = $status;
                $_SESSION['book'] = $book;
                header("Location: books.php?page=saveUpdate");
                exit();
            }
        }
        ?>
            <div class="container mt-3 mb-3 pt-3 pb-3">
                <div class="row m-auto">
                    <div class="col-md-10 m-auto">
                        <?php if (isset($_SESSION['message_err'])) { ?>
                            <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                                <?php echo $_SESSION['message_err'] ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php unset($_SESSION['message_err']);
                        } ?>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="old_id" value="<?php echo $result['id'] ?>">
                            <input type="text" placeholder="ID" name="id" class="form-control mb-5" value="<?php echo $result['id'] ?>">
                            <h5 class="text-center"><?php echo $idErr ?></h5>
                            <input type="text" placeholder="Title" name="title" class="form-control mb-5" value="<?php echo $result['title'] ?>">
                            <h5 class="text-center"><?php echo $titleErr ?></h5>
                            <input type="text" placeholder="Author" name="author" class="form-control mb-5" value="<?php echo $result['author'] ?>">
                            <h5 class="text-center"><?php echo $authorErr ?></h5>
                            <input type="text" placeholder="Year" name="year" class="form-control mb-5" value="<?php echo $result['year'] ?>">
                            <h5 class="text-center"><?php echo $yearErr ?></h5>
                            <select name="status" class="form-control mb-5">
                                <option value="available" <?php if ($result['status'] == "available") echo 'selected'; ?>>Available</option>
                                <option value="borrowed" <?php if ($result['status'] == "borrowed") echo 'selected'; ?>>Borrowed</option>
                            </select>
                            <input type="file" name="book" class="form-control mb-5" value="<?php echo $result['book'] ?>">
                            <h5 class="text-center"><?php echo $bookErr ?></h5>
                            <input type="submit" value="Update" class="btn btn-success form-control mb-5">
                        </form>
                    </div>
                </div>
            </div>
    <?php

    }
    // ---------- UPDATE BOOK --------------
    else if ($page == "saveUpdate") {
        if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
            $old_id = $_SESSION['old_id'];
            $title = $_SESSION['title'];
            $author = $_SESSION['author'];
            $year = $_SESSION['year'];
            $status = $_SESSION['status'];
            $book = $_SESSION['book'];
            try {
                $statement1 = $connect->prepare(
                    "UPDATE books SET 
                 id = ?, 
                 title = ?, 
                 author = ?, 
                 year = ?, 
                 status = ?, 
                 book = ? 
                 WHERE id = ?"
                );
                $statement1->execute([
                    $id,
                    $title,
                    $author,
                    $year,
                    $status,
                    $book,
                    $old_id,
                ]);
                $_SESSION['message'] = "Updated Successfully!";
                header("Location: books.php");
                exit();
            } catch (PDOException $e) {
                $_SESSION['message_err'] = "Duplicate ID!";
                header("Location: books.php?page=edit&id=" . $old_id);
            }
        }
    }
    include("includes/footer.php");
} else {
    $_SESSION['login_err'] = "Login first ya حرامي يابن الاحبه!";
    header("Location:../auth/login.php");
}
    ?>