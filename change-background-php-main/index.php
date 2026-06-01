<?php
if (isset($_COOKIE['bg'])) {
    echo "<style>body {background-color: " . htmlspecialchars($_COOKIE['bg']) . ";} </style>";
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    setcookie("bg", $_POST['back'], strtotime("+1 year"), "/");
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit(); 
}
?>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="color" name="back">
    <input type="submit">
</form>


<?php
?>