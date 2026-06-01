<!-- 
this is tasks session one in php,
By Mohamed Tamer Atwaa,
Back end core team .
-->


<!-- تكليفات PHP Bootcamp من الدرس 1 الي 5 -->
<!-- Ass 1 -->
 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="<?php

use function PHPSTORM_META\type;

 echo "UTF-8" ;?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "My First PHP Page";?></title>
  </head>
  <body>
    <div><?php echo "We Love";?></div>
    <div><?php echo " Elzero Channel";?></div>
  </body>
</html>



<!-- Ass 2-->
 <?php 
 #echo 'Prevent Me From Running Please';
//echo 'Prevent Me From Running Please';
/*echo 'Prevent Me From Running Please'; */
 ?>


<!-- Ass 3 -->
 <?php
 echo "My Application";
 echo "Version 1.0";
 echo "Created By Elzero";
 ?>


<br>
<!-- Ass 4 -->
 <?php 
echo "كلهم ثح <br> ";
    // ## First Comment
# // # Second Comment
/* /* /* Third Comment */
////// Fourth Comment
 ?>


<!-- تكليفات PHP Bootcamp من الدرس 6 الي 12 -->

<!-- Ass 1 -->
<?php 
  echo (int)(15.2 + 14.7 + (10.5 + 10.5)); // 50
  echo "<br>";
echo gettype((int)(15.2 + 14.7 + (10.5 + 10.5))); // Integer  
?>


<!-- Ass 2 -->
 <?php 
    echo "<br>";
    echo gettype((int)(100));
    echo "<br>";
    echo var_dump((int)(100));
    echo "<br>";
    echo get_debug_type(100);
    echo "<br>";
 ?>


<!-- Ass 3 -->
 <?php 
    echo 'Hello "Elzero"  \\\\ """ We Love "$$PHP"';
    echo "<br>";
 ?>



<!-- Ass 4 -->
 <?php 
 echo "We <br> Love <br> Elzero <br> Web <br> School <br>";
 ?>


<!-- Ass 5 -->
 <?php
echo <<<'Here'
Hello "'Elzero'"
We Love $Programming$
Languages Specially "PHP"
Here;

 ?>
 <br>


 <!-- Ass 6 -->
  <?php 
    $something = "Programming";
echo <<<Here
Hello \PHP\
We Love $something
Here;
?>
<br>


<!-- Ass 7 -->
 <?php
echo (int)(bool)("Hello PHP");
echo '<br>';
echo gettype((int)(bool)("Hello PHP"));

 ?>


<!-- Ass 8 -->
 <?php 
 $arr = [
    "FrontEnd" => ["HTML" , "CSS" ,"JS"=>["VueJS" =>["v2" , "v3"] , "Reactjs" , "Svlte"]],
    "BackEnd" => ["PHP" , "Mysql" , "Security"],
    "Git",
    "GitHub",
    "Testing" =>["unit testing" , "End To End" , "Integration"]
 ];

 echo "<pre>";
 print_r($arr);
 echo"</pre>";
 ?>
 <br>


<!-- تكليفات PHP Bootcamp من الدرس 13 إلى 14 -->

<!-- Ass 1 -->
 <?php 
    $head = "Elzero Courses";
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Elzero Courses">
    <title>Welcome To Elzero Courses</title>
  </head>
  <body>
    <h1><?php echo $head?></h1>
    <p>Here In Elzero Courses We Provide Front-End And Back-End Courses</p>
    <hr>
    <div>Elzero Courses Is The What You Need.</div>
    <footer>All Right Reserved To Elzero Courses</footer>
  </body>
</html>




<!-- Ass 2 -->
 <?php 

$name = "elzero";
$$name = "Web";

echo $elzero;
echo "<br>";

echo $$name;
echo "<br>";

echo ${$name};
echo "<br>";

مش فاكر ال 2 الباقيين

?>


<!-- ASs 3 -->
<?php
// يا وجع البوينتر 
$a = 200;
$b = &$a;
$a = 100;

echo $b; // 100
?>
<br>

<!-- Ass 4 -->
 <?php
 echo $_SERVER['DOCUMENT_ROOT'] . "<br>";
 echo $_SERVER['SERVER_NAME'] . "<br>";
 ?>
